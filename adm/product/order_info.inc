<script>
function onResizeImage(img){
  (img.width < img.height)?img.style.height='96px':img.style.width='96px';
  img.style.marginTop = (96 - img.height) / 2 + "px";
  img.style.marginLeft = (96 - img.width) / 2 + "px";
}
</script>
<table id="cart_list_style" border="0"  cellpadding="0" cellspacing="0" width="100%">
<tr>
    <th class="cart_cell_prdinfo" align="center">구매상품정보</th>
    <!-- <th width="100">수량</th> -->
    <!-- <th width="200">대여기간</th> -->
    <!-- <th width="100">배송방법</th> -->
    <th width="100">가격</th>
    <th class="" width="80">상품평</th>
</tr>
<?
$sql = "select * from wiz_basket where orderid = '$order_info[orderid]'";
$result = mysql_query($sql,$connect) or error(mysql_error());
$prd_num = mysql_num_rows($result);

$no = 0;
while($row = mysql_fetch_object($result)){

	$prd_price += $row->prdprice;
	if($row->prdimg == "") $row->prdimg = "/adm/images/noimage.gif";
	else $row->prdimg = "/adm/data/prdimg/".$row->prdimg;

	$option_table = json_decode($row->option_table, true);


	if(!strcmp($row->status, "CA")) $basket_status = "<font color='red'>[취소신청]</font>";
	else if(!strcmp($row->status, "CI")) $basket_status = "<font color='red'>[처리중]</font>";
	else if(!strcmp($row->status, "CC")) $basket_status = "<font color='red'>[취소완료]</font>";
	else $basket_status = "";

	$del_type = "";
	if(!empty($row->del_type) && strcmp($row->del_type, "DA")) {
		if(!strcmp($row->del_type, "DC")) $del_type = "<br>(".deliver_name_prd($row->del_type)." : ".number_format($row->del_price)."원)";
			else $del_type = "<br>(".deliver_name_prd($row->del_type).")";
		}

		if($_GET["shop"] === "cat"){
			$prd_view_page = "/child/sub/shop/product_cat.php?shop=cat&ptype=view&prdcode=".$row->prdcode;
		} else {
			$prd_view_page = "/child/sub/shop/product.php?ptype=view&prdcode=".$row->prdcode;
		}

		$review_link = "/service/review.php?ptype=input&prdcode=".$row->prdcode."&basketid=".$row->idx."&orderid=".$order_info[orderid];

	/* 고양이 쇼핑몰 스타일 */
	if($shop === "cat"){
		$catclass = " table_cat";
		$catcolor = " cat-color";
	}

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
					<div class="option_list" style="display:<?=($option_table == '')?'none':'block'?>;">
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
							<table style="width:100%;">
								<tr>
                  <td>
                    <span class="basket-val" title="<?=$item_values?>"><?=$item_values?></span>
                    <span><?=$item_amount?></span>
                  </td>
								</tr>
							</table>
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
	<td align=center><?=number_format($row->prdprice)?>원</td>
	<td align=center><a href="<?=$review_link?>"><button class="btn_delete_item" type="button">작성<br class="m_br">하기</button></a></td>
</tr>
<?
	$no++;
}

// 회원할인
if($order_info[discount_price] > 0){
	$discount_msg = " - 회원할인(<b>".number_format($order_info[discount_price])."원</b>)";
}

// 적립금 사용
if($order_info[reserve_use] > 0){
	$reserve_msg = " - 적립금 사용(<b>".number_format($order_info[reserve_use])."원</b>)";
}

// 쿠폰사용
if($order_info[coupon_use] > 0){
	$coupon_msg = " - 쿠폰 사용(<b>".number_format($order_info[coupon_use])."원</b>)";
}

// 배송비
$deliver_price = deliver_price($order_info[prd_price], $oper_info);

?>
</table>

