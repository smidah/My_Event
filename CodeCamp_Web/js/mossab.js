$('document').ready(function(){

	////////////LISTING PARTICIPANT////////////////////////////
	var id_event = $('#id_evenement').val();
	var id_utilisateur = $('#id_utilisateur').val();

	// liste participant qui se charge dans la page de base
	$.post('../apps/list_particip.php', {id_evenement:id_event, id_utilisateur:id_utilisateur}, function(donnees_list_1){

		$('#listing_participant').append(donnees_list_1);

	});



	$('#star_5').click(function(){
			$(this).css({
				"color": '#ff6908'
			});
			
			$(this).prevUntil(rating, 'i').css({
				"color": '#ff6908'
			});

			$('#feedback_star').val('5');

	});

	$('#star_4').click(function(){
			$(this).css({
				"color": '#ff6908'
			});
			$(this).prevUntil(rating, 'i').css({
				"color": '#ff6908'
			});
			$(this).nextUntil(rating, 'i').css({
				"color": '#222'
			});

			$('#feedback_star').val('4');

	});

	$('#star_3').click(function(){
			$(this).css({
				"color": '#ff6908'
			});
			$(this).prevUntil(rating, 'i').css({
				"color": '#ff6908'
			});
			$(this).nextUntil(rating, 'i').css({
				"color": '#222'
			});
			$('#feedback_star').val('3');
	});

	$('#star_2').click(function(){
			$(this).css({
				"color": '#ff6908'
			});
			$(this).prevUntil(rating, 'i').css({
				"color": '#ff6908'
			});
			$(this).nextUntil(rating, 'i').css({
				"color": '#222'
			});
			$('#feedback_star').val('2');
	});

	$('#star_1').click(function(){
			$(this).css({
				"color": '#ff6908'
			});
			$(this).prevUntil(rating, 'i').css({
				"color": '#ff6908'
			});
			$(this).nextUntil(rating, 'i').css({
				"color": '#222'
			});
			$('#feedback_star').val('1');
	});

});