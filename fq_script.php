<?php

// ////////////////////////////////////// 
// vincent dubois
// /var/www/social/script/cron/#.php
// HEAD - geneve
// /////////////////////////////////////

$hr = "--------------------------------------------------------------------------------";
$today = date("Y-m-d H:i:s");
$fp = fopen('/var/www/undefined/social/script/cron/log_fq/fq-' . $today . '.txt', 'w');

// $fp = fopen($today, 'w')

$directory = '/var/www/undefined/social/script/cron/log_fq/';
$files = glob($directory . '*');

if ($files !== false) {
	$filecount = count($files);

	// echo $filecount;

}

$num = $filecount;

// /////////////////////////////////////////////////////////////////////////////////
// ////////////////////////////////////// base de donnÃ©es

try {

	// connexion mysql

	$bdd = new PDO('mysql:host=localhost;dbname=#', '#', '#');
}

catch(Exception $e) {

	// erreur mysql

	die('Erreur : ' . $e->getMessage());
}

$reponse = $bdd->query('SELECT * FROM user_fq');

// ////////////////////////////////////// require

require_once ('/var/www/undefined/social/script/foursquareSDK/FoursquareAPI.class.php');

// //////////////////////////////////// API KEY

$client_key = "#"; // Your Client ID
$client_secret = "#"; // Your Client Secret

// //////////////////////////////////// API

