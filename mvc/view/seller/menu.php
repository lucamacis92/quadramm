<!-- menu seller -->


<h2>Menu Vendite</h2>
<ul class="listaMenu">
	<li class="<? if($vd->getSottoPagina() == 'NuovoQuadro') echo 'selectedMenu' ?>"><a href="seller/NuovoQuadro<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Nuovo Quadro</a></li>
	<li class="<? if($vd->getSottoPagina() == 'VendiQuadro') echo 'selectedMenu' ?>"><a href="seller/VendiQuadro<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Vendi Quadro</a></li>
	<li class="<? if($vd->getSottoPagina() == 'MieiQuadri') echo 'selectedMenu' ?>"><a href="seller/MieiQuadri<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">I Miei Quadri</a></li>
	<li class="<? if($vd->getSottoPagina() == 'OrdiniRicevuti') echo 'selectedMenu' ?>"><a href="seller/OrdiniRicevuti<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Ordini Ricevuti</a></li>
</ul>
<h2>Menu Acquisti</h2>
<ul class="listaMenu">
	<li class="<? if($vd->getSottoPagina() == 'StoricoOrdini') echo 'selectedMenu' ?>"><a href="seller/StoricoOrdini<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Storico Ordini</a></li>
	<li class="<? if($vd->getSottoPagina() == 'Profilo') echo 'selectedMenu' ?>"><a href="seller/Profilo<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Profilo e Conto</a></li>
	<? require 'mvc/view/share/menu.php'; ?>

</ul>