<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
if($prdcode != "") $ptype = "view";
if($ptype == "" || $ptype == "list"){
  if($listtype == "main"){
    include "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_list_main.php";
  } else {
    include "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_list.php";
  }
}
else{
    include "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_view.php";
}
// update_page("PRD");
?>
