$('document').ready(function(){

	$('#bouton_join_event').submit(function(){

		var id_event = $('#id_evenement').val();
		var id_utilisateur = $('#id_utilisateur').val();
		var participer = $(this).find('#participer').val();

		$.post('../apps/cible_join_event.php', {participer:participer, id_evenement:id_event}, function(donnees){

			$('#popup_momo').remove();
			$('body').append(donnees);

			$.post('../apps/list_particip.php', {id_evenement:id_event, id_utilisateur:id_utilisateur}, function(donnees_list_3){

					$('#listing_participant').empty();
					$('#listing_participant').append(donnees_list_3);
			});

		});

		return false;
	});


});