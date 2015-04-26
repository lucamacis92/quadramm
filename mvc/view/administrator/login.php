<!-- buyer -->

<div class="box">
	<p>Super User: <span class="logged"><?= $_SESSION[BaseController::user]->getNome().' '.$_SESSION[BaseController::user]->getCognome() ?></span></p>
	<p>
	    <a href="administrator/Home?cmd=logout">Logout</a>
	</p>
	<p>Credito: <span class="logged"><?= $_SESSION[BaseController::user]->getCredito() ?> &euro;</span></p>
</div>