<?php
require_once("conf.php");
require_once("mailsender-wrapper.php");

function makeApiRequest ($roomid) {
  $requestURL = "https://api.live.bilibili.com/room/v1/Room/playUrl?cid=".$roomid."&quality=4&platform=web";
  $responseDocument = file_get_contents($requestURL);
  $jsonify = json_decode($responseDocument);
  $durl = $jsonify -> data -> durl[0] -> url;
  return $durl;
}

function requestLiveroomState ($roomid) {
  $requestURL = "https://api.live.bilibili.com/room/v1/Room/get_info?room_id=".$roomid."&from=room";
  $responseDocument = file_get_contents($requestURL);
  $jsonify = json_decode($responseDocument);
  $livestatus = $jsonify -> data -> live_status;
  return $livestatus;
}

function makeFileName() {
//please calibrate your server - you ought to have timezone set to Asia/Shanghai.
  date_default_timezone_set("Asia/Shanghai");
  $filename = date("Y-m-d-H-m-s", time()) ."-lgnn-live.flv";
  return $filename;
}

//下载大文件的代码来自这里：https://gist.github.com/damienalexandre/1258787/917e1058a502895a13dcdb02cbf459c272065c5f

function downloadDistantFile($url, $dest)
  {
    $options = array(
      CURLOPT_FILE => is_resource($dest) ? $dest : fopen($dest, 'w'),
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_URL => $url,
      CURLOPT_FAILONERROR => true, // HTTP code > 400 will throw curl error
    );

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $return = curl_exec($ch);

    if ($return === false)
    {
      $curlerror = curl_error($ch);
      //sends mail
      $mail->Subject = '录播组通知 - 下载服务出现问题';
      $mail->Body    = $curlerror;
      $mail->AltBody = $curlerror;
      $mail -> send();
      return $curlerror;
    }
    else
    {
      return true;
    }
  }

function exceptionLoggerAgent($timestamp, $content) {

}

?>
