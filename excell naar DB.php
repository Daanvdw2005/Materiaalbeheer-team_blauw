<?php

	// Verbinding maken met de database
	$servername = "localhost";  // Hostname
	$username = "username";      // Gebruikersnaam
	$password = "password";      // Wachtwoord
	$dbname = "database_name";   // Naam van de database

	// Maak verbinding met de database
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check of de verbinding is gelukt
	if ($conn->connect_error) {
		die("Verbinding mislukt: " . $conn->connect_error);
	}

	// Bestandpad naar de Excel-lijst
	$file = 'path/to/excel/file.xlsx';

	// Laad de PHPExcel bibliotheek
	require_once 'path/to/PHPExcel/Classes/PHPExcel.php';

	// Lees de Excel-lijst
	$objPHPExcel = PHPExcel_IOFactory::load($file);

	// Selecteer het actieve werkblad
	$sheet = $objPHPExcel->getActiveSheet();

	// Ga door elke rij van het werkblad
	foreach ($sheet->getRowIterator() as $row) {
		// Ga door elke cel in de rij
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);

		$values = array();
		foreach ($cellIterator as $cell) {
			// Voeg de waarde van de cel toe aan de array
			$values[] = $cell->getValue();
		}

		// Als er meer dan één cel is gevonden, voeg dan de rij toe aan de database
		if (count($values) > 1) {
			$sql = "INSERT INTO table_name (col1, col2, col3) VALUES ('".$values[0]."', '".$values[1]."', '".$values[2]."')";

			// Voer de query uit en check of deze is gelukt
			if ($conn->query($sql) === TRUE) {
				echo "Nieuwe rij toegevoegd aan de database";
			} else {
				echo "Error: " . $sql . "<br>" . $conn->error;
			}
		}
	}

	// Sluit de verbinding met de database
	$conn->close();

?>
