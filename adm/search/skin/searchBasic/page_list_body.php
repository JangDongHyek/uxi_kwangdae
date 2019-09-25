<?
/*
$no					: 글 넘버
$pagename		: 페이지명
$content		: 페이지내용
*/
?>
	<tr>
		<td align="center" height="28" style="padding:2px"><?=$no?></td>
		<td align="left"><a href="<?=$purl?>"><?=$pagename?></a></td>
		<td align="center"><?=$viewimg?></td>
	</tr>
	<tr>
	  <td colspan="3">
	  	<table width="100%" cellspacing="0" cellpadding="0">
	    <tr>
	      <td><table cellspacing="1" cellpadding="0" border="0" width="100%" bgcolor="e2e2e2">
	        <tr>
	          <td bgcolor="f9f9f9" style="padding-top:3px;padding-bottom:3px;">
	          <table cellspacing="3" cellpadding="2" border="0" width="100%">
	            <tr>
	              <td width="1"></td>
	              <td style="word-break:break-all;" align="left"><a href="<?=$purl?>"><?=$content?></a></td>
	            </tr>
	          </table></td>
	        </tr>
	      </table></td>
	    </tr>
	  </table></td>
	</tr>
