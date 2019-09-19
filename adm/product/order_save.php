<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_price.php";

$order_url = $prd_info[order_url];

if($rece_name == "") error("받으시는 분 이름이 빠졌습니다.");
if($rece_post1 == "") error("받으시는 분 우편번호가 빠졌습니다.");
if($rece_address1 == "" || $rece_address2 == "") error("받으시는 분 주소가 빠졌습니다.");
if($rece_tphone == "" || $rece_tphone2 == "" || $rece_tphone3 == "") error("받으시는 분 전화번호가 빠졌습니다.");

$send_id = $wiz_session[id];
$reserve_use = $_POST["reserve_use"];

$send_post = $send_post1;
$send_address = $send_address1." ".$send_address2;
$send_tphone = $send_tphone."-".$send_tphone2."-".$send_tphone3;
$send_hphone = $send_hphone."-".$send_hphone2."-".$send_hphone3;

$rece_post = $rece_post1;
$rece_address = $rece_address1." ".$rece_address2;
$rece_tphone = $rece_tphone."-".$rece_tphone2."-".$rece_tphone3;
$rece_hphone = $rece_hphone."-".$rece_hphone2."-".$rece_hphone3;

// 주문생성
// 주문번호
$orderid = date("ymdHis").rand(100,999);

// 주문가격 정보(상품가 격, 배송비, 적립금, 전체결제금액)
// 주문정보 입력폼에서 전달시 변조될 위험있음

// $selidx는 장바구니 같은곳에서, 선택된 상품들을 모아서 전달해 넘어온 변수
$idx=explode("|",$selidx);

// 상품들 루프
for($ii="0"; $ii<count($idx)-1; $ii++){
	$sql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$_COOKIE["uniq_id"]."'and idx='$idx[$ii]'";
	$bkresult = mysql_query($sql) or error(mysql_error());

	// 상품 가격을 더해서, 주문정보 금액으로 만드는 부분
	while($bkinfo = mysql_fetch_array($bkresult)){
		// 장바구니에 담긴 금액 말고, 검증된 가격으로 넣어야함
		//$prd_price += $bkinfo[prdprice];
		$amount = $bkinfo[amount];
		$option_table = stripslashes(html_entity_decode($bkinfo[option_table]));
		$option_table = json_decode($option_table, true);

		$sellprice = getPrice($bkinfo[prdcode], $option_table);
		if($sellprice == -1) error($prd_data[msg]);
		$prd_price += ($sellprice + ($sellprice * 0.2 * $bkinfo[day]));

		// $reserve_price += $bkinfo[prdreserve];
	}

	$prd_info = "";
	// 주문상품 저장

	$sql = "SELECT wb.*, wp.del_type, wp.del_price FROM wiz_basket_tmp as wb left join wiz_product as wp on wb.prdcode = wp.prdcode WHERE wb.uniq_id='".$_COOKIE["uniq_id"]."'and wb.idx='$idx[$ii]'";
	$bkiresult = mysql_query($sql) or error(mysql_error());
	while($bkirow = mysql_fetch_array($bkiresult)){
		if(($pay_method == "PB" || $pay_method == "PN" || $pay_method == "PV")&& $tax_type == "N"){ $vat = 0; }
		else $vat = $bkirow[prdprice] * 0.1;

		$sql = "INSERT INTO wiz_basket(idx,tmp_idx,orderid,prdcode,prdname,prdimg,prdprice,prdreserve,
		option_table,amount,wdate,status,del_type,del_price,sdate,edate,day,delivery,memo,vat
		)VALUES(
		'','$bkirow[idx]','".$orderid."','".$bkirow[prdcode]."','".$bkirow[prdname]."','".$bkirow[prdimg]."','".$bkirow[prdprice]."','".$bkirow[prdreserve]."',
		'".$bkirow[option_table]."','".$bkirow[amount]."',now(),'','".$bkirow[del_type]."','".$bkirow[del_price]."','".$bkirow[sdate]."','".$bkirow[edate]."',
		'".$bkirow[day]."','".$bkirow[delivery]."','{$bkirow[memo]}','{$vat}')";

		mysql_query($sql) or error(mysql_error());

		$prd_info .= $bkirow[prdname]."^".$bkirow[prdprice]."^".$bkirow[amount]."^^";
	}

}

// 배송비
$deliver_price = deliver_price($prd_price, $oper_info);

// 배송방법
$deliver_method = $oper_info[del_method];

// 회원할인 [$discount_msg 메세지 생성]
$discount_price = level_discount($wiz_session[level],$prd_price);

