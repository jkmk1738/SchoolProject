<?php
	session_start();

	session_unset();
	$_SESSION['wylogowanie'] = true;
	header('Location: index.php');
?>