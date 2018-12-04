<?php
    include_once('user.php');
    $data = json_decode(file_get_contents("php://input"),true);
    $ip = '{"code":0,"msg":"密码错误！"}';
    if(isset($data['loginsign'])){
        if($data['loginsign'] == md5($_SERVER["REMOTE_ADDR"] . $_SERVER['HTTP_USER_AGENT'] . $user . $password)){
            $ip = '{"code":1,"msg":"验证通过"}';
        }else{
            $ip = '{"code":0,"msg":"验证不通过"}';
        }
    }else{
        if(isset($data['user']) && isset($data['password']) && $data['user'] == $user && $data['password'] == $password){
            $ip = '{"code":1,"msg":"登陆成功！","loginsign":"'.md5($_SERVER["REMOTE_ADDR"] . $_SERVER['HTTP_USER_AGENT'] . $user . $password).'"}';
        }
    }
    echo $ip;
?>