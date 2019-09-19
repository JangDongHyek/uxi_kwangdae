<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";


if($_GET[catcode] != "") $catcode = $_GET[catcode];

echo "<link href=\"".$skin_dir."/style.css\" rel=\"stylesheet\" type=\"text/css\">";
echo "<script language='javascript' src='/adm/js/lib.js'></script>";
echo "<script language='javascript' src='/adm/js/jquery-1.10.2.js'></script>";
$param = "grp=$grp&brand=$brand&orderby=$orderby&searchopt=$searchopt&searchkey=$searchkey";

// 상품정보 가져오기 (이동하지 말것)
$sql = "select *, new as newc from wiz_product wp, wiz_cprelation wc where wp.prdcode='$prdcode' and wc.prdcode = wp.prdcode";
$result = mysql_query($sql) or error(mysql_error());
$total = mysql_num_rows($result);
$prd_row = mysql_fetch_array($result);
if($prdcode == "" || $total <= 0) error("존재하지 않는 상품입니다.");
if($catcode == "") $catcode = $prd_row[catcode];

// 상품옵션 가져오기
$sql = "select * from wiz_product_option where prdcode='$prdcode'";
$result = mysql_query($sql) or error(mysql_error());
while($row = mysql_fetch_array($result)){
	if($row[type] == "select") $select_table = $row[table];
	if($row[type] == "supply") $supply_table = $row[table];
}
if($select_table == "") $select_table = "{}";
if($supply_table == "") $supply_table = "{}";

$select_subjects = $prd_row[select_subjects];
$supply_subjects = $prd_row[supply_subjects];

// 브랜드 가져오기
$sql = "select idx, brdname from wiz_brand where brduse != 'N' and idx='$prd_row[brand]'";
$result = mysql_query($sql) or error(mysql_error());
$brand_info = mysql_fetch_array($result);
$brand = $brand_info[brdname];

// 상품 조회수 업데이트
$sql = "update wiz_product set viewcnt = viewcnt + 1 where prdcode = '$prdcode'";
mysql_query($sql) or error(mysql_error());

include "$_SERVER[DOCUMENT_ROOT]/adm/inc/cat_info.php"; 		// 카테고리정보

$shortexp = nl2br($prd_row[shortexp]);
$content = $prd_row[content];
$content_m = $prd_row[content_m];
$prdname = $prd_row[prdname];

// 오늘본 상품목록에 추가
$view_exist = false;
$view_idx = 0;
for($ii=0;$ii<100;$ii++){
	if($_SESSION["view_list"][$ii][prdcode]) $view_idx++;
}
for($ii = 0; $ii < $view_idx; $ii++){
	if($_SESSION["view_list"][$ii][prdcode] == $prdcode){ $view_exist = true; break; }
}
if(!$view_exist){
	$_SESSION["view_list"][$view_idx][prdcode] = $prdcode;
	$_SESSION["view_list"][$view_idx][prdimg] = $prd_row[prdimg_R];
	$_SESSION["view_list"][$view_idx][prdurl] = $_SERVER[PHP_SELF];
}

// 상품 이미지
if(!@file($_SERVER[DOCUMENT_ROOT]."/adm/data/prdimg/".$prd_row[prdimg_M1])) $prdimg = "/adm/images/noimg_M.gif";
else $prdimg = "/adm/data/prdimg/".$prd_row[prdimg_M1];

$prdimg_S1 = $prd_row[prdimg_S1];
$prdimg_S2 = $prd_row[prdimg_S2];
$prdimg_S3 = $prd_row[prdimg_S3];
$prdimg_S4 = $prd_row[prdimg_S4];
$prdimg_S5 = $prd_row[prdimg_S5];

$prdimg_M1 = $prd_row[prdimg_M1];
$prdimg_M2 = $prd_row[prdimg_M2];
$prdimg_M3 = $prd_row[prdimg_M3];
$prdimg_M4 = $prd_row[prdimg_M4];
$prdimg_M5 = $prd_row[prdimg_M5];

$info_name1 = $prd_row[info_name1];
$info_value1 = $prd_row[info_value1];
$info_name2 = $prd_row[info_name2];
$info_value2 = $prd_row[info_value2];
$info_name3 = $prd_row[info_name3];
$info_value3 = $prd_row[info_value3];
$info_name4 = $prd_row[info_name4];
$info_value4 = $prd_row[info_value4];
$info_name5 = $prd_row[info_name5];
$info_value5 = $prd_row[info_value5];
$info_name6 = $prd_row[info_name6];
$info_value6 = $prd_row[info_value6];

$sellprice 	= $prd_row[sellprice];
$strprice 	= $prd_row[strprice];
$conprice 	= $prd_row[conprice];
$reserve 		= $prd_row[reserve];
$stock      = $prd_row[stock];
$price      = $prd_row[sellprice];
$shortage   = $prd_row[shortage];
$delprice   = $prd_row[delprice];

$coupon_use			= $prd_row[coupon_use];
$coupon_sdate		= $prd_row[coupon_sdate];
$coupon_edate		= $prd_row[coupon_edate];
$coupon_limit		= $prd_row[coupon_limit];
$coupon_amount	= $prd_row[coupon_amount];
$coupon_type		= $prd_row[coupon_type];
$coupon_dis			= $prd_row[coupon_dis];

$prdcom					= $prd_row[prdcom];
$origin					= $prd_row[origin];

$info_use				= $prd_row[info_use];
$info_name1			= $prd_row[info_name1];
$info_value1		= $prd_row[info_value1];
$info_name2			= $prd_row[info_name2];
$info_value2		= $prd_row[info_value2];
$info_name3			= $prd_row[info_name3];
$info_value3		= $prd_row[info_value3];
$info_name4			= $prd_row[info_name4];
$info_value4		= $prd_row[info_value4];
$info_name5			= $prd_row[info_name5];
$info_value5		= $prd_row[info_value5];
$info_name6			= $prd_row[info_name6];
$info_value6		= $prd_row[info_value6];

