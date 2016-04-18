<html>
<?php require_once('includes/head.php'); ?>
<body>
	<?php session_start(); ?>
	<?php if (isset($_SESSION['login'])) require_once('includes/header.php'); ?>
	<?php
	if (!isset($_GET['sign'])) {
		if (isset($_SESSION['login']))
			require_once('includes/accueil.php');
		else
			require_once('includes/sign.php');
	}
	else if (isset($_GET['sign']) && $_GET['sign'] == "up") {
		require_once('includes/inscription.php');
	}

	else
		require_once('includes/sign.php');
	?>
	<?php require_once('includes/footer.php'); ?>
	<script src="js/forget_pass.js"></script>
	<script src="https://cdn.jsdelivr.net/scrollreveal.js/3.0.0/scrollreveal.min.js"></script>
	<script>
	var fooReveal = {
		origin   :  'left'  ,
		delay    : 100,
		distance : '10px',
		easing   : 'ease-in',
		scale    : 1.0
	};
	window.sr = ScrollReveal()
	.reveal( '.foo', fooReveal )
	</script>
</body>
</html>