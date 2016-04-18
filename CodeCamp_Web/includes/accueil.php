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
        <div class="row">
         <div class="col-md-offset-1 col-md-10" style="margin-top: 15px;">
          <div class="well well-lg" id="my-calendar" style="background-color: #ddd"></div>
        </div>
      </div>
    </div>
    <div class="col-md-12" id="actu">
     <div class="container-fluid">
      <div class="row">
       <div class="col-md-12">
        <div class="well" id="orange" style="text-align: center; font-size: 120%;">
         Dernières programmations !
       </div>
     </div>
     <div class="container-fluid">
       <div class="col-md-6">
        <div class="well" id="anticlay" style="text-align: center;">
         <img width="20" height="20" src="img/Coktail.png"> New Events Fun
       </div>
       <div class="row">
        <?php
        while ($result = $req_eventfun->fetch()) {
          echo '<a href="includes/page_event.php?id='. $result->id .'"><div class="col-md-6" style="padding: 0;">
          <div class="well foo" id="vitrine" style="text-align: center; padding: 0;">';
          echo '<p style="width: 100%; background-color: #222; color: white; text-align: center; font-family: gotham ;padding: 10px; margin-bottom:0;"><img width="20" height="20" src="img/Coktail.png"> ' . utf8_encode(ucfirst($result->titre)) . "</p>";
          if (empty($result->image))
            echo '<img src="img/background_signin.png" id="imgvitrine" style="padding: 0px; width: 100%;" height="200">';
          else
            echo '<img src="includes/' . $result->image  . '" id="imgvitrine" style="padding: 0px; width: 100%;" height="200">';
          echo '<div>';
          echo '<p style="width: 100%;text-align: left; font-family: gotham ;padding: 15px;"><span style="color: #ff6908;">Le </span>: ' . $result->date_evenement . " à " .  $result->heure_evenement .".<br> <span style='color: #ff6908;'>Agence</span> : ". $result->agence .
          '</p><p style="width: 100%; background-color: #eeeeee; color: #222; text-align: right; font-family: gotham ;padding: 10px;"><span style="color: #ff6908;">Lieu </span>: '. utf8_encode(ucfirst($result->lieu)) ."</div></div></div></a>";
        }
        ?>
      </div>
    </div>
    <div class="col-md-6">
      <div class="well" id="anticlay" style="text-align: center;">
        <img width="20" height="20" src="img/09o.png"> New Events Pro
      </div>
      <div class="row">
        <?php
        while ($result = $req_eventpro->fetch()) {
          echo '<a href="includes/page_event.php?id='. $result->id .'"><div class="col-md-6" style="padding: 0;">';
          echo '<div class="well foo" id="vitrine" style="text-align: center; padding: 0;">';
          echo '<p style="width: 100%; background-color: #222; color: white; text-align: center; font-family: gotham ;padding: 10px; margin-bottom:0;"><img width="20" height="20" src="img/09o.png"> ' . utf8_encode(ucfirst($result->titre)) . "</p>";
          if (empty($result->image))
            echo '<img src="img/background_signin.png" id="imgvitrine" style="padding: 0; width: 100%;" height="200">';
          else
            echo '<img src="includes/' . $result->image  . '" id="imgvitrine" style="padding: 0; width: 100%;" height="200">';
          echo '<div>';
          echo '<p style="width: 100%;text-align: left; font-family: gotham ;padding: 15px;"><span style="color: #ff6908;">Le </span>: ' . $result->date_evenement . " à " .  $result->heure_evenement .".<br> <span style='color: #ff6908;'>Agence </span>: ". $result->agence .
          '</p><p style="width: 100%; background-color: #eeeeee; color: #222; text-align: right; font-family: gotham ;padding: 10px;"><span style="color: #ff6908;">Lieu </span>: '. utf8_encode(ucfirst($result->lieu)) ."</div></div></div></a>";
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


<!-- charger le calendrier -->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="application/javascript">

$(document).ready(function () {

  $("#my-calendar").zabuto_calendar({
    ajax: {
      url: "show_data.php",
      modal: true,
      dataType : 'json'
    }
  });



});
</script>



<script src="js/calend.js"></script>

<script type="application/javascript">
// function my_calend()
// {
//   $(document).ready(function ()
//   {
//     $(".event").on("click", function(){
//       var date = $(this).attr('title');

//        $.post('apps/cible_calend.php', {date:date}, function(donnees){
//        $('body').append(donnees);})
//        });
//   });

//clearInterval(timer);


// window.onload = function() { 
 
//   my_calend();

</script>





