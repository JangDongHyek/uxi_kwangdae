<div id="join_box">

<form name="joinFrm" action="<?=$action?>" method="post" enctype="multipart/form-data" onSubmit="return joinCheck(this);">
<input type="hidden" name="ptype" value="save">
<input type="hidden" name="prev" value="<?=$prev?>">
<input type="hidden" name="tmp_vcode" value="<?=md5($norobot_key)?>">

<div class="join_input_tit_wrap">
	<div class="head_title">
		<h3>기본정보 입력</h3>
	</div>

<div class="join_input_caption t_right" ><span class="point_color">*</span> 는 필수입력사항으로 온라인 회원가입시 반드시 필요한 항목입니다.</div>
</div>
<div class="join_input_cont">
	<table id="join_table_style" width="100%" border="0" cellpadding="0" cellspacing="0">
    	<tr>
        	<th>아이디 <span>*</span></th>
            <td>
            	<input id="j_id" name="id" type="text" class="input w130" onClick="idCheck()" readonly>
                <a class="btn btn_confirm" href="#" onClick="idCheck()">중복확인</a>
                <font class="comment left10">* 3~12 영문, 숫자, 가입 후 ID변경은 불가함을 알려드립니다.</font>
            </td>
        </tr>
    	<tr>
        	<th>비밀번호 <span>*</span></th>
            <td>
            	<input id="j_password1" name="passwd1" type="password" class="input w130" />
				<font class="comment left10">* 특수문자 및 한글입력불가, 대소문자 구별, 4~12자리입력</font>
            </td>
        </tr>
    	<tr>
        	<th>비밀번호 확인 <span>*</span></th>
            <td>
            	<input id="j_password2" name="passwd2" type="password" class="input w130" />
            	<font class="comment left10">* 비밀번호 확인을 위해 다시 한 번 입력해 주시기 바랍니다.</font>
            </td>
        </tr>

			<!-- 관리자 선택. KCP 인증 유무 -->
			<? if($site_info[cert_kcp_use] == 'Y'){?>
				<tr><th>KCP 본인인증 <span>*</span></th>
					<td>
						<input type="hidden" name="kcp_cert" />
						<button type="button" onclick="auth_type_check()" style="color: #fff; background-color: #8f8f99; padding: 4px; font-size: 12px;">KCP본인인증하기</button>
						<font class="comment left10">* 본인인증 후에 이름과 휴대폰번호가 자동 입력됩니다.</font>
					</td>
				</tr>
	    	<tr>
					<th>이름 <span>*</span></th>
						<td><input id="j_name" name="name" type="text" class="input w130" onclick="auth_type_check()" readonly/></td>
				</tr>
			<? }else {?>
					<th>이름 <span>*</span></th>
						<td><input id="j_name" name="name" type="text" class="input w130"/></td>
				</tr>
			<?}?>

        <?=$hide_nick_start?>
    	<tr>
        	<th>닉네임 <span><? if($info_ess[nick]) echo "*"; ?></span></th>
            <td>
            	<input name="nick" type="text" class="input w130" readonly onClick="nickCheck();"/>
				<a href="#" onClick="nickCheck()"><img src="<?=$skin_dir?>/image/input_bt_search.gif" /></a>
			</td>
        </tr>
        <?=$hide_nick_end?>
        </tr>

        <?=$hide_photo_start?>
        <tr>
        	<th>회원사진 <span><? if($info_ess[photo]) echo "*"; ?></span></th>
            <td><input name="photo" type="file" class="file" /></td>
        </tr>
        <?=$hide_photo_end?>

        <?=$hide_icon_start?>
        <tr>
        	<th>회원 아이콘 <span><? if($info_ess[icon]) echo "*"; ?></span></th>
            <td><input name="icon" type="file" class="file" /></td>
        </tr>
        <?=$hide_icon_end?>

        <?=$hide_resno_start?>
        <tr>
        	<th>주민등록번호 <span><? if($info_ess[resno]) echo "*"; ?></span></th>
        	<td>
                <input name="resno1" type="text" class="input w100" onKeyup="jfocus(this.form);" <? if($resno1!="") echo "value='".$resno1."' readonly"; ?> />
                -
                <input name="resno2" type="password" class="input w100" <? if($resno2!="") echo "value='".$resno2."' readonly"; ?> />
        	</td>
        </tr>
        <?=$hide_resno_end?>

        <?=$hide_tphone_start?>
        <tr>
        	<th>전화번호 <span><? if($info_ess[tphone]) echo "*"; ?></span></th>
            <td>
            	<input id="j_phone1" name="tphone1" type="text" class="input w40" />
				-
                <input id="j_phone2" name="tphone2" type="text" class="input w40" />
                -
                <input id="j_phone3" name="tphone3" type="text" class="input w40" />
            </td>
        </tr>
        <?=$hide_tphone_end?>

				<!-- 관리자 선택. SMS 인증 유무 -->
				<? if($site_info[cert_sms_use] == 'Y'){?>
	        <tr>
	        	<th rowspan='2'>휴대폰 <span><? if($info_ess[hphone]) echo "*"; ?></span></th>
	          <td>
	          	<input id="j_tel1" name="hphone1" type="text" class="input w40"/>
	              -
	              <input id="j_tel2" name="hphone2" type="text" class="input w40"/>
	              -
	              <input id="j_tel3" name="hphone3" type="text" class="input w40"/>
	              <?=$hide_reemail_start?>
	              <font class="comment left10">SMS 받으시겠습니까?</font>
	              <font class="comment left10"><input name="resms" type="radio" value="Y" id="resms" checked /> <label for="resms">예</label></font>
	              <font class="comment left10"><input name="resms" type="radio"  class="radio" value="N" id="resmsn" /> <label for="resmsn">아니오</label></font>
	              <?=$hide_reemail_end?>
	          </td>
	        </tr>
					<tr>
						<td>
							<input class="input w220" name="authcode_sms" type="text" style="width: 280px; height: 40px;" />
							<input type="hidden" name="authpass_sms" value="false" />
							<button type="button" onclick="create_authcode('phone')" class="btn btn_confirm">인증번호발송</button>
							<button type="button" onclick="check_authcode('phone')" class="btn btn_confirm">인증확인</button>
						</td>
					</tr>
					<?} else{?>
						<tr>
		        	<th>휴대폰 <span><? if($info_ess[hphone]) echo "*"; ?></span></th>
		          <td>
		          	<input id="j_tel1" name="hphone1" type="text" class="input w40"/>
		              -
		              <input id="j_tel2" name="hphone2" type="text" class="input w40"/>
		              -
		              <input id="j_tel3" name="hphone3" type="text" class="input w40"/>
		              <?=$hide_reemail_start?>
		              <font class="comment left10">SMS 받으시겠습니까?</font>
		              <font class="comment left10"><input name="resms" type="radio" value="Y" id="resms" checked /> <label for="resms">예</label></font>
		              <font class="comment left10"><input name="resms" type="radio"  class="radio" value="N" id="resmsn" /> <label for="resmsn">아니오</label></font>
		              <?=$hide_reemail_end?>
		          </td>
		        </tr>
						<?}?>


        <?=$hide_comtel_start?>
        <tr>
        	<th>회사전화 <span><? if($info_ess[comtel]) echo "*"; ?></span></th>
            <td>
            	<input name="comtel1" type="text" class="input w40" />
                -
                <input name="comtel2" type="text" class="input w40" />
                -
                <input name="comtel3" type="text" class="input w40" />
            </td>
        </tr>
        <?=$hide_comtel_end?>

				<!-- 관리자 선택. 이메일 인증 유무 -->
				<? if($site_info[cert_email_use] == 'Y'){?>
	        <tr>
	        	<th rowspan="2">이메일 <span><? if($info_ess[email]) echo "*"; ?></span></th>
	            <td>
                <input id="j_email" type="text" name="email" maxlength="80" class="input w220" />
                <font class="comment left10">이메일을 받으시겠습니까?</font>
                <font class="comment left10"><input name="reemail" type="radio"  class="radio"value="Y" checked id="reemail" /> <label for="reemail">예</label></font>
                <font class="comment left10"><input name="reemail" type="radio"  class="radio"value="N" id="reemailn" /> <label for="reemailn">아니오</label></font>
	            </td>
	        </tr>
					<tr>
						<td>
							<input class="input w220" name="authcode_email" type="text" style="width: 280px; height: 40px;"/>
							<input type="hidden" name="authpass_email" value="false" />
							<button type="button" onclick="create_authcode('email')" class="btn btn_confirm">인증번호발송</button>
							<button type="button" onclick="check_authcode('email')" class="btn btn_confirm">인증확인</button>
						</td>
					</tr>
				<? } else{?>
					<tr>
	        	<th>이메일 <span><? if($info_ess[email]) echo "*"; ?></span></th>
	            <td>
	                <input id="j_email" type="text" name="email" maxlength="80" class="input w220" />
	                <?=$hide_reemail_start?>
	                <font class="comment left10">이메일을 받으시겠습니까?</font>
	                <font class="comment left10"><input name="reemail" type="radio"  class="radio"value="Y" checked id="reemail" /> <label for="reemail">예</label></font>
	                <font class="comment left10"><input name="reemail" type="radio"  class="radio"value="N" id="reemailn" /> <label for="reemailn">아니오</label></font>
	                <?=$hide_reemail_end?>
	            </td>
	        </tr>
				<?}?>

        <?=$hide_homepage_start?>
        <tr>
        	<th>홈페이지 <span><? if($info_ess[homepage]) echo "*"; ?></span></th>
            <td><input type="text" name="homepage" maxlength="80" class="input w220" /></td>
        </tr>
        <?=$hide_homepage_end?>

        <?=$hide_address_start?>
        <tr>
        	<th>주소 <span><? if($info_ess[address]) echo "*"; ?></span></th>
            <td>
            	<div>
                	<input id="j_post" type="text" name="post1" maxlength="5" class="input w40" onClick="postSearch('')" readonly>

                    <a href="#" class="btn btn_confirm" onClick="postSearch('');">우편번호 찾기</a>
                </div>
                <div class="top3"><input id="j_address1" type="text" name="address1" maxlength="80" onClick="postSearch('')" readonly> 기본주소</div>
                <div class="top3"><input id="j_address2" type="text" name="address2" maxlength="80"> 상세주소</div>
            </td>
        </tr>
        <?=$hide_address_end?>

        <?=$hide_recom_start?>
        <tr>
        	<th>추천인 아이디 <span><? if($info_ess[recom]) echo "*"; ?></span></th>
            <td><input name="recom" type="text" class="input w130" /></td>
        </tr>
        <?=$hide_recom_end?>
    </table>
