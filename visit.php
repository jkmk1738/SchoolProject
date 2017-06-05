<?php
/*
author:Józef Kańczugowski, www.teacher.webd.pl, Programy komputerowe dla nauczycieli, 12.11.2012
*/
	function skrypt_jest_wykonywany()
	{
		if (!file_exists('skrypt_jest_wykonywany.txt')) return false;		
		@$plik=fopen('skrypt_jest_wykonywany.txt','r'); if (!$plik) return true;
		flock($plik, LOCK_SH);
		$tekst_z_pliku=fread($plik, filesize('skrypt_jest_wykonywany.txt'));
		if ($tekst_z_pliku=='skrypt_jest_wykonywany') return true; else return false;
		flock($plik, LOCK_UN);
		fclose($plik);
	}
	
	function zapisz_ze_skrypt_jest_wykonywany($jest_wykonywany)
	{
		@$plik=fopen('skrypt_jest_wykonywany.txt','w'); if (!$plik) return;
		flock($plik, LOCK_EX);
		if ($jest_wykonywany) fwrite($plik,'skrypt_jest_wykonywany'); else fwrite($plik,'skrypt_nie_jest_wykonywany');
		flock($plik, LOCK_UN);
		fclose($plik);
	}		
		
	function ip_goscia_jest_w_pliku($ip_goscia,$sciezka_pliku)
	{
		if (!file_exists($sciezka_pliku)) return false;
		@$plik=fopen($sciezka_pliku,'r'); if (!$plik) return true;//zwiększymy licznik tylko w przypadkach sprawdzonych
		flock($plik, LOCK_SH);

		$jest=false;
		while(!feof($plik)) 
		{
			$linia_pliku=fgets($plik,32);

		   if (trim($linia_pliku) == trim($ip_goscia)) 
		   {
		   	$jest=true;
		   	break;
		   }
		}	
		flock($plik, LOCK_UN);
		fclose($plik);
		
		return $jest;
	}
			
	function ip_goscia_zapisano_w_pliku($ip_goscia,$sciezka_pliku,$zeruj_plik) 
	{
		if ($zeruj_plik ) @$plik=fopen($sciezka_pliku,'w'); else @$plik=fopen($sciezka_pliku,'a');
		if (!$plik) return false;
		flock($plik, LOCK_EX);
		$ip_goscia=$ip_goscia."\n";
		fwrite($plik,$ip_goscia,strlen($ip_goscia));		
		flock($plik, LOCK_UN);
		fclose($plik);
		return true;
	}

	function odwiedziny_z_pliku($sciezka_pliku,& $odwiedziny)
	{
		@$plik=fopen($sciezka_pliku,'r'); if (!$plik) return false;
		flock($plik, LOCK_SH);

		$tekst_z_pliku=fread($plik, filesize($sciezka_pliku));
		$tablica_z_pliku=explode("\t",$tekst_z_pliku);		

		$odwiedziny=array('dzien','miesiac','rok','w_dniu','w_miesiacu','w_roku');
		$odwiedziny['dzien']=$tablica_z_pliku[0];
		$odwiedziny['miesiac']=$tablica_z_pliku[1];
		$odwiedziny['rok']=$tablica_z_pliku[2];
		$odwiedziny['w_dniu']=$tablica_z_pliku[3];
		$odwiedziny['w_miesiacu']=$tablica_z_pliku[4];
		$odwiedziny['w_roku']=$tablica_z_pliku[5];
		
		flock($plik, LOCK_UN);
		fclose($plik);
		return true;
	}	
	
	function odwiedziny_do_pliku($sciezka_pliku,$odwiedziny)
	{
		@$plik=fopen($sciezka_pliku,'w'); if (!$plik) return false;
		flock($plik, LOCK_EX);

		$tekst_do_pliku=$odwiedziny['dzien']."\t".$odwiedziny['miesiac']."\t".$odwiedziny['rok']."\t".$odwiedziny['w_dniu']."\t"
								.$odwiedziny['w_miesiacu']."\t".$odwiedziny['w_roku'];
		fwrite($plik, $tekst_do_pliku);
		
		flock($plik, LOCK_UN);
		fclose($plik);
		return true;
	}	
	
	function poczatkowa_wartosc_odwiedzin()
	{
		$dzis=getdate();
		$d=$dzis['mday']; 
		$m=$dzis['mon']; 
		$r=$dzis['year']; 

		$odwiedziny=array('dzien','miesiac','rok','w_dniu','w_miesiacu','w_roku');
		$odwiedziny['dzien']=$d;
		$odwiedziny['miesiac']=$m;
		$odwiedziny['rok']=$r;

		$odwiedziny['w_dniu']=0;
		$odwiedziny['w_miesiacu']=0;
		$odwiedziny['w_roku']=0;
		
		return($odwiedziny); 
	}
	
	if (skrypt_jest_wykonywany()) exit;
	zapisz_ze_skrypt_jest_wykonywany(true);

	if (!file_exists('odwiedziny.txt')) $odwiedziny_gosci=poczatkowa_wartosc_odwiedzin();
	else
	if (!odwiedziny_z_pliku('odwiedziny.txt',$odwiedziny_gosci)) $odwiedziny_gosci=poczatkowa_wartosc_odwiedzin();

	$ip_goscia = $_SERVER['REMOTE_ADDR'];
	if (!ip_goscia_jest_w_pliku($ip_goscia,'ip_gosci.txt') || !file_exists('ip_gosci.txt'))
	{
		$dzisiaj=getdate();
		$dzien=$dzisiaj['mday']; 
		$miesiac=$dzisiaj['mon']; 
		$rok=$dzisiaj['year']; 

		if ($dzien==$odwiedziny_gosci['dzien'] &&	$miesiac==$odwiedziny_gosci['miesiac'] && $rok==$odwiedziny_gosci['rok'])
		{
			$odwiedziny_gosci['w_dniu']++; 
			$odwiedziny_gosci['w_miesiacu']++; 
			$odwiedziny_gosci['w_roku']++; 
			ip_goscia_zapisano_w_pliku($ip_goscia,'ip_gosci.txt',false);
		}
		else
		{		
			if ($dzien!=$odwiedziny_gosci['dzien']) 
			{
				$odwiedziny_gosci['w_dniu']=1;
				$odwiedziny_gosci['dzien']=$dzien;
				ip_goscia_zapisano_w_pliku($ip_goscia,'ip_gosci.txt',true);
			} 
			
			if ($miesiac!=$odwiedziny_gosci['miesiac']) 
			{
				$odwiedziny_gosci['w_miesiacu']=1;
				$odwiedziny_gosci['miesiac']=$miesiac;
			}
			
			if ($rok!=$odwiedziny_gosci['rok']) 
			{
				$odwiedziny_gosci['w_roku']=1;
				$odwiedziny_gosci['rok']=$rok;
			}
		}

		odwiedziny_do_pliku('odwiedziny.txt',$odwiedziny_gosci);
	}

	echo 'Dzisiaj: '.$odwiedziny_gosci['w_dniu'].'<br />
		W tym miesiącu: '.$odwiedziny_gosci['w_miesiacu'].'<br />
		W tym roku '.$odwiedziny_gosci['w_roku'];

	zapisz_ze_skrypt_jest_wykonywany(false);
?>