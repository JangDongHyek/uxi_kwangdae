<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/mem_info.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";

// 스팸글 차단
$pos = strpos($HTTP_REFERER, $_http_host);
if($pos === false) error("잘못된 경로 입니다.");

if($info_use[spam] == true){
  // 자동등록방지 코드 검사
  if(empty($_POST[tmp_vcode]) || empty($_POST[vcode])) {
  	error("자동등록방지 코드가 존재하지 않습니다.");
  } else if(strcmp($_POST[tmp_vcode], md5($_POST[vcode]))) {
  	error("자동등록방지 코드가 일치하지 않습니다.");
  }
}

if($site_info[cert_sms_use] == 'Y'){
  if($authcode_sms != $_SESSION[sms_authcode]){
    error("SMS 인증이 잘못되었습니다.");
  }
  $hphone = $hphone1+$hphone2+$hphone3;
  if($hphone != $_SESSION[sms_number]){
    error("인증된 SMS 번호가 아닙니다.");
  }
}
if($site_info[cert_email_use] == 'Y'){
  if($authcode_email != $_SESSION[email_authcode]){
    error("email 인증이 잘못되었습니다.");
  }
  if($email != $_SESSION[email_number]){
    error("인증된 email 주소가 아닙니다.");
  }
}

$level = level_basic();
$passwd = $passwd1;
$resno = $resno1."-".$resno2;
$tphone = $tphone1."-".$tphone2."-".$tphone3;
$hphone = $hphone1."-".$hphone2."-".$hphone3;
$comtel = $comtel1."-".$comtel2."-".$comtel3;

$post = $post1;
$birthday = $birthday1."-".$birthday2."-".$birthday3;
$memorial = $memorial1."-".$memorial2."-".$memorial3;

for($ii=0; $ii<count($consph); $ii++){ $consph_checked .= $consph[$ii].","; }

// 주민번호 중복체크
if($resno != "-"){

	$sql = "select id from wiz_member where resno = '$resno'";
	$result = mysql_query($sql) or error(mysql_error());
	$total = mysql_num_rows($result);
	if($total > 0) error("이미등록된 주민번호 입니다.\\n\\n관리자에게 문의하시기 바랍니다.");

}

// 사진등록
if($photo[size] > 0){

	file_check($photo[name]);
	$upfile_path = WIZHOME_PATH."/data/member";
	if(!is_dir($upfile_path)) mkdir($upfile_path, 0707);

	if(fileperms($upfile_path) != 16837 && fileperms($upfile_path) != 16839 && fileperms($upfile_path) != 16895){
		error("파일업로드시 문제가 발생하였습니다.\\n\\ndata 디렉토리 이하는 모두 쓰기권한이 있어야합니다.","");
	}

	$photo_name = $id.".".pathinfo($photo[name],PATHINFO_EXTENSION);
	copy($photo[tmp_name], $upfile_path."/".$photo_name);
	chmod($upfile_path."/".$photo_name, 0606);

 	$srcimg = $photo_name;
 	$dstimg = $photo_name;
 	$photo_width = "120";
 	img_resize($srcimg, $dstimg, $upfile_path, $photo_width, $photo_height);

}

// 아이콘등록
if($icon[size] > 0){

	file_check($icon[name]);
	$upfile_path = WIZHOME_PATH."/data/member";
	if(!is_dir($upfile_path)) mkdir($upfile_path, 0707);

	if(fileperms($upfile_path) != 16837 && fileperms($upfile_path) != 16839 && fileperms($upfile_path) != 16895){
		error("파일업로드시 문제가 발생하였습니다.\\n\\ndata 디렉토리 이하는 모두 쓰기권한이 있어야합니다.","");
	}

	$icon_name = $id."_icon.".pathinfo($icon[name],PATHINFO_EXTENSION);
	copy($icon[tmp_name], $upfile_path."/".$icon_name);
	chmod($upfile_path."/".$icon_name, 0606);

 	$srcimg = $icon_name;
 	$dstimg = $icon_name;
 	$icon_width = $icon_size;
 	img_resize($srcimg, $dstimg, $upfile_path, $icon_width, $icon_height);

}

