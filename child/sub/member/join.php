<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/head.php"; // head 파일 추가 ?>
<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/header.php"; // header ?>
<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/header_sub.php"; // header sub style ?>


<div id="sub-wrap">

  <div class="container">

    <div class="sub_head_title clearfix">
      <div class="fLeft">
        <h1>회원가입</h1>
      </div>
      <div class="fRight">
        <div class="list">
          <a href=""><span></span></a>
          <a href=""><span>회원가입</span></a>
        </div>
      </div>
    </div>


    <div id="join">
      <div class="join_wrap">

        <? include "$_SERVER[DOCUMENT_ROOT]/adm/module/join.php"; // 회원가입 ?>

      </div>
    </div>
  </div>

</div>


<? include "$_SERVER[DOCUMENT_ROOT]/child/inc/footer.php"; // 푸터 ?>
