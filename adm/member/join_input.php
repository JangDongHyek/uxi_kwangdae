<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/mem_info.php";

// 자동등록글체크
get_spam_check();

$prev = "http://".$_http_host.$PHP_SELF;

$action = $ssl."/adm/member/join_save.php";

// 정보입력 여부 체크
if($info_use[nick] != true){
	$hide_nick_start = "<!--"; $hide_nick_end = "-->";
}
if($info_use[photo] != true){
	$hide_photo_start = "<!--"; $hide_photo_end = "-->";
}
if($info_use[icon] != true){
	$hide_icon_start = "<!--"; $hide_icon_end = "-->";
}
if($info_use[resno] != true){
	$hide_resno_start = "<!--"; $hide_resno_end = "-->";
}
if($info_use[tphone] != true){
	$hide_tphone_start = "<!--"; $hide_tphone_end = "-->";
}
if($info_use[hphone] != true){
	$hide_hphone_start = "<!--"; $hide_hphone_end = "-->";
}
if($info_use[comtel] != true){
	$hide_comtel_start = "<!--"; $hide_comtel_end = "-->";
}
if($info_use[email] != true){
	$hide_email_start = "<!--"; $hide_email_end = "-->";
}
if($info_use[reemail] != true){
	$hide_reemail_start = "<!--"; $hide_reemail_end = "-->";
}
if($info_use[resms] != true){
	$hide_resms_start = "<!--"; $hide_resms_end = "-->";
}
if($info_use[homepage] != true){
	$hide_homepage_start = "<!--"; $hide_homepage_end = "-->";
}
if($info_use[address] != true){
	$hide_address_start = "<!--"; $hide_address_end = "-->";
}
if($info_use[recom] != true){
	$hide_recom_start = "<!--"; $hide_recom_end = "-->";
}
if($info_use[birthday] != true){
	$hide_birthday_start = "<!--"; $hide_birthday_end = "-->";
}
if($info_use[marriage] != true){
	$hide_marriage_start = "<!--"; $hide_marriage_end = "-->";
}
if($info_use[memorial] != true){
	$hide_memorial_start = "<!--"; $hide_memorial_end = "-->";
}
if($info_use[job] != true){
	$hide_job_start = "<!--"; $hide_job_end = "-->";
}
if($info_use[scholarship] != true){
	$hide_scholarship_start = "<!--"; $hide_scholarship_end = "-->";
}
if($info_use[consph] != true){
	$hide_consph_start = "<!--"; $hide_consph_end = "-->";
}
if($info_use[hobby] != true){
	$hide_hobby_start = "<!--"; $hide_hobby_end = "-->";
}
if($info_use[income] != true){
	$hide_income_start = "<!--"; $hide_income_end = "-->";
}
if($info_use[car] != true){
	$hide_car_start = "<!--"; $hide_car_end = "-->";
}
if($info_use[intro] != true){
	$hide_intro_start = "<!--"; $hide_intro_end = "-->";
}
if($info_use[addinfo1] != true){
	$hide_addinfo1_start = "<!--"; $hide_addinfo1_end = "-->";
}
if($info_use[addinfo2] != true){
	$hide_addinfo2_start = "<!--"; $hide_addinfo2_end = "-->";
}
if($info_use[addinfo3] != true){
	$hide_addinfo3_start = "<!--"; $hide_addinfo3_end = "-->";
}
if($info_use[addinfo4] != true){
	$hide_addinfo4_start = "<!--"; $hide_addinfo4_end = "-->";
}
if($info_use[addinfo5] != true){
	$hide_addinfo5_start = "<!--"; $hide_addinfo5_end = "-->";
}
if($info_use[spam] != true){
	$hide_spam_start = "<!--"; $hide_spam_end = "-->";
}

