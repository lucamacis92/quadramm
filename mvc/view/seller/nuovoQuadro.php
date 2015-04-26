<?

include_once 'mvc/model/Paint.php';

?>
<div class="editForm">
	
	<h1><?= $vd->getContentTitle()?></h1>

	<form action="seller/NuovoQuadro" method="post">
	
		<?= $vd->scriviToken('', ViewDescriptor::post); ?>
	
		<label for="nome">Nome</label><input name="nome" id="nome" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getNome(); ?>" >
		<label for="tipologia">Tipologia</label>
		<select name="tipologia" id="tipologia">
			<option value="<?= Paint::Medievale ?>" <? if(isset($recoveredPaint) && $recoveredPaint->getTipologia() == Paint::Medievale) echo "selected" ?>><?= Paint::Medievale ?></option> 
			<option value="<?= Paint::Moderna ?>" <? if(isset($recoveredPaint) && $recoveredPaint->getTipologia() == Paint::Moderna) echo "selected" ?>><?= Paint::Moderna ?></option> 
			<option value="<?= Paint::Contemporanea ?>" <? if(isset($recoveredPaint) && $recoveredPaint->getTipologia() == Paint::Contemporanea) echo "selected" ?>><?= Paint::Contemporanea ?></option>
		</select>
		<label for="autore">AUTORE</label><input name="autore" id="autore" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getAutore() ?>" >
		<label for="data">DATA</label><input name="data" id="data" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getData()  ?>" >
		<label for="dimensione">DIMENSIONE</label><input name="dimensione" id="dimensione" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getDimensione()  ?>" >
		<label for="tecnica">TECNICA</label><input name="tecnica" id="tecnica" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getTecnica()  ?>" >
		<label for="corrente">CORRENTE</label><input name="corrente" id="corrente" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getCorrente()  ?>" >
		<label for="descrizione">Descrizione</label><input name="descrizione" id="descrizione" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getDescrizione()  ?>" >
		<label for="immagine">Immagine</label><input name="immagine" id="immagine" type="text" value="<? if(isset($recoveredPaint)) echo $recoveredPaint->getImmagine()  ?>" >
			
		<?
		if($vd->getSottoPagina() == "NuovoQuadro")
		{
		?>
			<input type="hidden" name="cmd" value="nuovoQuadro">
			<hr><input value="Aggiungi" type="submit" >
		<?
		}
		else if($vd->getSottoPagina() == "EditQuadro")
		{
		?>
			<input type="hidden" name="cmd" value="editQuadro">
			<input type="hidden" name="id" value="<?= $recoveredPaint->getId() ?>">
			<hr><input value="Salva Modifiche" type="submit" >
		<?
		}
		?>
		
		
			
	</form>
</div>