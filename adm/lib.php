<?
// prev, 스팸글 체크등 HTTP_HOST 체크 시 SSL 포트번호와 분리
list($_http_host, $_http_port) = explode(":", $_SERVER[HTTP_HOST]);

$mobile_path = "m";

function mobile_check() {

	global $mobile_path;

	if(!is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$mobile_path))	return false;

	$mobile_array  = array("iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone");

	$checkCount = 0;
	for($i=0; $i<sizeof($mobile_array); $i++){
		if(preg_match("/$mobile_array[$i]/", strtolower($_SERVER['HTTP_USER_AGENT']))){ $checkCount++; break; }
	}

	// PC 테스트 시
	$referer = $_SERVER['HTTP_REFERER'];
	$parse_url = parse_url($referer);

	$parse_path = explode("/", $parse_url['path']);

	if($parse_path[1] == $mobile_path) {
		$checkCount += 1;
	}

	return ($checkCount >= 1) ? true : false;
}

function check_mobile(){
	global $HTTP_USER_AGENT;
  $MobileArray  = array("iphone","lgtelecom","skt","mobile","samsung","nokia","blackberry","android","android","sony","phone");

  $checkCount = 0;
  for($i=0; $i<sizeof($MobileArray); $i++){
      if(preg_match("/$MobileArray[$i]/", strtolower($HTTP_USER_AGENT))){ $checkCount++; break; }
  }
 	return ($checkCount >= 1) ? true : false;
}


// 랜덤한 10자리 정수를 리턴
function get_rand_number($len=10) {
    $len = abs((int)$len);

    if ($len < 1) $len = 1;

    else if ($len > 10) $len = 10;

    return rand(pow(10, $len - 1), (pow(10, $len) - 1));
}

// 에러 출력
function error($msg, $go_url=""){

	if($go_url == "") {
		echo "<script>alert(\"$msg\");history.go(-1);</script>";
		exit;
	} else {
		echo "<script>alert(\"$msg\");document.location=\"$go_url\";</script>";
		exit;
	}


}

// 경고창 출력
function alert($msg, $go_url=""){

	if($go_url == "")
		echo "<script>alert(\"$msg\");history.go(-1);</script>";
	else
		echo "<script>alert(\"$msg\");document.location=\"$go_url\";</script>";

}

// 완료 메세지 출력
function complete($com_msg, $go_url=""){

	if($go_url == "")
		echo "<script>window.setTimeout(\"history.go(-1)\",600);</script>";
	else
	echo "<script>window.setTimeout(\"document.location='$go_url';\",600);</script>";

	echo "<body><table width=100% height=100%><tr><td align=center><font size=2>$com_msg</font></td></tr></table></body>";

}

// 테이블 데이타 얻기
function get_table($table, $search = ""){

	if($search != "") $search_sql = " where $search";
	$sql = "select * from ".$table.$search_sql;
	$result = mysql_query($sql) or error(mysql_error());
	$data = mysql_fetch_array($result);

	return $data;

}

// 문자열 끊기 (이상의 길이일때는 ... 로 표시)
function cut_str($msg,$cut_size) {
  if($cut_size<=0) return $msg;
  if(ereg("\[re\]",$msg)) $cut_size=$cut_size+4;
    $max_size = $cut_size;
  $i=0;
  while(1) {
   if (ord($msg[$i])>127)
    $i+=3;
   else
    $i++;

   if (strlen($msg) < $i)
    return $msg;

   if ($max_size == 0)
    return substr($msg,0,$i)."...";
   else
    $max_size--;
  }
}



// 문자열의 마지막 문자를 * 로 처리해서 반환
function set_passwd($str){
   $re_str = "";
   $strlen = strlen($str) - 2;
   $re_str = substr($str,0,2);
   for($ii=0;$ii<$strlen;$ii++){
      $re_str .= "*";
   }

   return $re_str;

}


// 기본 레벨
function level_basic(){
	$sql = "select idx from wiz_level order by level desc limit 1";
	$result = mysql_query($sql) or error(mysql_error());
	$row = mysql_fetch_object($result);

	return $row->idx;

}


// 회원등급 리스트
function level_list(){

	$sql = "select idx,level,name from wiz_level order by level desc, idx asc";
	$result = mysql_query($sql) or error(mysql_error());
	while($row = mysql_fetch_object($result)){
		echo "<option value='$row->idx'>$row->name</option>";
	}

}


// 등급정보
function level_info(){

	$level_info[""][level] = 10000;
	$level_info[""][name] = "전체";
	$level_info["-1"][level] = -1;
  $level_info["-1"][name] = "구매회원";
	$level_info["0"][level] = 0;
	$level_info["0"][name] = "관리자";

	$sql = "select * from wiz_level";
	$result = mysql_query($sql) or error(mysql_error());

	while($row = mysql_fetch_object($result)){
		$level_info[$row->idx][level] = $row->level;
		$level_info[$row->idx][name] = $row->name;
	}

	return $level_info;

}


// 비방글, 욕설체크
function check_abuse($str){

	global $bbs_info;
	global $poll_info;
	if(!empty($bbs_info)) {
		if($bbs_info['abuse'] == "Y") {
			$abuse_list = explode(",",$bbs_info[abtxt]);
			for($ii=0; $ii < count($abuse_list); $ii++){
				$abuse_list[$ii] = trim($abuse_list[$ii]);
				if(!empty($abuse_list[$ii])){
					if( strpos($str, $abuse_list[$ii]) !== false){
						error("'$abuse_list[$ii]' 단어는 사용하실 수 없습니다.");
					}
				}
			}
		}
	}

	if(!empty($poll_info)) {
		if($poll_info['abuse'] == "Y") {
			$abuse_list = explode(",",$poll_info[abtxt]);
			for($ii=0; $ii < count($abuse_list); $ii++){
				$abuse_list[$ii] = trim($abuse_list[$ii]);
				if(!empty($abuse_list[$ii])){
					if( strpos($str, $abuse_list[$ii]) !== false){
						error("'$abuse_list[$ii]' 단어는 사용하실 수 없습니다.");
					}
				}
			}
		}
	}

}

// 이미지 리사이즈
function img_resize($srcimg, $dstimg, $imgpath, $rewidth, $reheight, $mode=""){
	// $src_info[0] : width, $src_info[1] : height, $src_info[2] : type
	$src_info = getimagesize($imgpath."/".$srcimg);

	if(!strcmp($src_info['channels'], "4")) {
		//echo "<script>alert('현재 업로드하신 이미지는 CMYK 형식입니다. \\n\\n웹상에서 보이지 않을 수 있습니다.');</script>";
	}

	if($rewidth < $src_info[0] || $reheight < $src_info[1] ){

		if(!strcmp($mode, "width")) {

			$reheight = round(($src_info[1]*$rewidth)/$src_info[0]);

		} else {

			if(($src_info[0]-$rewidth) > ($src_info[1]-$reheight)){
				$reheight = round(($src_info[1]*$rewidth)/$src_info[0]);
			}else{
				$rewidth = round(($src_info[0]*$reheight)/$src_info[1]);
			}

		}

	}else{
		copy($imgpath."/".$srcimg,$imgpath."/".$dstimg);
		return;
	}

	if(function_exists(imageCreatetrueColor)) {

		$dst = @imageCreatetrueColor($rewidth,$reheight);

		if($src_info[2] == 1){

			$src = @ImageCreateFromGIF($imgpath."/".$srcimg);
			@imagecopyResampled($dst, $src,0,0,0,0,$rewidth,$reheight,ImageSX($src),ImageSY($src));
			@Imagejpeg($dst,$imgpath."/".$dstimg,100);

		}else if($src_info[2] == 2){

			$src = @ImageCreateFromJPEG($imgpath."/".$srcimg);
			@imagecopyResampled($dst, $src,0,0,0,0,$rewidth,$reheight,ImageSX($src),ImageSY($src));
			@Imagejpeg($dst,$imgpath."/".$dstimg,100);

		}else if($src_info[2] == 3){

			$src = @ImageCreateFromPNG($imgpath."/".$srcimg);

			imageAlphaBlending($dst, false);
			imagesavealpha($dst, true);

			@imagecopyResampled($dst, $src,0,0,0,0,$rewidth,$reheight,ImageSX($src),ImageSY($src));
			@Imagepng($dst,$imgpath."/".$dstimg);

		}else{

			copy($imgpath."/".$srcimg,$imgpath."/".$dstimg);

		}

		@imageDestroy($src);
		@imageDestroy($dst);

	} else {

			link($imgpath."/".$srcimg,$imgpath."/".$dstimg);

	}

}

// 파일이 이미지인지
function img_type($srcimg){
	if(is_file($srcimg)){

		$image_info = getimagesize($srcimg);
		switch ($image_info['mime']) {
			case 'image/gif': return true; break;
			case 'image/jpeg': return true; break;
			case 'image/png': return true; break;
			case 'image/bmp': return true; break;
			default : return false; break;
		}
	}else{
		return false;
	}

}

// 페이지 리스트 출력
function print_pagelist($page, $list_amount, $page_count, $param, $page_type = ""){

   global $code, $catcode, $orderby, $skin_dir, $ptype;

   if($skin_dir == "") $skin_dir = "/adm/manage";
   if($param != "") $param = "&".$param;

	if(($page%$list_amount) == 0) $tmp = $page-1;
	else $tmp = $page;

	$spage = floor($tmp/$list_amount)*$list_amount+1;
	if($spage <= 1) $ppage = 1;
	else $ppage = $spage - $list_amount;

	$epage = $spage+$list_amount-1;
	if($epage >= $page_count){
		$epage = $page_count;
		$npage = $page_count;
	}else{
		$npage = $epage + 1;
	}

	if(!empty($page_type)) {
		$page_name = strtolower($page_type)."page";
	} else {
		$page_name = "page";
	}

	if($epage > 0) {
		echo "    <table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td align='center'>";
		echo "      <table id='pager' border='0' cellspacing='0' cellpadding='0'>";
		echo "        <tr>";
		echo "          <td width='22' height='50'><a class='page_backward' href='$PHP_SELF?ptype=$ptype&$page_name=1$param'></a></td>";
		echo "          <td width='22'><a class='page_back5' href='$PHP_SELF?ptype=$ptype&$page_name=$ppage$param'></a></td>";
		echo "          <td style='width:10px;border:none !important;'></td>";

		for($spage; $spage <= $epage; $spage++){
			 if($page == $spage) echo "<td class='current_page'>$spage</td>";
			 else echo "<td><a href='$PHP_SELF?ptype=$ptype&$page_name=$spage$param'> $spage </a></td>";
		}

		echo "          &nbsp; </td>";
		echo "          <td style='width:10px;border:none !important;'></td>";
		echo "          <td width='22' align='right'><a class='page_5' href='$PHP_SELF?ptype=$ptype&$page_name=$npage$param'></a></td>";
		echo "          <td width='22' align='right'><a class='page_forward' href='$PHP_SELF?ptype=$ptype&$page_name=$page_count$param'></a></td>";
		echo "        </tr>";
		echo "      </table>";
	 echo "    </td></tr></table>";

	}

}