$foursquare = new FoursquareAPI($client_key, $client_secret);

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
fwrite($fp, ' - LOG FILE : /var/www/undefined/social/script/cron/log_fq/' . $today . '.txt');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, " - SCRIPT PHP : /cron_fq_log.php");
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, $hr);
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - LOG : #' . $num . '');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - SOCIAL NETWORK : Foursquare');
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

	fwrite($fp, ' - USER : ' . $donnees['first_name'] . '');
	fwrite($fp, "\n");
	fwrite($fp, "\n");

    $toggle = rand(3, 6);
    //$toggle = 5;

	fwrite($fp, ' - TICKET : ' . $toggle . '');
	fwrite($fp, "\n");
	fwrite($fp, "\n");

	$token = $donnees['token'];
	$foursquare->SetAccessToken($token);

	if ($toggle == 5) {

		fwrite($fp, ' - TICKET : true');
		fwrite($fp, "\n");
		fwrite($fp, "\n");
		fwrite($fp, ' - TOKEN : ok');
		fwrite($fp, "\n");
		fwrite($fp, "\n");

		if ($donnees['strategy'] == "random") {

			fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");

			// get

			$response1 = $foursquare->GetPrivate("users/self/checkins");
			$checkin1 = json_decode($response1);
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
				"AsunciÃ³n",
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
				"BogotÃ¡",
				"BrasÃ­lia",
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
				"Town",
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
				"AaiÃºn",
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
				"HagÃ¥tÃ±a",
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
				"LomÃ©",
				"London",
				"Luanda",
				"Lusaka",
				"Luxembourg",
				"Madrid",
				"Majuro",
				"Malabo",
				"MalÃ©",
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
				"ReykjavÃ­k",
				"Riga",
				"Riyadh",
				"Road",
				"Town",
				"Rome",
				"Roseau",
				"Saipan",
				"San",
				"JosÃ©",
				"San",
				"Juan",
				"San",
				"Marino",
				"San",
				"Salvador",
				"Sana'a",
				"Santiago",
				"ValparaÃ­so",
				"Santo",
				"Domingo",
				"SÃ£o",
				"TomÃ©",
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
				"TÃ³rshavn",
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
				"YaoundÃ©",
				"Yaren",
				"Zagreb"
			);
			$mycapital = $capital[mt_rand(0, count($capital) - 1) ];

			// params Search

			$params = array(
				"near" => $mycapital,
				"radius" => "300",
				"intent" => "checkin"
			);

			// Perform a request to a public resource

			$response = $foursquare->GetPublic("venues/search", $params);
			$venues = json_decode($response);
			$total = count($venues->response->venues);
			$rd = rand(0, $total);

			fwrite($fp, ' - GET :');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
			fwrite($fp, '    -  CAPITAL : ' . $mycapital . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
			fwrite($fp, '    - CAPITAL PLACE : ' . $venues->response->venues[$rd]->name . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");

			// post

			$rdata = array(
				'venueId' => $venues->response->venues[$rd]->id
			);
			$check = $foursquare->GetPrivate("checkins/add", $rdata, $POST = true);
			$checkDe = json_decode($check);

			// $checkDe->response->checkin->id

			fwrite($fp, ' - POST :');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
			fwrite($fp, '    - CHECK-IN ID : ' . $checkDe->response->checkin->id . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
		}
		elseif ($donnees['strategy'] == "similar") {
			fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");

			// get last ll check

			$response1 = $foursquare->GetPrivate("users/self/checkins");
			$checkin1 = json_decode($response1);
			$myLat = $checkin1->response->checkins->items[0]->venue->location->lat;
			$myLng = $checkin1->response->checkins->items[0]->venue->location->lng;

			// change ll

			$NewLat = substr_replace($myLat, "", 7);
			$NewLng = substr_replace($myLng, "", 7);
			$distance = 20;

			// search with new ll

			$params = array(
				"ll" => "$NewLat,$NewLng" /*,"intent"=>"browse"*/
			);
			$response = $foursquare->GetPublic("venues/search", $params);
			$venues = json_decode($response);
			$NearCheck = $venues->response->venues[5]->id;
			fwrite($fp, ' - GET :');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
			fwrite($fp, '    -  NEAR CHECK : ' . $NearCheck . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");

			// post

			$data = array(
				'venueId' => $NearCheck
			);
			$check = $foursquare->GetPrivate("checkins/add", $data, $POST = true);
			$checkDe = json_decode($check);

			// $checkDe->response->checkin->id
			// fwrite($fp, $check);

			fwrite($fp, ' - POST :');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
			fwrite($fp, '    -  CHECK-IN ID : ' . $checkDe->response->checkin->id . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
		}
		elseif ($donnees['strategy'] == "flourish") {

			fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");

			// get

			$response1 = $foursquare->GetPrivate("users/self/checkins");
			$checkin1 = json_decode($response1);
			$myLat = $checkin1->response->checkins->items[0]->venue->location->lat;
			$myLng = $checkin1->response->checkins->items[0]->venue->location->lng;

			// params Search

			$params = array(
				"ll" => "$myLat,$myLng",
				"intent" => "browse",
				"radius" => "100"
			);

			// Perform a request to a public resource

			$response = $foursquare->GetPublic("venues/search", $params);
			$venues = json_decode($response);

			// print_r($venues->response->venues[5]);

			fwrite($fp, ' - GET :');
			fwrite($fp, "\n");
			fwrite($fp, "\n");
			fwrite($fp, '    - EXAMPLE PLACE : ' . $venues->response->venues[5]->name . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");

			// post

			$lengt = count($venues->response->venues);
			fwrite($fp, '    - TOTAL CHECK : ' . $lengt . '');
			fwrite($fp, "\n");
			fwrite($fp, "\n");

			for ($ck = 0; $ck < $lengt; $ck++) {
				$theid = $venues->response->venues[$ck]->id;
				$data = array(
					'venueId' => $theid
				);
				$check = $foursquare->GetPrivate("checkins/add", $data, $POST = true);
				$checkDe = json_decode($check);
				fwrite($fp, ' - POST :');
				fwrite($fp, "\n");
				fwrite($fp, "\n");
				fwrite($fp, '    -  CHECK-IN ID : ' . $checkDe->response->checkin->id . '');
				fwrite($fp, "\n");
				fwrite($fp, "\n");
			}
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
		fwrite($fp, ' - TOOGLE : false');
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
