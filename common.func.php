<?php
/*
 * 提示信息并且跳转
 */
header("content-type:text/html;charset=utf-8");

function alertMes($mes,$url){
    echo  "<script type='text/javascript'>alert('{$mes}');location.href='{$url}';</script>";
}


?>