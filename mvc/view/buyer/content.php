<!-- content buyer -->

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

	case 'Categorie':
		include_once 'mvc/view/share/listCategory.php';

		break;

	case 'DettagliQuadro':
		include_once 'mvc/view/share/workDetails.php';
		break;

	case 'Carrello':
		include_once 'mvc/view/share/checkOut.php';
		break;

	case 'ApriNegozio':
		include_once 'createNegozio.php';
		break;
		
	case 'Profilo':
		include_once 'mvc/view/share/profiloConto.php';
		break;
		
	case 'StoricoOrdini':
		include_once 'mvc/view/share/listOrdini.php';
		break;
		
	case 'DettagliOrdine':
		include_once 'mvc/view/share/dettagliOrdine.php';
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