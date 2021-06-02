<?php
// ---------------------------------
    // SIM-IDを設定します。
    define('SIM_ID', 'XXXX');
    // 端末番号を設定します。
    define('TREM_ID', 'XXXX');
// ---------------------------------

    // IPフィルタ
    include_once('ipfilter.php');

    // ユーザエージェント取得
    $ua = $_SERVER['HTTP_USER_AGENT'];

    // 端末番号取得
    if (!strpos($ua, ';')) {

        // 前の部分を切り捨てる
        $ser = substr(strstr($ua, 'ser'), 3);
    } else {
        // セミコロンで区切る
        $ser = split(';', $ua);

        // 先頭の'ser'と取り除く
        $ser = substr($ser[count($ser) -2], 3);
    }

    // SIM-ID取得、セミコロンで区切る
    $icc = split(';', $ua);

    // 後ろの')'と先頭の'icc'と取り除く
    $icc = substr(trim($icc[count($icc) -1], ')'), 3);

    // 15桁以外の場合
    if (strlen($ser) != 15) {
        $msg = 'FTPメニューを選んでください。';

    // 端末番号が違う場合
    } elseif ($ser != TREM_ID) {
        $msg = $ser . '端末番号が不正です。';

    // セミコロンが無いと識別番号は取得できない
    } elseif (!strpos($ua, ';')) {
        $msg = $ua . 'UserAgentが不正です。';

    // 15桁以外の場合
    } elseif (strlen($icc) != 20) {
        $msg = $icc . 'SIM-IDが不明です。';

    // SIM-IDが違う場合
    } elseif ($icc != SIM_ID) {
        $msg = $icc . 'SIM-IDが不正です。';
    } else {
        system('net ' . $_POST['submit'] . ' "FTP Publishing"');
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=Shift-JIS" />
    <title>FTPサーバ復旧</title>
  </head>
  <body bgcolor="#ffffff" text="#666666" link="#FF8605" vlink="#FF8605" >
    <center>
      <br />
      <font size="-2"><?= $msg ?></font>
      <br />
      <form action="" method="post" utn>
        <input type="submit" name="submit" value="start" />
        <input type="submit" name="submit" value="stop" />
      </form>
    </center>
  </body>
</html>
