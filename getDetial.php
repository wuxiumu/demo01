<?php
header("Content-Type:text/html;charset=utf-8");
$mysqli = new mysqli("127.0.0.1",
		"root",
		"123456", "movie");
//获取video详细页的url地址
if($mysqli){
        echo "mysqli success"."<br>";
    }else{
        echo "mysqli error"."<br>";
        exit;
    }
//dzvideo => over


$type="jqurl";
$typeV="jqvideo";
//接受start值

$start=isset($_GET['start']) ? (int)$_GET['start'] : 0;
//去数据库表beimaiurl中取一条记录
$sql="select * from $type limit $start,1";
$pdoS=$mysqli->query($sql);
$arr=mysqli_fetch_assoc($pdoS);
if(!empty($arr)){
	$dz="http://www.666hdhd.com";
	$url=$dz.$arr['url'];
	//根据url地址获取url对应的页面内容
	$content=file_get_contents($url);
	
	preg_match_all("/<strong>(.*?)<\/strong>/",$content,$arr1);
	$biaoti=$arr1[1][0];
	echo $biaoti;
	echo "<br>";


	preg_match_all("/<div class=\"text\">(.*?)<\/div>/","$content",$arr2);
	$jieshao=$arr2[1][0];
	echo $jieshao;
	echo "<br>";

	preg_match_all("/<li>(.*?)<\/li>/","$content",$arr3);
	$dizhi=$arr3[1][14];
	echo $dizhi;
	echo "<br>";

    
	preg_match_all("/<div class=\"movie_pic\"><img src=\"(.*?)\" (.*)><\/div>/","$content",$arr4);
	$urlPic=$arr4[1][0];
	echo $urlPic;
	echo "<br>";

	$pathArr=pathinfo($urlPic);
	$fileName=$pathArr['basename'];
	echo $fileName;
	echo "<br>";
	$name=iconv("UTF-8","gb2312",$fileName);
	echo $name;
	$imageContent=file_get_contents($urlPic);
	file_put_contents("images/".$name,$imageContent);
	
	$sql="insert into $typeV (title,content,url,imagename) values('{$biaoti}','{$jieshao}','{$dizhi}','{$fileName}')";

	$re=$mysqli->query($sql);
	$nextStart=$start+1;
	if($re){
	?>

    开始采集<?php echo $nextStart?>
	<script type="text/javascript">
	location.replace("http://localhost/getDetail.php?start=<?php echo $nextStart?>");
	</script>
	<?php
	}else{
		echo "写表失败";
	}
}else{
	echo "采集完成";	

}

?>
