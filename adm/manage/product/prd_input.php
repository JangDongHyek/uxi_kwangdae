<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include_once "../../inc/oper_info.php"; ?>
<? include_once "../../inc/prd_info.php"; ?>
<? include "../head.php"; ?>
<?

// 페이지 파라메터 (검색조건이 변하지 않도록)
//--------------------------------------------------------------------------------------------------
$param = "dep_code=$dep_code&dep2_code=$dep2_code&dep3_code=$dep3_code";
$param .= "&special=$special&display=$display&searchopt=$searchopt&searchkey=$searchkey&page=$page&shortpage=$shortpage";
//--------------------------------------------------------------------------------------------------

if($shortpage == "Y") $listpage_url = "prd_shortage.php";
else $listpage_url = "prd_list.php";

$imgpath = WIZHOME_PATH."/data/prdimg";

if(empty($mode)) $mode = "insert";

if($mode == "insert"){

	$catcode01 = $dep_code;
   $catcode02 = $dep_code.$dep2_code;
   $catcode03 = $dep_code.$dep2_code.$dep3_code;
   $prd_row->stock = "100";


// 상품정보를 가져온다.
}else if($mode == "update"){

   $sql = "select wp.*, wc.idx, wc.catcode from wiz_product wp, wiz_cprelation wc where wp.prdcode = '$prdcode' and wp.prdcode = wc.prdcode";
   $result = mysql_query($sql) or error(mysql_error());
   $prd_row = mysql_fetch_object($result);

   $relidx = $prd_row->idx;

   $catcode01 = substr($prd_row->catcode,0,3);
   $catcode02 = substr($prd_row->catcode,0,6);
   $catcode03 = substr($prd_row->catcode,0,9);

}

// 적립금 사용여부와 적용률을 가저온다.
$sql = "select reserve_use, reserve_buy from wiz_operinfo";
$result = mysql_query($sql) or error(mysql_error());
$row = mysql_fetch_object($result);
$reserve_use = $row->reserve_use;
$reserve_buy = $row->reserve_buy;

?>
<script language="JavaScript" type="text/javascript">
<!--
  var loding = false;
  var prd_class = new Array();
<?
   $no = 0;
   $sql = "select catcode, catname, depthno from wiz_category order by priorno01, priorno02, priorno03 asc";
   $result = mysql_query($sql) or error(mysql_error());
   $total = mysql_num_rows($result);
   while($row = mysql_fetch_object($result)){

      $code01 = substr($row->catcode,0,3);
      $code02 = substr($row->catcode,0,6);
      $code03 = substr($row->catcode,0,9);

      if($row->depthno == 1){ $catcode = $code01; $parent = 0; }
      if($row->depthno == 2){ $catcode = $code02; $parent = $code01; }
      if($row->depthno == 3){ $catcode = $code03; $parent = $code02; }
?>

  prd_class[<?=$no?>] = new Array();
  prd_class[<?=$no?>][0] = "<?=$catcode?>";
  prd_class[<?=$no?>][1] = "<?=$row->catname?>";
  prd_class[<?=$no?>][2] = "<?=$parent?>";
  prd_class[<?=$no?>][3] = "<?=$row->depthno?>";

<?
   	$no++;
   }
?>
var tno = <?=$total?>;

function setClass01(){

  var arrayClass = eval("document.frm.class01");
  var arrayClass1 = eval("document.frm.class02");
  var arrayClass2 = eval("document.frm.class03");

  arrayClass.options[0] = new Option(":: 대분류 ::","");
  arrayClass1.options[0] = new Option(":: 중분류 ::","");
  arrayClass2.options[0] = new Option(":: 소분류 ::","");

  for(no=0,sno=1 ; no < tno ; no++){
	  if(prd_class[no][3]=='1'){
		 arrayClass.options[sno] = new Option(prd_class[no][1],prd_class[no][0]);
		 sno++;
	  }
  }
}

function changeClass01(){

  var arrayClass = eval("document.frm.class01");
  var arrayClass1 = eval("document.frm.class02");
  var arrayClass2 = eval("document.frm.class03");

  var selidx = arrayClass.selectedIndex;
  var selvalue = arrayClass.options[selidx].value;

  arrayClass1.options.length=0;
  arrayClass2.options.length=0;
  arrayClass1.options[0] = new Option(":: 중분류 ::","");
  arrayClass2.options[0] = new Option(":: 소분류 ::","");

  for(no=0,sno=1 ; no < tno ; no++){
	  if(prd_class[no][3]=='2' && prd_class[no][2]==selvalue){
		 arrayClass1.options[sno] = new Option(prd_class[no][1],prd_class[no][0]);
		 sno++;
	  }
  }

}

function changeClass02(){

  var arrayClass1 = eval("document.frm.class02");
  var arrayClass2 = eval("document.frm.class03");

  var selidx = arrayClass1.selectedIndex;
  var selvalue = arrayClass1.options[selidx].value;

  arrayClass2.options.length=0;
  arrayClass2.options[0] = new Option(":: 소분류 ::","");

  for(no=0,sno=1 ; no < tno ; no++){
	  if(prd_class[no][3]=='3' && prd_class[no][2]==selvalue){
		 arrayClass2.options[sno] = new Option(prd_class[no][1],prd_class[no][0]);
		 sno++;
	  }
  }

}

function changeClass03(){
}

// 상품카테고리 설정
function setCategory(){

  var arrayClass01 = eval("document.frm.class01");
  var arrayClass02 = eval("document.frm.class02");
  var arrayClass03 = eval("document.frm.class03");

  for(no=1; no < arrayClass01.length; no++){
    if(arrayClass01.options[no].value == '<?=$catcode01?>'){
      arrayClass01.options[no].selected = true;
      changeClass01();
    }
  }

  for(no=1; no < arrayClass02.length; no++){
    if(arrayClass02.options[no].value == '<?=$catcode02?>'){
      arrayClass02.options[no].selected = true;
      changeClass02();
    }
  }

  for(no=1; no < arrayClass03.length; no++){
    if(arrayClass03.options[no].value == '<?=$catcode03?>')
      arrayClass03.options[no].selected = true;
  }

}

function inputCheck(frm){

   if(loding == false){
   	alert("상품정보를 가져오고 있습니다. 잠시후 재시도 하세요");
   	return false;
   }
	if(frm.prdname.value == ""){
		alert("상품명을 입력하세요");
		frm.prdname.focus();
		return false;
	}
	if(frm.sellprice.value == ""){
		alert("판매가를 입력하세요");
		frm.sellprice.focus();
		return false;
	}

	frm.select_subjects.value = SubjectToString("select");
	frm.supply_subjects.value = SubjectToString("supply");
	frm.select_table.value = JSON.stringify(JsonToTable("select"));
	frm.supply_table.value = JSON.stringify(JsonToTable("supply"));

	content.outputBodyHTML();
	content_m.outputBodyHTML();

/*
	var optvalue = "";
	var length = frm.optcode_tmp.length;
	for(ii = 0; ii < length; ii++){ optvalue += frm.optcode_tmp.options[ii].value+"^^"; }
	frm.optcode.value = optvalue;
*/
}

