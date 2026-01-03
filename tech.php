<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Image du jour de la NASA</title>
    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
        }
        h1 {
            margin: 10px;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        footer p {
            margin: 0;
        }
        footer a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;

        }

        .image-container {
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            margin: auto;
            max-height: 400px;
        }

    </style>
</head>
<body>
<div class="image-container">
    
    <header>
    <h1>Image du jour de la NASA</h1>
    </header>

    <?php
    $apiKey = 'sDQhhVl2qB0zWLLzPopT8abM3STS5woRKaTHiqp1';
    $date = date('Y-m-d');
    $url = "https://api.nasa.gov/planetary/apod?api_key=$apiKey&date=$date";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    echo '<img src="' . $data['url'] . '" alt="' . $data['title'] . '">';
    ?>
</div>

<p style="text-align: center; font-family: Arial, sans-serif; margin:10px">
    <?php

        $ip = $_SERVER['REMOTE_ADDR'];
        $url = "http://www.geoplugin.net/xml.gp?ip=$ip";
        $response = file_get_contents($url);
        $xml = simplexml_load_string($response);

        $city = $xml->geoplugin_city;
        $country = $xml->geoplugin_countryName;
        $postalCode = $xml->geoplugin_regionCode;
        echo "Votre position approximative est : $city, $country ($postalCode)";
       
       
        echo ", Localisation a l'aide de IPinfo:";
        $token = "924f54d9932e7f";

        $ipinfo = file_get_contents("https://ipinfo.io/" . $ip . "?token=" . $token);
        $json = json_decode($ipinfo);
        echo " Ville : ".$json->city.", Pays : ".$json->country ;

    ?>

</p>

<footer>
    <p>Autres liens : <a href="index.php">Accueil</a></p>
</footer>
</body>
</html>


