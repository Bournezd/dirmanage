<?php
	header("Content-type:text/html; charset=utf-8" );
	$con=mysqli_connect("localhost","root","123456");
	mysqli_select_db($con,"info");
	mysqli_query($con,"set names utf8");
	$sql="update test set name='西红柿' where name='test1'";

	$query=mysqli_query($con,$sql);
	echo mysqli_affected_rows($con);
	//print_r(mysqli_fetch_object($query));
	//mysqli_fetch_object输出的是一个对象,只需要一个参数
	/*while($mes=mysqli_fetch_object($query)){
		echo $mes->id."<br/>";
		echo $mes->name."<br/>";
	}
	echo mysqli_num_rows($query);*/
	//echo mysql_result($query, 1, 2);

?>