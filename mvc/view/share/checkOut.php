<h2>Quadri nel Carrello</h2>

	<table id="tabellaCarrello">
		<tr>
			<th></th>
			<th>Quadro</th>
			<th>Negozio</th>
			<th>Prezzo</th>
			<th>Quantita</th>
			<th></th>
		</tr>
		<?
		foreach ($session['carrello']->getWorks() as $work)
		{
		?>
		<tr class="rigaCarrello">
			<td><img width="50" height="50" alt="" src="img/products/<? if($work->getImmagine() == NULL) echo "default.jpg"; else echo $work->getImmagine();?>"></td>
			<td><?= $work->getNome() ?></td>
			<td><?= $work->getNegozio() ?></td>
			<td><?= $work->getPrezzo() ?>&euro;</td>
			<td><?= $work->getQty() ?></td>
			<td><a title="Rimuovi dal carrello" href="<?= $vd->getUrlBase() ?>?cmd=rimuoviQuadro&amp;id=<?= $work->getId() ?>&amp;negozio=<?= $work->getNegozio() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><img width="20" height="20" alt="elimina" src="img/system/trash.png"></a></td>
		</tr>
		<?
		}
		?>
		<tr>
			<td colspan="6"><hr></td>
		</tr>
		<tr>
			<td colspan="3">Totale: </td>
			<td><?= $session['carrello']->getTot() ?>&euro;</td>
			<td><?= $session['carrello']->getQty() ?></td>
		</tr>
	</table>
	<div id="checkout">
	<?
	if($session['carrello']->getQty() > 0)
	{
		if($user->getCredito() >= $session['carrello']->getTot())
		{
			?><a href="<?= $vd->getUrlBase() ?>?cmd=checkout<?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>" >Compra</a><?
		}
		else 
		{
			?>Non hai abbastanza soldi per completare l'acquisto. Puoi ricaricare il conto da <a href="<?= $vd->getUrlBase() ?>/Profilo<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">qui</a><? 
		}
	}
	?>
	</div>