<?php

include_once 'BaseController.php';
include_once 'mvc/view/ViewDescriptor.php';
include_once 'mvc/model/User.php';
include_once 'mvc/model/UserFactory.php';

include_once 'mvc/model/Paint.php';
include_once 'mvc/model/PaintFactory.php';
include_once 'mvc/model/Carrello.php';


/**
 * Classe che gestisce contorlla l'interazione tra un utente
 * Amministratore ed il sistema
 */
class AdministratorController extends BaseController {

	/**
	 * Costruttore
	 */
	public function __construct() {
		// richiamo il costruttore della superclasse
		parent::__construct();
	}

	/**
	 * Metodo per gestire l'input dell'utente
	 * @param type $request la richiesta da gestire
	 * @param type $session array con le variabili di sessione
	 */
	public function handleInput(&$request, &$session) {

		// creo il descrittore della vista
		$vd = new ViewDescriptor();
		
		$vd->setUrlBase('administrator');

		// imposto la pagina
		$vd->setPagina($request['page']);

		// imposto il token per impersonare un utente (nel lo stia facendo)
		$this->setImpToken($vd, $request);

		// verifico se la connesisone al db è ok
		$db = DB::istance();
		
		if($db == false)
		{
			$vd->setErrorMessage("Ci scusiamo ma si è verificato un problema, gentilmente segnalarlo all'amministratore del sito. Grazie");
			$this->showLoginPage($vd);
		}
		else
		{
			if (!$this->loggedIn()) 
			{
	
				$this->showLoginPage($vd);
			} 
			else 
			{
				$user = $session[BaseController::user];
	
				if (isset($request["subpage"])) 
				{
					$res = $this->setViewDescriptorFromSubpage($request, $vd, $user);
					
					if(!$res)
					{
						switch ($request["subpage"]) 
						{
							case 'ImpersonaUtente':						
								
								$listUtenti = UserFactory::getListaUtenti();
								break;
							
							default:
								
								$listUtenti = UserFactory::getListaUtenti();
								break;
						}
					}
					
					$this->showHomeUtente($vd);
				}
				if (isset($request["cmd"])) 
				{
					switch ($request["cmd"]) 
					{
						case 'filtra':
						
							$vd->setContentTitle('Risultati della ricerca');
							$vd->setListWork(PaintFactory::loadWorkFromFilter($request));
							$this->showHomeUtente($vd);
						
							break;
							
						case 'logout':
							$this->logout($vd);
							break;
	
						case 'u_mod':
							if (isset($request[BaseController::impersonato])) 
							{	
								$index = str_replace('obj', '', $request[BaseController::impersonato]);
	
								$sessionIndex = $request[BaseController::impersonato];
								$s = UserFactory::loadUserFromId($index);
	
								if ($this->impersonaUtente($s, $request['type'], 'home', $sessionIndex, $session)) 
								{
									return;
								}
							}
							$this->showHomeUtente($vd);
							break;
					}
				} 
				else 
				{
					$user = $session[BaseController::user];
					$this->showHomeUtente($vd);
				}
			}
		}

		require 'mvc/view/master.php';
		
		DB::chiudiDB();
	}

	private function impersonaUtente($utente, $pagina, $sottoPagina, $sessionIndex, &$session) 
	{
		if (isset($utente)) 
		{
			$session[$sessionIndex] = array();

			$session[$sessionIndex][BaseController::user] = $utente;
			
			$session[$sessionIndex]['carrello'] = new Carrello();
			
			switch ($pagina) 
			{
				case 'buyer':
					
					$delegate = new BuyerController();
					break;

				case 'seller':

					$delegate = new SellerController();
					break;
			}

			$new_request = array();
			$new_request["page"] = $pagina;
			$new_request["subpage"] = $sottoPagina;

			$new_request[BaseController::impersonato] = $sessionIndex;

			$delegate->handleInput($new_request, $session[$sessionIndex]);
			return true;
		}

		return false;
	}

	public function &getSessione() 
	{
		$null = null;
		if (isset($_SESSION) && array_key_exists(BaseController::user, $_SESSION)) 
		{
			$user = $_SESSION[BaseController::user];

			if (isset($user) && $user->getRuolo() == User::Administrator) 
			{
				return $_SESSION;
			}
		}
		return $null;
	}

}

?>