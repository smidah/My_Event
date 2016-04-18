<?php 
try {
  $bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
  die('Erreur : ' . $e->getMessage());
}
?>
<html>
<head>
  <script type="text/javascript" src="js/jquery.js"></script>

    <title>Extia - News</title>  
  <?php //session_start();
  if(!isset($_SESSION['login'])) {
    header("Location: ../index.php");
  } 
  $req_eventfun = $bdd->query('SELECT * FROM evenement WHERE categorie = 1 ORDER BY date_creation DESC LIMIT 4');
  $req_eventfun->setFetchMode(PDO::FETCH_OBJ);

  $req_eventpro = $bdd->query('SELECT * FROM evenement WHERE categorie = 0 ORDER BY date_creation DESC LIMIT 4');
  $req_eventpro->setFetchMode(PDO::FETCH_OBJ);
  ?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12" id="even1" style="padding: 15px">
        <div class="col-md-offset-1 col-md-10" style="margin-top: 15px;">
          <div class="well well-lg" id="my-calendar"></div>
        </div>
      </div>
      <div class="col-md-12" id="actu">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="well" id="orange" style="text-align: center; font-size: 120%;">
                Des événements à venir !
              </div>
            </div>
            <div class="container">
             <div class="col-md-6">
              <div class="well" id="anticlay" style="text-align: center;">
               <span class="glyphicon glyphicon-glass" aria-hidden="true"></span> New Events Fun
             </div>
             <div class="row">
              <?php
              while ($result = $req_eventfun->fetch()) {
                echo '<div class="col-md-6" style="padding: 0;">
                <div class="well" id="vitrine" style="text-align: center; padding: 0;">';
                if (empty($result->image))
                  echo '<img src="img/background_signin.png" id="imgvitrine" style="padding: 0px; width: 100%;" height="200">';
                else
                  echo '<img src="includes/' . $result->image  . '" id="imgvitrine" style="padding: 0px; width: 100%;" height="200">';
                echo '<div>';
                echo '<p style="width: 100%; background-color: #eeeeee; color: #222; text-align: center; font-family: gotham ;padding: 4px;">' . utf8_encode(ucfirst($result->titre)) . "</p>";
                echo '<p style="width: 100%;text-align: left; font-family: gotham ;padding: 15px;">Le : ' . $result->date_evenement . " à " .  $result->heure_evenement .".<br> Agence : ". $result->agence .
                '</p><p style="width: 100%; background-color: #eeeeee; color: #222; text-align: right; font-family: gotham ;padding: 4px;">Lieu : '. utf8_encode(ucfirst($result->lieu)) ."</div></div></div>";
              }
              ?>
            </div>
          </div>
          <div class="col-md-6">
            <div class="well" id="anticlay" style="text-align: center;">
              <span class="glyphicon glyphicon-earphone" aria-hidden="true"></span> New Events Pro
            </div>
            <div class="row">
              <?php
              while ($result = $req_eventpro->fetch()) {
                echo '<div class="col-md-6" style="padding: 0;">
                <div class="well" id="vitrine" style="text-align: center; padding: 0;">';
                if (empty($result->image))
                  echo '<img src="img/background_signin.png" id="imgvitrine" style="padding: 0; width: 100%;" height="200">';
                else
                  echo '<img src="includes/' . $result->image  . '" id="imgvitrine" style="padding: 0; width: 100%;" height="200">';
                echo '<div>';
                echo '<p style="width: 100%; background-color: #eeeeee; color: #222; text-align: center; font-family: gotham ;padding: 4px;">' . utf8_encode(ucfirst($result->titre)) . "</p>";
                echo '<p style="width: 100%;text-align: left; font-family: gotham ;padding: 15px;">Le : ' . $result->date_evenement . " à " .  $result->heure_evenement .".<br> Agence : ". $result->agence .
                '</p><p style="width: 100%; background-color: #eeeeee; color: #222; text-align: right; font-family: gotham ;padding: 4px;">Lieu : '. utf8_encode(ucfirst($result->lieu)) ."</div></div></div>";
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a href="includes/events.php" class="btn btn-fab" id="goto"><i class="material-icons">&#xE037;</i></a>
  </div>
</div>
</div>
<script src="js/calend.js"></script>
</body>
</html>