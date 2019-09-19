<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
if($ptype == "" || $ptype == "agree") include "$_SERVER[DOCUMENT_ROOT]/adm/member/join_agree.php";
else if($ptype == "input") include "$_SERVER[DOCUMENT_ROOT]/adm/member/join_input.php";
else if($ptype == "save") include "$_SERVER[DOCUMENT_ROOT]/adm/member/join_save.php";
else if($ptype == "ok") include "$_SERVER[DOCUMENT_ROOT]/adm/member/join_ok.php";
update_page("MEM_JOIN");
?>
