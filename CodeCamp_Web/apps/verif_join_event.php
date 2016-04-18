<?php


	// On prepare la requete pour verifier s l'utilisateur participe deja a l'evenement
	$req_all_event = $bdd->prepare('SELECT * FROM utilisateur_evenement WHERE id_utilisateur = ?');

			//  Si on trouve son ID on continue
	if ($req_all_event->execute(array($result['id'])))
	{echo "momo";
		while ($donnees_event = $req_all_event->fetch())
		{echo "boucle";
			// Si l'id_evenement et l'id_utilisateur son egaux avec les valeur envoye, avec le formulaire alors on cree la variable $deja_inscrit
			if ($donnees_event['id_evenement'] == $whatevent 
				&& $donnees_event['id_utilisateur'] ==  $result['id'])
			{
				$deja_inscrit_event = true;
			}
		}
	}

?>