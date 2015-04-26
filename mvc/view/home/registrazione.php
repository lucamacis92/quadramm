
<h1>Form di registrazione</h1>

<form action="home/Registrazione" method="post">

	<input type="hidden" name="cmd" value="registrazione">

	<div class="tabUser">
		<div class="record">
		    <div class="label"><label for="nome">Nome*</label></div>
		    <div class="valore"><input id="nome" name="nome" type="text" value="<? if(isset($recoveredUser))echo $recoveredUser->getNome()?>"></div>
		</div>
		<div class="record">
		    <div class="label"><label for="cognome">Cognome*</label></div>
		    <div class="valore"><input id="cognome" name="cognome" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getCognome()?>"></div>
	    </div>
	    <div class="record">
	    	<div class="label"><label for="username">User*</label></div>
	    	<div class="valore"><input id="username" name="username" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getUsername()?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="first-password">Password*</label></div>
		    <div class="valore"><input id="first-password" name="first-password" type="password"></div>
	    </div>
	    <div class="record">	
		    <div class="label"><label for="confirm-password">Confirm-Password*</label></div>
		    <div class="valore"><input id="confirm-password" name="confirm-password" type="password"></div>
	    </div>
	    <div class="record">
	    	<div class="label"><label for="email">e-Mail*</label></div>
	   		<div class="valore"><input id="email" name="email" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getEmail()?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="indirizzo">Via/Piazza*</label></div>
		    <div class="valore"><input id="indirizzo" name="via" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getVia()?>"> 
		    	n<sup>o</sup><input id="numero_civico" name="numero_civico" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getNumeroCivico()?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="citta">Citt&agrave;*</label></div>
		    <div class="valore"><input id="citta" name="citta" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getCitta()?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="provincia">Provincia*</label></div>
		    <div class="valore"><input id="provincia" name="provincia" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getProvincia()?>"></div>
	    </div>
	    <div class="record">
		    <div class="label"><label for="cap">CAP*</label></div>
		    <div class="valore"><input id="cap" name="cap" type="text" value="<? if(isset($recoveredUser))echo  $recoveredUser->getCap()?>"></div>
	    </div>
	</div>

  	<input type="submit" value="Invia">
	
</form>

<p>I campi contrassegnati dal simbolo * sono obbligatori.</p>
