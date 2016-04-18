<?php

$req_utilisateur_2 = $bdd->prepare('SELECT * FROM utilisateur WHERE login = ?');
$req_utilisateur_2->execute(array($_SESSION['login']));
$donnees_utilisateur_2 = $req_utilisateur_2->fetch();

$req_recup_reponse_2 = $bdd->prepare('SELECT * FROM reponse WHERE id_utilisateur = ? AND id_evenement = ? ');
$req_recup_reponse_2->execute(array($donnees_utilisateur_2['id'], $_POST['id_evenement']));
$donnees_reponse_2 = $req_recup_reponse_2->fetch();

$req_recup_question_2 = $bdd->prepare('SELECT * FROM question WHERE id_utilisateur = ? AND id_evenement = ? ');
$req_recup_question_2->execute(array($donnees_utilisateur_2['id'], $_POST['id_evenement']));
$donnees_question_2 = $req_recup_question_2->fetch();
?>
<div class="container" style="padding: 25px;">
	<div class="row">
		<p class="lead" style="font-family: "gotham"; margin-top: 25px;"><h2 style="color: #ff6908;"><i class="fa fa-question-circle"></i> Question</h2></p>	
		<div class="well well-lg" id="anticlay2" style="margin-left: 15px; text-align: left; word-wrap: break-word;">
			<form method="post" action="../apps/cible_supp_reponse_question.php" class="supp_reponse_question">
				<p style="font-family: gotham;"><span style="color: #F2784B;"> A propos de  l'Evenement : </span> <?php if(isset($_POST['titre_evenement'])){echo $_POST['titre_evenement'];}?> </p style="font-family: gotham;"><br/>
					Question :
					<div class="well well-sm" style="box-shadow: 0 0 1px 1px grey; padding: 15px;">
						<p style="font-family: gotham;"><?php if(isset($_POST['question'])){echo $_POST['question'];}?> </p style="font-family: gotham;">
						</div>
					</div>
					<p class="lead" style="font-family: "gotham"; margin-top: 25px;"><h2 style="color: #ff6908;"><i class="fa fa-check-circle"></i> Réponse</h2></p>	
					<div class="well well-lg" id="anticlay2" style="margin-left: 15px; text-align: left; word-wrap: break-word;">
						<input type="hidden" id="titre_evenement" name="titre_evenement" value="<?php if(isset($_POST['titre_evenement'])){echo $_POST['titre_evenement'];}?>">
						<input type="hidden" id="id_utilisateur" name="id_utilisateur" value="<?php if(isset($_POST['id_utilisateur'])){echo $_POST['id_utilisateur'];}?>">
						<input type="hidden" id="id_createur"  name="id_createur" value="<?php if(isset($_POST['id_createur'])){echo $_POST['id_createur'];}?>">
						<input type="hidden" id="id_evenement" name="id_evenement" value="<?php if(isset($_POST['id_evenement'])){echo $_POST['id_evenement'];}?>">
						<input type="hidden" id="supp_reponse_question" name="supp_reponse_question" value="question">
						<input type="hidden" id="id_reponse" name="id_reponse" value="<?php if(isset($donnees_reponse_2['id'])){echo $donnees_reponse_2['id'];}?>">
						<input type="hidden" id="id_question" name="id_question" value="<?php if(isset($donnees_question_2['id'])){echo $donnees_question_2['id'];}?>">
						Réponse :
						<div class="well well-sm" style="box-shadow: 0 0 1px 1px grey; padding: 15px;">
						<p style="font-family: gotham;"><?php if(isset($donnees_reponse_2['reponse'])){echo $donnees_reponse_2['reponse'];} else {echo '<h4 class="text-danger"><i class="fa fa-info-circle"></i> L\'administrateur n\'a pas encore répondu à votre question.</h4>';}?> </p style="font-family: gotham;">
						</div>
					</div>
					<div class="col-md-6">
					<button type="submit"  class="form-group btn-raised btn btn-warning"><i class="material-icons">&#xE5CD;</i> Supprimer cette question</button>
				</div>
					</form>
				</div>	
			</div>
		</div>	
	</div>
</div>