//해당 이미지를 삭제한다.
function deleteImage(prdcode, prdimg, imgpath){
	if(imgpath == ""){
		alert("삭제할 이미지가 없습니다.");
		return;
	}else{
	if(confirm("이미지를 삭제하시겠습니까?"))
		document.location = "prd_save.php?mode=delete_image&prdcode="+prdcode+"&prdimg="+prdimg+"&imgpath="+imgpath;
	}
	return;
}


function prdlayCheck(){
	<?
	if(@file($imgpath."/".$prd_row->prdimg_S2)) echo "document.frm.prdlay_check2.checked = true; prdlay2.style.display='';";
	if(@file($imgpath."/".$prd_row->prdimg_S3)) echo "document.frm.prdlay_check3.checked = true; prdlay3.style.display='';";
	if(@file($imgpath."/".$prd_row->prdimg_S4)) echo "document.frm.prdlay_check4.checked = true; prdlay4.style.display='';";
	if(@file($imgpath."/".$prd_row->prdimg_S5)) echo "document.frm.prdlay_check5.checked = true; prdlay5.style.display='';";
	?>
}

// 상품가격에 따른 적립금 적용 퍼센트에따라 적립금 적용
function setReserve(frm){

   if(frm.reserve != null){
   	var sellprice = frm.sellprice.value;
   	if(!check_Num(sellprice)){
			alert("판매가는 숫자이어야 합니다.");
			frm.sellprice.value = "";
			frm.sellprice.focus();
		}else{
	      var reserve = "" + sellprice*(<?=$reserve_buy?>/100)
	      reserve = reserve.split('.');
	      frm.reserve.value = reserve[0];
	   }
   }
}

function lodingComplete(){
	loding = true;
}

function prdCategory(){
  var url = "prd_catlist.php?prdcode=<?=$prdcode?>";
  window.open(url, "prdCategory", "height=330, width=600, menubar=no, scrollbars=yes, resizable=yes, toolbar=no, status=no, left=150, top=100");
}

function prdIcon(){
	var url = "prd_icon.php";
	window.open(url, "prdIcon", "height=250, width=450, menubar=no, scrollbars=yes, resizable=no, toolbar=no, status=no, left=150, top=100");
}

function setImgsize(){
	var url = "prd_imgsize.php";
   window.open(url, "setImgsize", "height=250, width=300, menubar=no, scrollbars=yes, resizable=no, toolbar=no, status=no, left=150, top=100");
}


// 상품별쿠폰 발급회원
function popMycoupon(prdcode){
	var url = "shop_mycoupon.php?prdcode=" + prdcode;
	window.open(url,"MyCouponList","height=400, width=600, menubar=no, scrollbars=yes, resizable=no, toolbar=no, status=no, top=100, left=100");
}



function prdFocus(){
frm.prdname.focus();
}

//reserve_percent 다른키입력막기
function func_reservekey(e){
	if (e.keyCode == 8){
		return;
	}
	else if(e.keyCode < 48 || (e.keyCode > 57 && e.keyCode < 96) || e.keyCode > 105 || e.shiftKey){
		return false;
	}
}
//reserve_percent 0~100 까지 입력유도
function setReserve_change(frm){
	if(100 < frm.reserve_percent.value){
		frm.reserve_percent.value = "100";
	}
	else if(frm.reserve_percent.value < 0){
		frm.reserve_percent.value = "0";
	}
}


//-->
</script>

