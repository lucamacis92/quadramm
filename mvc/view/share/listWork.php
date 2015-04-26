<h1><?= $vd->getContentTitle() ?></h1>

<?
$nriga = 0;

if($vd->getSottoPagina() == 'CercaAvanzato')
{
	?>
	<div id="cercaAvanzato">
		<h2>Filtri</h2>
		<form action="<?= $vd->getUrlBase() ?>/CercaAvanzato" method="post">
			
			<input type="hidden" name="cmd" value="filtra">
			<input id="base" type="hidden" value="<?= $vd->getUrlBase() ?>">
			<?= $vd->scriviToken('', ViewDescriptor::post); ?>
			
			<div id="box-cerca">
				<div id="label">
					<div class="sx">
						<label for="Nome">Nome:</label>
					</div>
					<div class="sx">
						<label for="Autore">Autore:</label>
					</div>
					<div class="sx">
						<label for="Data">Data:</label>
					</div>
					<div class="sx">
						<label for="Dimensione">Dimensione:</label>
					</div>
					<div class="sx">
						<label for="Tecnica">Tecnica:</label>
					</div>
					<div class="sx">
						<label for="Corrente">Corrente:</label>
					</div>
				</div>
				<div class="clear"></div>
				<div id="input">
					<div>
					<input title="cerca" class="searchSubmit" type="submit" value="">
					</div>
				</div>
			</div>
		</form>
	</div>
	
	<div class="clear"></div>
	<?
}

if(count($vd->getListWork()) < 1)
{
?>
	<p>Non ci sono quadri da visualizzare.</p>
<?
}
else
{
	foreach ($vd->getListWork() as $work)
	{
	?>
		
			<? 
			if($vd->getSeller())
			{
				?>
				<div class=""><a title="Modifica i dettagli di vendita" href="<?= $vd->getUrlBase().'/ModificaDettagliVendita?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><img width="100" height="100" alt="<?= $work->getImmagine()?>" src="img/products/<? if($work->getImmagine() == NULL) echo "default.jpg"; else echo $work->getImmagine();?>"></a></div>
				<div class="">
					<a title="Modifica i dettagli di vendita" href="<?= $vd->getUrlBase().'/ModificaDettagliVendita?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><?= $work->getNome() ?></a>
					<a title="Modifica il quadro" href="seller/EditQuadro?id=<?= $work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><img width="15" height="15" alt="modifica" src="img/system/pencil.png"></a>
				</div>
				<div class="">
					<a title="Modifica i dettagli di vendita" href="<?= $vd->getUrlBase().'/ModificaDettagliVendita?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>">Prezzo: <?= $work->getPrezzo() ?>&euro;</a>
				</div>
				<div class="">
					<a title="Modifica i dettagli di vendita" href="<?= $vd->getUrlBase().'/ModificaDettagliVendita?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>">Magazzino: <?= $work->getQty() ?></a>
					<a title="Non vendere piu" href="seller/Home?cmd=eliminaVendita&amp;id=<?= $work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><img width="25" height="25" alt="EliminaVendita" src="img/system/trash.png"></a>
				</div>
				<?
			}
			else 
			{
				?>
				<div class=""><a title="Dettagli quadro" href="<?= $vd->getUrlBase().'/DettagliQuadro?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><img width="100" height="100" alt="<?= $work->getImmagine()?>" src="img/products/<? if($work->getImmagine() == NULL) echo "default.jpg"; else echo $work->getImmagine();?>"></a></div>
				<div class=""><a title="Dettagli quadro" href="<?= $vd->getUrlBase().'/DettagliQuadro?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>"><?= $work->getNome() ?></a></div>
				<div class=""><a title="Dettagli quadro" href="<?= $vd->getUrlBase().'/DettagliQuadro?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>">Prezzo <? if($work->GetPrezzoMin() == $work->getPrezzoMax()){ echo $work->getPrezzoMin()."&euro;";}else{?> da <?= $work->getPrezzoMin().'&euro; a '.$work->getPrezzoMax().'&euro;'; }?></a></div>
				<div class=""><a title="Dettagli quadro" href="<?= $vd->getUrlBase().'/DettagliQuadro?id='.$work->getId() ?><?= $vd->scriviToken('&amp;', ViewDescriptor::get); ?>">Ancora <?= $work->getQty() ?> Disponibili</a></div>
				<?
			}
			?>
			
		
		
	<?
	if($nriga > 0 && $nriga % 4 == 0)
		echo '<div class="clear"></div>';
	
	$nriga++;
	}
}
?>
