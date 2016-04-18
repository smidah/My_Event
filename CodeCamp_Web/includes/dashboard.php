<html>
<?php require_once('headrecur.php'); ?>
<body style="background-color: #394147;">
	<title>Extia - Informations</title>
	<?php session_start();
	if(!isset($_SESSION['login'])) {
		header("Location: ../index.php");
	}
	$req = $bdd->query('select * from utilisateur where login="'.$_SESSION['login'].'"');
	$req->setFetchMode(PDO::FETCH_OBJ);
	$result = $req->fetch();
	$req_pays = $bdd->query('SELECT * FROM pays');
	$req_agence = $bdd->query('SELECT * FROM agence');
	$req_users = $bdd->query('SELECT * FROM utilisateur');
	?>
	<?php require_once('headerrecur.php'); ?>
	<?php require_once('../apps/cible_desinscrire_event.php'); ?>
	<div class="container-fluid" id="panneladmin2" style="min-height: 86vh;">
		<div class="row">
			<div class="col-md-12">
				<div class="" style="padding: 0; font-family: 'Verdana'; margin-bottom: 25px;">
					<div id="headwell">
						<div class="list-group">
							<div class="list-group-item">
								<div class="row-content">
									<h4 class="list-group-item-heading" style="color: #eeeeee;"><?php echo $_SESSION['login']; ?></h4>
									<p class="list-group-item-text"><?php
									if ($result->role == 1)
										echo 'Vous êtes administrateur Fun.';
									else if ($result->role == 2)
										echo 'Vous êtes administrateur Pro.';
									else if ($result->role == 3)
										echo '<p id="titlepannel">Vous êtes un administrateur.</p>';
									else if ($result->role == 4)
										echo 'Vous êtes un utilisateur.';
									?></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div id="clay2">
					<div class="row">
						<div class="col-md-6" id="rightsep">
							<?php 
							$date = new DateTime($result->date_creation);
							echo "<span style='color: ff6908;'>Nom</span> : " .ucfirst($result->nom) . ".<br>";
							echo "<span style='color: ff6908;'>Prénom</span> : " .ucfirst($result->prenom) . ".<br>";
							echo "<span style='color: ff6908;'>Email</span> : " .$result->email . ".<br>";
							echo "<span style='color: ff6908;'>Tel</span> : " .$result->telephone . ".<br>";
							echo "<span style='color: ff6908;'>Agence</span> : " .$result->agence . ".<br>";
							echo "<span style='color: ff6908;'>Date d'inscription</span> : " .$date->format('d/m/Y à H:i') . ".<br>";
							?>
						</div>
						<div class="col-md-6">
							<a style="position: relative; left:25%;" role="button" data-toggle="collapse" href="#collapsemodif" aria-expanded="false" aria-controls="collapsemodif" class="btn btn-raised btn-warning">Modifier
								<div class="ripple-container">
								</div>
							</a>
							<div class="collapse" id="collapsemodif" aria-expanded="false" style="height: 0px; color: #394147;"> 
								<div class="row">
									<div class="well well-lg" style="margin-left: 15px; background-color: #eeeeee">
										<form class="form-horizontal" method="post" action="../apps/modif_info.php">
											<div class="form-group is-empty has-warning">
												<div class="col-md-12">
													<span style="black">Email : </span>
													<input name="email" type="email" class="form-control">
												</div>
												<span class="material-input"></span>
											</div>
											<div class="form-group is-empty">
												<div class="col-md-12">
													<span style="black">Telephone : </span>
													<input name="telephone" type="text" class="form-control" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$">
												</div>
												<span class="material-input"></span>
											</div>
											<div class="form-group is-empty">
												<div class="col-md-12">
													<span style="black">Agence : </span>
													<select id="select111" class="form-control" name="agence">
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
													<input type="hidden" name="sign" value="up">
													<span class="material-input"></span>
												</div>
											</div>
											<button type="submit" class="btn btn-warning" style="margin-top: 15px; margin-bottom: 0;">Valider
												<div   class="ripple-container">
												</div>
											</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php 
			if ($result->role != 4) { 
				echo '<div class="col-md-6">';
			}
			else {
				echo '<div class="col-md-12">';
			}
			?>
			<div class="col-md-12" id="orange" style="text-align: center; font-family:'gotham'; margin-bottom: 25px;">
				My events / Mes inscriptions
			</div>
			<?php if ($result->role != 4) { ?>
			<p style="color : ff6908; font-size: 20px;"><i class="fa fa-map-signs"></i> Événements festifs</p>
			<div class="col-md-12" id="anticlay2"Events Pro>
				<?php require_once('../apps/cible_my_events_fun.php'); ?>
			</div>
			<p style="color : ff6908; font-size: 20px;"><i class="fa fa-briefcase"></i> Événements Professionnels</p>
			<div class="col-md-12" id="anticlay2">
				<?php require_once('../apps/cible_my_events_pro.php'); ?>
			</div>
			<?php } else if ($result->role == 4) { ?>
			<p style="color : ff6908; font-size: 20px;"><i class="fa fa-map-signs"></i> Événements festifs</p>
			<div class="col-md-12" id="anticlay2"Events Pro>
				<?php require_once('../apps/cible_my_events_fun.php'); ?>
			</div>
			<p style="color : ff6908; font-size: 20px;"><i class="fa fa-briefcase"></i> Événements Professionnels</p>
			<div class="col-md-12" id="anticlay2">
				<?php require_once('../apps/cible_my_events_pro.php'); ?>
			</div>
			<?php }?>
		</div>
		<?php if ($result->role != 4) {?>
		<div class="col-md-6">
			<div id="orange" style="text-align: center; font-family:'gotham';">
				Administration
			</div>
		</div>
		<div class="col-md-6">
			<div id="anticlay">
				<i class="fa fa-plus"></i> Organiser un événement
				<div id="anticlay2" style="padding: 25px; text-align: center;">
					<a role="button" data-toggle="collapse" href="#addevent" aria-expanded="false" aria-controls="addevent" class="btn btn-raised btn-warning">Creer un event
						<div class="ripple-container">
						</div>
					</a>
					<div class="collapse" id="addevent" aria-expanded="false" style="height: 0px; color: #394147;"> 
						<div class="row">
							<div class="well well-lg" id="anticlay2" style="margin-left: 15px;">
								<?php require_once('../apps/cible_add_event.php'); ?>
								<form method="post" action="" enctype="multipart/form-data" class="form-horitzontal" style="text-align: left;">
									<div class="form-group has-empty">
										<label for="pseudo">Titre : </label>
										<input class="form-control" type="text" name="titre" id="titre"  size="15" required autofocus/>
									</div>
									<div class="form-group has-empty">
										<label for="lieu">Lieu : </label>
										<input class="form-control" type="text" name="lieu" id="lieu"  size="15" required />
									</div>
									<div class="form-group has-empty">
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
									<div class="form-group has-empty">
										<label for="date">Date de l'evenement : </label>
										<input class="form-control" type="date" name="date_evenement" id="date" 
										<?php 
										$date_en = date('Y-m-d');
										$date_fr = date('d-m-Y');

										echo '"min="'.$date_fr.'"';
										echo '"min="'.$date_en.'"';
										?>
										required
										/>
									</div>
									<div class="form-group has-empty">
										<label for="heure_evenement">L'heure de l'evenement : </label>
										<input class="form-control" type="texte" name="heure_evenement" id="heure_evenement" size="5" required/>
									</div>
									<div class="form-group has-empty">
										<label for="nombre_place">Nombre de place : </label>
										<input class="form-control" type="number" name="nombre_place" id="nombre_place" size="5" required>
									</div>
									<div class="form-group has-empty">
										<label for="descriptif">Descriptif : </label><br/>
										<textarea name="descriptif" required></textarea>
									</div>
									<div class="form-group has-empty">
										<label for="url">Url : </label>
										<input class="form-control" type="text" name="url" id="url" required>
									</div>
									<div class="form-group has-empty">
										<label for="image">Uploader une image: </label>
										<input class="form-control" type="file" name="image" id="image" required>
									</div>
									<div class="form-group has-empty">
										<label>Categorie : </label>

										<input type="radio" name="categorie" value="1" id="fun" checked="checked">
										<label for="fun">Fun</label>

										<input type="radio" name="categorie" value="0" id="pro">
										<label for="pro">Pro</label>
									</div>
									<div class="form-group has-empty">
										<label>Visioconference : </label>

										<label for="oui">Oui</label>
										<input type="radio" name="visio_conference" value="1" id="oui" >

										<label for="non">Non</label>
										<input type="radio" name="visio_conference" value="0" id="non" checked="checked">
									</div>
									<div class="form-group has-empty">
										<label>Payant : </label>

										<label for="oui_payant">Oui</label>
										<input type="radio" name="payant" value="1" id="oui_payant" >

										<label for="non_payant">Non</label>
										<input type="radio" name="payant" value="0" id="non_payant" checked="checked">
									</div>
									<div class="form-group has-empty">
										<label for="prix">Le prix (si payant): </label>
										<input type="number" name="prix" id="prix" />
									</div>
									<div class="form-group has-empty">
										<label for="email_contact">Email de contact : </label>
										<input class="form-control" type="text" name="email_contact" id="email_contact" required>
										<input type="hidden" name="id_createur" id="id_createur" value="<?php echo $result->id ?>" />
									</div>
									<input class="btn btn-raised btn-warning" type="submit" value="Créer l'événement !">
								</form>
							</div>
						</div>
					</div>
				</div>
				<i class="fa fa-plus"></i> Ajouter une Agence
				<div id="anticlay2" style="padding: 25px;text-align: center;">
					<a type="button" class="btn btn-raised btn-warning" data-toggle="modal" data-target="#myModalagence">Ajouter une agence
						<div class="ripple-container">
						</div>
					</a>
					<div class="modal fade" id="myModalagence" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Ajouter une Agence</h4>
								</div>
								<div class="modal-body">
									<form class="form-horizontal" method="post" action="../apps/add_agence.php">
										<div class="form-group is-empty has-warning">
											<div class="col-md-12">
												<span style="black">Pays : </span>
												<input name="pays" type="text" class="form-control" required>
											</div>
											<span class="material-input"></span>
										</div>
										<div class="form-group is-empty has-warning">
											<div class="col-md-12">
												<span style="black">Agence : </span>
												<input name="agence" type="text" class="form-control" required>
											</div>
											<span class="material-input"></span>
										</div>
										<button type="submit" class="btn btn-warning" style="margin-top: 5px;  margin-bottom: 0;">Valider
											<div class="ripple-container">
											</div>
										</button>
									</form>
								</div>
								<div class="modal-footer">
								</div>
							</div>
						</div>
					</div>
				</div>
				<i class="fa fa-plus"></i> Modifier le code entreprise
				<div id="anticlay2" style="padding: 25px;text-align: center;">
					<a type="button" class="btn btn-raised btn-warning" data-toggle="modal" data-target="#modo">Modifier le code entreprise
						<div class="ripple-container">
						</div>
					</a>
					<div class="modal fade" id="modo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="myModalLabel">Modifier le code entreprise</h4>
								</div>
								<div class="modal-body">
									<?php
									if (isset($_POST) && isset($_POST['code']))
									{
										if ($_POST['code'] == $_POST['verif_code'])
										{
											$req_change_pass = $bdd->prepare('UPDATE code_entreprise set code = ?');
											$req_change_pass->execute(array($_POST['code']));
											echo 'Succès : Le code à été modifié';
										}
										else
											echo 'Erreur : Les codes ne sont pas identiques';
									}
									?>
									<form method="POST" class="form-horizontal">
										<div class="form-group is-empty has-warning">
											<label>Nouveau Code Entreprise</label>
										</div>
										<input class="form-group" type="password" name="code" required>
										<div class="form-group is-empty has-warning">
											<label>Confirmation Code Entreprise</label>
											<input class="form-group" type="password" name="verif_code" required>
										</div>
										<input type="submit" class="btn btn-raised btn-warning" value="Valider">
									</form>
								</div>
								<div class="modal-footer">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>
</div>
</div>
<?php require_once('footerrecur.php'); ?>
</body>
</html>