<style>
.button { padding: 8px 12px; }
.button.blue  { color: #fff; background: #4999de; border: 1px solid #3384c9; }
.button.black { color: #fff; background: #333; border: 1px solid #222; }
</style>

 <div id="location">HOME > 상품관리</div>
<div id="S_contents">
<h3>상품등록<span>상품 상세정보를 설정합니다.</span></h3>

		<h4>기본정보</h4>
      <form name="frm" action="prd_save.php?<?=$param?>" method="post" onSubmit="return inputCheck(this)" enctype="multipart/form-data">
      <input type="hidden" name="tmp">
      <input type="hidden" name="mode" value="<?=$mode?>">
      <input type="hidden" name="prdcode" value="<?=$prdcode?>">
      <input type="hidden" name="relidx" value="<?=$relidx?>">
			<input type="hidden" name="select_subjects">
			<input type="hidden" name="supply_subjects">
			<input type="hidden" name="select_table">
			<input type="hidden" name="supply_table">

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th>상품분류</th>
                <td colspan="3">
                <select name="class01" onChange="changeClass01();">
                </select>
                <select name="class02" onChange="changeClass02();">
                </select>
                <select name="class03" onChange="changeClass03();">
                </select>&nbsp;
                <? if($mode == "update"){ ?>
					<button type="button" class="h18 t3 color small round black_s" onclick="prdCategory()">분류추가</button>
                <? } ?>
                </td>
              </tr>
              <tr>
                <th>상품그룹</th>
                <td colspan="3">
                  <input type="checkbox" name="new" value="Y" <? if($prd_row->new == "Y") echo "checked"; ?>> <img src="/adm/images/icon_new.gif" border="0"> &nbsp;
                  <input type="checkbox" name="best" value="Y" <? if($prd_row->best == "Y") echo "checked"; ?>> <img src="/adm/images/icon_best.gif" border="0"> &nbsp;
                  <input type="checkbox" name="popular" value="Y" <? if($prd_row->popular == "Y") echo "checked"; ?>> <img src="/adm/images/icon_hit.gif" border="0"> &nbsp;
                  <input type="checkbox" name="recom" value="Y" <? if($prd_row->recom == "Y") echo "checked"; ?>> <img src="/adm/images/icon_rec.gif" border="0"> &nbsp;
                  <input type="checkbox" name="sale" value="Y" <? if($prd_row->sale == "Y") echo "checked"; ?>> <img src="/adm/images/icon_sale.gif" border="0"> &nbsp;
                </td>
              </tr>
              <tr>
                <th>상품아이콘</th>
                <td colspan="3">
                	<table cellspacing=0 cellpadding=0><tr><td>
                	<table cellspacing=0 cellpadding=0>
                	<?
                	$prdicon= explode("/",$prd_row->prdicon);
                  for($ii=0; $ii<count($prdicon); $ii++){
                     $prdicon_list[$prdicon[$ii]] = true;
                  }

									$no = 0;

									// 업로드 디렉토리 생성
									if(!is_dir('../../data/prdicon')) mkdir('../../data/prdicon', 0707);

									if($handle = opendir('../../data/prdicon')){
										while(false !== ($file_name = readdir($handle))){
											if($file_name != "." && $file_name != ".."){
												if($no%7 == 0) echo "<tr>";
									?>
                  <td><input type="checkbox" name="prdicon[]" value="<?=$file_name?>" <? if($prdicon_list["$file_name"]==true) echo "checked";?>></td>
                  <td>&nbsp;<img src="/adm/data/prdicon/<?=$file_name?>" border="0"></td>
                  <?
												$no++;
											}
										}
										closedir($handle);
									}
									?>
                  </table></td>
                  <td>&nbsp;
					<button type="button" class="h22 t4 small icon gray" onClick="prdIcon()"><span class="icon_plus"></span>아이콘관리</button>
				  </td>
                  </tr>
                  </table>
                </td>
              </tr>
              <tr>
                <th>상품명 <font color="red">*</font></th>
                <td colspan="3">
                <input type="text" name="prdname" value="<?=$prd_row->prdname?>" size="60" class="input">
                </td>
              </tr>
              <!-- <tr>
                <th width="15%">제조사</th>
                <td width="35%">
                	<input name="prdcom" type="text" value="<?=$prd_row->prdcom?>" class="input">
                	<select onChange="this.form.prdcom.value = this.value">
                	<option value="">::선택::</option>
                	<?
                	$sql = "select distinct prdcom from wiz_product where prdcom != '' order by prdcom asc";
                	$result = mysql_query($sql);
                	while($row = mysql_fetch_object($result)){
                	?>
                	<option value="<?=$row->prdcom?>"><?=$row->prdcom?></option>
                	<?
                	}
                	?>
                	<select>
                </td>
                <th width="15%">원산지</th>
                <td width="35%">
                	<input name="origin" type="text" value="<?=$prd_row->origin?>" class="input">
                	<select onChange="this.form.origin.value = this.value">
                	<option value="">::선택::</option>
                	<?
                	$sql = "select distinct origin from wiz_product where origin != '' order by origin asc";
                	$result = mysql_query($sql);
                	while($row = mysql_fetch_object($result)){
                	?>
                	<option value="<?=$row->origin?>"><?=$row->origin?></option>
                	<?
                	}
                	?>
                	<select>
                </td>
              </tr> -->
              <tr>
                <!-- <th>브랜드</th>
                <td>
                	<select name="brand" style="width:130px">
                	<option value="">::선택::</option>
                	<?
                	$sql = "select idx, brdname from wiz_brand where brduse != 'N' order by priorno asc";
                	$result = mysql_query($sql);
                	while($row = mysql_fetch_object($result)){
                	?>
                	<option value="<?=$row->idx?>" <? if(!strcmp($row->idx, $prd_row->brand)) echo "selected" ?>><?=$row->brdname?></option>
                	<?
                	}
                	?>
                	<select>
                </td> -->
                <th>상품진열</th>
                <td>
                <input type="radio" name="showset" value="Y" <? if($prd_row->showset == "Y" || empty($prd_row->showset)) echo "checked"; ?>> 진열함&nbsp;
                <input type="radio" name="showset" value="N" <? if($prd_row->showset == "N") echo "checked"; ?>> 진열안함
                </td>
              </tr>
							<tr>
								<!-- mjs -->
								<!-- <th>공제분류</th>
								<td colspan="3">
									<input type="radio" name="deductset" value="normal" <? if($prd_row->deductset == "Y" || empty($prd_row->deductset)) echo "checked"; ?>> 일반상품&nbsp;
									                <input type="radio" name="deductset" value="culture" <? if($prd_row->deductset == "N") echo "checked"; ?>> 도서&문화상품
								</td> -->
							</tr>

              <input type="hidden" name="prior" value="<? if(empty($prd_row->prior)) echo date(ymdHis); else echo $prd_row->prior; ?>" maxlength="12" class="input">
              <!--tr>
                <td>우선순위</td>
                <td>
                <input type="text" name="prior" value="<? if(empty($prd_row->prior)) echo date(ymdHis); else echo $prd_row->prior; ?>" maxlength="12" class="input">
                </td>
                <td></td>
                <td>

                </td-->
                <!--td>선호도</td>
                <td>
                <select name="prefer">
                <option value="1" <? if($prd_row->prefer == "1") echo "selected"; ?>>별1
                <option value="2" <? if($prd_row->prefer == "2") echo "selected"; ?>>별2
                <option value="3" <? if($prd_row->prefer == "3" || $prd_row->prefer == "") echo "selected"; ?>>별3
                <option value="4" <? if($prd_row->prefer == "4") echo "selected"; ?>>별4
                <option value="5" <? if($prd_row->prefer == "5") echo "selected"; ?>>별5
                </select>
                </td//-->
              <!--/tr-->
            </table>
          </td>
        </tr>
      </table>
      <!--table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr><td height="2"></td></tr>
        <tr>
          <td width="17%"></td>
          <td>(숫자가 클수록 진열시 앞에 나옵니다. 최대 12자리) </td>
        </tr>
      </table-->

      <br>
			<!-- <h4>상품정보</h4>
			      <table width="100%" border="0" cellspacing="0" cellpadding="2" class="table_basic">
			  <tr>
			    <th width="15%">상품정보</th>
			    <td>
			          	<input type="radio" name="info_use" onClick="if(this.checked==true) addinfo.style.display='none';" value="N" <? if($prd_row->info_use == "" || $prd_row->info_use == "N") echo "checked"; ?>> 사용안함
			          	<input type="radio" name="info_use" onClick="if(this.checked==true) addinfo.style.display='';" value="Y" <? if($prd_row->info_use == "Y") echo "checked"; ?>> 사용함
			          </td>
			  </tr>
			</table> -->
      <div id="addinfo" style=display:<? if($prd_row->info_use == "" || $prd_row->info_use == "N") echo "none"; else echo "show"; ?>>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="15%">상품정보</td>
                <td width="85%">

                	<table border="1" cellspacing="5" cellpadding="0">
                		<tr>
                			<td></td>
                			<td>상품가격</td>
                			<td>1,000원 (예시)</td>
                		</tr>
                		<tr>
                			<td>1.</td>
                			<td><input name="info_name1" type="text" value="<?=$prd_row->info_name1?>" size="15" class="input"></td>
                			<td><input name="info_value1" type="text" value="<?=$prd_row->info_value1?>" size="20" class="input"></td>
                			<td width="60"></td>
                			<td>4.</td>
                			<td><input name="info_name4" type="text" value="<?=$prd_row->info_name4?>" size="15" class="input"></td>
                			<td><input name="info_value4" type="text" value="<?=$prd_row->info_value4?>" size="20" class="input"></td>
                		</tr>
                		<tr>
                			<td>2.</td>
                			<td><input name="info_name2" type="text" value="<?=$prd_row->info_name2?>" size="15" class="input"></td>
                			<td><input name="info_value2" type="text" value="<?=$prd_row->info_value2?>" size="20" class="input"></td>
                			<td></td>
                			<td>5.</td>
                			<td><input name="info_name5" type="text" value="<?=$prd_row->info_name5?>" size="15" class="input"></td>
                			<td><input name="info_value5" type="text" value="<?=$prd_row->info_value5?>" size="20" class="input"></td>
                		</tr>
                		<tr>
                			<td>3.</td>
                			<td><input name="info_name3" type="text" value="<?=$prd_row->info_name3?>" size="15" class="input"></td>
                			<td><input name="info_value3" type="text" value="<?=$prd_row->info_value3?>" size="20" class="input"></td>
                			<td></td>
                			<td>6.</td>
                			<td><input name="info_name6" type="text" value="<?=$prd_row->info_name6?>" size="15" class="input"></td>
                			<td><input name="info_value6" type="text" value="<?=$prd_row->info_value6?>" size="20" class="input"></td>
                		</tr>
                	</table>

                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <br>
      </div>

		<h4 class="top20">가격및재고</h4>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="15%">판매가 <font color="red">*</font></th>
                <td width="35%"><input name="sellprice" type="text" value="<?=$prd_row->sellprice?>" class="input" onchange="setReserve(this.form);"></td>
                <th width="15%">정가</th>
                <td width="35%"><input name="conprice" type="text" value="<?=$prd_row->conprice?>" class="input"><br>* <s>5,000</s>로 표기됨, 0 입력시 표기안됨 </td>
              </tr>
              <tr>
                <th style="display: none;">적립금<br><a href="shop_oper.php#res"><? if($reserve_use == "Y") echo "(판매가 ".$reserve_buy." %)"; ?></a></th>
                <td style="display: none;"><input name="reserve" type="text" value="<?=$prd_row->reserve?>" class="input"></td>
								<th style="display: none;">적립금(%)<br><a href="shop_oper.php#res"></a></th>
								<td style="display: none;"><input name="reserve_percent" type="text" onkeydown="return func_reservekey(event);" onchange="setReserve_change(this.form);" value="<?=$prd_row->reserve_percent?>" class="input"> %</td>
                <th>재고량</th>
                <td>
                	<input type="radio" name="shortage" value="Y" <? if($prd_row->shortage == "Y") echo "checked"; ?>>&nbsp;품절 &nbsp;
                	<input type="radio" name="shortage" value="N" <? if($prd_row->shortage == "N" || empty($prd_row->shortage)) echo "checked"; ?>>무제한
                	<input type="radio" name="shortage" value="S" <? if($prd_row->shortage == "S") echo "checked"; ?>>수량
                	<input name="stock" type="text" size="5" value="<?=$prd_row->stock?>" class="input">개<br>
                	수량을 지정하면 재고가 없을시 판매중지
                </td>
              </tr>
              <tr>
              	<th>판매가대체문구</th>
                <td colspan="3">
                	<input name="strprice" type="text" value="<?=$prd_row->strprice?>" class="input">
                	판매가대체문구를 입력하면 가격대신 입력한 문구가 보이며 구매가 불가능합니다.
                </td>
              </tr>
							<tr>
                <th width="15%">상품분실 및 파손</th>
                <td width="35%" colspan="3"><input name="delprice" type="text" value="<?=($mode == "update")?$prd_row->delprice:500000;?>" class="input">원</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>


      <h4 class="top20">배송비</h4>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="15%">배송비</th>
                <td width="85%">
                	<input type="radio" name="del_type" value="DA" <? if(!strcmp($prd_row->del_type, "DA") || empty($prd_row->del_type)) echo "checked" ?>> 기본 배송정책
                	<input type="radio" name="del_type" value="DB" <? if(!strcmp($prd_row->del_type, "DB")) echo "checked" ?>> 무료배송
                	<input type="radio" name="del_type" value="DC" <? if(!strcmp($prd_row->del_type, "DC")) echo "checked" ?>> 상품별 배송비
                	<input name="del_price" type="text" value="<?=$prd_row->del_price?>" class="input" size="10">원
                	<input type="radio" name="del_type" value="DD" <? if(!strcmp($prd_row->del_type, "DD")) echo "checked" ?>> 수신자부담(착불)
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

		<h4 class="top20">상품옵션</h4>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
			<tr>
				<th width="15%">상품옵션 사용</th>
				<td>
					<label><input type="radio" name="option_use" value="false" onchange="document.getElementById('prd_option').style.display='none';" <?=$prd_row->option_use?'':'checked'?>></input>사용안함</lable>
					<label style="margin-left: 16px;"><input type="radio" name="option_use" value="true"  onchange="document.getElementById('prd_option').style.display='table';" <?=$prd_row->option_use?'checked':''?>></input>사용</label>
				</td>
			</tr>
		</table>

    <table id="prd_option" width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic" style="display: <?=$prd_row->option_use?'table':'none'?>;">
			<tr style="display: none;">
				<th width="15%">선택옵션</th>
				<td>
					<div class="option_container">
						<span>옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다.<br>옷을 예로 들어 [옵션1 : 사이즈 , 옵션1 항목 : XXL,XL,L,M,S] , [옵션2 : 색상 , 옵션2 항목 : 빨,파,노]<br>옵션명과 옵션항목에 따옴표(', ")는 입력할 수 없습니다.</span>
						<div style="position: relative;">
							<div id="select_container"></div>
							<button type="button" onclick="addOption('select');" class="button black option_add">옵션추가</button>
						</div>
						<div style="text-align: center;">
							<button type="button" onclick="createTables('select');" class="button blue option_create">옵션목록생성</button>
						</div>
					</div>
					<div id="select_list">
						<table id="select_table" style="width: 100%" cellspacing="0" class="table_option">
							<tr>
								<th width="50%">옵션</th>
								<th width="13.3%">추가금액</th>
								<th width="13.3%">재고수량</th>
								<th width="13.3%">사용여부</th>
							</tr>
						</table>
					</div>
				</td>
			</tr>
			<tr>
				<th width="15%">추가옵션</th>
				<td>
					<div class="option_container">
						<span>옵션항목은 콤마(,) 로 구분하여 여러개를 입력할 수 있습니다.<br>스마트폰을 예로 들어 [추가1 : 추가구성상품 , 추가1 항목 : 액정보호필름,케이스,충전기]<br>옵션명과 옵션항목에 따옴표(', ")는 입력할 수 없습니다.</span>
						<div style="position: relative;">
							<div id="supply_container"></div>
							<button type="button" onclick="addOption('supply');" class="button black option_add">옵션추가</button>
						</div>
						<div style="text-align: center;">
							<button type="button" onclick="createTables('supply');" class="button blue option_create">옵션목록생성</button>
						</div>
					</div>

					<div id="supply_list">
						<table id="supply_table" style="width: 100%;" cellspacing="0" class="table_option">
							<tr>
								<th width="15%">옵션명</th>
								<th width="35%">옵션항목</th>
								<th width="13.3%">상품금액</th>
								<th width="13.3%">재고수량</th>
								<th width="13.3%">사용여부</th>
							</tr>
						</table>
					</div>
				</td>
			</tr>
    </table>

		<table width="100%" border="0" cellspacing="0" cellpadding="2" class="top20">
			<tr>
			<td width="15%"><h4>상품사진</h4></td>
			<td>
			<input type="checkbox" name="prdlay_check2" onClick="if(this.checked==true) prdlay2.style.display=''; else prdlay2.style.display='none';"><font color="red">이미지추가2</font>
			<input type="checkbox" name="prdlay_check3" onClick="if(this.checked==true) prdlay3.style.display=''; else prdlay3.style.display='none';"><font color="red">이미지추가3</font>
			<input type="checkbox" name="prdlay_check4" onClick="if(this.checked==true) prdlay4.style.display=''; else prdlay4.style.display='none';"><font color="red">이미지추가4</font>
			<input type="checkbox" name="prdlay_check5" onClick="if(this.checked==true) prdlay5.style.display=''; else prdlay5.style.display='none';"><font color="red">이미지추가5</font> &nbsp; &nbsp;
			<button style="border:0" type="button" class="h18 t3 color small round black_s" onClick="setImgsize();">이미지사이즈설정</button>
			</td>
			</tr>
		</table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="75%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="20%">원본 이미지</th>
                <td width="80%" colspan="3">
									<!-- <input type="file" name="realimg" class="input"> -->
									<div class="input-file">
										<input type="text" readonly="readonly" class="file-name" />
										<label class="file-label" for="file-realimg">파일 선택</label>
										<input id="file-realimg" class="file-upload" name="realimg" type="file" class="input" />
									</div>
									[GIF, JPG, PNG]<br>원본이미지를 등록하면 나머지 이미지가 자동생성 됩니다.
								</td>
              </tr>
              <tr>
                <th>
                  상품목록 이미지 <font color="red">*</font><br>
                  &nbsp;&nbsp;⇒ 크기 : <?=$oper_info[prdimg_R]?> x <?=$oper_info[prdimg_R]?></th>
                <td colspan="3">
                <!-- <input type="file" name="prdimg_R" class="input"> -->
								<div class="input-file">
									<input type="text" readonly="readonly" class="file-name" />
									<label class="file-label" for="file-prdimg_R">파일 선택</label>
									<input id="file-prdimg_R" class="file-upload" name="prdimg_R" type="file" class="input" />
								</div>

                <? if( @file($imgpath."/".$prd_row->prdimg_R) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_R?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_R?>" target="_blank" onMouseOver="document.prdimg1.src='../../data/prdimg/<?=$prd_row->prdimg_R?>';"><?=$prd_row->prdimg_R?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  축소이미지 이미지1<br>
                  &nbsp;&nbsp;⇒ 크기 : <?=$oper_info[prdimg_S]?> x <?=$oper_info[prdimg_S]?></th>
                <td colspan="3">
                <!-- <input type="file" name="prdimg_S1" class="input"> -->
								<div class="input-file">
									<input type="text" readonly="readonly" class="file-name" />
									<label class="file-label" for="file-prdimg_S1">파일 선택</label>
									<input id="file-prdimg_S1" class="file-upload" name="prdimg_S1" type="file" class="input" />
								</div>

                <? if( @file($imgpath."/".$prd_row->prdimg_S1) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_S1?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_S1?>" target="_blank" onMouseOver="document.prdimg1.src='../../data/prdimg/<?=$prd_row->prdimg_S1?>';"><?=$prd_row->prdimg_S1?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  제품상세 이미지1 <font color="red">*</font><br>
                  &nbsp;&nbsp;⇒ 크기 : <?=$oper_info[prdimg_M]?> x <?=$oper_info[prdimg_M]?></th>
                <td colspan="3">
                <!-- <input type="file" name="prdimg_M1" class="input"> -->
								<div class="input-file">
									<input type="text" readonly="readonly" class="file-name" />
									<label class="file-label" for="file-prdimg_M1">파일 선택</label>
									<input id="file-prdimg_M1" class="file-upload" name="prdimg_M1" type="file" class="input" />
								</div>

                <? if( @file($imgpath."/".$prd_row->prdimg_M1) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_M1?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_M1?>" target="_blank" onMouseOver="document.prdimg1.src='../../data/prdimg/<?=$prd_row->prdimg_M1?>';"><?=$prd_row->prdimg_M1?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  확대 이미지1 <font color="red">*</font><br>
                  &nbsp;&nbsp;⇒ 크기 : <?=$oper_info[prdimg_L]?> x <?=$oper_info[prdimg_L]?></th>
                <td colspan="3">
                <!-- <input type="file" name="prdimg_L1" class="input"> -->
								<div class="input-file">
									<input type="text" readonly="readonly" class="file-name" />
									<label class="file-label" for="file-prdimg_L1">파일 선택</label>
									<input id="file-prdimg_L1" class="file-upload" name="prdimg_L1" type="file" class="input" />
								</div>

                <? if( @file($imgpath."/".$prd_row->prdimg_L1) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_L1?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_L1?>" target="_blank" onMouseOver="document.prdimg1.src='../../data/prdimg/<?=$prd_row->prdimg_L1?>';"><?=$prd_row->prdimg_L1?></a>)
                <? } ?>

                </td>
              </tr>
            </table>
          </td>
          <td width="25%" height="100">
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <td align="center" bgcolor="#ffffff">
                <?
                if(@file($imgpath."/".$prd_row->prdimg_R))
                	echo "<img src='../../data/prdimg/$prd_row->prdimg_R' name='prdimg1' width='100'>";
                else
                	echo "No<br>Image";
					 			?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      <div id="prdlay2" style="display:none">
      <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="75%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="20%">원본 이미지</th>
                <td width="80%" colspan="3"><input type="file" name="realimg2" class="input"></td>
              </tr>
              <tr>
                <th>
                  축소 이미지2</th>
                <td colspan="3">
                <input type="file" name="prdimg_S2" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_S2) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_S2?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_S2?>" target="_blank" onMouseOver="document.prdimg2.src='../../data/prdimg/<?=$prd_row->prdimg_S2?>';"><?=$prd_row->prdimg_S2?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  상세 이미지2</th>
                <td colspan="3">
                <input type="file" name="prdimg_M2" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_M2) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_M2?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_M2?>" target="_blank" onMouseOver="document.prdimg2.src='../../data/prdimg/<?=$prd_row->prdimg_M2?>';"><?=$prd_row->prdimg_M2?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  확대 이미지2</th>
                <td colspan="3">
                <input type="file" name="prdimg_L2" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_L2) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_L2?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_L2?>" target="_blank" onMouseOver="document.prdimg2.src='../../data/prdimg/<?=$prd_row->prdimg_L2?>';"><?=$prd_row->prdimg_L2?></a>)
                <? } ?>

                </td>
              </tr>
            </table>
          </td>
          <td width="25%" height="100">
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <td align="center" bgcolor="#ffffff">
                <?
                if(@file($imgpath."/".$prd_row->prdimg_M2))
                	echo "<img src='../../data/prdimg/$prd_row->prdimg_M2' name='prdimg2' width='100'>";
                else
                	echo "No<br>Image";
					 ?>
					 </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      </div>
      <div id="prdlay3" style=display:none>
      <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="75%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="20%">원본 이미지</th>
                <td width="80%" colspan="3"><input type="file" name="realimg3" class="input"></td>
              </tr>
              <tr>
                <th>
                  축소 이미지3</th>
                <td colspan="3">
                <input type="file" name="prdimg_S3" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_S3) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_S3?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_S3?>" target="_blank" onMouseOver="document.prdimg3.src='../../data/prdimg/<?=$prd_row->prdimg_S3?>';"><?=$prd_row->prdimg_S3?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  상세 이미지3</th>
                <td colspan="3">
                <input type="file" name="prdimg_M3" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_M3) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_M3?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_M3?>" target="_blank" onMouseOver="document.prdimg3.src='../../data/prdimg/<?=$prd_row->prdimg_M3?>';"><?=$prd_row->prdimg_M3?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  확대 이미지3</th>
                <td colspan="3">
                <input type="file" name="prdimg_L3" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_L3) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_L3?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_L3?>" target="_blank" onMouseOver="document.prdimg3.src='../../data/prdimg/<?=$prd_row->prdimg_L3?>';"><?=$prd_row->prdimg_L3?></a>)
                <? } ?>

                </td>
              </tr>
            </table>
          </td>
          <td width="25%" height="100">
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <td align="center" bgcolor="#ffffff">
                <?
                if(@file($imgpath."/".$prd_row->prdimg_M3))
                	echo "<img src='../../data/prdimg/$prd_row->prdimg_M3' name='prdimg3' width='100'>";
                else
                	echo "No<br>Image";
					 ?>
					 </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      </div>
      <div id="prdlay4" style=display:none>
      <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="75%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="20%">원본 이미지</th>
                <td width="80%" colspan="3"><input type="file" name="realimg4" class="input"></td>
              </tr>
              <tr>
                <th>
                  축소 이미지4</th>
                <td colspan="3">
                <input type="file" name="prdimg_S4" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_S4) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_S4?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_S4?>" target="_blank" onMouseOver="document.prdimg4.src='../../data/prdimg/<?=$prd_row->prdimg_S4?>';"><?=$prd_row->prdimg_S4?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  상세 이미지4</th>
                <td colspan="3">
                <input type="file" name="prdimg_M4" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_M4) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_M4?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_M4?>" target="_blank" onMouseOver="document.prdimg4.src='../../data/prdimg/<?=$prd_row->prdimg_M4?>';"><?=$prd_row->prdimg_M4?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  확대 이미지4</th>
                <td colspan="3">
                <input type="file" name="prdimg_L4" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_L4) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_L4?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_L4?>" target="_blank" onMouseOver="document.prdimg4.src='../../data/prdimg/<?=$prd_row->prdimg_L4?>';"><?=$prd_row->prdimg_L4?></a>)
                <? } ?>

                </td>
              </tr>
            </table>
          </td>
          <td width="25%" height="100">
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <td align="center" bgcolor="#ffffff">
                <?
                if(@file($imgpath."/".$prd_row->prdimg_M4))
                	echo "<img src='../../data/prdimg/$prd_row->prdimg_M4' name='prdimg4' width='100'>";
                else
                	echo "No<br>Image";
					 ?>
					 </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      </div>
      <div id="prdlay5" style=display:none>
      <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="75%">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="20%">원본 이미지</th>
                <td width="80%" colspan="3"><input type="file" name="realimg5" class="input"></td>
              </tr>
              <tr>
                <th>
                  축소 이미지5</th>
                <td colspan="3">
                <input type="file" name="prdimg_S5" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_S5) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_S5?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_S5?>" target="_blank" onMouseOver="document.prdimg5.src='../../data/prdimg/<?=$prd_row->prdimg_S5?>';"><?=$prd_row->prdimg_S5?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  상세 이미지5</th>
                <td colspan="3">
                <input type="file" name="prdimg_M5" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_M5) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_M5?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_M5?>" target="_blank" onMouseOver="document.prdimg5.src='../../data/prdimg/<?=$prd_row->prdimg_M5?>';"><?=$prd_row->prdimg_M5?></a>)
                <? } ?>

                </td>
              </tr>
              <tr>
                <th>
                  확대 이미지5</th>
                <td colspan="3">
                <input type="file" name="prdimg_L5" class="input">

                <? if( @file($imgpath."/".$prd_row->prdimg_L5) ){ ?>
                <input type="checkbox" name="delimg[]" value="<?=$prd_row->prdimg_L5?>">삭제 (<a href="/adm/data/prdimg/<?=$prd_row->prdimg_L5?>" target="_blank" onMouseOver="document.prdimg5.src='../../data/prdimg/<?=$prd_row->prdimg_L5?>';"><?=$prd_row->prdimg_L5?></a>)
                <? } ?>

                </td>
              </tr>
            </table>
          </td>
          <td width="25%" height="100">
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <td align="center" bgcolor="#ffffff">
                <?
                if(@file($imgpath."/".$prd_row->prdimg_M5))
                	echo "<img src='../../data/prdimg/$prd_row->prdimg_M5' name='prdimg5' width='100'>";
                else
                	echo "No<br>Image";
					 ?>
					 </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
      </div>

    <?/* if(!strcmp($oper_info[prdrel_use], "Y")) { ?>
		<h4 class="top20">관련상품</h4>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="100%">
                <iframe width="100%" height="95" frameborder="0" src="prd_relation.php?mode=<?=$mode?>&prdcode=<?=$prdcode?>"></iframe>
                </th>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    	<? } */?>

		<h4 class="top20">상품설명</h4>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table_basic">
              <tr>
                <th width="15%">관리자주석</th>
                <td width="85%">
                <textarea name="stortexp" rows="3" cols="90" class="textarea"><?=$prd_row->stortexp?></textarea>
                </td>
              </tr>
              <tr>
                <th colspan="3" align="center">PC 상세설명</th>
              </tr>
              <tr>
                <td colspan="3">
                <?
                $edit_content = $prd_row->content;
                include "../../webedit/WIZEditor.html";
                ?>
                </td>
              </tr>
							<tr>
								<th colspan="3" align="center">모바일 상세설명</th>
							</tr>
							<tr>
								<td colspan="3">
								<?
								$edit_type = "mobile";
								$edit_content = $prd_row->content_m;
								include "../../webedit/WIZEditor.html";
								?>
								</td>
							</tr>
            </table>
          </td>
        </tr>
      </table>
      <table width="100%" height="10" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td></td>
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

