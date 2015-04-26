<div>
	<h2>Agisci per conto di un altro utente:</h2>
	
	<ul class="listUser">
	<?
	foreach ($listUtenti as $utente)
	{
		$ruolo = '';
		
		switch ($utente->getRuolo())
		{
			case User::Buyer:
				$ruolo = 'buyer';
				break;
			case User::Seller:
				$ruolo = 'seller';
				break;
		}
		
		?><li><a href="administrator/ImpersonaUtente?cmd=u_mod&amp;type=<?= $ruolo?>&amp;_imp=obj<?= $utente->getId() ?>"><?= $utente->getNome().' '.$utente->getCognome().' - '.$ruolo ?></a></li><?
	}
	?>
	</ul>
</div>