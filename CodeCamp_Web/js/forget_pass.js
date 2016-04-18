$('document').ready(function(){

	$('#forget_button').submit(function(){
		var email_recup = $("#email_recup").val();

		$.post('apps/cible_forget_pass.php', {email_recup:email_recup}, function(donnees){
			
			$('#forget_button').after(donnees);

			 var form_exist = $('#form_question');

			 if (form_exist.length)
				$('#forget_button').remove();

			var reponse_secrete_recup = $("#var_reponse").val();

			$("#var_reponse").remove();
			
			//////////////////////////////////////////////////////
			$('#form_question').submit(function(){

				var reponse_tape = $('#reponse_secrete').val();

				

				$.post('apps/cible_forget_pass.php', {reponse_secrete:reponse_tape, var_reponse:reponse_secrete_recup,  var_mail:email_recup}, function(donnees_2){
					$('#form_question').after(donnees_2);

					var form_exist = $('#form_new_pass');

				 	if (form_exist.length)
						$('#form_question').remove();

						////////////////////////////////////////////////////////////
						$('#form_new_pass').submit(function(){

							var pass1 = $('#pass1').val();
							var pass2 = $('#pass2').val();

							$.post('apps/cible_forget_pass.php', {pass1:pass1, pass2:pass2, var_mail:email_recup}, function(donnees_2){
								
								$('#form_new_pass').after(donnees_2);

							})

							return false;
						});

				})	

				return false;
			});
		})

		return false;
	});




});