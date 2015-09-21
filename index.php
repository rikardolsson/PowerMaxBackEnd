<?php
// get the command
$command = $_REQUEST['command'];
$RegId = $_REQUEST['RegId'];

$host    = "127.0.0.1";
$port    = 4096;
$EnableAlarmMessage = "EnableAlarm";
$DisableAlarmMessage = "DisableAlarm";
$StatusAlarmMessage = "StatusAlarm";

if(!empty($_GET["shareRegId"])) {
  $gcmRegID  = $_POST["regId"];
  echo "RegisterDevice and $gcmRegID";
  file_put_contents("GCMRegId.txt",$gcmRegID);
  exit;
} else {


if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);

    die("Couldn't create socket: [$errorcode] $errormsg \n");
}

//Connect socket to remote server
if(!socket_connect($sock , $host , $port))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    socket_close($sock);

    die("Could not connect: [$errorcode] $errormsg \n");
}

if($command == "EnableAlarm") {
  //Call function for enable alarm
  echo "EnableAlarm";
  //Send the message to the server
  if( ! socket_send ( $sock , $EnableAlarmMessage , strlen($EnableAlarmMessage) , 0))
  {
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    socket_close($sock);
    die("Could not send data: [$errorcode] $errormsg \n");
  }
} else if($command == "DisableAlarm") {
  //Call function for disable alarm
  echo "DisableAlarm";
  if( ! socket_send ( $sock , $DisableAlarmMessage , strlen($DisableAlarmMessage) , 0))
  {
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    socket_close($sock);
    die("Could not send data: [$errorcode] $errormsg \n");
  }

} else if(($command == "RegisterDevice")) {
  //Register device for GCM messages
  echo "RegisterDevice";

} else if($command == "StatusAlarm") {
  //Call function for disable alarm
  if( ! socket_send ( $sock , $StatusAlarmMessage , strlen($StatusAlarmMessage) , 0))
  {
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
    socket_close($sock);
    die("Could not send data: [$errorcode] $errormsg \n");
  }

  $buf = '';
  if (false !== ($bytes = socket_recv($sock, $buf, 2048, MSG_WAITALL))) {
      echo "$buf";
  } else {
      echo "socket_recv() failed; reason: " . socket_strerror(socket_last_error($socket)) . "\n";
  }

} else {
  //Should not be here is input will be logged and Administrator notified
  socket_close($sock);
  echo "Unknow Input";
}
}
socket_close($sock);
?>
