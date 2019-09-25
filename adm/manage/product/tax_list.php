<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include "../head.php"; ?>
<? include_once "../../inc/oper_info.php"; ?>

<?
// 페이지 파라메터 (검색조건이 변하지 않도록)
//--------------------------------------------------------------------------------------------------
$param = "status=$status&sdate=$sdate&edate=$edate";
$param .= "&searchopt=$searchopt&searchkey=$searchkey";
$param .= "&tax_type=$tax_type";
//--------------------------------------------------------------------------------------------------

if($tax_type == "T") $tax_title = "세금계산서";
else if($tax_type == "C") $tax_title = "현금영수증";
?>
<script language="JavaScript" type="text/javascript">
<!--

// 주문상태 변경
function chgStatus(status){
   document.frm.status.value = status;
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
function taxDelete(){

var i;
var selvalue = "";
for(i=0;i<document.forms.length;i++){
	if(document.forms[i].orderid != null){
		if(document.forms[i].select_checkbox){
			if(document.forms[i].select_checkbox.checked)
				selvalue = selvalue + document.forms[i].orderid.value + "|";
			}
		}
}

if(selvalue == ""){
	alert("삭제할 항목을 선택하지 않았습니다.");
	return;
}else{
	if(confirm("선택한 항목을 정말 삭제하시겠습니까?")){
		document.location = "order_save.php?mode=tax_delete&selvalue=" + selvalue + "&tax_type=<?=$tax_type?>";
	}else{
		return;
	}
}
return;

}

// 선택주문 상태변경
function batchStatus(){

var i;
var selvalue = "";
for(i=0;i<document.forms.length;i++){
	if(document.forms[i].orderid != null){
		if(document.forms[i].select_checkbox){
			if(document.forms[i].select_checkbox.checked)
				selvalue = selvalue + document.forms[i].orderid.value + "|";
			}
		}
}

if(selvalue == ""){
	alert("변경할 항목을 선택하지 않았습니다.");
	return;
}else{
	var url = "tax_status.php?selvalue=" + selvalue;
	window.open(url,"taxStatus","height=140, width=200, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, top=100, left=100");
}
return;

}

// 세금계싼서 엑셀다운
function excelDown(){

	document.location = "tax_excel.php?<?=$param?>";

}
// 증빙서류 엑셀다운

function dacomexcelDown(){

document.location = "dacomtax_txt.php?<?=$param?>";

}
function kcpexcelDown(){

document.location = "kcptax_txt.php?<?=$param?>";

}

// 기간설정
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

var clickvalue='';
function viewTax( orderid ) {

	ccontent =eval("ccontent_"+orderid+".style");

	if(clickvalue != ccontent) {
		if(clickvalue!='') {
			clickvalue.display='none';
		}

		ccontent.display='';
		clickvalue=ccontent;
	} else {
		ccontent.display='none';
		clickvalue='';
	}

}

// 증빙서류 출력
function printTax(orderid) {
	var url = "/adm/product/print_tax_sup.php?orderid=" + orderid;
	window.open(url, "taxPub", "height=750, width=670, menubar=no, scrollbars=no, resizable=no, toolbar=no, status=no, left=50, top=50");
}

function tax_go(orderid){
	if(confirm("선택한 세금계산서를 발행하시겠습니까?")){
		document.location = "tax_t_go.php?orderid=" + orderid+"&<?=$param?>";
	}else{
		return;
	}
}
-->
</script>
<div id="location">HOME > 쇼핑몰관리</div>
<div id="S_contents">
<h3><?=$tax_title?><span><?=$tax_title?> 목록 입니다.</span></h3>

		<form name="frm" action="<?=$PHP_SELF?>" method="get">
		<input type="hidden" name="page" value="">
		<input type="hidden" name="status" value="<?=$status?>">
		<input type="hidden" name="tax_type" value="<?=$tax_type?>">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="table_basic">
		 <tr>
		   <th width="15%">진행상태</th>
		   <td width="85%">
		     <input style="width:70px;height:30px;cursor:pointer;" type="button" onClick="chgStatus('');" value=" 전체 " <? if($status == "") echo "class=btn_sm"; else echo "class=btn_m"; ?>>
		     <input style="width:70px;height:30px;cursor:pointer;" type="button" onClick="chgStatus('N');" value="발급대기" <? if($status == "N") echo "class=btn_sm"; else echo "class=btn_m"; ?>>
		     <input style="width:70px;height:30px;cursor:pointer;" type="button" onClick="chgStatus('Y');" value="발급완료" <? if($status == "Y") echo "class=btn_sm"; else echo "class=btn_m"; ?>>
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
		       <option value="orderid" <? if($searchopt == "orderid") echo "selected"; ?>>주문번호</option>
		       <option value="com_name" <? if($searchopt == "com_name") echo "selected"; ?>>상호</option>
		       <option value="com_owner" <? if($searchopt == "com_owner") echo "selected"; ?>>대표자</option>
		       <option value="com_address" <? if($searchopt == "com_address") echo "selected"; ?>>사업장소재지</option>
		       <option value="com_num" <? if($searchopt == "com_num") echo "selected"; ?>>사업자등록번호</option>
		       <option value="com_kind" <? if($searchopt == "com_kind") echo "selected"; ?>>업태</option>
		       <option value="com_class" <? if($searchopt == "com_class") echo "selected"; ?>>종목</option>
		       <option value="com_tel" <? if($searchopt == "com_tel") echo "selected"; ?>>전화번호</option>
		       <option value="com_email" <? if($searchopt == "com_email") echo "selected"; ?>>이메일</option>
		       </select>
		       <input type="text" name="searchkey" value="<?=$searchkey?>" class="input">
		       <button type="submit" style="height:22px" class="b h28 t5 color blue_big">검색</button>
		   </td>
		 </tr>
		</table>
		</form>

      <?
      if($tax_type != "") $tax_sql = " and tax_type='$tax_type' ";

    	$sql = "select orderid from wiz_tax where tax_date != '' $tax_sql";
    	$result = mysql_query($sql) or error(mysql_error());
      $all_total = mysql_num_rows($result);

      if($prev_year){
         $prev_period = $prev_year."-".$prev_month."-".$prev_day;
         $next_period = $next_year."-".$next_month."-".$next_day." 23:59:59";
         $period_sql = " and tax_date >= '$prev_period' and tax_date <= '$next_period'";
      }
      if($status == "") $status_sql = "and tax_pub != ''";
      else $status_sql = "and tax_pub = '$status'";

      if($searchopt && $searchkey) $searchopt_sql = " and $searchopt like '%$searchkey%'";

      $sql = "select * from wiz_tax where tax_date != '' $tax_sql $status_sql $period_sql $searchopt_sql order by tax_date desc,orderid desc";
      $result = mysql_query($sql) or error(mysql_error());
      $total = mysql_num_rows($result);

      $rows = 20;
      $lists = 5;
     	$page_count = ceil($total/$rows);
     	if($page < 1 || $page > $page_count) $page = 1;
     	$start = ($page-1)*$rows;
     	$no = $total-$start;
     	if($start>1) mysql_data_seek($result,$start);
      ?>
      <table width="100%" border="0" cellpadding="0" cellspacing="0" class="top10">
        <tr>
          <td>총 <?=$tax_title?>수 : <b><?=$all_total?></b> &nbsp; 검색 <?=$tax_title?>수 : <b><?=$total?></b></td>
          <td align="right">
	       	&nbsp; <font color="6DCFF6">■</font> 발급완료
	       	&nbsp; <font color="ED1C24">■</font> 발급대기
            <?if($tax_type=="T"){?>
			<button type="button" class="h22 t4 small icon gray" onClick="excelDown();"><span class="icon_exel"></span>엑셀파일저장</button>
            <?}?>
			<?if($tax_type=="C"){?>
			<?if(!strcmp($oper_info[pay_agent], "DACOM")) {?>
			<button type="button" class="h22 t4 small icon gray" onClick="dacomexcelDown();"><span class="icon_list"></span>LG uplus현금영수증 파일저장</button>
			<?}
			if(!strcmp($oper_info[pay_agent], "KCP")) {?>
			<button type="button" class="h22 t4 small icon gray" onClick="kcpexcelDown();"><span class="icon_list"></span>KCP현금영수증 파일저장</button>
			<?}?>
			<?}?>
		  </td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list top2 bbs_tax_list">
      	<form>
      	<thead>
        <tr>
          <td width="3%"><input type="checkbox" name="select_tmp" onClick="onSelect(this.form)"></td>
          <td width="10%">주문번호</td>
          <td>주문명</td>
          <td width="10%">발급요청</td>
          <td width="10%">발급완료</td>
          <td width="8%">공급가액</td>
          <td width="8%">세액</td>
          <td width="115">처리상태</td>
          <td width="12%">기능</td>
        </tr>
        </thead>
      	</form>
		<tbody>
		<?
		while(($row = mysql_fetch_object($result)) && $rows){

			if($row->tax_pub == "Y") $stacolor = "6DCFF6";
			else if($row->tax_pub == "N") $stacolor = "ED1C24";
			else $stacolor = "";

			$prd_name = "";

			$prd_info = explode("^^", $row->prd_info);
			$no = 0;
			for($ii = 0; $ii < count($prd_info); $ii++) {

				if(!empty($prd_info[$ii])) {
					$tmp_prd = explode("^", $prd_info[$ii]);
					if($ii < 1) $prd_name = cut_str($tmp_prd[0], 25);
					$no++;
				}
			}

			if($no > 1) {
				$prd_name .= " 외 ".($no-1)."건";
			}

		?>
	     <form action="order_save.php" name="<?=$row->orderid?>" method="get">
        <input type="hidden" name="mode" value="tax_status">
        <input type="hidden" name="page" value="<?=$page?>">
        <input type="hidden" name="orderid" value="<?=$row->orderid?>">
        <input type="hidden" name="tmp_tax_pub" value="<?=$row->tax_pub?>">
        <input type="hidden" name="status" value="<?=$status?>">
        <input type="hidden" name="prev_year" value="<?=$prev_year?>">
        <input type="hidden" name="prev_month" value="<?=$prev_month?>">
        <input type="hidden" name="prev_day" value="<?=$prev_day?>">
        <input type="hidden" name="next_year" value="<?=$next_year?>">
        <input type="hidden" name="next_month" value="<?=$next_month?>">
        <input type="hidden" name="next_day" value="<?=$next_day?>">
        <input type="hidden" name="searchopt" value="<?=$searchopt?>">
        <input type="hidden" name="searchkey" value="<?=$searchkey?>">
        <input type="hidden" name="tax_type" value="<?=$tax_type?>">

        <tr>
          <td><input type="checkbox" name="select_checkbox"></td>
          <td><a href="order_info.php?orderid=<?=$row->orderid?>&page=<?=$page?>&<?=$param?>"><?=$row->orderid?></a></td>
          <td style="text-align:left"> <?= $prd_name ?> </td>
          <td><?=$row->tax_date?></td>
          <td><?=$row->wdate?></td>
          <td><?=number_format($row->supp_price)?>원</td>
          <td><?=number_format($row->tax_price)?>원</td>
          <td bgcolor="<?=$stacolor?>">
	          <select name="tax_pub">
	          <option value="N" <? if($row->tax_pub == "N") echo "selected"; ?>>발급대기</option>
	          <option value="Y" <? if($row->tax_pub == "Y") echo "selected"; ?>>발급완료</option>
	          </select>
	          <!--<td><input type="image" src="../image/btn_apply_s.gif"><? if($tax_type=="T" && $oper_info[tax_api]=="Y"){  ?>&nbsp;<img src="../image/btn_apply_issue.gif" style="cursor:pointer" onclick="tax_go('<?=$row->orderid?>');";><?}?></td>-->
	        </td>
	        <td>
			<button type="submit" class="h18 t3 color small round red_s" > 적용</button>
	        	<button type="button" class="h18 t3 color small round black_s" onclick="viewTax('<?=$row->orderid?>');">보기</button>
	        	<!--img src="../image/btn_print_s.gif" style="cursor:pointer" align="absmiddle" onClick="printTax('<?=$row->orderid?>')"-->
          </td>
        </tr>

       	<tr id="ccontent_<?=$row->orderid?>" style="display:none">
          <td  colspan="10" style="padding:3px">
          	<? if($row->tax_type == "T") { ?>
			  		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="inner_table left">
			  			<tr>
			  				<td width="15%">사업자 번호</td><td width="35%"><?=$row->com_num?></td>
			  				<td width="15%">상 호</td><td><?=$row->com_name?></td>
			  			</tr>
			  			<tr>
			  				<td height="25">대표자</td><td width="30%"><?=$row->com_owner?></td>
			  				<td>사업장 소재지</td><td><?=$row->com_address?></td>
			  			</tr>
			  			<tr>
			  				<td height="25"> 업 태</td><td><?=$row->com_kind?></td>
			  				<td>종 목</td><td><?=$row->com_class?></td>
			  			</tr>
			  			<tr>
			  				<td height="25">전화번호</td><td><?=$row->com_tel?></td>
			  				<td>이메일</td><td><?=$row->com_email?></td>
			  			</tr>
						<tr>
			  				<td height="25">세금세산서번호</td><td><?=$row->tax_no?></td>
			  				<td> </td><td> </td>
			  			</tr>
			  		</table>
			  		<? } else if($row->tax_type == "C") { ?>
			  		<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="inner_table left">
			  			<tr>
			  				<th width="15%">발급사유</th><td width="35%"><?=get_cash_type_name($row->cash_type)?></td>
			  				<th width="15%">신청정보 </th><td width="35%"><?=get_cash_type2_name($row->cash_type2)?></td>
			  			</tr>
			  			<tr>
			  				<th>신청자명</th><td><?=$row->cash_name?></td>
			  				<th>신청정보 내용</th><td><?=$row->cash_info?></td>
			  			</tr>
			  		</table>
			  		<? } ?>
          </td>
        </tr>
        </form>
        <?
        		$no--;
            $rows--;
         }
       	if($total <= 0){
       	?>
       		<tr><td height=30 colspan=9 align=center>등록된 항목이 없습니다.</td></tr>

       	<?
       	}
        ?>
		</tbody>
      </table>

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
		 <tr>
		   <td width="33%">
				<button type="button" class="h22 t4 small icon gray" onClick="taxDelete();"><span class="icon_plus"></span>선택삭제</button>
				<button type="button" class="h22 t4 small icon gray" onClick="batchStatus();"><span class="icon_plus"></span>상태일괄변경</button>
		   </td>
		   <td width="33%"><? print_pagelist($page, $lists, $page_count, "&$param"); ?></td>
		   <td width="33%"></td>
		 </tr>
		</table>

<? if($tax_type=="T"){ ?>

<? } ?>
<? if($tax_type=="C"){ ?>
<div class="graybox top50">
	<p class="question">현금영수증 발행 방법</p>
    <div class="top10 font11 line2 colorgray">
- 유의사항<br />
<?if(!strcmp($oper_info[pay_agent], "DACOM")) {?>
			    &nbsp;&nbsp;LG유플러스 전용 입니다.(타 PG사 불가능) 무통장입금에 한해 현금영수증을 자동 발급하는 메뉴 입니다.<br />
			    &nbsp;&nbsp;관리자 -> 기본설정 -> 사업자정보에 사업자번호, 상호, 전화번호는 반드시 입력해주세요<br />
				&nbsp;&nbsp;국세청 현금영수증 사이트(<a href='http://www.taxsave.go.kr'>http://www.taxsave.go.kr</a>)에<br />
				&nbsp;&nbsp;등록된 정보가 아니면 발급이 되지 않습니다.<br />
				&nbsp;&nbsp;결제완료된 주문건에 한해 처리상태를 발급완료로 두신후 적용을 누르시면<br />
				&nbsp;&nbsp;자동으로 현금영수증이 발급됩니다.(미발급선택시 취소)<br />
				&nbsp;&nbsp;발급된 현금영수증은 주문배송조회에서 30분경과후 출력및 확인이 가능하며<br />
				&nbsp;&nbsp;또는 국세청 현금영수증 사이트에서 출력및 확인이 가능합니다.<br />

				&nbsp;&nbsp;발급시 신분정보확인오류가 출력되는 경우 유효한 핸드폰번호및, <br />
				&nbsp;&nbsp;사업자등록번호가 아니니 구매자에게 다시 확인 하시면 됩니다.<br />
<?}else if(!strcmp($oper_info[pay_agent], "KCP")){?>
				&nbsp;&nbsp;KCP 설명 입니다.(타 PG사 불가능) 무통장입금에 한해 현금영수증을 등록하는 메뉴 입니다.<br />
			    &nbsp;&nbsp;관리자 -> 기본설정 -> 사업자정보에 사업자번호, 상호, 전화번호는 반드시 입력해주세요<br />
				&nbsp;&nbsp;국세청 현금영수증 사이트(<a href='http://www.taxsave.go.kr'>http://www.taxsave.go.kr</a>)에<br />
				&nbsp;&nbsp;등록된 정보가 아니면 발급이 되지 않습니다.<br />
				&nbsp;&nbsp;결제완료된 주문건에 한해 pc현금영수증 파일저장을 다운받습니다.<br />
				&nbsp;&nbsp;https://admin8.kcp.co.kr에 접속 후 현금영수증 -> 현금영수증 작성 -> 대량등록(업로드)<br />
				&nbsp;&nbsp;KCP 등록은 발급일 기준 6일이내건만 등록이 가능합니다.<br />
				&nbsp;&nbsp;발급된 현금영수증은 주문배송조회에서 30분경과후 출력및 확인이 가능하며<br />
				&nbsp;&nbsp;또는 국세청 현금영수증 사이트에서 출력및 확인이 가능합니다.<br />

				&nbsp;&nbsp;발급시 신분정보확인오류가 출력되는 경우 유효한 핸드폰번호및, <br />
				&nbsp;&nbsp;사업자등록번호가 아니니 구매자에게 다시 확인 하시면 됩니다.<br />
<?}?>
    </div>
</div>
<? } ?>

<? include "../foot.php"; ?>
