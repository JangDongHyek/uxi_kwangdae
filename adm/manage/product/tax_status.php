<? include_once "../../common.php" ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>세금계산서, 현금영수증  일괄처리</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<link href="../wiz_style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="S_contents">

<h4>계산서,영수증  일괄처리</h4>

<form action="order_save.php">
<input type="hidden" name="tmp">
<input type="hidden" name="mode" value="batchStatusTax">
<input type="hidden" name="selvalue" value="<?=$selvalue?>">
<table width="100%" align="center" border="0" cellspacing="0" cellpadding="0" class="table_basic">
  <tr>
    <th>상태선택</th>
    <td>
    <select name="tax_pub" style="width:90">
    <option value="N">발급대기</option>
    <option value="Y">발급완료</option>
    </select>
    </td>
  </tr>
</table>

<div class="center top10">
    <button type="submit" class="b h28 t5 color blue_big">확인</button>
    <button type="button" onClick="self.close();" class="b h28 t5 color gray_big">닫기</button>
</div>
</form>


</body>
</html>
