<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Séparou</title>
    <link rel="icon" href="images/logo.png" type="image/png">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="site-header">
        <img src="images/logo.png" alt="Séparou Logo" id="site-logo">
        <h1 id="site-title">Séparou</h1>

    </header>
    
    <form method="post" class="center">
    <div class="input-container">
        <div class="form-group">
            <label for="gare_d">Départ :</label>
            <input type="text" id="gare_d" name="gare_d" placeholder="Entrez le nom de la gare de départ...">
        </div>
        <div class="form-group">
            <label for="gare_a">Arrivée :</label>
            <input type="text" id="gare_a" name="gare_a" placeholder="Entrez le nom de la gare d'arrivée...">
        </div>
    </div>
    <input type="submit" value="Rechercher">
    </form>


    <div id="results">
        <?php
        // Fonction pour enregistrer les gares consultées dans un fichier CSV        
        function enregistrerGareConsultee($gareDepart, $gareArrivee) {
            $file = 'gares_consultees.csv';
            $consultations = [];
        
            if (file_exists($file)) {
                // Lire toutes les consultations existantes
                $handle = fopen($file, 'r');
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $consultations[$data[0] . '/' . $data[1]] = [
                        'depart' => $data[0],
                        'arrivee' => $data[1],
                        'count' => isset($data[2]) ? $data[2] : 1
                    ];
                }
                fclose($handle);
            }
        
            // Clé de recherche
            $searchKey = $gareDepart . '/' . $gareArrivee;
        
            // Si le trajet existe déjà, incrémenter le compteur, sinon l'ajouter
            if (array_key_exists($searchKey, $consultations)) {
                $consultations[$searchKey]['count']++;
            } else {
                $consultations[$searchKey] = [
                    'depart' => $gareDepart,
                    'arrivee' => $gareArrivee,
                    'count' => 1
                ];
            }
        
            // Réécrire le fichier avec les nouvelles données
            $handle = fopen($file, 'w');
            foreach ($consultations as $consultation) {
                fputcsv($handle, [$consultation['depart'], $consultation['arrivee'], $consultation['count']]);
            }
            fclose($handle);
        }
        
        // Fonction pour récupérer les données des gares consultéesfunction recupererGaresConsultees() {
        function recupererGaresConsultees() {
            $file = 'gares_consultees.csv';
            $consultations = [];
            if (file_exists($file)) {
                $handle = fopen($file, 'r');
                while (($data = fgetcsv($handle)) !== FALSE) {
                    $consultations[] = $data;
                }
                fclose($handle);
            }
            return $consultations;
        }

        // Génération de l'histogramme des gares les plus consultées
        function genererHistogramme() {
            $file = 'gares_consultees.csv';
            $consultations = [];
            
            // Vérifie si le fichier existe avant de l'ouvrir
            if (file_exists($file)) {
                $handle = fopen($file, 'r');
                
                // Lecture du fichier CSV ligne par ligne
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Utilisation de la combinaison départ/arrivée comme clé du tableau
                    $key = $data[0] . '/' . $data[1];
                    
                    // Si cette clé existe déjà, on ajoute le compte sinon on initialise à 1
                    if (!isset($consultations[$key])) {
                        $consultations[$key] = (int) $data[2];
                    } else {
                        $consultations[$key] += (int) $data[2];
                    }
                }
                fclose($handle);
                
                // Tri du tableau par ordre décroissant des consultations
                arsort($consultations);
                
                // Affichage des résultats
                echo "<ul>";
                foreach ($consultations as $pair => $count) {
                    echo "<li>$pair : $count consultation(s)</li>";
                }
                echo "</ul>";
            } else {
                // Le fichier n'existe pas
                echo "Aucune consultation à afficher.";
            }
        }

        function genererImage($code){
            if(strcmp($code,"A")==0){
                return("images/A.png");
            }
            if(strcmp($code,"B")==0){
                return("images/B.png");
            }
            if(strcmp($code,"C")==0){
                return("images/C.png");
            }
            if(strcmp($code,"D")==0){
                return("images/D.png");
            }
            if(strcmp($code,"E")==0){
                return("images/E.png");
            }
            if(strcmp($code,"H")==0){
                return("images/H.png");
            }
            if(strcmp($code,"J")==0){
                return("images/J.png");
            }
            if(strcmp($code,"K")==0){
                return("images/K.png");
            }
            if(strcmp($code,"L")==0){
                return("images/L.png");
            }
            if(strcmp($code,"N")==0){
                return("images/N.png");
            }
            if(strcmp($code,"P")==0){
                return("images/P.png");
            }
            if(strcmp($code,"R")==0){
                return("images/R.png");
            }
            if(strcmp($code,"U")==0){
                return("images/U.png");
            }
            if(strcmp($code,"street_network")==0){
                return("images/walking.png");
            }
            if(strcmp($code,"waiting")==0){
                return("images/waiting.png");
            }
            if(strcmp($code,"TGV INOUI")==0){
                return("images/INOUI.jpg");
            }
            if((strcmp($code,"TER")==0) or (str_contains($code,"TER"))){
                return("images/TER.png");
            }
        }

        function decoderDate($date){
            $dateD = "";
            echo"$date";
            $len = strlen($date);
            for($i=0; $i<$len;$i++){
                echo$i;
                if(!(strcmp($i,"-")==0) or (strcmp($i,":")==0)){
                    $dateD .= $i;
                }
            return $dateD;
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["gare_d"]) && isset($_POST["gare_a"])) {
            $searchTerm = urlencode($_POST["gare_d"]);
            $apiKey = "622dadd5-1c31-47b3-a943-a35c57cdcfe0";
            $url = "https://api.sncf.com/v1/coverage/sncf/places?q=$searchTerm&type%5B%5D=stop_area&";
            
            echo"<form method=\"post\">";

            echo "<div class=\"radio-group\">";
            echo"<h2>Choisissez la gare de départ : </h2>";

            $options = array(
                'http' => array(
                    'header' => "Authorization: $apiKey"
                )
            );
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $data = json_decode($response, true);
            if ($data && isset($data['places'])) {
                echo "<ul>";
                foreach ($data['places'] as $place) {
                    //echo "<li><a href='?gare=" . urlencode($place['id']) . "'>". $place['name']."</a></li>";
                    echo "<li><input type=\"radio\" id=\"depart\" name=\"depart\" value=".urlencode($place['id'])."><label for=\"depart\">".$place['name']."</label></li>";
                }
                echo "</ul></div>";
            $searchTerm = urlencode($_POST["gare_a"]);
            $apiKey = "622dadd5-1c31-47b3-a943-a35c57cdcfe0";
            $url = "https://api.sncf.com/v1/coverage/sncf/places?q=$searchTerm&type%5B%5D=stop_area&";
            echo "<div class=\"radio-group\">";
            echo"<h2>Choisissez la gare d'arrivée : </h2>";

            $options = array(
                'http' => array(
                    'header' => "Authorization: $apiKey"
                )
            );
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $data = json_decode($response, true);
            if ($data && isset($data['places'])) {
                echo "<ul>";
                foreach ($data['places'] as $place) {
                    //echo "<li><a href='?gare=" . urlencode($place['id']) . "'>". $place['name']."</a></li>";
                    echo "<li><input type=\"radio\" id=\"arrivee\" name=\"arrivee\" value=".urlencode($place['id'])."><label for=\"arrivee\">".$place['name']."</label></li>";
                }
            echo "</ul>";
            echo"<input type=\"datetime-local\" id=\"date\" name=\"date\">";
            echo"<br><br><input type=\"submit\" value=\"Valider\">";
            echo"</form>";
            } else {
                echo "Aucune gare trouvée.";
            }
            echo"</div>";
        }
    }
        // Vérifier si une gare est sélectionnée et afficher ses informations
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["depart"]) && isset($_POST["arrivee"]) && isset($_POST["date"])) {
            $gareDepart = urlencode($_POST["depart"]);
            $gareDepart2 = str_replace('%253','%3',$gareDepart);
            $gareArrivee = urlencode($_POST["arrivee"]);
            $gareArrivee2 = str_replace('%253','%3',$gareArrivee); 
            $dateD = str_replace(array(':','-'),'',$_POST["date"]);
            $apiKey = "622dadd5-1c31-47b3-a943-a35c57cdcfe0";
            $options2 = array(
                'http' => array(
                    'header' => "Authorization: $apiKey"
                )
            );
            $url2 = "https://api.sncf.com/v1/coverage/sncf/journeys?from=$gareDepart2&to=$gareArrivee2&datetime=".$dateD."00";
            $context2 = stream_context_create($options2);
            $response2 = file_get_contents($url2, false, $context2);
            $data2 = json_decode($response2, true);
            if (isset($data2['journeys'][0]['sections'])) {
                // Récupération de la première section pour la gare de départ
                $first_section = $data2['journeys'][0]['sections'][0];
                $gare_depart = $first_section['from']['name'];
        
                // Récupération de la dernière section pour la gare d'arrivée
                $last_section_index = count($data2['journeys'][0]['sections']) - 1;
                $last_section = $data2['journeys'][0]['sections'][$last_section_index];
                $gare_arrivee = $last_section['to']['name'];
        
                // Affichage
                echo "<h2>Trajet de : $gare_depart à $gare_arrivee</h2>";   
                // Définir un cookie pour stocker la dernière gare consultée
                setcookie("derniere_gare_depart", $gare_depart, time() + (86400 * 30), "/");
                setcookie("derniere_gare_arrivee", $gare_arrivee, time() + (86400 * 30), "/");
                // Définir un cookie pour stocker la date de consultation
                setcookie("date_consultation", date('d-m-Y H:i:s'), time() + (86400 * 30), "/");
                enregistrerGareConsultee($gare_depart, $gare_arrivee);
            }
 
            foreach ($data2['journeys'] as $journey){
                $taille = $journey['nb_transfers']*2+3;
                $horaire_d = $journey['departure_date_time'];
                $heure = substr($horaire_d, -6, 2)."h";
                $minute = substr($horaire_d, -4, 2)." ";
                $date_d = $heure . $minute;
                $horaire_a = $journey['arrival_date_time'];
                $heure = substr($horaire_a, -6, 2)."h";
                $minute = substr($horaire_a, -4, 2)." ";
                $date_a = $heure . $minute;
                $escale = $journey['nb_transfers'];
                echo "<li><a>".$date_d." - ".$date_a." (".$escale." escales) "."<br><br>";
                foreach ($journey['sections'] as $sections){
                    if(isset($sections['display_informations']['code'])){
                        $code = $sections['display_informations']['code'];
                        if((!strcmp($code,"")==0) && (!str_contains($sections['display_informations']['commercial_mode'],"TER"))){
                            $adresse_i = genererImage($code);
                            $largeur = 20;
                        }
                        else{
                            $adresse_i = genererImage($sections['display_informations']['commercial_mode']);
                            $largeur = 35;
                        }
                        $type = $sections['display_informations']['commercial_mode'];
                        $min = intdiv($sections['duration'],60);
                        $sec = $sections['duration']%60;
                        $duree = $min."min".$sec."s";
                        $depart = $sections['from']['name'];
                        $arrivee = $sections['to']['name'];
                        print $type." "."<img src=\"$adresse_i\" width=\"$largeur\" height=\"20\"\/>"." de ".$depart." à ".$arrivee."(".$duree.")"." <br><br>";
                    }
                    if(!isset($sections['display_informations']['code']) && $sections['type']!=="crow_fly"){
                        $type = $sections['type'];
                        $min = intdiv($sections['duration'],60);
                        $sec = $sections['duration']%60;
                        $duree = $min."min".$sec."s";
                        $depart = "";
                        $arrivee = "";
                        if(isset($sections['from']) && isset($sections['to'])){
                            $depart = $sections['from']['name'];
                            $arrivee = $sections['to']['name'];
                        }
                        if (strcmp($type,"waiting")==0){
                            print "Attendre pendant ".$duree."<br><br>";
                        }
                        else{
                        print "Marcher de ".$depart." à ".$arrivee."(".$duree.")"." <br><br>";
                        }
                    }
                }
                echo"</a></li>";
            }
            if(isset($_COOKIE['derniere_gare_depart']) && isset($_COOKIE['derniere_gare_arrivee'])) {
                echo "Dernière gare consultée : " ."<br>";
                echo $_COOKIE['derniere_gare_depart'] . "/" ;
                echo $_COOKIE['derniere_gare_arrivee'] . "<br>";
            } else {
                echo "Aucune gare consultée récemment.<br>";
            }
            
            if(isset($_COOKIE['date_consultation'])) {
                echo "Date de la consultation : " . "<br>";
                echo $_COOKIE['date_consultation'] . "<br>";
            } else {
                echo "Aucune date de consultation enregistrée.<br>";
            }
        }


        function getRandomImage() {
            $photoDir = 'imageR'; 
            $photos = array_diff(scandir($photoDir), array('..', '.')); 
            if (!empty($photos)) {
                $randomImage = $photos[array_rand($photos)];
                echo "<figure class='random-image'>";
                echo "<img src='$photoDir/$randomImage' alt='Random Image'>";
                echo "</figure>";
            } else {
                echo "<p>No images found.</p>"; 
            }
        }

        ?>

    </div>

    <div id="stats">
        <h2>Statistiques</h2>
        <?php
        $consultations = recupererGaresConsultees();
        genererHistogramme($consultations);
        ?>
    </div>

    <div id="imgR">
        <?php getRandomImage()?>
    </div>

    <footer>
        <p>Autres liens : <a href="tech.php">Image du jour de la NASA</a></p>
    </footer>
</body>
</html>
