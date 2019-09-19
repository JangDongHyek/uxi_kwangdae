
<script language="JavaScript" src="/adm/js/lib.js"></script>

<script>
	function onResizeImage(img){
		(img.width < img.height)?img.style.height='96px':img.style.width='96px';
		img.style.marginTop = (96 - img.height) / 2 + "px";
		img.style.marginLeft = (96 - img.width) / 2 + "px";
	}
</script>

<table id="cart_list_style" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
	<th width="50%">상품정보</th>
	<!-- <th width="10%">수량</th> -->
	<th width="10%">할인금액</th>
	<!-- <th width="10%">대여기간</th> -->
	<!-- <th width="10%">배송방법</th> -->
	<th width="10%">주문금액</th>
</tr>
<?
$basket_exist = false;
$no = 0;

$idx=explode("|",$selidx);
for($ii="0"; $ii<count($idx)-1; $ii++){
		$sql = "SELECT wb.*, wp.del_type, wp.del_price FROM wiz_basket_tmp as wb left join wiz_product as wp on wb.prdcode = wp.prdcode WHERE wb.uniq_id='".$_COOKIE["uniq_id"]."' and wb.idx='$idx[$ii]'";
		$btresult = mysql_query($sql) or error(mysql_error());
		while($brow = mysql_fetch_array($btresult)){
			$basket_exist = true;
			$prdimg = "";
			$del_type = "";
			$prd_price += $brow[prdprice];
			$prd_amount  += $brow[amount];
			$option_table = json_decode($brow[option_table], true);
			$memo = $brow[memo];

			// 상품 이미지
			if(!@file($_SERVER[DOCUMENT_ROOT]."/adm/data/prdimg/".$brow[prdimg])) $prdimg = "/adm/images/noimg_S.gif";
			else $prdimg = "/adm/data/prdimg/".$brow[prdimg];

			if(!empty($brow[del_type]) && strcmp($brow[del_type], "DA")) {
				if(!strcmp($brow[del_type], "DC")) $del_type = "(".deliver_name_prd($brow[del_type])." : ".number_format($brow[del_price])."원)";
					else $del_type = "(".deliver_name_prd($brow[del_type]).")";
				}

				$c_sql = "select wc.purl
				from wiz_product as wp left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode
				left join wiz_category as wc on wcp.catcode = wc.catcode
				where wp.prdcode = '$brow[prdcode]'";
			$c_result = mysql_query($c_sql) or error(mysql_error());
			$c_row = mysql_fetch_array($c_result);

			$prd_view_page = "/".$c_row[purl]."?ptype=view&prdcode=".$brow[prdcode];
		?>

		<tr>
			<td class="buy-td">
					<div class="basket-col-wrap order-basket">
						<div class="basket-col">
							<a href="<?=$prd_view_page?>" target="prdview">
								<img src="<?=$prdimg?>" border="0" onload="onResizeImage(this);">
							</a>
						</div>
						<div class="basket-col">
							<div class="opt-list" style="display:<?=($option_table == '')?'none':'block'?>;">
								<a class="basket-name" href="<?=$prd_view_page?>" target="prdview"><?=$brow[prdname]?></a>
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
								대여기간: <?=$brow[sdate]?> ~ <?=$brow[edate]?> (<?=$brow[day]+3?>일)
							</div>
							<div class="basket-bottom-row">
								배송방법: <?=$brow[delivery]?>
							</div>
							<div class="basket-bottom-row">
								사이즈: <?=$brow[memo]?>
							</div>
						</div>
					</div>
			</td>
			<td align=center>
				<?=number_format(level_discount($wiz_session[level],$brow[prdprice],$brow[amount]))?>원
			</td>
			<td align=center><?=number_format($brow[prdprice])?>원</td>
		</tr>
		<!-- <div style="width: 100%;">
			<div style="width: 100%; background: #e0eaef;">
				<div style="display: inline-block;">
					<a href="<?=$prd_view_page?>" target="prdview">
						<img src="<?=$prdimg?>" border="0" onload="onResizeImage(this);">
					</a>
				</div>
				<div style="display: inline-block;"></div>
			</div>
		</div> -->
		<?
			$no++;

		}
}

if(!$basket_exist){
	echo "<tr><td colspan=7 height=30 align=center>장바구니가 비어있습니다.</td></tr>";
}

// 회원할인 [$discount_msg 메세지 생성]
$discount_price = level_discount($wiz_session[level],$prd_price,$prd_amount);

// 배송비
$deliver_price = deliver_price($prd_price, $oper_info);

// 전체결제금액
$total_price = $prd_price + $deliver_price - $discount_price;
$total_price_vat = $prd_price * 1.1 + $deliver_price - $discount_price;
?>
</table>

<div class="basket-total">
	<div class="deliver-text">
		<span class="dv-col">상품가격<span class="dp"><span class="vhide">(</span><b><?=number_format($prd_price)?>원</b><span class="vhide">)</span> <?=$discount_msg?></span></span>
		<span class="dv-col s-i"><i class="b-plus"></i></span>
		<span class="dv-col">배송비<span class="dp"><span class="vhide">(</span><b><?=number_format($deliver_price)?>원</b><span class="vhide">)</span></span></span>
		<span class="dv-col s-i"><i class="b-plus"></i></span>
		<span class="dv-col">부가세<span class="dp"><span class="vhide">(</span><b id="vat"  style="display: none;"><?=number_format($prd_price*0.1)?>원</b><b id="non-vat">0원</b><span class="vhide">)</span></span></span>
		<span class="dv-col s-i"><i class="b-equal"></i></span>
		<span class="dv-col">주문합계 <span class="dp"><em class="total-price" id="vat2" style="display: none;" ><?=number_format($total_price_vat)?></em><em class="total-price" id="non-vat2" ><?=number_format($total_price)?></em>원</span></span>
	</div>
</div>
