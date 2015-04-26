<!-- shared -->
<li <? if($vd->getSottoPagina() == 'CercaAvanzato') echo 'class="selectedMenu"' ?>><a href="<?= $vd->getUrlBase() ?>/CercaAvanzato<?= $vd->scriviToken('?', ViewDescriptor::get) ?>">Cerca</a></li>
<li <? if($vd->getSottoPagina() == 'Negozi') echo 'class="selectedMenu"' ?>><a href="<?= $vd->getUrlBase() ?>/Negozi<?= $vd->scriviToken('?', ViewDescriptor::get) ?>">Negozi</a></li>
<li <? if($vd->getSottoPagina() == 'Categorie') echo 'class="selectedMenu"' ?>><a href="<?= $vd->getUrlBase() ?>/Categorie<?= $vd->scriviToken('?', ViewDescriptor::get) ?>">Categorie</a></li>
<li <? if($vd->getSottoPagina() == 'Quadri') echo 'class="selectedMenu"' ?>><a href="<?= $vd->getUrlBase() ?>/Quadri<?= $vd->scriviToken('?', ViewDescriptor::get) ?>">Quadri</a></li>

