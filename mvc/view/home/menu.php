
<h2>Menu</h2>
<ul class="listaMenu">
	<li <? if($vd->getSottoPagina() == 'Registrazione') echo 'class="selectedMenu"' ?>><a href="home/Registrazione<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Registrati</a></li>
	<? require 'mvc/view/share/menu.php'; ?>
</ul>
