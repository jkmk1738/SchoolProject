			<?php
				session_start();
				if(!isset($_SESSION['zalogowany']))
				{
					header('Location: index.php');
					exit();
				}
				require_once "connect.php";

				$connection = @new mysqli($host, $db_user, $db_password, $db_name);

					if ($connection->connect_errno!=0) {
					echo "Błąd połączenia";
						} else {
							/*$fhandle = fopen($_FILES['zdjecie']['tmp_name'], "r");
        					$content = base64_encode(fread($fhandle, $_FILES['zdjecie']['size']));
        					fclose($fhandle);
        					*/
							$tytul = $_POST['tytul'];
							$tresc = $_POST['tresc'];
									if($result=$zapytanie->query("INSERT INTO `zdjecia` (`id`, `tytul`,`opis`) VALUES (NULL, '$tytul', '$tresc')")){
									        /*$adres = "http://localhost:8888/Naprog/showimage.php?id=".mysql_insert_id();*/
									        $_SESSION['dodano']= true;
									        header('Location: index.php');
								}
					else{
						$_SESSION['niedodano']= true;
					}
				}
				$polaczenie->close();
				/*
				echo "Twoje zdjęcie otrzymało adres: <br/>".$adres;
				echo "<br/><img src='.$adres.'/>";
				*/
			?>
	