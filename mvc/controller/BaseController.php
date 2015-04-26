<?php

include_once 'mvc/view/ViewDescriptor.php';
include_once 'mvc/model/User.php';
include_once 'mvc/model/UserFactory.php';

include_once 'mvc/model/Paint.php';
include_once 'mvc/model/PaintFactory.php';

/**
 * Controller che gestisce gli utenti non autenticati,
 * fornendo le funzionalita' comuni anche agli altri controller
 *
 * @author Davide Spano
 */
class BaseController {

	const user = 'user';
	const impersonato = '_imp';

	/**
	 * Costruttore
	 */
	public function __construct() {

	}

	/**
	 * Metodo per gestire l'input dell'utente. Le sottoclassi lo sovrascrivono
	 * @param type $request la richiesta da gestire
	 * @param type $session array con le variabili di sessione
	 */
	public function handleInput(&$request, &$session) {

		if(!isset($_SESSION['carrello'])) $_SESSION['carrello'] = new Carrello();
		
		// creo il descrittore della vista
		$vd = new ViewDescriptor();

		// imposto la pagina
		$vd->setPagina($request['page']);

		// imposto la base dell'url da usare nel menu condiviso al valore di default
		$vd->setUrlBase('home');

		// verifico se la connesisone al db è ok
		$db = DB::istance();
		
		if(!$db)
		{
			$vd->setErrorMessage("Ci scusiamo ma si è verificato un problema, gentilmente segnalarlo all'amministratore del sito. Grazie");
			$this->showLoginPage($vd);
		}
		else
		{
			
			if ($this->loggedIn()) {
				// utente autenticato
				// questa variabile viene poi utilizzata dalla vista
				$user = $_SESSION[self::user];
				
                                if(Settings::debug)
                                    echo "loggato";
                                
				$this->showHomeUtente($vd);
				if($user->getRuolo() == User::Seller)
				{
					$vd->setSeller(true);
					$vd->setListWork(PaintFactory::loadWorkFromNegozio(1,$session));
					$vd->setContentTitle('I miei quadri');
				}
			
			} else {
				
				// utente non autenticato
				if(isset($request["subpage"]))
				{
					$res = $this->setViewDescriptorFromSubpage($request, $vd, new User());
						
					if(!$res)
					{
						switch ($request['subpage']) {
							case 'Registrazione':
									
								$vd->setSottoPagina('Registrazione');
								break;
									
							default:
						}
					}
					$this->showLoginPage($vd);
				}
				else
				{
					$this->showLoginPage($vd);
				}
			}
			
			// gestion dei comandi
			// tutte le variabili che vengono create senza essere utilizzate
			// direttamente in questo switch, sono quelle che vengono poi lette
			// dalla vista, ed utilizzano le classi del modello

			if (isset($request["cmd"])) {
				// abbiamo ricevuto un comando
				switch ($request["cmd"]) {
					case 'login':
						$username = isset($request['user']) ? $request['user'] : '';
						$password = isset($request['password']) ? $request['password'] : '';
						$this->login($vd, $username, $password);
						// questa variabile viene poi utilizzata dalla vista
						if ($this->loggedIn())
						{
							$user = $_SESSION[self::user];
							
							switch ($user->getRuolo()){
								case User::Buyer:
									
									$vd->setUrlBase('buyer');
									break;

								case User::Seller:

									$vd->setUrlBase('seller');
									$vd->setListWork(PaintFactory::loadWorkFromNegozio($user->getNegozio()->getId()));
									$vd->setContentTitle('I miei quadri');
									$vd->setSeller(true);
									break;

								case User::Administrator:

									$vd->setUrlBase('administrator');
									$listUtenti = UserFactory::getListaUtenti();
									break;

								default:

							}
						}
						break;
							
						// logout
					case 'logout':

						$this->logout($vd);
						break;
							
							
					case 'registrazione':

						$new_user = UserFactory::makeUserFromRequest($request, $vd);

						if($new_user && UserFactory::storeUser($new_user, $vd))
						{
							$vd->setInfoMessage('La tua registrazione &egrave; andata a buon fine.');
							$vd->setSottoPagina('Home');
						}
						else
						{
							$recoveredUser = UserFactory::recoverUserFromRequest($request);
						}
				
						$this->showLoginPage($vd);

						break;
						
					case 'filtra':
						
						$vd->setContentTitle('Risultati della ricerca');
						$vd->setListWork(PaintFactory::loadWorkFromFilter($request));
						
						break;
					default : $this->showLoginPage($vd);
				}
			}				
		}
		
		
		//	richiamo la vista
                require 'mvc/view/master.php';			

		// chiudo la connessione al db
		DB::chiudiDB();
	}

