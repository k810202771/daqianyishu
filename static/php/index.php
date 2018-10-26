<?php 
require_once './autoload.php';
header('Access-Control-Allow-Origin:*');
 
use Qiniu\Auth;
 
$bucket = 'images';
$accessKey = '9z_oh12RFn7KAX3T-Idz3YDz7IcG1tIsAZ_qxdSV';
$secretKey = 'DgIbQ3p0TRN5Yt221yySu5ujvQ8zK4cq5gsGx4LM';
$auth = new Auth($accessKey, $secretKey);
$upToken = $auth->uploadToken($bucket, null, 3600);//获取上传所需的token

function request_by_curl($remote_server,$post_string,$upToken) {

    $headers = array();
    $headers[] = 'Content-Type:application/octet-stream';
    $headers[] = 'Authorization:UpToken '.$upToken;
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL,$remote_server); 
    curl_setopt($ch, CURLOPT_HTTPHEADER ,$headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $data = curl_exec($ch); 
    curl_close($ch); 

    return $data;

}

$postdata = json_decode(file_get_contents('php://input'),true);
$get = json_decode(request_by_curl('http://upload.qiniu.com/putb64/-1',$postdata['imgdata'],$upToken),true);

echo '{"src":"http://ph34rw0qj.bkt.clouddn.com/'.$get['key'].'","key":"'.$get['key'].'"}';