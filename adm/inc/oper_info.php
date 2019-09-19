<?php
  $sql = "SELECT * FROM wiz_operinfo";
  $result = mysql_query($sql) or error(mysql_error());

  $oper_info = mysql_fetch_array($result);



  $sql = "SELECT estimate_use, estimate_bigo FROM wiz_siteinfo";
  $result = mysql_query($sql) or error(mysql_error());
  $row = mysql_fetch_array($result);

  $oper_info[estimate_use] = $row[estimate_use];
  $oper_info[estimate_bigo] = $row[estimate_bigo];

	$review_code = "review";
  $sql = "select usetype from wiz_bbsinfo where code = '$review_code'";
  $result = mysql_query($sql) or error(mysql_error());
  $row = mysql_fetch_array($result);

  $oper_info[review_usetype] = $row[usetype];

	$qna_code = "qna";
  $sql = "select usetype from wiz_bbsinfo where code = '$qna_code'";
  $result = mysql_query($sql) or error(mysql_error());
  $row = mysql_fetch_array($result);

  $oper_info[qna_usetype] = $row[usetype];
?>
