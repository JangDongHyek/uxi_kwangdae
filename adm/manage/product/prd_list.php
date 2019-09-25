<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include "../head.php"; ?>
<?

// 페이지 파라메터 (검색조건이 변하지 않도록)
//--------------------------------------------------------------------------------------------------
$param = "dep_code=$dep_code&dep2_code=$dep2_code&dep3_code=$dep3_code&list_rows=$list_rows";
$param .= "&special=$special&display=$display&coupon_use=$coupon_use&searchopt=$searchopt&searchkey=$searchkey";
$param .= "&brand=$brand&shortage=$shortage&stock=$stock";
//--------------------------------------------------------------------------------------------------

?>

<script language="JavaScript" type="text/javascript">
<!--

//체크박스선택 반전
function onSelect(obj){
	if(obj.checked){
		selectAll();
	}else{
		selectEmpty();
	}
}

//체크박스 전체선택
function selectAll(){

	var i;

	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].prdcode != null){
			if(document.forms[i].select_checkbox){
				document.forms[i].select_checkbox.checked = true;
			}
		}
	}
	return;
}

//체크박스 선택해제
function selectEmpty(){

	var i;

	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].prdcode != null){
			if(document.forms[i].select_checkbox){
				document.forms[i].select_checkbox.checked = false;
			}
		}
	}
	return;
}

//선택상품 삭제
function prdDelete(){

	var i;
	var selected = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].prdcode != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked){
					selected = selected + document.forms[i].prdcode.value + "|";
				}
			}
		}
	}

	if(selected == ""){
		alert("삭제할 상품을 선택하지 않았습니다.");
		return;
	}else{
		if(confirm("선택한 상품을 정말 삭제하시겠습니까?")){
			document.location = "prd_save.php?mode=delete&page=<?=$page?>&<?=$param?>&selected=" + selected;
		}else{
			selectEmpty();
			return;
		}
	}
	return;

}

//선택상품 수정
function prdChange(){

	var i;
	var selprdcode = "";
	var selprior = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].prdcode != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked){
					selprdcode = selprdcode + document.forms[i].prdcode.value + "|";
					selprior = selprior + document.forms[i].prior_num.value + "|";
				}
			}
		}
	}
	if(selprdcode == ""){
		alert("수정할 상품을 선택하지 않았습니다.");
		return;
	}else{
		document.location = "prd_save.php?mode=change&page=<?=$page?>&<?=$param?>&selprdcode=" + selprdcode + "&selprior=" + selprior;
	}
	return;
}

function list_rows_change(){
	var sellist="";
	sellist = document.getElementById("sel_list_rows").value;
	document.location = "prd_list.php?&page=1&<?=$param?>&list_rows="+sellist;
}

// 카테고리 변경
function catChange(form, idx){
   if(idx == "1"){
      form.dep2_code.options[0].selected = true;
      form.dep3_code.options[0].selected = true;
   }else if(idx == "2"){
      form.dep3_code.options[0].selected = true;
   }
   	form.page.value = 1;
   	form.submit();
}

// 상품복사
function prdCopy(prdcode){
	if(confirm("동일한 상품을 하나더 자동등록합니다.")){
		document.location = "prd_save.php?mode=prdcopy&prdcode=" + prdcode;
	}
}

// 상품정보 엑셀다운
function excelDown(){
	var url = "prd_excel.php?<?=$param?>";
	window.open(url,"excelDown","height=330, width=560, menubar=no, scrollbars=no, resizable=yes, toolbar=no, status=no, top=100, left=100");
}

// 상품정보 엑셀입력
function excelUp() {
	var url = "prd_excel_up.php";
	window.open(url,"excelUp","height=600, width=650, menubar=no, scrollbars=yes, resizable=yes, toolbar=no, status=no, top=100, left=100");
}

// 재고여부
function chgShortage(frm) {

	frm.page.value = 1;

	if(frm.shortage.value == "S") {
		frm.stock.disabled = false;
		frm.stock.focus();
	} else {
		frm.stock.disabled = true;
		frm.submit();
	}

}