	public function setViewDescriptorFromSubpage($request, ViewDescriptor $vd, User $user)
	{
		switch ($request['subpage'])
		{
			case 'Categorie';
				
				$vd->setSottoPagina('Categorie');

				break;

			case Paint::Moderna:

				$vd->setSottoPagina(Paint::Moderna);
				$vd->setListWork(PaintFactory::loadWorkFromCategory(Paint::Moderna));
				$vd->setContentTitle('Elenco '.Paint::Moderna);
					
				break;

			case Paint::Medievale:

				$vd->setSottoPagina(Paint::Medievale);
				$vd->setListWork(PaintFactory::loadWorkFromCategory(Paint::Medievale));
				$vd->setContentTitle('Elenco '.Paint::Medievale);
					
				break;

			case Paint::Contemporanea:

				$vd->setSottoPagina(Paint::Contemporanea);
				$vd->setListWork(PaintFactory::loadWorkFromCategory(Paint::Contemporanea));
				$vd->setContentTitle('Elenco '.Paint::Contemporanea);
					
				break;

			case 'Quadri':
					
				$vd->setSottoPagina('Quadri');
				$vd->setListWork(PaintFactory::loadAllWork());
				$vd->setContentTitle('Elenco Opere');
					
				break;

			case 'DettagliQuadro':
					
				$vd->setSottoPagina('DettagliQuadro');
				$vd->setWork(PaintFactory::loadWorkFromId($request['id']));
				$vd->setPrezzoNegozio(PaintFactory::loadPriceFromWork($request['id']));

				break;

			case 'Negozi':
					
				$vd->setSottoPagina('Negozi');
				$vd->setNegozi(NegozioFactory::loadListNegozi($user->getId()));
			
				break;
			
			case 'QuadriDelNegozio':
					
				$vd->setContentTitle('Quadri Del Negozio');
				$vd->setSottoPagina('Quadri');
				$vd->setListWork(PaintFactory::loadWorkFromNegozio($request['id_negozio']));
					
				break;
							
			case 'CercaAvanzato':
				
				$vd->setSottoPagina('CercaAvanzato');
				if(!$vd->getContentTitle())
					$vd->setContentTitle('Ricerca Avanzata');
				
				break;
			
			default:
					
				return false;
		}
	}

	/**
	 * Verifica se l'utente sia correttamente autenticato
	 * @return boolean true se l'utente era gia' autenticato, false altrimenti
	 */
	protected function loggedIn() {
		return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
	}

	/**
	 * Imposta la vista master.php per visualizzare la pagina di login
	 * @param ViewDescriptor $vd il descrittore della vista
	 */
	protected function showLoginPage($vd)
	{
		$vd->setTitolo("Quadramm - home");
		$vd->setMenuFile('mvc/view/home/menu.php');
		$vd->setLoginFile('mvc/view/home/login.php');
		$vd->setContentFile('mvc/view/home/content.php');
	}

	/**
	 * Imposta la vista master.php per visualizzare la pagina di gestione
	 * dello studente
	 * @param ViewDescriptor $vd il descrittore della vista
	 */
	protected function showHomeBuyer($vd)
	{
		// mostro la home degli acquirenti

		$vd->setTitolo("Quadramm - gestione acquirente");
		$vd->setMenuFile('mvc/view/buyer/menu.php');
		$vd->setLoginFile('mvc/view/buyer/login.php');
		$vd->setContentFile('mvc/view/buyer/content.php');
	}

	/**
	 * Imposta la vista master.php per visualizzare la pagina di gestione
	 * del docente
	 * @param ViewDescriptor $vd il descrittore della vista
	 */
	protected function showHomeSeller($vd)
	{
		// mostro la home dei docenti
		$vd->setTitolo("Quadramm - gestione venditore ");
		$vd->setMenuFile('mvc/view/seller/menu.php');
		$vd->setLoginFile('mvc/view/seller/login.php');
		$vd->setContentFile('mvc/view/seller/content.php');
	}


