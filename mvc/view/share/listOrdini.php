<?php

if(count($orderList) > 0)
{
?>
	<h1><?= $vd->getContentTitle() ?></h1>
	<div>
		<?
		foreach ($orderList as $ordine)
		{
			?>
			<div>
				<a href="<?= $vd->getUrlBase() ?>/<? if($vd->getSeller()) echo 'DettagliGestioneOrdine'; else echo 'DettagliOrdine'; ?>?id=<?= $ordine->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>">
					N ordine: <?= $ordine->getId() ?> Data: <?= $ordine->getData() ?> Stato: <? if($ordine->getStato() == 0) echo 'Attesa di spedizione'; else echo 'Spedito'; ?>
				</a>
			</div>
			<?	
		}
		?>
	</div>
<?
}
else 
{
?>
	<h1>Non ci sono ordini da visualizzare.</h1>
<?
}
?>