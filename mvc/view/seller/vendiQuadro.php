
	<h1>Scegli un quadro da aggiungere al tuo negozio</h1>
	
	<table id="tableElencoQuadri">
	<?php
		$nriga = 0;
		if(count($vd->getListWork()) < 1)
		{
			?>
			<tr>
				<td>Non ci sono quadri da aggiungere al negozio, vai alla <a href="seller/NuovoQuadro<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Pagina di inserimento quadri</a> per aggiungerne uno.</td>
			</tr>
			<?
		}
		else
		{
			foreach ($vd->getListWork() as $work)
			{
	
				$nriga%2 == 0 ? $classRiga = "rigaPari" : $classRiga = "rigaDispari";
			?>
				<tr class="<?= $classRiga; ?>">
					<td class="listImmagine elementoRiga" rowspan="2"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><img width="50" height="50" alt="immagine quadro" src="img/products/<? if($work->getImmagine() == NULL) echo "default.jpg"; else echo $work->getImmagine();?>"></a></td>
					<td class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?>"><?= $work->getNome() ?></a></td>
					<td class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?>"><?= 'AUTORE: '.$work->getAutore() ?></a></td>
					<td class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?>"><?= 'DATA: '.$work->getData() ?></a></td>
					<td class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?>"><?= 'DIMENSIONE: '.$work->getDimensione() ?></a></td>
					<td class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?>"><?= 'TECNICA: '.$work->getTecnica() ?></a></td>
					<td class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?>"><?= 'CORRENTE: '.$work->getCorrente() ?></a></td>
					<td class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?>"><?= 'TIPOLOGIA: '.$work->getTipologia() ?></a></td>
				</tr>
				<tr>
					<td colspan="7" class="elementoRiga"><a href="<?= 'seller/ModificaDettagliVendita?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><?= $work->getDescrizione() ?></a></td>
				</tr>
		<?
				$nriga++;
			}
                }
	?>
	</table>
