<?php
        //Generic php function to send GCM push notification
   function sendMessageThroughGCM($registatoin_ids, $message) {
                //Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
                // Update your Google Cloud Messaging API Key
        //      define("GOOGLE_API_KEY", "API_SERVER_KEY");
        define("GOOGLE_API_KEY", "API_SERVER_KEY");
        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            print "ERROR!";
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
?>
<?php
  $gcmRegID  = file_get_contents("/var/www/gcm/GCMRegId.txt");
  $pushMessage = $argv[1];
  if (isset($gcmRegID)) {
    $gcmRegIds = array($gcmRegID);
    $message = array("m" => $pushMessage);
//    echo "RegID is $gcmRegID ";
    $pushStatus = sendMessageThroughGCM($gcmRegIds, $message);
  }
  else {
    echo "Failed to read RegID";
  }
?>
