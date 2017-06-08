<?php
header("Content-type:text/html;charset=utf-8");
//连接数据库
$con=mysqli_connect("localhost","root","123456");
if($con){
	echo "success1";
}else{
	echo "failed1";
}
//选择数据库
if(mysqli_select_db($con,"info")){
	echo "success2";
}else{
	echo "failed2";
}
/*
//数据库执行语句
mysqli_query($con,'set names utf8');
if(mysqli_query($con,"insert into test values(3,'我叫什么')")){
	echo "success3";
}else{
	echo mysql_error();
	echo "failed3";
}
*/
mysqli_query($con,'set names utf8');
$mes=mysqli_query($con,"select * from test");
/*
或者写成
print_r(mysqli_fetch_row($mes));
输出的值都是success1success2Array ( [0] => 1 [1] => test1 )  这是二维数组的表达方式
但是数据库的值是
1test1
2test2
3香蕉
4葡萄
5苹果
所以他只返回数据库的第一条值
*/
$message=mysqli_fetch_row($mes);
while($message){

	print_r($message);
}

mysqli_close($con);
?>