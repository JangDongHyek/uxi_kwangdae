<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include_once "../../inc/oper_info.php"; ?>
<? include "../head.php"; ?>

<?
// 페이지 파라메터 (검색조건이 변하지 않도록)
//--------------------------------------------------------------------------------------------------
$param = "s_status=$s_status&sdate=$sdate&edate=$edate";
$param .= "&searchopt=$searchopt&searchkey=$searchkey";
//--------------------------------------------------------------------------------------------------

?>
<script language="JavaScript" type="text/javascript">
<!--

// 주문상태 변경
function chgStatus(s_status){
   document.frm.s_status.value = s_status;
   document.frm.submit();
}

//체크박스선택 반전
function onSelect(form){
	if(form.select_tmp.checked){
		selectAll();
	}else{
		selectEmpty();
	}
}

//체크박스 전체선택
function selectAll(){

	var i;

	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].orderid != null){
			if(document.forms[i].select_checkbox){
				document.forms[i].select_checkbox.checked = true;
			}
		}
	}
	return;
}

//체크박스 선택해제
function selectEmpty(){

	var i;

	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].orderid != null){
			if(document.forms[i].select_checkbox){
				document.forms[i].select_checkbox.checked = false;
			}
		}
	}
	return;
}

//선택상품 삭제
function orderDelete(){

	var i;
	var selorder = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].orderid != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked)
					selorder = selorder + document.forms[i].orderid.value + "|";
				}
			}
	}

	if(selorder == ""){
		alert("삭제할 주문을 선택하지 않았습니다.");
		return;
	}else{
		if(confirm("선택한 주문을 정말 삭제하시겠습니까?")){
			document.location = "order_save.php?mode=delete&selorder=" + selorder + "&<?=$param?>";
		}else{
			return;
		}
	}
	return;

}

// 선택 주문서 출력
function orderPrint() {

	var i;
	var selorder = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].orderid != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked)
					selorder = selorder + document.forms[i].orderid.value + "|";
				}
			}
	}

	if(selorder == ""){
		alert("출력할 주문을 선택하지 않았습니다.");
		return;
	}else{
		document.order_print.location = "order_print.php?selorder=" + selorder;
	}
	return;

}

// 선택주문 상태변경
function batchStatus(){

	var i;
	var selorder = "";
	for(i=0;i<document.forms.length;i++){
		if(document.forms[i].orderid != null){
			if(document.forms[i].select_checkbox){
				if(document.forms[i].select_checkbox.checked)
					selorder = selorder + document.forms[i].orderid.value + ":" + document.forms[i].status.value + "|";
				}
			}
	}

	if(selorder == ""){
		alert("변경할 주문을 선택하지 않았습니다.");
		return;
	}else{
		var url = "order_status.php?selorder=" + selorder;
		window.open(url,"batchStatus","height=250, width=250, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, top=100, left=100");
	}
	return;

}

// 주문정보 엑셀다운
function excelDown(){
	var url = "order_excel.php?<?=$param?>";
	window.open(url,"excelDown","height=350, width=650, menubar=no, scrollbars=no, resizable=yes, toolbar=no, status=no, top=100, left=100");
}
Date.prototype.yyyymmdd = function()
	{
		var yyyy = this.getFullYear().toString();
		var mm = (this.getMonth() + 1).toString();
		var dd = this.getDate().toString();


		return yyyy + (mm[1] ? '-'+mm : '-0'+mm[0]) + (dd[1] ? '-'+dd : '-0'+dd[0]);
	}
// 기간설정
function setPeriod(pdate){
		var dt = new Date().yyyymmdd();
		//dt = dt.getFullYear() + "-" + (dt.getMonth() + 1) + "-" + dt.getDate();

		var sdate = document.frm.sdate;
		var edate = document.frm.edate;

		sdate.value= pdate;
		edate.value = dt;


		document.frm.submit();
	}

