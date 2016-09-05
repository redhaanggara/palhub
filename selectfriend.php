<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers:        {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


$link = new mysqli("localhost", "root", "", "jokedb");

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);
$user = mysql_real_escape_string($request->user);

$result = $link->query("SELECT * FROM friend WHERE user='$user'");


$outp = "";
while($rs = $result->fetch_array(MYSQLI_ASSOC)) {
    if ($outp != "") {$outp .= ",";}
    $outp .= '{"user":"'                       . $rs["user"]                        . '",';

    $outp .= '"friend":"'                       . $rs["friend"]                       . '",';

    $outp .= '"photo":"'                       . $rs["photo"]                       . '"}';

}
$outp ='{"records":['.$outp.']}';
$link->close();
echo($outp);

?>