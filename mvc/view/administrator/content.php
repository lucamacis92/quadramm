<?
switch ($vd->getPagina()) {
	case 'buyer':
		switch ($vd->getSottoPagina()) {
			default:
				include_once 'mvc/view/buyer/content.php';
				break;
		}
		break;

	case 'seller':
		switch ($vd->getSottoPagina()) {
			default:
				include_once 'mvc/view/seller/content.php';
				break;
		}
		break;

	case 'administrator':
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

			case 'ImpersonaUtente':
				include_once 'listUser.php';
				break;
				
			case 'Negozi':
				include_once 'mvc/view/share/listNegozi.php';
				break;
				
			case 'CercaAvanzato':
				include_once 'mvc/view/share/listWork.php';
				break;
				
			default:
				include_once 'listUser.php';
				break;
		}
		break;

	default:
		include_once 'listUser.php';
		break;
}
?>

