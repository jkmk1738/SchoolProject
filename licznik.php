<?php session_start(); ?>  <!-- Musi znajdować się na samym początku pliku! -->
<?php

include("connect.php");  //Wczytywanie pliku polaczenie.php

@mysql_connect($host, $db_user, $db_password) or Die ("Błąd połączenia z bazą danych");
@mysql_select_db($db_name) or Die ("Nazwa bazy danych jest błędna");

mysql_query("SET NAMES 'latin2'");  //Kodowanie bazy danych
$date = date('Y-m-d');    //Data Rok-Miesiąc-Dzień
$time = date('H:i:s');    //Czas Godzina:Minuta:Sekunda
$ip = $_SERVER['REMOTE_ADDR']; //Pobiera IP odwiedzającego
$link = mysql_query("SELECT ip FROM online WHERE ip='$ip' and data='$date'"); //Zapytanie.
$ile = mysql_num_rows($link); //Pobiera ilość wyników
if ($ile == 0) {   //Jeżeli ilość wyników = 0
    $asd = mysql_query("INSERT INTO online SET ip='$ip', data='$date', godzina='" . date('H') . "', minuta='" . date('i') . "'"); //Dodaje do tabeli dane

    if (!$asd) {  //Jeżeli nie udało się dodać naszych danych
        echo('Błąd bazy danych. <br />'); //Pojawia się komunikat o błędzie
    }
} else { //Jeżeli ilość wyników <> 0
    $asd = mysql_query("UPDATE online SET data='$date', godzina='" . date('H') . "', minuta='" . date('i') . "' WHERE ip='$ip' and data='$date'"); //Odświeża dane użytkownika w tabeli

    if (!$asd) { //Jeżeli nie udało się odświerzyć naszych danych
        echo('Blad bazy danych. <br />'); //Pojawia się komunikat o błędzie
    }
}

$wczoraj = (int) date('d'); //Pobiera dzień
$wczoraj = $wczoraj - 1;  //odejmuje 1 dzień
$miesiac = (int) date('m'); //Pobiera miesiąc
if ($wczoraj == 0) { //Jeżeli wczoraj = 0
    if (date('m') == 4 || date('m') == 6 || date('m') == 8 || date('m') == 9 || date('m') == 11) {
        $wczoraj = "31";
        $miesiac -= "1";
    }
    if (date('m') == 3) {
        $wczoraj = "28";
        $miesiac -= "1";
    }
    if (date('m') == 5 || date('m') == 7 || date('m') == 10 || date('m') == 12) {
        $wczoraj = "30";
        $miesiac -= "1";
    }
    if (date('m') == 2) {
        $wczoraj = "31";
        $miesiac -= "12";
    }
}
if ($wczoraj <= 9) { //Jeżeli wczoraj jest mniejsze lub równe 9
    $wczoraj = "0" . $wczoraj;
}
if ($miesiac <= 9) { //Jeżeli miesiac jest mniejsze lub równe 9
    $miesiac = "0" . $miesiac;
}
$wczoraj = date('Y') . "-" . $miesiac . "-" . $wczoraj;

$time = date('H'); //Pobiera godzine
$time2 = date('i') - 5; //Pobiera minuty odejmując 5
$link = mysql_query("SELECT * FROM online"); //Pobiera dane z tabeli 'online'
$online = 0; //ustawia zmienna na = 0
$dzis = 0; //ustawia zmienna na = 0
$wczorajlicz = 0; //ustawia zmienna na = 0
while ($wynik = mysql_fetch_array($link)) { //Pętla
    if ($wynik['data'] == $date) { //jeżeli wynik równa się z dzisiejszą datą
        if ($wynik['godzina'] >= $time) { //
            if ($wynik['minuta'] >= 5) { //jeżeli wynik minut jest większy lub równy od 5
                $minuta = $wynik['minuta'] - 5;
            } else {
                $minuta = $wynik['minuta'];
            }
            if ($minuta >= $time2) { 
                $online++; //Dodaje osobę online
            }
        }
        $dzis++; //Dodaje osobę odwiedzającą do dziś
    }
    if ($wynik['data'] == $wczoraj) {
        $wczorajlicz++; //dodaje osobę odwiedzającą do wczoraj
    }
    $all++; //Dodaje osobę do wszystkich
}
echo('Osób Online: ' . $online . '<br />'); //Wyświetla tekst
echo('Dzisiaj było: ' . $dzis . '<br />'); //Wyświetla tekst
echo('Wczoraj było: ' . $wczorajlicz . '<br />'); //Wyświetla tekst
echo('Wszystkich razem było: ' . $all . '<br />'); //Wyświetla tekst
?>