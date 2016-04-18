<?php
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}


	if (isset($_POST) && !empty($_POST['id_reponse']) || !empty($_POST['id_question']))
	{
		$req_supp_question = $bdd->prepare('DELETE FROM question WHERE id= ?');
		$req_supp_question->execute(array($_POST['id_question']));

		$req_supp_reponse = $bdd->prepare('DELETE FROM reponse WHERE id= ?');
		$req_supp_reponse->execute(array($_POST['id_reponse']));

		echo '<div id="popup_momo" class="alert alert-dismissible alert-success" style="border-radius: 3px; position:fixed; width: 30%; text-align:center;left:35%;top:40%;z-index:100"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>Question supprimé !</div>';

		header("Location: ../includes/mailbox.php");
	}
?>