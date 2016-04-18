<?php
if(isset($_POST) && isset($_POST['login'])) {
    //On créer les variables
    $login =   $_POST['login'];
    $password = $_POST['password'];
    $password = hash("sha1", $password);
    $req = $bdd->query('select mot_de_passe from utilisateur where login="'.$login.'"');
    $req->setFetchMode(PDO::FETCH_OBJ);
    $result = $req->fetch();
    if (empty($result->mot_de_passe) || isset($result->mot_de_passe) == false)
        echo '<div class="alert alert-dismissible alert-danger">
    <strong><i class="fa fa-exclamation-triangle"></i> Erreur !</strong>
    <p>Utilisateur inconnu.</p>
    </div>';
    else {
        if ($result->mot_de_passe != $password)
            echo '<div class="alert alert-dismissible alert-danger">
        <strong><i class="fa fa-exclamation-triangle"></i> Erreur !</strong>
        <p>Mauvais mot de passe.<br><strong><a href="#modmod" data-toggle="modal" data-target=".bs-example-modal-sm">Mot de passe oublié ?</a></strong></p>
        </div>
        <div class="modal fade bs-example-modal-sm" tabindex="-1" id="modmod" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
        <div class="modal-content" style="padding: 15px;">
        <p style="padding: 0; text-align: center;">Mot de Passe oublié</p><hr>

        <form method="POST" id="forget_button" style="padding-bottom: 15px;">
        <input id="email_recup" type="email" placeholder="Entrez votre email" required>
        <input type="submit" value="Envoyer" id="envoyer">
        </form>
</div>
</div>
</div>';
else if ($result->mot_de_passe == $password) {
    session_start();
    $_SESSION['login'] = $login;

    header("Location: index.php");
}
}
}
?>
<script src="../js/forget_pass.js"></script>