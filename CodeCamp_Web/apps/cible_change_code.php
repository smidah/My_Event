<?php
if (isset($_POST) && isset($_POST['code']))
{
	if ($_POST['code'] == $_POST['verif_code'])
	{
		$req_change_pass = $bdd->prepare('UPDATE code_entreprise set code = ?');
		$req_change_pass->execute(array($_POST['code']));
		echo 'réussi';
	}
	else
		echo 'Les codes ne sont pas identiques';
}

?>

<form method="POST">
	<input type="password" name="code" required>
	<input type="password" name="verif_code" required>
	<input type="submit" value="Valider">
</form>