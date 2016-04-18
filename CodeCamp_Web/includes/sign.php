 <title>Extia - Connexion</title>
 <script>
 $('body').css('background', 'url("img/background_signin.png")');
 </script>
 <div class="container-fluid" id="sign">
 	<div class="container container-table">
 		<div class="row vertical-center-row">
 			<div class="col-md-6 col-md-offset-3 alert alert-dismissible alert-primary" id="TitreSign">
 				<strong id="extia"><img src="img/Logo_FINAL.png" style="max-width: 30%; max-height: 30%;"></strong>
 			</div>
 			<div class="well well-lg col-md-6 col-md-offset-3" id="SignWall">
 				<?php require_once('apps/connexion.php'); ?>
 				<form class="form-horizontal" method="POST" action="">
 					<div class="row">
 						<div class="col-md-12 form-group has-Warning is-empty">
 							<label class="control-label" for="focusedInput2"><i class="fa fa-user"></i> Login</label>
 							<input class="form-control" name="login" id="focusedInput2" type="text" pattern="^[\d\w]{4,8}$" required>
 							<p class="help-block">Champ obligatoire.</p>
 							<span class="material-input"></span>
 						</div>
 						<div class="col-md-12 form-group has-Warning is-empty">
 							<label class="control-label" for="focusedInput2"><i class="fa fa-lock"></i> Mot de passe</label>
 							<input class="form-control" name="password" id="focusedInput2" type="password" pattern="^[\d\w]{4,8}$" required>
 							<p class="help-block">Champ obligatoire.</p>
 							<span class="material-input"></span>
 						</div>
 						<div class="col-md-6">
 							<button type="submit" name="submit" class="btn btn-default hvr-glow" style="margin-top: 15px;" id="buttsign"><i class="fa fa-sign-in"></i> Connexion<div class="ripple-container"></div></button>
 						</div>
 					</form>
 					<div class="col-md-6">
 						<form method="get" action="">
 							<input type="hidden" name="sign" value="up">
 							<button type="submit" class="btn btn-default hvr-glow" style="margin-top: 15px;" id="buttsign"><i class="fa fa-clipboard"></i> Inscription<div class="ripple-container"></div></button>
 						</form>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>
 <script src="../js/forget_pass.js"></script>