<?
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php";

$total = count($view_list);
$v_idx = $total-1;
$scroll_amount = 100;		// 한번에 스크롤되는 값
if($total > 0) $div_height = 220;

if($total <= 0) $prd_view .= "<tr><td height='71' align='center'></td></tr>";

if(!empty($prd_info[wish_url])) $prd_info[wish_url] = "/".$prd_info[wish_url];
else $prd_info[wish_url] = "\"javascript:alert('상품보관함 페이지가 설정되지 않았습니다.');\"";

if(!empty($prd_info[basket_url])) $prd_info[basket_url] = "/".$prd_info[basket_url];
else $prd_info[basket_url] = "\"javascript:alert('장바구니 페이지가 설정되지 않았습니다.');\"";

$prd_view = "
<script>
function gdscroll(gap){
 var gdscroll = document.getElementById('gdscroll');
 gdscroll.scrollTop += gap;
}
</script>
<div class='quick_today'>
  <div class='quick_title'>
    <span>최근 본 상품</span>
    <div class='quick-stat-wrap'>
        <button class='quick-prev'></button>
        <span class='quick-stat'><em id='current-slide-stat'>1</em>/<em id='total-slide-stat'></em></span>
        <button class='quick-next'></button>
    </div>
  </div>

  <!--<div><font style='color:#999'>(".$total."개)</font></div>-->

	<div id=gdscroll class='swiper-quickmenu'>
    <div class='today-slide'>
";

while(0 <= $v_idx){

	// 상품 이미지
	if(!@file($_SERVER[DOCUMENT_ROOT]."/adm/data/prdimg/".$view_list[$v_idx][prdimg])) $view_prdimg = "/adm/images/noimg_R.gif";
	else $view_prdimg = "/adm/data/prdimg/".$view_list[$v_idx][prdimg];

	$prd_view .= "<div class='_today'><a href=".$view_list[$v_idx][prdurl]."?ptype=view&prdcode=".$view_list[$v_idx][prdcode]."><img style='width:auto;' src=".$view_prdimg." border=0></a></div>";
	$v_idx--;
}

$prd_view .= "
    </div>
  </div> <!-- gdscroll End -->
    <!--
    <a href='javascript:gdscroll(".$scroll_amount.")'><</a>
    <a href='javascript:gdscroll(-".$scroll_amount.")'>></a>
	  <a href=".$prd_info[wish_url]."><img src=/adm/images/prdview/btn_q_1.gif border=0></a>
	  <a href=".$prd_info[basket_url]."><img src=/adm/images/prdview/btn_q_2.gif border=0></a>
    -->
</div>

</div>
";

if($prd_info[right_scroll] == "Y"){
	if($prd_info[site_align] == "CENTER"){
		$site_width = ceil($prd_info[site_width]/2);
		// echo "<div id='scrollingBanner' style='width:100%;padding-top:10px;Z-INDEX:1;POSITION:absolute;LEFT:expression(document.body.clientWidth/2+".$site_width.")px;TOP:".$prd_info[right_starty]."px'>";
    echo "<div id='scrollingBanner'>";
	}else{
		// echo "<div id='scrollingBanner' style='width:100%;padding-top:10px;Z-INDEX:1;POSITION:absolute;LEFT:".$prd_info[site_width]."px;TOP:".$prd_info[right_starty]."px'>";
    echo "<div id='scrollingBanner'>";
	}
}else{
	echo "<div style='width:100%;height:100%;padding-top:10px;Z-INDEX:1;POSITION:absolute;LEFT:".$prd_info[site_width]."px;TOP:".$prd_info[right_starty]."px'>";
}

?>
	<div style='width:100%; height:100%;'>
	  <?=$prd_view?>
  </div>


  <script>
  var curStat = $('#current-slide-stat'),
  totalStat = $('#total-slide-stat');
  $(".today-slide")
  .on('afterChange',function(event, slick, currentSlide, nextSlide){
      var cur = $('.today-slide .slick-dots li.slick-active').index();
      curStat.text(cur + 1);
  })
  .slick({
      cssEase: 'ease-in-out',
      arrows: true,
      dots: true,
      infinite: true,
      // autoplay: true,
      autoplaySpeed: 3000,
      speed : 700,
      slidesToShow: 2,
      slidesToScroll: 2
  });

  $('.quick-prev').click(function(){
      $('.today-slide').slick('slickPrev');
  });
  $('.quick-next').click(function(){
      $('.today-slide').slick('slickNext');
  });

  totalStat.text($('.today-slide .slick-dots li').length);
  </script>