<script>
window.addEventListener('load', function(){
	setClass01();setCategory();prdlayCheck();lodingComplete();prdFocus();
}, false);
</script>
<?
if($mode == "update"){
	$sql = "select * from wiz_product_option where prdcode='$prd_row->prdcode'";
	$result = mysql_query($sql) or error(mysql_error());
	while($row = mysql_fetch_object($result)){
		if($row->type == "select") $select = $row->table;
		if($row->type == "supply") $supply = $row->table;
	}
}
?>
<script>
// ************************** 옵션 *******************************


// 옵션 필드
var select_subjects = '<?=$prd_row->select_subjects?>';
var supply_subjects = '<?=$prd_row->supply_subjects?>';
var select_table = '<?=$select?>';
var supply_table = '<?=$supply?>';

window.addEventListener('load', function(){
	initOption();
}, false);

// 옵션 초기 설정
function initOption(){

	// json 스크립트를 테이블화 시켜준다.
	if(select_table == "") select_table = new Object();
	else select_table = JSON.parse(select_table);

	if(supply_table == "") supply_table = new Object();
	else supply_table = JSON.parse(supply_table);

	initSelectSubject();
	initSupplySubject();

	// 데이터베이스에 저장된 옵션이 있으면 테이블을 보여주고, 없으면 테이블을 보여주지 않음
	if(0 < Object.keys(select_table).length) createTables("select");
	else document.getElementById("select_list").style.display = "none";

	if(0 < Object.keys(supply_table).length) createTables("supply");
	else document.getElementById("supply_list").style.display = "none";
}

