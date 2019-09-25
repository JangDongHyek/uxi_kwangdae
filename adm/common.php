<?
@header('P3P: CP="NOI CURa ADMa DEVa TAIa OUR DELa BUS IND PHY ONL UNI COM NAV INT DEM PRE"');

header("Content-Type:text/html; charset=utf-8"); // 페이지 utf-8 설정

@ini_set("session.use_trans_sid", 0);	// PHPSESSID를 자동으로 넘기지 않음	=> session.auto_start = 0 으로 설정 / PHP 5 이상 버전부터 session.use_trans_sid 설정을 ini_set으로 바꿀 수 없음
@ini_set("url_rewriter.tags","");			// 링크에 PHPSESSID가 따라다니는것을 무력화함

session_save_path("$_SERVER[DOCUMENT_ROOT]/adm/data/session");

if($SESSION_CACHE_LIMITER) session_cache_limiter($SESSION_CACHE_LIMITER);
else session_cache_limiter('private, must-revalidate');

@ini_set("session.cache_expire", 1440);			// 세션 캐쉬 보관시간 (분)
@ini_set("session.gc_maxlifetime", 86400);	// session data의 gabage collection 존재 기간을 지정 (초)

session_set_cookie_params(0, "/");
@ini_set("session.cookie_domain", "");

@session_start();

// register_globals off 처리
@extract($_GET);
@extract($_POST);
@extract($_SERVER);
@extract($_ENV);
@extract($_SESSION);
@extract($_COOKIE);
@extract($_REQUEST);
@extract($_FILES);

define(WIZHOME_DIR, "adm");
define(WIZHOME_PATH, $_SERVER['DOCUMENT_ROOT']."/".WIZHOME_DIR);

/******************************************************************************
* 솔루션 설치확인
******************************************************************************/
if(!file_exists(WIZHOME_PATH."/dbcon.php")){
	echo "<script>document.location='/adm/install.php';</script>";
	exit;
}

/******************************************************************************
* lib.php
******************************************************************************/
include WIZHOME_PATH."/lib.php";
include WIZHOME_PATH."/lib_puny.php";

/******************************************************************************
* 데이타 베이스 접속
******************************************************************************/
include WIZHOME_PATH."/dbcon.php";
$connect = @mysql_connect($db_host, $db_user, $db_pass) or error("DB 접속시 에러가 발생했습니다.");
@mysql_select_db($db_name, $connect) or error("DB Select 에러가 발생했습니다");

/******************************************************************************
* 접속상황 및 이동경로 파악
******************************************************************************/
$con_file = WIZHOME_PATH."/data/connect/".$_SERVER['REMOTE_ADDR'];
@touch($con_file);

/******************************************************************************
* 라이센스 체크
(아래 라이센스 체크 부분을 삭제하거나 변경 할 경우 법적 제제를 받으실수 있습니다.
******************************************************************************/
// include WIZHOME_PATH."/licence.php";

/******************************************************************************
* 캐슬 방화벽 실행
******************************************************************************/
// define(__CASTLE_PHP_VERSION_BASE_DIR__, WIZHOME_PATH."/castle");
// include __CASTLE_PHP_VERSION_BASE_DIR__."/castle_referee.php";

//광대 이전을 위해 패스워드 암호화 변경
function sql_password($value)
{
    // mysql 4.0x 이하 버전에서는 password() 함수의 결과가 16bytes
    // mysql 4.1x 이상 버전에서는 password() 함수의 결과가 41bytes
    $row = sql_fetch(" select password('$value') as pass ");
    return $row[pass];
}

// mysql_query 와 mysql_error 를 한꺼번에 처리
function sql_query($sql, $error=TRUE)
{
    if ($error)
        $result = @mysql_query($sql) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    else
        $result = @mysql_query($sql);
    return $result;
}

// 쿼리를 실행한 후 결과값에서 한행을 얻는다.
function sql_fetch($sql, $error=TRUE)
{
    $result = sql_query($sql, $error);
    //$row = @sql_fetch_array($result) or die("<p>$sql<p>" . mysql_errno() . " : " .  mysql_error() . "<p>error file : $_SERVER[PHP_SELF]");
    $row = sql_fetch_array($result);
    return $row;
}

// 결과값에서 한행 연관배열(이름으로)로 얻는다.
function sql_fetch_array($result)
{
    $row = @mysql_fetch_assoc($result);
    return $row;
}

?>
<? $_COMPONENTS = array(); ?>
