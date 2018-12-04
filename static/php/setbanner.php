<?php

    require_once './conn.php'; //加载数据库
    require_once './delete.php'; //加载数据库
    header('Access-Control-Allow-Origin:*');
    
    //获取传过来的值
    $postdata = json_decode(file_get_contents('php://input'),true);
    
    switch($postdata['type']){
        case 'init':

            //更新内容
            $sql = "insert into `bannerdata` (url,href,time) ".
            "values('".$postdata['url']."','".$postdata['href']."','".time()."');";
            $retval = mysqli_query( $conn, $sql );

            if($retval){

                //图片索引加一
                $sql = "UPDATE `waitforupload` SET number=number+1 WHERE url='".$postdata['img']."'";
                $retval = mysqli_query( $conn, $sql );

                echo '{"code":1,"msg":"添加成功！"}';
            }else{
                echo '{"code":-1,"msg":"添加失败！"}';
            }

        break;
        case 'delete':

            //查询出这个id的url地址
            $sql = "SELECT * FROM `bannerdata` WHERE id='".$postdata['id']."'";
            $retval = mysqli_query( $conn, $sql );
            $row = mysqli_fetch_array($retval,MYSQLI_ASSOC);
            
            //url转图片key
            $start = strlen('http://ph34rw0qj.bkt.clouddn.com/');
            $end = strlen($row['url']);
            $key = substr($row['url'], $start, $end);

            //删除这条记录
            $sql = "delete from `bannerdata` where id='".$postdata['id']."'";
            $retval = mysqli_query( $conn, $sql );
            
            if($retval){
                //索引表-1
                $sql = "UPDATE `waitforupload` SET number=number-1 WHERE url='".$key."'";
                $retval = mysqli_query( $conn, $sql );

                if($retval){
                    echo '{"code":1,"msg":"删除成功！"}';
                }else{
                    echo '{"code":-1,"msg":"删除失败！"}';
                }

            }else{
                echo '{"code":-1,"msg":"删除失败！"}';
            }


        break;
    }

    //删除多余的图片
    $sql = "SELECT * FROM `waitforupload`";
    $retval = mysqli_query( $conn, $sql );
    $deleteimgs = [];
    while($row=mysqli_fetch_array($retval,MYSQLI_ASSOC)){
        if($row['number'] <= 0){
            $sql = "DELETE FROM `waitforupload` WHERE id='".$row['id']."'";
            mysqli_query( $conn, $sql );
            array_push($deleteimgs,$row['url']);
        };
    }
    deleteimgs($deleteimgs);

    //释放
    mysqli_free_result($row);
    mysqli_free_result($retval);
    //关闭连接
    mysqli_close($conn);
?>