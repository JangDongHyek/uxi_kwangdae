<? if(strpos($_SERVER[PHP_SELF],"/main/")!==false){ //메인일때 노출 ?>
<?
function str_insert_pattern($str, $len)
{
	$ereg = "[^ \n<>]{".$len."}";

	return eregi_replace($ereg, "\\0\n", $str);    // 대소문자 구분안함
}

?>

<script type="text/javascript">
	function go_popup() {

		$('#popup').bPopup({
            speed: 650,
            transition: 'slideIn',
			transitionClose: 'slideBack'
		});

	};

	$(document).ready(function(){

		$(":checkbox").click(function(){
			var len = $(":checkbox:checked").length;

			var max = 10;
			if( len > max )
			{
				alert(max + " 개 이상 등록할 수 없습니다");
				$(this).attr("checked",false);
				return;
			}

		});
	/*
		$(".quick_btn").click(function(){
			var $chk = $(":checkbox:checked");
			var max = 5;
			var quick;

			if($chk.length < 1)
			{
				alert("Quick Link에 등록할 메뉴를 하나이상 선택하세요");
				return;
			}
			else if( $chk.length > max )
			{
				alert(max + " 개 이상 등록할 수 없습니다");
				return;
			}

			quick = $chk.serialize();

			$.post("./quick_link.act.php",{quick:quick},function(data){
				alert("Quick Link 등록 완료");
				location.reload();
			});
		});
	*/
	});
	function addurl() {

		var frm = document.frm;
		var tbl = document.getElementById('quick');
		var row = tbl.insertRow(-1);
		var t = 1;
		for (i=0;i<tbl.rows[0].cells.length;i++){
			cell = row.insertCell(0);
			cell.innerHTML = "링크명 : <input type=\"text\" size='15' class=\"input\" name=\"url[]\">";
			cell.innerHTML += " Url : <input type=\"text\" size=\"50\" class=\"input\" name=\"urlname[]\">";
			cell.innerHTML += " 사용여부 : <input id='c" +(tbl.rows.length - 1) +"' type=\"checkbox\" onclick=used('c" +(tbl.rows.length - 1)+"','t"+(tbl.rows.length - 1)+"'); checked>";
			cell.innerHTML += " <input id='t" +(tbl.rows.length - 1)+"' type=\"hidden\" value='' name=\"used[]\">";

		}
	}

	function delurl() {

		var tbl = document.getElementById('quick');
		if (tbl.rows.length > 1) tbl.deleteRow(-1);
	}

	function used (idx,uid) {
		if (document.getElementById(idx).checked == true) {
			document.getElementById(uid).value = 'Y';
		}
		else {
			document.getElementById(uid).value = 'N';
		}

	}
</script>
<style type="text/css">

.Pstyle {
    opacity: 0;
    display: none;
    position: relative;
    width: 700px;
    border: 5px solid #fff;
    padding: 20px;
    background-color: #fff;
}

.b-close {
    position: absolute;
    right: 5px;
    top: 5px;
    padding: 5px;
    display: inline-block;
    cursor: pointer;
}
</style>

    <div id="popup" class="Pstyle" style="display:none;">
        <span class="b-close">X</span>
        <div class="content" style="height: auto; width:700px;">
			<table width="100%" border="0" cellspacing="0" cellpadding="2">
			  <tr>
				<td><h3 style="background: url(../image/sub/h3.gif) left 6px no-repeat;line-height: 1.6;font-size: 16px;font-weight: bold;color: #2f2f2f;padding-left: 16px;">퀵링크 메뉴관리</h3></td>
			  </tr>
			</table>
			<br />
			<form name="frm" action="../menu_save.php" method="post">
			<?
				$sql = "select * from wiz_quicklink where info != ''";
				$result = mysql_query($sql) or error(mysql_error());
				$row = mysql_fetch_array($result);
			?>
			<table width="100%" class="table_basic">
			  <tr>
				<td>
					<table width="100%" border="0" cellspacing="5" cellpadding="0" id="quick">
						<tr>
							<td>
								<button type="button" class="h18 t3 color small round black_s" onClick="addurl()">추가</button>
								<button type="button" class="h18 t3 color small round red_s" onClick="delurl()">삭제</button>
							</td>
						</tr>
						<?
						$url_arr = explode("^^", $row[info]);
						for($ii = 0; $ii < count($url_arr) - 1; $ii++) {
							list($url, $urlname, $used) = explode("^", $url_arr[$ii]);
						?>
						<tr>
							<td>
								링크명 : <input type="text" size="15" class="input" name="url[]" value="<?=$url?>">
								Url : <input type="text" size="50" class="input" name="urlname[]" value="<?=$urlname?>">
								사용여부 :
								<input id="c<?=$ii+1?>" <? if($used == 'Y') echo checked ?> type="checkbox" onclick="used('c<?=$ii+1?>','t<?=$ii+1?>');">
								<input id="t<?=$ii+1?>" type="hidden" class="input" name="used[]" value="<?=$used?>">
							</td>
						</tr>
						<?
						}
						?>
					</table>
				</td>
			  </tr>
			</table>
			<div align="center">
				<button type="submit" style="margin-top:5px" class="b h28 t5 color blue_big">저장</button>
			</div>
			</form>

        </div>
    </div>



<div class="main_left"><!-- 메인일때 좌, 우측 여백 -->
    <div class="License">
        <p class="tit type1">라이센스</p>
        <ul class="cont">
            <li><span>솔루션</span><br />Wizcom Plus</li>
            <li><span>라이센스</span></br >
				<?
					if($site_info[site_key] == ''){
						echo "라이센스 비활성";
					}
					else{
						echo str_insert_pattern($site_info[site_key],25);
					}
				?>
			</li>
            <li><span>설치일</span><br /><?=date("Y-m-d H:i:s", $site_info[site_date])?></li>
            <li><span>도메인</span></br ><?=$_SERVER["HTTP_HOST"];?></li>
        </ul>
    </div><!-- //M_license// -->
    <script>
		function openMenu() {
			window.open('../menu_config.php', 'cm', 'width=850,height=700,menubar=no, scrollbars=yes, resizable=no, toolbar=no, status=no, top=100, left=100');

		}
	</script>
    <div class="Quicklink top15" style="display:none;">
        <p class="tit type2"><span>퀵</span> 링크</p>
        <ul class="cont">
			<?
			$sql = "select * from wiz_quicklink where info != ''";
			$result = mysql_query($sql) or error(mysql_error());

			$row = mysql_fetch_array($result);
			$url_arr = explode("^^", $row[info]);
			for($ii = 0; $ii < count($url_arr) - 1; $ii++) {
				list($url, $urlname, $used) = explode("^", $url_arr[$ii]);
				if($used == 'Y'){
			?>
					<li><a href="<?=$urlname?>"><?=$url?></a></li>
			<?
				}
			}
			?>
        </ul>
		<a href="javascript:go_popup();void(0);" onFocus="this.blur();" class="more">메뉴관리</a>
    </div><!-- //M_quicklink// -->



	<!-- //M_cs// -->
</div><!-- //main_left// -->
<? } ?>


