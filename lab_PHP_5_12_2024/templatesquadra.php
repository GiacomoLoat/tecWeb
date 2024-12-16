<?php

require_once ".." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'php'. DIRECTORY_SEPARATOR . 'squadra_php.html');	//importante usare DIRECTORY_SEPARATOR, in quanto varia a seconda del OS

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$giocatrici = "";
$stringaGiocatrici = "";

if (!$connessioneOK) {				//in fase di produzione si mette spesso !$connessioneOK
	$giocatrici=$connessione->getList();
	$connessione->closeConnection();		//chiudo la connessione, subito dopo aver finito le operazioni sul database
	//$stringaGiocatrici;
	if(count($giocatrici)>0){
		$stringaGiocatrici='<dl class="giocatrici">';
		foreach($giocatrici as $giocatrice){
			$stringaGiocatrici .='<dt>'.$giocatrice['nome'].'</dt>';
			if($giocatrice['capitano']){
				$stringaGiocatrici .= "- <em>Capitano</em>"
			}
			$stringaGiocatrici .='</dt>'
			.'<dd><img src="'.$giocatrice['immagine'].'" alt="">'
			.'<dl classe="giocatrice"><dt>Data di nascita</dt><dd>'$giocatrice["dataNascita"].'</dd>'
			//luogo 	squadra		 ruolo 		altezza 	maglia 		maglia_nazionale
			.'<dt>Luogo</dt><dd>'$giocatrice['luogo'].'</dd>'
			.'<dt>Squadra</dt><dd>'$giocatrice['squadra'].'</dd>'
			.'<dt>Ruolo</dt><dd>'$giocatrice['ruolo'].'</dd>'
			.'<dt>Altezza</dt><dd>'$giocatrice['altezza'].'</dd>'
			.'<dt>Numero di maglia</dt><dd>'$giocatrice['maglia'].'</dd>'
			.'<dt>Numero di maglia in nazionale</dt><dd>'$giocatrice['magliaNazionale'].'</dd>';
			if($giocatrice['ruolo']!='Libero'){
				$stringaGiocatrici.='<dt>Punti Totali</dt>'.'<dd>'.$giocatrice['punti'].'</dd>'
			}
			else{
				$stringaGiocatrici.='<p>Nessuna giocatrice presente nel database</p>'
			}
		}
	}
} else {
	$stringaGiocatrici = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";
}
echo str_replace("[listaGiocatrici]", $stringaGiocatrici, $paginaHTML);

?>