<?php 

$work = $vd->getWork();

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
			<form action="seller/Home" method="post">
			
				<?= $vd->scriviToken('', ViewDescriptor::post); ?>
			
				<input type="hidden" name="id" value="<?= $work->getId()?>">
				<input type="hidden" name="cmd" value="modificaDettagliVendita">
				<lable for="qty">Quantita a magazzino: </lable><input id="qty" name="qty" type="text" value="<?= $work->getQty() ?>">
				<lable for="prezzo">Prezzo di vendita: </lable><input id="prezzo" name="prezzo" type="number" value="<?= $work->getPrezzo() ?>">
				<hr>
				<input type="submit" value="Salva">
			</form>
		</div>
	</div>
</div>