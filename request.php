#!/usr/bin/php

<?php
require_once("lib.php");

//creates an empty document on disk to prevent further changes by other arriving request commands
if (file_exists("live.lock") == false) {
  $lockingDocument = fopen("live.lock", "a+");
  fclose($lockingDocument);//文件创建完毕
  print ("[debug] document set\n");
  //determine whether
  $liveroomState = requestLiveroomState($roomid);
  
  if ($liveroomState == 1) {
  	print ("[debug] live started\n");
    //some variables
    $filename = makeFileName();
    $downloadURL = makeApiRequest($roomid);
    //sends mail
    $mail->Subject = '录播组通知 - 直播已开始';
    $mail->Body    = '直播已开始录制。';
    $mail->AltBody = '直播已开始录制。';
    $mail -> send();
    //calls download manager
    downloadDistantFile($downloadURL, $filename);
    unlink("live.lock"); //removes live lock
    print ("[debug] document destroyed\n");
    $mail->Subject = '录播组通知 - 直播已结束';
    $mail->Body    = '直播已结束。';
    $mail->AltBody = '直播已结束。';
    $mail -> send();
    exit();
  } else {
    unlink("live.lock"); //removes live lock
    print ("[debug] document destroyed, no operation performed\n");
    exit();
  }
} else {
	print ("[warn] document exists\n");
}

?>
