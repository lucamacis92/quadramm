<?php

include_once 'BaseController.php';

include_once 'mvc/model/Paint.php';
include_once 'mvc/model/PaintFactory.php';

include_once 'mvc/model/Negozio.php';
include_once 'mvc/model/NegozioFactory.php';

include_once 'mvc/model/Ordine.php';
include_once 'mvc/model/OrdineFactory.php';


/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa agli
 * Studenti da parte di utenti con ruolo Studente o Amministratore
 *
 * @author Davide Spano
 */
class BuyerController extends BaseController {

	/**
	 * Costruttore
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Metodo per gestire l'input dell'utente.
	 * @param type $request la richiesta da gestire
	 * @param type $session array con le variabili di sessione
	 */
	public function handleInput(&$request, &$session) {

		// creo il descrittore della vista
		$vd = new ViewDescriptor();
		
		$this->setImpToken($vd, $request);

		// imposto la pagina
		$vd->setPagina($request['page']);

		// imposto la base dell'url da usare nel menu condiviso
		$vd->setUrlBase('buyer');

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
				
			// gestion dei comandi
			// tutte le variabili che vengono create senza essere utilizzate
			// direttamente in questo switch, sono quelle che vengono poi lette
			// dalla vista, ed utilizzano le classi del modello

			if (!$this->loggedIn()) {
				// utente non autenticato, rimando alla home
				$this->showLoginPage($vd);
			} else {
				// utente autenticato

				$user = $session[BaseController::user];
				
				if (isset($request[BaseController::impersonato]))
					$userImp = $user;
				
				// gestione dei comandi inviati dall'utente
				if (isset($request["cmd"])) {
					// abbiamo ricevuto un comando
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

							if($session['carrello']->checkout($user->getId()))
							{
								$vd->setWorkQty($session['carrello']->getQty());
								$session[self::user] = UserFactory::loadUserFromId($user->getId());
								$user = $session[self::user];
								$vd->setInfoMessage('Acquisto avvenuto con successo.');
							}
							else 
							{
								$vd->setErrorMessage('Impossibile portare a termine la transazione.');
							}
							
							
							break;

						case 'apriNegozio':

							$new_negozio = NegozioFactory::makeNegozioFromRequest($request, $vd);

							if($new_negozio && NegozioFactory::storeNegozio($new_negozio, $user, $vd))
							{
								if(UserFactory::changeRuolo($user, User::Seller))
								{
									$vd->setInfoMessage('Negozio aperto, per gestire il negozio rieffettua il login.');
									$vd->setSottoPagina('Categorie');
								}
								else 
									$vd->setErrorPage('Si è verificato un problema durante il cambio di ruolo dell\'utente, segnalare il problema ad un amministratore.');
							}
							else
								$recoveredNegozio = Negoziofactory::recoverNegozioFromRequest($request);
							
							$this->showHomeUtente($vd);
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
							
						default : 
							$this->showHomeUtente($vd);
							break;
					}
				} else {
					// nessun comando
					$this->showHomeUtente($vd);
				}
					
				if (isset($request["subpage"])) {
						
					$res = $this->setViewDescriptorFromSubpage($request, $vd, $user);
						
					if(!$res)
					{
						switch ($request['subpage']) {
							case 'ApriNegozio':

								$vd->setSottoPagina('ApriNegozio');
								break;
									
							case 'Carrello':
									
								$carrello = $session['carrello'];
								$vd->setSottoPagina('Carrello');
									
								break;
								
							case 'Profilo':
								
								$vd->setSottoPagina('Profilo');
								$recoveredUser = $session['user'];
								
								break;
								
							case 'StoricoOrdini':
								
								$orderList = OrdineFactory::loadOrderFromUserId($user->getId());
								$vd->setSottoPagina('StoricoOrdini');
								$vd->setContentTitle('Storico Ordini');
								
								break;
								
							case 'DettagliOrdine':
								
								$ordine = OrdineFactory::loadOrderFromId($request['id']);
								$vd->setSottoPagina('DettagliOrdine');
								
								break;
									
							default:
						}
					}
					$this->showHomeUtente($vd);
				}
			}
		}

		// includo la vista
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
			case User::Buyer:
				return $_SESSION;

				// l'utente e' un amministratore
			case User::Administrator:
				
				if (isset($request[BaseController::impersonato])) 
				{
					// ha richiesto di impersonare un utente
					$index = $request[parent::impersonato];
					if (array_key_exists($index, $_SESSION) && 
						$_SESSION[$index][BaseController::user]->getRuolo() == User::Buyer) 
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
