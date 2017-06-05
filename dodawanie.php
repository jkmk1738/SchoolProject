	<?php
				session_start();
				if(!isset($_SESSION['zalogowany']))
				{
					header('Location: index.php');
					exit();
				}
				?>
	<p name="ddd" style="font-weight: 900; font-size: 48px;">Dodawanie wpisu</p>
	<form method="POST" ENCTYPE="multipart/form-data" action="dodaj.php" name="dodawanie" style="margin-top: 10%;" >
				<input type="text" name="tytul" placeholder="Wpisz tytuł"><br /><br />
				<textarea form="dodawanie" name="tresc" placeholder="Opis" cols="50" rows="15"></textarea><br /><br />
				<input type="file" name="zdjecie"><br /><br />
					<input type="submit" value="Wyślij">
			</form>
			<?php
				if(isset($_SESSION['dodano']))
				{
					echo "Dodano wpis";
				} 
				if (isset($_SESSION['niedodano'])) {
					echo "Nie dodano wpisu";
				}
			?>