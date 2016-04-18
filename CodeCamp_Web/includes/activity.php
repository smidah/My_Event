<html>
<?php require_once('headrecur.php'); ?>
<body>
	<title>Extia - Activité du site</title>
	<?php session_start();
	if (!isset($_SESSION['login'])) {
		header("Location: ../index.php");
	} 

	$req = $bdd->query('select * from utilisateur where login="'.$_SESSION['login'].'"');
	$req->setFetchMode(PDO::FETCH_OBJ);
	$result = $req->fetch();
	if ($result->role == 4)
		header("location: ../index.php");?>
	<?php require_once('headerrecur.php'); ?>
	<div class="container-fluid" style="font-family: 'gotham';">
		<div class="row">
			<div class="container-fluid" style="margin-top: 25px; text-align: center;">
				<div class="col-md-4 col-md-offset-4">
					<p class="lead" style="font-family: 'gotham';"><img width="40" height="40" src="../img/croissance.png"> Activité du site en temps réel</p>
				</div>
			</div>
			<div class="container acti" style="margin-top: 0; padding-top: 0;">
				<div class="col-md-12">
					<div class="row" style="margin: 0; padding: 0;">
						<p><h3 style="color: #ff6908;"><i class="fa fa-download"></i> Exporter des données</h3></p>
						<div class="col-md-12" style="box-shadow: 0 0 1px 1px grey">
							<p><h5 style="color: #222;">Les données seront exportées sous forme de fichier excel.</h5></p>
							<div class="col-md-6" style="margin-top: 25px; margin-bottom: 25px;">
								<p><h5 style="color: #ff6908;"><i class="fa fa-file-excel-o"></i> Données utilisateurs (Liste des Inscriptions)</h5></p>
								<br>
								<table class="table table-striped table-hover ">
									<tr class="warning">
										<td><a href="../apps/cible_exporte.php" style="margin: 5px; color:inherit;"><i class="fa fa-file"></i> Données utilisateurs..</a></td>
									</tr>
								</table>
								<p><h5 style="color: #ff6908;"><i class="fa fa-file-excel-o"></i> Données événements (Liste des notes et commentaires)</h5></p>
								<br>
								<table class="table table-striped table-hover ">
									<tr class="defaut">
										<th>Titre</th>
										<th>Lien</th>
									</tr>
									<?php
									$req = $bdd->query('select * from evenement');
									$date = date('Y-m-d');
									$hour = date('H:i');
									while ($result = $req->fetch()) {
										if ($result['date_evenement'] < $date || ($result['date_evenement'] == $date && $result['date_evenement'] < $hour)) {
											echo '<tr class="warning">
											<td>'. $result['titre'] .'</td>
											<td><form style="margin: 0; padding: 0;" method="post" action="../apps/cible_exporte2.php">
											<input type="hidden" name="idevent" value="'. $result['id'] .'">
											<button type="submit" style="margin: 0; padding: 0; background-color: inherit; border: none;">
											<i class="fa fa-download"></i>
											</button>
											</form></td>
											</tr>';
										}
									}
									?>
								</table>
							</div>
							<div class="col-md-6" style="margin-top: 25px; margin-bottom: 25px;">
								<p><h5 style="color: #ff6908;"><i class="fa fa-medium"></i> Moyenne des événement terminés</h5></p>
								<br>
								<table class="table table-striped table-hover">
									<tr>
										<td>Titre</td>
										<td>Note sur 5</td>
									</tr>
									<?php
									$req = $bdd->prepare('select * from evenement');
									$date = date('Y-m-d');
									$hour = date('H:i');
									$namelist = array();
									$idlist = array();
									$notelist = array();
								//echo '<tr class="warning"><td><i class="fa fa-database"></i> ' . $note['note'] . '</td><td>/5 </td></tr>';
								//$note = $bdd->prepare('select * from commentaire where id_evenement ="' . $result['id'] .'"');
									$req->execute();
									while ($result = $req->fetch()) {
										if ($result['date_evenement'] < $date || ($result['date_evenement'] == $date && $result['date_evenement'] < $hour)) {
											$namelist[] = $result['titre'];
											$idlist[] = $result['id'];
										}
									}
									$req->closeCursor();
									$i = 0;
									while (isset($idlist[$i])) {
										$sql = $bdd->query('select AVG(note) from commentaire where id_evenement ="' . $idlist[$i] .'"');
										$note = $sql->fetch();
										$notelist[] =  $note['AVG(note)'];
										++$i;
									}
									$i = 0;
									while (isset($idlist[$i])) {
										if ($notelist[$i] == 0.00)
											$note = "Pas de Note";
										else
											$note = number_format($notelist[$i], 2);
										echo '<tr class="warning"><td><i class="fa fa-database"></i> ' . utf8_encode($namelist[$i]) . '</td><td>'. $note .'</td></tr>';
										++$i;
									}
									?>
								</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<p><h3 style="color: #ff6908;"><i class="fa fa-pie-chart"></i> Dernières activités</h3></p>
					<div class="col-md-12" style="box-shadow: 0 0 1px 1px grey; padding-bottom: 30px;">
						<p><h5 style="color: #222;">Dernières notes, commentaires et inscriptions (<small>les 25 derniers</small>).</h5></p>
						<div class="col-md-6">
							<table class="table table-striped table-hover ">
								<thead>
									<tr>
										<th>Agence</th>
										<th>Date</th>
										<th>Nom</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$req = $bdd->query('SELECT * from utilisateur ORDER BY date_creation DESC LIMIT 25');
									while ($result = $req->fetch()) {
										$datee = new DateTime($result['date_creation']);
										echo '<tr class="defaut">
										<td>'. $result['agence'] .'</td>
										<td>'. $datee->format('d/m/Y') .'</td>
										<td>'. $result['nom'] . '</td>
										</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
						<div class="col-md-6">
							<table class="table table-striped table-hover ">
								<thead>
									<tr>
										<th>Date</th>
										<th>Evenement</th>
										<th>Note sur 5</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$req = $bdd->query('SELECT * from commentaire ORDER BY date_creation DESC LIMIT 25');
									while ($result = $req->fetch()) {
										$sql = $bdd->query('SELECT titre from evenement WHERE id="'. $result['id_evenement'] .'"');
										$res = $sql->fetch();
										$datee = new DateTime($result['date_creation']);
										echo '<tr class="defaut">
										<td>'. $datee->format('d/m/Y') . '</td>
										<td>'. $res['titre'] .'</td>
										<td>'. $result['note'] .'</td>
										</tr>';
									}
									?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php require_once('footerrecur.php'); ?>
</body>
</html>
