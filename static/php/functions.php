<?php 
    require_once './conn.php'; //加载数据库
    header('Access-Control-Allow-Origin:*');
        
    //获取传过来的值
    $postdata = json_decode(file_get_contents('php://input'),true);
    
    //是否传了id值过来
    if(isset($_GET['id'])){

        //更新内容
        if(isset($postdata['recommend'])){
            if($postdata['recommend'] == "true"){
                $text = "recommend = '".time()."'";
            }else{
                $text = "recommend = '0'";
            }
        }
        if(isset($postdata['online'])){
            $text = "online = '".$postdata['online']."'";
        }

        $sql = "UPDATE `articledata` SET ". $text ." WHERE id='" .$_GET['id']."'";
        $retval = mysqli_query( $conn, $sql );

        if($retval){
            echo '{"code":1,"msg":"更新成功！"}';
        }else{
            echo '{"code":-1,"msg":"更新失败！"}';
        }
    }

    //释放
    mysqli_free_result($row);
    mysqli_free_result($retval);
    //关闭连接
    mysqli_close($conn);
?>