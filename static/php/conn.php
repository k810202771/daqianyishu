<?php
    error_reporting(0);
    //ini_set("display_errors", "On");
    //error_reporting(E_ALL || E_STRICT);
    //设置页面编码
    header("Content-type: text/html; charset=utf-8");
    //数据库名称
    $databasename = 'article';
	//连接数据库
    $conn = mysqli_connect("127.0.0.1","root","root");
    
    //$conn = mysqli_connect("127.0.0.1","a1018164505","2b526d70");
    //$databasename = 'a1018164505';
	// 设置编码，防止中文乱码
	mysqli_query($conn , "set names utf8");

	if(! $conn )
	{
		die('Could not connect: ' . mysqli_error());
	}

	$sql = 'CREATE DATABASE '.$databasename;
	$retval = mysqli_query($conn,$sql);

    //选择数据库
	mysqli_select_db($conn, $databasename );

	//创建文章新表
	$sql = "CREATE TABLE `articledata`( ".
			"id INT NOT NULL AUTO_INCREMENT, ".//id
            "zltype TINYINT NOT NULL, ".//类型 0展览 1公益 2公共项目 3新闻
            "online TINYINT NOT NULL, ".//0在线上 1草稿箱 2垃圾箱
			"titletype VARCHAR(255) NOT NULL, ". //标题类型
			"title VARCHAR(255) NOT NULL, ". //标题
			"subtitle TEXT, ". //副标题
			"cover TINYTEXT NOT NULL, ". // 封面地址 4:3
			"timestart CHAR(10), ". // 时间 开始 10位时间戳
            "timeend CHAR(10), ". //时间 结束 10位时间戳
            "timeDescription TINYTEXT, ". //时间补充 255字符
			"place TINYTEXT, ". //地点
            "cost TEXT, ". // 费用json数据格式
            "costDescription TINYTEXT, ". // 费用补充
            "qrcode TINYTEXT, ". // 消费二维码
            "content LONGTEXT NOT NULL, ". // 文章内容
            "imgs TEXT NOT NULL, ". // 图片标识
            "recommend INT NOT NULL, ".//0未被推荐 其他时间排序
            "PRIMARY KEY ( id ), ".
            "KEY `title` ( title ), ". //标题搜索
			"KEY `tiem` ( timestart,timeend ) ". //时间
			")ENGINE=InnoDB DEFAULT CHARSET=utf8;";
    $retval = mysqli_query( $conn, $sql );
    
	$sql = "CREATE TABLE `waitforupload`( ".
			"id INT NOT NULL AUTO_INCREMENT, ".//id
			"url TINYTEXT NOT NULL,". //图片地址
			"number MEDIUMINT NOT NULL,". //使用文章次数
			"PRIMARY KEY ( id )".
			")ENGINE=InnoDB DEFAULT CHARSET=utf8; ";
    $retval = mysqli_query( $conn, $sql );

    $sql = "CREATE TABLE `bannerdata`( ".
    "id INT NOT NULL AUTO_INCREMENT, ".//id
    "url TEXT NOT NULL,". //图片地址
    "href TEXT NOT NULL,". //链接地址
    "time CHAR(10) NOT NULL,". //设置时间
    "PRIMARY KEY ( id )".
    ")ENGINE=InnoDB DEFAULT CHARSET=utf8; ";
    $retval = mysqli_query( $conn, $sql );
    /**
    * 这里执行要执行的数据库内容
    */



    /**
     * 这里以下是关闭数据库
     */
?>