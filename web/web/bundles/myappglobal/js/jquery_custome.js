$(function(){
	//Champs de recherche affinée 
        $(".rechercheraffinee").hide();
        
	/*#########################################################################*/
	/*     Script pour faire afficher la recherche par carte		   */
	/*#########################################################################*/
	//On cache la recherche par carte
	$('#google_api').hide();
	$('.map_interactive').click(function(){	//Si on clique sur « OÙ SOUHAITEZ VOUS ALLER ? »
		$(this).addClass('cache_img_map');	//On ajoute une classe a l'image que l'on viend de cliquer pour la cachée
		$('#google_api').slideToggle("show");	//On fait dérouler la recherche par carte
		if($('img').hasClass('cache_img_map'))	//On vérifie que si « OÙ SOUHAITEZ VOUS ALLER ? » est caché on donne l'action du click ou souhaitez vous aller de la recherche
		{
			$('#google_api > .header_google_api').click(function(){	//Si on clique on cache la carte et on reaffiche l'image « OÙ SOUHAITEZ VOUS ALLER ? »
				$('#google_api').hide();
				$('.map_interactive').removeClass('cache_img_map');
			});
		}
	});
	
	//Efface le value dans le moteur de recherche
	$('#moteursearch').click(function(){
		$(this).removeAttr("value");
	});
	
	$('p#legendeRegion').next('h3').css('margin-top', '-40px');
	
	//Sélectionne par défault le radio hébergement dans la carte
	$('#google_hebergement').attr('checked', 'checked');
	
	//Sélectionne par défault la province Québec pour le formulaire d'appel d'offre, section « CORPORATIF »
	//var value = $("#select2 option:selected").selectedIndex = 8;
           
        //On affiche le bouton imprimer lors du clic sur le bouton calculer l'initéraire'
        $('input.imprimerItineraire').hide();
            $('input.calculItineraire').click(function(){
                $('input.imprimerItineraire').show();
         });
	
	//Cache les autres images de la galerie pour ne pas avoir toute la liste afficher dans la section chambre du mini site
	$("#gauche").each(function(){
		$(".fiche div > a.fancybox").hide();
		$(".fiche div a:first-child").show();
	});
	
	//Empêche de déclencher une erreur si le client n'a pas de galerie photo si on clique sur la photo de la chambre par défault.
	$(".photoChambre").click(function(){
		return false;
	});
	
	//Ajoute un astérisque rouge après le label des champs obligatoires
	 $("label.obligatoire").append("<span class='asterisquerequired'>*</span>");
	 
	//Affiche le logo global lors du scroll
	 $(window).scroll(function(){  
		    posScroll = $(document).scrollTop();  
		    if(posScroll >=180)  
		        $('img#logoblanc').fadeIn(600);  
		    else  
		        $('img#logoblanc').fadeOut(600);  
	});  
        
        // filtre les liens et images dans la colonne de droite pour les fiches clients.      
        $("#cleanLink").each(function(){
            $("#cleanLink img").remove();
            $("#cleanLink a").remove();
        });
        
        //filtre les images et les liens pour les directions routières
        $(".textedirectionperso").each(function(){
            $(".textedirectionperso img").remove();
            $(".textedirectionperso a").remove();
        });
        
        //recherche affinée
        $("#rechercheraffinee").on("click", function(){
           $(".rechercheraffinee").slideToggle();            
        });
        //décoche la case si on rafraichit la page.
        if($(".rechercheraffinee").attr("style", "display:none")){
            $("#rechercheraffinee").removeAttr("checked");
        }
       
});