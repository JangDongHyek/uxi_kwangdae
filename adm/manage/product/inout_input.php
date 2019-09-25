<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include_once "../../inc/oper_info.php"; ?>
<? include_once "../../inc/prd_info.php"; ?>
<? include "../head.php"; ?>

<?php
    if (empty($mode)) $mode = "insert";

    if ($mode == 'update') {
        $sql = "select * from wiz_product_inout where idx = '$idx'";
        $result = mysql_query($sql) or error(mysql_error());
        $row = mysql_fetch_object($result);
    }
 ?>


<style>
.button { padding: 8px 12px; }
.button.blue  { color: #fff; background: #4999de; border: 1px solid #3384c9; }
.button.black { color: #fff; background: #333; border: 1px solid #222; }
</style>

 <div id="location">HOME > 입출고관리</div>
<div id="S_contents">
<h3>내역등록<span>입출고 내역을 등록합니다.</span></h3>

		<h4>기본정보</h4>
      <form name="frm" action="inout_save.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="mode" value="<?= $mode ?>">
          <input type="hidden" name="idx" value="<?= $idx ?>">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th>ID</th>
                <td colspan="3">
                    <input type="text" name="id" value="<?=$row->id?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>제품코드</th>
                <td colspan="3">
                  <input type="text" name="prd_code" value="<?=$row->prd_code?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>제품명</th>
                <td colspan="3">
                	<input type="text" name="prd_name" value="<?=$row->prd_name?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>가격</th>
                <td colspan="3">
                    <input type="text" name="price" value="<?=$row->price?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>출고</th>
                <td colspan="3">
                    <input type="text" name="prd_out" value="<?=$row->prd_out?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>출고시 특이사항</th>
                <td colspan="3">
                    <input type="text" name="prd_out_description" value="<?=$row->prd_out_description?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>입고</th>
                <td colspan="3">
                    <input type="text" name="prd_in" value="<?=$row->prd_in?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>입고시 특이사항</th>
                <td colspan="3">
                    <input type="text" name="prd_in_description" value="<?=$row->prd_in_description?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>주문번호</th>
                <td colspan="3">
                    <input type="text" name="order_idx" value="<?=$row->order_idx?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>대여자</th>
                <td colspan="3">
                    <input type="text" name="lender" value="<?=$row->lender?>" size="60" class="input">
                </td>
              </tr>
              <tr>
                <th>대여~반납</th>
                <td colspan="3">
                    <input class="input w150" type="text" id="datepicker1" name="sand_date" value="<?=$row->sand_date?>" >
    				<input type="button" class="btn_calendar" id=""/> ~
    				<input class="input w150" type="text" id="datepicker2" name="return_date" value="<?=$row->return_date?>" >
    				<input type="button" class="btn_calendar" id=""/>
                </td>
              </tr>
              <tr>
                <th>주문일</th>
                <td colspan="3">
                    <input class="input w150" type="text" id="datepicker3" name="order_date" value="<?=$row->order_date?>" >
    				<input type="button" class="btn_calendar" id=""/>
                </td>
              </tr>

            </table>
          </td>
        </tr>
      </table>





      <br>
      <table align="center" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
			<button type="submit" class="b h28 t5 color blue_big">확인</button>
			<button type="button" class="b h28 t5 color gray_big" onclick="document.location='<?=$listpage_url?>?<?=$param?>';">목록</button>
          </td>
        </tr>
	  </table>
	  </form>



<? include "../foot.php"; ?>
