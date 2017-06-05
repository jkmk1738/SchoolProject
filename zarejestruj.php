        <form action="rejestruj.php" method="POST">
        Login:<input type="text" name="login"><br><br>
        Hasło:<input type="password" name="pass"></br></br>
        <input type="submit" name="zarejestruj" value="Zarejestruj" style="margin-top: 5px; text-align: center;">
        </form>
        <?php
        if (isset($_SESSION['zarejestrowano'])) {
          echo "Dodano użytkownika";
        }
  			if (isset($_SESSION['bladr'])) {
  				echo $_SESSION['bladr'];
  			}
  		?>
