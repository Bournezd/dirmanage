<?php
//设置编码模式为UTF-8
header("Content-type: text/html; charset=utf-8");
require_once 'dir.func.php';
require_once 'file.func.php';
require_once 'common.func.php';
$path = 'file';
$info = readDirectory($path);
/*
 * $path=@$_REQUEST['path']?$_REQUEST['path']:$path;
 * $dirname=@$_REQUEST['dirname'];
 */
$act = @$_REQUEST['act1'];
$filename = @$_REQUEST['filename1'];

//测试$act1是否拿到值
//echo $act;

$redirect="index.php?path={$path}";
//创建文件
if ($act == "createFile") {
   // echo $path;
   //echo $filename;
    $mes=createFile($path."/".$filename);
    alertMes($mes, $redirect);    
}elseif($act == "showContent"){
    //显示内容
    // echo "111";
    // echo $filename;
    //echo "$path."/".$filename";
    $connent= file_get_contents($filename);
    //highlight_string($connent);也可以全部输出
    if($connent==null){
         alertMes("当前文件为空文件", $redirect);
    }else {
        echo "<textarea readonly='readonly' cols='100' rows='10' >{$connent}</textarea>";
    }
}elseif($act == "editContent"){
    //echo "编辑文件";
    $connent=file_get_contents($filename);
    //highlight_string($connent);
    $str=<<<EOF
    <form action='index.php?act1=doEdit' method='post' >
        <textarea name="connent" cols='100' rows='10'>{$connent}</textarea><br/>
        <input type="hidden" name="filename1" value="{$filename}" />
        <input type="submit"  value="修改文件">
    </form>
EOF;
    echo  $str;
}elseif($act == "doEdit"){
	//文件修改功能
    $connent=$_REQUEST['connent'];
    //echo "$connent";
    //echo "$filename";
    if(file_put_contents($filename, $connent)){
        $mes="修改成功";
    }else{
    	$mes="修改失败";
    }
    alertMes($mes,$redirect);
}elseif ($act == "renameFile") {
	//完成重命名
	$str=<<<EOF
	<form action="index.php?act1=doRename" method='post'>
		请填写新文件名<input type="text" name="newname" placeholder="重命名" />
		<input type="hidden"  name="filename" value='{$filename}' />
		<input type="submit" value="重命名" />
	</form>	
EOF;
echo $str;
}elseif ($act == "doRename") {
	$filename=$_REQUEST['filename'];
	# 重命名操作
	$newname=$_REQUEST['newname'];
	//renameFile($filename,$newname);
	$mes=renameFile($filename,$newname);
	alertMes($mes,$redirect);
}elseif($act =="delFile"){
	//echo "文件删除了";
	$filename=$_REQUEST['filename1'];
	$mes=delFile($filename);
	alertMes($mes,$redirect);
}elseif($act =="downFile"){
	$mes=downFile($filename);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Insert title here</title>
<link rel="stylesheet" href="images/cikonss.css" />
<script src="jquery-ui/js/jquery-1.10.2.js"></script>
<script src="jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
<link rel="stylesheet"
	href="jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css"
	type="text/css" />
<style type="text/css">
body, p, div, ul, ol, table, dl, dd, dt {
	margin: 0;
	padding: 0;
}

a {
	text-decoration: none;
}

ul, li {
	list-style: none;
	float: left;
}

#class1 td {
	width: 2%;
	height: 10%;
}

#class1 td img {
	width: 20px;
	height: 25px;
}

#main {
	margin: 0 auto;
	border: 2px solid #ABCDEF;
}

.small {
	width: 25px;
	height: 25px;
	border: 0;
}
</style>
<script type="text/javascript">
	function show(dis){
	document.getElementById(dis).style.display="block";
	}
	/*function delFile(filename,path){
		if(window.confirm("您确定要删除嘛?删除之后无法恢复哟!!!")){
				location.href="index.php?act=delFile&filename="+filename+"&path="+path;
		}
	}*/

	function delFolder(dirname,path){
		if(window.confirm("您确定要删除嘛?删除之后无法恢复哟!!!")){
			location.href="index.php?act=delFolder&dirname="+dirname+"&path="+path;
		}
	}
	function showDetail(t,filename){
		$("#showImg").attr("src",filename);
		$("#showDetail").dialog({
			  height:"auto",
		      width: "auto",
		      position: {my: "center", at: "center",  collision:"fit"},
		      modal:false,//是否模式对话框
		      draggable:true,//是否允许拖拽
		      resizable:true,//是否允许拖动
		      title:t,//对话框标题
		      show:"slide",
		      hide:"explode"
		});
		}
	function goBack($back){
		location.href="index.php?path="+$back;
	}
