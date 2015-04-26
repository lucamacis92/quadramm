<!-- seller -->

<div class="box">
	<p>Rivenditore: <span class="logged"><?= $_SESSION[BaseController::user]->getNome().' '.$_SESSION[BaseController::user]->getCognome() ?> </span>Negozio: <span class="logged"><?= $_SESSION[BaseController::user]->getNegozio()->getNomeNegozio() ?></span></p>
	<p>
	    <a href="home/Quadri?cmd=logout">Logout</a>
	</p>
	<p>Credito: <span class="logged"><?= $user->getCredito() ?> &euro;</span></p>
</div>