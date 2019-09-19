<?php
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";

$prev = $PHP_SELF;

// 로그인페이지
$order = "true"; 
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/member/login.php";

?>
