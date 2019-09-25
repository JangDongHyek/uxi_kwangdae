<? if(strpos($_SERVER[PHP_SELF],"/main/")===false){ //메인이 아닐때 ?>
</div>
<? } ?>
</div><!-- //Container// -->
</div><!-- //Container_wrap// -->

<div id="Footer">
  <div class="footer-top">
    <ul>
      <li><a href="http://uxi.co.kr/">UXI 홈페이지</a></li><li><a href="http://uxi.co.kr/child/sub/sub1/9_customer/contact_us.php">관리자 에러 및 사용법 문의</a></li>
    </ul>
  </div>
  <div class="footer-bottom">
    <span>Copyright ⓒ UXI. All righsts reserved.</span>
    <!-- <?=$site_info[admin_copyright]?> -->
  </div>
</div>
</div>
<?
foreach( $_COMPONENTS as $component ){
  include_once $_SERVER[DOCUMENT_ROOT]."/adm/manage/components/".$component;
}
?>
</body>
</html>

<? mysql_close(); ?>
