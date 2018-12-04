<?php 
require_once './conn.php'; //加载数据库
require_once './delete.php'; //加载数据库
header('Access-Control-Allow-Origin:*');
    
    //获取传过来的值
    $postdata = json_decode(file_get_contents('php://input'),true);
    
    //是否传了id值过来
    if(isset($_GET['id'])){

        //更新内容
        $type = "zltype = '".$postdata['atype']."'";
        $titletype = "titletype = '".$postdata['titletype']."'";
        $title = "title = '".$postdata['title']."'";
        $subtitle = "subtitle = '".$postdata['subtitle']."'";
        $cover = "cover = '".$postdata['cover']."'";
        $timestart = "timestart = '".$postdata['time'][0]."'";
        $timeend = "timeend = '".$postdata['time'][1]."'";
        $timeDescription = "timeDescription = '".$postdata['timeRemarks']."'";
        $place = "place = '".$postdata['address']."'";
        $cost = "cost = '".json_encode($postdata['price'],JSON_UNESCAPED_UNICODE)."'";
        $costDescription = "costDescription = '".$postdata['priceRemarks']."'";
        $qrcode = "qrcode = '".$postdata['QRcode']."'";
        $content = "content = '".$postdata['content']."'";
        $imgs = "imgs = '".json_encode($postdata['imgs'])."'";

        $sql = "UPDATE `articledata` SET ".$type.",".$titletype.",".$title.",".$subtitle.",".$cover.",".$timestart.",".$timeend.",".$timeDescription.",".$place.",".$cost.",".$costDescription.",".$qrcode.",".$content.",".$imgs." WHERE id='" .$_GET['id']."'";
        $retval = mysqli_query( $conn, $sql );

        if($retval){

            //遍历文章内所有图片索引+1
            for($i = 0;$i<count($postdata['imgs']);$i++){
                $sql = "UPDATE `waitforupload` SET number=number+1 WHERE url='".$postdata['imgs'][$i]."'";
                $retval = mysqli_query( $conn, $sql );
            }
            //查询原文章所有图片索引-1
            $sql = "SELECT imgs FROM `articledata` WHERE id='" .$_GET['id']."'";
            $retval = mysqli_query( $conn, $sql );
            while($row=mysqli_fetch_array($retval,MYSQLI_ASSOC)){
                $images = json_decode($row['imgs'],true);
                for($i = 0;$i<count($images);$i++){
                    $sql = "UPDATE `waitforupload` SET number=number-1 WHERE url='".$images[$i]."'";
                    $retval = mysqli_query( $conn, $sql );
                }
            }

            echo '{"code":1,"msg":"更新成功！"}';
        }else{
            echo '{"code":-1,"msg":"更新失败！"}';
        }
    }else{


        
        $sql = "insert into `articledata`(zltype,online,titletype,title,subtitle,cover,timestart,timeend,timeDescription,place,cost,costDescription,qrcode,content,imgs,recommend) ".
        "values('".$postdata['atype']."','".$postdata['type']."','".$postdata['titletype']."','".$postdata['title']."','".$postdata['subtitle']."','".$postdata['cover']."','".$postdata['time'][0]."','".$postdata['time'][1]."','".$postdata['timeRemarks']."','".$postdata['address']."','".json_encode($postdata['price'],JSON_UNESCAPED_UNICODE)."','".$postdata['priceRemarks']."','".$postdata['QRcode']."','".$postdata['content']."','".json_encode($postdata['imgs'])."','0');";
        $retval = mysqli_query( $conn, $sql );

        if($retval){

            //遍历文章内所有图片，删除不需要的图片
            for($i = 0;$i<count($postdata['imgs']);$i++){
                $sql = "UPDATE `waitforupload` SET number=number+1 WHERE url='".$postdata['imgs'][$i]."'";
                $retval = mysqli_query( $conn, $sql );
            }

            echo '{"code":1,"msg":"发布成功！"}';
        }else{
            echo '{"code":-1,"msg":"发布失败！"}';
        }

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