// 상품아이콘
if($prd_row[popular] == "Y") 	$sp_img .= "<img src='/adm/images/icon_hit.gif'>&nbsp;";
if($prd_row[recom] == "Y") 		$sp_img .= "<img src='/adm/images/icon_rec.gif'>&nbsp;";
if($prd_row[newc] == "Y") 			$sp_img .= "<img src='/adm/images/icon_new.gif'>&nbsp;";
if($prd_row[best] == "Y") 			$sp_img .= "<img src='/adm/images/icon_best.gif'>&nbsp;";
if($prd_row[sale] == "Y")			$sp_img .= "<img src='/adm/images/icon_sale.gif'>&nbsp;";

if($prd_row[shortage] == "Y" || (!strcmp($prd_row[shortage], "S") && $prd_row[stock] <= 0)) $sp_img .= "<img src='/adm/images/icon_not.gif'>&nbsp;";

$prdicon_list = explode("/",$prd_row[prdicon]);
for($ii=0; $ii<count($prdicon_list)-1; $ii++){
  $sp_img .= "<img src='/adm/data/prdicon/".$prdicon_list[$ii]."'> ";
}

if(!empty($prd_row[strprice])) $sellprice = $prd_row[strprice];
else $sellprice = number_format($prd_row[sellprice])."원";

if($prdimg_max < 12) $prdimg_hide_max = 12;
else $prdimg_hide_max = $prdimg_max;
for($ii = 1; $ii <= $prdimg_hide_max; $ii++) {

	if(!is_file("$_SERVER[DOCUMENT_ROOT]/adm/data/prdimg/".${prdimg_S.$ii})){
		${prdimg_hide_start.$ii} = "<!--"; ${prdimg_hide_end.$ii} = "-->";
	}

}

//include "$_SERVER[DOCUMENT_ROOT]/adm/product/category.php";					// 카테고리

if($info_name1 == ""){
	$info_hide_start1 = "<!--"; $info_hide_end1 = "-->";
}
if($info_name2 == ""){
	$info_hide_start2 = "<!--"; $info_hide_end2 = "-->";
}
if($info_name3 == ""){
	$info_hide_start3 = "<!--"; $info_hide_end3 = "-->";
}
if($info_name4 == ""){
	$info_hide_start4 = "<!--"; $info_hide_end4 = "-->";
}
if($info_name5 == ""){
	$info_hide_start5 = "<!--"; $info_hide_end5 = "-->";
}
if($info_name6 == ""){
	$info_hide_start6 = "<!--"; $info_hide_end6 = "-->";
}

$list_btn = "<a href='".$PHP_SELF."?ptype=list&page=".$page."&catcode=".$catcode."&".$param."'><img src='".$skin_dir."/image/btn_list.gif' border='0'></a>";
?>

<script language="javascript">
<!--

var prdimg = "<?=$prd_row[prdimg_L1]?>";

function chgImage(idx){
<?php
for($ii = 1; $ii <= $prdimg_max; $ii++) {
?>
	if(idx == "<?=$ii?>"){
		prdimg = "<?=$prd_row[prdimg_L.$ii]?>";
		document.prdimg.src = "/adm/data/prdimg/<?=$prd_row[prdimg_M.$ii]?>";
	}
<?php
}
?>

}

// 상품이미지 팝업
function prdZoom(){
   var url = "/adm/product/prd_zoom.php?prdcode=<?=$prdcode?>";
   window.open(url,"prdZoom","width=798,height=600,scrollbars=no");
}

// 장바구니에 담기
function saveBasket(direct){
  <?
  if($prd_row[shortage] == "Y" || (!strcmp($prd_row[shortage], "S") && $prd_row[stock] <= 0)) echo "alert('죄송합니다. 품절상품 입니다.');";
  else {
  	if(empty($prd_info[basket_url]) || empty($prd_info[order_url])) {
  		echo "alert('장바구니 또는 주문페이지가 설정되지 않았습니다.');";
  	} else {

			?>
				$.when(checkOption()).done(
					function(data){
						data = JSON.parse(data);
						if(data.msg){
							alert(data.msg);
						}
						else {
							if(direct=='buy'){
								document.prdForm.option_table.value = JSON.stringify(getOptionTable());
								document.prdForm.direct.value = direct;
								document.prdForm.mode.value='insert';
								document.prdForm.submit();
							}
							else{
								baskertajax(true);
							}
						}
					}
				);

			<?

  	}
  }
  ?>

}

function saveWish(){
	$.ajax({
		url: "/adm/product/prd_save.php",
		method: "post",
		data: {
			prdcode: document.prdForm.prdcode.value,
			mode: "my_wish"
		},
		success: function(res){
			alert(res);
		}
	});
}

function postForm(){

	var data = getFormData($("#prdForm"));
	data['option_table'] = getOptionTable();

	$.ajax({
		type : "post",
		url : "/adm/product/prd_save.php",
		data : data,
		success : function(response){
			location.href = response;
		}
	});

}


function baskertajax(alertable){

	var data = getFormData($("#prdForm"));
	data['option_table'] = getOptionTable();

	return $.ajax({
			type:"post"
			, dataType: "text"
			, url:  "/adm/product/inc/basket_ajax.php"
			, data: data
			, dataType: "json"
			, success: function(res) {
				if(res.error){ alert(res.error); }
				else{
					if(confirm("장바구니에 담았습니다. \n장바구니로 이동하시겠습니까?")){
						document.location = "/<?=$prd_info[basket_url]?>";
					}
				}
			}
			, error: function(){
				alert("error");
			}
	});
}

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        indexed_array[n['name']] = n['value'];
    });

    return indexed_array;
}
-->
</script>

<?

