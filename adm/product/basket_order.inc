<script>
function onResizeImage(img){
  (img.width < img.height)?img.style.height='96px':img.style.width='96px';
  img.style.marginTop = (96 - img.height) / 2 + "px";
  img.style.marginLeft = (96 - img.width) / 2 + "px";
}
</script>
<table id="cart_list_style" border="0" cellpadding="0" cellspacing="0" width="100%">
 <tr>
     <th width="50%">주문상품정보</th>
     <!-- <th width="10%">수량</th> -->
     <th width="10%">할인금액</th>
     <!-- <th width="10%">대여기간</th> -->
     <!-- <th width="10%">배송방법</th> -->
     <th width="10%">주문금액</th>
 </tr>
 <?

 // 주문정보
 $sql = "select * from wiz_order where orderid='".$orderid."'";
 $result = mysql_query($sql) or error(mysql_error());
 $order_info = mysql_fetch_object($result);

 // 주문상품 정보
 $sql = "select * from wiz_basket where orderid='".$orderid."'";
 $result = mysql_query($sql) or error(mysql_error());
 $total = mysql_num_rows($result);
 while($row = mysql_fetch_object($result)){

	 $del_type = "";
   $option_table = json_decode($row->option_table, true);

	 ///////////////////////////////////////////////////////////////////////////////////
	 //결제에 들어갈 상품이름 (1개일경우 :마우스 , 2개이상일경우 마우스 외1개 로 출력)//
	 ///////////////////////////////////////////////////////////////////////////////////
	 if($total>1){//1개 이상일경우
		 $payment_prdname = $row->prdname." 외".($total-1)."개";
	 }else{//한개일경우
		 $payment_prdname = $row->prdname;
	 }

	 if(!empty($row->del_type) && strcmp($row->del_type, "DA")) {
		 if(!strcmp($row->del_type, "DC")) $del_type = "<br>(".deliver_name_prd($row->del_type)." : ".number_format($row->del_price)."원)";
		 else $del_type = "<br>(".deliver_name_prd($row->del_type).")";
	 }

	 // 상품 이미지
	 if(!@file($_SERVER[DOCUMENT_ROOT]."/adm/data/prdimg/".$row->prdimg)) $row->prdimg = "/adm/images/noimg_S.gif";
	 else $row->prdimg = "/adm/data/prdimg/".$row->prdimg;

	 $c_sql = "select wc.purl
						 from wiz_product as wp left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode
						 left join wiz_category as wc on wcp.catcode = wc.catcode
						 where wp.prdcode = '$row->prdcode'";
	 $c_result = mysql_query($c_sql) or error(mysql_error());
	 $c_row = mysql_fetch_array($c_result);

	 $prd_view_page = "/".$c_row[purl]."?ptype=view&prdcode=".$row->prdcode;
 ?>
 <tr>
   <td class="buy-td">
       <div class="basket-col-wrap order-basket">
           <div class="basket-col">
               <a href="<?=$prd_view_page?>" target="prdview">
                   <img src="<?=$row->prdimg?>" border="0" onload="onResizeImage(this);">
               </a>
           </div>
           <div class="basket-col">
               <div class="option-list" style="display:<?=($option_table == '')?'none':'block'?>;">
                   <a class="basket-name" href="<?=$prd_view_page?>" target="prdview"><?=$row->prdname?></a>
                   <?
                   // 옵션 리스팅
                   foreach($option_table as $item){
                       // $item_values = $item[values]." / ".number_format($item[price])."원";
                       $item_values = $item[values];
                       $item_amount = $item[amount]."개" ;
                       // $item_price = number_format($item[price] * $item[amount])."원";
                       $item_price = "";
                       ?>
                       <span class="basket-val" title="<?=$item_values?>"><?=$item_values?></span>
                       <span><?=$item_amount?></span>
                       <?
                   }
                   ?>
               </div>
           </div>
           <div class="basket-col-bottom">
               <div class="basket-bottom-row">
                   수량: <?=$row->amount?>개
               </div>
               <div class="basket-bottom-row">
                   대여기간: <?=$row->sdate?> ~ <?=$row->edate?>
               </div>
               <div class="basket-bottom-row">
                   배송방법: <?=$row->delivery?>
               </div>
               <div class="basket-bottom-row">
                   사이즈: <?=$row->memo?>
               </div>
           </div>
       </div>
   </td>
   <td align=center>
     <?=number_format(level_discount($wiz_session[level],$row->prdprice,$row->amount))?>원
   </td>
   <td align=center><?=number_format($row->prdprice)?>원</td>
 </tr>
 </form>
 <?
 }

 if($total <= 0){
 ?>
 <tr><td colspan=10 height=30 align=center>장바구니가 비어있습니다.</td></tr>
 <?
 }

 // 배송비
 $deliver_price = deliver_price($order_info->prd_price, $oper_info);
 if($order_info->deliver_price > $deliver_price){
	 $deliver_msg .= " , 배송비 할증";
 }

 // 회원할인 [$discount_msg 메세지 생성]
 $discount_price = level_discount($wiz_session[level],$order_info->prd_price);

 // 적립금 사용
 if($order_info->reserve_use > 0){
	 $reserve_msg = " - 적립금 사용(<b>".number_format($order_info->reserve_use)."</b>)";
 }

 // 쿠폰사용
 if($order_info->coupon_use > 0){
	 $coupon_msg = " - 쿠폰 사용(<b>".number_format($order_info->coupon_use)."</b>)";
 }
 ?>
</table>



<div class="basket-total">
	<div class="deliver-text">
		<span class="dv-col">상품가격<span class="dp"><span class="vhide">(</span><b><?=number_format($order_info->prd_price)?>원</b><span class="vhide">)</span> <?=$discount_msg?></span></span>
		<span class="dv-col s-i"><i class="b-plus"></i></span>
		<span class="dv-col">배송비<span class="dp"><span class="vhide">(</span><b><?=number_format($order_info->deliver_price)?>원</b><span class="vhide">)</span></span><?=$coupon_msg?> <?=$reserve_msg?></span>
    <span class="dv-col s-i"><i class="b-plus"></i></span>
		<span class="dv-col">부가세<span class="dp"><span class="vhide">(</span><b><?=number_format($order_info->vat_price)?>원</b><span class="vhide">)</span></span><?=$coupon_msg?> <?=$reserve_msg?></span>
		<span class="dv-col s-i"><i class="b-equal"></i></span>
		<span class="dv-col">주문합계 <span class="dp"><em class="total-price"><?=number_format($order_info->total_price)?></em>원</span></span>
	</div>
</div>
