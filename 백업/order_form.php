<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";

echo "<link href=\"".$skin_dir."style.css\" rel=\"stylesheet\" type=\"text/css\">";

if(!empty($wiz_session[id])) {

	$sql = "select * from wiz_member where id = '$wiz_session[id]'";
	$result = mysql_query($sql) or error(mysql_error());
	$mem_info = mysql_fetch_array($result);

	$mem_tphone = explode("-", $mem_info[tphone]);
	$mem_hphone = explode("-", $mem_info[hphone]);
	$mem_fax = explode("-", $mem_info[fax]);
	$mem_post = explode("-", $mem_info[post]);

	$mem_com_post = explode("-", $mem_info[com_post]);

	$mem_birthday = explode("-", $mem_info[birthday]);
	$mem_memorial = explode("-", $mem_info[memorial]);
}

// 회원적립금 가져오기
if($oper_info[reserve_use] == "Y" && $wiz_session[id] != ""){

	$sql = "select sum(reserve) as reserve from wiz_reserve where memid = '$wiz_session[id]'";
	$result = mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_array($result);
	if($row[reserve] == "") $mem_info[reserve] = 0;
	else $mem_info[reserve] = $row[reserve];

}
else{
	$mem_info[reserve] = 0;
}
?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script language="JavaScript" src="/adm/js/lib.js"></script>
<script language="JavaScript">
<!--
function sameCheck(frm){

	if(frm.same_check.checked == true){
		frm.rece_name.value = frm.send_name.value;

		frm.rece_tphone.value = frm.send_tphone.value;
		frm.rece_tphone2.value = frm.send_tphone2.value;
		frm.rece_tphone3.value = frm.send_tphone3.value;

		frm.rece_hphone.value = frm.send_hphone.value;
		frm.rece_hphone2.value = frm.send_hphone2.value;
		frm.rece_hphone3.value = frm.send_hphone3.value;

		frm.rece_post1.value = frm.send_post1.value;

		frm.rece_address1.value = frm.send_address1.value;
		frm.rece_address2.value = frm.send_address2.value;

	}
	else{

		frm.rece_name.value = "";
		frm.rece_tphone.value = "";
		frm.rece_tphone2.value = "";
		frm.rece_tphone3.value = "";
		frm.rece_hphone.value = "";
		frm.rece_hphone2.value = "";
		frm.rece_hphone3.value = "";
		frm.rece_post1.value = "";

		frm.rece_address1.value = "";
		frm.rece_address2.value = "";

	}

}