// 게시판 저장
function save_bbs($code, $name, $email, $subject, $ctype, $content, $passwd=""){

  global $DOCUMENT_ROOT;
  global $upfile1, $upfile1_size, $upfile1_name;
  global $upfile2, $upfile2_size, $upfile2_name;
  global $upfile3, $upfile3_size, $upfile3_name;

	$sql = "select max(prino) as prino from wiz_bbs where code = '$code'";
	$result = mysql_query($sql) or error(mysql_error());
	if($row = mysql_fetch_object($result)){
		$prino = $row->prino+1;
	}

	$upfile_idx = date('Ymdhis').rand(1,9);
	if(!is_dir("$_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code")){
		echo exec("mkdir $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code");
		exec("chmod 705 $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code");
	}

	if($upfile1_size > 0){
		$upfile1_tmp = $upfile_idx.".".substr($upfile1_name,-3);
		exec("cp $upfile1 $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code/$upfile1_tmp");
		exec("chmod 606 $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code/$upfile1_tmp");
	}
	if($upfile2_size > 0){
		$upfile2_tmp = $upfile_idx.".".substr($upfile2_name,-3);
		exec("cp $upfile2 $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code/$upfile2_tmp");
		exec("chmod 606 $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code/$upfile2_tmp");
	}
	if($upfile3_size > 0){
		$upfile3_tmp = $upfile_idx.".".substr($upfile3_name,-3);
		exec("cp $upfile3 $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code/$upfile3_tmp");
		exec("chmod 606 $_SERVER[DOCUMENT_ROOT]/wizhome/bbs/upfile/$code/$upfile3_tmp");
	}

	$authkey = rand(0,999);
	$content = str_replace("'","",$content);
	$content = str_replace("\"","",$content);
	$sql = "insert into wiz_bbs(idx,code,prino,depno,notice,name,email,subject,content,ctype,upfile,upfile2,upfile3,upfile_name,upfile2_name,upfile3_name,wdate,passwd,authkey)
	                           values('', '$code', '$prino', '', '','$name', '$email', '$subject', '$content', '$ctype', '$upfile1_tmp', '$upfile2_tmp', '$upfile3_tmp', '$upfile1_name', '$upfile2_name', '$upfile3_name', now(), '$passwd','$authkey')";

	mysql_query($sql) or error(mysql_error());

}

function info_replace($site_info, $re_info, $msg, $order_info = ""){

	global $_http_host;

	$date = date('Y')."년 ".date('m')."월 ".date('d')."일";

	$msg = str_replace("{DATE}", $date, $msg);
	$msg = str_replace("{MEM_ID}", $re_info[id], $msg);
	$msg = str_replace("{MEM_PW}", $re_info[passwd], $msg);
	$msg = str_replace("{MEM_NAME}", $re_info[name], $msg);
	$msg = str_replace("{SITE_NAME}", $site_info[site_name], $msg);
	$msg = str_replace("{SITE_EMAIL}", $site_info[site_email], $msg);
	$msg = str_replace("{SITE_TEL}", $site_info[site_tel], $msg);
	$msg = str_replace("{SITE_URL}", "http://".$_http_host, $msg);

	$msg = str_replace("{SHOP_NAME}", $site_info[site_name], $msg);
	$msg = str_replace("{SHOP_EMAIL}", $site_info[site_email], $msg);
	$msg = str_replace("{SHOP_TEL}", $site_info[site_tel], $msg);
	$msg = str_replace("{SHOP_URL}", "http://".$_http_host, $msg);
	$msg = str_replace("{ORDER_INFO}", $order_info, $msg);

	return $msg;

}

function site_replace($site_info, $re_info, $msg){

	global $_http_host;

	$date = date('Y')."년 ".date('m')."월 ".date('d')."일";

	$msg = str_replace("{SITE_URL}", "http://".$_http_host, $msg);

	return $msg;

}

// 이메일 발송
function send_mail($se_name, $se_email, $re_name, $re_email, $subject, $content, $cc="", $bcc=""){

	$charset  = "utf-8";

	$se_name   = "=?$charset?B?" . base64_encode($se_name) . "?=";
	$subject = "=?$charset?B?" . base64_encode($subject) . "?=";

	//$header  = "Return-Path: <$se_email>\n";
	$header .= "From: $se_name <$se_email>\n";
	$header .= "Reply-To: <$se_email>\n";
	if ($cc)  $header .= "Cc: $cc\n";
	if ($bcc) $header .= "Bcc: $bcc\n";
	$header .= "MIME-Version: 1.0\n";

	$header .= "Content-Type: TEXT/HTML; charset=$charset\n";
	$content = stripslashes($content);

	$header .= "Content-Transfer-Encoding: BASE64\n\n";
	$header .= chunk_split(base64_encode($content)) . "\n";

	$result = @mail($re_email, $subject, "", $header, "-f<server@uxi.kr>");

	return $result;

}


// SMS 발송
function send_sms($se_num, $re_num, $message, $se_name=""){

	global $site_info;

	// if(strlen($message) > 80){
	// 	include_once $_SERVER[DOCUMENT_ROOT]."/ext/SMS/sms.php";
	// 	send_icodesms($re_num,$se_num, "", $message);
	// 	return;
	// }

	/**************************************************************************************
		SMS 클래스 사용 예제입니다.
	**************************************************************************************/
	include_once WIZHOME_PATH."/inc/class.sms.php";

	$sms_server	= "211.172.232.124";	## SMS 서버
	$sms_id		= $site_info[sms_id];				## icode 아이디
	$sms_pw		= $site_info[sms_pw];				## icode 패스워드
	//$portcode	= 1;				## 정액제 : 2, 충전식 : 1
	if($site_info[sms_type] == "" || $site_info[sms_type] == "C") $portcode = 1;
	else if($site_info[sms_type] == "J") $portcode = 2;

	$SMS	= new SMS;
	$SMS->SMS_con($sms_server,$sms_id,$sms_pw,$portcode);

	/**************************************************************************************
	1단계: 보낼 메시지를 저장합니다. 쇼핑몰에서 장바구니에 물건을 담는다고 생각하면 됩니다.

		일반 메시지를 보낼 경우 SMS->Add() 를 사용합니다. 인자는 다음과 같습니다.
			1. 받는 사람 핸드폰 번호
			2. 보내는 사람 전화 (회신번호)
			3. 보내는 사람 이름
			4. 보내는 메시지 (80자 이내)
			5. 예약시간 (12자 - 예약발송일 경우에만 입력. 예: 2001년 5월30일 오후2시30분이면 200105301430)

		URL을 보낼 경우 SMS->AddURL() 을 사용합니다. 인자는 다음과 같습니다.
			1. 받는 사람 핸드폰 번호
			2. URL (50자 이내)
			3. 보내는 메시지 (80자 이내)
			4. 예약시간 (12자 - 예약발송일 경우에만 입력. 예: 2001년 5월30일 오후2시30분이면 200105301430)

		잘못된 값이 들어갔을 경우 에러메시지가 리턴됩니다.

		※ .URL 콜백의 경우 건당 50원의 요금이 부과 됩니다.
		※ .SKT(011,017) 번호로 발송하실 경우 사용자 동의를 받지 않아 전송 실패일 경우에도
		    정상적으로 요금이 청구 됩니다.
		※ .KTF(016,018) 번호로 발송하실 경우 회신번호를 반드시 입력하셔야 정상적으로 송신이 됩니다.
	**************************************************************************************/

	$tran_phone	= str_replace("-", "", $re_num);		# 수신번호
	$tran_callback	= str_replace("-", "", $se_num);			# 회신번호
	$tran_msg		= $message;	# 발송 메세지
	$tran_date	= "";				#발송시간
	#즉시 전송일 경우 $tran_date	= "" ;
	#예약 전송일 경우 $tran_date	= "200412312359";	# 2004년 12월 31일 23시 59분

	$result = $SMS->Add($tran_phone,"$tran_callback","$sms_id","$tran_msg","$tran_date");
	//if ($result) echo $result; else echo "일반메시지 입력 성공<BR>";

	//$result = $SMS->AddURL($tran_phone,"$tran_callback","w.yahoo.co.kr","테스트입니다","");
	//if ($result) echo $result; else echo "URL 입력 성공<BR>";
	//echo "<HR>";

	/**************************************************************************************
	2단계: 저장해둔 메시지를 전송합니다. 쇼핑몰에서 결제를 한다고 생각하면 됩니다.

		SMS->Send() 를 실행하면 모아둔 메시지를 모두 발송합니다.
		이때 SMS->Send()가 리턴하는 값은 true, false 입니다.
		이것은 서버와의 접속 상태를 나타냅니다.

		SMS->Send() 를 실행하고 난 후에는 메시지 발송 결과를 조회할 수 있습니다.
		메시지 발송 결과는 SMS->Result 배열에 저장되어 있습니다.
		데이타 형식은 "핸드폰 번호 : 메시지 고유번호" 입니다. 예) 0115511474:13622798
		전송이 제대로 되지 않은 건에 대해서는 에러 표시가 납니다. 예) 0195200107:Error

		만약 같은 클래스를 재사용할 경우, SMS->Init() 명령으로 메시지 발송 결과를 없애주십시오.
	**************************************************************************************/

	$result = $SMS->Send();
	if ($result) {
		//echo "SMS 서버에 접속했습니다.<br>";
		$success = $fail = 0;
		foreach($SMS->Result as $result) {
			list($phone,$code)=explode(":",$result);
			if ($code=="Error") {
				//echo $phone.'로 발송하는데 에러가 발생했습니다.<br>';
				$fail++;
			} else {
				//echo $phone."로 전송했습니다. (메시지번호:".$code.")<br>";
				$success++;
			}
		}
		//echo $success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
		$SMS->Init(); // 보관하고 있던 결과값을 지웁니다.
	} else {
		//echo "에러: SMS 서버와 통신이 불안정합니다.<br>";
	}

	//echo "<table width='100%'><tr><td align='center'><span onClick='self.close()' style='cursor:pointer'>[닫기]</span></td></tr></table>";

}

// 메일내용 생성
function send_mailsms($type, $re_info, $ordmail=""){

	global $site_info;

	// 관리자 정보 가져오기
	include WIZHOME_PATH."/inc/site_info.php";

	$se_name = $site_info[site_name];
	$se_email = $site_info[site_email];
	$se_tel = $site_info[site_tel];
	$se_hand = $site_info[site_hand];

	// 메일/sms 발송내용 가져오기
	$mail_info = get_table("wiz_mailsms", "code = '$type'");

	$mail_info[email_subj] = info_replace($site_info, $re_info, $mail_info[email_subj]);
	$mail_info[email_msg] = info_replace($site_info, $re_info, $mail_info[email_msg], $ordmail);
	$mail_info[sms_msg] = info_replace($site_info, $re_info, $mail_info[sms_msg]);
	$mail_info[email_msg] = stripslashes($mail_info[email_msg]);

	if($mail_info[email_send] == "Y"){
		send_mail($se_name, $se_email, $re_info[name], $re_info[email], $mail_info[email_subj], $mail_info[email_msg]);
	}
	if($mail_info[email_oper] == "Y"){
		send_mail($se_name, $se_email, $se_name, $se_email, $mail_info[email_subj], $mail_info[email_msg]);
	}

	if($mail_info[sms_send] == "Y"){
		send_sms($se_tel, $re_info[hphone], $mail_info[sms_msg], $se_name);
	}
	if($mail_info[sms_oper] == "Y"){
		send_sms($se_tel, $se_hand, $mail_info[sms_msg], $se_name);
	}
}


// 중복로그인 방지 세션삭제
function del_session($id){

	$sess_path = WIZHOME_PATH."/data/session";
	$dirlist = opendir($sess_path);

	while($file = readdir($dirlist)){
		if ($file != "." && $file != "..") {
			$sline = file($sess_path."/".$file,"r");
			$slist = explode(";",$sline[0]);
			$slist = explode(":",$slist[1]);
			if ($slist[2] == "\"".$id."\"") unlink($sess_path."/".$file);
		}
	}

}


