<?php 
try {
    $bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<?php

    $req = $bdd->prepare('SELECT * FROM evenement WHERE date_evenement = ?');
    $req->execute(array($_POST['date']));

    while ($reponse = $req->fetch())
    {
        echo '<div style="position: absolute;"> '.$reponse['date_evenement'].'
                '.$reponse['titre'].'</div><br/>';
    }

    //echo ($date);
  ?>