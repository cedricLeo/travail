 $(function(){
        //Ajuste les jours du calendrier
     /*   dateToday = new Date();
        dateToday.getDate();
        jourArrive = document.getElementById("reservationOnline_datedebut_day");
       //Met à jour les jours pour la date arrivée 
        for(i = 0; i < jourArrive.options.length; i++)
        {
                if(jourArrive.options[i].value == dateToday.getDate())
                {
                       jourArrive.selectedIndex = i;
                }
        }
       jourDepart = document.getElementById("reservationOnline_datefin_day");
       //Met à jour les jours pour la date départ
       for(i = 0; i < jourDepart.options.length; i++)
       {
               if(jourDepart.options[i].value == (dateToday.getDate() + 1) )
               {
                       jourDepart.selectedIndex = i;
               }
       }
       moisArrive = document.getElementById("reservationOnline_datedebut_month");
       //Met à jour le mois pour la date arrivée
       for(i = 0; i < moisArrive.options.length; i++)
       {
               if(moisArrive.options[i].value == dateToday.getMonth() + 1)
               {
                       moisArrive.selectedIndex = i;
               }
       }			
       moisDepart = document.getElementById("reservationOnline_datefin_month");
       //Met à jour le mois pour la date de départ 
       for(i = 0; i < moisDepart.options.length; i++)
       {
               if(moisDepart.options[i].value == dateToday.getMonth() + 1)
               {
                       moisDepart.selectedIndex = i;
               }
       }
       anneeDepart = document.getElementById("reservationOnline_datefin_year");
       for(i = 0; i < anneeDepart.options.length; i++)
       {
               if(anneeDepart.options[i].value == dateToday.getFullYear())
                       anneeDepart.selectedIndex = i;
       }
       anneeArrive = document.getElementById("reservationOnline_datedebut_year");
       for(i = 0; i < anneeArrive.options.length; i++)
       {
               if(anneeArrive.options[i].value == dateToday.getFullYear())
                       anneeArrive.selectedIndex = i;
       }
       //Ajout des variables pour le reservit
       $(function(){
               //Pour la date arrivée par défault
                if($("#reservationOnline_datedebut_month option:selected").val() < 10){
                         $("#begindate").attr('value', $("#reservationOnline_datedebut_day option:selected").val()+'/0'+$("#reservationOnline_datedebut_month option:selected").val()+'/'+$("#reservationOnline_datedebut_year option:selected").val());
                 }
                 else{
                         $("#begindate").attr('value', $("#reservationOnline_datedebut_day option:selected").val()+'/'+$("#reservationOnline_datedebut_month option:selected").val()+'/'+$("#reservationOnline_datedebut_year option:selected").val());
                 }
                 //Si on change le jour de la date d'arrivée
                 $("#reservationOnline_datedebut_day").change(function(){
                         jourArriveeChamge = true;
                         modifArrivee();
                 });
                 //Si on change le mois de la date d'arrivée
                 $("#reservationOnline_datedebut_month").change(function(){
                         moisArriveeChamge = true;
                         modifArrivee();
                 });
                 //Si on change le année de la date d'arrivée
                 $("#reservationOnline_datedebut_year").change(function(){
                         anneeArriveeChamge = true;
                         modifArrivee();
                 });
                 function modifArrivee(){
                         if($("#reservationOnline_datedebut_month option:selected").val() < 10 && jourArriveeChange ==  true || $("#reservationOnline_datedebut_month option:selected").val() < 10 && moisArriveeChange ==  true || $("#reservationOnline_datedebut_month option:selected").val() < 10 && anneeArriveeChange ==  true)
                                 $("#begindate").attr('value', $("#reservationOnline_datedebut_day option:selected").val()+'/0'+$("#reservationOnline_datedebut_month option:selected").val()+'/'+$("#reservationOnline_datedebut_year option:selected").val());
                         else
                                 $("#begindate").attr('value', $("#reservationOnline_datedebut_day option:selected").val()+'/'+$("#reservationOnline_datedebut_month option:selected").val()+'/'+$("#reservationOnline_datedebut_year option:selected").val());  
                 }
               //##############################################################################
               //Pour la date du départ par défault
                 if($("#reservationOnline_datefin_month option:selected").val() < 10){
                         $("#enddate").attr('value', $("#reservationOnline_datefin_day option:selected").val()+'/0'+$("#reservationOnline_datefin_month option:selected").val()+'/'+$("#reservationOnline_datefin_year option:selected").val());
                 }
                 else{
                         $("#enddate").attr('value', $("#reservationOnline_datefin_day option:selected").val()+'/'+$("#reservationOnline_datefin_month option:selected").val()+'/'+$("#reservationOnline_datefin_year option:selected").val());
                 }
                 //Si on change le jour du départ
                 $("#reservationOnline_datefin_day").change(function(){
                               jourDepartChange = true;
                               modifDepart();
                 });
                 //Si on change le mois du départ
                 $("#reservationOnline_datefin_month").change(function(){
                          moisDepartChange = true;
                          modifDepart();
                 });
                 //Si on change le année du départ
                 $("#reservationOnline_datefin_year").change(function(){
                         anneeDepartChange = true;
                         modifDepart();
                 });
                 function modifDepart(){
                         if($("#reservationOnline_datefin_month option:selected").val() < 10 && jourDepartChange ==  true || $("#reservationOnline_datefin_month option:selected").val() < 10 && moisDepartChange ==  true || $("#reservationOnline_datefin_month option:selected").val() < 10 && anneeDepartChange ==  true)
                                 $("#enddate").attr('value', $("#reservationOnline_datefin_day option:selected").val()+'/0'+$("#reservationOnline_datefin_month option:selected").val()+'/'+$("#reservationOnline_datefin_year option:selected").val());
                         else
                                 $("#enddate").attr('value', $("#reservationOnline_datefin_day option:selected").val()+'/'+$("#reservationOnline_datefin_month option:selected").val()+'/'+$("#reservationOnline_datefin_year option:selected").val());  
                 }
                 //##############################################################################
                 // Nombre de chambres
                $("#currentroomid").attr('value', $("#reservationOnline_chambre").val());
                $("#roomidavailinfo").attr('value', $("#reservationOnline_chambre").val());
                $("#reservationOnline_chambre").change(function(){
                        $("#currentroomid").attr('value', $("#reservationOnline_chambre").val());
                        $("#roomidavailinfo").attr('value', $("#reservationOnline_chambre").val());
                });
       });*/

   
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
 });
