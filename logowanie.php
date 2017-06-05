			<?php
				session_start();
				ob_start();
				if($_GET['action'] == 'register')
			{
			include('zarejestruj.php');
				}
				 else{
				 	?>
			<form action="zaloguj.php" method="POST">
				Login<br><input type="text" name="login"><br>
				Hasło<br><input type="password" name="pass"><br>
				<input type="submit" name="zaloguj" value="Zaloguj" style="margin-top: 5px;">
			</form>
			<form action="index.php?action=register" method="POST">
				<input type="submit" name="rejestruj" value="Zarejestruj">
			</form>
			<?php
			if (isset($_SESSION['zalogowany'])) {
				ob_clean();
				include_once "zalogowany.php";
			}
			 ob_end_flush(); 
			}
			?>