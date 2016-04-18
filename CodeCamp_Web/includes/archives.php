<html>
<?php require_once('headrecur.php'); ?>
<body style="background-color: #394147;">
  <title>Extia - Events</title>
  <?php session_start();
  if (!isset($_SESSION['login'])) {
    header("Location: ../index.php");
  } ?>
  <?php require_once('headerrecur.php'); ?>
  <?php
  $req = $bdd->query('select * from utilisateur where login="'.$_SESSION['login'].'"');
  $req->setFetchMode(PDO::FETCH_OBJ);
  $result = $req->fetch();
  $req_event = $bdd->query('SELECT * FROM evenement WHERE date_evenement < Now()');
  if(isset($_GET['select2']) && $_GET['select2'] == "Fun")
    $req_event = $bdd->query('SELECT * FROM evenement WHERE date_evenement < Now() AND categorie = 1 AND agence = "'.$_GET['select1'].'"');
  if(isset($_GET['select2']) && $_GET['select2'] == "Pro")
    $req_event = $bdd->query('SELECT * FROM evenement WHERE date_evenement < Now() AND categorie = 0 AND agence = "'.$_GET['select1'].'"');
  if(isset($_GET['select2']) && $_GET['select2'] == "Tous")
    $req_event = $bdd->query('SELECT * FROM evenement WHERE date_evenement < Now() AND agence = "'.$_GET['select1'].'"');
  if(isset($_GET['select2']) && $_GET['select2'] == "Tous" && $_GET['select1'] == "Tous")
   $req_event = $bdd->query('SELECT * FROM evenement WHERE date_evenement < Now()');
 if(isset($_GET['select2']) && $_GET['select2'] == "Fun" && $_GET['select1'] == "Tous")
   $req_event = $bdd->query('SELECT * FROM evenement WHERE date_evenement < Now() AND categorie = 1');
 if(isset($_GET['select2']) && $_GET['select2'] == "Pro" && $_GET['select1'] == "Tous")
   $req_event = $bdd->query('SELECT * FROM evenement WHERE date_evenement < Now() AND categorie = 0'); 
 ?>
 <div class="container-fluid" id="panneladmin" style="min-height: 86vh;">
   <div class="container-fluid col-md-6 col-md-offset-3">
    <form  method="GET" action="" name="events" class="form-horizontal">
      <div class="col-md-3 col-md-offset-1">
        <select value="Region" name="select1" id="select111" class="form-control">
          <option value="Tous">All</option>
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
      <div class="col-md-3 col-md-offset-1">
        <select name="select2" class="form-control" id="select111">
          <option name="all" value="Tous">All</option>
          <option name="pro" value="Pro">Pro</option>
          <option name="fun" value="Fun">Fun</option>
        </select>
      </select>
    </div>
    <div class="col-md-3" style="text-align:center;">
      <button type="submit" style="" value="Afficher" class="form-group btn btn-raised btn-warning"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> Trier</button>
    </div>
  </form>
</div>
<div class="container col-md-12" style="margin-top:15px; margin-bottom:15px">
  <div class="row">
    <?php
    while ($event = $req_event->fetch())
    {
      $date = new DateTime($event['date_evenement']);
      echo '<div class="col-md-6 foo">
      <form method="GET" action="page_event.php" class="form-horizontal" style="margin: 0;">
      <div class="well" id="clayevent" style="box-shadow: 2px 3px 10px 1px grey;">
      <div class="row">';
      echo '<button style="text-align:left; margin: 0; padding: 0;border: none; background-color: transparent;text-decoration: none; color: inherit; outline: none;" type="submit" name="id" value="'.$event['id'].'">';
      echo '<div class="col-md-8">' .utf8_encode($event['titre']). '</div>';
      if ($event['categorie'] == 1)
        echo '<div class="col-md-4" style="color: #F2784B;"><i class="flaticon-celebrating"></i> Fun</div>';
      else if ($event['categorie'] == 0)
        echo '<div class="col-md-4" style="color: #D35400;"><span class="flaticon-business112"></span> Pro</div>';
      echo '<div class="col-md-12" style="color: #F2784B;"><blockquote style="font-size: 12px"><i class="material-icons">&#xE873;</i> '. substr(utf8_encode($event['descriptif']), 0, 50) .'[...]<small>Organisé par <cite title="Source Title" style="color: #F2784B;">'. $event['email_contact'] .'</cite></small></blockquote></div>';
      echo '<div class="col-md-3 col-md-offset-9"><small style="font-family: gotham; color: #F2784B">'.$date->format('d/m/Y') . ' à '. $event['heure_evenement'] .'</small></div>';
      echo '</div>
      </div>
      </button>
      </form>
      </div>';
    } ?>
  </div>
</div>
</div>
<?php require_once('footerrecur.php'); ?>
  <script src="https://cdn.jsdelivr.net/scrollreveal.js/3.0.0/scrollreveal.min.js"></script>
  <script>
  var fooReveal = {
    origin   :  'left'  ,
    delay    : 100,
    distance : '10px',
    easing   : 'ease-in',
    scale    : 1.0
  };
  window.sr = ScrollReveal()
  .reveal( '.foo', fooReveal )
  </script>
</body>
</html>
