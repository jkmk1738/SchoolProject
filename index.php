<!DOCTYPE html>
<html lang="pl">
<head>
	<title>World of Warcraft</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="utf-8">
	<meta name="author" content="Jakub Kaniowski">
	<meta name="keywords" content="WoW,World of Warcraft, Strona o World of Warcraft">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="css/fontello.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,900&amp;subset=latin-ext" rel="stylesheet"> 
</head>
<body>
	<div id="container">
		<div id="header">
			<img src="Wowlogo.png">
		</div>
		<div id="logo">
			<img src="logo.png">
		</div>
		<div id="citation">
			<p><i>No, old friend, you've freed us all.</i> - Thrall, wódz Hordy</p>
		</div>
		<div style="clear:both"></div>
		<div id="middle">
			<div id="leftbar">
				<div class="square">
					<div id="logowanie" class="square">
					<?php
						require_once "logowanie.php";
					?>
					</div>
					<div style="clear:both"></div>
				</div>
				<div class="square">
					<div class="linki">	<a href="index.php?menu=default">Strona główna</a><br /></div>
					<div class="linki">	<a href="index.php?menu=1">Postacie</a><br /></div>
					<div class="linki">	<a href="index.php?menu=2">Rasy</a><br /></div>
					<div class="linki">	<a href="index.php?menu=3">Klasy</a><br /></div>
				</div>
				<div class="square">
					<div id="odwiedziny">
						<?php
							require_once "odwiedziny.php";
						?>
					</div>
				</div>
				<div style="clear:both"></div>
			</div>
			<div id="article">
				<?php
$arg = $_GET['menu'];
 
switch ($arg)
{
	case 4:
		include('dodawanie.php');
	break;
	case 1:
		include('postacie.html');
	break;
 
	case 2:
		include('rasy.html');
	break;
 
	case 3:
		include('klasy.html');
	break;
 
	default:
		include('glowna.html');
	break;
}
?>
			</div>
			<div style="clear:both;"></div>
		</div>
		<div id="footer">
			<p name="stopka">&copy;Copyright by Jakub Kaniowski <i class="demo-icon icon-mail-alt"> jakub_kaniowski@o2.pl</i></p>
		</div>
	</div>
</body>
</html>