// 다음이전 상품
$catcode01 = str_replace("00","",substr($catcode,0,2));
$catcode02 = str_replace("00","",substr($catcode,2,2));
$catcode03 = str_replace("00","",substr($catcode,4,2));
$tmp_catcode = $catcode01.$catcode02.$catcode03;
$sql = "select wp.prdcode from wiz_cprelation wc, wiz_product wp where wc.catcode like '$tmp_catcode%' and wc.prdcode = wp.prdcode and wp.showset != 'N' and wp.prdcode > '$prdcode' order by wp.prdcode asc limit 1";
$result = mysql_query($sql) or error(mysql_error());
if($row = mysql_fetch_object($result)) {
	$prev = "<a href='$PHP_SELF?ptype=view&prdcode=$row->prdcode&catcode=$catcode&$param'>이전</a>";
	$prev_prdcode = "$PHP_SELF?ptype=view&prdcode=$row->prdcode&catcode=$catcode&$param";
} else {
	$prev = "<a href=javascript:prevAlert();>이전</a>";
	$prev_prdcode = "javascript:prevAlert();";
}

$sql = "select wc.prdcode from wiz_cprelation wc, wiz_product wp where wc.catcode like '$tmp_catcode%' and wc.prdcode = wp.prdcode and wp.showset != 'N' and wp.prdcode < '$prdcode' order by wp.prdcode desc limit 1";
$result = mysql_query($sql) or error(mysql_error());
if($row = mysql_fetch_object($result)) {
	$next = "<a href='$PHP_SELF?ptype=view&prdcode=$row->prdcode&catcode=$catcode&$param'>다음</a>";
	$next_prdcode = "$PHP_SELF?ptype=view&prdcode=$row->prdcode&catcode=$catcode&$param";
} else {
	$next = "<a href=javascript:nextAlert();>다음</a>";
	$next_prdcode = "javascript:nextAlert();";
}
?>

<!--제품 상세보기 시작-->


