<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/head.php"; // head 파일 추가 ?>
<? $quick = "on"; include "$_SERVER[DOCUMENT_ROOT]/child/inc/header.php"; // header ?>
<? // include "$_SERVER[DOCUMENT_ROOT]/child/inc/quickmenu.php"; // Quick Menu ?>

<div class="prd-wrap">


    <div id="list">
        <? include "$_SERVER[DOCUMENT_ROOT]/adm/module/product.php"; // 상품관리 ?>
    </div>


</div>
<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/footer.php"; // 푸터 ?>
