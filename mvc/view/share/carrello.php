<div class="box" >
	<?
	if(isset($userImp) ||
		$vd->getUrlBase() == 'seller' ||
		$vd->getUrlBase() == 'buyer')
	{
		?>
		<p id="textCarrello">
		<? if($vd->getWorkQty() == 0)
		{
			echo "Non ci sono";
		}
		else 
		{
			echo "Ci sono ".$vd->getWorkQty(); 
		}?> quadri nel <a href="<?= $vd->getUrlBase() ?>/Carrello<?= $vd->scriviToken('?', ViewDescriptor::get); ?>">Carrello</a></p>
		<? if($vd->getWorkQty() == 0)
		{
			echo '<img width="20" height="20" alt="carrello" src="img/icons/basket-empty.png">';
		}
		else
		{
			echo '<img width="20" height="20" alt="carrello" src="img/icons/basket-full.png">';
		}
	}
	?>
</div>