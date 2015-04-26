<!-- menu buyer -->

<h2>Menu Admin</h2>
<ul class="listaMenu">
	<li class="<? if($vd->getSottoPagina() == 'ImpersonaUtente') echo 'selectedMenu' ?>"><a href="administrator/ImpersonaUtente">Impersona Utente</a></li>
</ul>
<?php
switch ($user->getRuolo()) {
    case User::Buyer:
        include_once 'mvc/view/buyer/menu.php';
        break;
    case User::Seller:
        include_once 'mvc/view/seller/menu.php';
        break;
}
?>
