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
	if (isset($_POST)) {
		if (isset($_POST['email']) && !empty($_POST['email'])) {
			$update = $bdd->query('UPDATE utilisateur SET email = "'. $_POST['email'] .'" WHERE login = "'. $_SESSION['login'] .'"');
		}
		if (isset($_POST['telephone']) && !empty($_POST['telephone']))
			$update = $bdd->query('UPDATE utilisateur SET telephone = "'. $_POST['telephone'] .'" WHERE login = "'. $_SESSION['login'] .'"');
		if (isset($_POST['agence']) && !empty($_POST['agence']))
			$update = $bdd->query('UPDATE utilisateur SET agence = "'. $_POST['agence'] .'" WHERE login = "'. $_SESSION['login'] .'"');
	}

	header("Location: ../includes/dashboard.php");
?>