<?php
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}


	if (isset($_POST) && isset($_POST['envoi_question']) && !empty($_POST['id_evenement']) ) 
	{
		$date = date('Y-m-d H:i:s');


		$req_insert_question = $bdd->prepare('INSERT INTO question 
											(id_utilisateur,
											id_createur,
											id_evenement,
											question,
											date_creation)
											VALUES
											(:id_utilisateur,
											:id_createur,
											:id_evenement,
											:question,
											:date_creation)');

		$req_insert_question->execute(array('id_utilisateur' => $_POST['id_utilisateur'],
											'id_createur' => $_POST['id_createur'],
											'id_evenement' => $_POST['id_evenement'],
											'question' => $_POST['question'],
											'date_creation' => $date));

		header('Location: ../includes/mailbox.php');

	}
?>