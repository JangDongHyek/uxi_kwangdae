<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";

// 주문정보
$sql = "select * from wiz_order where orderid = '$orderid'";
$result = mysql_query($sql) or error(mysql_error());
$order_info = mysql_fetch_array($result);

if(!empty($HTTP_REFERER)) {
	$pos = strpos($HTTP_REFERER, "http://".$HTTP_HOST);
	if($pos === false) {
?>
<script Language="Javascript">
<!--
		alert("잘못된 경로 입니다.");
		self.close();
//-->
</script>
<?php
		exit;
	}
}
?>
<html>
<head>
<title>:: 주문내역 ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/adm/product/style.css" rel="stylesheet" type="text/css">
<link href="/child/css/shop.css" rel="stylesheet" type="text/css">
<style>
.logo { z-index: 1;
    position: absolute; top: 0; left: 0; right: 0; bottom: 0;
    margin: auto;
    opacity: .1;
}

.m_cell { display: none; }
.product_order_box .order_box_wrap { padding: 0; }
.head_title { padding-left: 0; background: none; }
.head_title h3 { margin-top: 0; }
.order-basket .basket-col { padding: 5px; }
.basket-val { margin: 5px 0; }
.basket-bottom-row { padding: 2px 10px; }
.basket-total { padding: 10px 0 0; }
#pay_method_style tr th { padding-left: 5px; width: 124px; }
.product_order_box { padding: 10px 0; }
.product_order_box .head_title { margin-top: 0; }
.product_order_box .order_box_wrap { border-collapse: collapse; margin-top: 0 !important; }
#pay_method_style tr,
.AWorder_form_table tr { border-bottom: 1px solid #e5e5e5; }
#pay_method_style tr th,
.AWorder_form_table th { border-right: 1px solid #e5e5e5; }
.AWorder_form_table th, .AWorder_form_table td { padding: 5px; height: auto; font-size: 12px; }
.product_order_box .order_box_wrap tr:first-child th, .product_order_box .order_box_wrap tr:first-child td { border-top: 0; }
</style>
</head>
<body onLoad="window.print();">
<table width="100%" cellpadding=20 cellspacing=0>
  <tr>
    <td style="padding:5px;">
			<img class="logo" src="/adm/data/config/logo.png" alt="">
			<? include "./order_info.inc"; ?>

    </td>
  </tr>
</table>
</body>
</html>
