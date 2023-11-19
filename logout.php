<?php session_start();
include_once("php/cn.php");$err="";
if(isset($_SESSION[SESSION_IDX])){
	SQL_UPDATE(SESSIONS,array("end_date"=>date("Y-m-d H:i:s")),"id",$_SESSION[SESSION_IDX]);
	SQL_UPDATE(COMPTE,array('session_id'=>""),"id",$_SESSION[KSJZXID]);
$_SESSION=array();session_destroy();
}
@header("location:login.php");exit();
?>