function initSelectSubject(){

	// 데이터베이스에 저장되어있던 옵션 명을 잘라서 배열에 저장
	var subjects = select_subjects.split(",");

	// 배열 수 만큼 반복
	for(var i=0;i<subjects.length; i++){

		// 선택옵션 영역에 줄 추가
		addOption("select");

		// 선택옵션 명 입력
		if(0 < i) frm.elements["select_subject[]"][i].value = subjects[i];
		else frm.elements["select_subject[]"].value = subjects[i];

		// 선택옵션 값을 선택옵션 테이블에서 구해온다
		var values = new Object();
		getValues(select_table, i, values);

		// 선택옵션 값 입력
		for(var key in values){
			if(0 < i) frm.elements["select_values[]"][i].value += ((frm.elements["select_values[]"][i].value == "")?"":",") + key;
			else frm.elements["select_values[]"].value += ((frm.elements["select_values[]"].value == "")?"":",") + key;
		}
	}
}

function initSupplySubject(){

	// 데이터베이스에 저장되어있던 추가옵션 명을 잘라서 배열에 저장
	var subjects = supply_subjects.split(",");

	// 배열 수 만큼 반복
	for(var i=0;i<subjects.length; i++){

		// 추가옵션 영역에 줄 추가
		addOption("supply");

		// 추가옵션 명 입력
		if(0 < i) frm.elements["supply_subject[]"][i].value = subjects[i];
		else frm.elements["supply_subject[]"].value = subjects[i];

		// 추가옵션 값을 추가옵션 테이블로부터 구해온다.
		var values = new Object();
		var cnt = 0;
		for(var key in supply_table){
			if(cnt == i){
				getValues(supply_table[key], 0, values);
				break;
			}
			cnt++;
		}

		// 추가옵션 값 입력
		for(var key in values){
			if(0 < i) frm.elements["supply_values[]"][i].value += ((frm.elements["supply_values[]"][i].value == "")?"":",") + key;
			else frm.elements["supply_values[]"].value += ((frm.elements["supply_values[]"].value == "")?"":",") + key;
		}
	}
}

