<?php 
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="donneuser.xls"');

try {
        $bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
}

$req = $bdd->prepare('SELECT * FROM utilisateur');
$req->execute();
echo '<table>
	<tr>
	<td>Nom</td>
	<td>Prenom</td>
	<td>Login</td>
	<td>Email</td>
	<td>Telephone</td>
	<td>Sexe</td>
	<td>Agence</td>
	</tr>';
while ($data = $req->fetch())
{
	 echo ' <tr><td>'.$data['nom'].'</td>';
	 echo '<td>'.$data['prenom'].'</td>';
	 echo '<td>'.$data['login'].'</td>';
	 echo '<td>'.$data['email'].'</td>';
	 echo '<td>0'.$data['telephone'].'</td>';
	 if ($data['sexe'] == 0)
	 	echo '<td>Femme</td>';
	 else
	 	echo '<td>Homme</td>';
	 echo '<td>'.$data['agence'].'</td></tr>';
}
 
  $req->closeCursor(); // Termine le traitement de la requête

?>