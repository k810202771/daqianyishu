<?php
$pageindex = isset($_GET['pageindex'])?$_GET['pageindex']:0;
$pagemax = isset($_GET['pagemax'])?$_GET['pagemax']:10;

require_once './conn.php'; //加载数据库
header('Access-Control-Allow-Origin:*');
    $text = '';
    if(isset($_GET['title'])){
        $text .= " AND (title LIKE '%".$_GET['title']."%' OR subtitle LIKE '%".$_GET['title']."%')";
    }
    if(isset($_GET['type'])){
        $text .= " AND zltype = '".$_GET['type']."'";
    }
    if(isset($_GET['online'])){
        $text .= " AND online = '".$_GET['online']."'";
    }
    if(isset($_GET['id'])){
        $text .= "AND id = '".$_GET['id']."'";
    }
    if(isset($_GET['subtype'])){
        $text .= " AND titletype LIKE '%".$_GET['subtype']."%'";
    }
    if(isset($_GET['list'])){
        $list = $_GET['list'];
    }else{
        $list = "id, zltype,titletype, title, subtitle, cover, timestart, timeend,recommend";
    }

    if(isset($_GET['time'])){
        switch($_GET['time']){
            case 'now':
                $text .= " AND (timestart <= '".time()."' AND timeend >='".time()."' OR timestart='0' AND timeend='0')";
            break;
            case 'soon':
                $text .= " AND timestart > '".time()."'";
            break;
            case 'past':
                $text .= " AND timeend <'".time()."' AND timestart!='0' AND timeend!='0'";
            break;
            default:
                $text .= " AND 1=2";
            break;
        }
        
    }

    $sql = "SELECT COUNT(*) FROM `articledata` WHERE 1=1 " .$text;
    $retval = mysqli_query( $conn, $sql );
    $row = $retval -> fetch_row();

    $sql = "SELECT ".$list." FROM `articledata` WHERE 1=1 ".$text." order BY recommend desc,id desc LIMIT " . ((int)$pageindex * $pagemax). "," . $pagemax;
    $retval = mysqli_query( $conn, $sql );
    $json = array( "count" => ceil((int)$row[0] / $pagemax ), "list" => []);
    
    while($row = mysqli_fetch_array($retval,MYSQLI_ASSOC)){
        if(isset($row['imgs'])){
            $row['imgs'] = json_decode($row['imgs'],true);
        }
        if(isset($row['cost'])){
            $row['cost'] = json_decode($row['cost'],true);
        }
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