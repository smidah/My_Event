<html>
<?php require_once('headrecur.php'); ?>
<body>
	<title>Extia - Modifier un événement</title>
	<?php session_start(); ?>
	<?php require_once('headerrecur.php'); ?>
	<?php require_once('../apps/cible_modif_event.php'); ?>

	<?php
	if (isset($_GET) && !empty($_GET['id_evenement']) )
	{
		$req_select_event = $bdd->prepare('SELECT * FROM evenement WHERE id = ?');
		$req_select_event->execute(array($_GET['id_evenement']));
		$donnees_even = $req_select_event->fetch();
		?>

		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3" style="background-color: white; margin-top: 15px; margin-bottom: 15px; border-radius: 2px; box-shadow: 0 0 1px 1px grey">
					<div class="row" style="padding: 5px;">
						<form method="post" action="" enctype="multipart/form-data" type="multipart/form-data">
							<div class="form-group is-empty col-md-6">
								<label for="pseudo">Titre : </label>
								<input class="form-control col-md-6" type="text" name="titre" id="titre" value="<?php echo $donnees_even['titre'];?>"  size="15" required autofocus/>
							</div>

							<div class="form-group is-empty col-md-6">
								<label for="lieu">Lieu : </label>
								<input class="form-control" type="text" name="lieu" id="lieu" value="<?php echo $donnees_even['lieu'];?>" size="15" required />
							</div>

							<div class="form-group is-empty col-md-6">
								<label for="agence">Agence : </label>
								<select id="select111" class="form-control" name="agence" required>
									<?php

									$req_pays = $bdd->query('SELECT * FROM pays');

									while($reponse_pays = $req_pays->fetch())
									{
										echo '<optgroup label="'.$reponse_pays['nom'].'">';
										$req_agence = $bdd->query('SELECT * FROM agence');

										while($reponse_agence = $req_agence->fetch())
										{

											if ($reponse_pays['nom'] == $reponse_agence['pays_agence'])
												echo '<optgroup><option value="'.$reponse_agence['nom_agence'].'">'.$reponse_agence['nom_agence'].'</option></optgroup>';
										}

										$req_agence->closeCursor();
									}
									?>
								</select>
							</div>

							<div class="form-group is-empty col-md-6">
								<label for="date">Date de l'evenement : </label>
								<input class="form-control" type="date" name="date_evenement" id="date" value="<?php echo $donnees_even['date_evenement'];?>"required/>
							</div>

							<div class="form-group is-empty col-md-6">
								<label for="heure_evenement">L'heure de l'evenement : </label>
								<input class="form-control" type="texte" name="heure_evenement" id="heure_evenement" size="5" value="<?php echo $donnees_even['heure_evenement'];?>"required/>
							</div>

							<div class="form-group is-empty col-md-6">
								<label for="nombre_place">Nombre de place : </label>
								<input class="form-control" type="number" name="nombre_place" id="nombre_place" size="5" value="<?php echo $donnees_even['nombre_place'];?>" />
							</div>

							<div class="form-group is-empty col-md-12">
								<label for="descriptif">Déscriptif : </label><br/>
								<textarea name="descriptif" style="resize: none; width : 100%;"><?php print $donnees_even['descriptif'];?></textarea>
							</div>

							<div class="form-group is-empty col-md-6">
								<label for="url">Url (lien du site) : </label>
								<input class="form-control" type="text" name="url" id="url" value="<?php echo $donnees_even['url'];?>"/>
							</div>

							<div class="col-md-6" style="margin-top: 10px;">
								<label for="image">Uploader / Modifier l'image de l'evenement: </label>
								<input type="file" name="image" id="image" />
								<input type="hidden" name="image" value="<?php echo $donnees_even['image'];?>"/>
							</div>

							<div class="form-group is-empty col-md-6">
								<label>Catégorie : </label>

								<input type="radio" name="categorie" value="1" id="fun" <?php if ($donnees_even['categorie'] == 1) echo 'checked="checked"';?> >
								<label for="fun">Fun</label>

								<input type="radio" name="categorie" value="0" id="pro" <?php if ($donnees_even['categorie'] == 0) echo 'checked="checked"';?> >
								<label for="pro">Pro</label>
							</div>

							<div class="form-group is-empty col-md-6">
								<label>Visioconference : </label>

								<label for="oui">Oui</label>
								<input type="radio" name="visio_conference" value="1" id="oui" <?php if ($donnees_even['visio_conference'] == 1) echo 'checked="checked"';?> >

								<label for="non">Non</label>
								<input type="radio" name="visio_conference" value="0" id="non" <?php if ($donnees_even['visio_conference'] == 0) echo 'checked="checked"';?> >
							</div>

							<div class="form-group is-empty col-md-6">
								<label>Payant : </label>

								<label for="oui_payant">Oui</label>
								<input type="radio" name="payant" value="1" id="oui_payant" <?php if ($donnees_even['payant'] == 1) echo 'checked="checked"';?> >

								<label for="non_payant">Non</label>
								<input type="radio" name="payant" value="0" id="non_payant" <?php if ($donnees_even['payant'] == 0) echo 'checked="checked"';?> >
							</div>

							<div class="form-group is-empty col-md-6">
								<label for="prix">Le prix (si payant): </label>
								<input class="form-control" type="number" name="prix" id="prix" value="<?php echo $donnees_even['prix'];?>" />
							</div>

							<div class="form-group is-empty col-md-12">
								<label for="email_contact">Email de contact : </label>
								<input class="form-control" type="text" name="email_contact" id="email_contact" value="<?php echo $donnees_even['email_contact'];?>" />
							</div>
							<input type="hidden" name="id" value="<?php echo $donnees_even['id'];?>" >
							<input style="margin-left: 25px;" class="btn btn-raised btn-success col-md-5" type="submit" value="Modifier l'événement !" >
						</form>

						<form method="POST" action="">
							<input type="hidden" name="supp_event" value="<?php echo $donnees_even['id'];?>" >
							<input style="margin-left: 25px;" class="btn btn-raised btn-danger col-md-5" type="submit" value="Supprimer l'événement !" >
						</form>
					</div>
					<?php
				}

				else
				{
					header("Location: events.php");	
				}
				?>
			</div>
		</div>
	</div>
	<?php require_once('footerrecur.php'); ?>
</body>
</html>