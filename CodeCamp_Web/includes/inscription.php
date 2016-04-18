<?php
require_once('apps/cible_inscription.php');
?>
<script>
$('body').css("background-color", "#394147");
</script>
<title>Extia - Inscription</title>
<div class="container-fluid" style="margin-top: 15px;">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3 alert alert-dismissible alert-info" id="TitreSign">
        <strong id="extia" style="color: #ff6908;"><i class="fa fa-sign-in"></i> Inscription</strong>
      </div>
      <div class="well well-lg col-md-6 col-md-offset-3" id="SignWall">
       <form class="form-horizontal" method="POST" action="" style="color: #D35400;">
        <div class="row">
          <div class="form-group is-empty foo">
            <div class="col-md-12">
              <span style="color: #ff6908;"><i class="fa fa-user"></i> Nom : </span><input name="nom" type="text" class="form-control" required>
            </div>
            <span class="material-input"></span></div>
            <div class="form-group is-empty foo">
              <div class="col-md-12">
                <span style="color: #ff6908;"><i class="fa fa-user"></i> Prenom : </span><input name="prenom" type="text" class="form-control" required>
              </div>
              <span class="material-input"></span></div>
              <div class="form-group is-empty foo">
                <div class="col-md-12">
                  <span style="color: #ff6908;"><i class="fa fa-user"></i> Login : </span><input name="login" type="text" class="form-control" required>
                </div>
                <span class="material-input"></span></div>
                <div class="form-group is-empty foo">
                  <div class="col-md-12">
                    <span style="color: #ff6908;"><i class="fa fa-lock"></i> Mot de passe : </span><input name="mot_de_passe" type="password" pattern="^[\d\w]{4,8}$" class="form-control"  required>
                  </div>
                     <span class="material-input"></span></div>
                <div class="form-group is-empty foo">
                  <div class="col-md-12">
                    <span style="color: #ff6908;"><i class="fa fa-lock"></i> Confirmation du mot de passe : </span><input name="verif_mot_de_passe" type="password" pattern="^[\d\w]{4,8}$" class="form-control" required>
                  </div>
                  <span class="material-input"></span></div>
                  <div class="form-group is-empty foo">
                    <div class="col-md-12">
                      <span style="color: #ff6908;"><i class="fa fa-envelope"></i> Email : </span><input name="email" type="email" class="form-control" required>
                    </div>
                    <span class="material-input"></span></div>
                    <div class="form-group is-empty foo">
                    <div class="col-md-12">
                      <span style="color: #ff6908;"><i class="fa fa-envelope"></i> Question secrete : </span><input name="question_secrete" type="text" class="form-control" required>
                    </div>
                    <span class="material-input"></span></div>
                    <div class="form-group is-empty foo">
                    <div class="col-md-12">
                      <span style="color: #ff6908;"><i class="fa fa-envelope"></i> Reponse secrete : </span><input name="reponse_secrete" type="text" class="form-control" required>
                    </div>
                    <span class="material-input"></span></div>
              <div class="form-group is-empty foo">
                <div class="col-md-12">
                  <span style="color: #ff6908;"><i class="fa fa-user-secret"></i> Code entreprise : </span><input name="code_entreprise" type="password" class="form-control" required>
                </div>
                <span class="material-input"></span></div>
              <div class="form-group is-empty foo">
                <div class="col-md-12">
                  <label style="color: #ff6908;"><i class="fa fa-neuter"></i> Sexe :</label></br>
                  <input style="color: #ff6908;" name="sexe" type="radio" value ="1"> Homme <input style="color: #ff6908; margin-left: 15px;" name="sexe" type="radio" value="0"> Femme
                </div>
                    <span class="material-input"></span></div>
                    <div class="form-group is-empty foo">
                      <div class="col-md-12">
                        <span style="color: #ff6908;"><i class="fa fa-phone"></i> Telephone : </span><input name="telephone" type="text" class="form-control" required>
                      </div>
                      <span class="material-input"></span></div>
                    </div>
                    <div class="form-group foo">
                      <span style="color: #ff6908;"><i class="fa fa-building"></i> Agence: </span>
                      <select id="select111" class="form-control" name="agence">
                       <?php
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
                     <span class="material-input"></span></div>
                     <div class="form-group" style="padding-bottom: -5px;">
                      <div class="col-md-10 col-md-offset-2">
                        <a href="index.php" class="btn btn-default hvr-glow" style="background-color: #eeeeee"> Annuler<div class="ripple-container"></div></a>
                        <button type="submit" class="btn btn-danger hvr-glow" style="background-color: #eeeeee"> S'inscrire</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>