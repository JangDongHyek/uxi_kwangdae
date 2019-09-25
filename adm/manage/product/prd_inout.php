<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include "../head.php"; ?>
<?

// 페이지 파라메터 (검색조건이 변하지 않도록)
//--------------------------------------------------------------------------------------------------
$param = "dep_code=$dep_code&dep2_code=$dep2_code&dep3_code=$dep3_code&list_rows=$list_rows";
$param .= "&special=$special&display=$display&coupon_use=$coupon_use&searchopt=$searchopt&searchkey=$searchkey";
$param .= "&brand=$brand&shortage=$shortage&stock=$stock";
//--------------------------------------------------------------------------------------------------

$sql = "select * from wiz_product_inout";
$result = mysql_query($sql) or error(mysql_error());
$all_total = mysql_num_rows($result);

if(!empty($searchkey))$search_sql ="and $searchopt like '%$searchkey%'" ;

$sql = "select * from wiz_product_inout where 1 $search_sql";
$result = mysql_query($sql) or error(mysql_error());
$total = mysql_num_rows($result);

// $rows = 16;
if($list_rows == ""){
    $rows = 30;
}else{
    $rows = $list_rows;
}
$lists = 5;
$page_count = ceil($total/$rows);
if(!$page || $page > $page_count) $page = 1;
$start = ($page-1)*$rows;
$no = $total-$start;


?>

<div id="location">HOME > 입출고관리</div>
<div id="S_contents">

	<h3>입출고관리<span></span></h3>

  <form action="<?=$PHP_SELF?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
      <tr>
      	<th width="15%">상품검색</th>
      	<td width="85%">
    			<select name="searchopt">
    				<option value="prd_name" <? if($searchopt == "prd_name") echo "selected"; ?>>제품명</option>
                    <option value="lender" <? if($searchopt == "lender") echo "selected"; ?>>대여자</option>
    			</select>
    			<input type="text" name="searchkey" value="<?=$searchkey?>" class="input">
    			<button style="height:22px;vertical-align:bottom;" type="submit" class="b h28 t5 color blue_big">검색</button>
      	</td>
      </tr>
    </table>
  </form>

  <table name="list_table" width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td>
                    총 상품수 : <b><?=$all_total?></b> , 검색 상품수 : <b><?=$total?></b> , 리스트 출력수
                    <select id="sel_list_rows" name="sel_list_rows" onChange="list_rows_change();">
                        <option value=""  <? if($list_rows == "30") echo selected?>>30개</option>
                        <option value=""  <? if($list_rows == "50") echo selected?>>50개</option>
                        <option value="" <? if($list_rows == "100") echo selected?>>100개</option>
                        <option value="" <? if($list_rows == "150") echo selected?>>150개</option>
                        <option value="" <? if($list_rows == "200") echo selected?>>200개</option>
                        <option value="" <? if($list_rows == "10000") echo selected?>>10000개</option>
                    </select>
                </td>
      <td align="right">
                  <!-- <button type="button" class="h22 t4 small icon gray" onClick="excelUp();"><span class="icon_exel"></span>엑셀상품등록</button>
                  <button type="button" class="h22 t4 small icon gray" onClick="excelDown();"><span class="icon_exel"></span>엑셀파일저장</button> -->
                  <button type="button" class="h22 t4 small icon gray" onClick="document.location='inout_input.php?<?=$param?>'"><span class="icon_plus"></span>내역등록</button>
      </td>
    </tr>
            <tr>
                <td height="3"></td>
            </tr>
  </table>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list bbs_prd_list">
    <tr class="t_td">
      <td width="5%">
          <input type="checkbox" name="checkAll" id="th_checkAll" onclick="checkAll();">
      </td>
      <td width="5%">ID</td>
      <td width="5%">제품코드</td>
      <td width="10%">제품명</td>
      <td width="5%">가격</td>
      <td width="5%">출고</td>
      <td width="5%">출고시 특이사항</td>
      <td width="5%">입고</td>
      <td width="5%">입고시 특이사항</td>
      <td width="5%">주문번호</td>
      <td width="5%">대여자</td>
      <td width="5%">대여</td>
      <td width="5%">반납</td>
      <td width="5%">주문일</td>
      <td width="10%">기능</td>

    </tr>

    <?

    $sql = "select * from wiz_product_inout where 1 $search_sql limit $start, $rows";
    $result = mysql_query($sql) or error(mysql_error());

    while(($row = mysql_fetch_object($result)) && $rows){

        ?>

    <tr>
  	  <td>
          <input type="checkbox" name="checkRow" value="<?=$row->idx?>">
      </td>
      <td><?= $row->id ?></td>
      <td><?= $row->prd_code ?></td>
      <td><?= $row->prd_name ?></td>
      <td><?= $row->price ?></td>
      <td><?= $row->prd_out ?></td>
      <td><?= $row->prd_out_description ?></td>
      <td><?= $row->prd_in ?></td>
      <td><?= $row->prd_in_description ?></td>
      <td><?= $row->order_idx ?></td>
      <td><?= $row->lender ?></td>
      <td><?= $row->sand_date ?></td>
      <td><?= $row->return_date ?></td>
      <td><?= $row->order_date ?></td>
      <td>
          <button type="button" class="h18 t3 color small round red_s" onclick="document.location='inout_input.php?mode=update&idx=<?=$row->idx?>&page=<?=$page?>&<?=$param?>'">수정</button>
          <button type="button" class="h18 t3 color small round black_s" onclick="one_delete('<?=$row->idx?>')">삭제</button>
      </td>
  	</tr>

    <?
    $no--;
    $rows--;
    }
    if($total <= 0){
        ?>
        <tr><td colspan="14">작성된 글이 없습니다.</td></tr>

        <?
    }
    ?>


  </table>

  <table width="100%" height="0" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="33%">
	      <button type='button' class='h22 t4 small icon gray' onclick="deleteAction()">
          <span class='icon_x'></span>선택삭제
        </button>
      </td>
      <td width="34%"><? print_pagelist($page, $lists, $page_count, $param); ?></td>
      <td width="33%" align="right"></td>
    </tr>
  </table>

	<? include "../foot.php"; ?>

<script type="text/javascript">

function checkAll(){
      if( $("#th_checkAll").is(':checked') ){
        $("input[name=checkRow]").prop("checked", true);
      }else{
        $("input[name=checkRow]").prop("checked", false);
      }
}

/* 삭제(체크박스된 것 전부) */
function deleteAction(){
  var checkRow = "";
  $( "input[name='checkRow']:checked" ).each (function (){
    checkRow = checkRow + $(this).val()+"," ;
  });
  checkRow = checkRow.substring(0,checkRow.lastIndexOf( ",")); //맨끝 콤마 지우기

  if(checkRow == ''){
    alert("삭제할 대상을 선택하세요.");
    return false;
  }

  if(confirm("정보를 삭제 하시겠습니까?")){

      location.href = "inout_save.php?mode=delete&idx=" + checkRow;

  }

}

function one_delete(idx) {
    if(confirm("정보를 삭제 하시겠습니까?")){

        location.href = "inout_save.php?mode=delete&idx=" + idx;

    }
}


</script>
