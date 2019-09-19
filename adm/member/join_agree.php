<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/mem_info.php";

echo "<link href=\"".$skin_dir."/style.css\" rel=\"stylesheet\" type=\"text/css\">";

if($site_info[namecheck_use] != "Y"){
	$namecheck_start = "<!--";
	$namecheck_end = "-->";
}

include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/join_agree.php";
?>