</script>
</head>


<body>

	<div id="showDetail" style="display: none">
		<img src="" id="showImg" alt="" />
	</div>
	<h1>在线文件管理器</h1>
	<form action="index.php" method="post" enctype="multipart/form-data">
	<div id="top">
		<ul id="navi">
			<li><a href=" " title="主目录"><span
					style="margin-left: 8px; margin-top: 0px; top: 4px;"
					class="icon icon-small icon-square"><span class="icon-home"></span></span></a></li>

			<li><a href="#" onclick="show('createFile')" title="新建文件"><span
					style="margin-left: 8px; margin-top: 0px; top: 4px;"
					class="icon icon-small icon-square"><span class="icon-file"></span></span></a></li>
			<li><a href="#" onclick="show('createFolder')" title="新建文件夹"><span
					style="margin-left: 8px; margin-top: 0px; top: 4px;"
					class="icon icon-small icon-square"><span class="icon-folder"></span></span></a></li>		
			<li><a href="#" onclick="show('uploadFile')" title="上传文件"><span
					style="margin-left: 8px; margin-top: 0px; top: 4px;"
					class="icon icon-small icon-square"><span class="icon-upload"></span></span></a></li>
	       	<li><a href="#" title="返回上级目录" onclick="goBack('<?php //echo $back;?>')"><span
					style="margin-left: 8px; margin-top: 0px; top: 4px;"
					class="icon icon-small icon-square"><span class="icon-arrowLeft"></span></span></a></li>
		</ul>
	</div>


		<table width=100% border='1' cellspacing='0' bgcolor="#ABCDEF"
			align="center" id="class1">


			<tr id="createFolder" style="display: none;">
				<td>请输入文件夹名称</td>
				<td>
				<input type="text" name="dirname" /> 
				<input type="submit" name="act" value="创建文件夹" /></td>
			</tr>
			
			
			<tr id="createFile" style="display: none;" >
				<td>请输入文件名称</td>
				<td>
				<input type="text" name="filename1" /> 
		<!--  	<input type="hidden" name="path" value="<?php echo $path;?>" />       -->	
			 	<input type="hidden" name="act1" value="createFile" /> 
				<input type="submit" name="act" value="创建文件" /></td>
			</tr>
			
	
			<tr id="uploadFile" style="display: none;" >
				<td>请选择要上传的文件</td>
				<td>
				<input type="file" name="myFile" /> 
				<input type="submit"
					name="act" value="上传文件" /></td>
			</tr>

			<tr>
				<td>编号</td>
				<td>名称</td>
				<td>类型</td>
				<td>大小</td>
				<td>可读</td>
				<td>可写</td>
				<td>可执行</td>
				<td>创建时间</td>
				<td>修改时间</td>
				<td>访问时间</td>
				<td>操作</td>
			</tr>
