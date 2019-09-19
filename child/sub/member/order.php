<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/head.php"; // head 파일 추가 ?>
<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/header.php"; // header ?>
<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/header_sub.php"; // header sub style ?>
<style>
#order{ background: #f3f4f5; padding: 24px 16px; }
</style>
<div id="order">
  <div class="container">
    <? include "$_SERVER[DOCUMENT_ROOT]/adm/module/order.php"; // 상품주문 ?>
  </div>
</div>

<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/footer.php"; // 푸터 ?>
