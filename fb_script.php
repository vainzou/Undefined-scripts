<?php


// ////////////////////////////////////// 
// vincent dubois
// /var/www/social/script/cron/#.php
// /////////////////////////////////////


$hr = "--------------------------------------------------------------------------------";
$today = date("Y-m-d H:i:s");
$fp = fopen('/var/www/undefined/social/script/cron/log_fb/fb-' . $today . '.txt', 'w');

// $fp = fopen($today, 'w')

$directory = '/var/www/undefined/social/script/cron/log_fb/';
$files = glob($directory . '*');

if ($files !== false) {
    $filecount = count($files);

    // echo $filecount;

}

$num = $filecount;

// /////////////////////////////////////////////////////////////////////////////////
// ////////////////////////////////////// base de donnÃƒÆ’Ã‚Â©es

try {

    // connexion mysql

    $bdd = new PDO('mysql:host=localhost;dbname=#', '#', '#');
}

catch(Exception $e) {

    // erreur mysql

    die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM user_fb');

// ////////////////////////////////////// require

require_once ('/var/www/undefined/social/script/facebookSDK/facebook.php');

require_once ('/var/www/undefined/social/script/wordnik/Swagger.php');

require_once ('/var/www/undefined/social/script/twitterSDK/twitteroauth.php');

// ////////////////////////////////////// API KEY

$config = array(
    'appId' => '#',
    'secret' => '#',
    'fileUpload' => true,
    'allowSignedRequest' => false

    // optional but should be set to false for non-canvas apps

);
$myAPIKey = '#';

define('CONSUMER_KEY', '#');
define('CONSUMER_SECRET', '#');
define('ACCESS_TOKEN', '#-#');
define('ACCESS_TOKEN_SECRET', '#');

$api_key = "#";

// ///////////////////////////////////// API
            function search(array $query)
            {
                $toa = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, ACCESS_TOKEN, ACCESS_TOKEN_SECRET);
                return $toa->get('search/tweets', $query);
            }

$facebook = new Facebook($config);
$client = new APIClient($myAPIKey, 'http://api.wordnik.com/v4');
$wordApi = new WordApi($client);

// expression

$expression = array(
    "incredible",
    "exhausting",
    "gorgeous",
    "horrifying",
    "ridiculous",
    "phenomenal",
    "brilliant",
    "amazing",
    "spectacular",
    "fun",
    "enjoyable",
    "interesting",
    "simply",
    "exhilarating",
    "hideous",
    "utterly",
    "atrocious",
    "ballpark",
    "nauseating",
    "take it easy",
    "holy smoke",
    "are you kidding me",
    "give me a break",
    "nuh uh",
    "oh my goodness",
    "catch you later",
    "no way,wahoo",
    "yikes",
    "eww",
    "seriously",
    "good grief"
);

// /////////////////////////////////////////////////////////////////////////////////

fwrite($fp, "\n");
fwrite($fp, $hr);
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - START SCRIPT ');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - ' . $today . '');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - LOG FILE : /var/www/undefined/social/script/cron/log_fb/' . $today . '.txt');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, " - SCRIPT PHP : /cron_fb_log.php");
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, $hr);
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - LOG : #' . $num . '');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - SOCIAL NETWORK : Facebook');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, $hr);
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - FUNCTION : ');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, $hr);
fwrite($fp, "\n");
fwrite($fp, "\n");

// /////////////////////////////////////////////////////////////////////////////////
// /////////////////////////////////////fonctions

