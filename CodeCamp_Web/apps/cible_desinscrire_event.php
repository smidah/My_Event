<?php 
if(!isset($_SESSION))
	session_start(); 
?>
<?php


try {
	$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
}



if (isset($_POST) && !empty($_POST['desinscrire_event']) && !empty($_POST['id_evenement']) ) 
{	
	
		// On recupere les infos de l'user
	$req_utilisateur = $bdd->prepare('SELECT * FROM utilisateur WHERE login = ?');
	$req_utilisateur->execute(array($_SESSION['login']));
	$donnees_utilisateur = $req_utilisateur->fetch();


		// On prepare la requete pour verifier s l'utilisateur participe deja a l'evenement
	$req_all_event = $bdd->prepare('SELECT * FROM utilisateur_evenement WHERE id_utilisateur = ?');

		//  Si on trouve son ID on continue
	if ($req_all_event->execute(array($donnees_utilisateur['id'])))
	{
		while ($donnees_event = $req_all_event->fetch())
		{
				// Si l'id_evenement et l'id_utilisateur son egaux avec les valeur envoye, avec le formulaire alors on cree la variable $deja_inscrit
			if ($donnees_event['id_evenement'] == $_POST['id_evenement'] 
				&& $donnees_event['id_utilisateur'] ==  $donnees_utilisateur['id'])
			{
					// On verifie qu'il reste encore de la place dans l'evenement 
				$req_event = $bdd->prepare('SELECT * FROM evenement WHERE id = ?');
				$req_event->execute(array($_POST['id_evenement']));
				$donnees_event_for_place = $req_event->fetch();


					// Si le nombre de participant est superieure a 0, on decremente le nombre de participant et on supprime la liaison entre l'even et l'utilisateur
				if ($donnees_event_for_place['nombre_participant'] > 0)
				{
					$delete_liaison = $bdd->prepare('DELETE FROM utilisateur_evenement WHERE id = ?');
					$delete_liaison->execute(array($donnees_event['id']));

						// On decremente le nombre de place de l'evenement
					$nombre_participant = $donnees_event_for_place['nombre_participant'] - 1;

						// On insert ce nouveau nombre dans l'evenement
					$req_decre_place = $bdd->query('UPDATE evenement
						SET nombre_participant = "'.$nombre_participant.'" WHERE id="'.$_POST['id_evenement'].'"');

					echo '<div id="popup_momo" class="alert alert-dismissible alert-success" style="border-radius: 3px; position:fixed; width: 30%; text-align:center;left:35%;top:40%;z-index:100">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>Vous etes desinscrit de l\'Event !
				</div>';

			}

		}
	}
}	

}


?>