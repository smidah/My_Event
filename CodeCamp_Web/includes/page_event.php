<html>
<?php require_once('headrecur.php'); ?>
<body>
	<?php session_start();
	if (!isset($_SESSION['login'])) {
		header("Location: ../index.php");
	}
	$req = $bdd->prepare('SELECT * FROM utilisateur WHERE login= ? ');
	$req->execute(array($_SESSION['login']));
	$donnees_utilisateur = $req->fetch();

	$whatevent = $_GET['id'];
	$req_event = $bdd->prepare('SELECT * FROM evenement WHERE id = ?');
	$req_event->execute(array($whatevent)); 
	$event = $req_event->fetch();
	if (empty($event['image']))
		$event['image'] = '../img/background_signin.png';
	echo '<title>Extia - '.utf8_encode($event['titre']).'</title>';
	?>
	<?php require_once('headerrecur.php'); ?>

	<?php $date = date('Y-m-d'); ?>


	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 page-header" style="background-color: #eeeeee; margin: 0;text-align: center; font-family: gotham;">
				<br><p><h1><?php 
				if ($event['categorie'] == 1)
					echo ' '. utf8_encode($event['titre']); 
				else if ($event['categorie'] == 0)
					echo ' '. utf8_encode($event['titre']); 
				?></h1></p>
			</div>
			<div class="col-md-12" style="background-color: #eeeeee; margin: 0;">
				<div class="container" style="padding: 25px;">
					<div class="row">
						<div class="col-md-4">
							<img class="img-rounded" src="<?php echo $event['image']; ?>" alt="picture" style="width: 100%;">
						</div>
						<div class="col-md-4" style="margin-top: 60px;">
							<h4 class="list-group-item-heading"><?php
							if ($event['payant'] == 1)
								echo '<p style="color: #ff6908;"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> Payant : '.$event['prix'].' euros.</p>';
							else
								echo '<p style="color: #ff6908;"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> Gratuit</p>';
							if ($event['visio_conference'] == 1)
								echo '<p style="color: #ff6908;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Visio Conférence : avec.</p>';
							else
								echo '<p style="color: #ff6908;"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Visio Conférence : sans.</p>';
							if (!empty($event['url']))
								echo '<a href="http://'.$event['url'].'"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Lien <i class="fa fa-link"></i></a>';
							else
								echo '<p style="color: #ff6908;"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Lien : aucun.</p>';
							?></h4>
						</div>
						<div class="col-md-4" style="margin-top: 60px;">
							<h4 class="list-group-item-heading"><?php
							echo '<p style="color: #ff6908;"><i class="fa fa-calendar-o"></i> Date : '.$event['date_evenement'].'.</p>';
							echo '<p style="color: #ff6908;"><i class="fa fa-clock-o"></i> Heure : '. $event['heure_evenement'] .'.</p>';
							if (!empty($event['nombre_place']))
								echo '<p style="color: #ff6908;"><i class="fa fa-sort"></i> Nombre de place : '. $event['nombre_place'] .'.</p>';
							else
								echo '<p style="color: #ff6908;"><span class="glyphicon glyphicon-globe" aria-hidden="true"></span> Lien : aucun.</p>';
							?></h4>
						</div>
						<div class="col-md-12" style="margin-top: 25px;">
							<div class="strike">
								<span><h5 style="color: #222;"><i class="fa fa-hashtag"></i></h5></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="background-color: #eeeeee ; margin: 0;">
				<div class="container" style="padding: 25px;">
					<div class="row desc-bord">
						<div class="col-md-12">
							<p><h3 style="color: #ff6908;"><img width="35" height="35" src="../img/Suivi RH.png"> Description : </h2></p>
							<p class="description"><?php echo $event['descriptif']; ?></p>
						</div>
						<div class="col-md-offset-1 col-md-5">
							<p><h3 style="color: #ff6908;"><i class="fa fa-building"></i> Agence : </h2></p>
							<p class="description"><?php echo $event['agence']; ?></p>
						</div>
						<div class="col-md-offset-1 col-md-5">
							<p><h3 style="color: #ff6908;"><i class="fa fa-street-view"></i> Lieu : </h2></p>
							<p class="description"><?php echo $event['lieu']; ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12" style="background-color: #eeeeee ; margin: 0;">
				<div class="container">
					<div class="row">
						<div class="col-md-4 well">
							<p><h3 style="color: #ff6908;"><i class="fa fa-th-list"></i> Liste des participants : </h2></p>
							<div style="margin-top:20px;" id="listing_participant">



							</div>
						</div>
						<div class="col-md-offset-1 col-md-7 well">
							<div class="row">

								<?php

								// input cacher pour recuperer id_evenement et id_utilisateur
								echo '
								<input type="hidden" id="id_evenement" value="'.$whatevent.'"">
								<input type="hidden" id="id_utilisateur" value="'.$donnees_utilisateur['id'].'">
								';


								if ($donnees_utilisateur['role'] != 4) 
								{
									echo '<div class="col-md-3">';
									echo '<form method="GET" action="modif_event.php" class="form-horizontal col-md-3">
									<input type="hidden" name="id_evenement" value="'. $whatevent .'">
									<input type="hidden" name="modif" value="Modifier";>';
									echo '<button type="submit" class="form-group btn btn-warning"><i class="material-icons">&#xE150;</i> Modifier</button>';
									echo '</form></div>';
								}


									// Si l'evenement n'est pas passé on afficher les boutons participer et desinscrire
								if ($event['date_evenement'] > $date) 
								{
									
										// On prepare la requete pour verifier s l'utilisateur participe deja a l'evenement
									$req_all_event = $bdd->prepare('SELECT * FROM utilisateur_evenement WHERE id_utilisateur = ?');


												//  Si on trouve son ID on continue
									if ($req_all_event->execute(array($donnees_utilisateur['id'])))
									{
										while ($donnees_event = $req_all_event->fetch())
										{
												// Si l'id_evenement et l'id_utilisateur son egaux avec les valeur envoye, avec le formulaire alors on cree la variable $deja_inscrit
											if ($donnees_event['id_evenement'] == $whatevent 
												&& $donnees_event['id_utilisateur'] ==  $donnees_utilisateur['id'])
											{
												$deja_inscrit_event = true;
											}
										}
									}

									if (isset($deja_inscrit_event))
										echo '
									<div class="col-md-3" id="content_bouton_desinscrire_1">
									<form method="POST" id="bouton_desinscrire" class="form-horizontal">
									<input type="hidden" id="id_evenement" name="id_evenement" value="'.$whatevent.'">
									<input type="hidden" id="desinscrire_event" name="desinscrire_event" value="desinscrire">
									<input type="hidden" id="id_utilisateur" value="'.$donnees_utilisateur['id'].'">
									<button type="submit"  class="form-group btn btn-warning"><i class="material-icons">&#xE5CD;</i>Se Désinscrire</button>
									</form>
									</div>
									';

									else
										echo '

									<div class="col-md-3" id="content_bouton_participer_1" >
									<form method="POST" id="bouton_join_event" class="form-horizontal">
									<input type="hidden" id="id_evenement" value="'.$whatevent.'"">
									<input type="hidden" id="id_utilisateur" value="'.$donnees_utilisateur['id'].'">
									<input type="hidden" id="participer" value="participer">
									<button type="submit" class="form-group btn btn-warning"><i class="fa fa-mouse-pointer"></i> Participer</button>
									</form>
									</div>
									';

									echo '

									<div class="col-md-3" id="content_bouton_question" >
									<form method="post" action="mailbox.php" id="bouton_question" class="form-horizontal">
									<input type="hidden" name="id_evenement" value="'.$whatevent.'"">
									<input type="hidden" name="id_utilisateur" value="'.$donnees_utilisateur['id'].'">
									<input type="hidden" name="nom_utilisateur" value="'.$donnees_utilisateur['nom'].'">
									<input type="hidden" name="prenom_utilisateur" value="'.$donnees_utilisateur['prenom'].'">
									<input type="hidden" name="id_createur" value="'.$event['id_createur'].'">
									<input type="hidden" name="titre_evenement" value="'.$event['titre'].'">
									<input type="hidden" name="envoi_question" value="question">
									<button type="submit" class="form-group btn btn-warning"><i class="material-icons">&#xE8FD;</i> J\'ai une question !</button>
									</form>
									</div>
									';
								}	
								?>
							</div>
						</div>
						<?php
							//////////////////////=====FEEDBACK=====////////////////////////
						if ($event['date_evenement'] < $date)
						{
								// On prepare la requete pour recuperer les infos de lutilisateur
							$req_utilisateur = $bdd->prepare('SELECT * FROM utilisateur WHERE login = ?');
								// Si la requete fonctionne on continue
							if ($req_utilisateur->execute(array($_SESSION['login'])))
							{
									// Variable avec toutes les donnees de l'utilisateur
								$donn_utilisateur = $req_utilisateur->fetch();
									// On recupere les id des evenements auquel l'utilisateur participe
								$req_recup_id_event = $bdd->prepare('SELECT * FROM utilisateur_evenement WHERE id_utilisateur = ? AND id_evenement = ?');
									// Si la requete fonctionne on continue
								if ($req_recup_id_event->execute(array($donn_utilisateur['id'], $whatevent)))
								{	
									while ($id_evenement = $req_recup_id_event->fetch())
									{
										if ($id_evenement['id_evenement'] == $whatevent)
										{
											echo '
											<div class="col-md-12" style="padding: 15px; font-family: Roboto; text-align: center;">
											<div class="row">
											<div class="col-md-4 well feedback">
											<div id="rating" style="box-shadow: 0 0 1px 1px grey; padding: 5px;">
											<i id="star_1"  class="material-icons">grade</i>
											<i id="star_2"  class="material-icons">grade</i>
											<i id="star_3"  class="material-icons">grade</i>
											<i id="star_4"  class="material-icons">grade</i>
											<i id="star_5"  class="material-icons">grade</i>
											</div>
											<form method="POST" id="bouton_commentaire" class="form-horizontal">
											<input type="hidden" id="feedback_star"  value="1">
											<input type="hidden" id="id_evenement" value="'.$whatevent.'">
											<input type="hidden" id="login_utilisateur" value="'.$_SESSION['login'].'">
											<label for="commentaire" style="color: #ff6908; font-family: gotham bold; margin: 15px;"><i class="fa fa-inbox"></i> Commentaire : </label><br/>
											<textarea id="commentaire" id="commentaire" style="color: black;resize: none; width: 100%; height: 100px;"></textarea><br/><br/>
											<button class="btn hvr-icon-push" type="submit" style="background-color: #eeeeee">Noter</button>
											</form>
											</div>
											<div class="col-md-7 col-md-offset-1 post-it">
											<h3><p style="color: #222; margin: 25px;"> *Aidez-nous à améliorer <i class="fa fa-heart" style="color: #ff6908;"></i> nos prochains événements !</p></h3>
											</div>
											</div>
											</div> ';
												// Si un evenement a ete trouver on declare la variable $verif
											$verif_3 = true;
										}
									}
										// Si verif n'existe pas donc, l'utilisateur ne participe pas a cet Event
									if (!isset($verif_3)) 
									{		
									}
								}
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script> $('body').css('background-color', '#222') </script>
	<?php require_once('footerrecur.php'); ?>
	<script src="../js/desinscrire.js" ></script>
	<script src="../js/join_event.js" ></script>
	<script src="../js/mossab.js"></script>
	<script src="../js/feedback.js"></script>

</body>
</html>