<?
$sql = "select * from wiz_prdinfo";
$result = mysql_query($sql) or error(mysql_error());
$prd_info = mysql_fetch_array($result);

// 스킨위치
// $skin_dir = "/adm/product/skin/".$prd_info[skin];
$skin_dir = "/adm/product/";

$prdimg_max = 8; // 상품사진 : 최대12까지가능
$prdfile_max = 8; // 첨부파일 : 최대5까지가능
?>