// 배송할증료 적용(고정값,구매가격별에서만 적용)
if($deliver_method == "DC" || $deliver_method == "DD"){
	$tmp_post = str_replace("-","",$rece_post);
	if($oper_info[del_extrapost1] <= $tmp_post && $tmp_post <= $oper_info[del_extrapost12]) $deliver_price = $deliver_price + $oper_info[del_extraprice1];
	if($oper_info[del_extrapost2] <= $tmp_post && $tmp_post <= $oper_info[del_extrapost22]) $deliver_price = $deliver_price + $oper_info[del_extraprice2];
	if($oper_info[del_extrapost3] <= $tmp_post && $tmp_post <= $oper_info[del_extrapost32]) $deliver_price = $deliver_price + $oper_info[del_extraprice3];
}

// 부가세 적용
if(($pay_method == "PB" || $pay_method == "PN" || $pay_method == "PV")&& $tax_type == "N"){ $vat = 0; }
else $vat = $prd_price * 0.1;
$total_price = $prd_price + $deliver_price - $discount_price + $vat;

// 적립금사용시 결제액 감소, 적림금감소
if($oper_info[reserve_use] == "Y" && $reserve_use > 0 && $wiz_session[id] != ""){

	// 회원적립금 가져오기
	$sql = "SELECT SUM(reserve) AS reserve FROM wiz_reserve WHERE memid = '$wiz_session[id]'";
	$result = mysql_query($sql) or error(mysql_error());
	$mem_info = mysql_fetch_object($result);
	if($mem_info->reserve == "") $mem_info->reserve = 0;

	// 적립금 사용금액이 실제 적립금보다 많다면
	if($reserve_use > $mem_info->reserve){
		error("실제적립금 보다 사용액이 많습니다.");
	}
	else{
		$total_price = $total_price - $reserve_use;
	}

}

// 쿠폰사용
if($coupon_use != "" && $coupon_use > 0){
	$total_price = $total_price - $coupon_use;
}

if($oper_info[reserve_use]=="Y"){
	$reserve_price=($total_price-$deliver_price)*$oper_info[reserve_buy]/100; //최종 적립금(토탈금액-배송비 기준)
}



// 주문정보 저장
$sql = "INSERT INTO wiz_order(
orderid,send_id,send_name,send_tphone,send_hphone,send_email,send_post,send_address,demand,message,cancelmsg,
rece_name,rece_tphone,rece_hphone,rece_post,rece_address,pay_method,account_name,account,coupon_use,coupon_idx,reserve_use,
reserve_price,deliver_method,deliver_price,deliver_num,discount_price,prd_price,total_price,status,order_date,
pay_date,send_date,cancel_date,descript,tax_type,vat_price
)VALUES(
'".$orderid."','".$send_id."', '".$send_name."', '".$send_tphone."', '".$send_hphone."', '".$send_email."', '".$send_post."', '".$send_address."', '".$demand."', '".$message."', '$cancelmsg ',
'".$rece_name."', '".$rece_tphone."', '".$rece_hphone."', '".$rece_post."', '".$rece_address."',
'".$pay_method."', '".$account_name."', '".$account."', '".$coupon_use."','".$coupon_idx."',
'".$reserve_use."', '".$reserve_price."', '".$deliver_method."', '".$deliver_price."', '".$deliver_num."', '".$discount_price."','".$prd_price."', '".$total_price."',
'".$status."', now(), '".$paydate."', '".$sendddate."', '".$canceldate."', '".$descript."','".$tax_type."','".$vat."')";

mysql_query($sql) or error(mysql_error());

// 세금계산서 저장
if(!strcmp($oper_info[tax_use], "Y") && $tax_type != "N") {

	$supp_price = intval($total_price/1.1);
	$tax_price = $total_price - $supp_price;

	// 신청정보
	if(is_array($cash_info_arr)) $cash_info = implode("-", $cash_info_arr);

	$sql = "INSERT INTO wiz_tax(orderid,com_num,com_name,com_owner,com_address,com_kind,com_class,com_tel,com_email,prd_info,supp_price,tax_price,tax_pub,tax_type,cash_type,cash_type2,cash_info,cash_name)
	VALUES ('".$orderid."','".$com_num."','".$com_name."','".$com_owner."','".$com_address."','".$com_kind."','".$com_class."','".$com_tel."','".$com_email."','".$prd_info."','".$supp_price."','".$tax_price."','N','".$tax_type."','".$cash_type."','".$cash_type2."','".$cash_info."','".$cash_name."')";
	mysql_query($sql) or error(mysql_error());

}

Header("location: http://".$_http_host."/".$order_url."?ptype=pay&orderid=".$orderid."&pay_method=".$pay_method);

?>
