$('document').ready(function(){
	

	$('#bouton_desinscrire').submit(function(){

		var id_event = $(this).find('#id_evenement').val();
		var desinscrire = $(this).find('#desinscrire_event').val();
		var id_utilisateur = $(this).find('#id_utilisateur').val();

		$.post('../apps/cible_desinscrire_event.php', {desinscrire_event:desinscrire, id_evenement:id_event}, function(donnees){

			$('#popup_momo').remove();
			$('body').append(donnees);

			$.post('../apps/list_particip.php', {id_evenement:id_event, id_utilisateur:id_utilisateur}, function(donnees_list){

				$('#listing_participant').empty();
				$('#listing_participant').append(donnees_list);
			});

		});

		return false;
	});


});