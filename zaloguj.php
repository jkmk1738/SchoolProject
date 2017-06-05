<?php
	session_start();

	if (empty($_POST['login']) || (empty($_POST['pass']))) {

		header('Location: index.php');
		exit();
	}

	require_once "connect.php";

	$connection = @new mysqli($host, $db_user, $db_password, $db_name);

	if ($connection->connect_errno!=0) {
		echo "Błąd połączenia";
	} else {
		$login = $_POST['login'];
		$password = $_POST['pass'];

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");

			if ($result = @$connection->query(sprintf("SELECT * FROM Users WHERE login ='%s' AND pass='%s'",mysqli_real_escape_string($connection,$login), mysqli_real_escape_string($connection, $password)))) {
					$ilu = $result->num_rows;
					if ($ilu>0) {
						$_SESSION['zalogowany'] = true;
						$wiersz = $result->fetch_assoc();
						$_SESSION['id'] = $wiersz['id'];
						$_SESSION['login'] = $wiersz['login'];
						unset($_SESSION['blad']);
						$result->free_result();
						header('Location: index.php');
					} 
					else{
					$_SESSION['blad'] = '<span style="color:red">Nie udało się zalogować!';
					header('Location: index.php');
					}
			}
			$connection->close();
	}
?>