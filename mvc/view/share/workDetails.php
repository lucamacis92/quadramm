<?php 

$work = $vd->getWork();
$prezzoNegozio = $vd->getPrezzoNegozio();

?>
<div id="dettagliQuadro">

	<div id="dettagliQuadro-img">
		<img alt="Immagine non caricata" width="200" src="img/products/<? if($work->getImmagine() == NULL) echo "default.jpg"; else echo $work->getImmagine();?>" >
	</div>
	
	<div id="dettagliQuadro-descrizione">
		
		<div id="dettagliQuadro-titolo">
			<h2><?= $work->getNome() ?></h2>
		</div>
		<div id="dettagliQuadro-caratteristiche">
			<p><?php
				if($work->getAutore() != '') echo 'AUTORE: '.$work->getAutore().' ';
				if($work->getData() != '') echo 'DATA: '.$work->getData().' ';
				if($work->getDimensione() != '') echo 'DIMENSIONE: '.$work->getDimensione().' ';
				if($work->getTecnica() != '') echo 'TECNICA: '.$work->getTecnica().' ';
				if($work->getCorrente() != '') echo 'CORRENTE: '.$work->getCorrente().'<br>';
				if($work->getDescrizione() != '') echo 'Altre Informazioni: '.$work->getDescrizione().' ';
			?></p>
		</div>
		<div id="dettagliQuadro-carrello">
			<?
				if($prezzoNegozio != NULL)
				{
					foreach($prezzoNegozio as $v)
					{
						?><h3>Negozio <?= $v->getNegozio().' - '.$v->getPrezzo()?>&euro;</h3>
						<? 
						if($this->loggedIn() && $vd->getPagina() != 'administrator'){ ?>
							<a href="<?= $vd->getUrlBase().'/'.$vd->getSottoPagina()?>?cmd=aggiungiQuadro&amp;id=<?= $v->getId() ?>&amp;negozio=<?= $v->getNegozio()?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>">Aggiungi<img width="15" height="15" alt="carrello" src="img/icons/basket-full.png"></a>
						<?}
					}
				}
			?>
		</div>
	</div>
</div>