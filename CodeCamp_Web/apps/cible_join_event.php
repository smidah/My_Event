<?php session_start(); ?>
<?php


try {
	$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
	die('Erreur : ' . $e->getMessage());
}

if (isset($_POST) && !empty($_POST['participer']) && !empty($_POST['id_evenement']) ) 
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
				$deja_inscrit = true;
			}
		}
	}

			// On verifie qu'il reste encore de la place dans l'evenement 
	$req_event = $bdd->prepare('SELECT * FROM evenement WHERE id = ?');
	$req_event->execute(array($_POST['id_evenement']));
	$donnees_event_for_place = $req_event->fetch();


			// Si le nombre de participant est inferieure au nombre de place on continue
	if ($donnees_event_for_place['nombre_participant'] < $donnees_event_for_place['nombre_place'])
	{
				// Si la variable $deja_inscrit n'est pas creer alors on ajoute l'evenement 
		if (!isset($deja_inscrit))
		{
			$date = date('Y-m-d H:i:s');

					// On rajoute l'utilisateur a l'evenement
			$req_insert = $bdd->prepare('INSERT INTO utilisateur_evenement
				(id_utilisateur,
					id_evenement,
					date_creation)
			VALUES(
				:id_utilisateur,
				:id_evenement,
				:date_creation)');

			$req_insert->execute(array('id_utilisateur' => $donnees_utilisateur['id'],
				'id_evenement' => $_POST['id_evenement'],
				'date_creation' => $date));

					// On incremente le nombre de place de l'evenement
			$nombre_participant = $donnees_event_for_place['nombre_participant'] + 1;

					// On insert ce nouveau nombre dans l'evenement
			$req_insert_place = $bdd->query('UPDATE evenement
				SET nombre_participant = "'.$nombre_participant.'" WHERE id="'.$_POST['id_evenement'].'"');

			echo '<div id="popup_momo" class="alert alert-dismissible alert-success" style="border-radius: 3px; position:fixed; width: 30%; text-align:center;left:35%;top:40%;z-index:100"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>Vous etes inscrit a l\'Event !</div>';
			//header( "refresh:1;url=events.php" );

			function johnny2($email, $nom, $prenom, $donnees) {
				require_once "../phpmailer/vendor/autoload.php";
				$mail = new PHPMailer;
				//$mail->SMTPDebug = 3;                               
				$mail->isSMTP();                                    
				$mail->Host = "smtp.gmail.com";
				$mail->SMTPAuth = true;                           
				$mail->Username = "reminder.extia@gmail.com";                 
				$mail->Password = "reminderextia";                           
				$mail->SMTPSecure = "ssl";                           
				$mail->Port = 465;                                   
				$mail->From = "reminder.extia@gmail.com";
				$mail->FromName = "EXTIA EVENT";
				$mail->addAddress($email, "Collabs");
				$mail->isHTML(true);
				$mail->Subject = "Inscription à EXTIA EVENT";
				$mail->Body = 'Bonjour '.$nom.' '.$prenom.'  vous êtes maintenant inscrit &agrave; l\'&eacute;v&eacute;nement ' .$donnees['titre'].'.<br>
				L\'&eacute;v&eacute;nement aura lieu le '. $donnees['date_evenement'] .' &agrave; '.$donnees['heure_evenement'].'.<br>
				Lieu : '. $donnees['lieu'];
				if(!$mail->send()) {
				//echo "Mailer Error: " . $mail->ErrorInfo;
				} 
				else {
				//echo "Message has been sent successfully";
				}
			}
			johnny2($donnees_utilisateur['email'], $donnees_utilisateur['nom'], $donnees_utilisateur['prenom'], $donnees_event_for_place);
		}

		else
		{
			echo '<div id="popup_momo" class="alert alert-dismissible alert-danger" style="border-radius: 3px;position:fixed; width: 30%; text-align:center;left:35%;top:40%;z-index:100;"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>Vous etes déjà inscrit à l\'Event !</div>';
			//header( "refresh:1;url=events.php" );
		}
	}

			// Si le nombre Maximum est deja atteint on en informe l'utilisateur
	else if ($donnees_event_for_place['nombre_participant'] == $donnees_event_for_place['nombre_place'])
	{
		echo '<div id="popup_momo" class="alert alert-dismissible alert-danger" style="border-radius: 3px;position:fixed; width: 30%; text-align:center;left:35%;top:40%;z-index:100;"><button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
		</button>L\'Event est complet!</div>';
	}			
}
?>