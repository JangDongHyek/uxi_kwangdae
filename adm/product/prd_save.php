<? include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php"; ?>
<? include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php"; ?>
<? include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php"; ?>
<? include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php"; ?>
<? include_once "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_check.php"; ?>
<? include_once "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_price.php"; ?>
<?php
header("Content-type: text/html; charset=utf-8");

// 재고량 체크
// function checkAmount($prdcode, $amount, $optcode){
//
// 	global $prd_row;
//
// 	global $optcode3;
// 	global $optcode4;
//
// 	$sql = "select prdname, prdimg_R as prdimg, opttitle, optcode, opttitle2, optcode2, opttitle3, optcode3, opttitle4, optcode4, optvalue, stock, sellprice, reserve, shortage, opt_use from wiz_product where prdcode = '$prdcode'";
// 	$result = mysql_query($sql) or error(mysql_error());
// 	$prd_row = mysql_fetch_object($result);
//
// 	if(!empty($prd_row->optcode3)) {
//
// 		$opt3_arr = explode("^^", $prd_row->optcode3);
//
// 		for($ii = 0; $ii < count($opt3_arr); $ii++) {
//
// 			list($opt, $price, $reserve) = explode("^", $opt3_arr[$ii]);
//
// 			if(!strcmp($opt, $optcode3)) {
//
// 				$prd_row->sellprice = $prd_row->sellprice + $price;
// 				$prd_row->reserve = $prd_row->reserve + $reserve;
//
// 			}
// 		}
// 	}
// 	if(!empty($prd_row->optcode4)) {
//
// 		$opt4_arr = explode("^^", $prd_row->optcode4);
//
// 		for($ii = 0; $ii < count($opt4_arr); $ii++) {
//
// 			list($opt, $price, $reserve) = explode("^", $opt4_arr[$ii]);
//
// 			if(!strcmp($opt, $optcode4)) {
//
// 				$prd_row->sellprice = $prd_row->sellprice + $price;
// 				$prd_row->reserve = $prd_row->reserve + $reserve;
//
// 			}
// 		}
//
// 	}
//
// 	if(!strcmp($prd_row->opt_use, "Y")){
//
// 		$opt1_arr = explode("^", $prd_row->optcode);
// 		$opt2_arr = explode("^", $prd_row->optcode2);
// 		$opt_tmp = explode("^^", $prd_row->optvalue);
//
// 		list($optcode1, $optcode2) = explode("/", $optcode);
//
// 		$no = 0;
// 		for($ii = 0; $ii < count($opt1_arr) - 1; $ii++) {
// 			for($jj = 0; $jj < count($opt2_arr) - 1; $jj++) {
// 				list($price, $reserve, $stock) = explode("^", $opt_tmp[$no]);
//
// 				if(!strcmp($optcode1, $opt1_arr[$ii]) && !strcmp($optcode2, $opt2_arr[$jj])) {
// 					$prd_row->sellprice = $prd_row->sellprice + $price;
// 					$prd_row->reserve = $prd_row->reserve + $reserve;
// 					if($stock < $amount){
// 						error("주문수량이 재고량(".$stock."개)보다 많습니다.");
// 					}
// 				}
//
// 				$no++;
// 			}
// 		}
//
// 		/*
// 		$tmp_short = 0;
// 		$opt_tmp = explode("^^",$prd_row->optcode);
// 		for($ii=0; $ii<count($opt_tmp)-1; $ii++){
// 			$opt_sub_tmp = explode("^",$opt_tmp[$ii]);
// 			if($opt_sub_tmp[0] == $optcode){
// 				$prd_row->sellprice = $opt_sub_tmp[1];
// 				if($opt_sub_tmp[2] < $amount){
// 					error("주문수량이 재고량(".$opt_sub_tmp[2]."개)보다 많습니다.");
// 				}
// 			}
// 		}
// 		*/
//
// 	}else{
//
// 		if(!strcmp($prd_row->shortage, "S")) {
//
// 	   	if($amount > $prd_row->stock){
// 	   		error("주문수량이 재고량(".$prd_row->stock."개)보다 많습니다.");
// 	   	}
//
// 	  } else if(!strcmp($prd_row->shortage, "Y")) {
//
// 	  	error("품절된 상품입니다.");
//
// 	  }
//
// 	}
//
// 	$data[sellprice] = $prd_row->sellprice;
// 	$data[reserve] = $prd_row->reserve;
// 	return $data;
//
// }
$memo = str_replace("'", "", $memo);
$option_table = stripslashes(html_entity_decode($option_table));
$option_table = json_decode($option_table, true);

