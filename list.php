


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
//定义每页的显示记录条数
$typeV="dzvideo";

$page_size = 5;
//获取当前页
$cur_page =isset($_GET['page'])?$_GET['page']:1;


//获取总页数
//获取总记录数
$sql="select count(*) as total from $typeV";
$result =$mysqli->query($sql);
$row = $result->fetch_assoc();
$total = $row['total'];
//计算总页数
$total_page = ceil($total/$page_size);

//上一页
$pre_page = $cur_page-1;
if($pre_page>=1){
	$pre_page_str = "<a href='list.php?page=".$pre_page."'>上一页</a>";
}else{
	$pre_page_str="";
}

//下一页
$next_page = $cur_page+1;
if($next_page<=$total_page){
$next_page_str = "<a href='list.php?page=".$next_page."'>下一页</a>";
}else{
	$next_page_str="";
}

//list 的后半部分
$num = 3;
$list_num_list="";
for($i=1;$i<=$num;$i++){
	$last_num = $cur_page+$i;//4+1 4+2 4+3
	if($last_num<=$total_page){
		$list_num_list.="&nbsp;"."<a href='list.php?page=".$last_num."'>".$last_num."</a>";//5 6 7
	}
}
//list前半部分
$first_num_list="";
for($i=$num;$i>=1;$i--){
	$first_num = $cur_page-$i;
	if($first_num>=1){
		$first_num_list.="&nbsp;"."<a href='list.php?page=".$first_num."'>".$first_num."</a>";
	}
}



//计算limit起始位置
$start = ($cur_page-1)*$page_size;

$title=isset($_POST['title'])?$_POST['title']:"";
if($title){
	$sql="select * from $typeV where title like '%".$title."%'";
}else{
	$sql="select * from $typeV";
}
//4、分页输出
//5、获取开始位置
//6、获取本页的数据
//7、把数据传给模板

echo "<form action='' method='post' >";
echo "用户查询:<input type='text' name='title' />";
echo "&nbsp;<input type='submit' value='查询' />";
echo "</form>";
echo "<table border='1' >";
echo "<tr>
<th>ID</th>
<th>title</th>
<th>content</th>
<th>url</th>
<th>imagename</th>
<th>操&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;作</th>
</tr>";
  //计算共有多少页，ceil取进1
  //$pageCount = ceil(($rowCount/$pageSize));
  
  // $total_page = ceil($total/$page_size);
  //使用sql语句时，注意有些变量应取出赋值。
  $pre = ($cur_page-1)*$page_size;
   
  $sql2 = "select * from $typeV limit $pre,$page_size";
  $res2 = $mysqli->query($sql2);
  
while( $row = $res2->fetch_assoc() ){
	echo "<tr>
		  <td>".$row['id']."</td>
		  <td>".$row['title']."</td>

		  <td>".mb_substr($row['content'], 0, 100) ."</td>	
 		  <td>".$row['url']."</td>
		  <td>".$row['imagename']."</td>
		  <td><a href='/update.php?id=".$row['id']."'>修改</a> 
		  	  <a href='/delete.php?id=".$row['id']."'>删除</a></td>		
		  </tr>";
}
echo "</table>";
echo "<center><a href='add.php'>增加</a></center>";
echo "<br/>";
echo "共".$total_page."页 ".$pre_page_str.$first_num_list."&nbsp;".$cur_page.$list_num_list."&nbsp;".$next_page_str;
echo "<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";

 /* free result set */
 $result->free();

 /* close connection */
 $mysqli->close();
?>