	/**
	 * Imposta la vista master.php per visualizzare la pagina di gestione
	 * dell'amministratore
	 * @param ViewDescriptor $vd il descrittore della vista
	 */
	protected function showHomeAdministrator($vd) {
		// mostro la home degli amministratori
		$vd->setTitolo("Quadramm - Super User ");
		$vd->setMenuFile('mvc/view/administrator/menu.php');
		$vd->setLoginFile('mvc/view/administrator/login.php');
		$vd->setContentFile('mvc/view/administrator/content.php');
	}

	/**
	 * Seleziona quale pagina mostrare in base al ruolo dell'utente corrente
	 * @param ViewDescriptor $vd il descrittore della vista
	 */
	protected function showHomeUtente($vd) {
		$user = $_SESSION[self::user];
		switch ($user->getRuolo()) {
			case User::Buyer:
				$this->showHomeBuyer($vd);
				break;

			case User::Seller:
				$this->showHomeSeller($vd);
				break;

			case User::Administrator:
				$this->showHomeAdministrator($vd);
				break;
		}
	}

	/**
	 * Procedura di autenticazione
	 * @param ViewDescriptor $vd descrittore della vista
	 * @param string $username lo username specificato
	 * @param string $password la password specificata
	 */
	protected function login($vd, $username, $password) {
		// carichiamo i dati dell'utente

            if(Settings::debug)
                echo " ".$username." - ".$password;
            
		$user = UserFactory::loadUser($username, $password);

		if ($user) {
			// utente autenticato

                    if(Settings::debug)
                    
			$_SESSION[self::user] = $user;
			$_SESSION['carrello'] = new Carrello();
			$this->showHomeUtente($vd);
		} else {
			$vd->setErrorMessage("Utente sconosciuto o password errata");
			$this->showLoginPage($vd);
		}
	}

	/**
	 * Procedura di logout dal sistema
	 * @param ViewDescriptor $vd il descrittore della pagina
	 */
	protected function logout($vd) {	
		
		// reset array $_SESSION
		$_SESSION = array();
		// termino la validita' del cookie di sessione
		if (session_id() != '' || isset($_COOKIE[session_name()])) {
			// imposto il termine di validita' al mese scorso
			setcookie(session_name(), '', time() - 2592000, '/');
		}
		// distruggo il file di sessione
		session_destroy();

		// imposto la url di base a login per il menu condiviso
		$vd->setUrlBase('home');

		$this->showLoginPage($vd);
	}

	protected function addToCart($vd, $request, $session)
	{
		$dev = PaintFactory::loadWorkStoreFromId($request['id'], $request['negozio']);
		
		if($dev)
		{
			
			$session['carrello']->addWork($dev);
				
			$vd->setWorkQty($session['carrello']->getQty());
			
			$vd->setInfoMessage('Quadri agginto al carrello.');
		}
		else
		{
			$vd->setErrorMessage('Impossibile aggiungere il quadro al carrello, se il problema persiste contattare un amministratore.');
		}
	}
	
	protected function removeFromCart($vd, $request, $session)
	{
		$dev = $session['carrello']->getWorkFromId($request['id'], $request['negozio']);
		
		if($session['carrello']->removeWork($dev))
		{
			$vd->setInfoMessage('Quadro rimosso.');
			$vd->setWorkQty($session['carrello']->getQty());
		}
		else 
		{
			$vd->setErrorMessage('Impossibile rimuovere il quadro, segnalare il problema ad un amministratore.');
		}
	}

	protected function setImpToken(ViewDescriptor $vd, &$request) 
	{
		if (array_key_exists('_imp', $request)) 
		{
			$vd->setImpToken($request['_imp']);
		}
	}
	
	protected function verificaCarta($numero, $data, $codice)
	{
		// verifico solo se i dati sono inseriti correttamente, andrebbe implementato con un modulo di connessione alla banca
		
		if (!filter_var($numero, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[0-9A-Z]{13,16}/')))) 
			return false;
		if (!filter_var($data, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9]{1,2}\/[0-9]{4}/')))) 
			return false;
		if (!filter_var($codice, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^\d+(,\d{2})?$/')))) 
			return false;
			
		return true;
	}
}

?>
