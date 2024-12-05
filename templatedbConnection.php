<?php
namespace DB;
class DBAccess {
	//Metti tutti i file della cartella su filezilla, da html a php 
//per mettere un file con file zilla si mette nel campo host: sftp://tecweb.studenti.math.unipd.it, nome utente  e passoword sono quelli del lab. si mettono i file php nella cartella publi_html
	private const HOST_DB = "localhost";
	private const DATABASE_NAME = "rpontell";
	private const USERNAME = "rpontell";
	private const PASSWORD = "jiec5Aeyeapei4bu";

	private $connection;

	public function openDBConnection() {
		//versione alternativa
		mysqli_report(MYSQLI_REPORT_ERROR /*| MYSQLI_REPORT_STRICT*/); /*nel primo caso vengono create delle stringhe di errore, nel secondo solleva un eccezione e quindi si gestisce con try catch */

		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);

		//debug
		return mysqli_connect_error(); /*va bene in fase di debug ma non in produzione , la stringa che ritorna va valutata: se vuota tutto ok, se piena allora c'e' un errore */
		/*
		//produzione, versione ad oggetti
		if(mysqli_connect_errno()){
			return false;
		} else{
			return true;
		}*/
	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}


	public function getList() {
		/*prendo i dati per creare un array associativo*/
		$query = "SELECT * FROM giocatrici ORDER BY ID ASC";
		//versione procedurale
		$queryResult = mysqli_query($this->connection, $query) or die("Errore in openDBConnection: ". mysqli_error($this->connection)); /*errore va sul log, non e' indicato il die ma qui dobbiamo far veloce */
		
		if(mysqli_num_rows($queryResult) == 0){
			return null;
		}else{
			$result = array();
			while ($row=mysli_fetch_assoc($queryResult)){
				array_push($result, $row);
			}
			$queryResult->free();
			return $result;
		}
	}

	public function insertNewElement($nome, $capitano, $dataNascita, $luogo, $squadra, $ruolo, $altezza, $maglia, $magliaNazionale, $punti, $riconoscimenti, $note) {
		$queryInsert = "INSERT INTO giocatrici(nome, capitano, dataNascita, luogo, squadra, ruolo, altezza, maglia, magliaNazionale, punti, riconoscimenti, note) 
						VALUES(\"$nome\", \"$capitano\", \"$dataNascita\", \"$luogo\", \"$squadra\", \"$ruolo\", $altezza, $maglia, $magliaNazionale, $punti, \"$riconoscimenti\", \"$note\")";
		/*il \" serve a dire a php che deve leggere le " come carattere e non come sintassi di codice */
	}

	
}


?>