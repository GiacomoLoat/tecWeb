<?php
namespace DB;

class DBAccess {
	
	//fileZilla: 
			//HOST: sftp://tecweb.studenti.unipd.it
			//UTENTE: tclaut
			//PASSWORD: quella del lab
			//PORTA: 22 (non dovrebbe essere importante, ma mettendo 22 ha funzionato)
	//PUTTY: 
			//apri il CMD e scrivi putty
			//su putty scrivi tecweb
			//fai login con le credenziali del lab

	private const HOST_DB = "localhost";
	private const DATABASE_NAME = "tclaut";
	private const USERNAME = "tclaut";
	private const PASSWORD = "Aidaej5eiz2fai5g";

	private $connection;

	public function openDBConnection() {

		//mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
		//MYSQLI_REPORT_ERROR --> restituisce una stringa con le informazioni dell'errore, ma il codice continua
		//MYSQLI_REPORT_STRICT --> deve essere gestito tramite try catch, e il codice si interrompe
		mysqli_report(MYSQLI_REPORT_ERROR);

		$this->connection = mysqli_connect(DBAccess::HOST_DB, DBAccess::USERNAME, DBAccess::PASSWORD, DBAccess::DATABASE_NAME);		//effettuo la connessione al database

		//mysqli_connect_error(); --> restituisce una stringa contenente le informazioni dell'errore (vuota se non ci sono errori)
		//return mysqli_connect_error(); --> funziona all'opposto, ritorna NULL se la stringa é non vuota

		//da usare solo durante la produzione, non nel prodotto finito
		/*if(mysqli_connect_errno()){		//controllo se la connessione é andata a buon fine errno = no errori
			return false;
		}
		else{
			return true;
		}*/
	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}


	public function getList() {
		$query="SELECT * FROM giocatrici ORDER BY ID ASC";

		$queryResult=mysqli_query($this->connection, $query or die("Errore in openDBconnection: ".mysqli_error($this->connection)));
		
		if(mysqli_num_rows($queryResult)==0){return null;}
		else{
			$result=array();
			while($row=mysqli_fetch_assoc($queryResult)){
				array_push($result, $row);
			}
			$queryResult->free();
			return $result;
		}
	}

	public function insertNewElement($nome, $capitano, $dataNascita, $luogo, $squadra, $ruolo, $altezza, $maglia, $magliaNazionale, $punti, $riconoscimenti, $note) {
		$queryInsert="INSERT INTO giocatrici(nome, capitano, dataNasscita, luogo, squadra, ruolo, altezza, maglia, magliaNazionale, punti, rionoscimenti, note) VALUES (\"$nome\", \"$capitano\", \"$dataNasscita\", \"$luogo\", \"$squadra\", \"$ruolo\", $altezza, $maglia, $magliaNazionale, $punti, \"$rionoscimenti\", \"$note\")";
		//$nome="Alessia Danesi" --> senza \ prima delle ", queste virgolette darebbero problemi
	
	}

	
}


?>	