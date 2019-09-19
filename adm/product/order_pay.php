<?php
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/prd_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/oper_info.php";
include_once "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";

echo "<link href=\"".$skin_dir."/style.css\" rel=\"stylesheet\" type=\"text/css\">";

?>
<div id="basket_title">
      <h1>구매하기</h1>
  </div>
<div id="basket_process">
      <img src="/child/img/cart/basket-process-3.png">
</div>

<!-- <img class="m-scroll" src="/child/img/scroll.png" alt=""> -->
<div class="bs">
  <div class="basket-scroll">
      <div class="basket-scroll-inner">

        	<? include "$_SERVER[DOCUMENT_ROOT]/adm/product/basket_order.inc"; ?>

        </div>
    </div>
</div>
<? include Inc_payment($pay_method,$oper_info[pay_agent]); ?>
