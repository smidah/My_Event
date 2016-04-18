<div class="container">
	<div class="row">
		<p class="lead" style="font-family: 'gotham'; margin-top: 25px;"><h2 style="color: #ff6908;"><i class="fa fa-question-circle"></i> Question</h2></p>
		<div>
			<div class="well well-lg" id="anticlay2" style="padding-left: 25px; padding-right: 25px;">
				<p><h3 style="color: #ff6908; text-align: center; margin: auto;"><i class="fa fa-desktop"></i> A propos de l'événement : <?php if(isset($_POST['titre_evenement'])){echo $_POST['titre_evenement'];}?> </h3></p>
				<form method="post" action="../apps/cible_envoi_question.php" class="form-horizontal">
					<div class="form-group is-empty">
						<input type="hidden" name="titre_evenement" value="<?php if(isset($_POST['titre_evenement'])){echo $_POST['titre_evenement'];}?>">
						<input type="hidden" name="id_utilisateur" value="<?php if(isset($_POST['id_utilisateur'])){echo $_POST['id_utilisateur'];}?>">
						<input type="hidden" name="id_createur" value="<?php if(isset($_POST['id_createur'])){echo $_POST['id_createur'];}?>">
						<input type="hidden" name="id_evenement" value="<?php if(isset($_POST['id_evenement'])){echo $_POST['id_evenement'];}?>">
						<input type="hidden" name="envoi_question" value="question">
					</div>
						<div class="form-group is-empty">
						<label for="descriptif" style="color: #222;">Votre question : </label><br/>
						<textarea style="width: 100%; height: 25%; resize:none; margin: auto;" name="question"></textarea>
					</div>
					<div class="form-group is-empty">
					<input type="submit" class="btn btn-raised btn-success hvr-glow" value="Envoyer votre question !" >
				</div>
				</form>
			</div>
		</div>
	</div>
</div>