<h1>Negozi</h1>

<?
$nriga = 0;

if(count($vd->getNegozi()) < 1)
{
?>
	<p>Non ci sono negozi da visualizzare.</p>
<?
}
else
{
	foreach ($vd->getNegozi() as $negozio)
	{
	?>
		<div class="blockResult">
			<div><?= $negozio->getNomeNegozio() ?></div>
			<div><?= $negozio->getDescrizione() ?></div>
			<div>
				<a title="Quadri" href="<?=$vd->getUrlBase()?>/QuadriDelNegozio?id_negozio=<?=$negozio->getId()?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><img alt="quadri" src="img/system/MaestaDelLouvre.jpg" width="35" height="35"></a>
			</div>
		</div>
		
	<?
	if($nriga > 0 && $nriga % 4 == 0)
		echo '<div class="clear"></div>';
	
	$nriga++;
	}
}
?>