</div>



<?
if($info_use[birthday] ||
$info_use[marriage] ||
$info_use[memorial] ||
$info_use[job] ||
$info_use[scholarship] ||
$info_use[income] ||
$info_use[car] ||
$info_use[hobby] ||
$info_use[consph] ||
$info_use[intro] ||
$info_use[addinfo1] ||
$info_use[addinfo2] ||
$info_use[addinfo3] ||
$info_use[addinfo4] ||
$info_use[addinfo5])
{
?>
<div class="join_input_tit_wrap" style="margin-top:40px;">
	<div class="head_title">
		<h3>추가정보 입력</h3>
	</div>
<div class="join_input_caption t_right"><span>* 는 필수입력사항</span>으로 온라인 회원가입시 반드시 필요한 항목입니다.</div>
</div>
<? } ?>
<div class="join_input_cont">
	<table id="join_table_style" width="100%" border="0" cellpadding="0" cellspacing="0">
		<?=$hide_birthday_start?>
        <tr>
        	<th>생년월일 <span><? if($info_ess[birthday]) echo "*"; ?></span></th>
            <td>
                <font class="comment"><input name="birthday1" type="text" class="input w50" /> 년</font>
                <font class="comment left10"><input name="birthday2" type="text" class="input w30" /> 월</font>
                <font class="comment left10"><input name="birthday3" type="text" class="input w30" /> 일</font>
                <font class="comment left20"><input name="bgubun" value="양력" type="radio" id="biry" checked /> <label for="biry">양력</label></font>
                <font class="comment left10"><input name="bgubun" value="음력" type="radio" id="bire" /> <label for="bire">음력</label></font>
			</td>
		</tr>
		<?=$hide_birthday_end?>

        <?=$hide_marriage_start?>
        <tr>
        	<th>결혼여부 <span><? if($info_ess[marriage]) echo "*"; ?></span></th>
        	<td>
                <font class="comment"><input name="marriage" value="미혼" type="radio" id="marrn" checked /> <label for="marrn">미혼</label></font>
                <font class="comment left10"><input name="marriage" value="기혼" type="radio" id="marry" /> <label for="marry">기혼</label></font>
        	</td>
        </tr>
		<?=$hide_marriage_end?>

        <?=$hide_memorial_start?>
        <tr>
        	<th>결혼기념일 <span><? if($info_ess[memorial]) echo "*"; ?></span></th>
        	<td>
                <font class="comment"><input name="memorial1" type="text" class="input w50" /> 년</font>
                <font class="comment left10"><input name="memorial2" type="text" class="input w30" /> 월</font>
                <font class="comment left10"><input name="memorial3" type="text" class="input w30" /> 일</font>
        	</td>
        </tr>
		<?=$hide_memorial_end?>

        <?=$hide_job_start?>
        <tr>
            <th>직업 <span><? if($info_ess[job]) echo "*"; ?></span></th>
            <td><?=$job_list?></td>
        </tr>
		<?=$hide_job_end?>

        <?=$hide_scholarship_start?>
        <tr>
            <th>학력 <? if($info_ess[scholarship]) echo "*"; ?></th>
            <td><?=$sch_list?></td>
        </tr>
		<?=$hide_scholarship_end?>

        <?=$hide_income_start?>
        <tr>
            <th>월평균소득 <span><? if($info_ess[income]) echo "*"; ?></span></th>
            <td><?=$income_list?></td>
        </tr>
		<?=$hide_income_end?>

        <?=$hide_car_start?>
        <tr>
        	<th>자동차소유 <span><? if($info_ess[car]) echo "*"; ?></span></th>
        	<td>
                <font class="comment"><input name="car" type="radio" value="소유" id="cary" checked /> <label for="cary">소유</label></font>
                <font class="comment left10"><input name="car" type="radio" value="미소유" id="carn" /> <label for="carn">미소유</label></font>
			</td>
        </tr>
		<?=$hide_car_end?>

        <?=$hide_hobby_start?>
        <tr>
        	<th>취미 <span><? if($info_ess[hobby]) echo "*"; ?></span></th>
        	<td><input name="hobby" type="text" class="input w200" /></td>
        </tr>
		<?=$hide_hobby_end?>

        <?=$hide_consph_start?>
        <tr>
        	<th>관심분야 <span><? if($info_ess[consph]) echo "*"; ?></span></th>
        	<td><?=$consph_list?></td>
        </tr>
		<?=$hide_consph_end?>

        <?=$hide_intro_start?>
        <tr>
        	<th>자기소개 <span><? if($info_ess[intro]) echo "*"; ?></span></th>
        	<td><textarea name="intro" rows="5" style="width:98%" class="input"></textarea></td>
        </tr>
		<?=$hide_intro_end?>

        <?=$hide_addinfo1_start?>
        <tr>
        	<th><?=$addname1?> <span><? if($info_ess[addinfo1]) echo "*"; ?></span></th>
        	<td><?=$addinfo1_input?></td>
        </tr>
        <?=$hide_addinfo1_end?>

        <?=$hide_addinfo2_start?>
        <tr>
        	<th><?=$addname2?> <span><? if($info_ess[addinfo2]) echo "*"; ?></span></th>
        	<td><?=$addinfo2_input?></td>
        </tr>
        <?=$hide_addinfo2_end?>

        <?=$hide_addinfo3_start?>
        <tr>
            <th><?=$addname3?> <span><? if($info_ess[addinfo3]) echo "*"; ?></span></th>
            <td><?=$addinfo3_input?></td>
        </tr>
        <?=$hide_addinfo3_end?>

        <?=$hide_addinfo4_start?>
        <tr>
        	<th><?=$addname4?> <span><? if($info_ess[addinfo4]) echo "*"; ?></span></th>
        <td><?=$addinfo4_input?></td>
        </tr>
        <?=$hide_addinfo4_end?>

        <?=$hide_addinfo5_start?>
        <tr>
            <th><?=$addname5?> <span><? if($info_ess[addinfo5]) echo "*"; ?></span></th>
            <td><?=$addinfo5_input?></td>
        </tr>
        <?=$hide_addinfo5_end?>

        <?=$hide_spam_start?>
        <tr>
            <th>자동등록방지코드 <span>*</span></th>
            <td><?=$spam_check?></td>
        </tr>
        <?=$hide_spam_end?>
    </table>