function inputCheck(frm){

	if(!selidx) {
		alert("주문할 상품을 선택하세요.");
		return false;
	}

	if(!frm.basket_exist.value) {
		alert("주문할 상품이 없습니다.");
		return false;
	}

	if(frm.send_name.value == ""){
		alert("고객 성명을 입력하세요");
		frm.send_name.focus();
		return false;
	}
	else{
		if(!check_nonChar(frm.send_name.value)){
			alert("고객 성명에는 특수문자가 들어갈 수 없습니다");
			frm.send_name.focus();
			return false;
		}
	}

	if(frm.send_tphone.value == ""){
		alert("고객 전화번호를 입력하세요.");
		frm.send_tphone.focus();
		return false;
	}
	else if(!check_Num(frm.send_tphone.value)){
		alert("지역번호는 숫자만 가능합니다.");
		frm.send_tphone.focus();
		return false;
	}

	if(frm.send_tphone2.value == ""){
		alert("고객 전화번호를 입력하세요.");
		frm.send_tphone2.focus();
		return false;
	}
	else if(!check_Num(frm.send_tphone2.value)){
		alert("국번은 숫자만 가능합니다.");
		frm.send_tphone2.focus();
		return false;
	}

	if(frm.send_tphone3.value == ""){
		alert("고객 전화번호를 입력하세요.");
		frm.send_tphone3.focus();
		return false;
	}
	else if(!check_Num(frm.send_tphone3.value)){
		alert("전화번호는 숫자만 가능합니다.");
		frm.send_tphone3.focus();
		return false;
	}


	if(frm.send_email.value == ""){
		alert("고객 이메일을 입력하세요.");
		frm.send_email.focus();
		return false;
	}
	else if(!check_Email(frm.send_email.value)){
		return false;
	}

	if(frm.send_address1.value == ""){
		alert("주문하시는분 주소를 입력하세요");
		frm.send_address1.focus();
		return false;
	}
	if(frm.send_address2.value == ""){
		alert("주문하시는분 상세주소를 입력하세요");
		frm.send_address2.focus();
		return false;
	}

	if(frm.rece_name.value == ""){
		alert("받으시는분 성명을 입력하세요");
		frm.rece_name.focus();
		return false;
	}
	else{
		if(!check_nonChar(frm.rece_name.value)){
			alert("받으시는분 성명에는 특수문자가 들어갈 수 없습니다");
			frm.rece_name.focus();
			return false;
		}
	}

	if(frm.rece_tphone.value == ""){
		alert("받으시는분 전화번호를 입력하세요.");
		frm.rece_tphone.focus();
		return false;
	}
	else if(!check_Num(frm.rece_tphone.value)){
		alert("지역번호는 숫자만 가능합니다.");
		frm.rece_tphone.focus();
		return false;
	}

	if(frm.rece_tphone2.value == ""){
		alert("받으시는분 전화번호를 입력하세요.");
		frm.rece_tphone2.focus();
		return false;
	}
	else if(!check_Num(frm.rece_tphone2.value)){
		alert("국번은 숫자만 가능합니다.");
		frm.rece_tphone2.focus();
		return false;
	}

	if(frm.rece_tphone3.value == ""){
		alert("받으시는분 전화번호를 입력하세요.");
		frm.rece_tphone3.focus();
		return false;
	}
	else if(!check_Num(frm.rece_tphone3.value)){
		alert("전화번호는 숫자만 가능합니다.");
		frm.rece_tphone3.focus();
		return false;
	}

	if(frm.rece_address1.value == ""){
		alert("받으시는분 주소를 입력하세요");
		frm.rece_address1.focus();
		return false;
	}

	if(frm.rece_address2.value == ""){
		alert("받으시는분 상세주소를 입력하세요");
		frm.rece_address2.focus();
		return false;
	}

	var pay_checked = false;
	var pay_checked_val = "";
	for(ii=0;ii<frm.pay_method.length;ii++){
		if(frm.pay_method[ii].checked == true){
			pay_checked = true;
			pay_checked_val = frm.pay_method[ii].value;
		}
	}

	if(pay_checked == false){
		alert("결제방법을 선택하세요");
		return false;
	}

	<? if(!strcmp($oper_info[tax_use], "Y")) {?>

		if(pay_checked_val == "PC" && frm.tax_type[0].checked != true) {
			alert("신용카드 결제 시 세금계산서 및 현금영수증 발급이 불가능합니다.");
			frm.tax_type[0].checked = true;
			qclick("");
			return false;
		}

		// 세금계산서
		if(frm.tax_type[1].checked == true) {

			if(frm.com_num.value == ""){
				alert("사업자 번호를 입력하세요");
				frm.com_num.focus();
				return false;
			}
			if(frm.com_name.value == ""){
				alert("상호를 입력하세요");
				frm.com_name.focus();
				return false;
			}
			if(frm.com_owner.value == ""){
				alert("대표자를 입력하세요");
				frm.com_owner.focus();
				return false;
			}
			if(frm.com_address.value == ""){
				alert("사업장 소재지를 입력하세요");
				frm.com_address.focus();
				return false;
			}
			if(frm.com_kind.value == ""){
				alert("업태를 입력하세요");
				frm.com_kind.focus();
				return false;
			}
			if(frm.com_class.value == ""){
				alert("종목을 입력하세요");
				frm.com_class.focus();
				return false;
			}
			if(frm.com_tel.value == ""){
				alert("전화번호를 입력하세요");
				frm.com_tel.focus();
				return false;
			}
			if(frm.com_email.value == ""){
				alert("이메일을 입력하세요");
				frm.com_email.focus();
				return false;
			}
		}

		// 현금영수증
		if(frm.tax_type[2].checked == true) {

			var cash_type_check = false;
			for(ii = 0; ii < frm.cash_type.length; ii++) {
				if(frm.cash_type[ii].checked == true) {
					cash_type_check = true;
					break;
				}
			}
			if(cash_type_check == false) {
				alert("발급사유를 선택하세요.");
				return false;
			}

			var cash_type2_check = false;
			for(ii = 0; ii < frm.cash_type2.length; ii++) {
				if(frm.cash_type2[ii].checked == true) {
					cash_type2_check = true;
					break;
				}
			}
			if(cash_type2_check == false) {
				alert("신청정보를 선택하세요.");
				return false;
			}

			for(ii = 0; ii < document.forms["frm"].elements["cash_info_arr[]"].length; ii++) {
				if(document.forms["frm"].elements["cash_info_arr[]"][ii].value == "") {
					alert("신청정보를 입력하세요.");
					document.forms["frm"].elements["cash_info_arr[]"][ii].focus();
					return false;
				}
			}

			if(frm.cash_name.value == "") {
				alert("신청자명을 입력하세요.");
				frm.cash_name.focus();
				return false;
			}
		}

		<?
	}?>
	if(!reserveUse(frm)){
		return false;
	}
}

	// 우편번호
