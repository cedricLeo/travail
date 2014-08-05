<?php
    /**/
    //form posted in a target iframe
    //sécurité pour iframe : todo (like cropper ?)
    /*
    1- déplacer le fichier dans le bon répertoire
    2- ajouter un enregistrement dans la bonne table
    3- afficher l'image dans la page qui a appeller l'upload
    */
    /**/

    session_start();
    include_once("../classes/CONFIGS.class.php");
    if(strpos($_SERVER["HTTP_REFERER"], "/admin/")){
        include_once($CONFIGS->WebsiteFolderAdminInclude."/security.inc.php");
    }elseif(strpos($_SERVER["HTTP_REFERER"], "/client/")){
        include_once($CONFIGS->WebsiteFolderClientInclude."/security.inc.php");
    }
    include_once($CONFIGS->WebsiteFolderClass."/DB.class.php");
    
    //inclusions de toutes les classes types d'images
    //##Général
    include_once($CONFIGS->WebsiteFolderClass."/regiontouristique.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/zone.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/modepaiement.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/affiliation.class.php");

    //##Attraits
    include_once($CONFIGS->WebsiteFolderClass."/categorieattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/souscategorieattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/provinceetatsouscategorieattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/zonesouscategorieattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/activiteattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/serviceattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/typesoinsante.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/attraitphoto.class.php");

    //##hébergements
    include_once($CONFIGS->WebsiteFolderClass."/provinceetatcategoriehebergement.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/categoriehebergementcotation.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/typecotationcotation.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/hebergementphoto.class.php");

    //qcsaison
    include_once($CONFIGS->WebsiteFolderClass."/qcsregiontouristiquevedette.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/qcsechoattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/qcsechohebergement.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/qcsfestivalattrait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/qcsthematique.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/qcsthematiqueitem.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/qcstypeforfait.class.php");
    include_once($CONFIGS->WebsiteFolderClass."/qcsforfait.class.php");

    //to comment ...
    //print_r($_POST);
    //echo "<br><br>";
    //print_r($_FILES);
    //echo "<br><br>";
    
    function validimage($typeupload, $image, &$error){
        $validlist = array("image/pjpeg", "image/jpeg", "image/jpg", "image/gif", "image/png", "image/x-png");
        $validsize = 2097152; // 2M in bytes
        
        $minwidth = 0;
        $minheight = 0;

        switch($typeupload){
            /*case "pays":
                break;
            case "provinceetat":
                break;*/
            case "regiontouristique":
                break;
            case "zone":
                break;
            case "ville":
                break;
            case "modepaiement":
                break;
            case "affiliation":
                break;
            case "categorieattrait":
                break;
            case "souscategorieattrait":
                break;
            case "provinceetatsouscategorieattrait":
                break;
            case "zonesouscategorieattrait":
                break;
            case "activiteattrait":
                break;
            case "serviceattrait":
                break;
            case "typesoinsante":
                break;
            case "provinceetatcategoriehebergement":
                break;
            case "categoriehebergementcotation":
                break;
            case "typecotationcotation":
                break;
            case "hebergement":
                $minwidth = 600;
                $minheight = 400;
                break;
            case "attrait":
                $minwidth = 600;
                $minheight = 400;
                break;
            case "regiontouristiquevedette":
                break;
            case "echoattrait":
                break;
            case "echohebergement":
                break;
            case "festivalattrait":
                break;
            case "thematique":
                break;
            case "thematiqueitem":
                break;
            case "qcstypeforfait":
                break;
            case "qcsforfait":
                break;
        }

        //valid the type (mimetype)
        if(!in_array($image["type"], $validlist)){
            $error = "File Type Error ".
                     "Your type is ".$image["type"].
                     "Accepted types ==> ".join(", ", $validlist);
            return 0;
        }

        //valid the size
        if($validsize < $image["size"]){
            $error = "File Size Error ".
                     "Your size is ".($image["size"] / 1024)." Ko ".
                     "Maximum size ==> ".($validsize / 1024)." Ko";
            return 0;
        }
        
        //valid the dimensions
        list($current_width, $current_height) = getimagesize($image["tmp_name"]);

        if($current_width < $minwidth || $current_height < $minheight){
            $error = "File Dimensions Error".
                     "Minimum is ".$minwidth." x ".$minheight.
                     "Your file is ".$current_width." x ".$current_height;
            //remove the file from server on the tmp folder
            unlink($image["tmp_name"]);
            return 0;
        }

        return 1;
    }

    //begin
    $error = "";
    $jscript = "";

    //validate all required infos ???
    //if(!isset($_POST["typeupload"]) || $_POST["typeupload"] == "") $error = "no type upload";
    //...

    //validate the file
    if($_FILES["btnuploadimage"] == null) $error = "No File Uploaded";
    validimage($_POST["typeupload"], $_FILES["btnuploadimage"], $error);
    
    if($error != ""){
        $idparent = 0;
        switch($_POST["typeupload"]){
            case "hebergement":
                $idparent = $_POST["idhebergement"];
                break;
            case "attrait":
                $idparent = $_POST["idattrait"];
                break;
        }
        //display an error and refresh upload button
        $jscript = "alert(\"".$error."\");";
        $jscript .= "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$idparent.");";
        $jscript .= "document.location = '';";

    }else{
        //do the upload/insert
        //to comment...
        //echo "a file is uploaded ".$_FILES["btnuploadimage"]["type"]."<br>";

        $src = $_FILES["btnuploadimage"]["tmp_name"];               

        //filename from tmp_name
        $filename = substr(basename($_FILES["btnuploadimage"]["tmp_name"]), 0, strrpos(basename($_FILES["btnuploadimage"]["tmp_name"]), '.'));
        //$filename = substr(basename($_FILES["btnuploadimage"]["name"]), 0, strrpos(basename($_FILES["btnuploadimage"]["name"]), '.'));
        //extension from name
        $ext = substr($_FILES["btnuploadimage"]["name"], strrpos($_FILES["btnuploadimage"]["name"], '.')+1);
        

        //creer le bon type d'objet
        $objimage = null;
        switch($_POST["typeupload"]){
            case "pays":
                break;
            case "provinceetat":
                break;
            case "regiontouristique":
                $objimage = new GI_REGIONTOURISTIQUE($CONFIGS, $DB);
                $objimage->Select($_POST["idregiontouristique"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imagehautfr" :
                        $objimage->imagehautfr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagehautfr");
                        break;
                    case "imagehauten" :
                        $objimage->imagehauten = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagehauten");
                        break;
                    case "imagegauche" :
                        $objimage->imagegauche = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagegauche");
                        break;
                    case "imagecentre" :
                        $objimage->imagecentre = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagecentre");
                        break;
                    case "imagetravel" :
                        $objimage->imagetravel = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagetravel");
                        break;
                    case "imageprintemps" :
                        $objimage->imageprintemps = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageprintemps");
                        break;
                    case "imageete" :
                        $objimage->imageete = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageete");
                        break;
                    case "imageautomne" :
                        $objimage->imageautomne = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageautomne");
                        break;
                    case "imagehiver" :
                        $objimage->imagehiver = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagehiver");
                        break;
                }
                break;
            case "zone":
                $objimage = new GI_ZONE($CONFIGS, $DB);
                $objimage->Select($_POST["idzone"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imagehautfr" :
                        $objimage->imagehautfr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagehautfr");
                        break;
                    case "imagehauten" :
                        $objimage->imagehauten = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagehauten");
                        break;
                    case "imagegauche" :
                        $objimage->imagegauche = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagegauche");
                        break;
                    case "imagecentre" :
                        $objimage->imagecentre = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagecentre");
                        break;
                }
                break;
            case "ville":
                break;
            case "modepaiement":
                $objimage = new GI_MODEPAIEMENT($CONFIGS, $DB);
                $objimage->Select($_POST["idmodepaiement"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "affiliation":
                $objimage = new GI_AFFILIATION($CONFIGS, $DB);
                $objimage->Select($_POST["idaffiliation"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "categorieattrait":
                $objimage = new GI_CATEGORIEATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idcategorieattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "souscategorieattrait":
                $objimage = new GI_SOUSCATEGORIEATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idsouscategorieattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "provinceetatsouscategorieattrait":
                $objimage = new GI_PROVINCEETATSOUSCATEGORIEATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idprovinceetatsouscategorieattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imagetopfr" :
                        $objimage->imagetopfr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagetopfr");
                        break;
                    case "imagetopen" :
                        $objimage->imagetopen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagetopen");
                        break;
                    case "imagemini" :
                        $objimage->imagemini = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagemini");
                        break;
                }
                break;
            case "zonesouscategorieattrait":
                $objimage = new GI_ZONESOUSCATEGORIEATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idzonesouscategorieattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "activiteattrait":
                $objimage = new GI_ACTIVITEATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idactiviteattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "serviceattrait":
                $objimage = new GI_SERVICEATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idserviceattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "typesoinsante":
                $objimage = new GI_TYPESOINSANTE($CONFIGS, $DB);
                $objimage->Select($_POST["idtypesoinsante"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "provinceetatcategoriehebergement":
                $objimage = new GI_PROVINCEETATCATEGORIEHEBERGEMENT($CONFIGS, $DB);
                $objimage->Select($_POST["idprovinceetatcategoriehebergement"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "categoriehebergementcotation":
                $objimage = new GI_CATEGORIEHEBERGEMENTCOTATION($CONFIGS, $DB);
                $objimage->Select($_POST["idcategoriehebergementcotation"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "typecotationcotation" :
                $objimage = new GI_TYPECOTATIONCOTATION($CONFIGS, $DB);
                $objimage->Select($_POST["idtypecotationcotation"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
            case "hebergement":
                $objimage = new GI_HEBERGEMENTPHOTO($CONFIGS, $DB);
                $objimage->idhebergement = $_POST["idhebergement"];
                //get the new filename
                $objimage->fichier = mb_strtolower($filename.".".$ext);
                $dest = $objimage->ToVirtualPath();
                break;
            case "attrait":
                $objimage = new GI_ATTRAITPHOTO($CONFIGS, $DB);
                $objimage->idattrait = $_POST["idattrait"];
                //get the new filename
                $objimage->fichier = mb_strtolower($filename.".".$ext);
                $dest = $objimage->ToVirtualPath();
                break;
            case "regiontouristiquevedette":
                $objimage = new GI_REGIONTOURISTIQUEVEDETTE($CONFIGS, $DB);
                $objimage->Select($_POST["idregiontouristiquevedette"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imageentetefr" :
                        $objimage->imageentetefr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageentetefr");
                        break;
                    case "imageenteteen" :
                        $objimage->imageenteteen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageenteteen");
                        break;
                    case "imagearticle" :
                        $objimage->imagearticle = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagearticle");
                        break;
                }
                break;
            case "echoattrait":
                $objimage = new GI_ECHOATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idechoattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imageentetefr" :
                        $objimage->imageentetefr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageentetefr");
                        break;
                    case "imageenteteen" :
                        $objimage->imageenteteen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageenteteen");
                        break;
                    case "imagearticle" :
                        $objimage->imagearticle = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagearticle");
                        break;
                }
                break;
            case "echohebergement":
                $objimage = new GI_ECHOHEBERGEMENT($CONFIGS, $DB);
                $objimage->Select($_POST["idechohebergement"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imageentetefr" :
                        $objimage->imageentetefr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageentetefr");
                        break;
                    case "imageenteteen" :
                        $objimage->imageenteteen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageenteteen");
                        break;
                    case "imagearticle" :
                        $objimage->imagearticle = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagearticle");
                        break;
                }
                break;
            case "festivalattrait":
                $objimage = new GI_FESTIVALATTRAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idfestivalattrait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imageentetefr" :                 
                        $objimage->imageentetefr = mb_strtolower($filename.".".$ext);
                       // $objimage->imageentetefr = strtolower($filename);
                        $dest = $objimage->ImageToVirtualPath("imageentetefr");
                        break;
                    case "imageenteteen" :
                        $objimage->imageenteteen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageenteteen");
                        break;
                    case "imagearticle" :
                        $objimage->imagearticle = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagearticle");
                        break;
                }
                break;
            case "thematique":
                $objimage = new GI_THEMATIQUE($CONFIGS, $DB);
                $objimage->Select($_POST["idthematique"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imageentetefr" :
                        $objimage->imageentetefr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageentetefr");
                        break;
                    case "imageenteteen" :
                        $objimage->imageenteteen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageenteteen");
                        break;
                }
                break;
            case "thematiqueitem":
                $objimage = new GI_THEMATIQUEITEM($CONFIGS, $DB);
                $objimage->Select($_POST["idthematiqueitem"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imageentetefr" :
                        $objimage->imageentetefr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageentetefr");
                        break;
                    case "imageenteteen" :
                        $objimage->imageenteteen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageenteteen");
                        break;
                    case "imagearticle" :
                        $objimage->imagearticle = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagearticle");
                        break;
                    case "imagethematique" :
                        $objimage->imagethematique = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imagethematique");
                        break;
                }
                break;
            case "qcstypeforfait":
                $objimage = new GI_QCSTYPEFORFAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idtypeforfait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "imageentetefr" :
                        $objimage->imageentetefr = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageentetefr");
                        break;
                    case "imageenteteen" :
                        $objimage->imageenteteen = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("imageenteteen");
                        break;
                }
                break;
            case "qcsforfait":
                $objimage = new GI_QCSFORFAIT($CONFIGS, $DB);
                $objimage->Select($_POST["idqcsforfait"]);
                //get the new filename
                switch($_POST["section"]){
                    case "image" :
                        $objimage->image = mb_strtolower($filename.".".$ext);
                        $dest = $objimage->ImageToVirtualPath("image");
                        break;
                }
                break;
        }

        //echo "OBJIMAGE:";
        //print_r($objimage);

        if(isset($objimage)){
            //echo (is_dir($objimage->GetImageFolderVirtual()));

            if(!is_dir($objimage->GetImageFolderVirtual())){
                mkdir($objimage->GetImageFolderVirtual(), 0777);
            }
    
            echo "<br>src:".$src."<br>dest:".$dest."<br>";

            if(move_uploaded_file($src, $dest)){
                //echo "file moved<br>";
                
                //save object
                //and return the values !!!
                switch($_POST["typeupload"]){
                    case "pays":
                        break;
                    case "provinceetat":
                        break;
                    case "regiontouristique":
                        switch($_POST["section"]){
                            case "imagehautfr" :
                                $objimage->SaveImageToDB("imagehautfr");
                                $photopath = $objimage->ImageToVirtualPath("imagehautfr");
                                break;
                            case "imagehauten" :
                                $objimage->SaveImageToDB("imagehauten");
                                $photopath = $objimage->ImageToVirtualPath("imagehauten");
                                break;
                            case "imagegauche" :
                                $objimage->SaveImageToDB("imagegauche");
                                $photopath = $objimage->ImageToVirtualPath("imagegauche");
                                break;
                            case "imagecentre" :
                                $objimage->SaveImageToDB("imagecentre");
                                $photopath = $objimage->ImageToVirtualPath("imagecentre");
                                break;
                            case "imagetravel" :
                                $objimage->SaveImageToDB("imagetravel");
                                $photopath = $objimage->ImageToVirtualPath("imagetravel");
                                break;
                            case "imageprintemps" :
                                $objimage->SaveImageToDB("imageprintemps");
                                $photopath = $objimage->ImageToVirtualPath("imageprintemps");
                                break;
                            case "imageete" :
                                $objimage->SaveImageToDB("imageete");
                                $photopath = $objimage->ImageToVirtualPath("imageete");
                                break;
                            case "imageautomne" :
                                $objimage->SaveImageToDB("imageautomne");
                                $photopath = $objimage->ImageToVirtualPath("imageautomne");
                                break;
                            case "imagehiver" :
                                $objimage->SaveImageToDB("imagehiver");
                                $photopath = $objimage->ImageToVirtualPath("imagehiver");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idregiontouristique"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "zone":
                        switch($_POST["section"]){
                            case "imagehautfr" :
                                $objimage->SaveImageToDB("imagehautfr");
                                $photopath = $objimage->ImageToVirtualPath("imagehautfr");
                                break;
                            case "imagehauten" :
                                $objimage->SaveImageToDB("imagehauten");
                                $photopath = $objimage->ImageToVirtualPath("imagehauten");
                                break;
                            case "imagegauche" :
                                $objimage->SaveImageToDB("imagegauche");
                                $photopath = $objimage->ImageToVirtualPath("imagegauche");
                                break;
                            case "imagecentre" :
                                $objimage->SaveImageToDB("imagecentre");
                                $photopath = $objimage->ImageToVirtualPath("imagecentre");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idzone"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "ville":
                        break;
                    case "modepaiement":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idmodepaiement"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "affiliation":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idaffiliation"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "categorieattrait":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idcategorieattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "souscategorieattrait":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idsouscategorieattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "provinceetatsouscategorieattrait":
                        switch($_POST["section"]){
                            case "imagetopfr" :
                                $objimage->SaveImageToDB("imagetopfr");
                                $photopath = $objimage->ImageToVirtualPath("imagetopfr");
                                break;
                            case "imagetopen" :
                                $objimage->SaveImageToDB("imagetopen");
                                $photopath = $objimage->ImageToVirtualPath("imagetopen");
                                break;
                            case "imagemini" :
                                $objimage->SaveImageToDB("imagemini");
                                $photopath = $objimage->ImageToVirtualPath("imagemini");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idprovinceetatsouscategorieattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "zonesouscategorieattrait":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idzonesouscategorieattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "activiteattrait":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idactiviteattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "serviceattrait":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idserviceattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "typesoinsante":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idtypesoinsante"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "provinceetatcategoriehebergement":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idprovinceetatcategoriehebergement"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "categoriehebergementcotation":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idcategoriehebergementcotation"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "typecotationcotation":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idtypecotationcotation"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "hebergement":
                        $objimage->Save();
                        $photopath = $objimage->ToVirtualPath();
                        list($current_width, $current_height) = getimagesize($objimage->ToVirtualPath());
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idhebergement"].", '".$_POST["idphotolist"]."', ".$objimage->id.", '".$photopath."', ".$current_width.", ".$current_height.");";
                        $jscript .= "document.location = 'afteruploadimage.html';";
                        break;
                    case "attrait":
                        $objimage->Save();
                        $photopath = $objimage->ToVirtualPath();
                        list($current_width, $current_height) = getimagesize($objimage->ToVirtualPath());
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idattrait"].", '".$_POST["idphotolist"]."', ".$objimage->id.", '".$photopath."', ".$current_width.", ".$current_height.");";
                        $jscript .= "document.location = 'afteruploadimage.html';";
                        break;
                    case "regiontouristiquevedette":
                        switch($_POST["section"]){
                            case "imageentetefr" :
                                $objimage->SaveImageToDB("imageentetefr");
                                $photopath = $objimage->ImageToVirtualPath("imageentetefr");
                                break;
                            case "imageenteteen" :
                                $objimage->SaveImageToDB("imageenteteen");
                                $photopath = $objimage->ImageToVirtualPath("imageenteteen");
                                break;
                            case "imagearticle" :
                                $objimage->SaveImageToDB("imagearticle");
                                $photopath = $objimage->ImageToVirtualPath("imagearticle");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idregiontouristiquevedette"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "echoattrait":
                        switch($_POST["section"]){
                            case "imageentetefr" :
                                $objimage->SaveImageToDB("imageentetefr");
                                $photopath = $objimage->ImageToVirtualPath("imageentetefr");
                                break;
                            case "imageenteteen" :
                                $objimage->SaveImageToDB("imageenteteen");
                                $photopath = $objimage->ImageToVirtualPath("imageenteteen");
                                break;
                            case "imagearticle" :
                                $objimage->SaveImageToDB("imagearticle");
                                $photopath = $objimage->ImageToVirtualPath("imagearticle");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idechoattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "echohebergement":
                        switch($_POST["section"]){
                            case "imageentetefr" :
                                $objimage->SaveImageToDB("imageentetefr");
                                $photopath = $objimage->ImageToVirtualPath("imageentetefr");
                                break;
                            case "imageenteteen" :
                                $objimage->SaveImageToDB("imageenteteen");
                                $photopath = $objimage->ImageToVirtualPath("imageenteteen");
                                break;
                            case "imagearticle" :
                                $objimage->SaveImageToDB("imagearticle");
                                $photopath = $objimage->ImageToVirtualPath("imagearticle");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idechohebergement"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "festivalattrait":
                        switch($_POST["section"]){
                            case "imageentetefr" :
                                $objimage->SaveImageToDB("imageentetefr");              
                                $photopath = $objimage->ImageToVirtualPath("imageentetefr");
                                break;
                            case "imageenteteen" :
                                $objimage->SaveImageToDB("imageenteteen");
                                $photopath = $objimage->ImageToVirtualPath("imageenteteen");
                                break;
                            case "imagearticle" :
                                $objimage->SaveImageToDB("imagearticle");
                                $photopath = $objimage->ImageToVirtualPath("imagearticle");
                                break;
                        }          
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idfestivalattrait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "thematique":
                        switch($_POST["section"]){
                            case "imageentetefr" :
                                $objimage->SaveImageToDB("imageentetefr");
                                $photopath = $objimage->ImageToVirtualPath("imageentetefr");
                                break;
                            case "imageenteteen" :
                                $objimage->SaveImageToDB("imageenteteen");
                                $photopath = $objimage->ImageToVirtualPath("imageenteteen");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idthematique"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "thematiqueitem":
                        switch($_POST["section"]){
                            case "imageentetefr" :
                                $objimage->SaveImageToDB("imageentetefr");
                                $photopath = $objimage->ImageToVirtualPath("imageentetefr");
                                break;
                            case "imageenteteen" :
                                $objimage->SaveImageToDB("imageenteteen");
                                $photopath = $objimage->ImageToVirtualPath("imageenteteen");
                                break;
                            case "imagearticle" :
                                $objimage->SaveImageToDB("imagearticle");
                                $photopath = $objimage->ImageToVirtualPath("imagearticle");
                                break;
                            case "imagethematique" :
                                $objimage->SaveImageToDB("imagethematique");
                                $photopath = $objimage->ImageToVirtualPath("imagethematique");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idthematiqueitem"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "qcstypeforfait":
                        switch($_POST["section"]){
                            case "imageentetefr" :
                                $objimage->SaveImageToDB("imageentetefr");
                                $photopath = $objimage->ImageToVirtualPath("imageentetefr");
                                break;
                            case "imageenteteen" :
                                $objimage->SaveImageToDB("imageenteteen");
                                $photopath = $objimage->ImageToVirtualPath("imageenteteen");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idtypeforfait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                    case "qcsforfait":
                        switch($_POST["section"]){
                            case "image" :
                                $objimage->SaveImageToDB("image");
                                $photopath = $objimage->ImageToVirtualPath("image");
                                break;
                        }
                        list($current_width, $current_height) = getimagesize($photopath);
                        $jscript = "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."', ".$_POST["idqcsforfait"].", '".$_POST["idphotolist"]."', '".$photopath."', '".$_POST["section"]."', '".$_POST["idlnkdeleteimage"]."');";
                        break;
                }               
                unset($objimage);
                
            }else{
                unset($objimage);
                echo "file NOT moved<br>";
                $jscript = "alert(\"Read/Write Error\");";
                $jscript .= "parent.imageuploaded(parent.document.".$_POST["frmname"].", '".$_POST["inputname"]."', '".$_POST["inputid"]."');";
            }
        }else{
            echo "file NOT moved<br>";
            $jscript = "alert(\"PHP Class/Object Error\");";
        }
    }

    //write the script to do after upload
    echo "<script type=\"text/javascript\">".
         $jscript.
         "</script>";
?>
