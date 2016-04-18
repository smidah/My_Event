<?php
$req_pays = $bdd->query('SELECT * FROM pays');
$req_users = $bdd->query('SELECT * FROM utilisateur');
$req_code = $bdd->query('SELECT * FROM code_entreprise');

if (isset($_POST) && isset($_POST['nom'])) {
	while ($list_users = $req_users->fetch())
	{
		if ($list_users['login'] == $_POST['login'])
			$login_user = true;
		if ($list_users['email'] == $_POST['email'])
			$email_user = true;
	}

	$code = $req_code->fetch();
	if ($code['code'] == $_POST['code_entreprise'])
	{
		$code_user = true;
	}

	if ($_POST['mot_de_passe'] != $_POST['verif_mot_de_passe'])
	{
		echo '<div class="alert alert-danger" style="margin: 0;">
		<strong><i class="fa fa-exclamation-triangle"></i> Erreur!</strong> Veuillez confirmer votre mot de passe.
		</div>';
		$mdp_pas_identique = true;
	}
	if (isset($login_user))
		echo '<div class="alert alert-danger" style="margin: 0;">
	<strong><i class="fa fa-exclamation-triangle"></i> Erreur!</strong> Ce login n\'est plus disponible.
	</div>';
	if (isset($email_user))
		echo '<div class="alert alert-danger" style="margin: 0;">
	<strong><i class="fa fa-exclamation-triangle"></i> Erreur!</strong> Cet Email n\'est plus disponible.
	</div>';
	if (!isset($code_user))
		echo '<div class="alert alert-danger" style="margin: 0;">
	<strong><i class="fa fa-exclamation-triangle"></i> Erreur!</strong> Le code entreprise est invalide.
	</div>';

	else if (!isset($login_user) && !isset($email_user) && isset($code_user) && !isset($mdp_pas_identique))
	{
		$genre = intval($_POST['sexe']);
		$req_pre = $bdd->prepare('INSERT INTO utilisateur (nom, prenom, sexe, email, question_secrete, reponse_secrete, login, mot_de_passe, telephone, agence, date_creation) 
			VALUES (:nom, :prenom, :sexe, :email, :question_secrete, :reponse_secrete, :login, :mot_de_passe, :telephone, :agence, NOW())');
		$req_pre->execute(array(
			'nom' => $_POST['nom'],
			'prenom' => $_POST['prenom'],
			'sexe' => $genre,
			'email' => $_POST['email'],
			'question_secrete' => $_POST['question_secrete'],
			'reponse_secrete' => $_POST['reponse_secrete'],
			'login' => $_POST['login'],
			'mot_de_passe' => hash('sha1', $_POST['mot_de_passe']),
			'telephone'=> $_POST['telephone'],
			'agence' => $_POST['agence']
			));

		function johnny($email, $nom, $prenom, $login) {
			require_once "phpmailer/vendor/autoload.php";

			$mail = new PHPMailer;
		//Enable SMTP debugging. 
		//	$mail->SMTPDebug = 3;                               
		//Set PHPMailer to use SMTP.
			$mail->isSMTP();            
		//Set SMTP host name                          
			$mail->Host = "smtp.gmail.com";
		//Set this to true if SMTP host requires authentication to send email
			$mail->SMTPAuth = true;                          
		//Provide username and password     
			$mail->Username = "reminder.extia@gmail.com";                 
			$mail->Password = "reminderextia";                           
		//If SMTP requires TLS encryption then set it
			$mail->SMTPSecure = "ssl";                           
		//Set TCP port to connect to 
			$mail->Port = 465;                                   

			$mail->From = "reminder.extia@gmail.com";
			$mail->FromName = "EXTIA EVENT";

			$mail->addAddress($email, "Collabs");

			$mail->isHTML(true);

			$mail->Subject = "Inscription à EXTIA EVENT";
			$mail->Body = 'Bonjour '.$nom.' '.$prenom.'  vous êtes maintenant inscrit &agrave; EXTIA EVENT. <br/><br/> Voici votre login : '.$login.' <br/> <br/> <br/><br/> ';

			if(!$mail->send()) {
				//echo "Mailer Error: " . $mail->ErrorInfo;
			} 
			else {
				//echo "Message has been sent successfully";
			}
		}
		johnny($_POST['email'], $_POST['nom'], $_POST['prenom'], $_POST['login']);

		echo '<div class="opaque"><div class="alert alert-success" id="poppy">
		Bravo, tu es inscrit !<br>
		<i class="fa fa-spinner fa-pulse fa-5x"></i>
		</div></div>';
		header( "refresh:2;url=index.php" ); 
	}
}
?>