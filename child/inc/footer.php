<div id="footer">
    <div class="footer-top">
        <div class="footer-container">
            <ul class="pt-list list">
                <li><a href="/child/sub/intro.php">회사소개</a></li>
                <li><a href="/child/sub/guide.php">대여가이드</a></li>
                <li><a href="/child/sub/member/privacy.php">개인정보취급방침</a></li>
                <li><a href="/child/sub/member/term.php">이용약관</a></li>
                <li onclick="desktopMode()" style="cursor:pointer">PC버전</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="footer-container">
            <ul class="list">
                <li><a>광대</a></li>
                <li><a>대표자 : 한준영</a></li>
                <li><a>사업자등록번호 : 214-09-54530</a></li>
                <li><a>통신판매업신고 : 제 09015호</a></li>
                <li><a>주소 : 서울시 서초구 서초중앙로18 쌍용플레티넘 지하 4층 광대</a></li>
                <li><a>대표전화 : 02-597-0033</a></li>
                <li><a>팩스 : 02-597-0035</a></li>
                <li><a>이메일 : 5970033@naver.com</a></li>
            </ul>
            <div class="copyright">
                <p>Copyright© KWANGDAE.NET. All right Reserved.</p>
            </div>
        </div>
    </div>
</div>



</body>

</html>

<script>

function getCookie(name) {
var cookies = document.cookie.split(";");
for (var i = 0; i < cookies.length; i++) {
    if (cookies[i].indexOf("=") == -1) {
        if (name == cookies[i])
            return "";
    } else {
        var crumb = cookies[i].split("=");
        if (name == crumb[0].trim())
            return unescape(crumb[1].trim());
    }
}
};
var desktopModeTF = getCookie("DesktopMode");
var Scale = getCookie("DesktopModeScale");
var defWidth = 1170;
if (desktopModeTF == "true") {
document
        .write('<meta name="viewport" content="width='+defWidth+', user-scalable=yes, initial-scale='+Scale+'">');
} else {
document
        .write('<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">');
}
function desktopMode() {
if(getCookie("DesktopMode") == "true"){
    setModeCookie(false);
}else{
    alert("다시한번 클릭하시면 원래대로 돌아옵니다.");
    setModeCookie(true);
    window.scrollTo(0, 0);
}
location.reload();

}
function setModeCookie(switchOn){
var now = new Date();
var time = now.getTime();
time += 3600 * 1000;
now.setTime(time);
document.cookie ='DesktopMode='+switchOn +'; expires=' + now.toUTCString() ;
if(switchOn){
    document.cookie = "DesktopModeScale=" + $('html').width() / defWidth +'; expires=' + now.toUTCString() ;;
}
}
</script>
