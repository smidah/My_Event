<?php 
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment; filename="donneesevent.xls"');

	try {
	        $bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		}
	catch (Exception $e) {
	        die('Erreur : ' . $e->getMessage());
		}

	$event_id = $_POST['idevent'];

	$req_event = $bdd->prepare('SELECT * FROM evenement WHERE evenement.id = ?'); //Recuperer titre .. de l'evenement
	$req_event->execute(array($event_id));
	$save_event = $req_event->fetch();

		echo '<table>
			<tr><td>Evenement : '.$save_event['titre'].'</td>
		 		<td colspan="3" style="text-align: center;">Date : '.$save_event['date_evenement'].'</td></tr>';

	$req = $bdd->prepare('SELECT * FROM commentaire WHERE id_evenement = ?'); //Recuperer les info (comentaire, note, id_user)
	$req->execute(array($event_id));

	while ($save_comment = $req->fetch())
	{

		$req_users = $bdd->prepare('SELECT * FROM utilisateur WHERE id = ?');
		$req_users->execute(array($save_comment['id_utilisateur']));
		$save = $req_users->fetch();


		echo '
			<tr><td>Nom : '.$save['nom'].'</td>
				<td>Prenom : '.$save['prenom'].'</td>
				<td>Commentaire : '.$save_comment['commentaire'].'</td>
				<td>Note : '.$save_comment['note'].'</td>
			</tr>';

		$req_event->closeCursor(); // Termine le traitement de la requête
		$req_users->closeCursor();
	}
	echo '</table>';

?>