// 포인트 저장
function save_point($ptype, $memid, $mode = "", $bidx = "", $cidx = "", $midx = ""){

	global $code;
	global $wiz_session;

	include WIZHOME_PATH."/inc/site_info.php";
	include WIZHOME_PATH."/inc/bbs_info.php";

	if(!strcmp($site_info[point_use], "Y") && !empty($memid)) {

		$mem_point = get_point($memid);

		$save = "Y";

		if(!strcmp($ptype, "JOIN")) {
			$point = $site_info[join_point];
			$memo = "회원가입 포인트";
		}

		if(!strcmp($ptype, "LOGIN")) {
			$point = $site_info[login_point];
			$memo = "로그인 포인트";

			$sql = "select idx from wiz_point where memid = '$memid' and ptype = 'LOGIN' and DATE_FORMAT(wdate, '%Y%m%d') = '".date('Ymd')."'";
			$result = mysql_query($sql) or error(mysql_error());
			$login_cnt = mysql_num_rows($result);

			if($login_cnt > 0) $save = "N";

		}

		if(!strcmp($ptype, "MSG")) {
			$point = $site_info[msg_point];
			$memo = "쪽지 보내기 포인트";
		}

		if(!strcmp($ptype, "BBS")) {
			if(!strcmp($mode, "view")) {
				$point = $bbs_info[view_point];
				$memo = "게시판 보기 포인트";
			}
			if(!strcmp($mode, "write")) {
				$point = $bbs_info[write_point];
				$memo = "게시판 글쓰기 포인트";

			}
			if(!strcmp($mode, "down")) {
				$point = $bbs_info[down_point];
				$memo = "게시판 다운로드 포인트";
			}
			if(!strcmp($mode, "recom")) {
				$point = $bbs_info[recom_point];
				$memo = "게시판 추천 포인트";
			}
		}

		if(!strcmp($ptype, "COMMENT")) {
			$sql = "select code from wiz_bbs where idx = '$bidx'";
			$result = mysql_query($sql) or error(mysql_error());
			$row = mysql_Fetch_array($result);
			$code = $row[code];

			include WIZHOME_PATH."/inc/bbs_info.php";

			$point = $bbs_info[comment_point];
			$memo = "게시판 덧글 포인트";
		}

		if($mem_point + $point < 0) {
			$save = "N";
			error($bbs_info[point_msg]);
		}

		if(!strcmp($site_info[point_use], "Y") && !strcmp($save, "Y") && $point != 0) {
			$sql = "insert into wiz_point (idx,bidx,cidx,midx,ptype,mode,memid,point,memo,wdate)
							values('','$bidx','$cidx','$midx','$ptype','$mode','$memid','$point','$memo',now())";
			mysql_query($sql) or error(mysql_error());
		}

	}
}

// 포인트 삭제
function delete_point($ptype, $memid, $mode = "", $bidx = "", $cidx = "", $midx = ""){

	include WIZHOME_PATH."/inc/site_info.php";

	if(!strcmp($site_info[point_use], "Y")) {
		if(!strcmp($ptype, "BBS")) {

			$where_sql = " and bidx = '$bidx' and mode = '$mode' ";
			if(!strcmp($mode, "view")) $memo = "게시글 보기 포인트 삭제";
			if(!strcmp($mode, "write")) $memo = "게시글 삭제";
			if(!strcmp($mode, "down")) $memo = "게시글 다운로드 포인트 삭제";

		} else if(!strcmp($ptype, "COMMENT")) {

			$where_sql = " and cidx = '$cidx' ";
			$memo = "덧글 삭제";

		} else if(!strcmp($ptype, "MSG")) {

			$where_sql = " and midx = '$midx' ";
			$memo = "쪽지 삭제";

		}

		$sql = "select point from wiz_point where memid = '$memid' $where_sql";
		$result = mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_array($result);

		if($row[point] > 0) $point = "-".$row[point];
		else $point = abs($row[point]);

		if(!empty($memid) && $point != 0) {

			$sql = "insert into wiz_point (idx,bidx,cidx,midx,ptype,mode,memid,point,memo,wdate)
							values('','$bidx','$cidx','$midx','$ptype','$mode','$memid','$point','$memo',now())";
			mysql_query($sql) or error(mysql_error());

		}
	}
}

// 회원 포인트
function get_point($memid){

	include WIZHOME_PATH."/inc/site_info.php";

	if(!strcmp($site_info[point_use], "Y")) {
		$sql = "select sum(point) as total_point from wiz_point where memid = '$memid' and memid != ''";
		$result = mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_array($result);

		return $row[total_point];
	}
}

// 포인트 체크 포인트가 부족할때 false 충분할때 true
function check_point($memid, $point){

	global $wiz_session;

	include WIZHOME_PATH."/inc/site_info.php";

	if(!strcmp($site_info[point_use], "Y") && $wiz_session[level] > 0) {
		$mem_point = get_point($memid);
		if($mem_point + $point < 0) return false;
		else return true;
	} else {
		return true;
	}
}

// 파일 확장자 체크
function file_check($filename, $file_str = "php|htm|html|inc|htm|shtm|ztx|dot|cgi|pl|phtm|ph|exe"){

	$fnames = explode(".", $filename);
	$fext = $fnames[count($fnames)-1];
	$fext = strtolower($fext);
	$file_str = strtolower($file_str);

	//업로드 금지 확장자 체크
	if(eregi($file_str, $fext)) {
		error("해당 파일은 업로드할 수 없는 형식입니다.");
		exit;
	}

}

// 연결 페이지 업데이트
function update_page($type){
/*
	global $code;
	global $catcode;
	global $PHP_SELF;

	if(strpos($PHP_SELF,"/manage/") == false) {

		switch ($type) {
			case "MEM_JOIN"		: $table = "wiz_meminfo"; $field = "join_url"; break;
			case "MEM_LOGIN"	: $table = "wiz_meminfo"; $field = "login_url"; break;
			case "MEM_IDPW" 	: $table = "wiz_meminfo"; $field = "idpw_url"; break;
			case "MEM_INFO" 	: $table = "wiz_meminfo"; $field = "myinfo_url"; break;
			case "MESSAGE" 		: $table = "wiz_siteinfo"; $field = "msg_url"; break;
			case "POINT" 			: $table = "wiz_siteinfo"; $field = "point_url"; break;
			case "SCH" 				: $table = "wiz_bbsinfo"; $field = "pageurl"; break;
			case "BBS" 				: $table = "wiz_bbsmain"; $field = "purl"; break;
			case "PRD" 				: $table = "wiz_category"; $field = "purl"; break;
			case "POLL" 			: $table = "wiz_pollinfo"; $field = "purl"; break;
			case "SEARCH"			: $table = "wiz_siteinfo"; $field = "search_url"; break;

			case "BASKET"			: $table = "wiz_prdinfo"; $field = "basket_url"; break;
			case "ORDER"			: $table = "wiz_prdinfo"; $field = "order_url"; break;
			case "ORDER_LIST"	: $table = "wiz_prdinfo"; $field = "order_list_url"; break;
			case "PRDSEARCH"	: $table = "wiz_prdinfo"; $field = "search_url"; break;
			case "WISHLIST"	: $table = "wiz_prdinfo"; $field = "wish_url"; break;
		}

		if(empty($table) || empty($field)) {
			alert("연결 페이지 업데이트를 위한 함수를 정상적으로 불러들이지 못하였습니다. \\n\\n해당 페이지를 확인해주세요.");
		} else {

			$this_page = substr($PHP_SELF, 1, strlen($PHP_SELF));

			if(!empty($code) && (!strcmp($table, "wiz_bbsinfo") || !strcmp($table, "wiz_bbsmain") || !strcmp($table, "wiz_pollinfo"))) $code_sql = " where code = '$code' ";
			if(!empty($catcode) && !strcmp($table, "wiz_category")) {

				if($catcode != ""){

					$catcode01 = str_replace("00","",substr($catcode,0,2));
					$catcode02 = str_replace("00","",substr($catcode,2,2));
					$catcode03 = str_replace("00","",substr($catcode,4,2));
					$tmp_code = $catcode01.$catcode02.$catcode03;

					if($tmp_code != "") $catcode_sql = " where catcode like '$tmp_code%' ";
					else $catcode_sql = " where catcode = '$catcode' ";

					$code_sql = "";

				}

			}
			$sql = "select $field from $table $code_sql $catcode_sql";
			$result = mysql_query($sql) or error(mysql_error());

			while($row = mysql_fetch_array($result)) {

				if(strcmp($row[$field], $this_page)) {
					$sql = "update $table set $field = '$this_page' $code_sql $catcode_sql";
					mysql_query($sql) or error(mysql_error());
				}

			}

		}

	}
*/
}

// 보기페이지 이미지 리사이즈
function view_img_resize(){

	global $_ResizeCheck;

	if($_ResizeCheck) {
?>
<!-- 이미지 리사이즈를 위해서 처리하는 부분 -->
<script>
	function wiz_img_check(){
		//var wiz_main_table_width = document.wiz_get_table_width.width;
		var wiz_main_table_width = document.getElementById('wiz_get_table_width').style.width;
		wiz_main_table_width = wiz_main_table_width.replace("px", "");
		var wiz_target_resize_num = document.wiz_target_resize.length;
		for(i=0;i<wiz_target_resize_num;i++){
			if(document.wiz_target_resize[i].width > wiz_main_table_width) {
				document.wiz_target_resize[i].width = wiz_main_table_width;
			}
		}
	}
	window.onload = wiz_img_check;
</script>

<?
	}

}

// 자동등록방지코드 생성
function get_spam_check(){

	global $is_norobot;
	global $norobot_img;
	global $norobot_msg;
	global $norobot_key;
	global $spam_check;

	global $form_info;	// 폼메일 자동등록방지 코드 생성 시 필요

	if(!empty($form_info[idx])) $idx = $form_info[idx];

	$is_norobot = false;

	$tmp_str = substr(md5(rand()),0,12); // 임의의 md5 문자열을 생성

	list($usec, $sec) = explode(' ', microtime()); // 난수 발생기
	$seed =  (float)$sec + ((float)$usec * 100000);
	srand($seed);
	$keylen = strlen($tmp_str);
	$div = (int)($keylen / 2);
	while (count($arr) < 6)
	{
	    unset($arr);
	    for ($i=0; $i<$keylen; $i++)
	    {
	        $rnd = rand(1, $keylen);
	        $arr[$rnd] = $rnd;
	        if ($rnd > $div) break;
	    }
	}

	sort($arr);	// 배열에 저장된 숫자를 차례대로 정렬

	$norobot_key = "";
	$norobot_str = "";
	$m = 0;

	for ($i=0; $i<count($arr); $i++)
	{
	    for ($k=$m; $k<$arr[$i]-1; $k++)
	        $norobot_str .= $tmp_str[$k];
	    $norobot_str .= "<font size=3 color=#FF0000><b>{$tmp_str[$k]}</b></font>";
	    $norobot_key .= $tmp_str[$k];
	    $m = $k + 1;

	}

	if ($m < $keylen) {
	    for ($k=$m; $k<$keylen; $k++)
	        $norobot_str .= $tmp_str[$k];
	}

	$norobot_str = "<font color=#999999>$norobot_str</font>";

	$ss_norobot_key = $norobot_key;
	$is_norobot = true;

	if (function_exists("imagecreate")) {	// 이미지 생성이 가능한 경우 자동등록체크코드를 이미지로 생성
	  $norobot_img = "<img src='/adm/bbs/norobot_image.php?ss_norobot_key=$norobot_key' border='0' style='border: 1px solid #343d4f;' align='absmiddle'>";
	  $norobot_msg = "<font class='comment left10'>* 왼쪽의 자동등록방지 코드를 입력하세요.</font>";
	}
	else {
	 $norobot_img = $norobot_str;
	 $norobot_msg = "* 왼쪽의 글자중 <FONT COLOR='red'>빨간글자</font>만 순서대로 입력하세요.";
	}
	$spam_check = $norobot_img." <input type='text' name='vcode' id='vcode' class='input w100' />".$norobot_msg;

	?>
	<script Language="JavaScript" src="/adm/js/md5.js"></script>
	<script language="javascript">
	<!--

	function hex_md5(s) {
		return binl2hex(core_md5(str2binl(s), s.length * chrsz));
	}
	var md5_norobot_key<?=$idx?> = "<?=md5($norobot_key)?>";

	String.prototype.trim = function() {
		return this.replace(/^\s+|\s+$/g, "");
	}

	//-->
	</script>
<?
}