function createObject($no,$type,$size,$flist){
	$skin_dir = "/adm/member/skin/memberBasic";

	global $upfile_idx;

	$fname = "f".$no;

	// 반복하지 않는 속성
	$tmp_type = Array("","address","birthday","phone","email");

	for($ii = 0;$ii < count($tmp_type); $ii++) {
		if(!strcmp($type, $tmp_type[$ii])) $flist = " ";
	}

	$tmp_flist = explode("|",$flist);

	if($type == "select") $finput = "<select id='".$fname."_0' name='fname[".$no."][]'><option value=''>--</option>";

	for($ii=0;$ii<count($tmp_flist);$ii++){
		//if($tmp_flist[$ii] != ""){
		if($type == "text"){
			$finput .= "<input type='text' id='".$fname."_$ii' name='fname[".$no."][]' class='input' size='".$size."'>".$tmp_flist[$ii];
		}
		else if($type == "file"){
			$upfile_idx++;
			$finput .= "<input type='file' id='".$fname."_$ii' name='upfile".$upfile_idx."' class='file' size='".$size."'>".$tmp_flist[$ii];
		}
		else if($type == "radio"){
			$finput .= "<input type='radio' id='".$fname."_$ii' name='fname[".$no."]' value='".$tmp_flist[$ii]."'>".$tmp_flist[$ii]."&nbsp; ";
		}
		else if($type == "checkbox"){
			$finput .= "<input type='checkbox' id='".$fname."_$ii' name='fname[".$no."][]' value='".$tmp_flist[$ii]."'>".$tmp_flist[$ii]."&nbsp; ";
		}
		else if($type == "textarea"){
			$finput .= "<textarea id='".$fname."_$ii' name='fname[".$no."][]' rows='".$size."' class='input' style='width:99%'></textarea>";
		}
		else if($type == "select"){
			$finput .= "<option value='".$tmp_flist[$ii]."'>".$tmp_flist[$ii]."</option>";
		}
		else if($type == "address"){
			$finput .= "<div><input type='text' id='".$fname."_0' name='".$fname."_post1' onClick=postSearch('".$fname."_'); class='input w40' readonly>";
			$finput .= "<input type='image' src='".$skin_dir."/image/input_bt_zip.gif' onClick=postSearch('".$fname."_'); class='button'></div>";
			//$finput .= "<input type='button' value='주소찾기' onClick=postSearch('".$fname."_'); class='button'><br>";
			$finput .= "<div class='top3'><input type='text' id='".$fname."_2' name='".$fname."_address1' class='input' size='".$size."'></div>";
			$finput .= "<div class='top3'><input type='text' id='".$fname."_3' name='".$fname."_address2' class='input' size='".$size."'></div>";
		}
		else if($type == "pdate"){
			$finput .= "<input type='text' id='".$fname."_".$ii."' name='fname[".$no."][]' class='input' size='".$size."' onClick=Calendar5('document.joinFrm','".$fname."_".$ii."'); readonly> ";
			$finput .= "<span class='comment left5'><input type='image' src='".$skin_dir."/image/icon_cal.gif' onClick=Calendar5('document.joinFrm','".$fname."_".$ii."'); /></font>".$tmp_flist[$ii];
			//$finput .= "<input type='button' value='달력' onClick=Calendar5('document.joinFrm','".$fname."_".$ii."'); class='button'>".$tmp_flist[$ii];
		}
		else if($type == "tdate"){
			$finput .= "<font class='comment'><select id='".$fname."_".$ii."_0' name='fname[".$no."][]'><option value=''>--</option>";

			for($jj=2008;$jj<=2015;$jj++){
				$finput .= "<option value='".$jj."'>".$jj."</option>";
			}

			$finput .= "</select> 년<font>";
			$finput .= "<font class='comment left10'><select id='".$fname."_".$ii."_1' name='fname[".$no."][]'><option value=''>--</option>";

			for($jj=1;$jj<=12;$jj++){
				if($jj<10) $jj = "0".$jj;
				$finput .= "<option value='".$jj."'>".$jj."</option>";
			}

			$finput .= "</select> 월</font>";
			$finput .= "<font class='comment left10'><select id='".$fname."_".$ii."_2' name='fname[".$no."][]'><option value=''>--</option>";

			for($jj=1;$jj<=31;$jj++){
				if($jj<10) $jj = "0".$jj;
				$finput .= "<option value='".$jj."'>".$jj."</option>";
			}

			$finput .= "</select> 일</font>";
			$finput .= "<font class='comment left10'><select id='".$fname."_".$ii."_3' name='fname[".$no."][]'><option value=''>--</option>";

			for($jj=1;$jj<=24;$jj++){
				if($jj<10) $jj = "0".$jj;
				$finput .= "<option value='".$jj."'>".$jj."</option>";
			}

			$finput .= "</select> 시</div>".$tmp_flist[$ii];
		}
		else if($type == "birthday") {
			$finput .= "<font class='comment'><select id='".$fname."_".$ii."_0' name='fname[".$no."][]'><option value=''>--</option>";

			for($jj=1900;$jj<=date('Y');$jj++){
				$finput .= "<option value='".$jj."'>".$jj."</option>";
			}

			$finput .= "</select> 년</font>";
			$finput .= "<font class='comment left10'><select id='".$fname."_".$ii."_1' name='fname[".$no."][]'><option value=''>--</option>";

			for($jj=1;$jj<=12;$jj++){
				if($jj<10) $jj = "0".$jj;
				$finput .= "<option value='".$jj."'>".$jj."</option>";
			}

			$finput .= "</select> 월</font>";
			$finput .= "<font class='comment left10'><select id='".$fname."_".$ii."_2' name='fname[".$no."][]'><option value=''>--</option>";

			for($jj=1;$jj<=31;$jj++){
				if($jj<10) $jj = "0".$jj;
				$finput .= "<option value='".$jj."'>".$jj."</option>";
			}
			$finput .= "</select> 일</font>";
		}
		else if($type == "phone") {
			$finput .= "<input type='text' id='".$fname."_0' name='fname[".$no."][]' class='input' size='".$size."' maxlength='4'> - ";
			$finput .= "<input type='text' id='".$fname."_1' name='fname[".$no."][]' class='input' size='".$size."' maxlength='4'> - ";
			$finput .= "<input type='text' id='".$fname."_2' name='fname[".$no."][]' class='input' size='".$size."' maxlength='4'>".$tmp_flist[$ii];
		}
		else if($type == "email") {
			$finput .= "<input type='text' id='".$fname."_$ii' name='fname[".$no."][]' class='input' size='".$size."'>".$tmp_flist[$ii];
		}
	}

	if($type == "select") $finput .= "</select>";
	return $finput;
}

