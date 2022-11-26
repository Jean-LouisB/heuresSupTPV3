<?php



    if(!isset($interupteur)){
            date_default_timezone_set('Europe/Paris');
            // Ecrire le log
            $dateJour = date("Y-m-d H:i:s");
            
        $fichierLog = fopen('log.txt', 'a+b'); 
        fputs($fichierLog, "\n");
        //fwrite($fichierLog,$prenomUserConnecte.' '.$nomUserConnecte.' s\'est connecté le '.$dateJour.' sur la page '.$currantPage);
        fwrite($fichierLog,$prenomUserConnecte.' '.$nomUserConnecte.';'.$dateJour.';'.$currantPage);
        fclose($fichierLog);
        $interupteur = 0;

    }

    ?>
<!--
    <p style="text-align:center; margin-top:50px;font-size:0.6em" id="compteRebour"></p>

-->

<script type="text/javascript">




function finalCountDown(){

        var deadline = new Date("nov 30, 2022 12:00:00").getTime();
        var now = new Date().getTime();
        var t = deadline - now;
        var days = Math.floor(t/(1000*60*60*24));
        var hours = Math.floor((t%(1000*60*60*24))/(1000*60*60));
        var minutes = Math.floor((t%(1000*60*60))/(1000*60));
        var seconds = Math.floor((t%(1000*60))/1000);
  
            if (now > deadline){

            }else{
                document.getElementById("compteRebour").innerHTML = "J - "+days + " jours, " + hours + " heure(s), " + minutes + " minute(s) et " + seconds +" seconde(s)";
                
            }
      

}

const finalCountDownInterval = setInterval(() => {
    
    finalCountDown();

}, 1000);


</script>

