<?php 
try {
    $bdd = new PDO('mysql:host=localhost;dbname=Projet_Extia', 'webadmin', '123',  array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<?php

    $req = $bdd->query('SELECT * FROM evenement WHERE date_evenement > NOW()');

    $dates = array();

    while ($reponse = $req->fetch())
    {

        $dates[$i] = array(
            'date' => $reponse['date_evenement'],
            'badge' => true,
            'title' => $reponse['date_evenement'],
            'body' =>  '<p class="lead">'.$reponse['titre'].'</p><p>'.$reponse['agence'].' '.$reponse['date_evenement'].'</p>',
            'footer' => '<a href="includes/page_event.php?id='.$reponse['id'].'">Plus d\'informations</a>'
        );     
        $i++;
    }

    echo json_encode($dates);
  ?>