function getValues(json, depth, values){
	if(depth != 0){
		for(var key in json){
			getValues(json[key], depth-1, values);
		}
	}
	else{
		for(var key in json){
			if(!values.hasOwnProperty(key)) values[key] = new Object();
		}
	}
}

// 옵션추가 기능
function addOption(id){
	var container = document.getElementById(id+"_container");

	var item = document.createElement("div");

	var label1 = document.createElement("label");
	label1.innerHTML = ((id == "select")?"선택":"추가") + (container.children.length + 1);

	var subject = document.createElement("input");
	subject.className = "input";
	subject.name = id + "_subject[]";
	subject.onkeydown = function(e){ console.log(e); if(e.keyCode == 13)  return false; };

	var label2 = document.createElement("label");
	label2.innerHTML = ((id == "select")?"선택":"추가") + (container.children.length + 1) + " 항목";
	label2.style.marginLeft = "24px";

	var values = document.createElement("input");
	values.className = "input";
	values.size = "30";
	values.name = id + "_values[]";
	values.onkeydown = function(e){ console.log(e); if(e.keyCode == 13)  return false; };

	var btn = document.createElement("button");
	btn.innerHTML = "삭제";
	btn.className = "button black option_delete";
	btn.addEventListener("click", function(){ deleteOption(item); }, false);

	item.appendChild(label1);
	item.appendChild(subject);
	item.appendChild(label2);
	item.appendChild(values);
	if(0 < container.children.length) item.appendChild(btn);

	container.appendChild(item);
}

