<?php
	header("Content-type:text/html; charset=utf-8");
	mysqli_query("set names 'utf8'");
	//验证数据库连接
	if($con=mysqli_connect('localhost','root','123456')){
		echo "success";
	}else{
		echo "false".mysql_error();
	}
	//选择数据库，当选择成功的时候，返回TRUE，当选择失败的时候返回FALSE
	if(mysqli_select_db($con,'weibo')){
	    echo "成功";
	  
	}else {
	    echo "失败";
	} 
	//数据库关闭
    mysql_close($con);


?>