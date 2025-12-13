<?php
require_once(__DIR__ . "sdk/config.php");
require_once(__DIR__ . "sdk/util/Log.php");
require_once(__DIR__ . "sdk/util/Cache.php");
require_once(__DIR__ . "sdk/api/Auth.php");
require_once(__DIR__ . "sdk/api/User.php");
require_once(__DIR__ . "sdk/api/Message.php");
require_once(__DIR__ . "sdk/api/ISVServiceImpl.php");

$code = $_GET['code'];
$corpId = $_GET['corpid'];
$corpInfo = ISVClass::getCorpInfo($corpId);
$accessToken = $corpInfo['corpAccessToken'];
$res = Auth::getPerson($accessToken,$code);
echo $res;
exit;