<!-- 실제 컨텐츠 부분 -->
<div width="100%" border="0" cellpadding="0" cellspacing="0">

  <!-- 상품 간략 설명 -->
	<div id="product_view_wrap">
		<div class="container">


			<div class="view-top">
				<!-- 상품 이미지 -->
				<div id="product_view_image">

					<div id="View_Product_Img">
						<img src="<?=$prdimg?>" name="prdimg">
					</div>

					<div id="zoom_btn_wrap" style="padding:10px 0px;">
						<!-- 확대보기 -->

						<a href="<?=$prev_prdcode?>"><img src="/adm/images/but_view_prev.gif" border=0></a>
						<img src="/adm/images/but_view_zoom.gif" border=0 onClick="prdZoom();" style="cursor:pointer">
						<a href="<?=$next_prdcode?>"><img src="/adm/images/but_view_next.gif" border=0></a>

						<!-- //확대보기 -->
					</div>

					<div id="thumbnail_wrap">

						<? $imgpath = $_SERVER[DOCUMENT_ROOT]."/adm/data/prdimg"; ?>
						<?php
						for($ii = 1; $ii <= 5; $ii++) {
							if(@file($imgpath."/".${"prdimg_S".$ii})){
								?>
								<div class="View_Product_SImg">
									<img src="/adm/data/prdimg/<?=${"prdimg_S".$ii}?>" onMouseOver="document.prdimg.src='/adm/data/prdimg/<?=${"prdimg_M".$ii}?>'"></td>

								</div><!-- //상품 썸네일 -->

								<?php
							}
						}
						?>
					</div><!-- //상품 이미지 -->

				</div>

				<!-- 제품정보 -->
				<div id="product_view_info">

					<form name="prdForm" id="prdForm" action="/adm/product/prd_save.php" method="post" enctype="application/json">
						<input type="hidden" name="mode" value="insert">
						<input type="hidden" name="direct" value="">
						<input type="hidden" name="prdcode" value="<?=$prdcode?>">
						<input type="hidden" name="tmp_sellprice" value="<?=$prd_row[sellprice]?>">
						<input type="hidden" name="tmp_reserve" value="<?=$reserve?>">
						<input type="hidden" name="option_table" value="">
						<input type="hidden" name="stock" value="<?=$stock?>">

						<table style="width:100%;">
							<tr>
								<td class="p_name"><h1 class="item_title"><?=$prdname?></h1></td>
							</tr>
						</table>

						<table width="100%" border=0 cellpadding=0 cellspacing=0>
							<tr>
								<td>
									<table id="item_info_style" border="0" cellpadding="0" cellspacing="0" width="100%">
										<? if($prd_row[conprice] > $prd_row[sellprice]){ ?>
											<tr>
												<th class="p_tit">정상가</th>
												<td class="p_info"><span style="text-decoration:line-through;"><?=number_format($conprice)?>원</span></td>
											</tr>
										<? } ?>
										<!-- <tr>
										<th class="p_tit">판매가격</th>
										<td class="p_info" id="sellprice"><span class="price_b"><?=$sellprice?></span></td>
									</tr> -->
									<?php
									if(!empty($wiz_session[id]) && empty($strprice)) {

										$level_info = level_info();
										$level = $level_info[$wiz_session[level]][name];

										$lev_sql = "select * from wiz_level where idx = '$wiz_session[level]'";
										$lev_result = mysql_query($lev_sql) or error(mysql_error());
										$lev_row = mysql_fetch_object($lev_result);

										if($lev_row->discount > 0) {
											if($lev_row->distype == "W") {
												$lev_row->distype = "원";
												$member_price = $lev_row->discount;
											} else {
												$lev_row->distype = "%";
												$member_dis = $lev_row->discount/100;
												$member_price = $prd_row[sellprice]*$member_dis;
											}
											?>
											<tr>
												<td class="p_tit">등급할인액</td>
												<td class="p_info"><?=number_format($member_price)?>원 &nbsp;<?=number_format($lev_row->discount)?><?=$lev_row->distype?> [<?=$level?>]</td>
											</tr>
											<?php
										}
									}
									?>

									<?
									if(
									$coupon_use == "Y" &&
									$coupon_sdate <= date('Y-m-d') &&
									$coupon_edate >= date('Y-m-d') &&
									($coupon_limit == "N" || ($coupon_limit == "" && $coupon_amount > 0))
									&& empty($strprice)
									){
										if($coupon_type == "%"){
											$coupon_dis = $coupon_dis/100;
											$coupon_price = $prd_row[sellprice]*$coupon_dis;
										}else{
											$coupon_price = $coupon_dis;
										}
										?>
										<input type="hidden" name="coupon_dis" value="<?=$prd_row[coupon_dis]?>">
										<input type="hidden" name="coupon_type" value="<?=$prd_row[coupon_type]?>">

										<tr>
											<th class="p_tit">쿠폰할인액</th>
											<td class="p_info"  id="coupon"><?=number_format($coupon_price)?>원 &nbsp;<?=number_format($prd_row[coupon_dis])?><?=$coupon_type?>&nbsp;<a href="/adm/product/coupon_down.php?prdcode=<?=$prdcode?>"><img src="/adm/images/coupon_down.gif" border="0"></a></td>
										</tr>
									<? } ?>

									<? if($oper_info[reserve_use] == "Y" && empty($strprice)){ ?>
										<tr>
											<th class="p_tit">적립금</th>
											<td  class="p_info" id="reserve"><?=number_format($reserve)?>원</td>
										</tr>
									<? } ?>
								</table><!-- //상품 가격 -->

							</td><!-- //상품 가격 -->
						</tr>
					</table>
					<table id="item_info_style" style="width:100%;" border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<? // 대여기간 날짜 선택 디자인 ?>
							<th>대여기간</th>
							<td>
								<div class="ll-wrap">
									<div class="ll l1">
										<label class="date-btn" for="sdate">
											<input id="sdate" name="sdate" type="text" maxlength="10" style="height: 40px;" placeholder="대여시작"/>
										</label>
									</div><span>~</span><div class="ll l2">
										<label class="date-btn" for="edate">
											<input id="edate" name="edate" type="text" maxlength="10" style="height: 40px;" placeholder="대여종료"/>
										</label>
									</div><input id="day" name="day" type="hidden" />
								</div>
							</td>
						</tr>
						<tr>
							<? // 배송 방법 선택 디자인 ?>
							<th>배송선택</th>
							<td>
								<select class="" name="delivery">
									<option value="">배송방법을 선택하세요.</option>
									<option value="매장방문">매장방문</option>
									<option value="퀵배송">퀵배송</option>
									<option value="고속버스탁송">고속버스탁송</option>
									<option value="택배">택배</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>수량</th>
							<td>
								<div class="option_control" style="display: inline-block;">
									<button class="option_decrease" type="button" onclick="decAmount(this.form);">-</button>
									<input type="number" name="amount" class="option_amount" type="text" value="1" onkeydown="return onkeydown_amount(event);" onchange="checkAmount(this.form);">
									<button class="option_increase" type="button" onclick="incAmount(this.form);">+</button>
								</div>
							</td>
						</tr>
						<? if($sp_img != ""){ ?>
							<!-- <tr>
							<td class="p_tit">제품상태</td>
							<td class="p_info"><?=$sp_img?></td>
						</tr> -->
					<? } ?>
					<? if($prdcom != ""){ ?>
						<tr>
							<th class="p_tit">저자</th>
							<td class="p_info"><?=$prdcom?></td>
						</tr>
					<? } ?>
					<? if($origin != ""){ ?>
						<tr>
							<th class="p_tit">출판사</th>
							<td class="p_info"><?=$origin?></td>
						</tr>
					<? } ?>

					<?php
					if(!strcmp($info_use, "Y")) {
						for($ii = 1; $ii <= 6; $ii++) {
							if(!empty(${"info_name".$ii})) {
								?>
								<tr>
									<td class="p_tit"><?=${"info_name".$ii}?></td>
									<td class="p_info"><?=${"info_value".$ii}?></td>
								</tr>
								<?php
							}
						}
					}
					?>

					<?
					/*if($prefer != ""){ ?>
					<tr>
					<td class="p_tit">고객선호도</td>
					<td class="p_info"> <img src="/adm/images/icon_star_<?=$prefer?>.gif"></td>
				</tr>
			<? }
			*/ ?>
		</table>
		<table style="width:100%;">

			<? /* 옴션 선택 */ ?>
			<tr class="option-tr" style="<?=($select_table!='{}')?'':'display:none;'?>">
				<th>옵션선택</th>
				<td>
					<table id="select_list"></table>
				</td>
			</tr>
			<? /* 추가 옵션 */ ?>
			<tr class="add-opt" style="<?=($supply_table!='{}')?'':'display:none;'?>">
				<th>옵션추가</th>
				<td>
					<table id="supply_list"></table>
				</td>
			</tr>
		</table>

		<div>
			<ul id="option_list" class="option_list"></ul>
		</div>
		<table>
			<tr>
				<td id="item_scrape_style" class="View_info_scrape">
					<table border="0" cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<td class="p_tit">스크랩하기</td>
							<td style="padding-left:20px;">
								<img src="/adm/images/i_tw.png" border=0 style="cursor:pointer" onclick="snsTwitter('<?=$prd_info->prdname?>','http://<?=$HTTP_HOST?><?=$REQUEST_URI?>');">
								<img src="/adm/images/i_fb.png" border=0 style="cursor:pointer" onclick="snsFacebook('<?=$prd_info->prdname?>','http://<?=$HTTP_HOST?><?=$REQUEST_URI?>');">
								<img src="/adm/images/i_blog.png" border=0 style="cursor:pointer" onclick="snsnaver('<?=$prd_info->prdname?>','http://<?=$HTTP_HOST?><?=$REQUEST_URI?>');">
							</td>
						</tr>
					</table></td>
				</tr>
			</table>

			<? // 연체 금액, 파손or분실 금액 ?>
			<div class="extra-info">
				<table border="0" cellpadding="0" cellspacing="0" width="100%">
					<tbody>
						<tr>
							<th>연체시</th>
							<td>일 <em id="due_price"></em>원</td>
						</tr>
						<tr>
							<th>파손 및 분실시</th>
							<td><div id="destroy"><?=number_format($delprice)?>원</div></td>
						</tr>
						<tr>
							<th>사이즈 요청란</th>
							<td>
								<textarea name="memo" rows="3" style="width: 100%; background: #fafafa"></textarea>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="info-total">
				<div class="info-total-row">총 대여료 <span class="total_price"><em id="total_price"><!-- 통대여료금액 --></em>원</span></div>
				<? if(empty($strprice)) { ?>
					<div class="info-btn-wrap">
						<div class="info-btn">
							<a class="btn btn_point" href="javascript:saveBasket('buy');">바로구매</a>
						</div>
						<div class="info-btn">
							<a class="btn btn_confirm" href="javascript:saveBasket('basket');">장바구니</a>
						</div>
						<div class="info-btn">
							<a class="btn btn_border" href="javascript:saveWish();">관심상품</a>
						</div>
						<div class="info-btn">
							<a class="btn btn_border" href="<?=$PHP_SELF?>?catcode=<?=$catcode?>&brand=<?=$brand?>&page=<?=$page?>&<?=$param?>">리스트</a>
						</div>
					</div>
				<? } ?>

				<? if( $site_info[naver_pay] == "Y" && ($site_info[naver_test] == "N" || $wiz_session[id] == "test" ) ){ // Start 네이버페이 블록 ?>
					<div id='npay'>
						<? if(!check_mobile()){ ?>
							<script type="text/javascript" src="http://pay.naver.com/customer/js/naverPayButton.js" charset="UTF-8"></script>
						<? } else { ?>
							<script type="text/javascript" src="https://pay.naver.com/customer/js/mobile/naverPayButton.js" charset="UTF8"></script>
						<? } ?>
						<script>

							function buy_nc(npay_url) {
								<?
								if($prd_row[shortage] == "Y" || (!strcmp($prd_row[shortage], "S") && $prd_row[stock] <= 0)) echo "alert('죄송합니다. 품절상품 입니다.');";
								else {
									if(empty($prd_info[basket_url]) || empty($prd_info[order_url])) {
										echo "alert('장바구니 또는 주문페이지가 설정되지 않았습니다.');";
									} else {
										// 네이버 페이 구매시 경로
										$npay_link = "";
										if($site_info[naver_pay] == "Y" && $site_info[naver_test] == "Y"){
											// 테스트 서버 환경일경우
											$npay_link = (!check_mobile())? "https://test-pay.naver.com/customer/order.nhn?ORDER_ID=" : "https://test-m.pay.naver.com/mobile/customer/order.nhn?ORDER_ID=";
										}
										else{
											// 실서버 환경일경우
											$npay_link = (!check_mobile())? "https://pay.naver.com/customer/order.nhn?ORDER_ID=" : "https://m.pay.naver.com/mobile/customer/order.nhn?ORDER_ID=";
										}
										?>
										//네이버페이로 주문 정보를 등록하는 가맹점 페이지로 이동.
										//해당 페이지에서 주문 정보 등록 후 네이버페이 주문서 페이지로 이동.
										//구매시 옵션 정보를 넘겨줘야함.
										$.when(baskertajax()).done(
										$.when(checkOption()).done(
										$.ajax({
											url: npay_url,
											type: 'post',
											data: {
												product : [{
													prdcode : '<?=$prdcode?>',
													option_table : getOptionTable(),
													amount : 1
												}]
											},
											success: function(data){
												var obj = JSON.parse(data);
												if(obj.resultCode == 200){
													location.href = '<?=$npay_link?>'+obj.ORDER_ID+'&SHOP_ID='+obj.SHOP_ID+'&TOTAL_PRICE='+obj.TOTAL_PRICE;
												}
												else{
													alert(obj.error);
												}
											}
										})
										)
										);
										<?
									}
								}
								?>
								return false;
							}

							function wishlist_nc(npay_url) {
								<?
								if($prd_row[shortage] == "Y" || (!strcmp($prd_row[shortage], "S") && $prd_row[stock] <= 0)) echo "alert('죄송합니다. 품절상품 입니다.');";
								else {
									if(empty($prd_info[basket_url]) || empty($prd_info[order_url])) {
										echo "alert('장바구니 또는 주문페이지가 설정되지 않았습니다.');";
									} else {
										$npay_link = "";
										if($site_info[naver_pay] == "Y" && $site_info[naver_test] == "Y"){
											$npay_link = (!check_mobile())? "https://test-pay.naver.com/customer/wishlistPopup.nhn?SHOP_ID=" : "https://test-m.pay.naver.com/mobile/customer/wishList.nhn?SHOP_ID=";
										}
										else{
											$npay_link = (!check_mobile())? "https://pay.naver.com/customer/wishlistPopup.nhn?SHOP_ID=" : "https://m.pay.naver.com/mobile/customer/wishList.nhn?SHOP_ID=";
										}
										?>
										//네이버페이로 주문 정보를 등록하는 가맹점 페이지로 이동.
										//해당 페이지에서 주문 정보 등록 후 네이버페이 주문서 페이지로 이동.
										//location.href=url;
										//옵션이 없어도 찜하기가 가능해야함

										$.ajax({
											type:"post"
											, dataType: "text"
											, url:  "/adm/product/inc/basket_ajax.php"
											, data: $("#prdForm").serialize()
										});

										$.ajax({
											url: npay_url,
											type: 'post',
											data: {
												prdcode : '<?=$prdcode?>'
											},
											success: function(data){
												var obj = JSON.parse(data);
												if(obj.resultCode == 200){
													var wish_url = '<?=$npay_link?>'+obj.SHOP_ID+'&ITEM_ID='+obj.ITEM_ID;
													window.open(wish_url,"wishlist_nc","scrollbars=yes,width=400,height=267");
												}
												else{
													alert(obj.error);
												}
											}
										});
										<?
									}
								}
								?>
								return false;
							}

							//<![CDATA[
							naver.NaverPayButton.apply({
								BUTTON_KEY: "<?=$site_info[naver_button_key]?>", // 네이버페이에서 제공받은 버튼 인증 키 입력
								TYPE: "<?=(check_mobile())?"MA":"B"?>", // 버튼 모음 종류 설정
								COLOR: 1, // 버튼 모음의 색 설정
								COUNT: 2, // 버튼 개수 설정. 구매하기 버튼만 있으면(장바구니 페이지) 1, 찜하기 버튼도 있으면(상품 상세 페이지) 2를 입력.
								ENABLE: "<?=($prd_row[shortage] == "Y" || (!strcmp($prd_row[shortage], "S") && $prd_row[stock] <= 0))?"N":"Y"?>", // 품절 등과 같은 이유에 따라 버튼을 비활성화할 필요가 있을 경우
								BUY_BUTTON_HANDLER: buy_nc, // 구매하기 버튼 이벤트 Handler 함수 등록, 품절인 경우 not_buy_nc 함수 사용
								BUY_BUTTON_LINK_URL:"/adm/product/npay/npay_order.php", // 링크 주소 (필요한 경우만 사용)
								WISHLIST_BUTTON_HANDLER: wishlist_nc, // 찜하기 버튼 이벤트 Handler 함수 등록
								WISHLIST_BUTTON_LINK_URL:"/adm/product/npay/npay_wish.php", // 찜하기 팝업 링크 주소
								"":""
							});
							//]]>
						</script>
					</div>
				<?  }  // END 네이버페이 블록  ?>

			</div>
		</form>

	</div>

			</div>



      <!-- <tr><td height="60"></td></tr> -->


	  	<div class="view-bottom">

			<div class="view-box">
				<!-- 상세 정보-->
				<div class="view-contents-wrap">
					<h3 class="view-title">구성품안내</h3>
					<div class="view-contents"><?=$content?></div>
					<div class="view-contents-m"><?=$content_m?></div>
				</div>
			</div>


			<!--     구매가이드         -->
			<? //$page_type = "prdview"; include "../inc/page_info.inc"; ?>
			<div style="display:none;"><?=$page_info->content?></div>

			<!-- <tr><td height="40"></td></tr> -->

			<div class="view-box" style="display:none;">
				<a name="review">
				<? include "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_review.php"; //리뷰 ?>
				<? include "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_expect.php"; //기대평 ?>
			</div>


			<div class="view-box" style="display:none;">
				<a name="qna"></a>
				<? include "$_SERVER[DOCUMENT_ROOT]/adm/product/prd_qna.php"; //상품 QnA ?>
			</div>

			<div class="view-box">
				<a name="rel" ></a>
				<h3 class="view-title">대여안내</h3>
				<div class="prd-info-box">
					<div class="pi">
						<? $code="prdinfo"; include "$_SERVER[DOCUMENT_ROOT]/adm/module/page.php"; // 배송및교환 ?>
					</div>
					<div class="pi-m">

					</div>

				</div>
			</div>


  	  	</div>
		</div>
		</div>
	</div>
