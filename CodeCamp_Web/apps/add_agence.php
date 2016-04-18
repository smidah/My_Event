<?php 
try {
	$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123');
}
catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
}
?>
<?php
session_start();
$req_agence = $bdd->query('SELECT * FROM agence WHERE nom_agence = "'.  $_POST["agence"]. '"');
$res = $req_agence->fetch();

if (isset($_POST) && !empty($_POST) && (!$res['nom_agence'])) {
	echo "werwe";
	$req_pays = $bdd->query('SELECT * FROM pays WHERE nom = "'.  $_POST["pays"]. '"');
	$res = $req_pays->fetch();
	if (!$res['nom']) {
		$bdd->query('INSERT INTO pays (nom) VALUES ("'. $_POST['pays'] .'")');
	}
	$req_pre = $bdd->prepare('INSERT INTO agence (nom_agence, pays_agence) 
		VALUES (:nom_agence, :pays_agence)');

	$req_pre->execute(array(
		'nom_agence' => $_POST['agence'],
		'pays_agence' => $_POST['pays']
		));
}
header('Location: ../includes/dashboard.php');
?>