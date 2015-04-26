<?php 

switch ($vd->getSottoPagina()) {
	case Paint::Moderna:
		include_once 'mvc/view/share/listWork.php';
		break;
	
	case Paint::Medievale:
		include_once 'mvc/view/share/listWork.php';
		break;
		
	case Paint::Contemporanea:
		include_once 'mvc/view/share/listWork.php';
		break;
		
	case 'Quadri':
		include_once 'mvc/view/share/listWork.php';
		break;
	
	case 'Registrazione':
		include_once 'registrazione.php';
		break;
		
	case 'DettagliQuadro':
		include_once 'mvc/view/share/workDetails.php';
		break;
		
	case 'Categorie':
		include_once 'mvc/view/share/listCategory.php';
		break; 
		
	case 'Profilo':
		include_once 'mvc/share/profiloConto.php';
		break;
	
	case 'Negozi':
		include_once 'mvc/view/share/listNegozi.php';
		break;
	
	case 'CercaAvanzato':
		include_once 'mvc/view/share/listWork.php';
		break;
		
	default:
		
		include_once 'mvc/view/share/listCategory.php';
		break;
		
} 

?>