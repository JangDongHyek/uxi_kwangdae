<?php
include_once "$_SERVER[DOCUMENT_ROOT]/adm/common.php";
include "$_SERVER[DOCUMENT_ROOT]/adm/inc/site_info.php";

echo "<script Language=\"JavaScript\" src=\"/adm/js/lib.js\"></script>";
echo "<link href=\"".$skin_dir."/style.css\" rel=\"stylesheet\" type=\"text/css\">";


// 스킨위치

$skin_dir = "/adm/search/skin/".$site_info[search_skin];



$total_searchkey = trim($total_searchkey);



$search_bg = "#fffc00";			// 검색어 배경

$search_color = "#000";		// 검색어 색상



$bbs_rows = "10";							// 게시판검색 페이지출력수

$bbs_lists = "5";								// 게시판검색 리스트출력수



$prd_rows = "10";							// 상품검색 페이지출력수

$prd_lists = "5";								// 상품검색 리스트출력수



$page_rows = "10";						// 페이지검색 페이지출력수

$page_lists = "5";							// 페이지검색 리스트출력수



$param = "total_searchkey=".$total_searchkey;



// 게시판

if(!strcmp($stype, "bbs")) {



	if(!empty($prd_page)) $param .= "&prd_page=".$prd_page;

	if(!empty($page_page)) $param .= "&page_page=".$page_page;



	// 제목, 내용

	if(empty($total_searchkey)) $search_sql = " wb.idx = '' ";

	else $search_sql = " (wb.subject like '%$total_searchkey%' or wb.content like '%$total_searchkey%') ";



	$sql = "select count(idx) as cnt from wiz_bbs as wb where $search_sql order by prino desc";

	$result = mysql_query($sql) or error(mysql_error());

	$row = mysql_fetch_array($result);

	$total = $row[cnt];



	$idx = 0;

	$rows = $bbs_rows;

	$lists = $bbs_lists;

	if($rows == "") $rows = "10";

	if($lists == "") $lists = "5";



	$page_count = ceil($total/$rows);

	if(!$bbs_page || $bbs_page > $page_count) $bbs_page = 1;

	$start = ($bbs_page-1)*$rows;

	$no = $total-$start;



	$sql = "select wb.*, wb.wdate as wtime, from_unixtime(wb.wdate, '%Y.%m.%d') as wdate, wm.purl,

					wi.title, wi.subject_len, wi.down_point, wi.point_msg, wi.bbsadmin, wi.newc, wi.hotc, wi.name_type,

					wc.catname, wc.caticon

					from wiz_bbs as wb left join wiz_bbsinfo as wi on wb.code = wi.code

					left join wiz_bbscat as wc on wb.category = wc.idx

					left join wiz_bbsmain as wm on wb.code = wm.code

					where $search_sql order by prino desc, idx desc limit $start, $rows";



	$result = mysql_query($sql) or error(mysql_error());

	$total = mysql_num_rows($result);



	// 상단파일

	@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_head.php";



	$ttime = mktime(0,0,0,date('m'),date('d'),date('Y'));



	while($row = mysql_fetch_array($result)) {



		$catname		="";

		$lock_icon	="";

		$re_icon		="";

		$new_icon		="";

		$hot_icon		="";

		$file_icon	="";

		$re_space		="";

		$upimg_s		="";

		$upimg_m		="";

		$upimg_size = "";



		$home_icon 	= "";

		$status    	= "";



		$name 		= $row[name];

		$nick 		= $row[nick];

		$email 		= $row[email];

		$count 		= $row[count];

		$comment 	= $row[comment];

		$recom 		= $row[recom];

		$wdate 		= $row[wdate];

		$address 		= $row[address];

		$ip = $row[ip];



		$addinfo1	= $row[addinfo1];

		$addinfo2	= $row[addinfo2];

		$addinfo3	= $row[addinfo3];

		$addinfo4	= $row[addinfo4];

		$addinfo5	= $row[addinfo5];



		if($row[subject_len] > 0) $row[subject] = cut_str($row[subject], $row[subject_len]);

		$row[content] = cut_str(strip_tags($row[content]), 300);



		$row[subject] = str_replace($total_searchkey, "<span style='background-color:".$search_bg."; color:".$search_color."; font-weight:bold;'>".$total_searchkey."</span>", $row[subject]);

		$row[content] = str_replace($total_searchkey, "<span style='background-color:".$search_bg."; color:".$search_color."; font-weight:bold;'>".$total_searchkey."</span>", $row[content]);



		$content = $row[content];



		$purl = "/".$row[purl];



		if($row[title] != "") $title = "[".$row[title]."]";

		else $title = "";



		if($row[caticon] != "") $catname = "<img src='/adm/data/category/".$row[code]."/".$row[caticon]."' align='absmiddle'>";		// category

		else if($row[catname] != "") $catname = "[".$row[catname]."]";



		if(!empty($row[upfile1])) {

			// 첨부파일

			if(!check_point($wiz_session[id], $row[down_point])) {

				$file_icon = "<a href=\"javascript:alert('$row[point_msg]')\"><img src='$skin_dir/image/file.gif' border='0' align='absmiddle'></a>";			// file

			} else if($rpermi < $mem_level) {

				$file_icon = "<a href=\"$purl?ptype=view&idx=$row[idx]&page=$page&$param\"><img src='$skin_dir/image/file.gif' border='0' align='absmiddle'></a>";			// file

			} else {

				$file_icon = "<a href='/adm/bbs/down.php?code=$row[code]&idx=$row[idx]&no=1'><img src='$skin_dir/image/file.gif' border='0' align='absmiddle'></a>";			// file

			}



		}



		$subject = "<a href='$purl?ptype=view&idx=$row[idx]&page=$page&$param' style=''>$row[subject]</a>";		// subject

		$viewBbs = "$purl?ptype=view&idx=$row[idx]&page=$page&$param";

		if($row[privacy] == "Y"){																																					// privacy

			if(

				($mem_level == "0") ||																																		// 전체관리자

				($row[bbsadmin] != "" && strpos($row[bbsadmin],$wiz_session[id]) !== false)  ||	// 게시판관리자

				($row[memid] != "" && $row[memid] == $wiz_session[id])																 ||	// 자신의글

				($wiz_session[id] != "" && strpos($row[memgrp],$wiz_session[id]) !== false)								// 그룹의글

			){

			}else{

				$subject = "<a href='$purl?ptype=passwd&mode=view&idx=$row[idx]&page=$page&$param'>$row[subject]</a>";

				$viewBbs = "$purl?ptype=passwd&mode=view&idx=$row[idx]&page=$page&$param";

				if(!empty($file_icon)) $file_icon = "<a href='$purl?ptype=passwd&mode=view&idx=$row[idx]&page=$page&$param'><img src='$skin_dir/image/file.gif' border='0' align='absmiddle'></a>";



				$content = "비밀글입니다.";

			}

			$lock_icon = "<img src='$skin_dir/image/lock.gif' border='0' align='absmiddle'>";

		}



		$wtime = $row[wtime];

		if(($ttime-$wtime)/86400 <= $row[newc]) 	$new_icon = "<img src='$skin_dir/image/new.gif' border='0' align='absmiddle'>";				// new

		if($row[count] > $row[hotc]) 						$hot_icon = "<img src='$skin_dir/image/hot.gif' border='0' align='absmiddle'>";				// hot

		if($row[depno] != 0) 													$re_icon = "<img src='$skin_dir/image/re.gif' border='0' align='absmiddle'>";					// re



		for($ii=0; $ii < $row[depno]; $ii++) 					$re_space .= "&nbsp;&nbsp;";																													// respace



		$upimg_l = $row[upfile1];

		if(file_exists(WIZHOME_PATH."/data/bbs/".$row[code]."/S".$row[upfile1])) $upimg_s = "/adm/data/bbs/$row[code]/S".$row[upfile1];							// img

		else $upimg_s = "$skin_dir/image/noimg.gif";



		if(file_exists(WIZHOME_PATH."/data/bbs/".$row[code]."/M".$row[upfile1])) $upimg_m = "/adm/data/bbs/$row[code]/M".$row[upfile1];							// img

		else $upimg_m = "$skin_dir/image/noimg.gif";



		$viewImg = "javascript:viewImg('".$upimg_l."')";



		if(img_type(WIZHOME_PATH."/data/member/".$row[memid]."_icon.gif")) $icon = "<img src='/adm/data/member/".$row[memid]."_icon.gif' align='absmiddle'>";

		else if(img_type(WIZHOME_PATH."/data/member/".$row[memid]."_icon.jpg")) $icon = "<img src='/adm/data/member/".$row[memid]."_icon.jpg' align='absmiddle'>";

		else $icon = "";



		if(!strcmp($row[name_type], "name")) $name = $name;

		else if(!strcmp($row[name_type], "nick") && !empty($nick)) $name = $nick;

		else if(!strcmp($row[name_type], "icon") && !empty($icon)) $name = $icon;

		else if(!strcmp($row[name_type], "iname")) $name = $icon." ".$name;

		else if(!strcmp($row[name_type], "inick")) {

			if(!empty($nick)) $name = $icon." ".$nick;

			else $name = $icon." ".$name;

		}



		// 홈페이지

		if(!empty($row[address])) {

			$home_icon = "<a href='http://".$row[address]."' target='_blank'><img src='".$skin_dir."/image/ic_home.gif' border='0'></a>";

		}



		// 처리상태

		if(!strcmp($row[status], "Y")) $status = "<img src='".$skin_dir."/image/bt_end.gif'>";

		else $status = "<img src='".$skin_dir."/image/bt_ing.gif'>";



		// 예약신청일

		if(!empty($addinfo1)) {

			$rdate = $addinfo1."년".$addinfo2."월".$addinfo3."일".$addinfo4."시~".$addinfo5."시";

		}



		// 목록파일

		@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_body.php";



		$no--;



	}



	if($total <= 0) {

?>

			<tr>

				<td height="38" align="center" colspan="20">검색된 게시물이 없습니다.</td>

			</tr>

			<tr>

			  <td height="1" colspan="20" bgcolor="959595"></td>

			</tr>

<?php

	}



	// 하단파일

	@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_foot.php";



// 상품

} else if(!strcmp($stype, "prd")) {



	if(!empty($bbs_page)) $param .= "&bbs_page=".$bbs_page;

	if(!empty($page_page)) $param .= "&page_page=".$page_page;



	// 상품명, 상품간단설명, 상품상세정보

	if(empty($total_searchkey)) $search_sql = " and wp.prdcode = '' ";

	else $search_sql = " and (wp.prdname like '%$total_searchkey%' or wp.stortexp like '%$total_searchkey%' or wp.content like '%$total_searchkey%') ";



	$sql = "select count(wp.prdcode) as cnt

				from wiz_product as wp left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode

				left join wiz_category as wcat on wcp.catcode = wcat.catcode

				where wcat.catuse != 'N' $search_sql";

	$result = mysql_query($sql) or error(mysql_error());

	$row = mysql_fetch_array($result);

	$total = $row[cnt];



	$idx = 0;

	$rows = $prd_rows;

	$lists = $prd_lists;

	if($rows == "") $rows = "10";

	if($lists == "") $lists = "5";



	$page_count = ceil($total/$rows);

	if(!$prd_page || $prd_page > $page_count) $prd_page = 1;

	$start = ($prd_page-1)*$rows;

	$no = $total-$start;



	$sql = "select wp.*, wc.catname, wc.purl, wc.catcode

					from wiz_product as wp left join wiz_cprelation as wcp on wp.prdcode = wcp.prdcode

					left join wiz_category as wc on wcp.catcode = wc.catcode

					where wc.catuse != 'N' $search_sql order by prior desc limit $start, $rows";



	$result = mysql_query($sql) or error(mysql_error());

	$total = mysql_num_rows($result);



	// 상단파일

	@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_head.php";



	while($row = mysql_fetch_array($result)) {



		$purl = "/".$row[purl];



		$row[content] = cut_str(strip_tags($row[content]), 300);

		$row[shortexp] = cut_str(strip_tags($row[shortexp]), 300);



		$row[prdname] = str_replace($total_searchkey, "<span style='background-color:".$search_bg."; color:".$search_color.";'>".$total_searchkey."</span>", $row[prdname]);

		$row[content] = str_replace($total_searchkey, "<span style='background-color:".$search_bg."; color:".$search_color.";'>".$total_searchkey."</span>", $row[content]);

		$row[shortexp] = str_replace($total_searchkey, "<span style='background-color:".$search_bg."; color:".$search_color.";'>".$total_searchkey."</span>", $row[shortexp]);



		if(!empty($row[catname])) $catname = "[".$row[catname]."]";

		else $catname = "";



		$prdurl = $purl."?ptype=view&prdcode=".$row[prdcode]."&catcode=". $catcode ."&page=".$page."&".$param;

		$content = str_replace("\n","",$row[content]);

		$prdnum = $row[prdnum];

		$prdimg = "/adm/data/prdimg/".$row[prdimg_R];

		$prdprice = number_format($row[prdprice]);

		$prdname = "<a href='".$purl."?ptype=view&prdcode=".$row[prdcode]."&catcode=". $row[catcode] ."&page=".$page."&".$param."'>".$row[prdname]."</a>";

		$shortexp = "<a href='".$purl."?ptype=view&prdcode=".$row[prdcode]."&catcode=". $row[catcode] ."&page=".$page."&".$param."'>".$row[shortexp]."</a>";

		$viewimg = "<a href='".$purl."?ptype=view&prdcode=".$row[prdcode]."&catcode=". $row[catcode] ."&page=".$page."&".$param."'><img src='$skin_dir/image/bt_view.gif' border='0'></a>";



		// 목록파일

		@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_body.php";



		$no--;



	}



	if($total <= 0) {

?>

			<tr>

				<td height="38" align="center" colspan="20">검색된 상품이 없습니다.</td>

			</tr>

			<tr>

			  <td height="1" colspan="20" bgcolor="959595"></td>

			</tr>

<?php

	}



	// 하단파일

	@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_foot.php";



// 페이지

} else if(!strcmp($stype, "page")) {



	if(!empty($bbs_page)) $param .= "&bbs_page=".$bbs_page;

	if(!empty($prd_page)) $param .= "&prd_page=".$prd_page;



	// 페이지내용

	if(empty($total_searchkey)) $search_sql = " idx = '' ";

	else $search_sql = " (content like '%$total_searchkey%') ";



	$sql = "select count(idx) as cnt from wiz_page where $search_sql";

	$result = mysql_query($sql) or error(mysql_error());

	$row = mysql_fetch_array($result);

	$total = $row[cnt];



	$idx = 0;

	$rows = $page_rows;

	$lists = $page_lists;

	if($rows == "") $rows = "10";

	if($lists == "") $lists = "5";



	$page_count = ceil($total/$rows);

	if(!$page_page || $page_page > $page_count) $page_page = 1;

	$start = ($page_page-1)*$rows;

	$no = $total-$start;



	$sql = "select * from wiz_page where $search_sql order by idx desc limit $start, $rows";

	$result = mysql_query($sql) or error(mysql_error());

	$total = mysql_num_rows($result);



	// 상단파일

	@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_head.php";



	while($row = mysql_fetch_array($result)) {



		$purl = "/".$row[url];

		$pagename = $row[title];



		$row[content] = cut_str(strip_tags($row[content]), 300);



		$content = str_replace($total_searchkey, "<span style='background-color:".$search_bg."; color:".$search_color.";'>".$total_searchkey."</span>", $row[content]);



		// 목록파일

		@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_body.php";



		$no--;



	}



	if($total <= 0) {

?>

			<tr>

				<td height="38" align="center" colspan="20">검색된 페이지가 없습니다.</td>

			</tr>

			<tr>

			  <td height="1" colspan="20" bgcolor="959595"></td>

			</tr>

<?php

	}



	// 하단파일

	@include "$_SERVER[DOCUMENT_ROOT]/$skin_dir/".$stype."_list_foot.php";



}



?>