// 디렉토리 삭제
function rm_dir($path){
	$oDir = @openDir($path);
	while($entry = @readDir($oDir)) {
		if($entry <> '.' && $entry <> '..') {
			if(Is_Dir($path.'/'.$entry)) {
				rm_dir ($path.'/'.$entry);
			} else {
				@UnLink ($path.'/'.$entry);
			}
		}
	}
	@closeDir($oDir);
	@RmDir($path);
}

//SQL 입력값 문자열 필터
//$str = 입력 문자열
function sql_filter($str){
	//1단계 ? ',",NULL 문자 필터링. 각 문자들에 백슬래쉬(\) 삽입됨. 필수 항목
	//출력시 stripslashes()함수를 이용하여 백슬래쉬(\)를 제거
	if (!get_magic_quotes_gpc()) $str = addslashes($str);

	//3단계 ? 특수 문자 및 문자열 필터링
	//WHERE 구문에서 쓰여지는 데이터만 사용하는 것이 바람직하다.
	$search = array("--","#",";");
	$replace = array("\--","\#","\;");
	$str = str_replace($search, $replace, $str);

	return $str;
}

function xss_check($get_String, $get_HTML = true){

	// xss_check (Cross Site Script) 막기
	$get_String = preg_replace("/(on)([a-z]+)([^a-z]*)(\=)/i", "&#111;&#110;$2$3$4", $get_String);
	$get_String = preg_replace("/(dy)(nsrc)/i", "&#100;&#121;$2", $get_String);
	$get_String = preg_replace("/(lo)(wsrc)/i", "&#108;&#111;$2", $get_String);
	$get_String = preg_replace("/(sc)(ript)/i", "&#115;&#99;$2", $get_String);
	$get_String = preg_replace("/(ex)(pression)/i", "&#101&#120;$2", $get_String);

   if(!$get_HTML) {
	  $get_String = STR_REPLACE( "<", "&lt;", $get_String );
	  $get_String = STR_REPLACE( ">", "&gt;", $get_String );
   }
   return $get_String;

}

// 문자열 변환 in_charset → out_charset
function str_conv($str, $mode){
	if(!strcmp(strtolower($mode), 'euc-kr')) {
		$in_charset = "utf-8";
		$out_charset = "euc-kr";
	} else if(!strcmp(strtolower($mode), 'utf-8')) {
		$in_charset = "euc-kr";
		$out_charset = "utf-8";
	}

	if(iconv($out_charset,$out_charset,$str)==$str) return $str;
	else return iconv($in_charset,$out_charset,$str);
}


// 로봇 체크
function check_robots($user_agent){
	$robots = array('1Noonbot', 'Accoona-AI-Agent', 'Allblog.net', 'Baiduspider', 'Blogbeat', 'Crawler', 'DigExt', 'DrecomBot', 'Exabot', 'FeedChecker', 'FeedFetcher', 'Gigabot', 'Googlebot', 'HMSE_Robot', 'IP*Works!', 'IRLbot', 'Jigsaw', 'LWP::Simple', 'Labrador', 'MJ12bot', 'Mirror Checking', 'Missigua Locator', 'NG/2.0', 'NaverBot', 'NutchCVS', 'PEAR HTTP_Request', 'PostFavorites', 'SBIder', 'W3C_Validator', 'WISEbot', 'Y!J-BSC', 'Yahoo! Slurp', 'ZyBorg', 'archiver', 'carleson', 'cfetch', 'compatible; Eolin', 'favicon', 'feedfinder', 'findlinks', 'genieBot', 'ichiro', 'kinjabot', 'larbin', 'lwp-trivial', 'msnbot', 'psbot', 'sogou', 'urllib/1.15', 'voyager');
	foreach($robots as $robot)
		if(strpos($user_agent, $robot) !== false)
			return false;
	return true;
}

// OS,브라우저 정보
function get_osbrowser($user_agent){

$agent=strtolower($user_agent);



if (preg_match("/msie ([1-9][0-9]\.[0-9]+)/", $agent, $m)) { $s = 'MSIE '.$m[1]; }
    else if(preg_match("/firefox/", $agent))            { $s = "FireFox"; }
    else if(preg_match("/chrome/", $agent))             { $s = "Chrome"; }
    else if(preg_match("/x11/", $agent))                { $s = "Netscape"; }
    else if(preg_match("/opera/", $agent))              { $s = "Opera"; }
    else if(preg_match("/gec/", $agent))                { $s = "Gecko"; }
    else if(preg_match("/bot|slurp/", $agent))          { $s = "Robot"; }
    else if(preg_match("/internet explorer/", $agent))  { $s = "IE"; }
    else if(preg_match("/mozilla/", $agent))            { $s = "Mozilla"; }
    else { $s = "etc"; }


$browser=$s;



 if (preg_match("/windows 98/", $agent))                 { $s = "98"; }
    else if(preg_match("/windows 95/", $agent))             { $s = "95"; }
    else if(preg_match("/windows nt 4\.[0-9]*/", $agent))   { $s = "NT"; }
    else if(preg_match("/windows nt 5\.0/", $agent))        { $s = "2000"; }
    else if(preg_match("/windows nt 5\.1/", $agent))        { $s = "XP"; }
    else if(preg_match("/windows nt 5\.2/", $agent))        { $s = "2003"; }
    else if(preg_match("/windows nt 6\.0/", $agent))        { $s = "Vista"; }
    else if(preg_match("/windows nt 6\.1/", $agent))        { $s = "Windows7"; }
    else if(preg_match("/windows nt 6\.2/", $agent))        { $s = "Windows8"; }
    else if(preg_match("/windows 9x/", $agent))             { $s = "ME"; }
    else if(preg_match("/windows ce/", $agent))             { $s = "CE"; }
    else if(preg_match("/mac/", $agent))                    { $s = "MAC"; }
    else if(preg_match("/linux/", $agent))                  { $s = "Linux"; }
    else if(preg_match("/sunos/", $agent))                  { $s = "sunOS"; }
    else if(preg_match("/irix/", $agent))                   { $s = "IRIX"; }
    else if(preg_match("/phone/", $agent))                  { $s = "Phone"; }
    else if(preg_match("/bot|slurp/", $agent))              { $s = "Robot"; }
    else if(preg_match("/internet explorer/", $agent))      { $s = "IE"; }
    else if(preg_match("/mozilla/", $agent))                { $s = "Mozilla"; }
    else { $s = "etc"; }

$os=$s;




	$data["browser"] = $browser;
	$data["os"] = $os;

	return $data;

}

// 게시물 번호 ($no)
function get_bbs_no($data) {

	global $bbs_info, $wiz_session;
	@extract($data);

	// 게시물 쿼리
	if($category) $category_sql = " and category = '$category' ";
	if($searchopt) {
		if(!strcmp($searchopt, "subcon")) $search_sql = " and (subject like '%$searchkey%' or content like '%$searchkey%') ";
		else $search_sql = " and $searchopt like '%$searchkey%' ";
	}
	// 자신이 쓴 글 또는 자신의 글에 달린 답변글
	if($mybbs) $my_sql = " and (memid='$wiz_session[id]' or memgrp like '".$wiz_session[id].",%')";
	if($sido) $address_sql = " and address like '".$sido."%' ";
	if($gugun) $address_sql .= " and address like '%".$gugun."%' ";

	$sql = "select idx from wiz_bbs where code = '$code' $my_sql $category_sql $search_sql $address_sql order by prino desc";
	$result = mysql_query($sql) or error(mysql_error());
	$total = mysql_num_rows($result);

	$rows = $bbs_info[rows];
	$lists = $bbs_info[lists];
	if($rows == "") $rows = "20";
	if($lists == "") $lists = "5";

	$ttime = mktime(0,0,0,date('m'),date('d'),date('Y'));
	$page_count = ceil($total/$rows);
	if(!$page || $page > $page_count) $page = 1;
	$start = ($page-1)*$rows;
	$no = $total-$start;

	$sql = "select wb.*,wb.wdate as wtime,from_unixtime(wb.wdate, '".$bbs_info[datetype_list]."') as wdate, wc.catname, wc.caticon
					from wiz_bbs as wb inner join wiz_bbscat as wc on wb.category = wc.idx
					where wb.code = '$code' $category_sql $search_sql $my_sql $address_sql
					order by wb.prino desc limit $start, $rows";

	$result = mysql_query($sql) or error(mysql_error());

	while($row = mysql_fetch_array($result)){
		if($row[idx] == $idx) break;
		$no--;
	}

	return $no;
}

/******************************************************************
*			 WizShop basket : SESSION -> DATABASE 변경
******************************************************************/

//쿠키 생성
function makeCookie( $name, $valuename, $exptime = "" ) {
	if(empty($exptime) || !$exptime){
		@setcookie("$name","$valuename","0","/");
	}else{
		@setcookie("$name","$valuename","$exptime","/");

	}
}

//장바구니를 위한 유니크 쿠키생성
function makeBasketCookie(){
	//쿠키가 생성되어있지 않으면 고유값 생성해서 만들기
	if(empty($_COOKIE["uniq_id"])){
		$basketid = md5($REMOTE_ADDR.time());
		makeCookie("uniq_id",$basketid,time()+3600*30*24); //쿠키시간 지정
		return $basketid;
	}
}

makebasketCookie();

// 결제방법
function pay_method($pay_method)
{

   if($pay_method == "PB") $pay_method = "무통장입금";
   else if($pay_method == "PC") $pay_method = "신용카드";
   else if($pay_method == "PN") $pay_method = "계좌이체";
   else if($pay_method == "PV") $pay_method = "가상계좌";
   else if($pay_method == "PH") $pay_method = "휴대폰";

   return $pay_method;
}

// 배송상태
function order_status($status)
{

   if($status == "OR") $status = "주문접수";
   else if($status == "OY") $status = "결제완료";
   else if($status == "DR") $status = "배송준비중";
   else if($status == "DI") $status = "배송처리";
   else if($status == "DC") $status = "배송완료";
   else if($status == "OC") $status = "주문취소";
   else if($status == "RD") $status = "취소요청";
   else if($status == "RC") $status = "취소완료";
   else if($status == "CD") $status = "교환요청";
   else if($status == "CC") $status = "교환완료";

   return $status;
}

/******************************************************************
*			 결제연동에 필요한 함수들
******************************************************************/
//////////////////////////////////////////////////////////////////////
//order_ok 에 들어가는 함수
//(선행 $orderid ,  $resmsg = pg (order_update.php)에서 넘어온값들
//////////////////////////////////////////////////////////////////////