</div>
<script>
var destroy = parseInt("<?=empty($delprice)?"0":$delprice?>");

/**
* Number.prototype.format(n, x)
*
* @param integer n: length of decimal
* @param integer x: length of sections
*/
Number.prototype.format = function(n, x) {
	var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')'; return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
};


var select_subjects = '<?=$select_subjects?>';
var supply_subjects = '<?=$supply_subjects?>';
var select_table = '<?=$select_table?>';
var supply_table = '<?=$supply_table?>';
var sellprice = parseInt('<?=$price?>');

initOption();

function initOption(){

	// json 스크립트를 테이블화 시켜준다.

	if(select_table == "") select_table = new Object();
	else select_table = JSON.parse(select_table);

	if(supply_table == "") supply_table = new Object();
	else{
		supply_table = JSON.parse(supply_table);
	}

	createProduct();
	createSelect();
	createSupply();

	updateTotalPrice();

}

// 본품
function createProduct(){

	<?
	$stack = 0;
	switch($shortage){
		case "Y": $stack = 0;      break;
		case "N": $stack = 9999;   break;
		case "S": $stack = $stock; break;
	}
	?>

	if(select_subjects == ""){
		addOption("product", "<?=$prdname?>", parseInt('<?=$price?>'), parseInt('<?=$stack?>'));
	}

}

