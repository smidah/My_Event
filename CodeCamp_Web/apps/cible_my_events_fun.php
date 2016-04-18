<?php

	// On prepare la requete pour recuperer les infos de lutilisateur
$req_utilisateur = $bdd->prepare('SELECT * FROM utilisateur WHERE login = ?');

	// Si la requete fonctionne on continue
if ($req_utilisateur->execute(array($_SESSION['login'])))
{
		// Variable avec toutes les donnees de l'utilisateur
	$donnees_utilisateur = $req_utilisateur->fetch();

		// On recupere les id des evenement auquel l'utilisateur participe
	$req_recup_id_event = $bdd->prepare('SELECT id_evenement FROM utilisateur_evenement WHERE id_utilisateur = ? ');
	

		// Si la requete fonctionne on continue
	if ($req_recup_id_event->execute(array($donnees_utilisateur['id'])))
	{

			// Boucle sur la Variable avec tout les id_evenement
		while ($id_evenement = $req_recup_id_event->fetch())
		{	

				// On recupere toutes les infos de l'evenement 
			$req_recup_event = $bdd->prepare('SELECT * FROM evenement WHERE id = ? AND categorie = ? AND date_evenement > NOW()');
			$req_recup_event->execute(array($id_evenement['id_evenement'],1));
			if ($donnees_event = $req_recup_event->fetch())
			{
				$date = new DateTime($donnees_event['date_evenement']);
				echo '<div class="col-md-12">
				<form method="GET" action="page_event.php" class="form-horizontal" style="margin: 0;">
				<div class="well" id="clayevent">
				<div class="row">';
				echo '<button style="text-align:left; margin: 0; padding: 0;border: none; background-color: transparent;text-decoration: none; color: inherit; outline: none;" type="submit" name="id" value="'.$donnees_event['id'].'">';
				echo '<div class="col-md-8">' .utf8_encode($donnees_event['titre']). '</div>';
				if ($donnees_event['categorie'] == 1)
					echo '<div class="col-md-4" style="color: #F2784B;"><i class="flaticon-celebrating"></i> Fun</div>';
				else if ($donnees_event['categorie'] == 0)
					echo '<div class="col-md-4" style="color: #D35400;"><span class="flaticon-business112"></span> Pro</div>';
				echo '<div class="col-md-12" style="color: #F2784B;"><blockquote style="font-size: 12px"><i class="material-icons">&#xE873;</i> '. substr(utf8_encode($donnees_event['descriptif']), 0, 50) .'[...]<small>Organisé par <cite title="Source Title" style="color: #F2784B;">'. $donnees_event['email_contact'] .'</cite></small></blockquote></div>';
				echo '<div class="col-md-3 col-md-offset-9"><small style="font-family: gotham; color: #F2784B">'.$date->format('d/m/Y') . ' à '. $donnees_event['heure_evenement'] .'</small></div>';
				echo '</div>
				</div>
				</button>
				</form>
				</div>';


					// Si un evenement a ete trouver un declare la variable $verif
				$verif_1 = true;
			}
		}

			// Si verif n'existe pas donc, l'utilisateur ne participe a aucun Event
		if (!isset($verif_1)) 
		{
			echo '<h4 class="text-danger"><i class="fa fa-info-circle"></i> Vous ne participez à aucun Event Fun !</h4>';
		}

	}

}

?>