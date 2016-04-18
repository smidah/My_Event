<?php
$req = $bdd->query('select * from utilisateur where login="'.$_SESSION['login'].'"');
$req->setFetchMode(PDO::FETCH_OBJ);
$result = $req->fetch();
if ($result->role == 4)
	header("location: ../index.php");

if (isset($_POST) && !empty($_POST['supp_event'])) 
{	
	// Desactivation du Foreinkey pour pouvoir supprimer es evenement
	$req_disable_foreinkey = $bdd->query('SET FOREIGN_KEY_CHECKS=0');

	// Suppression de l'event
	$req_supp_event = $bdd->prepare('DELETE FROM evenement WHERE id = ?');
	$req_supp_event->execute(array($_POST['supp_event']));

	// Suppression des gens inscrit a l'event
	$req_supp_listing = $bdd->prepare('DELETE FROM utilisateur_evenement WHERE id_evenement = ?');
	$req_supp_listing->execute(array($_POST['supp_event']));

	$req_supp_commentaire = $bdd->prepare('DELETE FROM commentaire WHERE id_evenement = ?');
	$req_supp_commentaire->execute(array($_POST['supp_event']));

	// Reactivation de l'event 
	$req_enable_foreinkey = $bdd->query('SET FOREIGN_KEY_CHECKS=1');

	header("Location: events.php");
}

else if(isset($_POST) && !empty($_POST['titre']))
{

		// On verifie si un fichier a ete upload
	if (isset($_FILES['image']) && $_FILES['image']['error'] == 0 )
	{
		if ($_FILES['image']['size'] <= 5000000) 
		{
				// Extension autorisees
			$extension_autorisees = array('jpg','gif','png','jpeg');

				// On recupere l'extension du fichier upload
			$infos_fichier = pathinfo($_FILES['image']['name']);
			$extension_du_fichier = $infos_fichier['extension'];


			if (in_array($extension_du_fichier, $extension_autorisees))
			{
					// Recuperation la valeur du compteur dans la table 'compteur_upload_image'
				$req_count = $bdd->query('SELECT compteur FROM compteur_upload_image WHERE id="1"');
				$reponse = $req_count->fetch();

					// Incrementation de l'ID
				$id_fichier = $reponse[0] + 1;

					// On definie le nom du fichier via som ID et son Extension
				$nom_du_fichier = $id_fichier . '.' . $extension_du_fichier;


					// On upload l'image dans la bdd
				if (move_uploaded_file($_FILES['image']['tmp_name'], '../upload_image/' .$nom_du_fichier))
				{	

						// Suppresion de l'ancienne image
					if ($_POST['image'] != NULL)
						unlink($_POST['image']);


					$image = '../upload_image/'.$nom_du_fichier;

						// Incrementation de l'ID dans le compteur_uplod_image
					$inc_compteur_upload_image = $bdd->query('UPDATE compteur_upload_image
						SET compteur = "'.$id_fichier.'" WHERE id="1"');


					$date = date('Y-m-d H:i:s');

						// Ajout de l'evenement lie a l'image
					$req_pre_insert = $bdd->prepare('UPDATE evenement SET
						titre = ?,
						lieu = ?, 
						agence = ?, 
						date_evenement = ?, 
						heure_evenement = ?, 
						nombre_place = ?, 
						descriptif = ?,
						categorie = ?,
						visio_conference = ?,
						payant = ?,
						prix = ?,
						email_contact = ?,
						date_modification = ?,
						url = ?,
						image = ?
						WHERE id= ?');

					$req_pre_insert->execute(array(
						$_POST['titre'],
						$_POST['lieu'],
						$_POST['agence'],
						$_POST['date_evenement'],
						$_POST['heure_evenement'],
						$_POST['nombre_place'],
						$_POST['descriptif'],
						$_POST['categorie'],
						$_POST['visio_conference'],
						$_POST['payant'],
						$_POST['prix'],
						$_POST['email_contact'],
						$date,
						$_POST['url'],
						$image,
						$_POST['id']
						));

					header("Location: modif_event.php");
				}

				else
				{
					echo "Erreur de l'upload de l'image <br/>";
				}

			}

			else
			{
				echo "L'extension n'est pas autorisé !";
			}
		}

		elseif ($_FILES['image']['size'] > 5000000) 
		{
			echo "Erreur l'image est trop volumineuse ! <br/>";
		}

	}

	else if(isset($_FILES['image']) && !empty($_FILES['image']['name']) && $_FILES['image']['error'] != 0 )
	{
		echo "Erreur de l'upload de l'image <br/>";
	}

	else if(isset($_POST) && !empty($_POST['titre']) && empty($_FILES['image']['name']))
	{
		$date = date('Y-m-d H:i:s');

			// Ajout de l'evenement sans image
		$req_pre_insert = $bdd->prepare('UPDATE evenement SET
			titre = ?,
			lieu = ?, 
			agence = ?, 
			date_evenement = ?, 
			heure_evenement = ?, 
			nombre_place = ?, 
			descriptif = ?,
			categorie = ?,
			visio_conference = ?,
			payant = ?,
			prix = ?,
			email_contact = ?,
			date_modification = ?,
			url = ?
			WHERE id= ?');

		$req_pre_insert->execute(array(
			$_POST['titre'],
			$_POST['lieu'],
			$_POST['agence'],
			$_POST['date_evenement'],
			$_POST['heure_evenement'],
			$_POST['nombre_place'],
			$_POST['descriptif'],
			$_POST['categorie'],
			$_POST['visio_conference'],
			$_POST['payant'],
			$_POST['prix'],
			$_POST['email_contact'],
			$date,
			$_POST['url'],
			$_POST['id']
			));

		header("Location: events.php");
	}
}
?>
