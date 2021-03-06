<?php
//Untuk antisipasi error No Access Control Allowed antar host
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
 
//Isi sesuai database
$mysqli=new mysqli("localhost","root","", "jokedb");
 

 $postdata = file_get_contents("php://input");
 $request = json_decode($postdata);
 $id = $request->id;
 $uname = $request->uname;

  $sql="SELECT A.id,A.tanggal,A.photo1,A.deskripsi,A.pengirim,A.location,A.lat,A.lng,A.like,B.dp FROM timelines A,users B WHERE A.id='$id' AND B.email='$uname'";

  $result = mysqli_query($mysqli,$sql);

  
    $data = mysqli_fetch_array($result, MYSQL_ASSOC); //Data user difetch dalam bentuk array lalu diubah jadi JSON biar bisa diolah per objek/fieldnya
    echo json_encode($data);
  exit();
?>