// 옵션 삭제 기능
function deleteOption(item){
	var container = item.parentElement;
	container.removeChild(item);
}

// 옵션 데이블 생성
function createTables(id){
	var ids = id + "_values[]";

	var container = document.getElementById(id+"_list");
	var frm = document.frm;

	// JSON 형태의 옵션 테이블을 생성할 변수
	var json = new Object();

	// 옵션 줄이 배열인 경우
	if(frm.elements[ids].length){

		// 옵션 줄 만큼 반복
		for(var i=0; i<frm.elements[ids].length; i++){

			// 옵션 값이 빈값이면 다음줄로 넘어감
			if(frm.elements[ids][i].value.trim() == "") continue;

			// 옵션 값이 있는 경우
			// 옵션 값을 배열 형태로 다른다
			var values = frm.elements[ids][i].value.split(",");

			// 옵션 값을 JSON에 넣는다.
			switch(id){
				case "select":
					addjson(json, values, i, (i+1 == frm.elements[ids].length) ? true : false);
					break;
				case "supply": // 추가옵션의 경우, 옵션명이 먼저 들어가고, 옵션값이 들어가는 구조

					// 옵션명
					var subject = frm.elements[id+"_subject[]"][i].value;

					// 옵션 명이 없으면 생성하지 않는다.
					if(subject.trim() == "") break;

					json[subject] = new Object();
					addjson(json[frm.elements[id+"_subject[]"][i].value], values, 0, true);
					break;
			}
		}
	}
	// 옵션줄이 한줄인 경우
	else{

		// 옵션 값을 배열 형태로 자른다.
		var values = frm.elements[ids].value.split(",");

		// 옵션 값을 JSON에 넣는다.
		switch(id){
			case "select":
				addjson(json, values, 0, true);
				break;
			case "supply": // 추가옵션의 경우, 옵션명이 먼저 들어가고, 옵션값이 들어가는 구조

				// 옵션명
				var subject = frm.elements[id+"_subject[]"].value;

				// 옵션 제목값이 없는경우 생성 X
				if(subject.trim() == "") break;

				json[subject] = new Object();
				addjson(json[frm.elements[id+"_subject[]"].value], values, 0, true);
				break;
		}
	}

	// 새로 생성된 테이블과 기존 테이블을 비교하여 테이블 정보를 셋팅한다.
	comparejson(json, (id == "select") ? select_table : supply_table);

	// 생성된 테이블의 UI를 생성
	loadTable(json, id);
}