// 옵션 선택
function createSelect(){

	document.getElementById("select_list").innerHTML = "";

	// 옵션명을 배열 형태로 자른다.
	var subjects = select_subjects.split(",");

	// 옵션명 수 만큼 반복
	for(var i=0; i<subjects.length;i++){

		var tr = document.createElement("tr");
		var td = document.createElement("td");

		var select = document.createElement("select");
		select.name = "select_values[]";
		select.onchange = onchangeSelect;

		var option = document.createElement("option");
		option.label = subjects[i];
		option.innerHTML = subjects[i];
		option.disabled = true;
		option.selected = true;
		option.style.display = "none";
		option.value = "";

		select.appendChild(option);

		td.appendChild(select);
		tr.appendChild(td);

		document.getElementById("select_list").appendChild(tr);

		if( i==0 ) setSelect(select);
		else select.disabled = true;
	}
}

// Select에 옵션을 설정
function setSelect(select){

	var selects = document.prdForm.elements[select.name];
	var i, values = select_table;

	var length = 0;
	for(var i=0; i<document.prdForm.elements.length; i++){
		if(document.prdForm.elements[i].name == select.name) length ++;
	}

	// 옵션 값을 구해온다.
	if(length > 1){
		for(i=0; i<length; i++){
			if( i != 0 ) values = values[selects[i-1].value];
			if( selects[i] == select ) break;
		}
	}

	// Select 초기화
	while(select.options.length > 1) select.removeChild(select.options[select.length - 1]);
	select.selectedIndex = 0;

	for(var key in values){

		var label = key;

		if(values[key].hasOwnProperty("price") && values[key].hasOwnProperty("stock") && values[key].hasOwnProperty("usable")){
			if(values[key].usable == "false") continue;
		}

		var option = document.createElement("option");
		option.label = label;
		option.innerHTML = label;
		option.value = key;

		if(values[key].hasOwnProperty("stock")){
			if(values[key].stock == "0"){
				option.label += " (품절)";
				option.innerHTML += " (품절)";
				option.disabled = true;
			}
		}

		select.appendChild(option);
	}
	select.disabled = false;
}