<?php
if ($info['file']) {
    $i = 1;
    foreach ($info['file'] as $val) {
    $p = $path . "/" . $val;
        ?>

<tr>
				<!--表里面数据的读取 -->
				<td><?php echo $i?></td>
				<td><?php echo $val?></td>
				<td><?php $src=filetype($p)=="file"?"file_ico.png":"folder_ico.png"?><img
					src="images/<?php echo $src?>" alt="" title="文件" /></td>
				<td><?php  echo transByte(filesize($p));?></td>
				<td><?php  $src=is_readable($p)?"correct.png":"error.png";?><img
					src="images/<?php echo $src?>" alt=""></img></td>
				<td><?php  $src=is_writeable($p)?"correct.png":"error.png";?><img
					src="images/<?php echo $src?>" alt=""></img></td>
				<td><?php  $src=is_executable($p)?"correct.png":"error.png";?><img
					src="images/<?php echo $src?>" alt=""></img></td>
				<td><?php echo date('Y-m-d',filectime($p))?></td>
				<td><?php echo date('Y-m-d',filemtime($p))?></td>
				<td><?php echo date('Y-m-d',fileatime($p))?></td>
				<td>
					<?php 
					//$ext=strtlower(end(explode(".",$val)));
					//直接上面那样写会报错，由于PHP5.5版本过高，end函数里面直接用explode会报错
						$ar=explode(".",$val);
					    $arr=end($ar);
						$ext=strtolower($arr);
						$imageExt=array("png","jpg","gif","jpeg");
						if(in_array($ext, $imageExt)){
							//echo "111";
						    ?>
							 <a href="#" onclick="showDetail('<?php echo $val?>','<?php echo $p?>')"><img
    						 class="small" src="images/show.png" alt="" title="查看" /></a>|
						<?php 
						}else{
						?>
    				<a href="index.php?act1=showContent&path=<?php echo $p;?>&filename1=<?php echo $p;?>">
    				<img
    						class="small" src="images/show.png" alt="" title="查看" />
    				</a>| 
    				<?php }?>	
    				<a href="index.php?act1=editContent&path=<?php echo $p;?>&filename1=<?php echo $p;?>"><img
    						class="small" src="images/edit.png" alt="" title="修改" /></a>| 			
    				<a href="index.php?act1=renameFile&path=<?php echo $p;?>&filename1=<?php echo $p;?>"><img
    						class="small" src="images/rename.png" alt="" title="重命名" /></a>| 
    				<a href="index.php?act=copyFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img
    						class="small" src="images/copy.png" alt="" title="复制" /></a>| 
    				<a href="index.php?act=cutFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img
    						class="small" src="images/cut.png" alt="" title="剪切" /></a>| 
    				<a href="index.php?act1=delFile&path=<?php echo $p;?>&filename1=<?php echo $p;?>"  ><!-- onclick="delFile('<?php echo $p;?>','<?php echo $path;?>)" --> <img 
    						class="small" src="images/delete.png" alt="" title="删除" /></a>| 
    				<a href="index.php?act1=downFile&path=<?php echo $p;?>&filename1=<?php echo $p;?>"><img
    						class="small" src="images/download.png" alt="" title="下载" /></a>
				</td>
			</tr>
		<?php 
		$i++;
    }
}
?>







<?php
if ($info['dir']) {
    $i = 1;
    foreach ($info['dir'] as $val) {
    $p = $path . "/" . $val;
        ?>

<tr>
				<!--表里面数据的读取 -->
				<td><?php echo $i?></td>
				<td><?php echo $val?></td>
				<td><?php $src=filetype($p)=="file"?"file_ico.png":"folder_ico.png"?><img
					src="images/<?php echo $src?>" alt="" title="文件" /></td>
				<td><?php $sum=0; echo transByte(dirSize($path));?></td>
				<td><?php  $src=is_readable($p)?"correct.png":"error.png";?><img
					src="images/<?php echo $src?>" alt=""></img></td>
				<td><?php  $src=is_writeable($p)?"correct.png":"error.png";?><img
					src="images/<?php echo $src?>" alt=""></img></td>
				<td><?php  $src=is_executable($p)?"correct.png":"error.png";?><img
					src="images/<?php echo $src?>" alt=""></img></td>
				<td><?php echo date('Y-m-d',filectime($p))?></td>
				<td><?php echo date('Y-m-d',filemtime($p))?></td>
				<td><?php echo date('Y-m-d',fileatime($p))?></td>
				<td>
					
					<a href="#" onclick="showDetail('<?php echo $val?>','<?php echo $p?>')"><img
    						 class="small" src="images/show.png" alt="" title="查看" /></a>|
    				<a href="index.php?act1=showContent&path=<?php echo $p;?>&filename1=<?php echo $p;?>">
    				<img
    						class="small" src="images/show.png" alt="" title="查看" />
    				</a>| 
    				<a href="index.php?act1=editContent&path=<?php echo $p;?>&filename1=<?php echo $p;?>"><img
    						class="small" src="images/edit.png" alt="" title="修改" /></a>| 			
    				<a href="index.php?act1=renameFile&path=<?php echo $p;?>&filename1=<?php echo $p;?>"><img
    						class="small" src="images/rename.png" alt="" title="重命名" /></a>| 
    				<a href="index.php?act=copyFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img
    						class="small" src="images/copy.png" alt="" title="复制" /></a>| 
    				<a href="index.php?act=cutFile&path=<?php echo $path;?>&filename=<?php echo $p;?>"><img
    						class="small" src="images/cut.png" alt="" title="剪切" /></a>| 
    						
    				<a href="index.php?act1=delFile&path=<?php echo $p;?>&filename1=<?php echo $p;?>" ><img 
    						class="small" src="images/delete.png" alt="" title="删除" /></a>| 
    						
    				<a href="index.php?act1=downFile&path=<?php echo $p;?>&filename1=<?php echo $p;?>"><img
    						class="small" src="images/download.png" alt="" title="下载" /></a>
				</td>
			</tr>

		<?php 
$i++;
    }
    
}
?>

	</table>
	</form>
</body>
</html>