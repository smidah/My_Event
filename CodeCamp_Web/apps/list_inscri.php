<?php
	
	$req_list = $bdd->prepare('SELECT nom, prenom, sexe, login, email, telephone, agence, date_creation 
								FROM utilisateur ORDER BY date_creation ASC');
	$req_list->execute();
		while($list = $req_list->fetch())
		{
			echo $list['nom']." ";
			echo $list['prenom']." ";
			echo $list['sexe']." ";
			echo $list['login']." ";
			echo $list['email']." ";
			echo $list['telephone']." ";
			echo $list['agence']." ";
			echo $list['date_creation'];
			echo "<br/>";
		}
?>