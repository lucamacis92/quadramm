<div id="errorMessage">
	<ul>
		<?
		foreach ($vd->getErrorMessage() as $message)
		{
			echo $message;
		}
		?>
	</ul>
</div>