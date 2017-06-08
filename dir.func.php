<?php
header("Content-type: text/html; charset=utf-8");
    /*
     * 遍历目录，只能看到最外层
     * String $path
     * return array
     */
    function readDirectory($path){
    //打开目录
    $handle=opendir($path);
    while(($item=readdir($handle))!==false){
        if($item!="." && $item!="..")
            if(is_file($path."/".$item)){
                $arr['file'][]=$item;
        }
            if(is_dir($path."/".$item)){
                $arr['dir'][]=$item;
            }
    }
    closedir($handle);
    return $arr;
    }  
    //$path='file';
    //测试有没有成功拿到目录
    //print_r(readDirectory($path));
    //$handle = opendir ( $path );
    

function dirSize($path){
    $sum=0;
    global $sum;
    $handle=opendir($path);
    while(($item=readdir($handle))!==false){
        if($item!="."&&$item!=".."){
            if(is_file($path."/".$item)){
                $sum+=filesize($path."/".$item);
            }
            if(is_dir($path."/".$item)){
                //自己调用自己的函数
                $func=__FUNCTION__;
                $func($path."/".$item);
            }
        }
        
    }
    closedir($handle);
    return $sum;
}

?>