<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include "../head.php"; ?>
<?
// 페이지 파라메터 (검색조건이 변하지 않도록)
//--------------------------------------------------------------------------------------------------
$param = "searchopt=$searchopt&keyword=$keyword";
//--------------------------------------------------------------------------------------------------

$code = "review";
include "../../inc/bbs_info.php";
?>

<script language="JavaScript" type="text/javascript">
<!--

//체크박스선택 반전
function onSelect(form){
	if(form.select_tmp.checked){
		selectAll();
	}
	else{
		selectEmpty();
	}
}

//체크박스 전체선택
function selectAll(){

	var i;

	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].estiidx != null){
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
		if(document.forms[i].select_checkbox){
			if(document.forms[i].estiidx != null){
				document.forms[i].select_checkbox.checked = false;
			}
		}
	}
	return;
}

//선택상품 삭제
function delSelEstimate(){

	var i;
	var selected = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].estiidx != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked)
					selected = selected + document.forms[i].estiidx.value + "|";
			}
		}
	}

	if(selected == ""){
		alert("삭제할 상품평을 선택하지 않았습니다.");
		return;
	}
	else{
		if(confirm("선택한 상품을 정말 삭제하시겠습니까?")){
			document.location = "prd_save.php?mode=delesti&page=<?=$page?>&selected=" + selected;
			return;
		}
		else{
			return;
		}
	}
	return;

}

function delEstimate(idx){
	if(confirm('상품평을 삭제하시겠습니까?')){
		document.location = "prd_save.php?mode=delesti&page=<?=$page?>&estiidx=" + idx;
	}
}

function searchEstimate(searchopt,keyword){
	document.searchForm.searchopt.value = searchopt;
	document.searchForm.keyword.value = keyword;
	document.searchForm.page.value = "1";
	document.searchForm.submit();
}

var clickvalue='';
var clickvalue_cut='';
function reviewShow(idnum) {

	review=eval("review"+idnum+".style");
	review_cut=eval("review"+idnum+"_cut.style");

	if(clickvalue != review) {
		if(clickvalue!='') {
			clickvalue.display='none';
			clickvalue_cut.display='block';
		}

		review.display='block';
		review_cut.display='none';
		clickvalue=review;
		clickvalue_cut=review_cut;
	}
	else {
		review.display='none';
		review_cut.display='block';
		clickvalue='';
		clickvalue_cut='';
	}

}

function openImg(img){
	var url = "../bbs/bbs_openimg.php?code=<?=$code?>&img=" + img;
	window.open(url,"openImg","width=300,height=300,scrollbars=yes");
}
//-->
</script>