function zipSearch(kind){
	if(kind == undefined) kind = '';
	new daum.Postcode({
		oncomplete: function(data) {
			//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
			//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
			//var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
			//document.getElementById('addr').value = addr;

			var frm;
			for(i=0;i<document.forms.length;i++){
				frm = document.forms[i];

				if(eval('frm.'+kind+'post1')){
					eval('frm.'+kind+'post1').value = data.zonecode;
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우

						eval('frm.'+kind+'address1').value = data.roadAddress;

					} else { // 사용자가 지번 주소를 선택했을 경우(J)

						eval('frm.'+kind+'address1').value = data.jibunAddress;

					}
					//eval('frm.'+kind+'address1').value = data.address;
					if(eval('frm.'+kind+'address2') != null) eval('frm.'+kind+'address2').focus();
				}

				if(eval('frm.'+kind+'address')){
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우

						eval('frm.'+kind+'address').value = data.roadAddress;

					} else { // 사용자가 지번 주소를 선택했을 경우(J)

						eval('frm.'+kind+'address').value = data.jibunAddress;

					}
					//eval('frm.'+kind+'address').value = data.address;
				}
			}
		}
	}).open();
}
// 적립금 사용
function reserveUse(frm){

	if(frm.reserve_use != null){

		var reserve_use = frm.reserve_use.value;
		var total_price = frm.total_price.value;

		if(reserve_use != ""){

			if(reserve_use != "" && !check_Num(reserve_use)){

				alert("적립금은 숫자만 가능합니다.");
				frm.reserve_use.value = "";
				frm.reserve_use.focus();
				return false;

			}
			else{

				reserve_use = eval(reserve_use);
				total_price = eval(total_price);

			}

			if(reserve_use > <?=$mem_info[reserve]?>){

				alert("사용가능액 보다 많습니다.");
				frm.reserve_use.value = "";
				frm.reserve_use.focus();
				return false;

			}
			else if(reserve_use > total_price){

				alert("주문금액 보다 많습니다.");
				frm.reserve_use.value = "";
				frm.reserve_use.focus();
				return false;

			}
			else if(reserve_use < <?=$oper_info[reserve_min]?>){

				alert("최소사용 적립금 보다 작습니다. <?=number_format($oper_info[reserve_min])?>원 이상 사용가능합니다.");
				frm.reserve_use.value = "";
				return false;

			}
			else if(reserve_use > <?=$oper_info[reserve_max]?>){

				alert("최대사용 적립금 보다 큽니다. <?=number_format($oper_info[reserve_max])?>원 이하 사용가능합니다.");
				frm.reserve_use.value = "";
				return false;

			}

		}

	}

	return true;

}