</div>


<div class="join_input_button">
	<input type="submit" class="btn btn_point" value="회원정보등록" />
  <a class="btn btn_border" href="#" onClick="history.go(-1);">취소하기</a>
</div>
</form>



<?
// KCP 본인인증
// 관리자 선택. 검수여부 테스트서버,실서버.
if($site_info[cert_kcp_test] == 'Y'){
	$site_cd = "S6186";
	// A7F6I cert 실서버 테스트시.
	// S6186 테스트서버 사이트코드.
	$kcp_url = "https://testcert.kcp.co.kr/kcp_cert/cert_view.jsp";
}
else{
	$site_cd   = $site_info[cert_kcp_code];
	$kcp_url = "https://cert.kcp.co.kr/kcp_cert/cert_view.jsp";
}

// 리턴페이지 ssl 여부에 따라 https/http
if($site_info[ssl_use] == "Y") $ssl_url = "https://";
else $ssl_url = "http://";
?>

<form name="form_auth">
	<input type="hidden" name="ordr_idxx"    value=""/>

	<input type="hidden" name="user_name"    value=""/>
	<input type="hidden" name="sex_code"     value=""/>
	<input type="hidden" name="local_code"   value=""/>
	<input type="hidden" name="year"    		 value=""/>
	<input type="hidden" name="month"    		 value=""/>
	<input type="hidden" name="day"    			 value=""/>
  <!-- 요청종류 -->
  <input type="hidden" name="req_tx"       value="cert"/>
  <!-- 요청구분 -->
  <input type="hidden" name="cert_method"  value="01"/>
  <!-- 웹사이트아이디 -->
  <input type="hidden" name="web_siteid"   value=""/>
  <!-- 노출 통신사 default 처리시 아래의 주석을 해제하고 사용하십시요
       SKT : SKT , KT : KTF , LGU+ : LGT
  <input type="hidden" name="fix_commid"      value="KTF"/>
  -->
  <!-- 사이트코드 -->
  <input type="hidden" name="site_cd"      value="<?= $site_cd ?>" />
  <!-- Ret_URL : 인증결과 리턴 페이지 ( 가맹점 URL 로 설정해 주셔야 합니다. ) -->
  <input type="hidden" name="Ret_URL"      value="<?= $ssl_url ?>" />
  <!-- cert_otp_use 필수 ( 메뉴얼 참고)
       Y : 실명 확인 + OTP 점유 확인 , N : 실명 확인 only
  -->
  <input type="hidden" name="cert_otp_use" value="Y"/>
  <!-- cert_enc_use 필수 (고정값 : 메뉴얼 참고) -->
  <input type="hidden" name="cert_enc_use" value="Y"/>

  <input type="hidden" name="res_cd"       value=""/>
  <input type="hidden" name="res_msg"      value=""/>

  <!-- up_hash 검증 을 위한 필드 -->
  <input type="hidden" name="veri_up_hash" value=""/>

  <!-- 본인확인 input 비활성화 -->
  <input type="hidden" name="cert_able_yn" value=""/>

  <!-- web_siteid 을 위한 필드 -->
  <input type="hidden" name="web_siteid_hashYN" value="Y"/>

  <!-- 가맹점 사용 필드 (인증완료시 리턴)-->
  <input type="hidden" name="param_opt_1"  value="opt1"/>
  <input type="hidden" name="param_opt_2"  value="opt2"/>
  <input type="hidden" name="param_opt_3"  value=<?= $kcp_url ?>/>
