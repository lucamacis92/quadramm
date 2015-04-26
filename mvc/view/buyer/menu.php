<!-- menu buyer -->

<h2>Menu Vendite</h2>
<ul class="listaMenu">
	<li class="<? if($vd->getSottoPagina() == 'ApriNegozio') echo 'selectedMenu' ?>"><a href="buyer/ApriNegozio<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Apri Negozio</a></li>
</ul>
<h2>Menu Acquisti</h2>
<ul class="listaMenu">
	<li class="<? if($vd->getSottoPagina() == 'StoricoOrdini') echo 'selectedMenu' ?>"><a href="buyer/StoricoOrdini<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Storico Ordini</a></li>
	<li class="<? if($vd->getSottoPagina() == 'Profilo') echo 'selectedMenu' ?>"><a href="buyer/Profilo<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Profilo e Conto</a></li>
	<? require 'mvc/view/share/menu.php'; ?>

</ul>