function Pay_result($pgname,$rescode){
	// rescode = 0000 이 성공메세지
	global $orderid,$resmsg;
	switch($pgname){
		case "DACOM":
			if($rescode == "0000" || $rescode == "C000"){
				$rescode = "0000";
			}else{
				$rescode = $rescode;
			}
			break;
		case "KCP":
			if($rescode == "0000"){
				$rescode = "0000";
			}else{
				$rescode = $rescode;
			}
			break;
		case "ALLTHEGATE":
			if($rescode == "y"){
				$rescode = "0000";
			}else{
				$rescode = $rescode;
			}
			break;
		case "INICIS":
			if($rescode == "00"){
				$rescode = "0000";
			}else{
				$rescode = $rescode;
			}
			break;
	}
	$presult[orderid] = $orderid;
	$presult[resmsg] = $resmsg;
	$presult[rescode] = $rescode;

	return $presult;
}

// 등급할인액
function level_discount($idx,$prd_price,$prd_amount)
{
	global $discount_msg;
	$discount_price = 0;

	if($idx != "" && $prd_price > 0)
	{
		$sql = "select * from wiz_level where idx = '$idx'";
		$result = mysql_query($sql) or error(mysql_error());
		$row = mysql_fetch_object($result);

		if($row->discount > 0)
		{
		   if($row->distype == "W")
		   {
		   	$discount_price = $row->discount*$prd_amount;
		   }else
		   {
		      $discount_price = floor(($prd_price*($row->discount/100))/100)*100;
			}
		}
	}

	if($discount_price > 0) $discount_msg = " - 회원할인(<b>".number_format($discount_price)."원</b>)";

	return $discount_price;

}

// 배송정책 이름
function deliver_name($deliver_method){
	if($deliver_method == "DA") return "전액무료";
	else if($deliver_method == "DB") return "수신자부담(착불)";
	else if($deliver_method == "DC") return "고정값";
	else if($deliver_method == "DD") return "구매가격별";
}

// 배송정책 이름 - 상품
function deliver_name_prd($deliver_method) {
	if($deliver_method == "DA") return "기본 배송정책";
	else if($deliver_method == "DB") return "무료배송";
	else if($deliver_method == "DC") return "상품별 배송비";
	else if($deliver_method == "DD") return "수신자부담(착불)";
}

// 배송비
function deliver_price($prd_price, $oper_info, $selidx ="", $prdcode = "", $amount = 1)
{
	global $deliver_msg; $deliver_price = 0;

	// 장바구니에 담긴 상품의 배송정책 및 배송비
	if(strpos($_SERVER[PHP_SELF],"/adm/product/npay") !== false) {
		$sql = "select sellprice, ".$amount." as amount, del_type, del_price from wiz_product where prdcode='$prdcode'";
	}
 	else if(strpos($_SERVER[PHP_SELF],"/adm/") !== false) {
 		global $orderid;
 		$sql = "select prdprice, amount, del_type, del_price from wiz_basket where orderid = '$orderid'";
 	} else if ($prdcode != ""){
		$sql = "select sellprice, ".$amount." as amount, del_type, del_price from wiz_product where prdcode='$prdcode'";
	} else {
		if($selidx!=""){
			$sel_sql = "";
			$idx=explode("|",$selidx);
			$idxs = "";
			for($ii="0"; $ii<count($idx)-1; $ii++){
				if($idx[$ii] != "") $idxs .= "'".$idx[$ii]."'";
			}
			$sel_sql = " and wb.idx in (".$idxs.") ";
		}
 		$sql = "SELECT wb.prdprice, wb.amount, wp.del_type, wp.del_price FROM wiz_basket_tmp as wb inner join wiz_product as wp on wb.prdcode = wp.prdcode WHERE wb.uniq_id='".$_COOKIE["uniq_id"]."' $sel_sql";
 	}

	$result = mysql_query($sql) or error(mysql_error());
	$basket_total = mysql_num_rows($result);

	while($row = mysql_fetch_array($result)) {
		if(empty($row[del_type])) $row[del_type] = "DA";							// 배송비 정책 누락시 기본 배송정책으로 설정

		if(!strcmp($row[del_type], "DC")) $del_price += $row[del_price];			// 상품별 배송비일 경우 배송비 합산
		$del_info[$row[del_type]][cnt] = $del_info[$row[del_type]][cnt] + 1;		// 배송방법별 합계

		if($row[del_type] != "DA") $prd_price -= ($row[prdprice] * $row[amount]);	// 기본 배송정책이 아닌 경우 상품가격 합산에서 차감(기본 배송정책의 상품가격만 합산)

		$del_type = $row[del_type];
	}

	/**************************************************************************************
		기본 배송정책
	**************************************************************************************/

	// 기본 배송정책에 따른 배송방법 및 배송비
	if($oper_info[del_method] == "DA"){ // 배송비 전액무료
 		$deliver_price = 0; $deliver_msg = "배송비 전액무료";
	}else if($oper_info[del_method] == "DB"){ // 수신자부담 (착불)
		$deliver_price = 0; $deliver_msg = "수신자부담 (착불)";
	}else if($oper_info[del_method] == "DC"){ // 고정값
		$deliver_price = $oper_info[del_fixprice]; $deliver_msg = "고정 ".number_format($oper_info[del_fixprice])."원";
	}else if($oper_info[del_method] == "DD"){ // 구매가격별
		if($oper_info[del_staprice] <= $prd_price) $deliver_price = $oper_info[del_staprice2];
		else $deliver_price = $oper_info[del_staprice3];

		$deliver_msg = number_format($oper_info[del_staprice])."원 이상구매시 ";

		if($oper_info[del_staprice2] == 0) $deliver_msg .= "무료";
		else $oper_info[del_staprice2] = $deliver_msg .= number_format($oper_info[del_staprice2])."원";
 	}


	/**************************************************************************************
		상품별 배송정책
	**************************************************************************************/

	// 무료배송 상품과 함께 주문할 경우, 전체 배송비를 무료
	if(!strcmp($oper_info[del_prd], "DA") && $del_info["DB"][cnt] > 0) {
		$deliver_price = 0; $deliver_msg = "배송비 전액무료";
	}

	// 장바구니 상품 갯수와 배송비가 없는 상품의 갯수가 같으면 배송비 0
	if($basket_total > 0 && $basket_total == $del_info["DB"][cnt] + $del_info["DD"][cnt]) {
		$deliver_price = 0; $deliver_msg = "상품별 배송비";
	}

	// 장바구니에 상품별 배송비가 있는 경우 배송비 문구에 "상품별 배송비 제외" 추가
	if($del_info["DC"][cnt] > 0) $deliver_msg .= "<br>&nbsp;(상품별 배송비는 부과)";

	// 상품을 2개 이상 주문할 경우
	if($basket_total > 1) {

		// 상품별 배송비 + 기본 배송비
		if(!strcmp($oper_info[del_prd2], "DA")) {

			// 장바구니 모든 상품이 상품별 배송인 경우 기본 배송료를 더하지 않음
			if($basket_total == $del_info["DC"][cnt]) $deliver_price = $del_price;
			else $deliver_price = $deliver_price + $del_price;

		// 상품별 배송비, 기본 배송비 중 큰 값
		} else if(!strcmp($oper_info[del_prd2], "DB")) {
			if($deliver_price < $del_price) $deliver_price = $del_price;
		}
	// 장바구니 상품이 1개이고 기본 배송료가 아닌경우
	} else if($basket_total > 0 && strcmp($del_type, "DA")) {
		$deliver_price = $del_price;	$deliver_msg = deliver_name_prd($del_type);
	}

 	return $deliver_price;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//   /shop/order_pay.php 에 사용되는것 , 결제방법,결제사를 파일 인쿠르드 ($oper_info , $pay_method , $order_info 선행)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Inc_payment($pay_method,$pay_agent){
	// 무통장 입금
	if($pay_method == "PB"){
	  return "$_SERVER[DOCUMENT_ROOT]/adm/product/pay_account.php";
	// 신용카드결제,계좌이체,휴대폰..
	}else{
	  if($pay_agent == "DACOM"){
	    return "$_SERVER[DOCUMENT_ROOT]/adm/product/dacom/pay_form.php";
	  }elseif($pay_agent == "KCP"){
			 return "$_SERVER[DOCUMENT_ROOT]/adm/product/kcp/pay_form.php";
	  }elseif($pay_agent == "ALLTHEGATE"){
	    return "$_SERVER[DOCUMENT_ROOT]/adm/product/allthegate/pay_form.php";
	  }elseif($pay_agent == "INICIS"){
	    return "$_SERVER[DOCUMENT_ROOT]/adm/product/INICIS/pay_form.php";
	  }
  }

}

// 모바일용
function Inc_payment2($pay_method,$pay_agent){
	// 무통장 입금
	if($pay_method == "PB"){
		return "pay_account.inc";
	// 신용카드결제,계좌이체,휴대폰..
	}else{
	  if($pay_agent == "DACOM"){
	    return "./dacom/pay_form.php";
	  }elseif($pay_agent == "KCP"){
			 return "./kcp/pay_form.php";
	  }elseif($pay_agent == "ALLTHEGATE"){
	    return "./allthegate/pay_form.php";
	  }elseif($pay_agent == "INICIS"){
	    return "./INICIS/pay_form.php";
	  }
  }


}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//주문후 자신의 임시 장바구니 삭제
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Exe_delbasket(){

Global $order_info;

	if(is_array($order_info)) $orderid = $order_info[orderid];
	else $orderid = $order_info->orderid;

	$d_sql = "SELECT * FROM wiz_basket WHERE orderid = '$orderid'";
	$d_result = mysql_query($d_sql) or die(mysql_error());
	while($d_row = mysql_fetch_object($d_result)){

	@mysql_query("DELETE FROM wiz_basket_tmp WHERE uniq_id='".$_COOKIE["uniq_id"]."' and idx='$d_row->tmp_idx'");
	}
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//적립금 처리 (선행 인클루드 $order_info 주문정보배열)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Exe_reserve(){
	Global $order_info;
	if($order_info->reserve_use > 0){
		$reserve_msg = "상품구입시 사용함";
		$sql = "INSERT INTO wiz_reserve(idx,memid,reservemsg,reserve,orderid,wdate) VALUES('', '$order_info->send_id', '$reserve_msg', -$order_info->reserve_use, '$order_info->orderid', now())";
		mysql_query($sql) or error(mysql_error());
	}
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//재고관리 (선행 $order_info 주문정보배열)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Exe_stock(){

	Global $order_info;

	if(is_array($order_info)) $orderid = $order_info[orderid];
	else $orderid = $order_info->orderid;

	// 장바구니 정보
	$j_sql = "SELECT wb.option_table,wb.amount,wb.prdcode, wp.option_use, wp.shortage
						FROM wiz_basket wb, wiz_product wp
						WHERE wb.orderid = '$orderid' AND wb.prdcode = wp.prdcode";
	$j_result = mysql_query($j_sql) or die(mysql_error());


	while($row = mysql_fetch_object($j_result)){

		// 상품 재고량
		if($row->shortage == "S"){
			$sql = "UPDATE wiz_product SET stock = stock - $row->amount, ordercnt = ordercnt + 1 WHERE prdcode = '$row->prdcode'";
			mysql_query($sql) or die(mysql_error());
		}

		// 옵션 정보(재고량)
		$sql = "select * from wiz_product_option where prdcode='$row->prdcode'";
		$result = mysql_query($sql) or error(mysql_error());

		while($option_row = mysql_fetch_object($result)){
			if($option_row->type == "select") $select_table = $option_row->table;
			if($option_row->type == "supply") $supply_table = $option_row->table;
		}

		$option_table = json_decode($row->option_table, true);

		// foreach($option_table as $item){
		//
		// 	if($item[type] == "product"){
		// 		//재고량 사용
		// 		if($row->shortage == "S"){
		// 			$sql = "UPDATE wiz_product SET stock = stock - $item[amount], ordercnt = ordercnt + 1 WHERE prdcode = '$row->prdcode'";
		// 			mysql_query($sql) or die(mysql_error());
		// 		}
		//
		// 		continue;
		// 	}
		//
		// 	// 옵션인경우
	  //   switch($item[type]){
	  //     case "select": $table = $select_table; break;
	  //     case "supply": $table = $supply_table; break;
	  //   }
		//
		// 	$values = explode(",",$item[values]);
		// 	$table = json_decode($table, true);
		// 	$option = &$table;
		//
		// 	foreach($values as $value){
		// 		$option = &$option[$value];
		// 	}
		//
		//
		// 	if($option[price] != "" && $option[stock] != ""){
		// 		$option[stock] = $option[stock] - $item[amount];
		// 	}
		//
		// 	$table = raw_json_encode($table);
		// 	//$table = substr($table, 1, strlen($table) - 2) ;
		// 	$sql = "UPDATE wiz_product_option SET `table` = '".$table."' WHERE prdcode = '$row->prdcode' and type='$item[type]'";
		//
		// 	mysql_query($sql) or die(mysql_error());
		// }
	}
}

