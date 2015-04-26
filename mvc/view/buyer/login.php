<!-- buyer -->

<div class="box">
	<p>Utente: <span class="logged"><?= $_SESSION[BaseController::user]->getNome().' '.$_SESSION[BaseController::user]->getCognome() ?></span></p>
	<p>
	    <a href="home/Quadri?cmd=logout">Logout</a>
	</p>
	<p>Credito: <span class="logged"><?= $user->getCredito() ?> &euro;</span></p>
</div>