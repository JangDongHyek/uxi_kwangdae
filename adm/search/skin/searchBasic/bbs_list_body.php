<?
/*
$no					: 글 넘버
$catname		: 카테고리
$re_space		: 답글 깊이
$re_icon		: 답글 아이콘
$subject		: 제목
$lock_icon	: 비밀글 아이콘
$new_icon		: 새글 아이콘
$hot_icon		: 인기글 아이콘
$file_icon	: 첨부파일 아이콘
$name				: 이름
$email			: 이메일
$wdate			: 작성일
$count			: 조회수
$comment		: 댓글수
$recom			: 추천
$content		: 글내용
*/
?>


<tr><td colspan="4" height="10"></td></tr>
<tr>
	<td align="center" height="38"><?=$no?></td>
	<td style="word-break:break-all;" align="left">
    	<div class="AW_search_bbslist_subject"><?=$title?> <?=$catname?> <?=$re_space?><?=$re_icon?><?=$subject?> <?=$lock_icon?> <?=$new_icon?> <?=$hot_icon?> <?=$file_icon?></div>
    </td>
	<td align="center" style="font-size:11px;"><?=$name?></td>
	<td align="center" style="font-size:11px;"><?=$wdate?></td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td colspan="2"><?=$content?></td>
    <td>&nbsp;</td>
</tr>
<tr><td colspan="4" height="15"></td></tr>



<tr><td colspan="4" height="1" bgcolor="#dddddd"></td></tr>