function raw_json_encode($input, $flags = 0) {
    $fails = implode('|', array_filter(array(
        '\\\\',
        $flags & JSON_HEX_TAG ? 'u003[CE]' : '',
        $flags & JSON_HEX_AMP ? 'u0026' : '',
        $flags & JSON_HEX_APOS ? 'u0027' : '',
        $flags & JSON_HEX_QUOT ? 'u0022' : '',
    )));
    $pattern = "/\\\\(?:(?:$fails)(*SKIP)(*FAIL)|u([0-9a-fA-F]{4}))/";
    $callback = function ($m) {
        return html_entity_decode("&#x$m[1];", ENT_QUOTES, 'UTF-8');
    };
    return preg_replace_callback($pattern, $callback, json_encode($input, $flags));
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//결제처리(상태변경,주문 업데이트)
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function Exe_payment($payment){

	global $oper_info;

	/*변수 초기화 시작*/
	$status			=	"";
	$orderid			=	"";
	$financecode	=	"";
	$accountnumber	=	"";
	$tno				=	"";
	$esw_check		=	"";
	$esw_stats		=	"";
	$totalprice		=	"";
	$paymentkind	=	"";
	$pay_method		=	"";
	$other_update	=	"";
	$accountname	=	"";
	/*변수 초기화 끝*/
	$status			=	$payment[status];		// 주문상태
	$orderid			=	$payment[orderid];	// 주문번호
	$financecode	=	$payment[bankkind];	// 은행코드
	$accountnumber	=	$payment[accountno];	// 계좌번호
	$accountname	=	$payment[accountname];	// 예금주
	$tno				=	$payment[ttno];		//	승인번호,TID번호,처리번호
	$es_check		=	$payment[es_check];	//에스크로 사용여부
	$es_stats		=	$payment[es_stats];	//에스크로 상태
	$tprice			=	$payment[tprice];		//결제금액
	$paymentkind	=	$payment[pgname];		//pg사 종류
	$pay_method		=	$payment[paymethod];	//wizshop 결제방법
	$other_update	=	$payment[otherupdate];	//기타 wiz_order 을 update 하는방법
	$cash_num =$payment[cash_num]; //현금영수증 승인번호
	$cash_type =$payment[cash_type]; //현금영수증 종류
	$cash_segno =$payment[cash_segno]; //가상계좌 입금순서

	@make_log("dacom_log.txt","--START".date("Y/m/d H:i:s",time())."---------\r".$status."\r".$orderid."\r".$financecode."\r".$accountnumber."\r".$tno."\r".$esw_check."\r".$esw_stats."\r".$totalprice."\r".$paymentkind."\r".$pay_method."\r");

	// 주문정보
	$sql = "SELECT * FROM wiz_order WHERE orderid='$orderid'";
	$result = mysql_query($sql) or error(mysql_error());
	$order_info = mysql_fetch_object($result);

	if($pay_method == "PV"||$pay_method=="PN"||$pay_method=="PB"){


		if($paymentkind=='allthegate'){//올더게이트 은행 코드
			switch($financecode){
				case "03":$financecode = "기업은행";break;
				case "04":$financecode = "국민은행";break;
				case "05":$financecode = "외환은행";break;
				case "06":$financecode = "국민은행(구 주택은행)";break;
				case "07":$financecode = "수협중앙회";break;
				case "11":$financecode = "농협중앙회";break;
				case "12":$financecode = "단위농협";break;
				case "20":$financecode = "우리은행";break;
				case "21":$financecode = "조흥은행";break;
				case "23":$financecode = "제일은행";break;
				case "32":$financecode = "부산은행";break;
				case "71":$financecode = "우체국";break;
				case "81":$financecode = "하나은행";break;
				case "88":$financecode = "신한은행";break;
				default:$financecode = $financecode;
			}
		}else if($paymentkind=='dacom'){//데이콤 은행 코드
			switch($financecode){
				case "02":$financecode = "산업은행";break;
				case "03":$financecode = "기업은행";break;
				case "05":$financecode = "외환은행";break;
				case "06":$financecode = "국민은행";break;
				case "07":$financecode = "수협";break;
				case "11":$financecode = "농협";break;
				case "20":$financecode = "우리은행";break;
				case "23":$financecode = "제일은행";break;
				case "26":$financecode = "신한은행";break;
				case "27":$financecode = "씨티은행";break;
				case "31":$financecode = "대구은행";break;
				case "32":$financecode = "부산은행";break;
				case "34":$financecode = "광주은행";break;
				case "35":$financecode = "제주은행";break;
				case "37":$financecode = "전북은행";break;
				case "39":$financecode = "경남은행";break;
				case "45":$financecode = "새마을금고";break;
				case "48":$financecode = "신협";break;
				case "71":$financecode = "우체국";break;
				case "81":$financecode = "하나은행";break;
				case "88":$financecode = "신한은행";break;
				default:$financecode = $financecode;
			}
		}else if($paymentkind=='inicis'){//이니시스 은행코드
			switch($financecode){
					case "03":$financecode = "기업은행";break;
					case "04":$financecode = "국민은행";break;
					case "05":$financecode = "외환은행";break;
					case "06":$financecode = "국민은행(구 주택은행)";break;
					case "07":$financecode = "수협중앙회";break;
					case "11":$financecode = "농협중앙회";break;
					case "12":$financecode = "단위농협";break;
					case "20":$financecode = "우리은행";break;
					case "21":$financecode = "조흥은행";break;
					case "23":$financecode = "제일은행";break;
					case "32":$financecode = "부산은행";break;
					case "71":$financecode = "우체국";break;
					case "81":$financecode = "하나은행";break;
					case "88":$financecode = "신한은행";break;
				}
		}else{
			if($financecode == "05") $financecode = "외환은행";
			else if($financecode == "06") $financecode = "국민은행";
			else if($financecode == "11") $financecode = "농협은행";
			else if($financecode == "26") $financecode = "신한은행";
			else if($financecode == "81") $financecode = "하나은행";
			else if($financecode == "20") $financecode = "우리은행";
			else $financecode = $financecode;
		}
		if($accountname){$accountname = " , account_name='$accountname'";}
		$pv_account = ", account='".$financecode." ".$accountnumber."'".$accountname;


	}
	if(trim($tno)){//승인번호,TID값
			$tno=" , tno='$tno' ";
	}else{
			$tno="";
	}
	if($status == "OY") {
		$oper_time = ", pay_date = now()";
		// 세금계산서 업데이트
		if(!strcmp($oper_info[tax_use], "Y")) {
			$sql = "update wiz_tax set tax_date = now() where orderid = '$orderid'";
			mysql_query($sql) or error(mysql_error());
		}
		//세금계산서 발급완료
		if($cash_num!="" && $cash_num!="0"){
			$sql = "update wiz_tax set tax_pub='Y' , cash_num='$cash_num' where orderid = '$orderid'";
			mysql_query($sql) or error(mysql_error());
		}
		//가상계좌일때 입금순서
		if($cash_segno!=""){
			$cash_sql=", cash_segno='$cash_segno'  ";
		}
	}
	// 에스크로 체크한경우 에스크로 상태 업데이트
	//if($tprice>=100000){

	if($oper_info[pay_agent] == "DACOM") {
	if($oper_info[pay_escrow] == "Y") {
		if($pay_method == "PV" || $pay_method == "PN"){$escrow_=",escrow_check='$es_check',escrow_stats='$es_stats'";}
	}
	}else{
		if($pay_method == "PV" || $pay_method == "PN"|| $pay_method == "PC"){$escrow_=",escrow_check='$es_check',escrow_stats='$es_stats'";}
	}


	// 쿠폰
	if($order_info->coupon_idx != "") {

		$today = date('Y-m-d');
		$coupon_list = explode("|", $order_info->coupon_idx);
		if(is_array($coupon_list)) {
			foreach($coupon_list as $c_idx => $cidx) {

				$c_sql = "select * from wiz_mycoupon where idx='".$cidx."'";
				$c_result = mysql_query($c_sql) or error(mysql_error());
				$c_row = mysql_fetch_array($c_result);

				if($c_row[coupon_use] == "N" && $c_row[coupon_sdate] <= $today && $c_row[coupon_edate] >= $today) {
					$sql = "update wiz_mycoupon set coupon_use = 'Y' where idx = '".$cidx."'";
					mysql_query($sql) or error(mysql_error());
				} else {
					// 미사용, 기간내의 쿠폰이 아닌 경우 주문 내역 업데이트
					/********** 쿠폰 구분별 : 쿠폰 할인금액, 쿠폰 idx, 총 결제금액 다시 계산 후 업데이트 처리

					if($c_row[prdcode] != "") {	// 상품할인 쿠폰

						$b_sql = "select prdcode, prdprice, amount from wiz_basket where orderid ='".$orderid."'";
						$b_result = mysql_query($b_sql) or error(mysql_error());
						$no = 0;

						while($b_row = mysql_fetch_array($b_result)) {

							//$basket_list[$no][prdcode] = $b_row[prdcode];
							//$basket_list[$no][prdprice] = $b_row[prdprice];
							//$basket_list[$no][amount] = $b_row[amount];

							$no++;
						}

						// coupon_use = coupon_use - 각 상품별 쿠폰할인 금액
						// coupon_idx = 사용 불가능한 쿠폰 idx 값 삭제한 값
						// total_price = total_price + 각 상품별 쿠폰할인 금액

						$total_price = $order_info->total_price - $order_info->coupon_use;

					} else if($c_row[] != "") {	// 이벤트 쿠폰

						$total_price = $order_info->total_price - $order_info->coupon_use;

					}

					$other_update = ", coupon_use = '$coupon_use', coupon_idx = '$coupon_idx', total_price = '$total_price' "
					*/

				}
			}
		}

	}

	// 주문상태 변경
	$sql = "UPDATE wiz_order SET status='$status' $tno $pv_account $oper_time $escrow_ $other_update $cash_sql WHERE orderid='$orderid'";
	$result = mysql_query($sql) or error(mysql_error());

	@make_log("dacom_log.txt","\r".$sql."\r---------------------------End----------------------------------\r");
}

//임시 로그파일 생성하기
function make_log($file, $noti) {
		$fp = fopen($file, "a+");
		ob_start();
		print_r($noti);
		$msg = ob_get_contents();
		ob_end_clean();
		fwrite($fp, $msg);
		fclose($fp);
}

// 배송정보 전송
function escrow_delivery($order_info, $oper_info, $delsno="", $deldate="") {



	if(!strcmp($order_info[escrow_check], "Y") && strcmp($order_info->escrow_stats, "DE")) {


		if(!strcmp($oper_info[pay_agent], "DACOM")) {


			$oid = $order_info[orderid];							// 주문번호
			$productid = $order_info[orderid];				// 상품ID
			$dlvtype = "03";													// 등록내용구분
			$dlvdate = $deldate;											// 발송일자

			// 배송회사코드
			switch($oper_info[del_com]) {
				case "대한통운" : $dlvcompcode = "KE"; break;
				case "로젠택배" : $dlvcompcode = "LG"; break;
				case "아주택배" : $dlvcompcode = "AJ"; break;
				case "엘로우캡" : $dlvcompcode = "YC"; break;
				case "우체국택배" : $dlvcompcode = "PO"; break;
				case "이젠택배" : $dlvcompcode = "EZ"; break;
				case "트라넷" : $dlvcompcode = "TN"; break;
				case "한진택배" : $dlvcompcode = "HJ"; break;
				case "현대택배" : $dlvcompcode = "HD"; break;
				case "훼미리택배" : $dlvcompcode = "FE"; break;
				case "Bell Express" : $dlvcompcode = "BE"; break;
				case "CJ GLS" : $dlvcompcode = "CJ"; break;
				case "HTH" : $dlvcompcode = "SS"; break;
				case "KGB택배" : $dlvcompcode = "KB"; break;
				case "KT로지스택배" : $dlvcompcode = "KT"; break;
			}

			$dlvcomp = $oper_info[del_com];					// 배송회사명
			$dlvno = $delsno;											// 운송장번호
			if(!empty($dlvdate) && !empty($dlvno)) {
				echo "<script>window.open('/adm/product/dacom/escrow_delivery.php?oid=$oid&productid=$productid&dlvtype=$dlvtype&dlvdate=$dlvdate&dlvcompcode=$dlvcompcode&dlvcomp=$dlvcomp&dlvno=$dlvno', 'Delivery', 'width=250px,height=220px,scrollbars=yes');</script>";


			}

		}

	}
}

// 주문상세 페이지 주문취소 버튼
function get_cancel_btn() {

	global $order_info;
	global $oper_info;
	global $orderid;
	global $cancel_btn;

?>

	<script language="JavaScript">
	<!--

	// 주문취소
	function orderCancel(orderid)
	{
		<? if($order_info[status] == "OR"){ ?>
		alert("결제완료된 주문만 취소요청이 가능합니다.");
		<? }else if($order_info[status] == "RD"){ ?>
		alert("이미 취소요청한 상태입니다.");
		<? }else if($order_info[status] == "RC" || $order_info[status] == "OC"){ ?>
		alert("취소처리가 완료된 상태입니다.");
		<? }else{ ?>
		var url = "/adm/product/order_cancel.php?orderid=" + orderid;
	  window.open(url, "orderCancel", "height=270, width=470, menubar=no, scrollbars=no, resizable=yes, toolbar=no, status=no, left=300, top=300");
		<? } ?>
	}

	// 주문취소 해제
	function orderRemoval(orderid)
	{
		if(confirm("주문취소를 해제하시겠습니까?")){
			document.location='/adm/product/order_status.php?orderid=' + orderid;
		}
	}

	//-->
	</script>

<?

	$cancel_btn = "<a class='btn btn_point' href=\"javascript:orderCancel('".$orderid."');\">주문 취소 요청</a>";
}

// 주문상세 페이지의 에스크로 버튼
function get_escrow_btn() {

	global $order_info;
	global $oper_info;
	global $orderid;
	global $escrow_btn;
if($oper_info[pay_agent] == "DACOM") {
	if(!strcmp($oper_info[pay_test], "Y")) {//테스트
		$oper_info[pay_id] = "t".$oper_info[pay_id];
		$oper_info[pay_key] = $oper_info[pay_key];
		$platform	= "test";             //LG데이콤 결제서비스 선택(test:테스트, service:서비스)
		$mid = $oper_info[pay_id];
		$pay_key = $oper_info[pay_key];
		$tport = ":7085";
		$_htt = "";
	}else{//실거래
		$platform	= "service";
		$mid = $oper_info[pay_id];
		$pay_key = $oper_info[pay_key];
		$tport = "";
		$_htt = "s";
	}
}



	if($oper_info[pay_agent] == "DACOM") {//데이콤
?>
	<SCRIPT language=JavaScript src="http://pgweb.dacom.net<?=$tport?>/js/DACOMEscrow.js"></SCRIPT>
<?
	}else if($oper_info[pay_agent] == "KCP") {
?>

<?}?>

	<script language="JavaScript">
	<!--

	// 에스크로 수령확인 Dacom
	function linkESCROW(mid,oid)
	{
	   checkDacomESC ("<?=$mid?>", oid,'');
	   location.reload();
	}



	//-->
	</script>

<?
	///////////////////////////////////////////
	//에스크로 사용일경우 수령확인 버튼 출력 //
	///////////////////////////////////////////
	if($oper_info[pay_escrow] == "Y"){

		if($oper_info[pay_agent] == "DACOM") {//데이콤 버튼
			if($order_info[escrow_stats]=='IN' || $order_info[escrow_stats]=='DE'){//에스크로 정보 : 수령확인 을안하였으면
				$escrow_btn = "<a href=\"javascript:linkESCROW('".$mid."', '".$orderid."');\"><img src=\"/adm/images/but_receok.gif\" border=\"0\"></a>";

		$escrow_install_btn="<a href='http://pgdownload.uplus.co.kr/lgdacom/LGDacomXPayWizard.exe ' taget='_blank'>수동설치</a>"; //수동설치 버튼 생성

			}
		} else if($oper_info[pay_agent] == "KCP") {//KCP버튼
			//$escrow_btn = "<img src=\"/adm/images/but_receok.gif\" border=\"0\" onClick=\"linkESCROW_kcp('".$oper_info[pay_id]."', '".$order_info[tno]."', '".$orderid."')\" style=\"cursor:pointer\">";
		}
	}
}

// 주문상세 페이지 세금계산서 버튼
function get_tax_btn() {

	global $order_info;
	global $oper_info;
	global $orderid;
	global $tax_btn;

?>
	<script language="JavaScript">
	<!--

	// 세금계산서 출력
	function printTax(orderid) {
	<?
	$print_tax_check = false;
	$status = order_status($order_info[status]);
	$tax_status = order_status($oper_info[tax_status]);

	if(!strcmp($order_info[status], "OC") || !strcmp($order_info[status], "RD") || !strcmp($order_info[status], "RC")) {
	?>
		alert("주문취소로 세금계산서가 폐기되었습니다.");
	<?
	} else {

		if(!strcmp($oper_info[tax_status], "OY")) {
			if(strcmp($order_info[status], "OR")) {
				$print_tax_check = true;
			}
		} else if(!strcmp($oper_info[tax_status], "DC")) {
			if(!strcmp($order_info[status], "DC") || !strcmp($order_info[status], "CC")) {
				$print_tax_check = true;
			}
		}

		if($print_tax_check) {
	?>
		var url = "/adm/product/print_tax.php?orderid=" + orderid;
		window.open(url, "taxPub", "height=750, width=670, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, left=50, top=50");
	<?
		} else {
	?>
		alert("현재 주문상태(<?=$status?>)에서는 세금계산서를 발급할 수 없습니다. \n\n<?=$tax_status?> 이후에 세금계산서 발행이 가능합니다.");
	<?
		}
	}
	?>

	}
	//-->
	</script>
<?
	if(!strcmp($oper_info[tax_use], "Y")) {
		$tax_btn = "<span onClick=\"printTax('".$orderid."')\" style=\"cursor:pointer\">[세금계산서]</span>";
	}
}

// 영수증 출력
function receipt_link($oper_info, $ord_info) {

	$card_icon = "카드영수증";
	$cash_icon = "현금영수증";

	// 데이콤
	if(!strcmp($oper_info[pay_agent], "DACOM")) {

		if(!strcmp($oper_info[pay_test], "Y")) {//테스트
			$oper_info[pay_id] = "t".$oper_info[pay_id];
			$pay_key = $oper_info[pay_key];
			$platform	= "test";             //LG데이콤 결제서비스 선택(test:테스트, service:서비스)
			$mid = $oper_info[pay_id];
			$pay_key = $oper_info[pay_key];
		}else{//실거래
			$platform	= "service";
			$mid = $oper_info[pay_id];
			$pay_key = $oper_info[pay_key];
		}

		/////////////////
		//결제방법 출력//
		/////////////////
		switch($ord_info->pay_method){
			case "PC"://신용카드
				$pay_method = "SC0010";break;
			case "PN"://계좌이체
				$pay_method = "SC0030";break;
			case "PV"://가상계좌
				$pay_method = "SC0040";break;
			case "PH";//휴대폰
				$pay_method = "SC0060";break;
		}

		echo "<script language='JavaScript' src='/adm/product/dacom/receipt_link.js'></script>";

		// 신용카드
		if(!strcmp($ord_info->pay_method, "PC")) {

			$authdata = md5($mid.$ord_info->tno.$pay_key);
			echo "<a href=\"javascript:showReceiptByTID('".$mid."', '".$ord_info->tno."', '".$authdata."','".$platform."')\">".$card_icon."</a>";

		// 계좌이체, 가상계좌, 무통장입금(상점관리 > 결제내역조회 > 현금영수증에서 직접 등록) 현금영수증
		} else if(!strcmp($ord_info->pay_method, "PN") || !strcmp($ord_info->pay_method, "PV") || !strcmp($ord_info->pay_method, "PB")) {

			switch($ord_info->pay_method) {
				case "PN" : $pay_method = "BANK"; break;
				case "PV" : $pay_method = "CAS"; break;
				case "PB" : $pay_method = "CR"; break;
			}

			//가상계좌입금순서
			$cash_segno="";
			if($ord_info->pay_method=="PV"){
				$cash_segno=$ord_info->cash_segno;
			}


			echo "<a href=\"javascript:showCashReceipts('".$mid."','".$ord_info->orderid."','".$cash_segno."','".$pay_method."','".$platform."')\">".$cash_icon."</a>";

		// 무통장입금
		} else {

			$authdata = md5($mid.$ord_info->orderid.$pay_method.$pay_key);
			echo "<a href=\"javascript:showReceiptByOID('".$mid."','".$ord_info->orderid."','".$pay_method."','".$authdata."','".$platform."')\">aaa</a>";

		}

	// KCP
	} else if(!strcmp($oper_info[pay_agent], "KCP")) {

		if(!strcmp($oper_info[pay_id], "Y")) {//테스트
			$oper_info[pay_id] = "tanywiz";
			$oper_info[pay_key] = "6f51f77a2b2222d642e20e445101a35f";
			$platform	= "test";             //LG데이콤 결제서비스 선택(test:테스트, service:서비스)
			$mid = $oper_info[pay_id];
			$pay_key = $oper_info[pay_key];
		}else{//실거래
			$platform	= "service";
			$mid = $oper_info[pay_id];
			$pay_key = $oper_info[pay_key];
		}

		// 신용카드
		if(!strcmp($ord_info->pay_method, "PC")) {
?>
			<script language="JavaScript">
			<!--
			function receipt() {
				<? if(empty($ord_info->tno)) { ?>
					alert("KCP거래번호가 없습니다.");
				<? } else { ?>
					var url = "http://admin.kcp.co.kr/Modules/Sale/Card/ADSA_CARD_BILL_Receipt.jsp?c_trade_no=<?=$ord_info->tno?>";
					window.open(url, "Receipt", "height=670, width=420, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, left=50, top=50");
				<? } ?>
			}
			-->
			</script>
			<a href="javascript:receipt()"><?=$card_icon?></a>
<?
		// 계좌이체, 가상계좌, 무통장입금(상점관리 > 결제내역조회 > 현금영수증에서 직접 등록) 현금영수증
		} else if(!strcmp($ord_info->pay_method, "PN") || !strcmp($ord_info->pay_method, "PV") || !strcmp($ord_info->pay_method, "PB")) {
			$site_cd = "	PGNW".$oper_info[pay_id];
?>
			<script language="JavaScript">
			<!--
			function receiptCash() {
				var url = "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp?term_id=<?=$site_cd?>&orderid=<?=$ord_info->orderid?>&id_info=<?=$ord_info->id_info?>&bill_yn=<?=$ord_info->bill_yn?>&authno=<?=$ord_info->authno?>";
				window.open(url, "Receipt", "height=670, width=420, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, left=50, top=50");
			}
			-->
			</script>
			<a href="javascript:receiptCash()"><?=$cash_icon?></a>
<?
		// 무통장입금
		} else {

		}

	// ALL THE GATE
	} else if(!strcmp($oper_info[pay_agent], "ALLTHEGATE")) {

		if(!strcmp($oper_info[pay_test], "Y")) {
			$oper_info[pay_id] = "aegis";
			$oper_info[pay_key] = "6f51f77a2b2222d642e20e445101a35f";
		}

		// 신용카드
		if(!strcmp($ord_info->pay_method, "PC")) {
?>
<script language=javascript>
<!--
function show_receipt(approve, send_no, send_dt)
{
	if("<?=$ord_info->status?>"!= "" && "<?=$ord_info->pay_method?>"=="PC")
	{
		if(parseInt(send_dt) < parseInt("<?=date('Ymd')?>")) {

			window.open("http://www.allthegate.com/support/card_search.html", "window","toolbar=no,location=no,directories=no,status=,menubar=no,scrollbars=yes,resizable=no,width=630,height=510,top=0,left=150");

		} else {
			var sRetailer_id = "<?=$oper_info[pay_id]?>";

			url="http://www.allthegate.com/customer/receiptLast3.jsp"
			url=url+"?sRetailer_id="+sRetailer_id;	// 상점아이디
			url=url+"&approve="+approve;						// 승인번호
			url=url+"&send_no="+send_no;						// 거래고유번호
			url=url+"&send_dt="+send_dt.substring(0,8);		// 승인시각

			window.open(url, "window","toolbar=no,location=no,directories=no,status=,menubar=no,scrollbars=no,resizable=no,width=420,height=700,top=0,left=150");
		}
	}
	else
	{
		alert("해당하는 결제내역이 없습니다");
	}
}
-->
</script>
			<a href="javascript:show_receipt('<?=$ord_info->tno?>', '<?=$ord_info->orderid?>', '<?=substr(str_replace("-", "", $ord_info->pay_date), 0, 8)?>')"><?=$card_icon?></a>
<?
		// 계좌이체, 가상계좌, 무통장입금(상점관리 > 결제내역조회 > 현금영수증에서 직접 등록) 현금영수증
		} else if(!strcmp($ord_info->pay_method, "PN") || !strcmp($ord_info->pay_method, "PV") || !strcmp($ord_info->pay_method, "PB")) {

		// 무통장입금
		} else {

		}

	}

}

// 현금영수증 발급사유
function get_cash_type_name($cash_type) {

	switch($cash_type) {
		case "C" : $name = "사업자 지출증빙용"; break;
		case "P" : $name = "개인소득 공제용"; break;
		default  : $name = ""; break;
	}

	return $name;

}
// 현금영수증 신청정보
function get_cash_type2_name($cash_type2) {

	switch($cash_type2) {
		case "CARDNUM" : $name = "현금영수증 카드번호"; break;
		case "COMNUM" : $name = "사업자번호"; break;
		case "HPHONE" : $name = "휴대전화번호"; break;
		case "RESNO" : $name = "주민등록번호"; break;
		default  : $name = ""; break;
	}

	return $name;

}

function get_rand_str($len=5) {
	$code_char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

	for($ii = 0; $ii < $len; $ii++) {
		$code_number .= $code_char{rand()%strlen($code_char)};
	}

	return $code_number;
}


function xml2array($content, $get_attributes = 1, $priority = 'tag')
{
    $contents = "";
    if (!function_exists('xml_parser_create'))
    {
        return array ();
    }
    $parser = xml_parser_create('');
    $url = $content;
    $url_list = parse_url($url);

    // URL
    if($url_list['host'] != "") {

			if(!($socket = fsockopen($url_list['host'], 80, $errno, $errstr, 5))) { // URL에 소켓 연결
				echo " $errno : $errstr ";
				exit;
			}

			$header = "GET {$url} HTTP/1.0\n\n";
			fwrite($socket, $header);

			$data = '';
			while(!feof($socket)) { $data .= fgets($socket); }
			fclose($socket);

			$data = explode("\r\n\r\n", $data, 2);
			$contents = $data[1];

		// XML Data
		} else {

			$contents=$content;

		}

    //xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8"); //xml  파서에서 옵션설정 인코딩
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); ///대문자로변경
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); //공백값무시
    xml_parse_into_struct($parser, trim($contents), $xml_values); //읽어들인 xml를 이용해 배열에 xml 구조를 담는다
    xml_parser_free($parser); //파서해제

    if (!$xml_values)
        return; //Hmm...
    $xml_array = array ();
    $parents = array ();
    $opened_tags = array ();
    $arr = array ();
    $current = & $xml_array;
    $repeated_tag_index = array ();

    foreach ($xml_values as $data)
    {
        unset ($attributes, $value);
        extract($data);
        $result = array ();
        $attributes_data = array ();
        if (isset ($value))
        {
            if ($priority == 'tag')
                $result = $value;
            else
                $result['value'] = $value;
        }
        if (isset ($attributes) and $get_attributes)
        {
            foreach ($attributes as $attr => $val)
            {
                if ($priority == 'tag')
                    $attributes_data[$attr] = $val;
                else
                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }
        if ($type == "open")
        {
            $parent[$level -1] = & $current;
            if (!is_array($current) or (!in_array($tag, array_keys($current))))
            {
                $current[$tag] = $result;
                if ($attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = & $current[$tag];
            }
            else
            {
                if (isset ($current[$tag][0]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset ($current[$tag . '_attr']))
                    {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset ($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = & $current[$tag][$last_item_index];
            }
        }
        elseif ($type == "complete")
        {
            if (!isset ($current[$tag]))
            {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
            }
            else
            {
                if (isset ($current[$tag][0]) and is_array($current[$tag]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data)
                    {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes)
                    {
                        if (isset ($current[$tag . '_attr']))
                        {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                        if ($attributes_data)
                        {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        }
        elseif ($type == 'close')
        {
            $current = & $parent[$level -1];
        }
    }

    return ($xml_array);
}

// 우편번호 검색
function get_zipcode_list($address) {

	// 도로명주소 관련 변수
	$site_info['zipcode_key']	= "5C38658E5EBBDFC5AD88D24EC7D80449";	// API키
	$site_info['zipcode_url']	= "ws.didim365.com";									// API주소
	$site_info['zipcode_enc']	= "utf-8";														// 인코딩 : utf-8
	$site_info['zipcode_dr']	= "t";																// 도로명주소 포함여부 : t(포함), f(포함안함)
	$site_info['zipcode_jb']	= "t";																// 지번주소 포함여부 : t(포함), f(포함안함)
	$site_info['zipcode_de']	= "f";																// 도로명영어주소 포함여부 : t(포함), f(포함안함)
	$site_info['zipcode_bn']	= "f";																// 대량배달/건물명 포함여부 : t(포함), f(포함안함)
	$site_info['zipcode_sp']	= "t";																// 건물번호/지번 제외여부 : t(포함), f(포함안함)

	$search_count = 0;
	if($address) {

		$WS_URL = $site_info['zipcode_url'];

		$GET_URL = "http://".$WS_URL."/address/addr.aspx?sd=" . urlencode("");
		$GET_URL .= "&sg=" . urlencode("");
		$GET_URL .= "&r=x";
		$GET_URL .= "&enc=".$site_info['zipcode_enc'];
		$GET_URL .= "&k=" . urlencode($address);
		$GET_URL .= "&dr=".$site_info['zipcode_dr'];
		$GET_URL .= "&jb=".$site_info['zipcode_jb'];
		$GET_URL .= "&de=".$site_info['zipcode_de'];
		$GET_URL .= "&bn=".$site_info['zipcode_bn'];
		$GET_URL .= "&sp=".$site_info['zipcode_sp'];
		$GET_URL .= "&key=".$site_info['zipcode_key'];
		$GET_URL .= "&ts=" . time();

		$parser = xml2array($GET_URL);

		$doc_el = $parser['Didim365-Address'];

		$Result = $doc_el['Result'];
		$Message = $doc_el['Message'];

		if ($Result == "True")
		{
			$Cnt = $doc_el['Count'];
			if($Cnt == 1) {
				$doc_el['Data']['Item'][0] = $doc_el['Data']['Item'];
			}
			foreach($doc_el['Data']['Item'] as $item)
			{
				//  <항상 포함>
				// zipno : 우편번호
				//  <옵션에 따라 포함>
				// doro : 도로명 주소
				// doroen : 도로면 영문 주소
				// jibun : 지번주소

				$ZipNo	= $item['ZipNo'];
				$Doro	= str_conv($item['Doro'], $site_info['zipcode_enc']);
				$Jibun	= str_conv($item['JiBun'], $site_info['zipcode_enc']);

				if(is_array($item)) {
					$list[$search_count][zip1]	= substr($ZipNo,0,3);
					$list[$search_count][zip2]	= substr($ZipNo,3,3);
					$list[$search_count][set_addr]	= $Doro;
					$list[$search_count][addr]	= $Doro.($Jibun ? '<br/>'.$Jibun : '');
					$list[$search_count][bunji]	= "";
					$list[$search_count][jibun]	= $Jibun;

					$list[$search_count][encode_addr] = urlencode($list[$search_count][addr]);
					$search_count++;
				}
			}
		}

		return $list;

	}
}

// A tag로 POST방식으로 전송하도록 하는 함수
function a_post_con($apost_url,$apost_value,$apost_name,$apost_style){
                $apost_values = explode ("&", $apost_value);
                $apost_values_count = count($apost_values);
                $apost_values_num=0;
                $apost_text=$apost_name;



                echo("<form name='$apost_text' action='$apost_url' method='post'>");



                while($apost_values_num < $apost_values_count){
                    $apost_var = explode ("=", $apost_values[$apost_values_num]);
                    echo("<input type='hidden' name='$apost_var[0]' value='$apost_var[1]'>");
                    $apost_values_num=$apost_values_num+1;
                }
                echo("</form>");
                echo("<a href='javascript:document.$apost_text.submit();' class='$apost_style'>");
}

?>
