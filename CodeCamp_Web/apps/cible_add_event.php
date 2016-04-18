<?php

	if(isset($_POST) && !empty($_POST['titre']))
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

						$image = '../upload_image/'.$nom_du_fichier;

						// Incrementation de l'ID dans le compteur_uplod_image
						$inc_compteur_upload_image = $bdd->query('UPDATE compteur_upload_image
						SET compteur = "'.$id_fichier.'" WHERE id="1"');


						$date = date('Y-m-d H:i:s');

						// Ajout de l'evenement lie a l'image
						$req_pre_insert = $bdd->prepare('INSERT INTO evenement 
												(titre,
												lieu, 
												agence, 
												date_evenement, 
												heure_evenement, 
												nombre_place, 
												descriptif,
												categorie,
												visio_conference,
												payant,
												prix,
												email_contact,
												id_createur,
												date_creation,
												url,
												image) 
												VALUES 
												(:titre, 
												:lieu, 
												:agence, 
												:date_evenement, 
												:heure_evenement, 
												:nombre_place, 
												:descriptif, 
												:categorie,
												:visio_conference,
												:payant,
												:prix,
												:email_contact,
												:id_createur,
												:date_creation,
												:url,
												:image)');

						$req_pre_insert->execute(array(
												'titre' => $_POST['titre'],
												'lieu' => $_POST['lieu'],
												'agence' => $_POST['agence'],
												'date_evenement' => $_POST['date_evenement'],
												'heure_evenement' => $_POST['heure_evenement'],
												'nombre_place' => $_POST['nombre_place'],
												'descriptif' => $_POST['descriptif'],
												'categorie' => $_POST['categorie'],
												'visio_conference' => $_POST['visio_conference'],
												'payant' => $_POST['payant'],
												'prix' => $_POST['prix'],
												'email_contact' => $_POST['email_contact'],
												'id_createur' => $_POST['id_createur'],
												'date_creation' => $date,
												'url' => $_POST['url'],
												'image' => $image
												));
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
			$req_pre_insert_2 = $bdd->prepare('INSERT INTO evenement 
									(titre,
									lieu, 
									agence, 
									date_evenement, 
									heure_evenement, 
									nombre_place, 
									descriptif,
									categorie,
									visio_conference,
									payant,
									prix,
									email_contact,
									id_createur,
									date_creation,
									url) 
									VALUES 
									(:titre, 
									:lieu, 
									:agence, 
									:date_evenement, 
									:heure_evenement, 
									:nombre_place, 
									:descriptif, 
									:categorie,
									:visio_conference,
									:payant,
									:prix,
									:email_contact,
									:id_createur,
									:date_creation,
									:url)');

			$req_pre_insert_2->execute(array(
									'titre' => $_POST['titre'],
									'lieu' => $_POST['lieu'],
									'agence' => $_POST['agence'],
									'date_evenement' => $_POST['date_evenement'],
									'heure_evenement' => $_POST['heure_evenement'],
									'nombre_place' => $_POST['nombre_place'],
									'descriptif' => $_POST['descriptif'],
									'categorie' => $_POST['categorie'],
									'visio_conference' => $_POST['visio_conference'],
									'payant' => $_POST['payant'],
									'prix' => $_POST['prix'],
									'email_contact' => $_POST['email_contact'],
									'id_createur' => $_POST['id_createur'],
									'date_creation' => $date,
									'url' => $_POST['url']
									));
		}
	}
?>