</form>

<script>
// 인증번호발송
function auth_type_check(){

	var today = new Date();
	var year  = today.getFullYear();
	var month = today.getMonth()+ 1;
	var date  = today.getDate();
	var time  = today.getTime();

	if(parseInt(month) < 10)
	{
			month = "0" + month;
	}

	var vOrderID = year + "" + month + "" + date + "" + time;

	var auth_form = document.form_auth;
	auth_form.ordr_idxx.value = vOrderID;
	// auth_form.Ret_URL.value = "https://" + location.hostname + "/ext/KCPCERT/WEB_ENC/kcpcert_proc_req.php";
	auth_form.Ret_URL.value = "<?=$ssl_url?>" + location.hostname + "/ext/KCPCERT/WEB_ENC/kcpcert_proc_req.php";

	if( ( navigator.userAgent.indexOf("Android") > - 1 || navigator.userAgent.indexOf("iPhone") > - 1 ) == false ) // 스마트폰이 아닌경우
	{
		var return_gubun;
		var width  = 410;
		var height = 500;

		var leftpos = screen.width  / 2 - ( width  / 2 );
		var toppos  = screen.height / 2 - ( height / 2 );

		var winopts  = "width=" + width   + ", height=" + height + ", toolbar=no,status=no,statusbar=no,menubar=no,scrollbars=no,resizable=no";
		var position = ",left=" + leftpos + ", top="    + toppos;
		var AUTH_POP = window.open('','auth_popup', winopts + position);
	}

	auth_form.method = "post";
	auth_form.target = "auth_popup"; // !!주의 고정값 ( 리턴받을때 사용되는 타겟명입니다.)
	auth_form.action = "/ext/KCPCERT/WEB_ENC/kcpcert_proc_req.php"; // 인증창 호출 및 결과값 리턴 페이지 주소
	auth_form.submit();
}

function auth_data( frm, name, hphone )
{
		var auth_form     = document.form_auth;
		var nField        = frm.elements.length;
		var response_data = "";

		// up_hash 검증
		if( frm.up_hash.value != auth_form.veri_up_hash.value )
		{
				alert("up_hash 변조 위험있음");
		}
		if(frm.res_cd.value == "0000"){
				document.joinFrm.kcp_cert.value = "Y";
				document.joinFrm.name.value = name;
				document.joinFrm.hphone1.value = hphone.substr(0,3);
				document.joinFrm.hphone2.value = hphone.substring(3,hphone.length-4);
				document.joinFrm.hphone3.value = hphone.substr(hphone.length-4,4);
		}
		console.log(frm.res_cd.value);
}
</script>

</div>