var couponWin;

// 쿠폰사용
function couponUse(){

	if(couponWin != null) couponWin.close();

	var url = "/adm/product/coupon_list.php?selidx=<?=$selidx?>";
	couponWin = window.open(url, "couponUse", "height=450, width=650, menubar=no, scrollbars=yes, resizable=no, toolbar=no, status=no, left=50, top=50");
}

function cuponClose() {

	if(couponWin != null) couponWin.close();
}

// 세금계산서발행
function qclick(idnum) {
	if(idnum == ''){
		tax01.style.display='none';
		tax02.style.display='none';
	}
	else if(idnum == '01'){
		tax01.style.display='block';
		tax02.style.display='none';
	}
	else if(idnum == '02'){
		tax01.style.display='none';
		tax02.style.display='block';
	}
}

// 현금영수증발행 - 발급사유
function qclick2(idnum) {

	var type1 = "<input type=\"radio\" name=\"cash_type2\" value=\"CARDNUM\" onclick=\"qclick3('01')\"> 현금영수증 카드번호";
	var type2 = "<input type=\"radio\" name=\"cash_type2\" value=\"COMNUM\" onclick=\"qclick3('02')\"> 사업자 등록번호";
	var type3 = "<input type=\"radio\" name=\"cash_type2\" value=\"HPHONE\" onclick=\"qclick3('03')\"> 휴대전화번호";
	var type4 = "<input type=\"radio\" name=\"cash_type2\" value=\"RESNO\" onclick=\"qclick3('04')\"> 주민등록번호";

	// 사업자 지출증빙용
	if(idnum == "01") {
		document.getElementById("cash_info01").innerHTML = type1 + " " + type2;
		// 개인소득 공제용
	}
	else if(idnum == "02") {
		document.getElementById("cash_info01").innerHTML = type1 + " " + type3 + " " + type4;
	}

	document.getElementById("cash_info02").innerHTML = "";

}

// 현금영수증발행 - 신청정보
function qclick3(idnum) {

	var cash_info01 = "<input id='p_cash1' type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"><input id='p_cash2' type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"><input id='p_cash3' type=\"password\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"><input id='p_cash4' type=\"password\" name=\"cash_info_arr[]\" size=\"7\" maxlength=\"7\" class=\"input\">";
	var cash_info02 = "<input id='p-cash-num1' type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"3\"><input id='p-cash-num2' type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"2\"><input id='p-cash-num3' type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"7\">";
	var cash_info03 = "<input id='p_cash_tel1' type=\"text\" name=\"cash_info_arr[]\" size=\"3\" maxlength=\"3\" class=\"input\"><input id='p_cash_tel2' type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\"><input id='p_cash_tel3' type=\"text\" name=\"cash_info_arr[]\" size=\"4\" maxlength=\"4\" class=\"input\">";
	var cash_info04 = "<input id='p_cash_in1' type=\"text\" name=\"cash_info_arr[]\" size=\"6\" maxlength=\"6\" class=\"input\"><input id='p_cash_in2' type=\"password\" name=\"cash_info_arr[]\" size=\"7\" maxlength=\"7\" class=\"input\">";

	var cash_info = eval("cash_info"+idnum);
	document.getElementById("cash_info02").innerHTML = cash_info;

}

var pay_method = "PB";
var tax_type = "N";
function change_method(obj){

	pay_method = obj.value;

	if(obj.value == "PC" || obj.value == "PH" ){
			tax_type = "N";
			document.frm.tax_type.selecedIndex = 0;
			document.getElementById("tax-header").style.display = "none";
			document.getElementById("tax-container").style.display = "none";
	}
	else{
		document.getElementById("tax-header").style.display = "block";
		document.getElementById("tax-container").style.display = "block";
	}

	change_tax();
}