// 상품장바구니에 저장
if($mode == "insert"){

	if(empty($idx) && empty($selprd)) {

		// 중복상품이 있는경우
		$bsql = "SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$_COOKIE["uniq_id"]."'";
		$bresult = mysql_query($bsql) or error(mysql_error());
		while($result = mysql_fetch_array($bresult)){
		$basket_exist=false;
			if($result[prdcode] == $prdcode){
				$bsql = "DELETE FROM wiz_basket_tmp where idx='$result[idx]'";
				mysql_query($bsql) or error(mysql_error());
			}
		}

		$psql	= "SELECT * FROM wiz_product WHERE prdcode = '$prdcode'";
		$presult= mysql_query($psql) or error(mysql_error());
		$prow	= mysql_fetch_array($presult);

		// 중복된 상품에 옵션이 없다면 신규생성
		if(!$basket_exist){

			if( $sdate == "" || $edate == "") error("대여기간을 설정해주세요.");

			// $amount = 0;
			$sellprice = getPrice($prdcode, $option_table);
			$sellprice = $sellprice + ($sellprice * 0.2 * $day);
			//mjs

			$insert_sql = "INSERT INTO wiz_basket_tmp (
			idx,uniq_id,prdcode,prdname,prdimg,prdprice,prdreserve,option_table,amount,wdate,sdate,edate,day,delivery,memo
			)VALUES(
			'','".$_COOKIE["uniq_id"]."','$prdcode','$prd_row->prdname','$prd_row->prdimg','$sellprice','0','".raw_json_encode($option_table)."','$amount',now(),'$sdate','$edate','$day','$delivery','$memo')";

			mysql_query($insert_sql) or error(mysql_error());
			$bidx = mysql_insert_id();
			$selidx=$bidx."|";

			// 장바구니수 증가
			$sql = "update wiz_product set basketcnt = basketcnt + 1 where prdcode='$prdcode'";
			mysql_query($sql);
		}

	}

	if($direct == "basket" || empty($direct)) header("Location: /".$prd_info[basket_url]);
	else if($direct == "buy") header("Location: /".$prd_info[order_url]."?selidx=$selidx");

// 장바구니 수정
}else if($mode == "update"){
	$idx = $_POST[idx];
	$bkinfo= mysql_fetch_array(mysql_query("SELECT * FROM wiz_basket_tmp WHERE uniq_id='".$_COOKIE["uniq_id"]."' AND idx='".$idx."'"));

	// 재고 체크
	//checkAmount($bkinfo[prdcode], $amount, $bkinfo[optcode]);
	// $amount = 0;
	try{
		$sellprice = getPrice($prdcode, $option_table);
		$sellprice = $sellprice + ($sellprice * 0.2 * $bkinfo['day']);
	}
	catch(Exception $e){
		error($e->getMessage());
		exit;
	}

	@mysql_query("UPDATE wiz_basket_tmp SET prdprice='$sellprice', amount = '$amount', option_table = '".raw_json_encode($option_table)."' WHERE uniq_id='".$_COOKIE["uniq_id"]."' AND idx='".$idx."'");

	header("Location: /".$prd_info[basket_url]);

// 장바구니 삭제
}else if($mode == "delete"){

	$idx = $_GET[idx];
	@mysql_query("DELETE FROM wiz_basket_tmp WHERE uniq_id='".$_COOKIE["uniq_id"]."' AND idx='".$idx."'");
	header("Location: /".$prd_info[basket_url]);

// 장바구니 선택삭제
}else if($mode == "delsel"){


	foreach(explode("|", $_GET[selidx]) as $idx){
		@mysql_query("DELETE FROM wiz_basket_tmp WHERE uniq_id='".$_COOKIE["uniq_id"]."' AND idx='".$idx."'");
	}
	header("Location: /".$prd_info[basket_url]);

// 장바구니 전체삭제
}else if($mode == "delall"){
	@mysql_query("DELETE FROM wiz_basket_tmp WHERE uniq_id='".$_COOKIE["uniq_id"]."'");
	header("Location: /".$prd_info[basket_url]);

// 관심상품 추가
}else if($mode == "my_wish"){

	if(empty($wiz_session[id])) {
		echo "로그인 후 이용해주세요.";
		exit;
	}

	if(!empty($idx)) {
		$sql = "select * from wiz_basket_tmp where idx = '$idx'";
		$result = mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_array($result);

		$prdcode = $row[prdcode];
	}

	$sql = "select * from wiz_wishlist where memid = '$wiz_session[id]' and prdcode = '$prdcode'";
	$result = mysql_query($sql) or error(mysql_error());
	$total = mysql_num_rows($result);

	if($total > 0 ){
		echo "이미 등록한 관심상품 입니다.";
		exit;
	}

	$sql = "insert into wiz_wishlist(idx,memid,prdcode,amount,wdate)
					values('', '$wiz_session[id]', '$prdcode', '$amount', now())";
	$result = mysql_query($sql) or error(mysql_error());

	echo "관심상품에 추가하였습니다.";

// 관심상품 삭제
}else if($mode == "my_wishdel"){

	if(!empty($selprd)) {

		$tmp_prd = explode("|", $selprd);

		for($ii = 0; $ii < count($tmp_prd); $ii++) {

			$idx = $tmp_prd[$ii];

			$sql = "delete from wiz_wishlist where memid = '$wiz_session[id]' and idx = '$idx'";
			$result = mysql_query($sql) or error(mysql_error());

		}

	} else {

		$sql = "delete from wiz_wishlist where memid = '$wiz_session[id]' and idx = '$idx'";
		$result = mysql_query($sql) or error(mysql_error());

	}

	alert("관심상품에 삭제되었습니다.", $prev);

}
?>
