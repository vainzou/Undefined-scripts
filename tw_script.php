<?php

// ////////////////////////////////////// 
// vincent dubois
// /var/www/social/script/cron/#.php
// HEAD - geneve
// /////////////////////////////////////

$hr = "--------------------------------------------------------------------------------";
$today = date("Y-m-d H:i:s");
$fp = fopen('/var/www/undefined/social/script/cron/log_tw/tw-' . $today . '.txt', 'w');

// $fp = fopen($today, 'w')

$directory = '/var/www/undefined/social/script/cron/log_tw/';
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

$reponse = $bdd->query('SELECT * FROM user_tw');

// ////////////////////////////////////// require

require_once ('/var/www/undefined/social/script/twitterSDK/twitteroauth.php');

// //////////////////////////////////// API KEY

$consumerkey = "#";
$consumersecret = "#";

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
fwrite($fp, ' - LOG FILE : /var/www/undefined/social/script/cron/log_tw/' . $today . '.txt');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, " - SCRIPT PHP : /cron_tw_log.php");
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, $hr);
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - LOG : #' . $num . '');
fwrite($fp, "\n");
fwrite($fp, "\n");
fwrite($fp, ' - SOCIAL NETWORK : Twitter');
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

while ($donnees = $reponse->fetch()) {

    fwrite($fp, ' - USER : ' . $donnees['username'] . '');

    fwrite($fp, "\n");
    fwrite($fp, "\n");

   // $toggle = rand(3, 6);
    $toggle = 5;
    fwrite($fp, ' - TICKET : ' . $toggle . '');

    fwrite($fp, "\n");
    fwrite($fp, "\n");

    $accesstoken = $donnees['oauth_token'];
    $accesstokensecret = $donnees['oauth_token_secret'];
    $connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
    $content = $connection->get('account/verify_credentials');

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
    $begin = array(
        "greetings",
        "howdy",
        "hi there",
        "how's the world treating you",
        "yo",
        "hello",
        "what's cooking",
        "how's it going",
        "how's by you",
        "sup",
        "tsup"
    );
    /*

    // Sugested user but not personnal

    $suggesList = $connection->get('users/suggestions');
    $random = $suggesList[mt_rand(0, count($suggesList) - 1)];

    // print_r($suggesList[0]);

    print_r($random->slug);
    $mySuggestGroup = $random->slug;
    $suggesList = $connection->get('users/suggestions/'.$mySuggestGroup.'/members');
    print_r($suggesList[0]->id);
    print_r($suggesList[0]->screen_name);
    $NewfollowId = $suggesList[0]->id;

    // $myFollow = $connecton->post('friendships/create',array('user_id'=>$NewfollowId));

    */

    if ($toggle == 5) {
        
        fwrite($fp, ' - TICKET : true');
        fwrite($fp, "\n");
        fwrite($fp, "\n");
        fwrite($fp, ' - TOKEN : ok');
        fwrite($fp, "\n");
        fwrite($fp, "\n");

        if ($donnees['strategy'] == "conversation") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // get

            $myFollowing = $connection->get('followers/ids');
            $randomf = $myFollowing->ids[mt_rand(0, count($myFollowing->ids) - 1) ];
            $randomB = $begin[mt_rand(0, count($begin) - 1) ];
            fwrite($fp, $randomB);
            $getidarray = array(
                'id' => $randomf,
            );
            $getid = $connection->get('users/show', $getidarray);;

            // print_r($getid);

            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  FOLLOWING ID: ' . $randomf . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  MESSAGE: ' . $randomB . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // post

            $NRconve = array(
                'status' => "@" . $getid->screen_name . " , " . $randomB . " ? "
            );

            // send message

            $itweet = $connection->post('statuses/update', $NRconve);
            
            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  TWEET ID : error//');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
        }
        elseif ($donnees['strategy'] == "copy") {

            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            $timeline = $connection->get('statuses/home_timeline', array(
                'count' => 10
            ));


            if (!empty($timeline[0]->text)) {
                fwrite($fp, '    -  STATUT OF : ' . $timeline[0]->user->name . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                fwrite($fp, '    -  STATUT TEXT : ' . $timeline[0]->text . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                $c_itweetarray = array(
                    'status' => "" . $timeline[0]->text . "",
                );

                // send message

                $ctweet = $connection->post('statuses/update', $c_itweetarray);
                fwrite($fp, ' - POST :');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
                fwrite($fp, '    -  STATUS ID : ' . $ctweet->id . '');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
            }
            else {
                fwrite($fp, '    -  STATUT TEXT : no message');
                fwrite($fp, "\n");
                fwrite($fp, "\n");
            }
        }
        elseif ($donnees['strategy'] == "bot") {
            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $ltweet = $connection->get('statuses/user_timeline', array(
                'count' => 3
            ));
            fwrite($fp, '    -  STATUT TEXT TO REPEAT : ' . $ltweet[0]->text . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $b_itweetarray = array(
                'status' => "" . $ltweet[0]->text . "",
            );

            // send message

            $btweet = $connection->post('statuses/update', $b_itweetarray);
            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  STATUS ID : id missing');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
        }
        elseif ($donnees['strategy'] == "friend") {
            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $myFollowing = $connection->get('friends/ids');
            $randomf = $myFollowing->ids[mt_rand(0, count($myFollowing->ids) - 1) ];

            $unFollow = $connection->post('friendships/destroy', array(
                'user_id' => $randomf
            ));
            $newfollow = array(
                'id' => $randomf
            );
            $myFollowing2 = $connection->get('friends/ids', $newfollow);
            $randomff = $myFollowing2->ids[mt_rand(0, count($myFollowing2->ids) - 1) ];

            // print_r($randomff);

            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  DELETE : ' . $randomf . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // post

            $newfollow3 = array(
                'id' => $randomff
            );
            $myFollowing3 = $connection->get('friends/ids', $newfollow3);
            
            $randomfff = $myFollowing3->ids[mt_rand(0, count($myFollowing3->ids) - 1) ];
            $myfollow = $connection->post('friendships/create', array(
                'id' => $randomfff
            ));


            $forid = array(
                'id' => $randomf
            );

            $maisquelid = $connection->get('users/show', $forid);

            $forid1 = array(
                'id' => $randomfff
            );

            $maisquelid1 = $connection->get('users/show', $forid1);

            $UnfoArray1 = array(
                'status' => "just decided to follow @".$maisquelid1->screen_name.""         
                   );

            // send message

            $Unfo1 = $connection->post('statuses/update', $UnfoArray1);

            $UnfoArray2 = array(
                'status' => "just decided to unfollow @".$maisquelid->screen_name.""         
                   );

            // send message

            $Unfo2 = $connection->post('statuses/update', $UnfoArray2);


            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - ADD : ' . $randomfff . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
        }
        elseif ($donnees['strategy'] == "interact") {
            fwrite($fp, ' - STRATEGY : ' . $donnees['strategy'] . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            $tagGif = "reaction"; //"+$tagGif+"
            $url = "http://api.giphy.com/v1/gifs/search?q=reaction&api_key=dc6zaTOxFJmzC";
            $content = file_get_contents($url);
            $json = json_decode($content);

            // get twitter feed and mentions
            // toogle entre les deux.

            $timeline = $connection->get('statuses/home_timeline', array(
                'count' => 10
            ));
            $mentions = $connection->get('statuses/mentions_timeline', array(
                'count' => 5
            ));

            // put a random choice
            // fwrite($fp, $timeline[0]->id);
            // fwrite($fp, $mentions[0]->id);
            // fwrite($fp, $mentions[0]->user->name);

            $commentaire = array_rand($expression, 1);
            $randgif = rand(1, 24);

            // Get reaction

            $mygifreaction = $json->data[$randgif]->images->fixed_height->url;
            $myexpression = $expression[$commentaire];
            fwrite($fp, ' - GET :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - MESSAGE : @' . $timeline[0]->user->screen_name . ' ' . $myexpression . ',' . $mygifreaction . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    - ANSWER TO ID : ' . $timeline[0]->id . '');
            fwrite($fp, "\n");
            fwrite($fp, "\n");

            // post tweet with.

            $m_itweetarray = array(
                'status' => "@" . $mentions[0]->user->screen_name . " " . $myexpression . "," . $mygifreaction . "",
                'in_reply_to_status_id' => $mentions[0]->id,
            );
            $t_itweetarray = array(
                'status' => "@" . $timeline[0]->user->screen_name . " " . $myexpression . "," . $mygifreaction . "",
                'in_reply_to_status_id' => $timeline[0]->id,
            );

            // send message

            $itweet = $connection->post('statuses/update', $t_itweetarray);
            fwrite($fp, ' - POST :');
            fwrite($fp, "\n");
            fwrite($fp, "\n");
            fwrite($fp, '    -  TWEET ID : ' . $itweet->id . '');
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