function checkObject($no,$name,$essen,$type,$flist){

	$fname = "f".$no;
	if($flist == "") $flist = " ";

	if($essen == "Y"){
		if($type == "text" || $type == "textarea" || $type == "file" || $type == "pdate"){
			$flist_list = explode("|",$flist);

			for($ii=0;$ii<count($flist_list);$ii++){
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert(\"".$name."을 입력하세요\");\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
			}
		}
		else if($type == "select"){
			$checkObj .=   "var obj = document.getElementById(\"".$fname."_0\");\n";
			$checkObj .=   "if(obj.value == \"\"){\n";
			$checkObj .=   "   alert(\"".$name."을 선택하세요\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";
		}
		else if($type == "tdate"){
			$flist_list = explode("|",$flist);

			for($ii=0;$ii<count($flist_list);$ii++){
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."_0\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert('년도를 선택하세요');\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."_1\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert('월을 선택하세요');\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."_2\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert('일자를 선택하세요');\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."_3\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert('시간을 선택하세요');\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
			}
		}
		else if($type == "checkbox" || $type == "radio"){
			$checkObj .=   "var c_checked = false;";
			$flist_list = explode("|",$flist);

			for($ii=0;$ii<count($flist_list);$ii++){
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."\");\n";
				$checkObj .=   "if(obj.checked == true) c_checked = true;\n";
			}

			$checkObj .=   "if(c_checked == false){\n";
			$checkObj .=   "   alert('".$name." 을 선택하세요');\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";
		}
		else if($type == "address"){
			$checkObj .=   "if(frm.".$fname."_address1.value == ''){\n";
			$checkObj .=   "   alert('주소를 입력하세요');\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";
			$checkObj .=   "if(frm.".$fname."_address2.value == ''){\n";
			$checkObj .=   "   alert('주소를 입력하세요');\n";
			$checkObj .=   "   frm.".$fname."_address2.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";
		}
		else if($type == "birthday"){
			$flist_list = explode("|",$flist);

			for($ii=0;$ii<count($flist_list);$ii++){
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."_0\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert('년도를 선택하세요');\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."_1\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert('월을 선택하세요');\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
				$checkObj .=   "var obj = document.getElementById(\"".$fname."_".$ii."_2\");\n";
				$checkObj .=   "if(obj.value == \"\"){\n";
				$checkObj .=   "   alert('일자를 선택하세요');\n";
				$checkObj .=   "   obj.focus();\n";
				$checkObj .=   "   return false;\n";
				$checkObj .=   "}\n";
			}
		}
		else if($type == "phone"){
			$checkObj .=   "var obj = document.getElementById(\"".$fname."_0\");\n";
			$checkObj .=   "if(obj.value == \"\"){\n";
			$checkObj .=   "   alert(\"".$name."을 입력하세요\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}else if(!check_Num(obj.value)){\n";
			$checkObj .=   "	alert(\"지역번호는 숫자만 가능합니다.\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";

			$checkObj .=   "var obj = document.getElementById(\"".$fname."_1\");\n";
			$checkObj .=   "if(obj.value == \"\"){\n";
			$checkObj .=   "   alert(\"".$name."을 입력하세요\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}else if(!check_Num(obj.value)){\n";
			$checkObj .=   "	alert(\"국번은 숫자만 가능합니다.\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";
			$checkObj .=   "var obj = document.getElementById(\"".$fname."_2\");\n";
			$checkObj .=   "if(obj.value == \"\"){\n";
			$checkObj .=   "   alert(\"".$name."을 입력하세요\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}else if(!check_Num(obj.value)){\n";
			$checkObj .=   "	alert(\"전화번호는 숫자만 가능합니다.\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";
		}
		else if($type == "email"){
			$checkObj .=   "var obj = document.getElementById(\"".$fname."_0\");\n";
			$checkObj .=   "if(obj.value == \"\"){\n";
			$checkObj .=   "   alert(\"".$name."을 입력하세요\");\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "} else if(!check_Email(obj.value)) {\n";
			$checkObj .=   "   obj.focus();\n";
			$checkObj .=   "   return false;\n";
			$checkObj .=   "}\n";
		}
	}
	return $checkObj;
}

$sql = "select fprior, ftype, fsize, flist from wiz_formfield where fidx = 'addinfo' order by fprior asc";
$result = mysql_query($sql) or error(mysql_error());
while($row = mysql_fetch_array($result)) {
	$no = $row[fprior];

	${addinfo.$no._input} = createObject($no,$row[ftype],$row[fsize],$row[flist]);
	${addinfo.$no._check} = checkObject($no,${addname.$no},"Y",$row[ftype],$row[flist]);

}
?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script language="JavaScript" src="/adm/js/lib.js"></script>
<script language="JavaScript" src="/adm/js/calendar.js"></script>
<script language="JavaScript">
// 입력값 체크
function joinCheck(frm){
	if(frm.id.value.length < 3 || frm.id.value.length > 12){ alert("아이디는 3 ~ 12자리만 가능합니다."); frm.id.focus(); return false; }
	else{
		if(!check_Char(frm.id.value)){ alert("아이디는 특수문자를 사용할수 없습니다."); frm.id.focus(); return false; }
	}

	if(frm.passwd1.value.length < 4 || frm.passwd1.value.length > 12){ alert("비밀번호는 4 ~ 12자리입니다"); frm.passwd1.focus(); return false; }
	if(frm.passwd2.value.length < 4 || frm.passwd2.value.length > 12){ alert("비밀번호는 4 ~ 12자리입니다"); frm.passwd2.focus(); return false; }
	if(frm.passwd1.value != frm.passwd2.value){ alert("비밀번호가 일치하지 않습니다"); frm.passwd1.focus(); return false; }

	if(frm.name.value == ""){ alert("이름을 입력하세요");frm.name.focus();return false; }
	else{
		if(!check_nonChar(frm.name.value)){ alert("이름에는 특수문자가 들어갈 수 없습니다"); frm.name.focus(); return false; }
	}

	<?
	if($info_use[nick]=="true" && $info_ess[nick]=="true"){ ?>
		if(frm.nick.value == ""){ alert("닉네임을 입력하세요."); frm.nick.focus(); return false; }
		<?
	}?>
	<?
	if($info_use[photo]=="true" && $info_ess[photo]=="true"){ ?>
		if(frm.photo.value == ""){ alert("사진을 입력하세요."); frm.photo.focus(); return false; }
	<?
	} ?>

	<?
	if($info_use[icon]=="true" && $info_ess[icon]=="true"){ ?>
		if(frm.icon.value == ""){ alert("아이콘을 입력하세요."); frm.icon.focus(); return false; }
	<?
	} ?>

	<?
	if($info_use[resno]=="true" && $info_ess[resno]=="true"){ ?>
		if(frm.resno1.value == ""){ alert("주민번호를 입력하세요"); frm.resno1.focus(); return false; }
		if(frm.resno2.value == ""){ alert("주민번호를 입력하세요"); frm.resno2.focus(); return false; }
		if(!check_ResidentNO(frm.resno1.value, frm.resno2.value)){ alert("주민번호가 올바르지 않습니다"); frm.resno1.value == ""; frm.resno2.value == ""; frm.resno1.focus(); return false; }
		<?
	} ?>

	<?
	if($info_use[tphone]=="true" && $info_ess[tphone]=="true"){ ?>
		if(frm.tphone1.value == ""){ alert("전화번호를 입력하세요"); frm.tphone1.focus(); return false; }
		else if(!check_Num(frm.tphone1.value)){ alert("지역번호는 숫자만 가능합니다."); frm.tphone1.focus(); return false; }

		if(frm.tphone2.value == ""){ alert("전화번호를 입력하세요"); frm.tphone2.focus(); return false; }
		else if(!check_Num(frm.tphone2.value)){ alert("국번은 숫자만 가능합니다."); frm.tphone2.focus(); return false; }

		if(frm.tphone3.value == ""){ alert("전화번호를 입력하세요"); frm.tphone3.focus(); return false; }
		else if(!check_Num(frm.tphone3.value)){ alert("전화번호는 숫자만 가능합니다"); frm.tphone3.focus(); return false; }
	<?
	} ?>

	<?
	if($info_use[hphone]=="true" && $info_ess[hphone]=="true"){ ?>
		if(frm.hphone1.value == ""){ alert("휴대폰번호를 입력하세요"); frm.hphone1.focus(); return false; }
		else if(!check_Num(frm.hphone1.value)){ alert("휴대폰번호는 숫자만 가능합니다."); frm.hphone1.focus(); return false; }

		if(frm.hphone2.value == ""){ alert("휴대폰번호를 입력하세요");frm.hphone2.focus(); return false; }
		else if(!check_Num(frm.hphone2.value)){ alert("휴대폰번호는 숫자만 가능합니다."); frm.hphone2.focus(); return false; }

		if(frm.hphone3.value == ""){ alert("휴대폰번호를 입력하세요"); frm.hphone3.focus(); return false; }
		else if(!check_Num(frm.hphone3.value)){ alert("휴대폰번호는 숫자만 가능합니다"); frm.hphone3.focus(); return false; }
	<?
	} ?>

	<?
	if($info_use[comtel]=="true" && $info_ess[comtel]=="true"){ ?>
		if(frm.comtel1.value == ""){ alert("회사전화를 입력하세요"); frm.comtel1.focus(); return false; }
		else if(!check_Num(frm.comtel1.value)){ alert("전화번호는 숫자만 가능합니다."); frm.comtel1.focus(); return false; }

		if(frm.comtel2.value == ""){ alert("회사전화를 입력하세요"); frm.comtel2.focus(); return false; }
		else if(!check_Num(frm.comtel2.value)){ alert("전화번호는 숫자만 가능합니다."); frm.comtel2.focus(); return false; }

		if(frm.comtel3.value == ""){ alert("회사전화를 입력하세요"); frm.comtel3.focus(); return false; }
		else if(!check_Num(frm.comtel3.value)){ alert("전화번호는 숫자만 가능합니다"); frm.comtel3.focus(); return false; }
	<?
	} ?>

	<?
	if($info_use[email]=="true" && $info_ess[email]=="true"){ ?>
		if(frm.email.value == ""){ alert("이메일을 입력하세요."); frm.email.focus(); return false; }
		else if(!check_Email(frm.email.value)){ frm.email.focus(); return false; }
	<?
	} ?>

	<?
	if($info_use[homepage]=="true" && $info_ess[homepage]=="true"){ ?>
		if(frm.homepage.value == ""){ alert("홈페이지를 입력하세요."); frm.homepage.focus(); return false; }
	<?
	} ?>

	<?
	if($info_use[address]=="true" && $info_ess[address]=="true"){ ?>
		if(frm.post1.value == ""){alert("우편번호를 입력하세요");frm.post1.focus();return false;}

		if(frm.post1.value.length != 5){alert("우편번호가 올바르지 않습니다");frm.post1.focus();return false;}
		if(frm.address1.value == ""){alert("주소를 입력하세요");frm.address1.focus();return false;}
		if(frm.address2.value == ""){alert("상세주소를 입력하세요");frm.address2.focus();return false;}
		<?
	} ?>

	<?
	if($info_use[birthday]=="true" && $info_ess[birthday]=="true"){ ?>

		if(frm.birthday1.value == ""){alert("생년월일을 입력하세요.");frm.birthday1.focus();return false;}
		if(frm.birthday2.value == ""){alert("생년월일을 입력하세요.");frm.birthday2.focus();return false;}
		if(frm.birthday3.value == ""){alert("생년월일을 입력하세요.");frm.birthday3.focus();return false;}
		if(frm.bgubun[0].checked == false && frm.bgubun[1].checked == false){alert("양력 음력을 선택하세요.");return false;}

		<?
	} ?>

	<?
	if($info_use[marriage]=="true" && $info_ess[marriage]=="true"){ ?>
		if(frm.marriage[0].checked == false && frm.marriage[1].checked == false){alert("결혼여부를 선택하세요.");return false;}
		<?
	} ?>

	<?
	if($info_use[memorial]=="true" && $info_ess[memorial]=="true"){ ?>
		if(frm.memorial1.value == ""){alert("결혼기념일을 입력하세요.");frm.memorial1.focus();return false;}
		if(frm.memorial2.value == ""){alert("결혼기념일을 입력하세요.");frm.memorial2.focus();return false;}
		if(frm.memorial3.value == ""){alert("결혼기념일을 입력하세요.");frm.memorial3.focus();return false;}
		<?
	} ?>

	<?
	if($info_use[job]=="true" && $info_ess[job]=="true"){ ?>
		if(frm.job.value == ""){alert("직업을 선택하세요.");frm.job.focus();return false;}
	<?
	} ?>

	<?
	if($info_use[scholarship]=="true" && $info_ess[scholarship]=="true"){ ?>
		if(frm.scholarship.value == ""){alert("학력을 선택하세요.");frm.scholarship.focus();return false;}
	<?
	} ?>

	<?
	if($info_use[consph]=="true" && $info_ess[consph]=="true"){ ?>

		var consphLen=frm['consph[]'].length;

		if(consphLen == undefined){
			if( frm['consph[]'].checked == false ){alert("관심분야가 선택되지 않았습니다.");frm['consph[]'].focus();return false;  }
		}
		else{
			var ChkLike=0;
			for(i=0;i<consphLen;i++){if( frm['consph[]'][i].checked == true ){ ChkLike=1; break;}}
			if( ChkLike==0 ){alert("관심분야는 한개 이상 선택하셔야 합니다.");frm['consph[]'][0].focus();return false; }
		}
		<?
	} ?>

	<?
	if($info_use[hobby]=="true" && $info_ess[hobby]=="true"){ ?>
		if(frm.hobby.value == ""){alert("취미를 입력하세요.");frm.hobby.focus();return false;}
		<?
	} ?>

	<?
	if($info_use[income]=="true" && $info_ess[income]=="true"){ ?>
		if(frm.income.value == ""){alert("월평균 소득일 선택하세요.");frm.income.focus();return false;}
		<?
	} ?>

	<?
	if($info_use[car]=="true" && $info_ess[car]=="true"){ ?>
		if(frm.car[0].checked==false && frm.car[1].checked==false ){alert("자동차 소유여부를 선택하세요.");return false;}
		<?
	} ?>

	<?
	if($info_use[intro]=="true" && $info_ess[intro]=="true"){ ?>
		if(frm.intro.value == ""){alert("자기소개를 입력하세요.");frm.intro.focus();return false;}
		<?
	} ?>

	<?
	if($info_use[recom]=="true" && $info_ess[recom]=="true"){ ?>
		if(frm.recom.value == ""){alert("추천인을 입력하세요");frm.recom.focus();return false;}
		else if(frm.id.value == frm.recom.value){alert("추천인은 본인이 될 수 없습니다.");frm.recom.focus();return false;}
		<?
	} ?>

	<?
	if($info_use[addinfo1]=="true" && $info_ess[addinfo1]=="true"){ ?>
		<?=$addinfo1_check?>
		<?
	} ?>

	<?
	if($info_use[addinfo2]=="true" && $info_ess[addinfo2]=="true"){ ?>
		<?=$addinfo2_check?>
		<?
	} ?>

	<?
	if($info_use[addinfo3]=="true" && $info_ess[addinfo3]=="true"){ ?>
		<?=$addinfo3_check?>
		<?
	} ?>

	<?
	if($info_use[addinfo4]=="true" && $info_ess[addinfo4]=="true"){ ?>
		<?=$addinfo4_check?>
		<?
	} ?>

	<?
	if($info_use[addinfo5]=="true" && $info_ess[addinfo5]=="true"){ ?>
		<?=$addinfo5_check?>
		<?
	} ?>

	<?
	if($info_use[spam]=="true" && $info_ess[spam]=="true"){ ?>
		if (frm.vcode != undefined && (hex_md5(frm.vcode.value) != md5_norobot_key)) {
			alert("자동등록방지코드를 정확히 입력해주세요.");
			frm.vcode.focus();
			return false;
		}
		<?
	} ?>

	// if(frm.secure_login != undefined) {
	// 	if(!frm.secure_login.checked){
	// 		frm.action = "/adm/member/join_save.php";
	// 	}
	// }

	// KCP인증 추가했는데 미인증시
	<?
	if($site_info[cert_kcp_use]=='Y'){?>
		if(frm.kcp_cert.value != "Y"){
			alert("KCP 본인인증이 필요합니다.");
			return false;
		}
		<?
	}?>

	if(frm.secure_login != undefined) {
		if(!frm.secure_login.checked){
			frm.action = "/adm/member/join_save.php";
		}
	}
}

// 아이디 중복확인
function idCheck(){
	var id = document.joinFrm.id.value;
	var url = "/adm/member/id_check.php?id=" + id;
	window.open(url, "idCheck", "width=410, height=280, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, left=150, top=150");
}

// 닉네임 중복확인
function nickCheck(){
	var nick = document.joinFrm.nick.value;
	var url = "/adm/member/nick_check.php?nick=" + nick;
	window.open(url, "nickCheck", "width=410, height=280, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, left=150, top=150");
}

// 우편번호 찾기
function postSearch(kind) {
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
					eval('frm.'+kind+'post1').value = data.zonecode ;
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
						eval('frm.'+kind+'address1').value = data.roadAddress;
					}
					else { // 사용자가 지번 주소를 선택했을 경우(J)
						eval('frm.'+kind+'address1').value = data.jibunAddress;
					}
					//eval('frm.'+kind+'address1').value = data.address;
					if(eval('frm.'+kind+'address2') != null) eval('frm.'+kind+'address2').focus();
				}

				if(eval('frm.'+kind+'address')){
					if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
						eval('frm.'+kind+'address').value = data.roadAddress;
					}
					else { // 사용자가 지번 주소를 선택했을 경우(J)
						eval('frm.'+kind+'address').value = data.jibunAddress;
					}
					//eval('frm.'+kind+'address').value = data.address;
				}
			}
		}
	}).open();
}

