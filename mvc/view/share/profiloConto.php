<h1>Dati del profilo</h1>

<form action="<?= $vd->getUrlBase() ?>/Profilo" method="post">

	<input type="hidden" name="cmd" value="modificaProfilo">
	<input type="hidden" name="id" value="<?= $user->getId() ?>">
	<?= $vd->scriviToken('', ViewDescriptor::post) ?>
	

	<div class="tabUser">
		<div class="record">
		    <div class="label"><label for="nome">Nome*</label></div>
		    <div class="valore"><input id="nome" name="nome" type="text" value="<?= $recoveredUser->getNome() ?>"></div>
		</div>
		<div class="record">
		    <div class="label"><label for="cognome">Cognome*</label></div>
		    <div class="valore"><input id="cognome" name="cognome" type="text" value="<?= $recoveredUser->getCognome() ?>"></div>
	    </div>
	    <div class="record">
	    	<div class="label"><label for="email">e-Mail*</label></div>
	   		<div class="valore"><input id="email" name="email" type="text" value="<?= $recoveredUser->getEmail() ?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="indirizzo">Via/Piazza*</label></div>
		    <div class="valore"><input id="indirizzo" name="via" type="text" value="<?= $recoveredUser->getVia() ?>"> 
		    	n<sup>o</sup><input id="numero_civico" name="numero_civico" type="text" value="<?= $recoveredUser->getNumeroCivico() ?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="citta">Citt&agrave;*</label></div>
		    <div class="valore"><input id="citta" name="citta" type="text" value="<?= $recoveredUser->getCitta() ?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="provincia">Provincia*</label></div>
		    <div class="valore"><input id="provincia" name="provincia" type="text" value="<?= $recoveredUser->getProvincia() ?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="cap">CAP*</label></div>
		    <div class="valore"><input id="cap" name="cap" type="text" value="<?= $recoveredUser->getCap() ?>"></div>
	    </div>
	</div>

  	<input type="submit" value="Invia">
	
</form>

<p>I campi contrassegnati dal simbolo * sono obbligatori.</p>

<?
if($recoveredUser->getNegozio())
{
	?>
	<h1>Dati del negozio</h1>
	
	<form action="<?= $vd->getUrlBase() ?>/Profilo" method="post">

		<input type="hidden" name="cmd" value="modificaNegozio">
		<input type="hidden" name="id" value="<?= $recoveredNegozio->getId() ?>">
		<?= $vd->scriviToken('', ViewDescriptor::post) ?>
	
		<div class="tabUser">
			<div class="record">
			    <div class="label"><label for="nome_negozio">NomeNegozio*</label></div>
			    <div class="valore"><input id="nome_negozio" name="nome_negozio" type="text" value="<?= $recoveredNegozio->getNomeNegozio() ?>"></div>
			</div>
			<div class="record">
			    <div class="label"><label for="descrizione">Descrizione</label></div>
			    <div class="valore"><input id="descrizione" name="descrizione" type="text" value="<?= $recoveredNegozio->getDescrizione() ?>"></div>
		    </div>
		</div>
	
		<input type="submit" value="Invia">
	
	</form>
	
	<p>I campi contrassegnati dal simbolo * sono obbligatori.</p>
	<?
}
?>

<h1>Ricarica Del Conto</h1>

<form action="<?= $vd->getUrlBase() ?>/Profilo" method="post">

	<input type="hidden" name="cmd" value="aggiungiCredito">
	<?= $vd->scriviToken('', ViewDescriptor::post) ?>

	<div class="tabUser">
		<div class="record">
		    <div class="label"><label for="numero_carta">Numero Carta*</label></div>
		    <div class="valore"><input title="(13 o 16 cifre)" id="numero_carta" name="numero_carta" type="number" value=""></div>
		</div>
		<div class="record">
		    <div class="label"><label for="data">Data di scadenza*</label></div>
		    <div class="valore"><input title="(mm/aaaa)" id="data" name="data" type="text" value=""></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="codice">Codice di sicurezza*</label></div>
		    <div class="valore"><input title="(3 cifre)" id="codice" name="codice" type="number" value=""></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="cash">Importo*</label></div>
		    <div class="valore"><input title="(10000,00)" id="cash" name="cash" type="number" value=""></div>
	    </div>
	</div>

	<input type="submit" value="Invia">

</form>

<p>I campi contrassegnati dal simbolo * sono obbligatori.</p>
