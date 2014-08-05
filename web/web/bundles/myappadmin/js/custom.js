$(function(){	
	
	//Script pour gérer l'affichage de la suppréssion d'un objet.
	$('#delete_hide').hide();
	$('.confirm_delete').click(function(){
		$('#delete_hide').slideToggle("show");
	});
	$('.boutonannuler').click(function(){
		$('#delete_hide').hide();
	});
	
	//Script pour la afficher le reste du formulaire, caché par défaut sur les longs formulaires pour éviter les longs scrolls.
	$('.formu_cache').hide();
	$('form.update_state_form h3').click(function(){
		$('.formu_cache').slideToggle("show");
	});
	
	//Script pour afficher la liste de liens des régions pour cette province ou état
	$('.gris_hide').hide();
	$('#lnkdivprovincesetats').click(function(){
		$('.gris_hide').slideToggle("show");
		return false;
	});
	
	//On vérifie si la checkbox nouveau client dans les formulaires ajout et modification attrait est cochée si oui on affiche le champ date pour remplir la date.
	if($("#add_attrait_nouveau_membre").is(":checked")){
		$('#new_member').show();
	}
	else{
		$('#new_member').hide();
		$("#add_attrait_nouveau_membre").click(function(){
			$("#new_member").slideToggle("show");
		});
	}
	
	//Similaire à la fonction plus haut affiche si l'attrait a une date de début et de fin.
	if($("#add_attrait_periode_pour_attrait").is(":checked")){
		$('#date_attrait').show();
	}
	else{
		$('#date_attrait').hide();
		$('#add_attrait_periode_pour_attrait').click(function(){
			$("#date_attrait").slideToggle("show");
		});
	}
	
	//Affiche le calendrier pour rentrer les date si c'est établissement saisonnier.
	if($("#add_hebergement_etablissement_saisonnier").attr("checked")){
		$("#hebergement_saisonnier").show();
	}
	else{
		$("#hebergement_saisonnier").hide();
		$("#add_hebergement_etablissement_saisonnier").click(function(){
			$("#hebergement_saisonnier").slideToggle("show");
		});
	}
	
	//Affiche pour entrer la date du nouveau membre dans le formulaire ajout hébergement
	if($("#add_hebergement_nouveau_membre").attr("checked"))
	{
		$("#hebergement_new_membre").show();
	}
	else{
		$("#hebergement_new_membre").hide();
		$("#add_hebergement_nouveau_membre").click(function(){
			$("#hebergement_new_membre").slideToggle("show");
		});
	}
	
	//Affiche le select option pour rechercher tous les clients qui sont dans cette région, ou cette  zone, où cette ville dans la section clients page d'accueil.
	$("#listRegion").hide();
	$("#listVille").hide();
	$("#listZone").hide();
	$("select#add_tri_validation_statut").click(function(){
		if($('select#add_tri_validation_statut option:selected').val() == 1 || $('select#add_tri_validation_statut option:selected').val() == 0){
			$("#listZone").hide();
			$("#listVille").hide();
			$("#listRegion").hide();
		}
		if($('select#add_tri_validation_statut option:selected').val() == 2){
			$("#listRegion").hide();
			$("#listZone").hide();
			$("#listVille").hide();
			$("#listRegion").slideToggle("show").focus();
		}
		else if($('select#add_tri_validation_statut option:selected').val() == 3){
			$("#listZone").hide();
			$("#listRegion").hide();
			$("#listVille").hide();
			$("#listZone").slideToggle("show").focus();
		}
		else if($('select#add_tri_validation_statut option:selected').val() == 4){
			$("#listVille").hide();
			$("#listZone").hide();
			$("#listRegion").hide();
			$("#listVille").slideToggle("show").focus();
		}
	});
	
	//Affiche le formulaire des politiques pour l'établissement
	$("#politique").hide();
	$("h3.formu_politique").click(function(){
		$("#politique").slideToggle("show");
	});
	
	//Affiche le formulaire pour les vidéos de l'établissement
	$("#video").hide();
	$("h3.formu_video").click(function(){
		$("#video").slideToggle("show");
	});
	
	/*########################################################################################*/
	/*########################## FICHE CLIENT ################################################*/
	/*########################################################################################*/
	
	//Textes de la page activité
	$(".text_activity").hide();
	$("#texte_activite").click(function(){
		$(".text_activity").slideToggle("show");
	});
	//L'express
	$(".lexpress").hide();
	$("#express").click(function(){
		$(".lexpress").slideToggle("show");
	});
	//Tarif et horaire
	$(".tarif_horaire").hide();
	$("#tarifHoraire").click(function(){
		$(".tarif_horaire").slideToggle("show");
	});
	//Modes de paiements
	$(".paiement_accepter").hide();
	$("#paimentAccepte").click(function(){
		$(".paiement_accepter").slideToggle("show");
	});
	//Photographie et logo
	$(".photo_logo").hide();
	$("#photoLogo").click(function(){
		$(".photo_logo").slideToggle("show");
	});
	//Vidéos externes
	$(".movie_externe").hide();
	$("#movieExterne").click(function(){
		$(".movie_externe").slideToggle("show");
	});
	//Vidéos téléchargées
	$(".movie_interne").hide();
	$("#movieInterne").click(function(){
		$(".movie_interne").slideToggle("show");
	});
	//Archives et services
	$(".activite_service").hide();
	$("#activiteService").click(function(){
		$(".activite_service").slideToggle("show");
	});
	//Coupons rabais
	$(".coupon_rabais").hide();
	$("#couponRabais").click(function(){
		$(".coupon_rabais").slideToggle("show");
	});
	//Carte routière
	$(".google_map").hide();
	$("#carteRoutiere").click(function(){
		$(".google_map").slideToggle("show");
	});
	
	/*#########################################################################################*/
	//		Formulaire d'ajout et de modification pour attrait et hébergement
	/*#########################################################################################*/
	
	//Heures supplémentaires
	/*$("#Over_time_Day").hide();
	$("h3#Over_time").click(function(){
		$("#Over_time_Day").slideToggle("show");
	});
	
	//Horaire d'été
	$("#Open_summer").hide();
	$("h3#Hour_summer").click(function(){
		$("#Open_summer").slideToggle("show");
	});
	
	//Horaire d'hiver
	$("#Close_winter").hide();
	$("h3#Hour_winter").click(function(){
		$("#Close_winter").slideToggle("show");
	});*/
    
        //Services hébergement
        $("#Open_service_hebergement").hide();
        $("h3#service_hebergement").click(function(){
                $("#Open_service_hebergement").slideToggle("show");
        });
        
        //Activités de l'hébergements
        $("#Open_activite_hebergement").hide();
	$("h3#activite_hebergement").click(function(){
		$("#Open_activite_hebergement").slideToggle("show");
	});
        
	//Vidéos
	$("#add_attrait_url1_fr").hide();
	$("h3#videoAttr").click(function(){
		$("#add_attrait_url1_fr").slideToggle("show");
	});
	
	//Photos
	$("#thumbnailPhotoPreview").hide();
	$("h3#photoAttr").click(function(){
		$("#thumbnailPhotoPreview").slideToggle("show");
	});
	
	//Voir plus
	$('#see_more').hide();
	$("h3#voir_plus").click(function(){
		$("#see_more").slideToggle("show");
	});
	
	//Galerie photo
	$('#galeriePhotoPreview').hide();
	$("h3#galleriePhotoAttr").click(function(){
		$("#galeriePhotoPreview").slideToggle("show");
	});
        
        //Activités
	$('.attraitactivite').hide();
	$("h3#attraitactivite").click(function(){
		$(".attraitactivite").slideToggle("show");
	});
        
        //Cuisines
	$('.attraitcuisine').hide();
	$("h3#attraitcuisine").click(function(){
		$(".attraitcuisine").slideToggle("show");
	});
	
	//Calendrier haute saison
	$('#Open_calendrier_haute_saison').hide();
	$("h3#haute_saison").css({"cursor":"pointer"});
	$("h3#haute_saison").click(function(){
		$("#Open_calendrier_haute_saison").slideToggle("show");
	});
	
	//Horaire
	$('.attraithoraire').hide();
	$("h3#attraithoraire").click(function(){
		$(".attraithoraire").slideToggle("show");
	});
	
	//Voir plus
	$('.attraitservice').hide();
	$("h3#attraitservice").click(function(){
		$(".attraitservice").slideToggle("show");
	});
	
	//AGRANDIT LE SELECT LORS DU HOVER
	
	//Affiliations formulaire hébergement
	$("#add_hebergement_affiliation_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Types soins de santé coté admin client (formulaire section attrait)
	$("#add_texte_activite_type_soins_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Soins de santé coté admin client (formulaire section attrait)
	$("#add_texte_activite_soins_sante_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Cuisines coté admin client (formulaire section attrait)
	$("#add_texte_activite_cuisine_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Paiements coté admin client (formulaire section attrait)
	$("#add_texte_activite_paiement_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Chambre coté client
	$("#add_chambre_client_type_chambre_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Soins de santé admn global
	$("#add_attrait_soins_sante_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Cuisines
	$("#add_attrait_cuisine_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Modes de paiments
	$("#add_attrait_paiement_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Vidéos
	$("#add_attrait_attrait_video_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Photos
	$("#add_attrait_attrait_photo_id").hover(function(){
		$(this).addClass("ralonger_liste");
	}, 
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Attraits services
	$("#add_attrait_attrait_service_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Attraits activités
	$("#add_attrait_attrait_activite_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	// Qc thématiques
	$("#add_attrait_qcs_thematique_attrait_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Qc échos
	$("#add_attrait_qcs_echo_attrait_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Qc festivals
	$("#add_attrait_qcs_festival_attrait_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Forfaits
	$("#add_attrait_forfait_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Types de chambres
	$("#add_hebergement_hebergement_type_chambre").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des établissements pour le formulaire des salles corporatives
	$("#add_salle_salle_corporative_hebergement").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des styles pour l'hébergement
	$("#add_hebergement_style_hebergement_id").hover(function(){	
		$(this).addClass("ralonger_liste");
	},function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste pour les services de l'hébergement
	$("#add_hebergement_hebergement_service_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des types de chambres pour le formulaire ajout d'une chambre
	$("#add_chambre_type_chambre_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des lits
	$("#add_chambre_lit_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	
	//Liste des modes de paiements formulaire hébergement
	$("#add_hebergement_hebergement_paiements_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des attraits dans le formulaire de la fiche client
	$("#add_customer_attrait_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des hébergements dans le formulaire de la fiche client
	$("#add_customer_hebergement_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des équipements dans le formulaire ajout/modification des chambre
	$("#add_chambre_equipement_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des catégories d'hébergement dans le formulaire ajout/modification des hébergements
	$("#add_hebergement_categorie_hebergement_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des services pour les corporatifs
	$("#add_corporatif_corporatif_service_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des événements pour les corporatifs
	$("#add_corporatif_type_evenement").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des types de soins
	$("#add_attrait_type_soins_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Liste des lits
	$("#add_chambre_client_lit_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	//Équipements de la chambre
	$("#add_chambre_client_equipement_id").hover(function(){
		$(this).addClass("ralonger_liste");
	},
	function(){
		$(".txt_add_state").removeClass("ralonger_liste");
	});
	
	
	
	//Valide que tous les champs obligatoires sont remplis sinon déroule la section du formulaire qui a des champs obligatoires pour les rendrent visibles
	var btn = $('.Btn_form_submit').click(function(){
		//Champs obligatoires dans le formulaire roulé
		var descripfr = $('#add_attrait_metadescription_fr').val();
		var descripen = $('#add_attrait_metadescription_en').val();
		var motclefr = $('#add_attrait_metakeywords_fr').val();
		var motcleen = $('#add_attrait_metakeywords_en').val();
		var monnaie = $('#add_attrait_paiement_id').val();
		var devise = $('#add_attrait_devise_id').val();
		if(descripfr == "" || descripen == "" || motclefr == "" || motcleen == "" || monnaie == "" || devise == "")
		{	
			//Déroule le formulaire
			$('#see_more').css('display','block');
		}
		
		
	});
	
	/*####################################################################*/
	/*						FICHE CLIENT 								  */
	/*####################################################################*/
	
	//Modes de paiements
	$('#add_devise_and_paiement_customer_paiement_id').click(function(){
		$(".txt_add_state2").removeClass("ralonger_liste");
		$(this).addClass("ralonger_liste");
	});
	//Activités
	$("#add_activity_customer_attrait_activite_id").click(function(){
		$(".txt_add_state2").removeClass("ralonger_liste");
		$(this).addClass("ralonger_liste");
	});
	//Services
	$("#add_activity_customer_attrait_service_id").click(function(){
		$(".txt_add_state2").removeClass("ralonger_liste");
		$(this).addClass("ralonger_liste");
	});
	//Soins de santé
	$("#add_activity_customer_soins_sante_id").click(function(){
		$(".txt_add_state2").removeClass("ralonger_liste");
		$(this).addClass("ralonger_liste");
	});
	//Types de soins
	$("#add_activity_customer_type_soins_id").click(function(){
		$(".txt_add_state2").removeClass("ralonger_liste");
		$(this).addClass("ralonger_liste");
	});
	//Cuisines
	$("#add_activity_customer_cuisine_id").click(function(){
		$(".txt_add_state2").removeClass("ralonger_liste");
		$(this).addClass("ralonger_liste");
	});
	
	//Agrandissement lors du survol de la listbox
	$('select.affiche_aquis').hover(function(){
		$(this).addClass("ralonger_liste");
		},
		function(){
			$(this).removeClass("ralonger_liste");
		}
	);
	
	//########################################################################
	//Ajout des classe css pour les formulaires imbriqués qui sont ManyToMany
	//########################################################################
	
	//Formulaire d'ajout des vidéos dans le formulaire des attraits
	$('#add_attrait_url1_fr_0 > div > label').addClass("lblnompays "); //Labels
	
	$('#add_attrait_url1_fr_0 > div > input').addClass("txt_add_state"); //Input type="text"
	
	$('#add_attrait_url1_fr_0 > div > textarea').addClass("txt_add_state"); //Textarea
	
	$('textarea.txt_add_state').after('<p class="resize_p_form">&nbsp;</p>');
	
	/* ***************************************************************************** */
	/*		 Colorie une ligne sur deux dans le tableau de gestion des clients       */
	/* ***************************************************************************** */
	
	$("table.display_info_customer tr:even").addClass('alphaLigne'); //Applique une couleur sur les lignes impaires
	$("table.display_info_customer tr:odd").addClass('betaLigne'); //Applique une couleur sur les lignes paires
	
	//Affiche un autre ajout de photo pour la galerie dans le formulaire d'ajout / modification des chambres
	
	$('#galery1').hide();
	$('#galery2').hide();
	$('#galery3').hide();
	$('#galery4').hide();
	$('input.add_photo_galery').click(function(){
		$('#galery1').show();
		$(this).hide();
	});
	$('#galery1 input.add_photo_galery').click(function(){
		$('#galery2').show();
		$(this).hide();
	});
	$('#galery2 input.add_photo_galery').click(function(){
		$('#galery3').show();
		$(this).hide();
	});
	$('#galery3 input.add_photo_galery').click(function(){
		$('#galery4').show();
	});
	
	/**************************************************************************************************************
	 * 			Ajout dynamique de champs photos pour les galeries
	 **************************************************************************************************************/
		

	//On récupère le div qui contient la collection de galerie.
	var collectionHolder = $('ul.tags');
	
	//On ajoute un lien "ajouter une photo".
	var $addTagLink = $('<a href="#" class="add_tag_galery">Ajouter une photo</a>');
	var $newLinkLi = $('<li></li>').append($addTagLink);
	
	jQuery(document).ready(function() {
	    // ajoute l'ancre « ajouter un tag » et li à la balise ul
	    collectionHolder.append($newLinkLi);

	    $addTagLink.click( function(e) {
	        // empêche le lien de créer un « # » dans l'URL
	        e.preventDefault();

	        // ajoute un nouveau formulaire tag (voir le prochain bloc de code)
	        addTagForm(collectionHolder, $newLinkLi);
	    });
	});
		
	function addTagForm(collectionHolder, $newLinkLi) {
	    // Récupère l'élément ayant l'attribut data-prototype 
	    var prototype = collectionHolder.attr('data-prototype');

	    // Remplace '$$name$$' dans le HTML du prototype par un nombre basé sur
	    // la longueur de la collection courante
	    var newForm = prototype.replace(/\$\$name\$\$/g, collectionHolder.children().length);

	    // Affiche le formulaire dans la page dans un li, avant le lien "ajouter une photo"
	    var $newFormLi = $('<li></li>').append(newForm);
	    $newLinkLi.before($newFormLi);
	}
	
	$('#add_hebergement_galery_id div label:first-child ').addClass("ajusteWidth");
	$('#add_hebergement_galery_id div > div > div input:first-child ').addClass("ajusteInputLegende");
	
	//Ajoute une classe aux labels du formulaire imbriqué pour l'ajout d'un client
	$("ul.tags li div label").addClass('lblnompays');
	$("ul.tags li div label.lblnompays").css("margin-left","0px");
	//Ajoute une classe aux champs input du formulaire ajout d'un client
	$("ul.tags li div input").addClass('txt_add_state');
	$("ul.tags li div input.txt_add_state").css("margin-right","20px");
	$("ul.tags ").children().css({"padding-top" : "0px", "padding-bottom" : "0px"});
	
	$('#add_customer_client div label').addClass("lblnompays");
	$('#add_customer_client div select').addClass("txt_add_state");
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
});