<? if(strpos($_SERVER[PHP_SELF],"/config/")==true){ //좌측메뉴 메인 아닐때 노출 ?>


<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 환경설정</h2>
	<ul id="Lnb">
		<li class="on"><a href="./basic_config.php" onFocus="this.blur();">기본설정</a>
			<ul>
				<li>
					<a href="./basic_config.php">기본설정</a>
				</li>
				<li>
					<a href="./log_config.php">로그분석</a>
				</li>
				<li>
					<a href="./popup_config.php">팝업관리</a>
				</li>
				<li>
					<a href="./poll_config.php">설문조사</a>
				</li>
				<li>
					<a href="./pollmain_config.php">메인설문</a>
				</li>
				<li>
					<a href="./form_config.php">폼메일</a>
				</li>
				<li>
					<a href="./sms_config.php">SMS발송</a>
				</li>
				<li>
					<a href="./schedule_config.php">일정관리</a>
				</li>
				<li>
					<a href="./banner_config.php">배너관리</a>
				</li>
				<li>
					<a href="./page_config.php">페이지관리</a>
				</li>
				<li>
					<a href="./levelcheck_config.php">페이지접근권한</a>
				</li>
				<li>
					<a href="./counter_config.php">카운터</a>
				</li>
				<li>
					<a href="./search_config.php">전체검색</a>
				</li>
			</ul>
		</li>
		<li class="on"><a href="#" onFocus="this.blur();">게시판</a>
			<ul>
				<li>
					<a href="./bbs_config.php">게시판</a>
				</li>
				<li>
					<a href="./bbsmain_config.php">메인게시물</a>
				</li>
			</ul>
		</li>
		<li class="on"><a href="#" onFocus="this.blur();">회원</a>
			<ul>
				<li>
					<a href="./member_config.php">회원관리</a>
				</li>
			</ul>
		</li>
		<li class="on"><a href="#" onFocus="this.blur();">쇼핑몰</a>
			<ul>
				<li>
					<a href="./prd_config.php">상품관리</a>
				</li>
				<li>
					<a href="./prdmain_config.php">메인상품</a>
				</li>
			</ul>
		</li>
		<!-- <li class="on"><a href="./message_config.php" onFocus="this.blur();">쪽지관리</a> -->
		<li class="on"><a href="./point_config.php" onFocus="this.blur();">포인트관리</a>
		<li class="on"><a href="./naver_config.php" onFocus="this.blur();">네이버 연동</a>
		<li class="on"><a href="./cert_config.php">인증 관리</a>
	</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/basic/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 기본설정</h2>
	<ul id="Lnb">
		<li class="on"><a href="./site_info.php" onFocus="this.blur();">기본설정</a>
			<ul>
				<li>
					<a href="./site_info.php">사이트정보</a>
				</li>
				<li>
					<a href="./admin_list.php">관리자설정</a>
				</li>
				<li>
					<a href="./popup_list.php">팝업관리</a>
				</li>
				<? if($site_info[sms_use] == "Y"){ ?>
				<li>
					<a href="./sms_fill.php">SMS관리</a>
				</li>
				<? } ?>
			</ul>
		</li>

	</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/bbs/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 게시판 관리</h2>
	<ul id="Lnb">
		<li class="on"><a href="./bbs_manage_list.php" onFocus="this.blur();">게시판 관리</a>
			<ul>
				<li>
					<a href="./bbs_list.php">게시판관리</a>
				</li>
				<li>
					<a href="./bbs_manage_list.php">게시물통합관리</a>
				</li>
				<!-- <li>
					<a href="./bbs_manage_comment.php">코멘트통합관리</a>
				</li> -->
			</ul>
		</li>
		<li class="on">
			<a href="#">게시판목록</a>
		</li>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<?
			$bbs_grp = explode("\n", $site_info[bbs_grp]);
			for($ii = 0; $ii < count($bbs_grp); $ii++) {
				if(!empty($bbs_grp[$ii])) {
					$tmp_grp = explode("^", $bbs_grp[$ii]);
					$bbs_grp_list[$tmp_grp[0]] = $tmp_grp[1];
				}
			}

		  $sql = "select * from wiz_bbsinfo where type='BBS' order by grp asc, prior asc";
				$result = mysql_query($sql) or error(mysql_error());
				$total = mysql_num_rows($result);
				while($row = mysql_fetch_array($result)){
					if(!empty($row[grp]) && strcmp($row[grp], $tmp_grp)) {
				?>
				<tr><td height="10"></td></tr>
				<tr>
					<td height="20" style="padding-left:15px"><b><?=$bbs_grp_list[$row[grp]]?></b></td>
				</tr>
				<?php
					}
				?>
				<tr>
					<td height="20" style="padding: 7px 0 0 22px;color: #777777;"><img src="../image/left_s_arrow.gif" align="absmiddle"><a href="./list.php?code=<?=$row[code]?>"><?=$row[title]?></a></td>
				</tr>
		  <?
			$tmp_grp = $row[grp];
			}
			if($total <= 0){
			?>
			<tr>
					<td height="20"><font color=red>등록된 게시판이<br>없습니다.</font></td>
			</tr>
			<?
			}
			?>

		</table>
	</ul>
<? } ?>
<? if(strpos($_SERVER[PHP_SELF],"/member/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 회원관리</h2>
<ul id="Lnb">
	<li class="on"><a href="./member_list.php" onFocus="this.blur();">회원관리</a>
		<ul>
			<li class="">
				<a href="./member_list.php">회원목록</a>
			</li>
			<!-- <li>
				<a href="./level_list.php">회원등급</a>
			</li> -->
			<li>
				<a href="./out_list.php">탈퇴회원</a>
			</li>
			<li>
				<a href="./mail_list.php">이메일,SMS설정</a>
			</li>
			<li>
				<a href="./mail_test.php">메일발송테스트</a>
			</li>
			<li>
				<a href="./mail_send.php">단체메일발송</a>
			</li>
			<? if($site_info[sms_use] == "Y"){ ?>
			<li>
				<a href="./sms_send.php">단체SMS발송</a>
			</li>
			<? } ?>
			<li>
				<a href="./member_config.php">가입약관 및 개인정보 보호정책</a>
			</li>
		</ul>
	</li>
	<? if($site_info[msg_use] == "Y"){ ?>
	<!-- <li class="on"><a href="./message_send.php" onFocus="this.blur();">쪽지관리</a>
		<ul>
			<li>
				<a href="./message_send.php">쪽지발송</a>
			</li>
			<li>
				<a href="./message_list.php">쪽지목록</a>
			</li>
		</ul>
	</li> -->
	<? } ?>
	<? if($site_info[point_use] == "Y"){ ?>
	<li class="on"><a href="./point_config.php" onFocus="this.blur();">포인트관리</a>
		<ul>
			<li>
				<a href="./point_config.php">포인트설정</a>
			</li>
			<li>
				<a href="./point_list.php">포인트목록</a>
			</li>
	</ul>
	</li>
	<? } ?>
</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/product/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 쇼핑몰관리</h2>
<ul id="Lnb">
	<li class="on"><a href="./shop_oper.php">운영정보설정</a></li>
	<li class="on"><a href="./prd_list.php">상품관리</a>
		<ul>
			<li>
				<a href="./prd_list.php">상품목록</a>
			</li>
			<li>
				<a href="./prd_category.php">상품분류</a>
			</li>
			<li>
				<a href="./prd_shortage.php">재고관리</a>
			</li>
			<li>
				<a href="./prd_estimate.php">상품평관리</a>
			</li>
			<li>
				<a href="./qna_list.php">상품문의관리</a>
			</li>
			<li>
				<a href="./prd_inout.php">입출고관리</a>
			</li>
		</ul>
	</li>
	<li class="on">
		<a href="./order_list.php">주문관리</a>
		<ul>
			<li>
				<a href="./order_list.php">주문목록</a>
			</li>
			<li>
				<a href="./order_create.php">주문서작성</a>
			</li>
			<li>
				<a href="./order_list.php?s_status=RD">취소요청</a>
			</li>
			<li>
				<a href="./order_list.php?s_status=CD">교환요청</a>
			</li>
			<li>
				<a href="./cancel_list.php">개별취소요청</a>
			</li>
			<li>
				<a href="./tax_list.php?tax_type=T">세금계산서</a>
			</li>
			<li>
				<a href="./tax_list.php?tax_type=C">현금영수증</a>
			</li>
		</ul>
	</li>
	<li class="on">
		<a href="./analy_paymethod.php">통계분석</a>
		<ul>

			<li>
				<a href="./analy_prd.php">상품통계분석</a>
			</li>
		</ul>
	</li>
	<li class="on"><a href="./shop_reserve.php">적립금관리</a></li>

</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/connect/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 접속자분석</h2>
<ul id="Lnb">
    <li class="on"><a href="./connect_list.php" onFocus="this.blur();">접속자분석</a>
        <ul>
			<li class="">
				<a href="./connect_list.php">접속자분석</a>
			</li>

			<li>
				<a href="./connect_refer.php">접속경로분석</a>
			</li>

			<li>
				<a href="./connect_keyword.php">검색키워드분석</a>
			</li>
			<li>
				<a href="./connect_osbrowser.php">OS/브라우저</a>
			</li>
        </ul>
    </li>

</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/form/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 폼메일관리</h2>
<ul id="Lnb">
	<li class="on"><a href="./form_list.php" onFocus="this.blur();">폼메일관리</a>
		<ul>
		<?
			$sql = "select * from wiz_forminfo where code != ''";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);
			while($row = mysql_fetch_array($result)){
			?>

			<li><a href="./form_list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>

	    <?
		}
		if($total <= 0){
		?>

			<li><a><font color=red>등록된 폼메일이 없습니다.</font></a></li>

		<?
		}
		?>
		</ul>
	</li>
</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/poll/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 설문관리</h2>
<ul id="Lnb">
	<li class="on"><a href="./pollinfo_list.php" onFocus="this.blur();">설문관리</a>
		<ul>
		<?
			$sql = "select code, title from wiz_pollinfo";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);
			while($row = mysql_fetch_array($result)){
			?>

			<li><a href="./poll_list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>

	    <?
		}
		if($total <= 0){
		?>

			<li><a><font color=red>등록된 설문이 없습니다.</font></a></li>

		<?
		}
		?>
		</ul>
	</li>
