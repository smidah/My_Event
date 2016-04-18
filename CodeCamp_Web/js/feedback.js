$('document').ready(function(){

	$('#bouton_commentaire').submit(function(){

			
			var id_evenement = $('#id_evenement').val();
			var login_utilisateur = $('#login_utilisateur').val();
			var feedback_star = $('#feedback_star').val();
			var commentaire = $('#commentaire').val();


			$.post('../apps/cible_commentaire.php', {id_evenement:id_evenement, login_utilisateur:login_utilisateur, feedback_star:feedback_star, commentaire:commentaire}, function(donnees_feedback){

				$('#popup_momo').remove();
				$('body').append(donnees_feedback);
				$('#commentaire').val("");

			});

			return false;

		});

});