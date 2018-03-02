<?php
date_default_timezone_set('PRC');
//服务器信息
$server = 'udp://192.168.182.105:9998';
//消息结束符号
$msg_eof = "\n";
$socket = stream_socket_server($server, $errno, $errstr, STREAM_SERVER_BIND);
if (!$socket) {
    die("$errstr ($errno)");
}

//NessCode
$NessCode = array("1"=>"Access-Request","2"=>"Access-Accept","3"=>"Access-Reject","4"=>"Accounting-Request","5"=>"Accounting-Response");


$test = 1;
$flag = 0;
$starttime = 0;
$overtime = 0;

do {
    //接收客户端发来的信息
    $inMsg = stream_socket_recvfrom($socket, 1024, 0, $peer);
    //服务端打印出相关信息
    $nasInfo = explode(":", $peer);




//    echo "NAS-IP-Address : {$nasInfo[0]}\n";
//    echo "NAS-Port : {$nasInfo[1]}\n";
//
//
//    $inMsgArr = [];
//    foreach (explode("\n", $inMsg) as $value) {
//        $split = explode(":", $value);
//        $inMsgArr[$split[0]]=$split[1];
//    }
//
//    //var_dump($inMsgArr);
//
//    $Request = '';
//
//    if (!empty($inMsgArr["Code"])) {
//        $code = $inMsgArr["Code"];
//
//        echo "Code : {$NessCode[$inMsgArr["Code"]]}({$inMsgArr["Code"]})\n";
//
//        switch ($code) {
//            case '1':
//            if (!empty($inMsgArr["Token"])) {
//                echo "Token : {$inMsgArr["Token"]}";
//                $acctToken = "Acct-Token:".md5($inMsgArr["Token"].time());
//                $Request = "Code:".$NessCode["2"]."\n".$acctToken;
//            } else {
//                $Request = errorCode();
//            }
//                break;
//            case '4':
//                if (!empty($inMsgArr["Acct-Token"])) {
//                    $Request = "Code:".$NessCode["5"]."\n".$acctToken;
//                } else {
//                    $Request = errorCode();
//                }
//                break;
//            default:
//                $Request = errorCode();
//                break;
//        }
//    } else {
//        $Request = errorCode();
//        echo "Code : Null-Code(0)\n";
//    }

    //echo date("Y-m-d H:i:s")."  ";
//    echo getMillisecond()."  ";
//    echo $test."\n";

    if($test == 1){
        $starttime = getMillisecond();
    }

    $test++;

    if(getMillisecond() - $starttime >= 1000  && $flag == 0){
        echo $test."\n";
        $flag = 1;
    }

    stream_socket_sendto($socket, date("Y-m-d H:i:s"), 0, $peer);
} while ($inMsg !== false);


function errorCode()
{
    $NessCode = array("1"=>"Access-Request","2"=>"Access-Accept","3"=>"Access-Reject","4"=>"Accounting-Request","5"=>"Accounting-Response");
    //echo "Code : {$NessCode["3"]}(3)\n";
    return "Code:".$NessCode["3"];
}


//毫秒代码
function getMillisecond() {
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
}