</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/schedule/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 스케쥴관리</h2>
<ul id="Lnb">
	<li class="on"><a href="./sch_list.php" onFocus="this.blur();">스케쥴관리</a>
		<ul>
		<?
			$sql = "select * from wiz_bbsinfo where type='SCH'";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);
			while($row = mysql_fetch_array($result)){
			?>

			<li><a href="./list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>

	    <?
		}
		if($total <= 0){
		?>

			<li><a><font color=red>등록된 일정이 없습니다.</font></a></li>

		<?
		}
		?>
		</ul>
	</li>
</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/page/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 페이지관리</h2>
<ul id="Lnb">
	<li class="on"><a href="./page_list.php" onFocus="this.blur();">페이지관리</a>
		<ul>
		<?
			$page_grp = explode("\n", $site_info[page_grp]);
			for($ii = 0; $ii < count($page_grp); $ii++) {
				if(!empty($page_grp[$ii])) {
					$tmp_grp = explode("^", $page_grp[$ii]);
					$page_grp_list[$tmp_grp[0]] = $tmp_grp[1];
				}
			}

			$sql = "select * from wiz_page order by menu asc, prior asc";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);
			while($row = mysql_fetch_array($result)){
				if(strcmp($row[menu], $tmp_grp) && !empty($row[menu])) {
			?>
			<br />	<b style="padding-left:15px;"><?=$page_grp_list[$row[menu]]?></b>
			<?
				}
			?>
			<li><a href="./page_input.php?mode=update&idx=<?=$row[idx]?>"><?=$row[title]?></a></li>

	    <?
		$tmp_grp = $row[menu];
		}

		if($total <= 0){
		?>

			<li><a><font color=red>등록된 페이지가 없습니다.</font></a></li>

		<?
		}
		?>
		</ul>
	</li>
</ul>
<? } ?>

<? if(strpos($_SERVER[PHP_SELF],"/banner/")==true){ //좌측메뉴 메인 아닐때 노출 ?>
<h2><img src="/adm/manage/image/header/icon3.png" alt=""> 배너관리</h2>
<ul id="Lnb">
	<li class="on"><a href="./banner_list.php" onFocus="this.blur();">배너관리</a>
		<ul>
		<?
			$sql = "select * from wiz_bannerinfo order by title";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);
			while($row = mysql_fetch_array($result)){
			?>

			<li><a href="./list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>

	    <?
		}
		if($total <= 0){
		?>

			<li><a><font color=red>등록된 배너그룹이 없습니다.</font></a></li>

		<?
		}
		?>
		</ul>
	</li>
</ul>
<? } ?>