// 체크박스 선택리스트
function selectValue(){
	var i;
	var selvalue = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].prdcode != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked)
					selvalue = selvalue + document.forms[i].prdcode.value + "|";
				}
			}
	}
	return selvalue;
}

//상품이동
function movePrd(){
	selvalue = selectValue();

	if(selvalue == ""){
		alert("이동할 상품을 선택하세요.");
		return false;
	}else{
		document.postForm.selvalue.value = selvalue;
		document.postForm.submit();
		// var uri = "prd_move.php?selvalue=" + ;
		// window.open(uri,"movePrd","width=450,height=150");
	}
}

// 상품복사
function copyPrd(){
	selvalue = selectValue();
	if(selvalue == ""){
		alert("복사할 상품을 선택하세요.");
		return false;
	}else{
		var uri = "prd_copy.php?selvalue=" + selvalue;
		window.open(uri,"copyPrd","width=450,height=150,resizable=yes");
	}
}

<? if($site_info["naver_ep"] == "Y"){ ?>
// 네이버 지식쇼핑
function nhnEnginePage(obj){

	var nhnurl;
	if(obj.id == "nhnAll") nhnurl = "/adm/nhn/nhn_ep_all.php";
	if(obj.id == "nhnMin") nhnurl = "/adm/nhn/nhn_ep_min.php";

	var selvalue = selectValue();
	if(obj.id == "nhnMin" && selvalue == ""){
		alert("업데이트 할 상품이 선택되지 않았습니다.");
		return;
	}

	$.ajax({
		url  : nhnurl,
		type : "post",
		data : {
			"selvalue" : selvalue
		},
		success : function(data){
			alert(data);
		}
	});
}
<? } ?>

//-->
</script>

