<?php
    ini_set("display_errors", "On");
    error_reporting(E_ALL || E_STRICT);
    
$pageindex = isset($_GET['pageindex'])?$_GET['pageindex']:0;
$pagemax = 10;

require_once './conn.php'; //加载数据库
header('Access-Control-Allow-Origin:*');
    
    $text = '';
    $list = '*';

    $sql = "SELECT COUNT(*) FROM `bannerdata` WHERE 1=1 " .$text;
    $retval = mysqli_query( $conn, $sql );
    $row = $retval -> fetch_row();

    $sql = "SELECT ".$list." FROM `bannerdata` WHERE 1=1 ".$text." order BY time DESC"; // LIMIT " . ((int)$pageindex * $pagemax). "," . $pagemax;
    $retval = mysqli_query( $conn, $sql );
    $json = array( "count" => ceil((int)$row[0] / $pagemax ), "list" => []);
    
    while($row = mysqli_fetch_array($retval,MYSQLI_ASSOC)){
        array_push($json["list"],$row);
        //var_dump($row);
    }

    echo json_encode($json);

    //释放
    mysqli_free_result($row);
    mysqli_free_result($retval);
    //关闭连接
    mysqli_close($conn);
?>