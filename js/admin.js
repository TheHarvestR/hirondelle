$(document).ready( function() {
	$( "#datepicker" ).datepicker( $.datepicker.regional[ "fr" ] );
	$("#dialog").dialog({
		autoOpen: false,
		modal: true,
		resizable: false,
		width: "auto",
		dialogClass: "dlg-no-close",
		buttons: { 
			"OUI": function() { 
				$(this).dialog("close");
				$('.uni-form-wrap').css('display','none');
				callback(true);
			},
			"NON": function() { 
				$(this).dialog("close"); 
				callback(false);
			}
		}
	});
});

$('#btnnew').on('click', function(event) {
	/* Centrage du formulaire */
	var largeur_fenetre = $(window).width();
	var gauche = (largeur_fenetre - $('.uni-form-wrap').width()) / 2 + $(window).scrollLeft();
	$('.uni-form-wrap').css({position: 'absolute', left: gauche});	
	
	/* Désactivation du bouton supprimer */
	$('#btndelete').hide();

	/* Affichage du formulaire */
	$('.uni-form-wrap').css('display','block');

	/* Vide la fenêtre des données précédentes */
	$('#id').val(0);
	$('#datepicker').val('');
	$('#titre').val('');
	$('#texte').val('');
	$('#lien').val('');
	$('#externe').prop('checked', false);
	$('#accueil').prop('checked', true);
});

$('#btnarchives').on('click', function(event) {
	$.get( "genere_archives.php" );
});

$('#actus').find('tr:not(.hors_champ)').click( function(){
    var newsid = $(this).find('td:first').text();

    /* requête AJAX vers le serveur */
	$.get('news_get.php', {id : newsid}, function(data) {
		if (data == "vide" || data == "noindex") {
			alert("Cette actualité n'existe plus");
			location.reload();
		} else {
			var ligne = data.split("|");
			$('#id').attr('value', newsid);
			$('#datepicker').val(ligne[1]);
			$('#titre').val(ligne[2]);
			$('#texte').val(ligne[3]);
			$('#lien').val(ligne[4]);
			if (ligne[5] == 1) { 
				$('#externe').prop('checked', true);
			} else {
				$('#externe').prop('checked', false);
			}
			if (ligne[6] == 1) {
				$('#accueil').prop('checked', true);
			} else if (ligne[7] == 1) {
				$('#archive').prop('checked', true);
			} else {
				$('#aucun').prop('checked', true);
			}
			/* Masquage du fond */
			$('body').append('<div id="mask"></div>');
			var maskHeight = $(document).height();
			var maskWidth = $(window).width();
			$('#mask').css({'width':maskWidth,'height':maskHeight});
    
			/* Centrage du formulaire */
			var largeur_fenetre = $(window).width();
			var gauche = (largeur_fenetre - $('.uni-form-wrap').width()) / 2 + $(window).scrollLeft();
			$('.uni-form-wrap').css({position: 'absolute', left: gauche});	

			/* Réactivation du bouton supprimer */
			$('#btndelete').show();

			/* Affichage du formulaire */
			$('.uni-form-wrap').css('display','block');
		}
	}
	, 'text');
});

$('#btndelete').on('click', function(event) {
	event.preventDefault();
	$("#dialog").dialog("open");
});

function callback(reponse){
	if (reponse) {
		$.post( "news_supprime.php", {id : $("#id").val()}, function(data) {
			if (data.indexOf("erreur_suppression") > -1) {
				alert("La suppression n'a pas pu être effectuée.");
			}
			location.reload();
			$('.uni-form-wrap').css('display','none');
			$('#mask').remove();
			$.get( "genere_news.php" );
			$.get( "genere_archives.php" );
		},
		'text');
	} 
}

$('#btnclose').on('click', function(event) {
	event.preventDefault();
	$('.uni-form-wrap').css('display','none');
	$('#mask').remove();
});


$('#btnsave').on('click', function(event) {
	event.preventDefault();
	/* Prépare le tableau de variables à envoyer */
	var envoi = [];
	envoi[0] = $('#id').val();
	envoi[1] = $('#datepicker').val();
	envoi[2] = $('#titre').val();
	envoi[3] = $('#texte').val();
	if ($('#accueil').is(':checked')) {
		envoi[4] = 1;
	} else {
		envoi[4] = 0;
	}
	if ($('#archive').is(':checked')) {
		envoi[5] = 1;
	} else {
		envoi[5] = 0;
	}
	envoi[6] = $('#lien').val();
	if ($('#externe').is(':checked')) {
		envoi[7] = 1;
	} else {
		envoi[7] = 0;
	}

	/* Envoi avec AJAX */
	$.post('news_write.php', {  
		id : envoi[0],
		datefr : envoi[1],
		titre : envoi[2],
		texte : envoi[3],
		afficher : envoi[4],
		archive : envoi[5],
		lien : envoi[6],
		externe : envoi[7]
		},
		function(data) {
		if (data.indexOf("erreur_") > -1) {
				alert("Cette actualité n'a pas pu être enregistrée. ");
			}
			location.reload();
			$('.uni-form-wrap').css('display','none');
			$('#mask').remove();
			$.get( "genere_news.php" );
			$.get( "genere_archives.php" );
		}, 
		'text'
	);
});

