<?php
//转换字节大小
header("Content-type: text/html; charset=utf-8");
function transByte($size)
{
    // 字节转换为M，G等等
    $arr = array(
        "B",
        "KB",
        "MB",
        "GB",
        "TB",
        "EB"
    );
    $i = 0;
    while ($size >= 1024) {
        $size /= 1024;
        $i ++;
    }
    return round($size, 2) . $arr[$i];
}

//创建文件
function createFile($filename){
    header("Content-type: text/html; charset=utf-8");
    //验证文件名的合法性
    $pattern="/[\/,\*,<>,\?\|]/";
    //preg_match匹配正则表达式   basename取出带后缀名的文件名称
   if(!preg_match($pattern,basename($filename))&&pathinfo($filename,PATHINFO_FILENAME)!=''&&pathinfo($filename,PATHINFO_DIRNAME)!='.'){
        //echo "test";
        if(!file_exists($filename)){
            if(touch($filename)){ 
                //touch（$filename）来创建文件
                return "建立成功";
            }else{
                return "文件创建失败";
            } 
        }else {
            return "文件名已存在，请重新建立";
        }
    }else{
        return "文件名不合法，请重新输入";
    }
}

//重新命名文件
function renameFile($oldname,$newname){
   // echo "$oldname";
   // echo "$newname";
   if (checkFilename($newname)) {
        $path=dirname($oldname);
        if (!file_exists($path."/".$newname)) {
            if(rename($oldname,$path."/".$newname)){
                return "重命名成功";
            }
        }else{
                return "存在同名文件，请重新输入";
            }
    }else{
     return "非法文件名";
        }
}


//判定文件名是否合法
function checkFilename($filename){
    $pattern="/[\/,\*,<>,\?\|]/";
    //这个正则表达式存在很大的问题，在重命名的时候由于取值是取.作为分割，所以如果重命名本身格式不带后缀名也是没有关系的，可以直接修改成功
    if(preg_match($pattern,$filename)){
        return false;
    }else{
        return true;    
    }
}

//删除文件
function delFile($filename){
    if(unlink($filename)){
        $mes="删除成功";
    }else{
        $mes="删除失败";
    }
    return $mes;
}

//下载文件
function downFile($filename){
    //$filename这个是我们下载时的文件名
    header("Content-disposition:attachment;filename=".basename($filename));
    //拿到文件的大小
    header("content-length:".filesize($filename));
    //阅读文件的内容
    readfile($filename);
}





?>