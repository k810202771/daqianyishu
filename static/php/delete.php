<?php
ini_set("display_errors", "On");
error_reporting(E_ALL || E_STRICT);
    require_once './autoload.php';
    
    use Qiniu\Storage\BucketManager;

    header('Access-Control-Allow-Origin:*');
    
    use Qiniu\Auth;
    
    $bucket = 'images';
    $accessKey = '9z_oh12RFn7KAX3T-Idz3YDz7IcG1tIsAZ_qxdSV';
    $secretKey = 'DgIbQ3p0TRN5Yt221yySu5ujvQ8zK4cq5gsGx4LM';

    $key = ['FpNd2uuJwtRDJjvh7sYRQYZaEfhW','Fq5-W89TVGI1m5MDbEGM0Cg5Y38N','FsCuD-3ntWULx_Q1FZyiRF-WCnrG','FvEUjIaCHN8YBb1cQXSPE2ToSC8y'];
     
    $expires = 6000;
    $auth = new Auth($accessKey, $secretKey);
     
     
    $policy = array(
        //'callbackUrl' => 'http://micuer.com/qiniuyun/examples/upload_verify_callback.php',
        'callbackBody' => 'key=$(key)&hash=$(etag)&bucket=$(bucket)&fsize=$(fsize)&name=$(x:name)',
        'callbackBodyType' => 'application/json'
    );
    $token = $auth->uploadToken($bucket, null, $expires, $policy, true);

    $bucketMgr = new BucketManager($auth);
     
    for($i = 0; $i < count($key); $i++){
        
        $err = $bucketMgr->delete($bucket,$key[$i]);
     
        if ($err !== null) {  
            echo 0;
            return;
        }else{
            echo "删除文件".$key[$i]."成功！";
        }
    }

?>