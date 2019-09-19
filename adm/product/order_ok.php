<?php
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";

echo "<link href=\"".$skin_dir."/style.css\" rel=\"stylesheet\" type=\"text/css\">";


///////////////////////////////////////////
/// PG사 결제 완료시 꼭 반환되어야할 값들//
///////////////////////////////////////////
/* $orderid : 주문번호
/* $resmsg : 오류 및 반환 메세지
/* $rescode : 성공반환 메세지
/* $pay_method : wizshop 결제종류
*//////////////////////////////////////////

//if($pay_method != "PB"){
	//Pay_result($oper_info->pay_agent);
	$presult=Pay_result($oper_info[pay_agent],$rescode);

  //////// 쓰레기 장바구니 데이터 삭제 ////////////
  @mysql_query("DELETE FROM wiz_basket_tmp WHERE wdate < (now()- INTERVAL 10 DAY)");
//}
?>

<script language="JavaScript">
<!--
function orderPrint(orderid){
   var url = "/adm/product/order_print.php?orderid=" + orderid + "&print=ok";
   window.open(url, "orderPrint", "height=650, width=736, menubar=no, scrollbars=yes, resizable=yes, toolbar=no, status=no, left=0, top=0");
}
//-->
</script>
<table border=0 cellpadding=0 cellspacing=0 width=100% align=center>
  <tr>
    <td style="padding-top:20px;">

			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<div id=basket_title>
					<h1>구매하기</h1>
				</div>
				<div id="basket_process">
						<img src="/child/img/cart/basket-process-4.png">
				</div>
			</table>
			<?

			// 주문정보
			$sql = "SELECT * FROM wiz_order WHERE orderid = '$presult[orderid]'";
			$result = mysql_query($sql) or error(mysql_error());
			$order_info = mysql_fetch_array($result);

			//echo $orderid;

			// 주문성공
			if($presult[rescode] == "0000" && strlen($presult[rescode]) == 4){

				// 주문완료 메일/sms발송
				include "$_SERVER[DOCUMENT_ROOT]/adm/product/order_mail.inc";		// 메일발송내용

				$re_info[name] = $order_info[send_name];
				$re_info[email] = $order_info[send_email];
				$re_info[hphone] = $order_info[send_hphone];

				// email, sms 발송 체크
				$sql = "update wiz_order set send_mailsms = 'Y' where orderid = '$order_info[orderid]'";
				mysql_query($sql) or error(mysql_error());

				if($order_info[send_mailsms] != "Y") send_mailsms("order_com", $re_info, $ordmail);
			?>


			<? include "$_SERVER[DOCUMENT_ROOT]/adm/product/order_info.inc"; ?>

			<div class="form-btn-wrap">
				<div class="form-btn">
					<a class="btn btn_point" href="/<?=$prd_info[order_list_url]?>">주문 조회 가기</a>
				</div>
				<div class="form-btn">
					<a class="btn btn_border" href="javascript:orderPrint('<?=$presult[orderid]?>');">프린트 하기</a>
				</div>
			</div>

			<?

			// 주문실패
			}else{
			?>
			<table border=0 cellpadding=0 cellspacing=0 width=96%>
				<tr><td height=3 bgcolor=#999999></td></tr>
				<tr>
					<td bgcolor=#F9F9F9 style="padding:10">

						<table border=1 cellpadding=0 cellspacing=2 bgcolor=#ffffff bordercolor=#E1E1E1 width=100%>
						  <tr>
						    <td style="padding:5">
							   <table width=100% border=0 cellpadding=0 cellspacing=0>
								  <tr height=25><td align="center"><font color=red><b>결제시 에러가 발생하였습니다.</b></font></td></tr>
								  <tr height=25><td align="center">결과메세지 : <?=$presult[resmsg]?></td></tr>
								  <tr><td height=20></td></tr>
								  <tr><td height=1 background="/images/dot.gif"></td></tr>
								  <tr><td align="center" height=80><a href="<?=$_SERVER['PHP_SELF']?>?ptype=pay&orderid=<?=$presult[orderid]?>&pay_method=<?=$order_info[pay_method]?>"><img src="/adm/product/image/but_re.gif" border="0"></a></td></tr>
								</table>
						    </td>
						  </tr>
						</table>

				  </td>
				</tr>
		  </table>
			<?
			}
			?>
		</td>
  </tr>
</table>
