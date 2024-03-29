<!DOCTYPE html>
<html lang="pt">
<head>
	<meta charset="utf-8"/>
	<title>TRAVIAN - End Game Parser</title>
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap-responsive.css" />
	<link rel="stylesheet" type="text/css" href="public/css/bootstrap-datepicker.css" />
	<link rel="stylesheet" type="text/css" href="public/css/style.css" />

	<link rel="shortcut icon" type="image/x-icon" href="http://forum.travian.pt/images/travianvb4/statusicon/favicon.ico">
</head>
<body>

	<div class="container">
		<div class="row">
			
			<div class="span8" id="header">
				<a href="/"><img src="public/img/logoBig.png"></a>
			</div>

			<div class="span8" id="content">

				<?php 
					if (phpversion() < 5.3) {
						echo '<div class="alert alert-error"><strong>Aviso!</strong> Essa aplicação não funciona em servidores com a versão do PHP menor que a 5.3.</div>';
					}
				?>

				<?php include($inner); ?>

			</div>

			<div class="span8" id="footer">
				<p>For internal use only<br />Desenvolvido por: dvl - http://xdvl.info/</p>
				</div>

			</div>
		</div>

		<script src="public/js/jquery-1.8.2.js"></script>
		<script src="public/js/bootstrap.min.js"></script>
		<script src="public/js/bootstrap-datepicker.js"></script>
		<script src="public/js/main.js"></script>
		<script>
		$(function () {
			$('.datapicker').each(function() {
				$(this).datepicker();
			});  
		});
		</script>
	</body>
	</html>