<?php # _includes/functions.php

session_start();

if (!isset($_SESSION['user'])) {
    if ($pageTitle != 'Login') {
        header("Location: login.php");
        die();
    }
}

require_once 'mysqli-connect.php';

// function for querying mysql
function queryMysql($query)
{
    global $mysqli;
    $result = $mysqli->query($query);
    if (!$result) die ($mysqli->error);
    return $result;
}

// Sanitize input with sanitizeString
function sanitizeString($var)
{
    global $mysqli;
    $var = stripslashes($var);
    $var = strip_tags($var);
    $var = htmlentities($var);
    return $mysqli->real_escape_string($var);
}

// number of requests
$numRequests = "4";

// today's date in YYYYMMDD format
$todaysDate = date("Ymd");
//convert yyyymmdd date to UNIX date
$todaysDate = strtotime($todaysDate);
// date from GET variable
$d = htmlspecialchars($_GET["d"]);
// if no $d variable in GET, then today's date is $d
if ($d == "") { $d = $todaysDate; }

// create previous day's UNIX date
$prevDay = $d - 86400;
// create next day's UNIX date
$nextDay = $d + 86400;

// database format of date
$dbDate = date("Ymd", $d);

// parse request JSON string - return array
function parseJSONrequest($request) {
    // create array
    $req = array();
    
    // $req['date']        = date YYYYMMDD
    // $req['time']        = time 0000
    // $req['party']       = party
    // $req['f_name']      = first name
    // $req['l_name']      = last name
    // $req['phone']       = phone 9999999999
    // $req['phoneNice']   = phone (999)999-9999
    // $req['email']       = email
    // $req['notes']       = notes
    // $req['birthday']    = birthday
    // $req['anniversary'] = anniversary
    // $req['allergy']     = allergy
    // $req['dateUnix']    = date UNIX
    // $req['dateNice']    = date M/DD/YY 
    // $req['timeNice']    = time 0:00am

    // decode request
    $jsonData = json_decode($request);
    // set date YYYYMMDD
    $req['date'] = $jsonData->date;
    // set date UNIX
    $req['dateUnix'] = strtotime($req['date']);
    // set date M/DD/YY
    $req['dateNice'] = date("n/j/y", $req['dateUnix']);
    // set time 0000
    $req['time'] = $jsonData->time;
    // set time 0:00am
    switch ($req['time']) {
        case "1730":
            $req['timeNice'] = "5:30pm";
            break;
        case "1930":
            $req['timeNice'] = "7:30pm";
            break;
        case "2130":
            $req['timeNice'] = "9:30pm";
            break;
    }
    // set party
    $req['party'] = $jsonData->party;
    // set first name
    $req['f_name'] = $jsonData->f_name;
    // set last name
    $req['l_name'] = $jsonData->l_name;
    // set phone number
    $req['phone'] = $jsonData->phone;
    // set phoneNice
    $req['phoneNice'] = getNicePhone($req['phone']);
    // set email
    $req['email'] = $jsonData->email;
    // set notes
    $req['notes'] = $jsonData->notes;
    // deal with extras
    $req['birthday'] = $jsonData->birthday;
    $req['anniversary'] = $jsonData->anniversary;
    $req['allergy'] = $jsonData->allergy;
    // return array
    return $req;
}

function getNicePhone($number) {
    $niceNumber = '('. substr($number, 0, 3) . ')' . substr($number, 2, 3) . '-' . substr($number, 5, 4);
    return $niceNumber;
}

function destroySession() {
    $_SESSION = array();

    if(session_id() != "" || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time() - 2592000, '/');
    }

    session_destroy();
}
?>