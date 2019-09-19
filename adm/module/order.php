<?

include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";



if($ptype == "") {

	if(empty($wiz_session[id])) include "$_SERVER[DOCUMENT_ROOT]/adm/product/order_check.php";

	else include "$_SERVER[DOCUMENT_ROOT]/adm/product/order_form.php";

}

else if($ptype == "form") include "$_SERVER[DOCUMENT_ROOT]/adm/product/order_form.php";

else if(!strcmp($ptype, "pay")) include "$_SERVER[DOCUMENT_ROOT]/adm/product/order_pay.php";

else if(!strcmp($ptype, "ok")) include "$_SERVER[DOCUMENT_ROOT]/adm/product/order_ok.php";


update_page("ORDER");

?>
