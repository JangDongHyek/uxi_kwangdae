<?
$sql = "select orderid from wiz_order wo where orderid and wo.status = 'OR'";
$result = mysql_query($sql) or error(mysql_error());
$OR_total = mysql_num_rows($result);


$sql = "select orderid from wiz_order wo where orderid and wo.status = 'OY'";
$result = mysql_query($sql) or error(mysql_error());
$OY_total = mysql_num_rows($result);

$sql = "select orderid from wiz_order wo where orderid and wo.status = 'DR'";
$result = mysql_query($sql) or error(mysql_error());
$DR_total = mysql_num_rows($result);




$sql = "select orderid from wiz_order wo where orderid and wo.status = 'RD'";
$result = mysql_query($sql) or error(mysql_error());
$RD_total = mysql_num_rows($result);

$sql = "select orderid from wiz_order wo where orderid and wo.status = 'CD'";
$result = mysql_query($sql) or error(mysql_error());
$CD_total = mysql_num_rows($result);

?>