function change_tax(obj){

	if(obj) tax_type = obj.value;

	if(tax_type == "N" && (pay_method == "PB" || pay_method == "PN" || pay_method == "PV")) {
		document.getElementById("vat").style.display = "none";
		document.getElementById("non-vat").style.display = "inline";
		document.getElementById("vat2").style.display = "none";
		document.getElementById("non-vat2").style.display = "inline";
	}
	else{
		document.getElementById("vat").style.display = "inline";
		document.getElementById("non-vat").style.display = "none";
		document.getElementById("vat2").style.display = "inline";
		document.getElementById("non-vat2").style.display = "none";
	}
}
//-->
</script>


<body onUnload="cuponClose();">

<form name="frm" action="<?=$ssl?>/adm/product/order_save.php" method="post" onSubmit="return inputCheck(this)">
	<input type="hidden" name="total_price" value="<?=$total_price?>">
	<input type="hidden" name="coupon_idx" value="">
	<input type="hidden" name="selidx" value="<?=$selidx?>">
	<input type="hidden" name="tax_type" value="N" checked onClick="qclick('');">

	<? // 주문 프로세스 이미지 ?>
	<div id="basket_process" class="mdc-card mdc-elevation-z1">
		<?
		if( $_GET["shop"] === "cat" ) $process_img = "/child/img/cart/basket-process-2-cat.png";
		else $process_img = "/child/img/cart/basket-process-2.png";
		?>
		<img src="<?=$process_img?>"/>

	</div>

	<? // 주문서 해더라인 ?>
	<div id="basket_title" class="basket_title mdc-card mdc-elevation-z1">
		<h1>주문서 작성</h1>
	</div>

	<? // 주문 상품 목록 리스트 ?>
	<div class="mdc-card mdc-elevation-z1" style="margin-top: 24px;">

		<!-- <img class="m-scroll" src="/child/img/scroll.png" alt=""> -->
		<div class="bs">
			<div class="basket-scroll">
				<div class="basket-scroll-inner">
					<? include "$_SERVER[DOCUMENT_ROOT]/adm/product/basket_listing.inc"; ?>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="basket_exist" value="<?=$basket_exist?>">

	<div class="mdc-card mdc-elevation-z1" style="display: table; width: 100%; margin-top: 24px;">

		<div class="order_left product_order_box">
			<!-- 주문자 정보 -->
			<div class="t_left head_title">
				<h3>주문자 정보</h3>
			</div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="AWorder_form_table order_box_wrap">
				<tr>
					<th>주문자</th>
					<td><input id="p_name" type=text name="send_name" value="<?=$mem_info[name]?>" class="input"></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td>
						<input id="p_phone1" type=text name="send_tphone" value="<?=$mem_tphone[0]?>" size=3 class="input"> -
						<input id="p_phone2"type=text name="send_tphone2" value="<?=$mem_tphone[1]?>" size=4 class="input"> -
						<input id="p_phone3" type=text name="send_tphone3" value="<?=$mem_tphone[2]?>" size=4 class="input">
					</td>
				</tr>
				<tr>
					<th>휴대전화번호</th>
					<td>
						<input id="p_tel1" type=text name="send_hphone" value="<?=$mem_hphone[0]?>" size=3 class="input"> -
						<input id="p_tel1" type=text name="send_hphone2" value="<?=$mem_hphone[1]?>" size=4 class="input"> -
						<input id="p_tel1" type=text name="send_hphone3" value="<?=$mem_hphone[2]?>" size=4 class="input">
					</td>
				</tr>
				<tr>
					<th>이메일</th>
					<td><input id="p_email" type=text name="send_email" value="<?=$mem_info[email]?>" size=30 class="input"></td>
				</tr>
				<tr>
					<th>주소</th>
					<td>
						<input id="p_post1" type=text name="send_post1" value="<?=$mem_post[0]?>" size=7 class="input">
						<a id="p_zipsearch1" href="javascript:zipSearch('send_');">우편번호 찾기</a>
					</td>
				</tr>
				<tr>
					<th>상세주소</th>
					<td>
						<input id="p_address1" type=text name="send_address1" value="<?=$mem_info[address1]?>" class="input" style="margin-bottom:5px;">
						<input id="p_address2" type=text name="send_address2" value="<?=$mem_info[address2]?>" class="input">
					</td>
				</tr>
			</table>

			<!-- 상품 받으실 분 -->
			<div class="t_left head_title">
				<h3 style="display:inline-block;vertical-align:bottom; margin-right: 8px;">상품 받으실 분</h3>
				<span style="display:inline-block;vertical-align:bottom;">
					<input id="sameinfo" type="checkbox" name="same_check" onClick="sameCheck(this.form);" style="margin-right:2px; vertical-align: middle;"/><label for="sameinfo" style="font-size: 14px; display: inline; vertical-align: bottom;">주문자 정보와 동일합니다.</label>
				</span>
			</div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="AWorder_form_table order_box_wrap<?=$catclass?>">
				<th>받으시는 분</th>
				<td><input id="p_name2" type=text name="rece_name" class="input"></td>
			</tr>
			<tr>
				<th>전화번호</th>
				<td>
					<input id="p_phone4" type=text name="rece_tphone" size=3 class="input"> -
					<input id="p_phone5" type=text name="rece_tphone2" size=4 class="input"> -
					<input id="p_phone6" type=text name="rece_tphone3" size=4 class="input">
				</td>
			</tr>
			<tr>
				<th>휴대전화번호</th>
				<td>
					<input id="p_tel4" type=text name="rece_hphone" size=3 class="input"> -
					<input id="p_tel5" type=text name="rece_hphone2" size=4 class="input"> -
					<input id="p_tel6" type=text name="rece_hphone3" size=4 class="input">
				</td>
			</tr>
			<tr>
				<th>주 소</th>
				<td>
					<input id="p_post2" type=text name="rece_post1" size=7 class="input">
					<a id="p_zipsearch2" href="javascript:zipSearch('rece_');">우편번호 찾기</a>
				</td>
			</tr>
			<tr>
				<th>상세주소</th>
				<td>
					<input id="p_address3" type=text name="rece_address1" class="input" style="margin-bottom:5px;">
					<input id="p_address4" type=text name="rece_address2" class="input">
				</td>
			</tr>
			<tr style="display: none;">
				<th>요청사항</th>
				<td><textarea id="p_demand" name="demand" rows="5" class="input"></textarea></td>
			</tr>
		</table>

	</div>

	<div class="order_right product_order_box">
		<? if($oper_info[reserve_use] == "Y"){ ?>
			<!-- 적립금 사용 -->
			<div class="t_left head_title">
				<h3>적립금 사용</h3>
			</div>
			<div class="mdc-card mdc-elevation-z1 order_box_wrap">
				<div style="width: 100%; font-size: 14px; text-align: center;">
					<input id="p_reserve" type="text" name="reserve_use" style="text-align:right;" size="20" class="input" onchange="reserveUse(this.form);">&nbsp;원&nbsp;
					<span class="form_sub">보유적립금 : <strong><?=number_format($mem_info[reserve])?></strong> 원</span>
				</div>
				<div style="text-align: center;">
					<span style="font-size: 12px">(적립금은 <?=number_format($oper_info[reserve_min])?>원부터 <?=number_format($oper_info[reserve_max])?>원까지 사용이 가능합니다)</span>
				</div>
			</div>
		<? } ?>


		<!-- 결제수단 -->
		<div class="t_left head_title">
			<h3>결제수단</h3>
		</div>
		<div class="order_box_wrap" style="padding: 0; font-size: 0; background: transparent;">
			<?
			$pay_method = explode("/",$oper_info[pay_method]);
			for($ii=0; $ii<count($pay_method)-1; $ii++){

				$pay_title = pay_method($pay_method[$ii]);

				if($ii == 0) $checked = "checked";
				else $checked = "";

				if($oper_info[pay_escrow] == "Y" && ($pay_method[$ii] == "PN" || $pay_method[$ii] == "PV")) $pay_title .= " (에스크로)";

				//if($oper_info[pay_escrow] == "Y" && $pay_method[$ii] == "PB" && $total_price > 100000){
				//}else{
				echo "<input type='radio' name='pay_method' id='$pay_method[$ii]' value='$pay_method[$ii]' onchange='change_method(this)' style='width:0; height:0;' $checked> &nbsp;";
				echo "<label for='$pay_method[$ii]' class='pay_method' style='display: inline-block;'>$pay_title</label>";
				//}

			}
			?>
		</div>

		<!-- 현금영수증, 세금계산서 -->
		<div id="tax-header" class="t_left head_title">
			<h3>증빙서류</h3>
		</div>
			<div id="tax-container">

				<div class="btn btn_border mdc-elevation-z1" style="width:100%;">
					<input type="radio" name="tax_type" value="N" onchange="change_tax(this)" checked onClick="qclick('');">발행안함
				</div>

				<div class="btn btn_border mdc-elevation-z1" style="width:100%; margin-top:8px;">
					<input type="radio" name="tax_type" value="T" onchange="change_tax(this)" onClick="qclick('01');">세금계산서 신청
				</div>
				<div id="tax01" style="display:none;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0" class="inner_table">
						<tr>
							<th>사업자 번호</th>
							<td colspan="3"><input type="text" name="com_num" value="<?=$mem_info[com_num]?>" class="input" size="20"></td>
						</tr>
						<tr>
							<th>상 호</th>
							<td><input type="text" name="com_name" value="<?=$mem_info[com_name]?>" class="input"></td>
						</tr>
						<tr>
							<th>대표자</th>
							<td><input type="text" name="com_owner" value="<?=$mem_info[com_owner]?>" class="input"></td>
						</tr>
						<tr>
							<th>소재지</th>
							<td colspan="3"><input type="text" name="com_address" value="<?=$mem_info[com_address]?>" class="input" size="50"></td>
						</tr>
						<tr>
							<th>업 태</th>
							<td><input type="text" name="com_kind" value="<?=$mem_info[com_kind]?>" class="input"></td>
						</tr>
						<tr>
							<th>종 목</th>
							<td><input type="text" name="com_class" value="<?=$mem_info[com_class]?>" class="input"></td>

						</tr>
						<tr>
							<th>전화번호</th>
							<td><input type="text" name="com_tel" value="<?=$mem_info[tphone]?>" class="input"></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="text" name="com_email" value="<?=$mem_info[email]?>" class="input"></td>

						</tr>
					</table>
				</div>

				<div class="btn btn_border mdc-elevation-z1" style="width:100%; margin-top:8px;">
					<input type="radio" name="tax_type" value="C" onchange="change_tax(this)" onClick="qclick('02');">현금영수증 신청
				</div>
				<div id="tax02" style="display:none;">
					<table width="100%" cellpadding="0" cellspacing="0" border="0" class="inner_table">
						<tr>
							<th>발급사유</th>
							<td>
								<input type="radio" name="cash_type" value="C" onClick="qclick2('01');"> 사업자 지출증빙용
								<input type="radio" name="cash_type" value="P" onClick="qclick2('02');"> 개인소득 공제용
							</td>
						</tr>
						<tr>
							<th>신청정보</th>
							<td>
								<div id="cash_info01"></div>&nbsp;
								<div id="cash_info02" style="padding:3px;"></div>
							</td>
						</tr>
						<tr>
							<th>신청자명</th>
							<td>
								<input type="text" name="cash_name" value="" class="input">
							</td>
						</tr>
					</table>
				</div>
			</div>

			<div class="pay_btn_wrap" style="margin-top: 24px;">
				<button class="btn btn_point mdc-elevation-z1" type="submit" border=0 style="cursor:pointer; display: block; width: 100%; height: 48px;">결제하기</button>
				<input class="btn btn_border mdc-elevation-z1" value="취소하기" onClick="history.go(-1);" style="cursor:pointer; display: block; width: 100%; height: 48px; margin: 0; margin-top: 8px;">
			</div>

		</div>

	</div>


</form>
