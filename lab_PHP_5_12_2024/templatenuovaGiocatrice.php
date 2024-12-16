<?php 

require_once "dbConnection.php";
use DB\DBAccess;

$paginaHTML = file_get_contents('nuovaGiocatrice.html');

$messaggiPerForm = "";

$nome = '';
$capitano = 0; 
$dataNascita = ''; 
$luogo = '';
$altezza = ''; 
$squadra = ''; 
$maglia = '';
$magliaNazionale = '';
$ruolo = '';
$punti = '';
$riconoscimenti = '';
$note = '';

$tagPermessi ='<em><strong><ul><li>';

function pulisciInput($value){
 	// elimina gli spazi
 	$value = trim($value);
 	// rimuove tag html (non sempre è una buona idea!) 
  	$value = strip_tags($value);
  	// converte i caratteri speciali in entità html (ex. &lt;)
	$value = htmlentities($value);
  	return $value;
}

function pulisciNote($value){
	global $tagPermessi;		// PHP è stupido e ha bisgno che gli specifichi che è la variabile globale
 	// elimina gli spazi
 	$value = trim($value);
 	// rimuove solo alcuni tag html 
  	$value = strip_tags($value, $tagPermessi);
  	return $value;
}


if (isset($_POST['submit'])) {
	$nome=pulisciInput($_POST["nome"]);
	// controllare che ci siano solo lettere, spazi, e nomi con 2 caratteri
	// NOME E COGNOME
	if(strlen($nome)==0){
		$messaggiPerForm.="<li>Inserire il nome</li>";
	}
	else{
		if(preg_match("/\d/", $nome)){
			$messaggiPerForm.="<li>Nome e cognome non possono contenere numeri</li>";
		}
		else{
			if!(preg_match("/[\w\ ]+\s[\w\ ]+/", $nome){		// una o più ripetizioni di lettere o numeri (ma i numeri li abbiamo già esclusi prima) in due gruppi, divisi da uno spazio
				$messaggiPerForm.="<li>Inserire sia il nome che il cognome</li>";		// NOTA: non considera i cognomi composti, o chi ha più nomi o cognomi
			}
		}
	}
	// CAPITANO
	$capitano=pulisciInput($_POST["capitano"]);
	// DATA DI NASCITA
	$dataNascita=pulisciInput($_POST["dataNascita"]);
	// LUOGO DI NASCITA
	$luogo=pulisciInput($_POST["luogo"]);
	if(strlen($luogo)==0){
		$messaggiPerForm.="<li>Luogo di nascita non presente</li>";
	}
	else{
		if(preg_match("/\d/", $luogo)){
			$messaggiPerForm.="<li>Il luogo di nascita non può contenere numeri</li>";
		}
	}
	// ALTEZZA
	$altezza=pulisciInput($_POST["altezza"])
	if(strlen($altezza)==0){
		$messaggiPerForm.="<li>Altezza non presente</li>";
	}
	else{
		if(!(ctype_digit($altezza) && ($altezza>129))){
			$messaggiPerForm.="<li>L\'altezza deve essere un numero maggiore o uguale di 130</li>";
		}
	}
	// SQUADRA IN CAMPIONATO
	$squadra=pulisciInput($_POST["squadra"])
	if(strlen($squadra)==0){
		$messaggiPerForm.="<li>Inserire la squadra in campionato</li>";
	}
	// MAGLIA
	$maglia=pulisciInput($_POST["maglia"])
	if(strlen($maglia)==0){
		$messaggiPerForm.="<li>Inserire la maglia</li>";
	}
	else{
		if (!ctype_digit($maglia)) {
            $messaggiPerForm .= "<li>Il numero di maglia deve essere un numero intero</li>";
        }
	}
	// MAGLIA IN NAZIONALE
	$magliaNazionale=pulisciInput($_POST["magliaNazionale"])
	if(strlen($magliaNazionale)==0){
		$messaggiPerForm.="<li>Inserire la maglia in nazionale</li>";
	}
	else{
		if (!ctype_digit($magliaNazionale)) {
			$messaggiPerForm .= "<li>Il numero di maglia in nazionale deve essere un numero intero</li>";
		}
	}
	// PUNTI/RICEZIONI
	$punti=pulisciInput($_POST["punti"])
	if(strlen($punti)==0){
		$messaggiPerForm.="<li>Inserire i/le punti/ricezioni</li>";
	}
	else{
		if (!ctype_digit($punti)) {
            $messaggiPerForm .= "<li>I punti o le ricezioni devono essere un numero intero</li>";
        }
	}
	// RICONOSCIMENTI	--> non so cosa mettere
    $riconoscimenti = pulisciInput($_POST["riconoscimenti"]);
    if (strlen($riconoscimenti) == 0) {
        $messaggiPerForm .= "<li>Inserire eventuali riconoscimenti</li>";
    }
	// NOTE	--> non so cosa mettere
    $note = pulisciInput($_POST["note"]);
    if (strlen($note) == 0) {
        $messaggiPerForm .= "<li>Inserire eventuali note aggiuntive</li>";
    }

	$messaggiPerForm.="</ul>";
}
	
$paginaHTML = str_replace('[messaggiForm]', $messaggiPerForm, $paginaHTML);
$paginaHTML = str_replace('[valoreNome]', $nome, $paginaHTML);
$paginaHTML = str_replace('[valData]', $dataNascita, $paginaHTML);
$paginaHTML = str_replace('[valLuogo]', $luogo, $paginaHTML);
$paginaHTML = str_replace('[valoreAltezza]', $altezza, $paginaHTML);
$paginaHTML = str_replace('[valoreSquadra]', $squadra, $paginaHTML);
$paginaHTML = str_replace('[valoreMaglia]', $maglia, $paginaHTML);
$paginaHTML = str_replace('[valRuolo]', $ruolo, $paginaHTML);
$paginaHTML = str_replace('[valoreMagliaNazionale]', $magliaNazionale, $paginaHTML);
$paginaHTML = str_replace('[valorePunti]', $punti, $paginaHTML);
$paginaHTML = str_replace('[valoreRiconoscimenti]', $riconoscimenti, $paginaHTML);
$paginaHTML = str_replace('[valoreNote]', $note, $paginaHTML);

echo $paginaHTML;

?>