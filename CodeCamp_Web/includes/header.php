  <?php //session_start();
  if(!isset($_SESSION['login'])) {
  	header("Location: ../index.php");
  } ?>
  <header>
  	<div class="navbar navbar-material-light-blue-300" id="navbar" style="margin: 0;">
  		<div class="container-fluid">
  			<div class="navbar-header">
  				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-material-light-blue-collapse">
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  					<span class="icon-bar"></span>
  				</button>
  				<a class="navbar-brand" id="bar" href="http://www.extia.fr/"><i class="material-icons">&#xE88A;</i></a>
  			</div>
  			<div class="navbar-collapse collapse navbar-material-light-blue-collapse">
  				<ul class="nav navbar-nav">
  					<li><a href="" id="a" class="a1"><img width="20" height="20" src="img/Articles presse.png"> </a></li>
  					<li><a href="includes/dashboard.php" id="a" class="a2"><img width="20" height="20" src="img/4.png"> </a></li>
  					<li><a href="includes/events.php" id="a" class="a3"><img width="20" height="20" src="img/Coktail.png"> </a></li>
            <li><a href="includes/archives.php" id="a" class="a6"><img width="20" height="20" src="img/Ingénieur et architecte orange.png"></a></li>
            <?php
            $req = $bdd->query('select * from utilisateur where login="'.$_SESSION['login'].'"');
            $req->setFetchMode(PDO::FETCH_OBJ);
            $result = $req->fetch();
            if ($result->role != 4)
              echo '<li><a href="includes/activity.php" id="a" class="a4"><img width="20" height="20" src="img/croissance.png"> </a></li>';
            ?>
            <li><a href="includes/mailbox.php" id="a" class="a5"><img width="20" height="20" src="img/rs.png"> </a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
           <li><a href="apps/logout.php" id="ad"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span> Déconnexion</a></li>
         </ul>
       </div>
     </div>
   </div>
 </header>