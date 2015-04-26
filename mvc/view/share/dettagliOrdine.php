
<?
if(Settings::debug)
	echo "getseller:".$vd->getSeller();
?>

<h1>Dettagli dell'ordine N <?= $ordine->getId() ?></h1>

<div>
	<div>N ordine: <?= $ordine->getId() ?> Data: <?= $ordine->getData() ?> Stato: <? if($ordine->getStato() == 0) echo 'Attesa di spedizione'; else echo 'Spedito'; ?></div>
	<div>
		<table id="tabellaCarrello">
			<tr>
				<th></th>
				<th>Quadro</th>
				<th>Negozio</th>
				<th>Prezzo</th>
				<th>Quantita</th>
				<th>Stato</th>
				<th></th>
			</tr>
			<?
			foreach ($ordine->getWorks() as $work)
			{
			?>
			<tr class="rigaCarrello">
					<td><img width="50" height="50" alt="" src="img/products/<? if($work->getImmagine() == NULL) echo "default.jpg"; else echo $work->getImmagine();?>"></td>
					<td><?= $work->getNome() ?></td>
					<td><?= $work->getNegozio() ?></td>
					<td><?= $work->getPrezzo() ?>&euro;</td>
					<td><?= $work->getQty() ?></td>
					<td><? if($work->getStato() == 0) echo 'Da Spedire'; else echo 'Spedito'; ?></td>
					<?
					if(Settings::debug)
						echo "statoWork:".$work->getStato();
					if($vd->getSeller())
					{
					?>
						<td>
							<a href="seller/DettagliGestioneOrdine?cmd=cambiaStatoSpedizione&amp;id=<?= $ordine->getId() ?>&amp;id_quadro=<?= $work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>">
							<? if($work->getStato() == 0) echo "Segna come spedito."; else echo "Segna come non spedito." ?></a>
						</td>
					<?
					}
					?>
				</tr>
			<?
			}
			?>
		</table>
	</div>
</div>
