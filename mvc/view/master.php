<?php 

include_once 'ViewDescriptor.php';
include_once basename(__DIR__) . '/../Settings.php';

if(Settings::debug)
	echo ' basename: '.basename(__DIR__);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title><?= $vd->getTitolo() ?></title>
		<base href="<?= Settings::getApplicationPath() ?>" />
		<link href="css/main.css" rel="stylesheet" type="text/css" media="screen" />
		<script type="text/javascript" src="js/lib/jquery2.js"></script>
		<script type="text/javascript" src="js/search.js"></script>
	</head>
	
	<body>
	
		<div id="pagina">
	
			<div id="header">
	
				<div id="logo">
					<img width="550" height="120" alt="logo" src="img/logo3.png">
				</div>
	
				<div id="login">
					<?php
					$login = $vd->getLoginFile();
					require "$login";
					?>
				</div>
	
				<div id="carrello">
					<?php 
					$carrello = 'mvc/view/share/carrello.php';
					require "$carrello";
					?>
				</div>
			</div>

			<div id="middle">
				<div id="side-bar1">
					<div class="box">
						<?php
						$menu = $vd->getMenuFile();
						require "$menu";
						
						if($vd->getPagina() != 'administrator' && $vd->getUrlBase() != 'administrator')
							require 'search.php';
						?>
					</div>
				</div>
	
				<div id="content">
					<?
					if(isset($userImp))
					{
					?>
						<div id="imp">
							<p>Ciao, <span class="logged"><?= $userImp->getNome().' '.$userImp->getCognome() ?></span>
							Credito: <span class="logged"><?= $userImp->getCredito() ?> &euro;</span>
						</div>
					<?
					}
					?>
					<?php
					if($vd->getErrorMessage())
						require 'errorMessage.php';
	
					if($vd->getInfoMessage())
						require 'infoMessage.php';
						
					$content = $vd->getContentFile();
					require "$content";
					?>
				</div>
				
				<?
				if($vd->getPagina() != 'administrator' && $vd->getUrlBase() != 'administrator')
				{
				}
				?>
	
				<div class="clear"></div>
	
			</div>
	
			<div id="footer">
				<?php require 'html/footer.php';?>
			</div>
	
		</div>
	
	</body>
</html>