<div id="location">HOME > 상품관리</div>
<div id="S_contents">
	<h3>상품평관리<span>상품평을 관리합니다.</span></h3>

	<?
	$sql = "select wb.idx from wiz_bbs as wb left join wiz_product as wp on wb.prdcode = wp.prdcode
	where wb.code='$code' and wb.prdcode != ''";
	$result = mysql_query($sql) or error(mysql_error());
	$all_total = mysql_num_rows($result);

	if(empty($searchopt)){
		$search_sql = "";
	}
	else{
		if($searchopt == "prdcode" || $searchopt == "prdname") $search_sql = " and wp.$searchopt like '%$keyword%' ";
		else $search_sql = " and wb.$searchopt like '%$keyword%' ";
	}

	$sql = "select wb.idx
	from wiz_bbs as wb left join wiz_product as wp on wb.prdcode = wp.prdcode
	left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode
	left join wiz_category as wc on wcp.catcode = wc.catcode
	where wb.code = '$code' $search_sql
	order by wb.wdate desc";
	$result = mysql_query($sql) or error(mysql_error());
	$total = mysql_num_rows($result);

	$rows = 20;
	$lists = 5;

	$page_count = ceil($total/$rows);
	if(!$page || $page > $page_count) $page = 1;
	$start = ($page-1)*$rows;
	$no = $total-$start;
	?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td>총 상품평수 : <b><?=$all_total?></b> , 검색 상품평수 : <b><?=$total?></b></td>
		<td align="right">
			<form name="searchForm" action="<?=$PHP_SELF?>" method="get">
			<input type="hidden" name="page" value="<?=$page?>">
			<table cellspacing="2" cellpadding="0" border="0">
			<tr>
				<td>
					<select name="searchopt" onChange="this.form.page.value=1;">
					<option value="">:: 선택 ::</option>
					<option value="content" <? if($searchopt == "content") echo "selected"; ?>>내용</option>
					<option value="subject" <? if($searchopt == "subject") echo "selected"; ?>>제목</option>
					<option value="name" <? if($searchopt == "name") echo "selected"; ?>>글쓴이</option>
					<option value="memid" <? if($searchopt == "memid") echo "selected"; ?>>아이디</option>
					<option value="prdcode" <? if($searchopt == "prdcode") echo "selected"; ?>>상품코드</option>
					<option value="prdname" <? if($searchopt == "prdname") echo "selected"; ?>>상품명</option>
					</select>
				</td>
				<td><input type="text" name="keyword" value="<?=$keyword?>" size="13" class="input"></td>
				<td><button type="submit" style="height:22px" class="b h28 t5 color blue_big">검색</button></td>
			</tr>
			</table>
			</form>
		</td>
	</tr>
	</table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list">
	<form>
	<thead>
	<tr>
		<td width="5%"><input type="checkbox" name="select_tmp" onClick="onSelect(this.form)"></td>
		<td width="5%">번호</td>
		<td width="10%">상품</td>
		<td>상품평</td>
		<td width="10%">선호도</td>
		<td width="10%">글쓴이</td>
		<td width="10%">작성일</td>
		<td width="10%">기능</td>
	</tr>
	</thead>
	<tbody>
	</form>
	<?
	$sql = "select wb.*, from_unixtime(wb.wdate) as wdate, wp.prdimg_R, wp.prdname, wc.purl
	from wiz_bbs as wb left join wiz_product as wp on wb.prdcode = wp.prdcode
	left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode
	left join wiz_category as wc on wcp.catcode = wc.catcode
	where wb.code = '$code' $search_sql
	order by wb.wdate desc limit $start, $rows";
	$result = mysql_query($sql) or error(mysql_error());

	while(($row = mysql_fetch_object($result)) && $rows){

		$review_display = "none";

		if($row->prdimg_R == "") $row->prdimg_R = "/adm/images/noimage.gif";
		else $row->prdimg_R = "/adm/data/prdimg/$row->prdimg_R";

		$subject = "<a href=\"javascript:reviewShow('$no');\">$row->subject</a>";

		if($row->ctype != "H")  $row->content = str_replace("\n", "<br>", $row->content);

		$cut_content = cut_str(strip_tags($row->content), 100);

		for($ii = 1; $ii <= $upfile_max; $ii++) {
			if(img_type($DOCUMENT_ROOT."/data/bbs/$code/M".$row->{upfile.$ii})) ${
				upimg.$ii}
			= "<div align='".$bbs_info[img_align]."'><a href=javascript:openImg('".$row->{
				upfile.$ii}
			."');><img src='/data/bbs/$code/M".$row->{
				upfile.$ii}
			."' border='0'></a></div>";
			else ${
				upimg.$ii}
			= "";
		}
	?>
	<form name="<?=$row->prdcode?>" action="product_save.php">
	<input type="hidden" name="estiidx" value="<?=$row->idx?>">
	<tr>
		<td align="center"><input type="checkbox" name="select_checkbox"></td>
		<td height="30" align="center"><?=$no?></td>
		<td align="center">

			<a href="/<?=$row->purl?>?ptype=view&prdcode=<?=$row->prdcode?>" target="_blank"><img src="<?=$row->prdimg_R?>" width="50" height="50" border="0"></a><br>
			<a href="javascript:searchEstimate('prdcode','<?=$row->prdcode?>');" class="3">검색</a>
		</td>
		<td valign="top" style="padding:3 0 3 0">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="layout:fixed;">
			<tr><td style="padding:3px"><b><?=$subject?></b></td></tr>
			<tr id="review<?=$no?>_cut" style="word-break:break-all;"><td style="padding:3px"><?=$cut_content?></td></tr>
			<tr id="review<?=$no?>" style="display:<?=$review_display?>;word-break:break-all;"><td style="padding:3px"><? for($ii = 1; $ii <= $upfile_max; $ii++) echo ${upimg.$ii} ?><?=$row->content?></td></tr>
			</table>
		</td>
		<td><img src="/adm/images/icon_star_<?=$row->star?>.gif"></td>
		<td align="center"><a href="javascript:searchEstimate('name','<?=$row->name?>');" class="3"><?=$row->name?></a><br>(<? if($row->memid=="") echo "비회원"; else echo "<a href=javascript:searchEstimate('memid','$row->memid');>$row->memid</a>"; ?>)</td>
		<td align="center"><?=$row->wdate?></td>
		<td align="center"><button type="button" class="h18 t3 color small round red_s" onclick="delEstimate('<?=$row->idx?>');">삭제</button></td>
	</tr>
	</form>
	<?
		$no--;
		$rows--;
	}

	if($total <= 0){
	?>
	<tr><td height='30' colspan=7 align=center>등록된 상품평이 없습니다.</td></tr>
	<?
	}
	?>
	</tbody>
	</table>

	<table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
	<tr><td height="5"></td></tr>
	<tr>
		<td width="33%">
			<button type="button" class="h22 t4 small icon gray" onClick="delSelEstimate();"><span class="icon_plus"></span>선택삭제</button>
		</td>
		<td width="33%"><? print_pagelist($page, $lists, $page_count, "&$param"); ?></td>
		<td width="33%"></td>
	</tr>
	</table>

	<div class="graybox top50">
		<p class="question">궁금증 해결!</p>
		<div class="top10 font11 line2 colorgray">
			- 상품평 제목을 클릭하면 전체 내용을 볼 수 있습니다.<br>
		</div>
	</div>



<? include "../foot.php"; ?>