<div class="basket-total">
	<div class="deliver-text">
		<span class="dv-col">총결제금액: 상품가격<span class="dp"><span class="vhide">(</span><b><?=number_format($order_info[prd_price])?>원</b><span class="vhide">)</span> <?=$discount_msg?></span></span>
		<span class="dv-col s-i"><i class="b-plus">+</i></span>
		<span class="dv-col">배송비<span class="dp"><span class="vhide">(</span><b><?=number_format($order_info[deliver_price])?>원</b><span class="vhide">)</span></span><?=$coupon_msg?><?=$reserve_msg?></span>
    <span class="dv-col s-i"><i class="b-plus">+</i></span>
		<span class="dv-col">부가세<span class="dp"><span class="vhide">(</span><b><?=number_format($order_info[vat_price])?>원</b><span class="vhide">)</span></span></span>
		<span class="dv-col s-i"><i class="b-equal">=</i></span>
		<span class="dv-col">주문합계 <span class="dp"><em class="total-price"><?=number_format($order_info[total_price])?></em>원</span></span>
	</div>
</div>


<div class="product_order_box">

	<table id="pay_method_style" class="order_box_wrap<?=$catclass?>" width="100%" border="0" cellpadding="0" cellspacing="0" style="text-align:left; margin-top:30px;" class="AWorder_form_table">
	<tr>
		<th>주문번호</th>
		<td><?=$order_info[orderid]?></td>
		<th class="pc_cell">주문일</th>
		<td class="pc_cell"><?=$order_info[order_date]?></td>
	</tr>
	<tr>
		<th class="m_cell">주문일</th>
		<td class="m_cell"><?=$order_info[order_date]?></td>
	</tr>
	<tr>
		<th>결제방법</th>
		<td><?=pay_method($order_info[pay_method])?></td>
		<th class="pc_cell">주문상태</th>
		<td class="pc_cell"><?=order_status($order_info[status])?></td>
	</tr>
	<tr>
		<th class="m_cell">주문상태</th>
		<td class="m_cell"><?=order_status($order_info[status])?></td>
	</tr>
	<? if($order_info[pay_method] == "PB"){ ?>
	<tr>
		<th>입금계좌</th>
		<td><?=$order_info[account]?></td>
		<th class="pc_cell">입금자명</th>
		<td class="pc_cell"><?=$order_info[account_name]?></td>
	</tr>
	<tr>
		<th class="m_cell">입금자명</th>
		<td class="m_cell"><?=$order_info[account_name]?></td>
	</tr>
	<? }else if($order_info[pay_method] == "PV"){ ?>
	<tr>
		<th>입금계좌</th>
		<td><?=$order_info[account]?></b><font color=red>(가상계좌번호로 입금하셔야 주문이 완료됩니다.)</font></td>
	</tr>
	<? } ?>
	</table>
</div>


<div class="product_order_box">

	<div class="t_left head_title">
		<h3>주문하시는 분</h3>
	</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="AWorder_form_table order_box_wrap<?=$catclass?>">
	<tr>
		<th>주문하시는 분</th>
		<td><?=$order_info[send_name]?></td>
	</tr>
	<tr>
		<th>전화번호</th>
		<td><?=$order_info[send_tphone]?></td>
	</tr>
	<tr>
		<th>휴대전화번호</th>
		<td><?=$order_info[send_hphone]?></td>
	</tr>
	<tr>
		<th>이메일</th>
		<td><?=$order_info[send_email]?></td>
	</tr>
	<tr>
		<th>주 소</th>
		<td>[<?=$order_info[send_post]?>] <?=$order_info[send_address]?></td>
	</tr>
	</table>
</div>



<!-- 상품 받으실 분 -->
<div class="product_order_box">

	<div class="t_left head_title">
		<h3>상품 받으실 분</h3>
	</div>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="AWorder_form_table order_box_wrap<?=$catclass?>">
	<tr>
		<th>받으시는 분</th>
		<td><?=$order_info[rece_name]?></td>
	</tr>
	<tr>
		<th>전화번호</th>
		<td><?=$order_info[rece_tphone]?></td>
	</tr>
	<tr>
		<th>휴대전화번호</th>
		<td>
			<?=$order_info[rece_hphone]?>
		</tr>
		<tr>
			<th>주 소</th>
			<td>[<?=$order_info[rece_post]?>] <?=$order_info[rece_address]?></td>
		</tr>
		<tr>
			<th>배송시 요청사항</th>
			<td><?=str_replace("\n","<br>&nbsp;&nbsp;",$order_info[demand])?></td>
		</tr>
	</table>
</div>
