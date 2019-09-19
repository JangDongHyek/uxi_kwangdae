<?
$sql = "select * from wiz_meminfo";
$result = mysql_query($sql) or error(mysql_error());
$mem_info = mysql_fetch_array($result);

// 스킨위치
$skin_dir = "/adm/member/skin/".$mem_info[skin];


$icon_size = 25;														// 회원 아이콘 크기

$agreement = $mem_info[agreement];					// 회원약관
$safeinfo = $mem_info[safeinfo];						// 개인정보 보호정책

$join_url = "/".$mem_info[join_url];        // 회원가입
$login_url = "/".$mem_info[login_url];      // 로그인 페이지
$logout_url = "/adm/member/logout.php";		// 로그아웃 페이지
$myinfo_url = "/".$mem_info[myinfo_url];    // 마이페이지
$idpw_url = "/".$mem_info[idpw_url];     		// 아이디,비번찾기 주소

// 입력정보 사용여부
$info_tmp = explode("/",$mem_info[infouse]);
for($ii=0; $ii<count($info_tmp); $ii++){
	$info_use[$info_tmp[$ii]] = true;
}

// 입력정보 필수여부
$info_tmp = explode("/",$mem_info[infoess]);
for($ii=0; $ii<count($info_tmp); $ii++){
	$info_ess[$info_tmp[$ii]] = true;
}

// 추가항목명
list($addname1, $addname2, $addname3, $addname4, $addname5) = explode("|", $mem_info[addname]);

// 직업목록
$i=0;
$array_job = explode(",",$mem_info[job_list]);
$job_list = "<select name='job'>\n";
$job_list .= "<option value=''>항목을 선택해 주세요</option>\n";
while($array_job[$i]){
	$job_list .= "<option value='".$array_job[$i]."'>".$array_job[$i]."</option>\n";
	$i++;
}
$job_list .= "</select>\n";

// 학력목록
$i=0;
$array_sch = explode(",",$mem_info[sch_list]);
$sch_list = "<select name='scholarship'>\n";
$sch_list .= "<option value=''>항목을 선택해 주세요</option>\n";
while($array_sch[$i]){
	$sch_list .= "<option value='".$array_sch[$i]."'>".$array_sch[$i]."</option>\n";
	$i++;
}
$sch_list .= "</select>\n";

// 수입목록
$i=0;
$array_income = explode(",",$mem_info[income_list]);
$income_list = "<select name='income'>\n";
$income_list .= "<option value=''>항목을 선택해 주세요</option>\n";
while($array_income[$i]){
	$income_list .= "<option value='".$array_income[$i]."'>".$array_income[$i]."</option>\n";
	$i++;
}
$income_list .= "</select>\n";


// 관심분야목록
$arrconsph=explode(",",$my_info[consph]);
for($ii=0; $ii<count($arrconsph); $ii++){
  $consph[$arrconsph[$ii]]="checked";
}

$i=0;
$consph_list = "";
$array_consph = explode(",",$mem_info[consph_list]);
while($array_consph[$i]){
	$consph_list .= "<input type='checkbox' name='consph[]'  value='".$array_consph[$i]."' ".$consph[$array_consph[$i]]."> ".$array_consph[$i]." ";
	$i++;
}
?>