while ($donnees = $reponse->fetch()) {
    fwrite($fp, ' - USER : ' . $donnees['username'] . '');
    fwrite($fp, "\n");
    fwrite($fp, "\n");

   // $toggle = rand(3, 6);
    $toggle = 5;

    fwrite($fp, ' - TICKET : ' . $toggle . '');
    fwrite($fp, "\n");
    fwrite($fp, "\n");

    $token = $donnees['token'];

    if ($toggle == 5) {
        fwrite($fp, ' - TICKET : true');
        fwrite($fp, "\n");
        fwrite($fp, "\n");
        fwrite($fp, ' - TOKEN : ok');
        fwrite($fp, "\n");
        fwrite($fp, "\n");

        // /////////////////////////////////////////////////////////////////////////////////

        if ($donnees['strategy'] == "random") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $param = array(
                'access_token' => $token,
            );
            $newsfeed = $facebook->api('/me/home?limit=10', $param);
            $myNewsID = $newsfeed['data'][array_rand($newsfeed['data']) ];
            $theid = $myNewsID['id'];

            // Get random phrase

            $json = file_get_contents("http://api.wordnik.com/v4/words.json/randomWord?hasDictionaryDef=true&minCorpusCount=0&maxCorpusCount=-1&minDictionaryCount=1&maxDictionaryCount=-1&minLength=9&maxLength=-1&api_key=#");
            $parsed_json = json_decode($json);

            // print_r($parsed_json);

            $randomWord = $parsed_json->{'word'};
            $example = $wordApi->getTopExample($randomWord);
            $phrase = $example->text;
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  SENTENCE : ' . $phrase . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  POST TO LIKE: ' . $theid . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // Post status

            $rpost = array(
                'access_token' => $token,
                'message' => $phrase
            );
            $rmessage = $facebook->api('/me/feed', 'POST', $rpost);

            /*
            $rlike = array(
                'access_token' => $token,
            );
            $rlikee = $facebook->api('/' . $theid . '/likes', 'POST', $rlike);
            */

            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // array a completer

            fwrite($fp, '    -  STATUS ID : ' . $rmessage['id'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  LIKE : false ');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
        }
        elseif ($donnees['strategy'] == "similar") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // get likes

            $param = array(
                'access_token' => $token,
                "rpp" => 1
            );
            $likes = $facebook->api('/me/likes?limit=20', $param);

            // get a random like

            $rd = rand(1, 19);

            // Get a like-Tweet

            $query = array(
                "q" => $likes['data'][$rd]['name'],
                "rpp" => 5,
                "include_entities" => "false"
            );
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - RANDOM LIKE : ' . $likes['data'][$rd]['name'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");


            $results = search($query);
            $RandMessage = $results->statuses[0]->text;
            //print_r($results);

            if (empty($RandMessage)) {
                fwrite($fp, '    - TWEET : no tweet found');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
            }
            elseif ($RandMessage[0] == '@') {
                fwrite($fp, '    - TWEET : twitter answer/bad syntax');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
            }
            elseif ($RandMessage[0] == 'R') {
                fwrite($fp, '    - TWEET : retweet/bad syntax');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
            }
            else {
                $spost = array(
                    'access_token' => $token,
                    'message' => $RandMessage
                );
                $smessage = $facebook->api('/me/feed', 'POST', $spost);
                fwrite($fp, ' - POST :');
                fwrite($fp, "\n");
                fwrite($fp, "\n");

                // array a completer

                fwrite($fp, '    -  STATUS ID : ' . $smessage['id'] . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");

                // /////////////////////////////////////////////////////////////////////////////////

            }
        }
        elseif ($donnees['strategy'] == "prosper") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // get likes

            $nbreStatrd = rand(7, 12);
            $nbreStat = 0;
            fwrite($fp, ' - NUMBER OF STATUT TO POST : ' . $nbreStatrd . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            while ($nbreStat <= $nbreStatrd) {
                fwrite($fp, ' - STATUT NUMBER : ' . $nbreStat . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                $param = array(
                    'access_token' => $token,
                    "rpp" => 1
                );
                $likes = $facebook->api('/me/likes?limit=20', $param);

                // get a random like

                $rd = rand(1, 19);

                // Get a like-Tweet

                $query = array(
                    "q" => $likes['data'][$rd]['name'],
                    "rpp" => 5,
                    "include_entities" => "false"
                );
                fwrite($fp, ' - GET :');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                fwrite($fp, '    - RANDOM LIKE : ' . $likes['data'][$rd]['name'] . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");


                $results = search($query);
                $RandMessage = $results->statuses[0]->text;
                if (empty($RandMessage)) {
                    fwrite($fp, '    - TWEET : no tweet found');
                    fwrite($fp, "\n");
                    fwrite($fp, "\n");
                }
                elseif ($RandMessage[0] == '@') {
                    fwrite($fp, '    - TWEET : twitter answer/bad syntax');
                    fwrite($fp, "\n");
                    fwrite($fp, "\n");
                }
                elseif ($RandMessage[0] == 'R') {
                fwrite($fp, '    - TWEET : retweet/bad syntax');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                }
                else {
                    $spost = array(
                        'access_token' => $token,
                        'message' => $RandMessage
                    );
                    $smessage = $facebook->api('/me/feed', 'POST', $spost);
                    fwrite($fp, ' - POST :');
                    fwrite($fp, "\n");
                    fwrite($fp, "\n");

                    // array a completer

                    fwrite($fp, '    -  STATUS ID : ' . $smessage['id'] . '');
                    fwrite($fp, "\n");
                    fwrite($fp, "\n");

                    // /////////////////////////////////////////////////////////////////////////////////

                    $nbreStat++;
                }
            }
        }
        elseif ($donnees['strategy'] == "copy") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $param = array(
                'access_token' => $token
            );
            $home = $facebook->api('/me/home?limit=2', $param);
            if (!empty($home['data'][0]['message'])) {
                print fwrite($fp, '    -  STATUT OF : ' . $home['data'][0]['from']['name'] . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                fwrite($fp, '    -  STATUT TEXT : ' . $home['data'][0]['message'] . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");

                // Post status

                $cpost = array(
                    'access_token' => $token,
                    'message' => $home['data'][0]['message']
                );
                $cmessage = $facebook->api('/me/feed', 'POST', $cpost);
                fwrite($fp, ' - POST :');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                fwrite($fp, '    -  STATUS ID : ' . $cmessage['id'] . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
            }
            else {
                fwrite($fp, '    -  STATUT TEXT : no message found ');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
            }

            // /////////////////////////////////////////////////////////////////////////////////

        }
        elseif ($donnees['strategy'] == "melt") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $param = array(
                'access_token' => $token
            );
            $stat = $facebook->api('/me/statuses?limit=80', $param);
            $myStatut1 = $stat['data'][array_rand($stat['data']) ]['message'];
            $myStatut2 = $stat['data'][array_rand($stat['data']) ]['message'];
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - SELECTED STATUS 1 : ' . $myStatut1 . ' ');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - SELECTED STATUS 2 : ' . $myStatut2 . ' ');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            /*
            $pieces = explode(" ", $myStatut);
            shuffle($pieces);
            $imp = implode(" ", $pieces);

            // Post status

            */
            $middle1 = strrpos(substr($myStatut1, 0, floor(strlen($myStatut1) / 2)) , ' ') + 1;
            $middle2 = strrpos(substr($myStatut2, 0, floor(strlen($myStatut2) / 2)) , ' ') + 1;
            $s1tring1 = substr($myStatut1, 0, $middle1); // "The Quick : Brown Fox "
            $s1tring2 = substr($myStatut1, $middle1); // "Jumped Over The Lazy / Dog"
            $s2tring1 = substr($myStatut2, 0, $middle2); // "The Quick : Brown Fox "
            $s2tring2 = substr($myStatut2, $middle2); // "Jumped Over The Lazy / Dog"
            $mpost = array(
                'access_token' => $token,
                'message' => '' . $s1tring1 . '' . $s2tring2 . ''
            );
            $mmessage = $facebook->api('/me/feed', 'POST', $mpost);
            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  STATUS ID : ' . $mmessage['id'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // /////////////////////////////////////////////////////////////////////////////////
            // /////////////////////////////////////////////////////////////////////////////////

        }
        elseif ($donnees['strategy'] == "shyphoto") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $Pexpression = array(
                "incredible",
                "exhausting",
                "gorgeous",
                "horrifying",
                "ridiculous",
                "phenomenal",
                "brilliant",
                "amazing",
                "spectacular",
                "fun",
                "enjoyable",
                "interesting",
                "simply",
                "exhilarating",
                "hideous",
                "utterly",
                "atrocious",
                "ballpark",
                "nauseating",
                "wahoo"
            );
            $capital = array(
                "habi",
                "Abuja",
                "Accra",
                "Adamstown",
                "Algiers",
                "Alofi",
                "Amman",
                "Amsterdam",
                "Ankara",
                "Antananarivo",
                "Apia",
                "Ashgabat",
                "Asmara",
                "Astana",
                "AsunciÃƒÆ’Ã‚Â³n",
                "Athens",
                "Avarua",
                "Baghdad",
                "Baku",
                "Bamako",
                "Bangkok",
                "Bangui",
                "Banjul",
                "Basseterre",
                "Beijing",
                "Beirut",
                "Belgrade",
                "Belmopan",
                "Berlin",
                "Bern",
                "Bishkek",
                "Bissau",
                "BogotÃƒÆ’Ã‚Â¡",
                "BrasÃƒÆ’Ã‚Â­lia",
                "Bratislava",
                "Brazzaville",
                "Bridgetown",
                "Brussels",
                "Bucharest",
                "Budapest",
                "Buenos",
                "Aires",
                "Bujumbura",
                "Cairo",
                "Canberra",
                "Caracas",
                "Castries",
                "Chisinau",
                "Cockburn",
                "Conakry",
                "Copenhagen",
                "Dakar",
                "Damascus",
                "Dhaka",
                "Dili",
                "Djibouti",
                "Doha",
                "Douglas",
                "Dublin",
                "Dushanbe",
                "Edinburgh",
                "El",
                "AaiÃƒÆ’Ã‚Âºn",
                "Episkopi",
                "Freetown",
                "Funafuti",
                "Gaborone",
                "George",
                "Town",
                "Georgetown",
                "Georgetown",
                "Gibraltar",
                "Gustavia",
                "HagÃƒÆ’Ã‚Â¥tÃƒÆ’Ã‚Â±a",
                "Hamilton",
                "Hanga",
                "Roa",
                "Hanoi",
                "Harare",
                "Hargeisa",
                "Havana",
                "Helsinki",
                "Honiara",
                "Islamabad",
                "Jakarta",
                "Jamestown",
                "Jerusalem",
                "Juba",
                "Kabul",
                "Kampala",
                "Kathmandu",
                "Khartoum",
                "Kiev",
                "Kigali",
                "Kingston",
                "Kingston",
                "Kingstown",
                "Kinshasa",
                "Kuala",
                "Lumpur",
                "Putrajaya",
                "Kuwait",
                "City",
                "Libreville",
                "Lilongwe",
                "Lima",
                "Lisbon",
                "Ljubljana",
                "LomÃƒÆ’Ã‚Â©",
                "London",
                "Luanda",
                "Lusaka",
                "Luxembourg",
                "Madrid",
                "Majuro",
                "Malabo",
                "MalÃƒÆ’Ã‚Â©",
                "Managua",
                "Manama",
                "Manila",
                "Maputo",
                "Marigot",
                "Maseru",
                "Mata-Utu",
                "Mbabane",
                "Lobamba",
                "Melekeok",
                "Ngerulmud",
                "Mexico",
                "City",
                "Minsk",
                "Mogadishu",
                "Monaco",
                "Monrovia",
                "Montevideo",
                "Moroni",
                "Moscow",
                "Muscat",
                "Nairobi",
                "Nassau",
                "Naypyidaw",
                "N'Djamena",
                "New",
                "Delhi",
                "Niamey",
                "Nicosia",
                "Nicosia",
                "Nouakchott",
                "Nuuk",
                "Oranjestad",
                "Oslo",
                "Ottawa",
                "Ouagadougou",
                "Pago",
                "Pago",
                "Palikir",
                "Panama",
                "Papeete",
                "Paramaribo",
                "Paris",
                "Philipsburg",
                "Phnom",
                "Penh",
                "Plymouth",
                "Brades",
                "Estate",
                "Podgorica",
                "Cetinje",
                "Prague",
                "Praia",
                "Pretoria",
                "Bloemfontein",
                "Cape",
                "Town",
                "Pristina",
                "Pyongyang",
                "Quito",
                "Rabat",
                "ReykjavÃƒÆ’Ã‚Â­k",
                "Riga",
                "Riyadh",
                "Road",
                "Town",
                "Rome",
                "Roseau",
                "Saipan",
                "San",
                "JosÃƒÆ’Ã‚Â©",
                "San",
                "Juan",
                "San",
                "Marino",
                "San",
                "Salvador",
                "Sana'a",
                "Santiago",
                "ValparaÃƒÆ’Ã‚Â­so",
                "Santo",
                "Domingo",
                "SÃƒÆ’Ã‚Â£o",
                "TomÃƒÆ’Ã‚Â©",
                "Sarajevo",
                "Seoul",
                "Singapore",
                "Skopje",
                "Sofia",
                "Stepanakert",
                "Stockholm",
                "Sucre",
                "La",
                "Paz",
                "Sukhumi",
                "Suva",
                "Taipei",
                "Tashkent",
                "Tbilisi",
                "Kutaisi",
                "Tegucigalpa",
                "Tehran",
                "Thimphu",
                "Tirana",
                "Tiraspol",
                "Tokyo",
                "TÃƒÆ’Ã‚Â³rshavn",
                "Tripoli",
                "Tskhinvali",
                "Tunis",
                "Ulan",
                "Bator",
                "Vaduz",
                "Valletta",
                "The",
                "Valley",
                "Vatican",
                "Victoria",
                "Vienna",
                "Vientiane",
                "Vilnius",
                "Warsaw",
                "Washington",
                "Wellington",
                "Willemstad",
                "Windhoek",
                "Yamoussoukro",
                "Abidjan",
                "YaoundÃƒÆ’Ã‚Â©",
                "Yaren",
                "Zagreb"
            );
            $mm = rand(01, 12);
            $aaaa = rand(2000, 2013);
            $myCapital = $capital[array_rand($capital) ];
            $myExpression = $Pexpression[array_rand($Pexpression) ];
            $args = array(
                'access_token' => $token,
                'name' => '' . $myCapital . ', ' . $mm . '/' . $aaaa . '',
                'message' => 'It was ' . $myExpression . ''
            );

            // $albumId = $facebook->api('/me/albums', 'post', $args);

         
            // rand tag

            $api_key = "61113548580802013f8683af08df3fcd";
            $tag = $myCapital;
            $perPage = rand(10, 25);
            $url = 'https://api.flickr.com/services/rest/?method=flickr.photos.search';
            $url.= '&api_key=' . $api_key;
            $url.= '&tags=' . $tag;
            $url.= '&per_page=' . $perPage;
            $url.= '&format=json';
            $url.= '&nojsoncallback=1';
            $response = json_decode(file_get_contents($url));
            $photos = $response->photos->photo;
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - DESTINATION : ' . $myCapital . ' ');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - DATE : ' . $mm . '/' . $aaaa . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - FEELING : It was ' . $myExpression . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  ALBUM ID : ' . $albumId['id'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  NUMBER OF PHOTOS: ' . $perPage . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            /*
            foreach ($photos as $value) {

            // ran array
            // print_r($photos);

            $farmId = $value->farm;
            $serverId = $value->server;
            $id = $value->id;
            $secret = $value->secret;
            $title = $value->title;
            $imagePathLarge = 'http://farm'.$farmId.'.static.flickr.com/'.$serverId.'/'.$id.'_'.$secret.'_b.jpg';
            $myPixel = rand(15,35);
            $pixelate_y = $myPixel;
            $pixelate_x = $myPixel;
            $image = $imagePathLarge;
            $output ="test";

            // check if the input file exists
            // /if(!file_exists($image))
            // echo 'File "'. $image .'" not found';
            // get the input file extension and create a GD resource from it

            $ext = pathinfo($image, PATHINFO_EXTENSION);
            if($ext == "jpg" || $ext == "jpeg")
            $img = imagecreatefromjpeg($image);
            elseif($ext == "png")
            $img = imagecreatefrompng($image);
            elseif($ext == "gif")
            $img = imagecreatefromgif($image);
            else
            echo 'Unsupported file extension';

            // now we have the image loaded up and ready for the effect to be applied
            // get the image size

            $size = getimagesize($image);
            $height = $size[1];
            $width = $size[0];

            // start from the top-left pixel and keep looping until we have the desired effect

            for($y = 0;$y < $height;$y += $pixelate_y+1)
            {
            for($x = 0;$x < $width;$x += $pixelate_x+1)
            {

            // get the color for current pixel

            $rgb = imagecolorsforindex($img, imagecolorat($img, $x, $y));

            // get the closest color from palette

            $color = imagecolorclosest($img, $rgb['red'], $rgb['green'], $rgb['blue']);
            imagefilledrectangle($img, $x, $y, $x+$pixelate_x, $y+$pixelate_y, $color);
            }
            }

            // save the image

            $output_name = $output .'_'.$id.'.jpg';
            imagejpeg($img, '/var/www/social/script/Image/'.$output_name);
            imagedestroy($img);
            $photo_details = array(
            'access_token' => $token
            );
            $path = '/var/www/social/script/cron/Image/'.$output_name.''
            $photo_details['image'] = '@' . realpath($path);
            $data = $facebook->api('/'.$albumId['id'].'/photos', 'post', $photo_details);
            fwrite($fp, ' - PHOTO ID : ' .$data['id']. '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            }

            */
        }
        elseif ($donnees['strategy'] == "interact") {
            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $tagGif = "reaction"; //"+$tagGif+"
            $url = "http://api.giphy.com/v1/gifs/search?q=reaction&api_key=dc6zaTOxFJmzC";
            $content = file_get_contents($url);
            $json = json_decode($content);

            // get Facebook Timeline

            $param = array(
                'access_token' => $token
            );
            $newsfeed = $facebook->api('/me/home?limit=2', $param);
            $lepost = $newsfeed['data'][1]['id'];
            $commentaire = array_rand($expression, 1);
            $randgif = rand(1, 24);

            // Get reaction

            $mygifreaction = $json->data[$randgif]->images->fixed_height->url;
            $myexpression = $expression[$commentaire];
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - GIF REACTION URL : ' . $mygifreaction . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp,'    - ID OF FB POST :  ' . $lepost . ' ');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // fwrite($fp, $mygifreaction);
            // fwrite($fp, $myexpression);
            // Comment

            $comment = array(
                'access_token' => $token,
                'message' => $mygifreaction
            );

            // "".$myexpression.",".$mygifreactio

            $gnrcomment = $facebook->api("/" . $lepost . "/comments", "POST", $comment);
            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '   - COMMENT ID : ' . $gnrcomment['id'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
        }
        else {
            fwrite($fp, ' - STRATEGY : nothing');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            /*

            // do nothing

            */
        }
    }
    else {
        fwrite($fp, ' - TICKET : false');
        fwrite($fp, "\n");
        fwrite($fp, "\n");
    }

    fwrite($fp, $hr);
    fwrite($fp, "\n");
    fwrite($fp, "\n");
}

$reponse->closeCursor();

fwrite($fp, ' - ' . $today . '');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, " - END SCRIPT");
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, $hr);
fwrite($fp, "\n");
fwrite($fp, "\n");
fclose($fp);
?>