function createSupply(){

	document.getElementById("supply_list").innerHTML = "";

	var subjects = supply_subjects.split(",");

	for(var i=0; i<subjects.length; i++){

		var tr = document.createElement("tr");
		var td = document.createElement("td");

		var select = document.createElement("select");
		select.name = "supply_values[]";
		select.onchange = onchangeSupply;

		var option = document.createElement("option");
		option.label = ":: " + subjects[i] + "을(를) 선택해주세요 ::";
		option.innerHTML = ":: " + subjects[i] + "을(를) 선택해주세요 ::";
		option.disabled = true;
		option.selected = true;
		option.style.display = "none";
		option.value = subjects[i];

		select.appendChild(option);

		for(var key in supply_table[subjects[i]]){
			option  = document.createElement("option");
			option.label = key;
			option.innerHTML = key;
			option.value = key;

			if(supply_table[subjects[i]][key].hasOwnProperty("stock")){
				if(supply_table[subjects[i]][key].stock == "0"){
					option.label += " (품절)";
					option.innerHTML += " (품절)";
					option.disabled = true;
				}
				else{
					option.label += " (+"+parseInt(supply_table[subjects[i]][key].price).format()+"원)";
					option.innerHTML += " (+"+parseInt(supply_table[subjects[i]][key].price).format()+"원)";
				}
			}

			select.appendChild(option);
		}

		td.style.width = "100%";
		td.appendChild(select);
		tr.appendChild(td);

		document.getElementById("supply_list").appendChild(tr);
	}

}

function getValues(json, depth, values){
	if(depth != 0){
		for(var key in json){
			getValues(json[key], depth-1, values);
		}
	}
	else{
		for(var key in json){
			if(!values.hasOwnProperty(key)) values[key] = new Object();
		}
	}
}

function onchangeSelect(e){

	var select  = this; // 옵션 선택이 일어난 셀렉트
	var selects = document.prdForm.elements[select.name]; // 폼에서 가져올때는, 여러개 일수도 있음
	var values  = select_table;
	var options = select.value;

	var length = 0;
	for(var i=0; i<document.prdForm.elements.length; i++){
		if(document.prdForm.elements[i].name == select.name) length ++;
	}

	// 셀릭트가 한개가 아닌경우
	if(length > 1){
		// 인덱스 찾기
		var i;
		for(i=0, options=""; i < length; i++){
			if( options != "" ) options += ",";
			options += selects[i].value;
			if( i != 0 ) values = values[selects[i-1].value];
			if( select == selects[i] ) break;
		}

		// 다음 셀렉트가 있다면 세팅
		if( i != length - 1) setSelect(selects[i+1]);

		// 다음 셀렉트 이후로 선택 못하도록 변경
		for(i+=2; i < length; i++){
			selects[i].disabled = true;
			selects[i].options[0].selected = true;
		}
	}

	if( values[select.value].hasOwnProperty("price") && values[select.value].hasOwnProperty("stock")){
		addOption("select", options, values[select.value]["price"], values[select.value]["stock"]);
	}
}


function addOption(type, options, price, stock){

	options = options.split(",");
	price = ( type=="select" ) ? parseInt(sellprice)+parseInt(price) : price;

	var list = document.getElementById("option_list");
	var li = document.createElement("li");
	li.className = "option_item";
	li.style.display = (type == "product") ? "none" : "block" ;

	var header = document.createElement("div");
	header.className = "option_header";

	for(var i=0;i<options.length; i++){
		var div = document.createElement("div");
		if(i>0){
			div.innerHTML = ' / '+options[i];
			if(i == options.length-1){
				div.innerHTML = "&nbsp;(+" + parseInt(price).format() + "원)";
			}
		} else {
			div.innerHTML = "추가대여 : " + options[i];

		}
		div.className = "option_values";

		header.appendChild(div);
	}

	// 삭제버튼
	var del = document.createElement("button");
	del.className = "option_delete";
	del.innerHTML = "Ｘ";
	del.onclick = function(){
		list.removeChild(li);

		updateTotalPrice();
	};

	var option_type = document.createElement("input");
	option_type.type = "hidden";
	option_type.name = "option_type[]";
	option_type.value = type;

	var option_values = document.createElement("input");
	option_values.type = "hidden";
	option_values.name = "option_values[]";
	option_values.value = options;

	var price_input = document.createElement("input");
	price_input.type = "hidden";
	price_input.name = "option_price[]";
	price_input.value = price;

	var stock_input = document.createElement("input");
	stock_input.type = "hidden";
	stock_input.name = "option_stock[]";
	stock_input.value = stock;

	var control = document.createElement("div");
	control.style.display = "none";
	control.className = "option_control";

	var amount = document.createElement("input");
	amount.name = "option_amount[]";
	amount.className = "option_amount";
	amount.type = "hidden";
	amount.value = 1;

	control.appendChild(amount);

	var label = document.createElement("label");
	label.className = "option_price";
	label.innerHTML = parseInt(price).format() + "원";
	label.style.display = "none";

	var footer = document.createElement("div");
	footer.className = "option_footer";

	var divider = document.createElement("div");
	divider.className = "option_divider";

	if(type != "product") header.appendChild(del);
	header.appendChild(option_type);
	header.appendChild(option_values);
	header.appendChild(price_input);
	header.appendChild(stock_input);

	header.appendChild(control);
	header.appendChild(label);

	li.appendChild(header);
	li.appendChild(divider);

	list.appendChild(li);

	updateTotalPrice();
}

function onchangeSupply(){

	var select  = this; // 옵션 선택이 일어난 셀렉트
	var subject = select.options[0].value;
	var values  = supply_table[subject];

	var index = 0;
	var value = "";
	for(var i=0; i<select.options.length; i++){
		if(select.options[i].selected){
			index = i;
			value = select.options[i].value;
		}
	}
	var options = subject + "," + value;

	if( values[select.value].hasOwnProperty("price") && values[select.value].hasOwnProperty("stock")){
		addOption("supply", options, values[select.value]["price"], values[select.value]["stock"]);
	}

	select.selectedIndex = 0;

	document.activeElement.blur();
}

