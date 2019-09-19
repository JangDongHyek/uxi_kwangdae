<? include_once "../../inc/site_info.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head lang="ko">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title><?=$site_info[admin_title]?></title>
<link rel="stylesheet" href="/adm/css/jquery-ui.css">
<link href="../wiz_style.css" rel="stylesheet" type="text/css"/>
<link href="../materialize.css" rel="stylesheet" type="text/css"/>
<script src="https://cdn.polyfill.io/v2/polyfill.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>
<script>
Number.prototype.format = function(n, x) {
  var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
  return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');};

function onkeydown_amount(e){
  if(47 < e.keyCode && e.keyCode < 58){
    return true;
  }
  else if(95 < e.keyCode && e.keyCode < 106){
    return true;
  }
  else if(e.keyCode == 8 || e.keyCode == 9 || e.keyCode == 37 || e.keyCode == 39){
    return true;
  }
  else{
    return false;
  }
}
function onchange_amount(obj){
  if(obj.value == "" || obj.value < 1) obj.value = 1;
}
</script>
<script>
if(Vue && !Vue.app){
	Vue.data    = {};
	Vue.methods = {};
  Vue.watch   = {};
  Vue.components = {};
  Vue.computed = {};
  Vue.created = [];
  Vue.mounted = [];

  window.addEventListener('load', function(){
    console.log(document.getElementById("vue-app"));
    Vue.app = new Vue({
      el: "#vue-app",
      data: Vue.data,
      methods: Vue.methods,
      components: Vue.components,
      computed: Vue.computed,
      created: function(){
        for(var i=0; i<Vue.created.length; i++){
          Vue.created[i]();
        }
      },
      mounted: function(){
        for(var i=0; i<Vue.mounted.length; i++){
          Vue.mounted[i]();
        }
      }
    });
  }, false);
}
</script>
<script src="/adm/js/jquery-1.10.2.js"></script>
<script src="/adm/js/jquery-ui.js"></script>
<script src="/adm/js/jquery.highchartTable.js"></script>
<script src="/adm/js/highcharts.js"></script>
<script src="/adm/js/jquery.bpopup.min.js"></script>
<script src="/adm/js/jquery.cookie.js"></script>
<script language="JavaScript" src="/adm/js/default.js"></script>
<script language="JavaScript" src="/adm/js/lib.js"></script>
<script>jQuery.ajaxSetup({cache:false});</script>
<style>
	.ui-datepicker { width: 242px; font-size:90%;}
	.ui-datepicker-calendar > tbody td:first-child a {
		COLOR: #f00;
	}
	.ui-datepicker-calendar > tbody td:last-child a {
		COLOR: blue;
	}
</style>
<script>
	$(function() {
		$( "#datepicker1" ).datepicker({
			dateFormat: 'yy-mm-dd',
				//yearSuffix: '년',
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
				changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
				showMonthAfterYear: true // 년월 셀렉트 박스 위치 변경
				//altField: "#date", // 타겟 필드
				//minDate: '-0d', // 오늘 이전 날짜는 선택 못함

		});
	});
	$(function() {
		$( "#datepicker2" ).datepicker({
			dateFormat: 'yy-mm-dd',
				//yearSuffix: '년',
				dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
				monthNamesShort: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
				changeMonth: true, // 월을 바꿀수 있는 셀렉트 박스를 표시한다.
				changeYear: true, // 년을 바꿀 수 있는 셀렉트 박스를 표시한다.
				showMonthAfterYear: true // 년월 셀렉트 박스 위치 변경
				//altField: "#date", // 타겟 필드
				//minDate: '-0d', // 오늘 이전 날짜는 선택 못함

		});
	});

	$(document).ready(function(){
		var parserRules = [
		  { pattern: /HOME/g, replacement: '<span class="home"></span>' }
		];
		document.querySelectorAll('#location').forEach(function(tag) {
		  var inner = tag.innerHTML;
		  parserRules.forEach(function(rule) {
		    inner = inner.replace(rule.pattern, rule.replacement)
		  });
		  tag.innerHTML = inner;
		});

	 if($.cookie("left_quick") == "close"){
		$('#Container_wrap').addClass('left_close');
	 }else{
		$('#Container_wrap').removeClass('left_close');

	 }


	});

	function leftBtn() {
		$('#Container_wrap').toggleClass('left_close');
		if ($('#Container_wrap').hasClass('left_close')) {
			$.cookie('left_quick', 'close', { expires: 1, path: '/', domain: '<?=$_SERVER[HTTP_HOST]?>', secure: false });
		}
		else {
			$.cookie('left_quick', 'open', { expires: 1, path: '/', domain: '<?=$_SERVER[HTTP_HOST]?>', secure: false });
		}
	}


</script>

</head>
<body class="home_body">
<div id="vue-app">
<div id="Header">
	<div class="header-top">
		<h1 class="logo"><a href="../main/main.php" title="UXI 관리자 홈"></a></h1>
		<ul id="gnb">
    	<li class="first"><a target="_blank" href="http://<?=$_SERVER["HTTP_HOST"];?>">내홈페이지</a></li>
    	<li><a href="/adm/manage/main/main.php">관리자홈</a></li>
    	<li><a href="../../logout.php" class="logbtn">로그아웃</a></li>
    </ul>
	</div>
	<div class="header-bottom">
		<div id="navi">
    	<li class="design">
				<? if($wiz_admin[designer] == "Y"){ ?>
				<a href="../config/basic_config.php"><span class="nav-icon n1"></span><span>환경설정</span></a>
				<? } ?>
			</li>
			<?
				// 메뉴사용여부
				$menu_tmp = explode("/",$site_info[menu_use]);
				for($ii=0; $ii<count($menu_tmp); $ii++){
					$menu_arr[$menu_tmp[$ii]] = true;
				}
			?>
			<? if($menu_arr["BASIC"]==true){ ?>
			<li>
				<a href="../basic/site_info.php"><span class="nav-icon n2"></span><span>기본설정</span></a>
	        	<ul class="category">
					<li>
						<a href="../basic/site_info.php">사이트정보</a>
					</li>
					<li>
						<a href="../basic/admin_list.php">관리자설정</a>
					</li>
					<li>
						<a href="../basic/popup_list.php">팝업관리</a>
					</li>
					<? if($site_info[sms_use] == "Y"){ ?>
					<li>
						<a href="../basic/sms_fill.php">SMS관리</a>
					</li>
					<? } ?>
				</ul>
			</li>
	        <? } ?>

			<? if($menu_arr["BBS"]==true){ ?>
			<li>
				<a href="../bbs/bbs_list.php"><span class="nav-icon n3"></span><span>게시판관리</span></a>
	        	<ul class="category">
	        		<li>
						<a href="../bbs/bbs_list.php">게시판관리</a>
					</li>
					<li>
						<a href="../bbs/bbs_manage_list.php">게시물통합관리</a>
					</li>
					<!-- <li>
						<a href="../bbs/bbs_manage_comment.php">코멘트통합관리</a>
					</li> -->
				</ul>
			</li>
	    	<? } ?>

			<? if($menu_arr["MEMBER"]==true){ ?>
			<li>
				<a href="../member/member_list.php"><span class="nav-icon n4"></span><span>회원관리</span></a>
				<ul class="category">
					<li>
						<a href="../member/member_list.php">회원목록</a>
					</li>

					<li>
						<a href="../member/level_list.php">회원등급</a>
					</li>

					<li>
						<a href="../member/out_list.php">탈퇴회원</a>
					</li>

					<li>
						<a href="../member/mail_list.php">메일,SMS설정</a>
					</li>
					<li>
						<a href="../member/mail_test.php">메일발송테스트</a>
					</li>
					<li>
						<a href="../member/mail_send.php">단체메일발송</a>
					</li>

					<? if($site_info[sms_use] == "Y"){ ?>
					<li>
						<a href="../member/sms_send.php">단체SMS발송</a>
					</li>
					<? } ?>
					<li>
						<a href="../member/member_config.php">가입약관, 개인정보보호정책</a>
					</li>
					<? if($site_info[msg_use] == "Y"){ ?>
					<!-- <li>
						<a href="../member/message_send.php">쪽지발송</a>
					</li>
					<li>
						<a href="../member/message_list.php">쪽지목록</a>
					</li> -->
					<? } ?>
					<? if($site_info[point_use] == "Y"){ ?>
					<li>
						<a href="../member/point_config.php">포인트설정</a>
					</li>
					<li>
						<a href="../member/point_list.php">포인트목록</a>
					</li>
					<? } ?>
				</ul>
			</li>
			<? } ?>

	       	<? if($menu_arr["FORMMAIL"]==true){?>
			<li>
				<a href="../form/form_list.php"><span class="nav-icon n5"></span><span>폼메일관리</span></a>
	        	<ul class="category">
					<li>
						<a href="../form/form_list.php">폼메일관리</a>
					</li>
					<li class="depth"><a href="#">폼메일목록</a>
						<ul class="category_2depth">
							<?
							$sql = "select * from wiz_forminfo where code != ''";
							$result = mysql_query($sql) or error(mysql_error());
							$total = mysql_num_rows($result);
							while($row = mysql_fetch_array($result)){
							?>
							<li><a href="../form/form_list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>
							<?
							}
							if($total <= 0){
							?>
								<li><a>폼메일이 없습니다.</a></li>
							<?
							}
							?>
						</ul>
					</li>
				</ul>
			</li>
	        <? } ?>

		    <? if($menu_arr["POLL"]==true){?>
			<li>
				<a href="../poll/pollinfo_list.php"><span class="nav-icon n6"></span><span>설문관리</span></a>
				<ul class="category">
					<li>
						<a href="../poll/pollinfo_list.php">설문관리</a>
					</li>
					<li class="depth"><a href="#">설문목록</a>
						<ul class="category_2depth">
							<?
							$sql = "select code, title from wiz_pollinfo";
							$result = mysql_query($sql) or error(mysql_error());
							$total = mysql_num_rows($result);
							while($row = mysql_fetch_array($result)){
							?>
								<li><a href="../poll/poll_list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>
							<?
							}
							if($total <= 0){
							?>
								<li><a>등록된 설문이 없습니다.</a></li>
							<?
							}
							?>
						</ul>
					</li>

				</ul>
			</li>
	        <? } ?>

			<? if($menu_arr["SCHEGUAL"]==true){?>
	        <li>
				<a href="../schedule/sch_list.php"><span class="nav-icon n7"></span><span>스케쥴관리</span></a>
				<ul class="category">
					<li>
						<a href="../schedule/sch_list.php">스케쥴관리</a>
					</li>
					<li class="depth"><a href="#">스케쥴목록</a>
						<ul class="category_2depth">
							<?
							$sql = "select * from wiz_bbsinfo where type='SCH'";
							$result = mysql_query($sql) or error(mysql_error());
							$total = mysql_num_rows($result);
							while($row = mysql_fetch_array($result)){
							?>
								<li><a href="../schedule/list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>
							<?
							}
							if($total <= 0){
							?>
								<li><a>등록된 일정이 없습니다.</a></li>
							<?
							}
							?>
						</ul>
					</li>

				</ul>
			</li>
	        <? } ?>

			<? if($menu_arr["PAGE"]==true){?>
			<li>

				<a href="../page/page_list.php"><span class="nav-icon n8"></span><span>페이지관리</span></a>
				<ul class="category">
					<li>
						<a href="../page/page_list.php">페이지관리</a>
					</li>
					<li class="depth"><a href="#">페이지목록</a>
						<ul class="category_2depth">
					<?
						$sql = "select * from wiz_page order by menu asc, prior asc";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						while($row = mysql_fetch_array($result)){
						?>
						<li><a href="../page/page_input.php?mode=update&idx=<?=$row[idx]?>"><?=$row[title]?></a></li>
					<?
					}
					$tmp_grp = $row[menu];
					if($total <= 0){
					?>
						<li><a>등록된 페이지가 없습니다.</a></li>
					<?
					}
					?>
						</ul>
					</li>
				</ul>

			</li>
			<? } ?>

			<? if($menu_arr["BANNER"]==true){?>
			<li>
				<a href="../banner/banner_list.php"><span class="nav-icon n9"></span><span>배너관리</span></a></td>
				<ul class="category">
					<li>
						<a href="../banner/banner_list.php">배너관리</a>
					</li>
					<li class="depth"><a href="#">배너목록</a>
						<ul class="category_2depth">
					<?
						$sql = "select * from wiz_bannerinfo order by title";
						$result = mysql_query($sql) or error(mysql_error());
						$total = mysql_num_rows($result);
						while($row = mysql_fetch_array($result)){
						?>
						<li><a href="../banner/list.php?code=<?=$row[code]?>"><?=$row[title]?></a></li>
					<?
					}
					if($total <= 0){
					?>
						<li><a>등록된 배너그룹이 없습니다.</a></li>
					<?
					}
					?>
						</ul>
					</li>
				</ul>
			</li>
			<? } ?>


			<? if($menu_arr["LOG"]==true){?>
			<li>
				<a href="../connect/connect_list.php"><span class="nav-icon n10"></span><span>접속통계</span></a>
	        	<ul class="category">
					<li>
						<a href="../connect/connect_list.php">접속자분석</a>
					</li>

					<li>
						<a href="../connect/connect_refer.php">접속경로분석</a>
					</li>

					<li>
						<a href="../connect/connect_keyword.php">검색키워드분석</a>
					</li>
					<li>
						<a href="../connect/connect_osbrowser.php">OS/브라우저</a>
					</li>
				</ul>
			</li>
	    	<? } ?>


			<? if($menu_arr["PRODUCT"]==true){?>
			<li>
				<a href="../product/prd_list.php"><span class="nav-icon n11"></span><span>쇼핑몰관리</span></a>
				<ul class="category">
					<li><a href="../product/shop_oper.php">운영정보설정</a></li>
					<li class="depth"><a href="../product/prd_list.php">상품관리</a>
						<ul class="category_2depth">
							<li>
								<a href="../product/prd_list.php">상품목록</a>
							</li>
							<li>
								<a href="../product/prd_category.php">상품분류</a>
							</li>
							<li>
								<a href="../product/prd_shortage.php">재고관리</a>
							</li>
							<li>
								<a href="../product/prd_estimate.php">상품평관리</a>
							</li>
							<li>
								<a href="../product/prd_qna.php">상품문의관리</a>
							</li>
						</ul>
					</li>
					<li class="depth"><a href="../product/order_list.php">주문관리</a>
						<ul class="category_2depth">
							<li>
								<a href="../product/order_list.php">주문목록</a>
							</li>
							<li>
								<a href="../product/cancel_list.php">주문취소목록</a>
							</li>
							<li>
								<a href="../product/tax_list.php?tax_type=T">세금계산서</a>
							</li>
							<li>
								<a href="../product/tax_list.php?tax_type=C">현금영수증</a>
							</li>
						</ul>
					</li>
					<li class="depth"><a href="../product/analy_paymethod.php">통계분석</a>
						<ul class="category_2depth">

							<li>
								<a href="../product/analy_prd.php">상품통계분석</a>
							</li>
						</ul>
					</li>
					<li><a href="../product/shop_reserve.php">적립금관리</a></li>
				</ul>
			</li>
	    	<? } ?>

    </div>
	</div>
</div>




<div id="Container_wrap" class="right_close">
    <!--
    class="left_close" 좌측만 닫힘
    class="right_close" 우측만 닫힘
    class="left_close right_close" 양쪽 닫힘
    -->
    <div class="nav_handle_left">
		<a href="#" onclick="leftBtn();"></a>
	</div>

    <div id="left_area">
		<? include "left_area.php"; ?>
	</div><!-- //left_area// -->

	<div id="Container">
