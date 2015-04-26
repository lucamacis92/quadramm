<?php

include_once 'BaseController.php';

include_once 'mvc/model/Paint.php';
include_once 'mvc/model/PaintFactory.php';



/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa ai
 * Docenti da parte di utenti con ruolo Docente o Amministratore
 *
 * @author Davide Spano
 */
class SellerController extends BaseController {

	public function __construct() {
		parent::__construct();
	}


	/**
	 * Metodo per gestire l'input dell'utente.
	 * @param type $request la richiesta da gestire
	 * @param type $session array con le variabili di sessione
	 */
	public function handleInput(&$request, &$session) {

		if(Settings::debug)
		{
			echo $session['user']->getCap();
			$now = new DateTime();
			echo "data di adesso: ".$now->format( 'd-m-Y' );
		}
			
		
		// creo il descrittore della vista
		$vd = new ViewDescriptor();
		
		$this->setImpToken($vd, $request);

		// imposto la pagina
		$vd->setPagina($request['page']);

		// imposto la base dell'url da usare nel menu condiviso
		$vd->setUrlBase('seller');

		$vd->setWorkQty($session["carrello"]->getQty());

		// verifico se la connesisone al db è ok
		$db = DB::istance();

		if($db == false)
		{
			$vd->setErrorMessage("Ci scusiamo ma si è verificato un problema, gentilmente segnalarlo all'amministratore del sito. Grazie");
			$this->showLoginPage($vd);
		}
		else
		{
			if (!$this->loggedIn()) {
				// utente non autenticato, rimando alla home
				$this->showLoginPage($vd);
			} else {
				// utente autenticato
				$user = $session[BaseController::user];
				
				if (isset($request[BaseController::impersonato]))
					$userImp = $user;
				
				if (isset($request["cmd"])) {
					switch ($request["cmd"]) {
							
						case 'filtra':
						
							$vd->setContentTitle('Risultati della ricerca');
							$vd->setListWork(PaintFactory::loadWorkFromFilter($request));
						
							break;
													
						case 'aggiungiQuadro':

							$this->addToCart($vd, $request, $session);
							$this->showHomeUtente($vd);
							break;
							
						case 'rimuoviQuadro': 
							
							$this->removeFromCart($vd, $request, $session);
							$vd->setSottoPagina('Carrello');
							
							break;

						case 'checkout':

							$session['carrello']->checkout();
							$vd->setWorkQty($cart->getQty());
							$this->showHomeUtente($vd);
							break;
							
						case 'nuovoQuadro':

							$new_paint = PaintFactory::makePaintFromRequest($request, $vd);

							if($new_paint && PaintFactory::storePaint($new_paint, $vd))
								$vd->setInfoMessage('Quadro inserito, per aggiungerlo ai quadri del tuo negozio vai alla voce Vendi Quadro.');
							else
								$recoveredPaint = PaintFactory::recoverPaintFromRequest($request);

							$this->showHomeUtente($vd);

							break;

						case 'editQuadro':

							$paint = PaintFactory::makePaintFromRequest($request, $vd);

							if($paint && PaintFactory::updatePaint($paint, $vd))
							{
								$vd->setInfoMessage('Quadro aggiornato.');
								$vd->setSottoPagina('DettagliQuadro');
								$vd->setWork(PaintFactory::loadWorkFromId($request['id']));
							}
							else
							{
								$recoveredPaint = PaintFactory::recoverPaintFromRequest($request);
							}

							$this->showHomeUtente($vd);

							break;

						case 'modificaDettagliVendita':

							$paint = PaintFactory::makeWorkStoreFromRequest($request, $vd);

							if($paint && NegozioFactory::setWorkStoreParam($user->getNegozio()->getId(), $paint))
							{
								$vd->setInfoMessage('Valori di vendita aggiornati.');
								$vd->setSottoPagina('Home');
								$vd->setListWork(PaintFactory::loadWorkFromNegozio($user->getNegozio()->getId()));
								$vd->setContentTitle('I miei quadri');
								$vd->setSeller(true);
							}
							else
							{
								$vd->setWork(PaintFactory::loadWorkStoreFromId($request['id'], $user->getNegozio()->getId()));
								$vd->setErrorMessage('Il prezzo o la quantita inseriti non sono valori accettati.');
								$vd->setSottoPagina('ModificaDettagliVendita');
							}
								
							$this->showHomeUtente($vd);
							break;
							
						case 'modificaNegozio':
							
							$new_negozio = NegozioFactory::makeNegozioFromRequest($request, $vd);
							
							if($new_negozio && NegozioFactory::updateNegozio($new_negozio))
							{
								$session[self::user] = UserFactory::loadUserFromId($session[self::user]->getId());
								
								if($session[self::user])
								{
									$vd->setInfoMessage('I dati del negozio sono stati modificati.');
									$vd->setSottoPagina('Profilo');
								}
								else 
									$vd->setErrorMessage('Non &egrave; stato possibile aggiornare il profilo, se il problema persiste contattare un amministratore.');
							}
							else
								$recoveredNegozio = Negoziofactory::recoverNegozioFromRequest($request);
								
							$this->showHomeBuyer($vd);
							
							break;
							
						case 'modificaProfilo':
								
							$new_user = UserFactory::makeUserFromRequest($request, $vd);
								
							if($new_user && UserFactory::updateUser($new_user))
							{
								$session[self::user] = UserFactory::loadUserFromId($new_user->getId());
						
								if($session[self::user])
								{
									$user = $session[self::user];
									$vd->setInfoMessage('Il tuo profilo &egrave; stato modificato.');
									$vd->setSottoPagina('Home');
								}
								else
									$vd->setErrorMessage('Non &egrave; stato possibile aggiornare il profilo, se il problema persiste contattare un amministratore.');
							}
							else
								$recoveredUser = UserFactory::recoverUserFromRequest($request);
								
							$this->showLoginPage($vd);
						
								
							break;
								
						case 'aggiungiCredito':
								
							if($this->verificaCarta($request['numero_carta'], $request['data'], $request['codice']))
							{
								if(UserFactory::addCreditFromUser($user->getId(), $request['cash'], $vd))
								{
									$vd->setInfoMessage('Ricarica avvenuta con successo.');
									$session[self::user] = UserFactory::loadUserFromId($user->getId());
									$user = $session[self::user];
								}
							}
							else
							{
								$vd->setErrorMessage('Carta non valia, ricontrolla i dati e riprova.');
							}
								
							break;
														
						case 'eliminaVendita':
							
							if(PaintFactory::deleteWorkStoreFromId($request['id'], $user->getNegozio()->getId()))
								$vd->setInfoMessage('Quadro rimosso dal negozio.');
							else 
								$vd->setErrorMessage('Impossibile rimuovere il quadro dal negozio, contattare un amministratore.');
							
							break;
							
						case 'cambiaStatoSpedizione':
							
							OrdineFactory::changeShipmentStatus($request['id'], $request['id_quadro'], $user->getNegozio()->getId());
							
							break;
							
							// default
						default:
							$this->showHomeUtente($vd);
							break;
					}
				} else {
					// nessun comando, dobbiamo semplicemente visualizzare
					// la vista
					$user = $session[BaseController::user];
					$this->showHomeUtente($vd);
				}
			}
		}
		
		// verifico quale sia la sottopagina della categoria
		// Docente da servire ed imposto il descrittore
		// della vista per caricare i "pezzi" delle pagine corretti
		// tutte le variabili che vengono create senza essere utilizzate
		// direttamente in questo switch, sono quelle che vengono poi lette
		// dalla vista, ed utilizzano le classi del modello
		if (isset($request["subpage"])) {
		
			$res = $this->setViewDescriptorFromSubpage($request, $vd, $user);
		
			if(!$res)
			{
				switch ($request["subpage"]) {
		
					case 'EditQuadro':
		
						$vd->setSottoPagina('EditQuadro');
						$vd->setContentTitle('Modifica del quadro');
						$recoveredPaint = PaintFactory::loadWorkFromId($request['id']);
		
						break;
		
					case 'NuovoQuadro':
		
						$vd->setSottoPagina('NuovoQuadro');
						$vd->setContentTitle('Nuovo Quadro');
		
						break;
		
					case 'VendiQuadro':
		
						$vd->setSottoPagina('VendiQuadro');
						$vd->setListWork(PaintFactory::loadWorkToSell($user->getNegozio()->getId()));
		
						break;
		
					case 'Carrello':
		
						$carrello = $session['carrello'];
						$vd->setSottoPagina('Carrello');
		
						break;
		
					case 'ModificaDettagliVendita':
		
						$vd->setWork(PaintFactory::loadWorkStoreFromId($request['id'], $user->getNegozio()->getId()));
						$vd->setSottoPagina('ModificaDettagliVendita');
		
						break;
		
					case 'Profilo':
							
						$vd->setSottoPagina('Profilo');
						if(!isset($recoveredUser))$recoveredUser = $session['user'];
						if(!isset($recoveredNegozio))$recoveredNegozio = $session['user']->getNegozio();
							
						break;
						
					case 'StoricoOrdini':
					
						$orderList = OrdineFactory::loadOrderFromUserId($user->getId());
						$vd->setSottoPagina('StoricoOrdini');
						$vd->setContentTitle('Storico Ordini');
					
						break;
						
					case 'OrdiniRicevuti':
						
						$orderList = OrdineFactory::loadOrderFromIdNegozio($user->getNegozio()->getId());
						$vd->setSottoPagina('StoricoOrdini');
						$vd->setContentTitle('Ordini Ricevuti');
						$vd->setSeller(true);
						
						break;
						
					case 'DettagliOrdine':
					
						$ordine = OrdineFactory::loadOrderWorkFromIdAndIdNegozio($request['id'], $user->getNegozio()->getId());
						$vd->setSottoPagina('DettagliOrdine');
					
						break;
						
					case 'DettagliGestioneOrdine':
							
						$ordine = OrdineFactory::loadOrderWorkFromIdAndIdNegozio($request['id'], $user->getNegozio()->getId());
						$vd->setSottoPagina('DettagliOrdine');
						$vd->setSeller(true);
							
						break;
														
					default:
		
						if($vd->getSottoPagina() == "" || $vd->getSottoPagina() == 'Home')
						{
							$vd->setSottoPagina('Home');
							$vd->setListWork(PaintFactory::loadWorkFromNegozio($user->getNegozio()->getId()));
							$vd->setContentTitle('I miei quadri');
							$vd->setSeller(true);
						}
				}
			}
			$this->showHomeUtente($vd);
		}

		// richiamo la vista
		require 'mvc/view/master.php';

		// chiudo la connessione al db
		DB::chiudiDB();
	}

	/**
	 * Restituisce l'array contentente la sessione per l'utente corrente
	 * (vero o impersonato)
	 * @return array
	 */
	public function &getSessione(&$request) {
		$null = null;
		if (!isset($_SESSION) || !array_key_exists(BaseController::user, $_SESSION)) {
			// la sessione deve essere inizializzata
			return $null;
		}

		// verifico chi sia l'utente correntemente autenticato
		$user = $_SESSION[BaseController::user];

		// controllo degli accessi
		switch ($user->getRuolo()) {

			// l'utente e' un docente, consentiamo l'accesso
			case User::Seller:
				return $_SESSION;

				// l'utente e' un amministratore
			case User::Administrator:
				
				if (isset($request[BaseController::impersonato])) 
				{
					// ha richiesto di impersonare un utente
					$index = $request[parent::impersonato];
					if (array_key_exists($index, $_SESSION) && 
						$_SESSION[$index][BaseController::user]->getRuolo() == User::Seller) 
					{
						// consentiamo l'accesso
						return $_SESSION[$index];
					} 
					else 
					{
						return $null;
					}
				}
				return $null;

			default:
				return $null;
		}
	}
}

?>
