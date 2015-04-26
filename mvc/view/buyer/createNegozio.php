
	<h1>Negozio</h1>
	
	<div>
		<form action="buyer/Home" method="post">
		
			<input type="hidden" name="cmd" value="apriNegozio">
			<input type="hidden" name="imp" value="<?= $vd->scriviToken() ?>">
			<?= $vd->scriviToken('', ViewDescriptor::post); ?>
		
			<div>
			    <div><label for="nome_negozio">Nome Azienda*</label>
			    	<input id="nome_negozio" name="nome_negozio" type="text" value="<? if(isset($recoveredNegozio))echo $recoveredNegozio->getNomeNegozio()?>"></div>
			  
			    <div><label for="descrizione">Descrizione*</label>
			    	<input id="descrizione" name="descrizione" type="text" value="<? if(isset($recoveredNegozio))echo  $recoveredNegozio->getDescrizione()?>"></div>
			</div>
			
			<input type="submit" value="Crea">
			
		</form>
		
		<p>I campi contrassegnati dal simbolo * sono obbligatori.</p>
	</div>