// 주민번호 자동포커스
function jfocus(frm){
	if(frm.resno2 != null){
		var str = frm.resno1.value.length;
		if(str == 6) frm.resno2.focus();
	}
}

// 인증번호발송
function create_authcode(type){

	if(type == "phone"){
		if(joinFrm.hphone1.value == "" || joinFrm.hphone2.value == "" || joinFrm.hphone3.value == "" ){
			alert("휴대폰 번호를 입력해주세요.");

			if(joinFrm.hphone1.value == "") joinFrm.hphone1.focus();
			else if(joinFrm.hphone2.value == "") joinFrm.hphone2.focus();
			else joinFrm.hphone3.focus();

			return;
		}
	}
	if(type == "email"){
		if(joinFrm.email){
			if(joinFrm.email.value == ""){
				alert("이메일을 입력해주세요.");
				joinFrm.email.focus();
				return;
			}
		}
		else{
		}
	}

	var hphone = joinFrm.hphone1.value + joinFrm.hphone2.value + joinFrm.hphone3.value;

	$.ajax({
		url: "/adm/member/join_authcode.php",
		type: "post",
		data : {
			mode : "create",
			hphone : hphone,
			email : joinFrm.email.value,
			type : type
		},
		success : function(data){
			var obj = JSON.parse(data);
			if(obj.resultCode == 200){
				alert("인증메세지가 발송되었습니다.");
			}
		}
	});
}

// 인증번호확인
function check_authcode(type){

	var authcode;

	switch(type){
		case "phone":
		if(joinFrm.authcode_sms) authcode = joinFrm.authcode_sms.value;
		break;
		case "email":
		if(joinFrm.authcode_email) authcode = joinFrm.authcode_email.value;
		break;
	}

	$.ajax({
		url: "/adm/member/join_authcode.php",
		type: "post",
		data : {
			mode : "auth",
			authcode : authcode ,
			type : type
		},
		success: function(data){
			var obj = JSON.parse(data);
			if(obj.resultCode == 200){
				if(type == "phone"){
					joinFrm.authpass_sms.value = true;
				}
				else if(type == "email"){
					joinFrm.authpass_email.value = true;
				}
				alert("인증번호가 확인되었습니다.");
			}
			else if(obj.resultCode == 500){
				alert(obj.msg);
			}
		}
	});
}

</script>

<? include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/join_input.php"; ?>