<div id="location">HOME > 상품관리</div>
<div id="S_contents">
<h3>상품목록<span>전체상품 목록 및 검색합니다.</span></h3>
	<form name="postForm" action="prd_move.php" method="post">
		<input type="hidden" name="selvalue">
	</form>

      <form name="searchForm" action="<?=$PHP_SELF?>" method="get">
      <input type="hidden" name="page" value="<?=$page?>">
	  <table width="100%" cellspacing="0" cellpadding="0" border="0" class="table_basic">
        <tr>
          <th width="15%">상품분류</th>
          <td width="85%" colspan="3">
          	<select name="dep_code" onChange="catChange(this.form,'1');" class="select">
          	<option value=''>:: 대분류 ::</option>
						<?
						$sql = "select substring(catcode,1,3) as catcode, catname from wiz_category where depthno = 1 order by priorno01 asc";
						$result = mysql_query($sql) or error(mysql_error());
						while($row = mysql_fetch_object($result)){
						  if($row->catcode == $dep_code)
						     echo "<option value='$row->catcode' selected>$row->catname</option>";
						  else
						     echo "<option value='$row->catcode'>$row->catname</option>";
						}
						?>
          	</select>
          	<select name="dep2_code" onChange="catChange(this.form,'2');" class="select">
          	<option value=''>:: 중분류 ::</option>
						<?
						if($dep_code != ''){
						   $sql = "select substring(catcode,4,3) as catcode, catname from wiz_category where depthno = 2 and catcode like '$dep_code%' order by priorno02 asc";
						   $result = mysql_query($sql) or error(mysql_error());
						   while($row = mysql_fetch_object($result)){
						      if($row->catcode == $dep2_code)
						         echo "<option value='$row->catcode' selected>$row->catname</option>";
						      else
						         echo "<option value='$row->catcode'>$row->catname</option>";
						   }
						}
						?>
          	</select>
          	<select name="dep3_code" onChange="catChange(this.form,'3');" class="select">
          	<option value=''>:: 소분류 ::</option>
		        <?
		        if($dep_code != '' && $dep2_code != ''){
		           $sql = "select substring(catcode,7,3) as catcode, catname from wiz_category where depthno = 3 and catcode like '$dep_code$dep2_code%' order by  priorno03 asc";
		           $result = mysql_query($sql) or error(mysql_error());
		           while($row = mysql_fetch_object($result)){
		              if($row->catcode == $dep3_code)
		                 echo "<option value='$row->catcode' selected>$row->catname</option>";
		              else
		                 echo "<option value='$row->catcode'>$row->catname</option>";
		           }
		        }
		        ?>
          </select>
          </td>
        </tr>
        <tr>
          <th width="15%">검색조건</th>
          <td width="85%" colspan="3">
            <select name="searchopt" onChange="this.form.page.value=1;">
            <option value="prdname" <? if($searchopt == "prdname") echo "selected"; ?>>상품명</option>
            <option value="prdcode" <? if($searchopt == "prdcode") echo "selected"; ?>>상품코드</option>
            <option value="prdcom" <? if($searchopt == "prdcom") echo "selected"; ?>>제조사</option>
            </select>
            <input type="text" size="25" name="searchkey" value="<?=$searchkey?>" class="input">
          </td>
          <th width="15%" style="display:none;">쿠폰적용</th>
          <td width="35%" style="display:none;">
          	<select name="coupon_use" onChange="this.form.page.value=1;this.form.submit();">
            <option value="">:: 선택 ::
            <option value="Y" <? if($coupon_use == "Y") echo "selected"; ?>>예
            <option value="N" <? if($coupon_use == "N") echo "selected"; ?>>아니오
            </select>
          </td>
        </tr>
        <tr>
          <th>재고여부</th>
          <td>
            <select name="shortage" onChange="chgShortage(this.form)">
            <option value="">:: 재고여부 ::</option>
            <option value="Y" <? if($shortage == "Y") echo "selected"; ?>>품절상품</option>
            <option value="N" <? if($shortage == "N") echo "selected"; ?>>무제한</option>
            <option value="S" <? if($shortage == "S") echo "selected"; ?>>수량</option>
            </select>
            <input type="text" size="5" name="stock" value="<?=$stock?>" class="input" <? if($shortage != "S") echo "disabled" ?> /> <font class="posi_r top_p_4">개 이하</font>
          </td>
          <th>진열여부</th>
          <td>
            <select name="display" onChange="this.form.page.value=1;this.form.submit();">
            <option value="">:: 선택 ::</option>
            <option value="Y" <? if($display == "Y") echo "selected"; ?>>진열함</option>
            <option value="N" <? if($display == "N") echo "selected"; ?>>진열안함</option>
            </select>
          </td>
        </tr>
        <tr>
          <th>그룹</th>
          <td>
            <select name="special" onChange="this.form.page.value=1;this.form.submit();">
            <option value="">:: 그룹선택 ::</option>
            <option value="new" <? if($special == "new") echo "selected"; ?>>신상품</option>
            <option value="best" <? if($special == "best") echo "selected"; ?>>베스트상품</option>
            <option value="popular" <? if($special == "popular") echo "selected"; ?>>인기상품</option>
            <option value="recom" <? if($special == "recom") echo "selected"; ?>>추천상품</option>
            <option value="sale" <? if($special == "sale") echo "selected"; ?>>세일상품</option>
            </select>
            <button type="submit" style="height:22px" class="b h28 t5 color blue_big">검색</button>
          </td>
          <th>브랜드</th>
          <td>
          	<select name="brand" onChange="this.form.page.value=1;this.form.submit();">
          	<option value="">:: 브랜드선택 ::</option>
          	<?
          	$sql = "select idx, brdname from wiz_brand where brduse != 'N' order by priorno asc";
          	$result = mysql_query($sql) or error(mysql_error());
          	while($row = mysql_fetch_array($result)) {
          	?>
          	<option value="<?=$row[idx]?>" <? if($brand == $row[idx]) echo "selected"; ?>><?=$row[brdname]?></option>
          	<?
          	}
          	?>
          </td>
        </tr>
				<? if($site_info[naver_ep] == "Y"){ ?>
				<tr>
					<th>네이버 지식쇼핑</th>
					<td colspan="3">
						<button id="nhnAll" type="button" onclick="nhnEnginePage(this);" style="background: #666; color: #fff; border-radius: 4px; border: 4px solid #666;">전체상품 업데이트</button>
						<button id="nhnMin" type="button" onclick="nhnEnginePage(this);" style="background: #666; color: #fff; border-radius: 4px; border: 4px solid #666;">요약상품 업데이트</button>
					</td>
				</tr>
				<? } ?>
      </table>
	  </form>

      <br>

      <?
			$sql = "select prdcode from wiz_product";
			$result = mysql_query($sql) or error(mysql_error());
			$all_total = mysql_num_rows($result);

			if(!empty($dep_code)) $catcode_sql = "wc.catcode like '$dep_code$dep2_code$dep3_code%' and ";
			if(!empty($special)) $special_sql = "wp.$special = 'Y' and ";
			if(!empty($display)) $display_sql = "wp.showset = '$display' and ";
			if(!empty($searchopt)) $search_sql = "wp.$searchopt like '%$searchkey%' and ";
			if(!empty($coupon_use)) $coupon_sql = "wp.coupon_use = '$coupon_use' and ";
			if(!empty($brand)) $brand_sql = "wp.brand = '$brand' and ";
			if(!empty($shortage)) {
				if(!strcmp($shortage, "N")) $shortage_sql = " (wp.shortage = '$shortage' or wp.shortage = '') and ";
				else $shortage_sql = " wp.shortage = '$shortage' and ";
			}
			if(!strcmp($shortage, "S")) $stock_sql = " wp.stock <= '$stock' and ";

			$sql = "select distinct wp.prdcode from wiz_product wp, wiz_cprelation wc
			              where $catcode_sql $special_sql $display_sql $search_sql $coupon_sql $brand_sql $shortage_sql $stock_sql wc.prdcode = wp.prdcode order by wp.prior, wp.prdcode desc";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);

			// $rows = 16;
			if($list_rows == ""){
				$rows = 30;
			}else{
				$rows = $list_rows;
			}
			$lists = 5;
			$page_count = ceil($total/$rows);
			if(!$page || $page > $page_count) $page = 1;
			$start = ($page-1)*$rows;
			$no = $total-$start;
      ?>
      <table name="list_table" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td>
						총 상품수 : <b><?=$all_total?></b> , 검색 상품수 : <b><?=$total?></b> , 리스트 출력수
						<select id="sel_list_rows" name="sel_list_rows" onChange="list_rows_change();">
							<option value="30"  <? if($list_rows == "30") echo selected?>>30개</option>
							<option value="50"  <? if($list_rows == "50") echo selected?>>50개</option>
							<option value="100" <? if($list_rows == "100") echo selected?>>100개</option>
							<option value="150" <? if($list_rows == "150") echo selected?>>150개</option>
							<option value="200" <? if($list_rows == "200") echo selected?>>200개</option>
							<option value="10000" <? if($list_rows == "10000") echo selected?>>10000개</option>
						</select>
					</td>
          <td align="right">
					  <!-- <button type="button" class="h22 t4 small icon gray" onClick="excelUp();"><span class="icon_exel"></span>엑셀상품등록</button>
					  <button type="button" class="h22 t4 small icon gray" onClick="excelDown();"><span class="icon_exel"></span>엑셀파일저장</button> -->
					  <button type="button" class="h22 t4 small icon gray" onClick="document.location='prd_input.php?<?=$param?>'"><span class="icon_plus"></span>상품등록</button>
          </td>
        </tr>
				<tr>
					<td height="3"></td>
				</tr>
      </table>

      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list bbs_prd_list">
				<thead>
					<tr>
						<td width="5%">
							<form>
								<input type="checkbox" name="select_tmp" onClick="onSelect(this)">
							</td>
							<td width="10%">상품코드</td>
							<td width="5%"></td>
							<td width="30%">상품명</td>
							<td width="10%">상품가격</td>
							<td width="10%">재고</td>
							<td width="10%">진열순서</td>
							<td width="15%">
								기능
							</form>
						</td>
					</tr>
				</thead>
				<tbody>
					<?
					$sql = "select distinct wp.prdcode, wp.prdimg_R, wp.prdname, wp.sellprice, wp.prior, wp.stock from wiz_product wp, wiz_cprelation wc
					where $catcode_sql $special_sql $display_sql $search_sql $coupon_sql $brand_sql $shortage_sql $stock_sql wc.prdcode = wp.prdcode order by wp.prior asc, wp.prdcode desc limit $start, $rows";
					$result = mysql_query($sql) or error(mysql_error());

					while(($row = mysql_fetch_object($result)) && $rows){

						// 상품 이미지
						if(!@file($_SERVER[DOCUMENT_ROOT]."/adm/data/prdimg/".$row->prdimg_R)) $row->prdimg_R = "/adm/images/noimg_R.gif";
						else $row->prdimg_R = "/adm/data/prdimg/".$row->prdimg_R;

						?>
						<tr>
							<td colspan="8">
								<form name="<?=$row->prdcode?>" action="product_save.php" onSubmit="return false;">
									<input type="hidden" name="prdcode" value="<?=$row->prdcode?>">
									<table width="100%" cellspacing="0" cellpadding="0">
										<tr>
											<td width="5%" align="center" height="52">
												<input type="checkbox" name="select_checkbox">
											</td>
											<td width="10%" align="center"><a href="prd_input.php?mode=update&prdcode=<?=$row->prdcode?>&page=<?=$page?>&<?=$param?>"><?=$row->prdcode?></a></td>
											<td width="5%" ><a href="prd_input.php?mode=update&prdcode=<?=$row->prdcode?>&page=<?=$page?>&<?=$param?>"><img class="bbs_prd_img" src="<?=$row->prdimg_R?>"></a></td>
											<td width="30%"><a href="prd_input.php?mode=update&prdcode=<?=$row->prdcode?>&page=<?=$page?>&<?=$param?>"><?=$row->prdname?></a></td>
											<td width="10%" align="right"><?=number_format($row->sellprice)?>원</td>
											<td width="10%" align="center"><?=$row->stock?></td>
											<td width="10%" style="" align="center">
												<div class="prd_updown_wrap">

													<input type="number" name="prior_num" value="<?=$row->prior?>" style="width:80px;">

												</div>
											</td>
											<td width="15%" align="center">
												<button type="button" class="h18 t3 color small round red_s" onclick="document.location='prd_input.php?mode=update&prdcode=<?=$row->prdcode?>&page=<?=$page?>&<?=$param?>'">수정</button>
												<button type="button" class="h18 t3 color small round black_s" onclick="selectEmpty();this.form.select_checkbox.checked=true;prdDelete('<?=$row->prdcode?>');">삭제</button>
												<button type="button" class="h18 t3 color small round black_s" onclick="prdCopy('<?=$row->prdcode?>');">복사</button>
											</td>
										</tr>
									</table>
								</form>
							</td>
						</tr>

						<?
						$no--;
						$rows--;
					}
					if($total <= 0){
						?>
						<tr><td  colspan="7">등록된 상품이 없습니다.</td></tr>

						<?
					}
					?>
				</tbody>
      </table>

      <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
      	<tr><td height="5"></td></tr>
        <tr>
          <td width="33%">
			<button type="button" class="h22 t4 small icon gray" onClick="prdDelete();"><span class="icon_plus"></span>선택삭제</button>
			<button type="button" class="h22 t4 small icon gray" onClick="prdChange();"><span class="icon_plus"></span>선택수정</button>
			<button type="button" class="h22 t4 small icon gray" onClick="movePrd();"><span class="icon_plus"></span>상품이동</button>
			<button type="button" class="h22 t4 small icon gray" onClick="copyPrd();"><span class="icon_plus"></span>상품복사</button>
          </td>
          <td width="33%"><? print_pagelist($page, $lists, $page_count, "&$param"); ?></td>
          <td width="33%"></td>
        </tr>
      </table>

<? include "../foot.php"; ?>
