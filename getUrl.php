<?php
error_reporting(0);
header("Content-Type:text/html;charset=utf-8");
$mysqli = new mysqli("127.0.0.1",
		"root",
		"123456", "movie");
//判断数据库连接是否错误
if($mysqli){
        echo "mysqli success"."<br>";
    }else{
        echo "mysqli error"."<br>";
        exit;
    }



//获取video详细页的url地址
$pn=$_GET[pn] ? $_GET[pn] : 1;

if($pn>3){
	echo "采集完成";
	exit;
}
//记录list_8-完成-3
//战争list_7-完成-1
//恐怖list_6-完成-20
//剧情list_5-完成-91
//科幻list_4-完成-5
//爱情list_3-完成-7
//喜剧list_2-完成-41
//动作list_1-完成-21
//$url="http://www.666hdhd.com/htm/list_8_____$pn.htm";
$content=file_get_contents($url);

//从内容中去想要的a链接的url  href="***" 正则表达式
$preg="/<a href=\"(.*?)\" target=\"_blank\">/";	
preg_match_all($preg,$content,$arr1);

for($i=5;$i<24;$i++){
	$v=$arr1[1][$i];
	echo $v;
	echo "<br>";
	$re=$mysqli->query("insert into jlurl (url) values ('$v')");
	var_dump($re);
}

$nextPn=$pn+1;
?>
<div>马上为您采集第<?php echo $nextPn;?>页</div>
<script type="text/javascript">
location.replace("http://localhost/getUrl.php?pn=<?php echo $nextPn?>");
</script>
