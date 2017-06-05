<?php

	if (!isset($_POST['login']) || (!isset($_POST['pass']))) {
	 	header('Location: zarejestruj.php'); 
	 exit();
	 }
	require_once "connect.php";

	 $polaczenie = @ new mysqli($host, $db_user, $db_password, $db_name);

	 if ($polaczenie->connect_errno!=0) {
	 	echo "Błąd.";
	 } else {
	 	$login = $_POST['login'];
	 	$password = $_POST['pass'];

	 	if ($result=$polaczenie->query("INSERT INTO `Users` (`id`, `login`, `pass`) VALUES (NULL, '$login', '$password')")) {
	 		$_SESSION['zarejestrowano']=true;
	 		header('Location: index.php');
	 		} else
	 		{
				$_SESSION['bladr'] = '<span color="red">NIE UDAŁO SIĘ ZAREJESTROWAĆ</span>';
				header('Location: zarejestruj.php');
	 		}
	 	}
	 	$polaczenie->close();
?>