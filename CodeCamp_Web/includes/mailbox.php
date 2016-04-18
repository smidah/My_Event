<html>
<?php require_once('headrecur.php'); ?>
<body style="background-color: #394147;">
	<title>Extia - Messagerie</title>
	<?php session_start();
	if (!isset($_SESSION['login'])) 
	{
		header("Location: ../index.php");
	} ?>
	<?php require_once('headerrecur.php'); ?>
	<div class="container-fluid" style="min-height: 86.5vh; background-color: #eeeeee">
		<?php
		if (isset($_POST['envoi_question']) && isset($_POST['id_utilisateur']) && isset($_POST['id_evenement']) )
		{
			require_once('envoi_question.php');
		}
		else if (isset($_POST['repondre_question']) && isset($_POST['nom_utilisateur']) && isset($_POST['id_evenement']) )
		{
			require_once('repondre_question.php');
		}
		else if (isset($_POST['aff_reponse']) && isset($_POST['nom_utilisateur']) && isset($_POST['id_evenement']) )
		{
			require_once('aff_reponse.php');
		}
		else
		{
			require_once('aff_question.php');
		}
		?>			
	</div>
	<?php require_once('footerrecur.php'); ?>
</body>
</html>
