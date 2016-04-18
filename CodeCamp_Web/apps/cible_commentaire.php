<?php

	try {
		$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}


	if (isset($_POST) && !empty($_POST['login_utilisateur']) && !empty($_POST['feedback_star']))  
	{

		$req_users = $bdd->prepare('SELECT id FROM utilisateur WHERE login = ?');
		$req_users->execute(array($_POST['login_utilisateur']));
		$donnees_utilisateur = $req_users->fetch();


		// Si un commentaire existe deja sur le meme event, on le supprime
		$req_commentaire = $bdd->prepare('SELECT * FROM commentaire WHERE id_utilisateur = ? AND id_evenement = ?');

		if ($req_commentaire->execute(array($donnees_utilisateur['id'], $_POST['id_evenement'])))
		{
			$donnees_commentaire = $req_commentaire->fetch();

			$req_supp = $bdd->prepare('DELETE FROM commentaire WHERE id = ?');
			$req_supp->execute(array($donnees_commentaire['id']));
		}
		

		$date = date('Y-m-d H:i:s');

		
		$req_insert_commentaire = $bdd->prepare('INSERT INTO commentaire 
												(id_utilisateur,
												id_evenement, 
												note,
												commentaire,
												date_creation) 
												VALUES 
												(:id_utilisateur, 
												:id_evenement, 
												:note, 
												:commentaire, 
												:date_creation)');

		$req_insert_commentaire ->execute(array('id_utilisateur' => $donnees_utilisateur['id'],
												'id_evenement' => $_POST['id_evenement'],
												'note' => $_POST['feedback_star'],
												'commentaire' => $_POST['commentaire'],
												'date_creation' => $date));

		echo '<div id="popup_momo" class="alert alert-dismissible alert-success" style="border-radius: 3px; position:fixed; width: 30%; text-align:center;left:35%;top:40%;z-index:100">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>Votre note a bien été envoyé !
			</div>';
	}
?>