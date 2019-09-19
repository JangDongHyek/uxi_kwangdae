<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>프린트</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link href="../wiz_style.css" rel="stylesheet" type="text/css">
</head>

<body onLoad="this.focus();print();">
<?
if(empty($selorder)) {
	error("출력할 주문서가 선택되지 않았습니다.","");
}
else {

	$order_list = explode("|", $selorder);
	$search_sql = " and (";
	for($ii = 0; $ii < count($order_list); $ii++) {
		if(!empty($order_list[$ii])) {
			if($ii > 0) $search_sql .= " or ";
			$search_sql .= " orderid = '$order_list[$ii]' ";
		}
	}
	$search_sql .= ")";

	$sql = "select * from wiz_order where orderid != '' $search_sql";
	$result = mysql_query($sql) or error(mysql_error());

	$no = 0;

	while($order_info = mysql_fetch_array($result)) {

		$discount_msg = "";
		$reserve_msg = "";
		$coupon_msg = "";

		$order_info[demand] = str_replace("\n", "<br>", trim($order_info[demand]));
		$order_info[cancelmsg] = str_replace("\n", "<br>", trim($order_info[cancelmsg]));
		$order_info[descript] = str_replace("\n", "<br>", trim($order_info[descript]));

		if($no > 0) echo "<p class=break><br style=\"height:0; line-height:0\"></p>";
?>

<style>
.delivery-table th, .delivery-table td{
	text-align: left;
	border-bottom: 1px solid #000;
}
.delivery-table th{
	background-color: rgb(150,150,150);
}
.order-table tr *:first-child{
	border-left: 1px solid #000;
}
.order-table th, .order-table td{
	border-right: 1px solid #000;
	border-bottom: 1px solid #000;
	font-weight: normal;
	padding: 4px;
}
.order-table tr:first-child *{
	border-top: 2px solid #000;
	border-bottom: 2px solid #000;
}
</style>

<div id="Container">
	<div id="S_contents" style="margin:50px 0 20px;padding:0px;">

		<div style="position: relative; width: 100%; height: 1100px;">
			<img class="logo" src="/adm/data/config/logo.png" alt="" style="z-index:1;position:absolute;top:0;left:0;right:0;bottom:0;margin:auto;opacity:.1;transform:translateY(-100px);">
			<div style="font-size: 20px;"><span style="display: inline-block; min-width: 100px; text-align: center; border-bottom: 1px solid #000;"><?=$order_info[send_name]?></span>고객님 <span style="font-size: 24px;">광대를 이용해주셔서 감사합니다.</span></div>
			<div style="font-size: 14px; margin-top: 50px;">
				*택배반납의 경우 집하일(택배사에 맡기신날)을 기준으로 합니다.
			</div>
			<div style="font-size: 14px; margin-top: 4px;">
				*연체시 1일당 40% 연체료가 부과됩니다.
			</div>

			<ul style="margin-top: 48px;">
				<li>
					※ 의상취급 주의사항
					<div style="border: 1px solid #000;">
						ㄱ. 의상의 분실/파손/오염에 관해서는 상태와 정도에 따라서 원가/수선비/세탁비가 실비청구됩니다. 오염 또는 파손을 이유로 반납을 미루시면 연체료가 추가로 부과되오니, 의상에 파손이나 오염이 발생하신 경우 광대로 연락을 주셔서 처리 절차를 안내받으시기 바랍니다.<br />
						ㄴ. 택배반납시 포장문제로 인해 파손되는 경우가 발생할 수 있습니다. 파손되기 쉬운 상품은 꼭 주의해서 포장/발송해주세요.<br />
						ㄷ. 모든 의상은 출고전 담당자가 오염 및 파손 여부를 점검하고 보내드립니다. 수령 후 의상에 문제가 있으신 경우에는 즉시 연락을 주시면 조치해드리겠습니다.
					</div>
				</li>
				<li style="margin-top: 25px;">
					※ 환불규정 안내
					<div style="border: 1px solid #000;">
						ㄱ. 대여의상의 특성상 이미 대여하신 의상의 환불은 불가합니다.<br />
						ㄴ. 부득이한 경우 대여료의 최대 50%까지 환급이 가능하며, 이는 광대에서 제공되는 적립금의 형태로 지급되고 있습니다.
					</div>
				</li>
				<li style="margin-top: 25px;">
					※ 택배반납 안내
					<div style="border: 1px solid #000;">
						ㄱ. 왕복 운송비는 고객님의 부담입니다 (제주도의 경우 항공료 추가가능).<br />
						ㄴ. 반납 택배 예약은 고객님 본인이 직접 해주셔야 합니다.<br />
						ㄷ. 반납일이 주말 및 공휴일이라면, 편의점택배를 이용해 꼭 반납일에 접수해 주세요.
					</div>
				</li>
			</ul>
			<div style="width: 100%; text-align: center; margin-top: 64px;">
				<table class="delivery-table" width="80%" height="10" border="0" cellpadding="0" cellspacing="0" style="display: inline-table;">
				<tr>
					<th>택배사명</th>
					<th>전화번호</th>
					<th>홈페이지</th>
				</tr>
				<tr>
					<td>롯데글로벌로지스</td>
					<td>1588-2121</td>
					<td>www.lotteglogis.com</td>
				</tr>
				<tr>
					<td>CJ 대한통운 택배</td>
					<td>1588-1255</td>
					<td>www.cjlogistics.com</td>
				</tr>
				<tr>
					<td>KG 옐로우캡 택배</td>
					<td>1588-0123</td>
					<td>www.kgyellowcap.co.kr</td>
				</tr>
				<tr>
					<td>우체국 택배</td>
					<td>1588-1300</td>
					<td>www.parcel.epost.go.kr</td>
				</tr>
				<tr>
					<td>한진 택배</td>
					<td>1588-0011</td>
					<td>www.hanex.hanjin.co.kr</td>
				</tr>
				<tr>
					<td>경동택배</td>
					<td>1899-5368</td>
					<td>kdexp.com</td>
				</tr>
				<tr>
					<td>로젠택배</td>
					<td>1588-9988</td>
					<td>www.ilogen.com</td>
				</tr>
			</table>
			</div>

			<div style="margin-top: 64px; width: 100%; text-align: center; border-bottom: 1px dotted #000; padding-bottom: 8px;">
				반납정보 ( 택배나 퀵 접수시 잘라서 사용하세요)
			</div>

			<div style="width: 100%; padding: 16px 32px;">
				<div style="font-style: italic;">반납하실 주소</div>
				<div style="padding-left: 32px;">서울시 서초구 서초동 1445-13 쌍용플래티넘 지하 4층 광대매장, 김효선 팀장</div>
				<div style="font-style: italic; margin-top: 4px;">전화</div>
				<div style="padding-left: 32px;">02 - 597 - 0033</div>
			</div>
		</div>


		<div style="position:relative;">
			<img class="logo" src="/adm/data/config/logo.png" alt="" style="z-index:1;position:absolute;top:0;left:0;bottom:0;right:0;margin:auto;opacity:.1;">

			<div>
				<div style="position: relative; width: 100%; text-align: center;">
					<div style="position: absolute; left: 0; top: 0; bottom: 0;">
						주문일자 <?=$order_info[order_date]?>
					</div>
					<span style="font-weight: 600;">의상대여 전문점 광대</span>
					<div style="position: absolute; right: 0; top: 0; bottom: 0;">
						주문번호 <?=$order_info[orderid]?>
					</div>
				</div>

				<table class="order-table" width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="4" style="text-align: center; font-size: 18px; font-weight: 600;">
							주&nbsp;문&nbsp;내&nbsp;역&nbsp;서
						</td>
					</tr>
					<tr>
						<th width="15%">담 당 자</th>
						<td width="35%"></td>
						<th width="15%">이&nbsp;&nbsp;&nbsp;&nbsp;름</th>
						<td width="35%"><?=$order_info[rece_name]?></td>
					</tr>
					<tr>
						<th colspan="2"></th>
						<th width="15%">생 년 월 일</th>
						<td width="35%">
							<?
							$sql = "select * from wiz_member where name = '{$order_info['rece_name']}' ";
							$mem_result = mysql_query($sql);
							$mem_info = mysql_fetch_array($mem_result);

							echo $mem_info['birthday'];
							?>
						</td>
					</tr>
					<tr>
						<th>주소</th>
						<td colspan="3">
							[<?=$order_info[rece_post]?>] <?=$order_info[rece_address]?>
						</td>
					</tr>
					<tr>
						<th>결제방법</th>
						<td>
							<?=pay_method($order_info[pay_method])?>
							<? if(!strcmp($order_info[tax_type], "N") || empty($order_iinfo[tax_type])) echo "(발행안함)" ?>
							<? if(!strcmp($order_info[tax_type], "T")) echo "(세금계산서 발행)" ?>
							<? if(!strcmp($order_info[tax_type], "C")) echo "(현금영수증 발행)" ?>
						</td>
						<th>연락처</th>
						<td><?=$order_info[rece_hphone]?></td>
					</tr>
					<tr>
						<th style="border-top: 1px solid #000;">대여료</th>
						<td id="sum_price" style="border-top: 1px solid #000; text-align:right;"></td>
						<th style="border-top: 1px solid #000; border-bottom: 2px solid #000;" rowspan="4">결제금액</th>
						<td style="border-top: 1px solid #000; border-bottom: 2px solid #000; font-size: 18px; font-weight: 600; text-align: right;" rowspan="4">
							<?=number_format($order_info[total_price])?>원
						</td>
					</tr>
					<tr>
						<th>연장비용</th>
						<td id="sum_due_price" style="text-align: right;"></td>
					</tr>
					<tr>
						<th>부가세</th>
						<td id="sum_vat" style="text-align: right;"></td>
					</tr>
					<tr>
						<th style="border-bottom: 2px solid #000;">할인금액</th>
						<td style="border-bottom: 2px solid #000; text-align: right;">
							<?=number_format($order_info[discount_price])?>원
						</td>
					</tr>
				</table>

			</div>

				<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list" style="margin-top: 32px;">
				<thead>
				<tr>
					<th width="50">번호</th>
					<th>사진</th>
		      <th>상품명</th>
		      <th>수량</th>
		      <th>대여일</th>
		      <th>반납일</th>
					<th>대여료</th>
					<th>연장료</th>
					<th>부가세</th>
		      <th>총 대여료</th>
				</tr>
				</thead>
				<tbody>
				<?
				$orderid = $order_info[orderid];
				$b_sql = "select wb.*, wp.sellprice from wiz_basket as wb left join wiz_product wp on wb.prdcode = wp.prdcode where wb.orderid = '$orderid'";
				$b_result = mysql_query($b_sql) or error(mysql_error());
				$b_total = mysql_num_rows($b_result);
				$mo = $b_total;

				$sum_price = 0;
				$sum_due_price = 0;

				while($b_row = mysql_fetch_object($b_result)){
					$price = $b_row->prdprice;
					$due_price = $b_row->prdprice * 0.2 * $b_row->day;
					$total = $price + $due_price;
					$vat = $b_row->vat;

					$sum_price += $b_row->prdprice;
					$sum_vat += $b_row->vat;
					$sum_due_price = $sum_due_price + $due_price;
				?>
				<tr>
					<td><?=$mo--?></td>
					<td><img src="/adm/data/prdimg/<?=$b_row->prdimg?>" style="width: 48px; height: 48px;"></td>
		      <td>
						<div>
							<?=$b_row->prdname?>
						</div>
					</td>
					<td><?=$b_row->amount?></td>
					<td><?=$b_row->sdate?></td>
					<td><?=$b_row->edate?></td>
		      <td><?=number_format($price)?>원</td>
		      <td><?=$due_price?>일</td>
					<td><?=number_format(($vat))?>원</td>
		      <td>
						<?=number_format(($price + $due_price + $vat))?>원
					</td>
					<td></td>
				</tr>
				<?
					$option_table = stripslashes(html_entity_decode($b_row->option_table));
					$option_table = json_decode($option_table, true);
					if(count($option_table) > 0) echo "<tr><td></td><td colspan='9' align='left' style='text-align:left;padding:2px 0;'><strong style='padding-right:30px;color:#000;'>구성품 : </strong>";

					foreach($option_table as $option){
						?>
						<span style="margin-left: 4px; margin-right: 28px;">
							<?=$option[values]?>
						</span>
					<?
					}
					if(count($option_table) > 0) echo "</td></tr>";
					?>
				<?
				}
				?>
				<tbody>
			</table>

			<div style="position: relative; width: 100%; margin-top: 16px;">
				ㄱ. 서명작성 후 교환 및 환불이 불가능합니다.<br />
				ㄴ. 오염, 파손 및 분실 시 복구비 또는 제작비가 청구됩니다.<br />
				ㄴ. 위 내용에 동의하고 확인합니다.<br />
				ㄷ. 미반납시 하루당 40%의 연체비가 청구됩니다.<br />
				ㄹ. 제공하신 개인정보(신분증사본)는 의상반납으로부터 3개월간 보관 후 폐기됩니다.<br />

				<div style="font-weight: 600;">
					위의 내용에 동의하고 확인합니다
				</div>

				<div style="width: 100%; text-align: right;">
					<span style="font-size: 18px; font-weight: 600; font-style: italic;">서명</span>
					<span style="margin-left: 8px; display: inline-block;text-align: center; min-width: 150px; border-bottom: 2px solid #000; padding-bottom: 4px;"><?=($order_info[offline])?"":"온라인주문 서명생략"?></span>
				</div>

			</div>
		</div>

		<script>
		document.getElementById("sum_price").innerHTML = "<?=number_format($sum_price)?>원";
		document.getElementById("sum_vat").innerHTML = "<?=number_format($sum_vat)?>원";
		document.getElementById("sum_due_price").innerHTML = "<?=number_format($sum_due_price)?>원";
		</script>
	</div>
</div>
<?
	}
}
?>
</body>
</html>