function getOptionTable(){

	var frm = document.prdForm;
	var list = document.getElementById("option_list");

	var option_table = [];

	for(var i=0;i<list.children.length; i++){
		var item = {};
		if(list.children.length != 1){
			item["type"]   = frm.elements["option_type[]"][i].value;
			item["values"] = frm.elements["option_values[]"][i].value;
			item["amount"] = frm.elements["amount"].value;
			item["price"]  = frm.elements["option_price[]"][i].value;
		}
		else{
			item["type"]   = frm.elements["option_type[]"].value;
			item["values"] = frm.elements["option_values[]"].value;
			item["amount"] = frm.elements["amount"].value;
			item["price"]  = frm.elements["option_price[]"].value;
		}

		option_table.push(item);
	}

	return option_table;
}


function getOptionString(){

	var option_table = getOptionTable();
	var option_string = "";

	for(var i=0;i<option_table.length; i++){
		var item = option_table[i];

		if(option_string != "") option_string += " | ";
		option_string += item.values + " " + item.amount + "개";
	}

	return option_string;

}
function checkOption(){

	var result = false;

	return $.ajax({
		url : "/adm/product/prd_check_ajax.php",
		method : "post",
		data : {
			prdcode : "<?=$prdcode?>",
			option_table : getOptionTable(),
		}
	});
}

function updateTotalPrice(){

	var option_price  = document.prdForm.elements["option_price[]"];
	var option_amount = document.prdForm.elements["option_amount[]"];
	var amount = document.prdForm.amount.value;

	var list = document.getElementById("option_list");
	var total = 0;

	for(var i=0; i<list.children.length; i++){
		if( list.children.length == 1 ){
			if(option_price.length){
				total = option_price[i].value * amount;
			}
			else{
				total = option_price.value * amount;
			}
		}
		else{
			total = total + option_price[i].value * amount;
		}
	}

	var day = document.getElementById("day").value;

	if(!total) total = 0;

	document.getElementById("total_price").innerHTML = parseInt(total + (total * 0.2 * day)).format();
	document.getElementById("due_price").innerHTML = parseInt(total * 0.4).format();
}

function incAmount(frm){
	var amount = frm.amount;
	var stock = frm.stock;

	if(parseInt(amount.value) < parseInt(stock.value)){
		amount.value ++;
		document.getElementById("destroy").innerHTML = parseInt(destroy * amount.value).format() + "원";
	}
	else alert("해당 옵션의 재고량이 부족합니다.");

	updateTotalPrice();
}

function decAmount(frm){
	var amount = frm.amount;
	var stock = frm.stock;

	if(1 < parseInt(amount.value)){
		amount.value --;
		document.getElementById("destroy").innerHTML = parseInt(destroy * amount.value).format()+ "원";
	}

	updateTotalPrice();
}

function checkAmount(frm){
	var amount = frm.amount;
	var stock = frm.stock;

	if(!amount.value) amount.value = 1;
	if(parseInt(amount.value) < 1) amount.value = 1;
	if(parseInt(stock.value) < parseInt(amount.value)) {
		alert("해당 옵션의 재고량이 부족합니다.");
		amount.value = 1;
	}

	updateTotalPrice();
}

function onKeyupNumber(){
	this.value = this.value.replace(/[^0-9]/g,'');
}


</script>

<script>
	$(document).ready(function(){
		$("#sdate").datepicker({
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
			changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
			showMonthAfterYear: true, // 년월 셀렉트 박스 위치 변경
			beforeShowDay: function(date){
				var edate = $("#edate").val();

				var today = new Date();
				today.setHours(0,0,0,0);

				if(date.getTime() < today.getTime()) return [false];

				if(!edate) return [true];
				else{
					var trd = new Date(edate);
					trd.setHours(0,0,0,0);
					trd.setDate(trd.getDate() - 2);
					if(date.getTime() <= trd.getTime()) return [true];
					else return [false];
				}
			},
			onSelect: function(date){
				var sdate = date;
				var edate = $("#edate").val();

				if(sdate && edate){
					sdate = new Date(sdate);
					sdate.setHours(0,0,0,0);
					edate = new Date(edate);
					edate.setHours(0,0,0,0);

					document.getElementById("day").value = (edate.getTime() - sdate.getTime()) / 86400000 - 2;

					updateTotalPrice();
				}
				else if(!edate){
					var trd = new Date(sdate);
					trd.setDate(trd.getDate() + 2);
					$("#edate").val([trd.getFullYear(), pad(trd.getMonth() + 1, 2), pad(trd.getDate(), 2)].join("-"));
				}
			}
		});
		$("#edate").datepicker({
			dateFormat: 'yy-mm-dd',
			dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
			monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
			changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
			changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
			showMonthAfterYear: true, // 년월 셀렉트 박스 위치 변경
			beforeShowDay: function(date){
				var sdate = $("#sdate").val();

				var today = new Date();
				today.setDate(today.getDate() + 2);
				today.setHours(0,0,0,0);

				if(date.getTime() < today.getTime()) return [false];

				if(!sdate) return [true];
				else{
					var trd = new Date(sdate);
					trd.setHours(0,0,0,0);
					trd.setDate(trd.getDate() + 2);
					if(trd.getTime() <= date.getTime()) return [true];
					else return [false];
				}
			},
			onSelect: function(date){
				var sdate = $("#sdate").val();
				var edate = date;

				if(sdate && edate){
					sdate = new Date(sdate);
					sdate.setHours(0,0,0,0);
					edate = new Date(edate);
					edate.setHours(0,0,0,0);

					document.getElementById("day").value = (edate.getTime() - sdate.getTime()) / 86400000 - 2;

					updateTotalPrice();
				}
				else if(!sdate){
					var trd = new Date(edate);
					trd.setDate(trd.getDate() - 2);
					$("#sdate").val([trd.getFullYear(), pad(trd.getMonth() + 1, 2), pad(trd.getDate(), 2)].join("-"));
				}
			}
		});

		function pad(n, width) {
		  n = n + '';
		  return n.length >= width ? n : new Array(width - n.length + 1).join('0') + n;
		};
	});
</script>

    <!-- 실제 컨텐츠 끝 -->
