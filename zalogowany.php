<?php
session_start();
if(!isset($_SESSION['zalogowany']))
{
	header('Location: index.php');
	exit();
}
			echo 'Jesteś zalogowany jako '.$_SESSION['login'].'<br /> WITAMY!<br />';
			echo '<a href="wyloguj.php" style="text-align: left; margin-left: -5px;">Wyloguj</a><br />';
			echo '<a href="index.php?menu=4" style="text-align: left; margin-left: -5px;">Dodaj wpis</a>';
		?>
		