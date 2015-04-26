<?php

include_once 'mvc/controller/BaseController.php';
include_once 'mvc/controller/BuyerController.php';
include_once 'mvc/controller/SellerController.php';
include_once 'mvc/controller/AdministratorController.php';

FronController::dispatch($_REQUEST);

class FronController {
    
	/**
	 * Gestore delle richieste al punto unico di accesso all'applicazione
	 * @param array $request i parametri della richiesta
	 */
    
	public static function dispatch(&$request) 
	{
		// inizializziamo la sessione
		
		session_start();
                
                if(!isset($request["page"])) $request["page"]="home";
		
		if (isset($request["page"])) 
		{
			switch ($request["page"]) 
			{
				case "home":
					
					$controller = new BaseController();
					$controller->handleInput($request, $_SESSION);
					
					break;

				case 'buyer':
					
					$controller = new BuyerController();
					$sessione = &$controller->getSessione($request);
					
					if (!isset($sessione)) {
						self::write403();
					}
					
					$controller->handleInput($request, $sessione);
					break;

				case 'seller':
					
					$controller = new SellerController();
					$sessione = &$controller->getSessione($request);
					
					if (!isset($sessione)) {
						self::write403();
					}
					$controller->handleInput($request, $sessione);
					break;

				case 'administrator':
					$controller = new AdministratorController();
					$sessione = &$controller->getSessione();
					if (!isset($sessione)) {
						self::write403();
					}
					$controller->handleInput($request, $sessione);
					break;

				default:
                                    
					self::write404();
				break;
			}
		}
	}
	
	public static function write404() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('mvc/view/error.php');
        exit();
    }

    /**
     * Crea una pagina di errore quando l'utente non ha i privilegi 
     * per accedere alla pagina
     */
    public static function write403() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $login = true;
        include_once('mvc/view/error.php');
        exit();
    }
	
}

?>
