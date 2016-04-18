<?php
	
	if(!isset($_SESSION))
	{
		session_start();
	}

	if (!isset($bdd))
	{
		try {
			$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
		catch (Exception $e) {
			die('Erreur : ' . $e->getMessage());
		}
	}

	if (isset($whatevent) && !empty($whatevent) || isset($_POST) && !empty($_POST['id_evenement']) && !empty($_POST['id_utilisateur']) )
	{
		if(!isset($whatevent))
		{
			$whatevent = $_POST['id_evenement'];
		}

		// On recupere les infos de l'user
		$req_utilisateur = $bdd->prepare('SELECT * FROM utilisateur WHERE login = ?');
		$req_utilisateur->execute(array($_SESSION['login']));
		$donnees_utilisateur = $req_utilisateur->fetch();

		$req_id_participants = $bdd->prepare('SELECT id_utilisateur FROM utilisateur_evenement 
			WHERE id_evenement = ?');

		$req_id_participants->execute(array($whatevent));

		$req_event = $bdd->prepare('SELECT nombre_place, nombre_participant FROM evenement 
			WHERE id = ?');

		$req_event->execute(array($whatevent));

		$event_donnees = $req_event->fetch();

		while($result_id_participants = $req_id_participants->fetch())
		{

			$req_participants = $bdd->prepare("SELECT nom, prenom, id FROM utilisateur 
				WHERE id = ? ");
			$req_participants->execute(array($result_id_participants['id_utilisateur']));


			while($result = $req_participants->fetch())
			{
				echo '<i class="fa fa-minus"></i> ' .ucfirst($result['prenom']) ."_". ucfirst($result['nom'][0]) . "<br/>";
			}
		

			$req_participants->closeCursor();
		}
	} 
	echo '<p style="color: #ff6908;margin-top:20px;"><i class="fa fa-sort"></i> Nombre de places restantes : '. ($event_donnees['nombre_place'] - $event_donnees['nombre_participant']) .'.</p>';
?>