// JSON 형태로 옵션 생성
function addjson(obj, values, depth, isEnd){
	if(depth != 0){
		for(var key in obj){
			if(!obj[key].hasOwnProperty("price")) addjson(obj[key], values, depth-1, isEnd);
		}
	}
	else{
		for(var i=0; i<values.length; i++){
			obj[values[i]] = new Object();
			if(isEnd){
				obj[values[i]].stock  = 9999;
				obj[values[i]].price  = 0;
				obj[values[i]].usable = true;
			}
		}
	}
}
// 새로 생성된 옵션 데이블과, 저장된 옵션 테이블을 비교해서 일치하면 변경
function comparejson(org, dst){
	for(var key in org){
		if(dst.hasOwnProperty(key)){
			if(org[key].constructor === {}.constructor && dst[key].constructor === {}.constructor){
				comparejson(org[key], dst[key]);
			}
			else if(
				org[key].constructor !== {}.constructor
				&& org[key].constructor !== [].constructor
				&& dst[key].constructor !== {}.constructor
				&& dst[key].constructor !== [].constructor
			){
				org[key] = dst[key];
			}
		}
	}
}
// 옵션 테이블 UI 생성
function loadTable(json, id){

	var list = document.getElementById(id + "_list");
	var table = document.getElementById(id + "_table");

	while(1<table.children.length){
		table.removeChild(table.children[table.children.length-1]);
	}

	switch(id){
		case "select":
			additem(table, json,"",null);
			break;
		case "supply":
			for(var subject in json){
				additem(table, json[subject], "", subject);
			}
			break;
	}
	list.style.display = "block";
}
// 옵션목록 아이템 생성
function additem(table, obj, str, subject){
	if(obj.hasOwnProperty("price")){
		var item = document.createElement("tr");
		var td, input, select, option;

		// 추가옵션 명칭
		if(subject){
			td = document.createElement("td"); td.innerHTML = subject;
			input = document.createElement("input");
			input.type = "hidden";
			input.name = table.id.split("_")[0] + "_header[]";
			input.value = subject;
			item.appendChild(input);
			item.appendChild(td);
		}

		// 옵션 명칭
		td = document.createElement("td"); td.innerHTML = str;
		input = document.createElement("input");
		input.type = "hidden";
		input.name = table.id.split("_")[0] + "_items[]";
		input.value = str;
		item.appendChild(input);
		item.appendChild(td);

		// 상품가격
		td = document.createElement("td");
		input = document.createElement("input");
		input.type = "number";
		input.value = obj.price;
		input.className = "input";
		input.name = table.id.split("_")[0] + "_price[]";
		input.style.width = "100%";
		td.appendChild(input);
		item.appendChild(td);

		// 재고수량
		td = document.createElement("td");
		input = document.createElement("input");
		input.type = "number";
		input.value = obj.stock;
		input.className = "input";
		input.name = table.id.split("_")[0] + "_stock[]";
		input.style.width = "100%";
		td.appendChild(input);
		item.appendChild(td);

		// 사용여부
		td = document.createElement("td");
		select = document.createElement("select");
		select.name = table.id.split("_")[0] + "_usable[]";
		select.style.width = "100%";

		option = document.createElement("option");
		option.value = true;
		option.innerHTML = "사용";
		option.selected = (obj.usable == true || obj.usable == 'true')?true:false;
		select.appendChild(option);

		option = document.createElement("option");
		option.value = false;
		option.innerHTML = "사용안함";
		option.selected = (obj.usable == false || obj.usable == 'false')?true:false;
		select.appendChild(option);

		td.appendChild(select);
		item.appendChild(td);

		// 테이블에 리스트 생성
		table.appendChild(item);
	}
	else{
		if(str != "") str += " > ";
		for(var key in obj){
			additem(table, obj[key], str + key, subject);
		}
	}
}
function JsonToTable(id){
	var table = document.getElementById(id + "_table");
	var frm = document.frm;
	var json = new Object();

	json = new Object();

	for(var i=0; i<table.children.length - 1; i++){

		var items;
		if ( 2 < table.children.length ) items = frm.elements[id+"_items[]"][i].value;
		else items = frm.elements[id+"_items[]"].value;

		if(items.trim() == "") continue;
		items = items.split(" > ");

		var price;
		if ( 2 < table.children.length ) price = frm.elements[id+"_price[]"][i].value;
		else price = frm.elements[id+"_price[]"].value;

		var stock;
		if ( 2 < table.children.length ) stock = frm.elements[id+"_stock[]"][i].value;
		else stock = frm.elements[id+"_stock[]"].value;

		var usable;
		if ( 2 < table.children.length ) usable = frm.elements[id+"_usable[]"][i].value;
		else usable = frm.elements[id+"_usable[]"].value;

		var option = json;

		if( id == "supply"){
			var header;
			if ( 2< table.children.length ) header = frm.elements[id+"_header[]"][i].value;
			else header = frm.elements[id+"_header[]"].value;
			if(!option.hasOwnProperty(header)) option[header] = new Object();
			option = option[header];
		}

		var depth = 0;
		do{
			if(depth == items.length){
				option.price = price;
				option.stock = stock;
				option.usable = usable;
			}
			else{
				if(!option.hasOwnProperty(items[depth])) option[items[depth]] = new Object();
				option = option[items[depth]];
			}
		} while(depth++ != items.length);

	}
	return json;
}
function SubjectToString(id){
	var frm = document.frm;
	var subject = "";

	if(frm.elements[id+"_subject[]"].length){
		for(var i=0; i<frm.elements[id+"_subject[]"].length; i++){
			if(i != 0) subject += ",";
			subject += frm.elements[id+"_subject[]"][i].value;
		}
	}
	else{
		subject = frm.elements[id+"_subject[]"].value;
	}
	return subject;
}
function OptionToString(id){
	var frm = document.frm;
	var option = "";

	if(frm.elements[id+"[]"].length){
		for(var i=0; i<frm.elements[id+"[]"].length; i++){
			if(i != 0) option += ",";
			option += frm.elements[id+"[]"][i].value;
		}
	}
	else{
		option = frm.elements[id+"[]"].value;
	}
	return option;
}
</script>


<? include "../foot.php"; ?>
