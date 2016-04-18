<?php
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}


	if (isset($_POST) && isset($_POST['envoi_reponse']) && !empty($_POST['id_evenement']) ) 
	{

		$req_verif_reponse = $bdd->prepare('SELECT * FROM reponse');
		$req_verif_reponse->execute();

		while ($donnees_reponse = $req_verif_reponse->fetch())
		{
			if ($donnees_reponse['id_createur'] == $_POST['id_createur'] 
				&& $donnees_reponse['id_evenement'] == $_POST['id_evenement'])
			{
				$sav_id = $donnees_reponse['id'];
				$reponse_existe = true;
			}
		}

		$date = date('Y-m-d H:i:s');

		if (!isset($reponse_existe))
		{
			$req_insert_reponse = $bdd->prepare('INSERT INTO reponse 
												(id_utilisateur,
												id_createur,
												id_evenement,
												id_question,
												reponse,
												date_creation)
												VALUES
												(:id_utilisateur,
												:id_createur,
												:id_evenement,
												:id_question,
												:reponse,
												:date_creation)');

			$req_insert_reponse->execute(array('id_utilisateur' => $_POST['id_utilisateur'],
												'id_createur' => $_POST['id_createur'],
												'id_evenement' => $_POST['id_evenement'],
												'id_question' => $_POST['id_question'],
												'reponse' => $_POST['reponse'],
												'date_creation' => $date));
		}

		else if (isset($reponse_existe))
		{
			$req_pre_insert = $bdd->prepare('UPDATE reponse SET
											reponse = ?
											WHERE id= ?');

			$req_pre_insert->execute(array($_POST['reponse'],
											$sav_id));

		}

		header('Location: ../includes/mailbox.php');

	}
?>