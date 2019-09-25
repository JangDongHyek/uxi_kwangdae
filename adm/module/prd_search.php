<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";
// 스킨위치
$skin_dir = "/adm/search/skin/".$site_info[search_skin];

$sql = "select search_url from wiz_prdinfo";
$result = mysql_query($sql) or error(mysql_error());
$row = mysql_fetch_array($result);
$purl = "/".$row[search_url];
?>
<script Language="Javascript">
<!--
function prdSearchCheck() {
	var searchInput = document.getElementById('search_input');
	if(searchInput.value === ''){
		alert('검색어를 입력해주세요.');
		return false;
	}
	<? if(empty($row[search_url])) {
		?>
		alert("상품검색 페이지가 설정되지 않았습니다.");
		return false;
		<? }
	else {
		?>
		return true;
		<? }
	?>
}
-->
</script>
<form action="<?=$purl?>" style="display:inline;" onSubmit="return prdSearchCheck()">
	<div id="hsearch-wrap">
		<div id="hsearch-area">
			<input type="hidden" name="searchopt" value="prdname">
			<input id="search_input" name="searchkey" value="<?=$searchkey?>" type="text" placeholder="상품 검색">
		</div>
		<div id="hsearch-btn">
			<button class="search_btn btn-search" type="submit">
				<span></span>
			</button>
		</div>
	</div>
</form>
