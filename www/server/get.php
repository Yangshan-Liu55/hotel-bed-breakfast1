<?php

// Lägg till följande rader vid problem med Access-Control-Allow-Origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
  exit(0);
}

// En PHP-Fil som tar emot data
$response = file_get_contents("php://input");

// Skicka tillbaka response-info för att testa
echo $response;

// Omvandla (convert) JSON till ett PHP-Objekt
$request = json_decode($response);

// Lagra data från objektet i olika variabler. 
// 这里可以给例子：可以先从页面post发送用户邮箱email，变量 $email = $request->email; 用于下面向数据库读取该用户的订单信息
$email = $request->email;
$fname = $request->fname;
$lname = $request->lname;
$gender = $request->gender;
$mobile = $request->mobile;
$adults = $request->adults;
$child = $request->child;
$adate = $request->adate;
$ddate = $request->ddate;
$nights = $request->nights;
$price = $request->price;
$roomid = $request->roomid;
$roomname = $request->roomname;
$total = $request->total;
//当下时间
$btime = date("Y-m-d H:i:s",time());


// Logga in i databasen!
$dbHost = "fdb18.awardspace.net";
$dbUser = "2673761_contacts";
$dbPass = "liangshan87";
$dbName = "2673761_contacts";

$connection = mysqli_connect($dbHost , $dbUser , $dbPass , $dbName);
if(!$connection){
    echo "<h1>" . mysqli_connect_error() . "</h1>"; exit;
}
mysqli_set_charset($connection, "utf8");


// hämta data från databas
$query="SELECT * FROM rooms";

$table=mysqli_query($connection, $query) 
or die(mysql_error($connection));

$rows=array();

while($row = mysqli_fetch_assoc($table)) {
    $rows[] = $row;
 }
 
 echo json_encode($rows); 

?>
