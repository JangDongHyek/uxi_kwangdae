<?
$sql = "select * from wiz_siteinfo";
$result = mysql_query($sql) or error(mysql_error());
$site_info = mysql_fetch_array($result);

if(!strcmp($site_info[ssl_use], "Y")) {
	$ssl = "https://".$_SERVER[HTTP_HOST];
	if(!empty($site_info[ssl_port])) $ssl .= ":".$site_info[ssl_port];
} else {
	$hide_ssl_start = "<!--"; $hide_ssl_end = "-->";
}
$icon_size = 25;

// 도로명주소 관련 변수
$site_info['zipcode_key']	= "5C38658E5EBBDFC5AD88D24EC7D80449";	// API키
$site_info['zipcode_url']	= "ws.didim365.com";									// API주소
$site_info['zipcode_enc']	= "utf-8";														// 인코딩 :  utf-8
$site_info['zipcode_dr']	= "t";																// 도로명주소 포함여부 : t(포함), f(포함안함)
$site_info['zipcode_jb']	= "t";																// 지번주소 포함여부 : t(포함), f(포함안함)
$site_info['zipcode_de']	= "f";																// 도로명영어주소 포함여부 : t(포함), f(포함안함)
$site_info['zipcode_bn']	= "f";																// 대량배달/건물명 포함여부 : t(포함), f(포함안함)
$site_info['zipcode_sp']	= "f";																// 건물번호/지번 제외여부 : t(포함), f(포함안함)
?>