function order_return(btn, orderid){
  if(confirm("※ 주의사항\n반납이 이루어질 경우 취소가 불가능합니다.\n해당 주문건을 반납 처리하시겠습니까?")){
    $.ajax({
      url: "order_return_ajax.php",
      method: "post",
      data: { orderid: orderid },
      success: function(res){
        var data = JSON.parse(res);
        if(data.error) alert(data.error);
        else{
          alert("반납이 완료되었습니다.");
          window.location.reload();
        }
      }
    });
  }
}



//-->
</script>

<div id="location">HOME > 상품관리</div>
<div id="S_contents">
<h3>주문목록<span>주문검색 목록 입니다.</span></h3>

<?include "order_count.php"?>
			<form name="frm" action="<?=$PHP_SELF?>" method="post">
			<input type="hidden" name="page" value="">
			<input type="hidden" name="s_status" value="<?=$s_status?>">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" class="table_basic">
			 <tr>
			   <th width="15%">진행상태</th>
			   <td width="85%">
           <div class="btn_orderlist_wrap">

  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('');" value=" 전체 " <? if($s_status == "") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('OR');" value="주문접수(<?=$OR_total?>)" <? if($s_status == "OR") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('OY');" value="결제완료(<?=$OY_total?>)" <? if($s_status == "OY") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('DR');" value="배송준비중(<?=$DR_total?>)" <? if($s_status == "DR") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('DI');" value="배송처리" <? if($s_status == "DI") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('DC');" value="배송완료" <? if($s_status == "DC") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('OC');" value="주문취소" <? if($s_status == "OC") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('MI');" value="미주문" <? if($s_status == "MI") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>><br>

  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('RD');" value="취소요청(<?=$RD_total?>)" <? if($s_status == "RD") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('RC');" value="취소완료" <? if($s_status == "RC") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('CD');" value="교환요청(<?=$CD_total?>)" <? if($s_status == "CD") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>
  			     <input style="cursor:pointer;" type="button" onClick="chgStatus('CC');" value="교환완료" <? if($s_status == "CC") echo "class='btn_sm w100 h30'"; else echo "class='btn_m w100 h30'"; ?>>

           </div>
         </td>
			 </tr>
			 <tr>
			   <th>기간</th>
			   <td>
    				<input class="input w100" type="text" id="datepicker1" name="sdate" value="<?=$sdate?>" >
    				<input type="button" class="btn_calendar" id=""/> ~
    				<input class="input w100" type="text" id="datepicker2" name="edate" value="<?=$edate?>" >
    				<input type="button" class="btn_calendar" id=""/>
					<?
					$yes_day = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y'))-(3600*24*1));
					$to_day = date('Y-m-d');
					$week_day = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y'))-(3600*24*7));
					$month_day = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y'))-(3600*24*30));
					?>

					<button type="button" class="h22 small t3 gray_s" onclick="setPeriod('<?=$to_day?>')">오늘</button>
					<button type="button" class="h22 small t3 gray_s" onclick="setPeriod('<?=$yes_day?>')">어제</button>
					<button type="button" class="h22 small t3 gray_s" onclick="setPeriod('<?=$week_day?>')">1주일</button>
					<button type="button" class="h22 small t3 gray_s" onclick="setPeriod('<?=$month_day?>')">1개월</button>

			   </td>
			 </tr>
			 <tr>
			   <th>조건검색</th>
			   <td>
			       <select name="searchopt" class="select2">
			       <option value="send_name" <? if($searchopt == "send_name") echo "selected"; ?>>주문자명</option>
			       <option value="rece_name" <? if($searchopt == "rece_name") echo "selected"; ?>>수취인명</option>
			       <option value="orderid" <? if($searchopt == "orderid") echo "selected"; ?>>주문번호</option>
			       <option value="send_id" <? if($searchopt == "send_id") echo "selected"; ?>>아이디</option>
			       <option value="send_hphone" <? if($searchopt == "send_hphone") echo "selected"; ?>>휴대폰</option>
			       <option value="rece_tphone" <? if($searchopt == "rece_tphone") echo "selected"; ?>>전화번호</option>
			       <option value="send_email" <? if($searchopt == "send_email") echo "selected"; ?>>이메일</option>
			       <option value="account_name" <? if($searchopt == "account_name") echo "selected"; ?>>입금자명</option>
			       </select>
			       <input type="text" name="searchkey" value="<?=$searchkey?>" class="input">
			       <button type="submit" style="height:22px" class="b h28 t5 color blue_big">검색</button>
			   </td>
			 </tr>
			</table>
			</form>
			<? if($oper_info[pay_test]=="Y"){ ?><div class="top10"><font color="red"><strong>현재 결제 시스템이 테스트 상태 입니다. 결제를 해도 실 결제가 이루어 지지 않습니다.<br>정상적인 운영을 위해서는 "쇼핑몰관리>운영정보설정>결제시스템" 에서 "PG업체 연동" 을 체크 후 운영하시기 바랍니다.</font></strong></div><? } ?>

			<?
			$sql = "select orderid from wiz_order where status != ''";
			$result = mysql_query($sql) or error(mysql_error());
			$all_total = mysql_num_rows($result);

			if($sdate && $edate){
			   $prev_period = $sdate;
			   $next_period = $edate." 23:59:59";
			   $period_sql = " and wo.order_date >= '$prev_period' and wo.order_date <= '$next_period'";
			}
			if($s_status == "") $status_sql = "and wo.status != ''";
			else if($s_status == "MI") $status_sql = "and wo.status = ''";
			else $status_sql = "and wo.status = '$s_status'";

			if($searchopt && $searchkey) $searchopt_sql = " and wo.$searchopt like '%$searchkey%'";

			$sql = "select orderid from wiz_order wo where orderid !='' $status_sql $period_sql $searchopt_sql order by orderid desc";
			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);

			$rows = 20;
			$lists = 5;
			$page_count = ceil($total/$rows);
			if($page < 1 || $page > $page_count) $page = 1;
			$start = ($page-1)*$rows;
			$no = $total-$start;
			?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top10">
        <tr>
          <td>총 주문수 : <b><?=$all_total?></b> 검색 주문수 : <b><?=$total?></b></td>
          <td align="right">
				<font color="6DCFF6">■</font> 결제완료
				<font color="BD8CBF">■</font> 주문완료
				<font color="ED1C24">■</font> 주문취소 &nbsp;
				<!-- <button type="button" class="h22 t4 small icon gray" onClick="excelDown();"><span class="icon_exel"></span>엑셀파일저장</button> -->
          </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list bbs_order_list top5">
      	<thead>
        <tr>
          <td width="60"><form><input type="checkbox" name="select_tmp" onClick="onSelect(this.form)"></form></td>
          <td width="11%">주문일</td>
          <td width="10%">반납일</td>
          <td >주문번호</td>
          <td width="16%">주문자명</td>
          <td width="12%">주문방법</td>
          <td width="5%">on/off</td>
          <td width="11%">주문금액</td>
          <td width="115">주문상태</td>
          <td width="13%">기능</td>
        </tr>
        </thead>
        <tbody>
		<?
		$orderid = "";

		$sql = "select order_date, orderid, send_name, send_id, pay_method, total_price, status, deliver_num, deliver_date, escrow_check, order_return, return_date, offline from wiz_order wo where orderid !='' $status_sql $period_sql $searchopt_sql order by orderid desc limit $start, $rows";
		$result = mysql_query($sql) or error(mysql_error());

		while(($row = mysql_fetch_object($result)) && $rows){

			if($orderid == $row->orderid) continue;
			else $orderid = $row->orderid; $ordernum = 0;

			if($row->status == "OY") $stacolor = "6DCFF6";
			else if($row->status == "DC" || $row->status == "CC") $stacolor = "BD8CBF";
			else if($row->status == "OC" || $row->status == "RC" || $row->status == "RD") $stacolor = "ED1C24";
			else $stacolor = "";

			if(!strcmp($row->escrow_check, "Y")) $escrow_check = "<br>[에스크로]";
			else  $escrow_check = "";

		?>

      <tr>
        <td colspan="10">
          <form action="order_save.php" name="<?=$row->prdcode?>" method="get" style="width: 100%;">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list bbs_order_list top5">
            <tbody>
              <td width="60">
                  <input type="hidden" name="mode" value="chgstatus">
                  <input type="hidden" name="page" value="<?=$page?>">
                  <input type="hidden" name="orderid" value="<?=$row->orderid?>">
                  <input type="hidden" name="status" value="<?=$row->status?>">
                  <input type="hidden" name="s_status" value="<?=$s_status?>">
                  <input type="hidden" name="prev_year" value="<?=$prev_year?>">
                  <input type="hidden" name="prev_month" value="<?=$prev_month?>">
                  <input type="hidden" name="prev_day" value="<?=$prev_day?>">
                  <input type="hidden" name="next_year" value="<?=$next_year?>">
                  <input type="hidden" name="next_month" value="<?=$next_month?>">
                  <input type="hidden" name="next_day" value="<?=$next_day?>">
                  <input type="hidden" name="searchopt" value="<?=$searchopt?>">
                  <input type="hidden" name="searchkey" value="<?=$searchkey?>">
                  <input type="checkbox" name="select_checkbox">
                </td>
                <td width="11%"><?=substr($row->order_date,0,16)?></td>
                <td width="10%"><?=($row->order_return)?$row->return_date:""?></td>
                <td><a href="order_info.php?orderid=<?=$row->orderid?>&page=<?=$page?>&<?=$param?>"><?=$row->orderid?></a> <?=$escrow_check?></td>
                <td width="16%">
                  <?
                  if($row->send_id == "") echo "$row->send_name [비회원]";
                  else echo "<a href='../member/member_input.php?mode=update&id=$row->send_id'>$row->send_name [$row->send_id]</a>";
                  ?>
                </td>
                <td width="12%"><?=pay_method($row->pay_method)?></td>
                <td width="5%"><?=($row->offline ? "오프라인" : "온라인")?></td>
                <td width="11%"><?=number_format($row->total_price)?>원 &nbsp;</td>
                <td width="115" bgcolor="<?=$stacolor?>">
                  <select name="chg_status" style="width:105px">
                    <? if(!strcmp($row->status, "OC")) {	//주문취소,취소완료인 경우 상태변경 불가능 ?>
                      <option value="OC" <? if($row->status == "OC") echo "selected"; ?>>주문취소</option>
                    <? } else if(!strcmp($row->status, "RC")) { ?>
                      <option value="RC" <? if($row->status == "RC") echo "selected"; ?>>취소완료</option>
                    <? } else { ?>
                      <? 		if($row->status == "OR"){ ?>
                        <option>---------</option>
                        <option value="OR" <? if($row->status == "OR") echo "selected"; ?>>주문접수</option>
                        <option value="OY" <? if($row->status == "OY") echo "selected"; ?>>결제완료</option>
                        <option value="OC" <? if($row->status == "OC") echo "selected"; ?>>주문취소</option>
                      <? 		}else{ ?>
                        <option>---------</option>
                        <option value="OY" <? if($row->status == "OY") echo "selected"; ?>>결제완료</option>
                        <option value="DR" <? if($row->status == "DR") echo "selected"; ?>>배송준비중</option>
                        <option value="DI" <? if($row->status == "DI") echo "selected"; ?>>배송처리</option>
                        <option value="DC" <? if($row->status == "DC") echo "selected"; ?>>배송완료</option>
                        <option value="OC" <? if($row->status == "OC") echo "selected"; ?>>주문취소</option>
                        <option>---------</option>
                        <option value="RD" <? if($row->status == "RD") echo "selected"; ?>>취소요청</option>
                        <option value="RC" <? if($row->status == "RC") echo "selected"; ?>>취소완료</option>
                        <option value="CD" <? if($row->status == "CD") echo "selected"; ?>>교환요청</option>
                        <option value="CC" <? if($row->status == "CC") echo "selected"; ?>>교환완료</option>
                      <? 		} ?>
                    <? } ?>
                  </select>
                </td>
                <td width="13%">
                  <button type="submit" class="h18 t3 color small round red_s">적용</button>
                  <button type="button" class="h18 t3 color small round black_s" onClick="document.location='order_info.php?orderid=<?=$row->orderid?>&page=<?=$page?>&<?=$param?>'">상세보기</button>
                  <button type="button" class="h18 t3 color small round black_s" onClick="order_return(this,<?=$row->orderid?>)" style="<?=($row->order_return == 1)?"background-color: #ccc; border: 1px solid #ccc;":""?>" <?=($row->order_return == 1)?"disabled":""?>>반납</button>
              </td>

            </tbody>
          </table>
        </form>
        </td>
      </tr>

			<?
				$no--;
				$rows--;
			}
			if($total <= 0){
			?>
			<tr><td colspan="8">등록된 주문이 없습니다.</td></tr>

			<?
			}
			?>
			</tbody>
			</table>

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="top5">
				<tr>
				 <td width="35%">
					<button type="button" class="h22 t4 small icon gray" onClick="orderDelete();"><span class="icon_plus"></span>선택삭제</button>
					<button type="button" class="h22 t4 small icon gray" onClick="batchStatus();"><span class="icon_plus"></span>상태일괄변경</button>
					<button type="button" class="h22 t4 small icon gray" onClick="orderPrint();"><span class="icon_plus"></span>주문서출력</button>
				 </td>
				 <td width="31%"><? print_pagelist($page, $lists, $page_count, "&$param"); ?></td>
				 <td width="33%"></td>
				</tr>
			</table>

			<div class="graybox top50">
				<p class="question">궁금증 해결!</p>
				<div class="top10 font11 line2 colorgray">
				  <b><font color="#000000">에스크로 주문 처리 주의사항</font></b><br>
				  - 에스크로 주문인경우 반드시 배송정보(택배사,송장번호,발송일자)를 결제시스템 회사에 등록해야합니다.<br>
				  - 위 주문 목록에서 주문번호 밑에 [에스크로] 표시가 되있다면 반드시 등록되어야합니다.<br>
				  - [에스크로]가 표시된것은 운영정보설정 > 에스크로 사용함으로 설정된 상태에서 고객이 10만원 이상 주문시 계좌이체, 가상계좌를 이용해서 주문한경우입니다.<br>
						- 에스크로 주문인 경우 실제 결제가 완료되어 결제시스템 회사의 상태가 결제된 이후에 배송정보가 결제시스템 회사로 등록됩니다.<br><br>

				  <b><font color="#000000">배송정보 등록방법</font></b><br>
				  1. 주문상세보기에서 운송장번호를 입력 후 처리상태를 "배송처리", "배송완료" 로 변경한경우 결제시스템 회사에 배송정보가 등록됩니다.<br>
				  2. 상태일괄변경에서 상태를 "배송처리", "배송완료" 로 선택하는경우 운송장번호 발송일자를 입력하는 화면이 생성됩니다.<br>
				  &nbsp;운송장 번호,발송일자를 입력후 적용하면 배송정보가 결제시스템 회사로 등록됩니다.<br><br>

				  <b><font color="#000000">재고 수량 확인</font></b><br>
				  - "주문완료" 시 수량이 감소되며 결제가 완료되지 않으면 직접 "주문취소" 처리를 하셔야 수량이 증가합니다.<br>
				</div>
			</div>

			<iframe SRC="" width="0" height="0" frameborder="0" border="0" scrolling="no" marginheight="0" marginwidth="0"  name="order_print"></iframe>

<? include "../foot.php"; ?>
