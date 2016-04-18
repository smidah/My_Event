
<?php


		// On prepare la requete pour recuperer les infos de lutilisateur
$req_utilisateur = $bdd->prepare('SELECT * FROM utilisateur WHERE login = ?');

		// Si la requete fonctionne on continue
if ($req_utilisateur->execute(array($_SESSION['login'])))
{ 

		// Variable avec toutes les donnees de l'utilisateur
	$donnees_utilisateur = $req_utilisateur->fetch();

		// On recupere les messages 
	if ($donnees_utilisateur['role'] == 3)
	{

		$req_recup_question = $bdd->prepare('SELECT * FROM question WHERE id_createur = ? AND id NOT IN(SELECT id_question FROM reponse)');
		$req_recup_question->execute(array($donnees_utilisateur['id']));

		echo '
		<div class="row">
		<div class="container">
		<p class="lead" style="font-family: "gotham";"><h2 style="color: #ff6908;"><i class="fa fa-question-circle"></i> Les questions</h2></p></div>';
	}

	else if ($donnees_utilisateur['role'] != 3)
	{

		$req_recup_question = $bdd->prepare('SELECT * FROM question WHERE id_utilisateur = ? ');
		$req_recup_question->execute(array($donnees_utilisateur['id']));

		echo '<div class="row"><div class="container">
		<p class="lead" style="font-family: "gotham"; margin-top: 25px;"><h2 style="color: #ff6908;"><i class="fa fa-question-circle"></i> Vos questions</h2></p>
		</div>';
	}

	while ($donnees_question = $req_recup_question->fetch()) 
	{
		$date = new DateTime($donnees_question['date_creation']);
			// On recupere quelques infos sur l'evenement 
		$req_recup_event = $bdd->prepare('SELECT * FROM evenement WHERE id = ? ');
		$req_recup_event->execute(array($donnees_question['id_evenement']));
		$donnees_event = $req_recup_event->fetch();


			// On recupere quelques infos sur l'expediteur
		$req_recup_expediteur = $bdd->prepare('SELECT * FROM utilisateur WHERE id = ? ');
		$req_recup_expediteur->execute(array($donnees_question['id_utilisateur']));
		$donnees_expediteur = $req_recup_expediteur->fetch();

		if ($donnees_utilisateur['role'] == 3)
		{
			echo '<div class="container" ><div class="col-md-12" >
			<form method="POST" action="" class="form-horizontal bouton_repondre" style="margin: 0;">
			<input type="hidden" name="id_evenement" value="'.$donnees_event['id'].'">
			<input type="hidden" name="titre_evenement" value="'.$donnees_event['titre'].'">
			<input type="hidden" name="id_createur" value="'.$donnees_question['id_createur'].'">
			<input type="hidden" name="id_utilisateur" value="'.$donnees_expediteur['id'].'">
			<input type="hidden" name="nom_utilisateur" value="'.$donnees_expediteur['nom'].' ' .$donnees_expediteur['prenom']. '">
			<input type="hidden" name="question" value="'.$donnees_question['question'].'">
			<input type="hidden" name="id_question" value="'.$donnees_question['id'].'">
			<input type="hidden" name="repondre_question" value="repondre_question">
			<div class="well" id="clayevent">
			<div class="row">';
			echo '<button style="text-align:left; margin: 0; padding: 0;border: none; background-color: transparent;text-decoration: none; color: inherit; outline: none;" type="submit" name="id_evenement"  value="'.$donnees_event['id'].'">';

			echo '<div class="col-md-12"><span style="color: #F2784B;"> Auteur : </span>' . utf8_encode(ucfirst($donnees_expediteur['nom'])).' ' .utf8_encode(ucfirst($donnees_expediteur['prenom'])) . '<br/><span style="color: #F2784B;"> A propos de  l\'Evenement : </span>"'. utf8_encode($donnees_event['titre']). '"</div>';

			echo '<div class="col-md-12" style="color: #F2784B;   word-wrap: break-word;"><blockquote style="font-size: 12px"><i class="material-icons">&#xE8FD;</i> '. utf8_encode($donnees_question['question']) .'</div>';
			echo '<div class="col-md-6"><small style="font-family: gotham; color: #F2784B;">'.$date->format('d/m/Y à H:i').'</small></div>';
			echo '</div>
			</div>
			</button>
			</form>
			</div></div></div>';

			$verif_1 = true;
		}

		else if ($donnees_utilisateur['role'] != 3)
		{

			echo '<div class="container"><div class="col-md-12" >
			<form method="POST" action="" class="form-horizontal bouton_repondre" style="margin: 0;">
			<input type="hidden" name="id_evenement" value="'.$donnees_event['id'].'">
			<input type="hidden" name="titre_evenement" value="'.$donnees_event['titre'].'">
			<input type="hidden" name="id_createur" value="'.$donnees_question['id_createur'].'">
			<input type="hidden" name="id_utilisateur" value="'.$donnees_expediteur['id'].'">
			<input type="hidden" name="nom_utilisateur" value="'.$donnees_expediteur['nom'].' ' .$donnees_expediteur['prenom']. '">
			<input type="hidden" name="question" value="'.$donnees_question['question'].'">
			<input type="hidden" name="aff_reponse" value="aff_reponse">
			<div class="well" id="clayevent">
			<div class="row">';
			echo '<button style="text-align:left; margin: 0; padding: 0;border: none; background-color: transparent;text-decoration: none; color: inherit; outline: none;" type="submit" name="id_evenement"  value="'.$donnees_event['id'].'">';

			echo '<div class="col-md-12"><span style="color: #F2784B;"> Auteur : </span>' . utf8_encode(ucfirst($donnees_expediteur['nom'])).' ' .utf8_encode(ucfirst($donnees_expediteur['prenom'])) . '<br/><span style="color: #F2784B;"> A propos de  l\'Evenement : </span>"'. utf8_encode($donnees_event['titre']). '"</div>';

			echo '<div class="col-md-12" style="color: #F2784B;   word-wrap: break-word;"><blockquote style="font-size: 12px"><i class="material-icons">&#xE8FD;</i> '. utf8_encode($donnees_question['question']) .'</div>';
			echo '<div class="col-md-6"><small style="font-family: gotham; color: #F2784B">'.$date->format('d/m/Y à H:i').'</small></div>';
			echo '</div>
			</div>
			</button>
			</form>
			</div></div></div>';

			$verif_1 = true;
			
		}

	}

		// Si verif n'existe pas donc, l'utilisateur ne participe a aucun Event
	if (!isset($verif_1)) 
	{
		echo '<div class="container"><div class="col-md-12 well" id="anticlay2"><h4 class="text-danger"><i class="fa fa-info-circle"></i> Vous n\'avez aucun message !</h4></div></div></div>';

	}

}

?>

</div>