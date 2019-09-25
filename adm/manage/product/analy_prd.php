<? include_once "../../common.php"; ?>
<? include_once "../../inc/admin_check.php"; ?>
<? include_once "../../inc/site_info.php"; ?>
<? include "../head.php"; ?>
<?
$param = "group=$group&searchopt=$searchopt&keyword=$keyword&dep_code=$dep_code&dep2_code=$dep2_code&dep3_code=$dep3_code";
?>

<div id="location">HOME > 쇼핑몰관리</div>
<div id="S_contents">
<h3>상품통계분석<span>상품의 상세 통계분석</span></h3>

		<form name="frm" action="<?=$PHP_SELF?>" method="get">
		<table width="100%" cellspacing="0" cellpadding="0" border="0" class="table_basic">
			<tr>
				<th>&nbsp;&nbsp;상품분류</th>
				<td colspan="3">
					<select name="dep_code" onChange="this.form.submit();" class="select">
						<option value=''>:: 대분류 ::</option>
						<?
						$sql = "select substring(catcode,1,3) as catcode, catname from wiz_category where depthno = 1";
						$result = mysql_query($sql) or error(mysql_error());
						while($row = mysql_fetch_object($result)){
							if($row->catcode == $dep_code) echo "<option value='$row->catcode' selected>$row->catname";
							else echo "<option value='$row->catcode'>$row->catname</option>";
						}
						?>
					</select>
					<select name="dep2_code" onChange="this.form.submit();" class="select">
						<option value=''>:: 중분류 ::</option>
						<?
						if($dep_code != ''){
							$sql = "select substring(catcode,4,3) as catcode, catname from wiz_category where depthno = 2 and catcode like '$dep_code%'";
							$result = mysql_query($sql) or error(mysql_error());
							while($row = mysql_fetch_object($result)){
								if($row->catcode == $dep2_code) echo "<option value='$row->catcode' selected>$row->catname";
								else echo "<option value='$row->catcode'>$row->catname</option>";
							}
						}
						?>
					</select>
					<select name="dep3_code" onChange="this.form.submit();" class="select">
						<option value=''>:: 소분류 ::
						<?
						if($dep_code != '' && $dep2_code != ''){
							$sql = "select substring(catcode,7,3) as catcode, catname from wiz_category where depthno = 3 and catcode like '$dep_code$dep2_code%'";
							$result = mysql_query($sql) or error(mysql_error());
							while($row = mysql_fetch_object($result)){
								if($row->catcode == $dep3_code) echo "<option value='$row->catcode' selected>$row->catname";
								else echo "<option value='$row->catcode'>$row->catname";
							}
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th width="15%">&nbsp; 상품그룹</th>
				<td width="25%">
					<select name="group">
						<option value="">:: 분류선택 ::</option>
						<option value="new" <? if($group == "new") echo "selected"; ?>>신상품</option>
						<option value="popular" <? if($group == "popular") echo "selected"; ?>>인기상품</option>
						<option value="recom" <? if($group == "recom") echo "selected"; ?>>추천상품</option>
						<option value="sale" <? if($group == "sale") echo "selected"; ?>>세일상품</option>
						<option value="stock" <? if($group == "stock") echo "selected"; ?>>품절상품</option>

						<option value="sell" <? if($group == "sell") echo "selected"; ?>>최다판매</option>
						<option value="revenue" <? if($group == "revenue") echo "selected"; ?>>최대매출</option>
					</select>
				</td>
				<th width="15%">&nbsp; 조건</th>
				<td width="45%">
					<select name="searchopt">
						<option value="">:: 조건선택 ::</option>
						<option value="prdname" <? if($searchopt == "prdname") echo "selected"; ?>>상품명</option>
						<option value="prdcode" <? if($searchopt == "prdcode") echo "selected"; ?>>상품코드</option>
					</select>
					<input type="text" name="keyword" value="<?=$keyword?>" class="input">
					<button type="submit" style="height:22px" class="b h28 t5 color blue_big">검색</button>
				</td>
			</tr>
		</table>
		</form>

		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr><td height="10"></td></tr>
		</table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="bbs_basic_list bbs_analy_list">
      <thead>
      <tr>
        <td width="7%">No</td>
        <td width="10%"></td>
        <td>상품명</td>
        <?
        $view_orderby = "desc";
        $deimg_orderby = "desc";
        $basket_orderby = "desc";
        $order_orderby = "desc";
        $cancel_orderby = "desc";
        $com_orderby = "desc";
		$revenue_orderby = "desc";

        if($orderkey == "viewcnt"){
        	if($orderby == "asc" || $orderby == "") $view_orderby = "desc";
        	else $view_orderby = "asc";
        }else if($orderkey == "deimgcnt"){
        	if($orderby == "asc" || $orderby == "") $deimg_orderby = "desc";
        	else $deimg_orderby = "asc";
        }else if($orderkey == "basketcnt"){
        	if($orderby == "asc" || $orderby == "") $basket_orderby = "desc";
        	else $basket_orderby = "asc";
        }else if($orderkey == "ordercnt"){
        	if($orderby == "asc" || $orderby == "") $order_orderby = "desc";
        	else $order_orderby = "asc";
        }else if($orderkey == "cancelcnt"){
        	if($orderby == "asc" || $orderby == "") $cancel_orderby = "desc";
        	else $cancel_orderby = "asc";
        }else if($orderkey == "comcnt"){
        	if($orderby == "asc" || $orderby == "") $com_orderby = "desc";
        	else $com_orderby = "asc";
        }else if($orderkey == "revenue"){
			$orderkey = "( (ordercnt + comcnt) * sellprice)";
        	if($orderby == "asc" || $orderby == "") $revenue_orderby = "desc";
        	else $revenue_orderby = "asc";
        }
        ?>
		<td width="9%"><a href="<?=$PHP_SELF?>?orderkey=revenue&orderby=<?=$revenue_orderby?>&<?=$param?>"><font color="#184390"><? if($revenue_orderby == "desc") echo "▲"; else echo "▼"; ?> 총매출액</font></a></td>
        <td width="9%"><a href="<?=$PHP_SELF?>?orderkey=viewcnt&orderby=<?=$view_orderby?>&<?=$param?>"><font color="#184390"><? if($view_orderby == "desc") echo "▲"; else echo "▼"; ?> 상세보기</font></a></td>
        <td width="9%"><a href="<?=$PHP_SELF?>?orderkey=deimgcnt&orderby=<?=$deimg_orderby?>&<?=$param?>"><font color="#184390"><? if($deimg_orderby == "desc") echo "▲"; else echo "▼"; ?> 상세이미지</font></a></td>
        <td width="9%"><a href="<?=$PHP_SELF?>?orderkey=basketcnt&orderby=<?=$basket_orderby?>&<?=$param?>"><font color="#184390"><? if($basket_orderby == "desc") echo "▲"; else echo "▼"; ?> 장바구니</font></a></td>
        <td width="9%"><a href="<?=$PHP_SELF?>?orderkey=ordercnt&orderby=<?=$order_orderby?>&<?=$param?>"><font color="#184390"><? if($order_orderby == "desc") echo "▲"; else echo "▼"; ?> 주문수</font></a></td>
        <td width="9%"><a href="<?=$PHP_SELF?>?orderkey=cancelcnt&orderby=<?=$cancel_orderby?>&<?=$param?>"><font color="#184390"><? if($cancel_orderby == "desc") echo "▲"; else echo "▼"; ?> 주문취소</font></a></td>
        <td width="9%"><a href="<?=$PHP_SELF?>?orderkey=comcnt&orderby=<?=$com_orderby?>&<?=$param?>"><font color="#184390"><? if($com_orderby == "desc") echo "▲"; else echo "▼"; ?> 배송완료</font></a></td>
      </tr>
      </thead>
      <?
			// 상품그룹
			if(!empty($group)) $group_sql = " and wp.$group = 'Y' ";

			// 조건검색
			if(!empty($searchopt)) $searchopt_sql = " and wp.$searchopt like '%$keyword%' ";

			// 상품분류
			if(!empty($dep_code)) $searchopt_sql .= " and wc.catcode like '$dep_code$dep2_code$dep3_code%' ";

			// 정렬순서
			if(!empty($orderkey) && !empty($orderby)) $order_sql = " order by $orderkey $orderby, wp.prior desc";
			else $order_sql = " order by wp.prior desc";

			$sql = "select prdcode from wiz_product wp where prdcode != '' $group_sql $searchopt_sql $order_sql";

			$sql = "select distinct(wp.prdcode), wp.prdname, wp.prdimg_R, wp.viewcnt, wp.deimgcnt, wp.basketcnt, wp.ordercnt, wp.cancelcnt, wp.comcnt, wp.sellprice, wc.purl
							from wiz_product as wp left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode
							left join wiz_category as wc on wcp.catcode = wc.catcode
							where wp.prdcode != '' $group_sql $searchopt_sql $order_sql";

			if ($group == "sell") {
				$sql = "select * from wiz_product order by (ordercnt + comcnt) desc";
			} elseif ($group == "revenue") {
				$sql = "select * from wiz_product order by ( (ordercnt + comcnt) * sellprice) desc";
			}

			$result = mysql_query($sql) or error(mysql_error());
			$total = mysql_num_rows($result);

			$rows = 12;
			$lists = 5;
			if(!$page) $page = 1;
			$page_count = ceil($total/$rows);
			$start = ($page-1)*$rows;
			$no = $total-$start;

			$sql = "select distinct(wp.prdcode), wp.prdname, wp.prdimg_R, wp.viewcnt, wp.deimgcnt, wp.basketcnt, wp.ordercnt, wp.cancelcnt, wp.comcnt,wp.sellprice, wc.purl
							from wiz_product as wp left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode
							left join wiz_category as wc on wcp.catcode = wc.catcode
							where wp.prdcode != '' $group_sql $searchopt_sql $order_sql limit $start, $rows";

			if ($group == "sell") {
				$sql = "select * from wiz_product order by (ordercnt + comcnt) desc limit $start, $rows";
			} elseif ($group == "revenue") {
				$sql = "select * from wiz_product order by ( (ordercnt + comcnt) * sellprice) desc limit $start, $rows";
			}

			$result = mysql_query($sql) or error(mysql_error());

			while(($row = mysql_fetch_object($result)) && $rows){
				if($row->prdimg_R == "") $row->prdimg_R = "/adm/images/noimage.gif";
				else $row->prdimg_R = "/adm/data/prdimg/$row->prdimg_R";

			?>
			<tr>
			  <td align="center" height="28"><?=$no?></td>
			  <td>&nbsp; <a href="/<?=$row->purl?>?ptype=view&prdcode=<?=$row->prdcode?>" target="_blank"><img src="<?=$row->prdimg_R?>" width="50" height="50" border="0" align="absmiddle"></a></td>
			  <td><a href="/<?=$row->purl?>?ptype=view&prdcode=<?=$row->prdcode?>" target="_blank"><?=$row->prdname?></a></td>
			  <td><?
			  $result_reveneu = ( ($row->ordercnt + $row->comcnt) * $row->sellprice);
			  echo number_format($result_reveneu);
			  ?></td>
			  <td align="center"><?=$row->viewcnt?></td>
			  <td align="center"><?=$row->deimgcnt?></td>
			  <td align="center"><?=$row->basketcnt?></td>
			  <td align="center"><?=$row->ordercnt?></td>
			  <td align="center"><?=$row->cancelcnt?></td>
			  <td align="center"><?=$row->comcnt?></td>
			</tr>

			<?
			  $no--;
			  $rows--;
			}
			?>
	   </table>

		<div class="center">
			<? print_pagelist($page, $lists, $page_count, "&orderkey=$orderkey&orderby=$orderby&$param"); ?></td>
		</div>

<? include "../foot.php"; ?>
