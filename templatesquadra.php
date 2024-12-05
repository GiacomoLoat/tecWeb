<?php

require_once ".." . DIRECTORY_SEPARATOR . "php". DIRECTORY_SEPARATOR . "templatedbConnection.php";

use DB\DBAccess;

$paginaHTML = file_get_contents('..' . DIRECTORY_SEPARATOR .'php'. DIRECTORY_SEPARATOR . 'squadra_php.html');

$connessione = new DBAccess();

$connessioneOK = $connessione->openDBConnection();

$giocatrici = $connessione->get_list();
if(count($giocatrici)>0){
	$stringaGiocatrici = '<dl class="giocatrici">'
	//in base alla situazione si puo' usare ' ' oppure \" per mettere le ""
	foreach($giocatrici as $giocatrice){
		$stringaGiocatrici .= '<dt>' . $giocatrice['nome'];
		if($giocatrice['capitano']){
			$stringaGiocatrici .= " - <em>Capitano</em>";
		}
		$stringaGiocatrici .= '</dl>'
	}
}
//oppure if($giocatrici != null)
$stringaGiocatrici = "";

//in fase di test si puo' mettere if (!$connessioneOK) per vedere la connessione e poi in fase di consegna si rimette apposto
if ($connessioneOK) {
	$stringaGiocatrici = "errore";

} else {
	$stringaGiocatrici = "<p>I sistemi sono momentaneamente fuori servizio, ci scusiamo per il disagio.</p>";
}
echo str_replace("[listaGiocatrici]", $stringaGiocatrici, $paginaHTML);

?>