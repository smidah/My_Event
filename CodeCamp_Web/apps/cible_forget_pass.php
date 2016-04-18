<?php
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	}
	catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	}


if (isset($_POST) && isset($_POST['email_recup'])) 
{
	$req = $bdd->prepare('SELECT * FROM utilisateur WHERE email = ?');
	$req->execute(array($_POST['email_recup']));
	//$save = false;

	while($donnees_email_recup = $req->fetch())
	{
		if ($_POST['email_recup'] == $donnees_email_recup['email'])
		{

				$save = true;
				$var_question = $donnees_email_recup['question_secrete'];
				$var_reponse = $donnees_email_recup['reponse_secrete'];
		}
		
	}

	$req->closeCursor();
		
	if(isset($save))
	{	
		
		echo '<form method="POST" id="form_question">
		<input id="question_secrete" type="text" value="'.$var_question.'" disabled>
		<input id="reponse_secrete" type="text" required>
		<input id="var_reponse" type="hidden" value="'.$var_reponse.'">
		<input id="var_mail" type="hidden" value="'.$_POST['email_recup'].'">
		<input type="submit" name="Envoyer">
		</form>';
	}
	elseif (!isset($save)) 
	{
		//echo 'Cet email n\'existe pas!';
	}
}
	

if (isset($_POST) && isset($_POST['reponse_secrete'])) 
{
	if($_POST['reponse_secrete'] == $_POST['var_reponse'])
	{
		echo '<form method="POST" id="form_new_pass">
		<input id="pass1" type="password" placeholder="Nouveau mot de passe" required>
		<input id="pass2" type="password" placeholder="Confirmation mot de passe" required>
		<input id="var_mail" type="hidden" value="'.$_POST['var_mail'].'">
		<input type="submit" name="Changer mot de passe">
		</form>';
	}
	else
	{
		//echo 'Reponse secrete incorrecte !';
	}
}
											

if(isset($_POST) && isset($_POST['pass1']) && isset($_POST['pass2']))
{
		if ($_POST['pass1'] == $_POST['pass2'])
		{
			$req_change_pwd = $bdd->prepare('UPDATE utilisateur SET
											mot_de_passe = ?
											WHERE email= ?');

			$req_change_pwd->execute(array(hash('sha1', $_POST['pass1']),
											$_POST['var_mail']
											));
			echo '<p class="text text-success">Votre mot de passe a bien été changé !</p>';
		}
		else
		{
			//echo 'Les mots de passe ne sont pas identiques !';
		}
}

?>