$sql = "select * from wiz_formfield where fidx = 'addinfo' order by fprior asc, idx asc";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result)){

	$no = $row[fprior];

   if($row[ftype] != "file"){

      $fvalue = "";

      if($row[ftype] == "address"){

      	$fpost1 = ${"f".$no."_post1"};

      	$faddress1 = ${"f".$no."_address1"};
      	$faddress2 = ${"f".$no."_address2"};
				$fvalue = $fpost1."|".$faddress1."|".$faddress2;

			}else if($row[ftype] == "tdate"){

				$year1 = $fname[$no][0];
      	$month1 = $fname[$no][1];
      	$day1 = $fname[$no][2];
      	$time1 = $fname[$no][3];

      	$year2 = $fname[$no][4];
      	$month2 = $fname[$no][5];
      	$day2 = $fname[$no][6];
      	$time2 = $fname[$no][7];

				$fvalue = $year1."-".$month1."-".$day1."&nbsp;".$time1."~";
				$fvalue .= $year2."-".$month2."-".$day2."&nbsp;".$time2;

			}else if($row[ftype] != "radio"){

				$split_char = "|";
				if($row[ftype] == "pdate") $split_char = "~";

				for($ii=0;$ii<count($fname[$no]);$ii++){
	         $fvalue .= $fname[$no][$ii];
	         if($ii<count($fname[$no])-1) $fvalue .= $split_char;
	      }

	    }else{

	    	$fvalue = $fname[$no];

	    }

	    ${"addinfo".$no} = $fvalue;

   } else {

   		$fvalue = "";

	   	for($ii = 1; $ii <= $row[fnum]; $ii++) {

				 // 파일등록

				 	$upfile			 = $_FILES['upfile'.$ii]['tmp_name'];
					$upfile_size = $_FILES['upfile'.$ii]['size'];
					$upfile_name = $_FILES['upfile'.$ii]['name'];

				 if($upfile_size > 0){

					file_check($upfile_name);

					$upfile_path = WIZHOME_PATH."/data/member";
				 	if(!is_dir($upfile_path)) mkdir($upfile_path, 0707);
				 	$upfile_name = $id."_".$no."_".$ii.".".pathinfo($upfile_name,PATHINFO_EXTENSION);

				 	exec("rm -f ".$upfile_path."/".$id."_".$no."_".$ii.".*");
				 	copy($upfile, $upfile_path."/".$upfile_name);
				 	chmod($upfile_path."/".$upfile_name, 0606);


					$split_char = "|";

					$fvalue .= $upfile_name;
					if($ii < $row[fnum]) $fvalue .= $split_char;

				 } else {

					$split_char = "|";

					$fvalue .= ${"tmp_upfile_".$no."_".$ii};
					if($ii < $row[fnum]) $fvalue .= $split_char;

				}
	   	}

	    ${"addinfo".$no} = $fvalue;

	   	if(!empty($fvalue)) {
	   		${"addinfo".$no."_sql"} = " , addinfo".$no." = '".$fvalue."' ";
	   	}

	  }


   $no++;
}

//암호화 변경
$passwd = sql_password($passwd);
// 회원정보 저장 
$sql = "insert into wiz_member (idx,id,passwd,name,photo,icon,nick,resno,email,tphone,hphone,comtel,homepage,post,address1,address2,reemail,resms,birthday,bgubun,marriage,memorial,scholarship,job,income,car,hobby,consph,conprd,level,recom,visit,visit_time,intro,memo,addinfo1,addinfo2,addinfo3,addinfo4,addinfo5,wdate)
							values('','$id','$passwd','$name','$photo_name','$icon_name','$nick','$resno','$email','$tphone','$hphone','$comtel','$homepage','$post','$address1','$address2','$reemail','$resms','$birthday','$bgubun','$marriage','$memorial','$scholarship','$job','$income','$car','$hobby','$consph_checked','$conprd','$level','$recom','$visit','$visit_time','$intro','$memo','$addinfo1','$addinfo2','$addinfo3','$addinfo4','$addinfo5',now())";

mysql_query($sql) or error(mysql_error());

// 가입포인트 저장
// save_point("JOIN", $id);

// 적립금 처리
if($oper_info[reserve_use] == "Y"){

	// 회원가입 적립테이블에 저장
	if($oper_info[reserve_join] > 0){
		$reserve_msg = "회원가입 적립금";
		$sql = "insert into wiz_reserve(idx,memid,reservemsg,reserve,orderid,wdate) values('', '$id', '$reserve_msg', '$oper_info[reserve_join]', '', now())";
		mysql_query($sql) or error(mysql_error());
	}

}

// 가입메일발송
$re_info[id]      = $id;
$re_info[name]    = $name;
$re_info[passwd]  = $passwd;
$re_info[hphone]  = $hphone;
$re_info[email]   = $email;
send_mailsms("mem_join", $re_info);

if(empty($prev)) $prev = "http://".$_http_host;
?>
<script>
	document.location = "<?=$prev?>?ptype=ok&id=<?=$id?>";
</script>
