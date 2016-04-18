<?php
if (!isset($_SESSION))
	session_start();
$req = $bdd->query('select * from utilisateur where login="'.$_SESSION['login'].'"');
$req->setFetchMode(PDO::FETCH_OBJ);
$result = $req->fetch();
if ($result->role == 4)
	header("location: ../index.php");
?>
<div class="container">
	<div class="row">
		<p class="lead" style="font-family: 'gotham'; margin-top: 25px;"><h2 style="color: #ff6908;"><i class="fa fa-question-circle"></i> Réponse</h2></p>
		<div class="well well-lg" id="anticlay2" style="margin-top: 15px; text-align: left; word-wrap: break-word;">
			<form method="post" action="../apps/cible_envoi_reponse.php" class="form-horizontal">
				<label><span style="color: #ff6908;">Question de </span>: <?php if(isset($_POST['nom_utilisateur'])){echo ucfirst($_POST['nom_utilisateur']);}?> </label><br/>
				<label><span style="color: #ff6908;">A propos de l'événement </span>: <?php if(isset($_POST['titre_evenement'])){echo $_POST['titre_evenement'];}?> </label><br/>
				<label><span style="color: #ff6908;">Question </span>: <?php if(isset($_POST['question'])){echo $_POST['question'];}?> </label>
				<div class="form-group is-empty">
					<input type="hidden" name="titre_evenement" value="<?php if(isset($_POST['titre_evenement'])){echo $_POST['titre_evenement'];}?>">
					<input type="hidden" name="id_utilisateur" value="<?php if(isset($_POST['id_utilisateur'])){echo $_POST['id_utilisateur'];}?>">
					<input type="hidden" name="id_createur" value="<?php if(isset($_POST['id_createur'])){echo $_POST['id_createur'];}?>">
					<input type="hidden" name="id_evenement" value="<?php if(isset($_POST['id_evenement'])){echo $_POST['id_evenement'];}?>">
					<input type="hidden" name="id_question" value="<?php if(isset($_POST['id_question'])){echo $_POST['id_question'];}?>">
					<input type="hidden" name="envoi_reponse" value="question">
					<label for="descriptif" style="color: #222;">Votre reponse : </label><br/>
					<textarea style="width: 100%; height: 25%;" name="reponse"></textarea>
				</div>
			</div>
			<input type="submit" class="btn btn-raised btn-success" value="Envoyer votre reponse !" >
		</form>
	</div>
</div>