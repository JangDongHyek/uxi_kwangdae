<? // PC Header ?>
<div id="header">

    <div class="header_top">
        <div class="container">
            <div class="header_top_left">
                <div id="bookmark">
                    <a href="#">
                        <p class="icon-bookmark"></p><span>즐겨찾기</span>
                    </a>
                </div>
            </div>
            <div class="header_top_right">
                <div id="customer-menu">
                    <ul>
                        <li><? include "$_SERVER[DOCUMENT_ROOT]/adm/module/toplogin.php"; // Login/Logout ?></li>
                        <li><? include "$_SERVER[DOCUMENT_ROOT]/adm/module/topjoin.php"; // Signin/Modify ?></li>
                        <li><a href="/child/sub/member/cart.php">장바구니</a></li>
                        <li><a href="/child/sub/member/order_list.php">주문내역</a></li>
                        <li><a href="/child/sub/notice.php">공지사항</a></li>
                        <li><a href="/child/sub/shop/product.php?catcode=111000000">개인결제창</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="header_middle">
        <div class="container clearfix">
            <div class="header_middle_left">
                <ul class="sns-ul clearfix">
                    <li class="sns"><a href=""><i class="s1"></i></a></li>
                    <li class="sns"><a href=""><i class="s2"></i></a></li>
                    <li class="sns"><a href=""><i class="s3"></i></a></li>
                </ul>
            </div>
            <div class="header_middle_center">
                <h1 id="header-logo">
                    <a class="ci" href="/child/main/main.php">
                        <span></span>
                    </a>
                </h1>
            </div>
            <div class="header_middle_right">
                <div id="header-search">
                    <? include "$_SERVER[DOCUMENT_ROOT]/adm/module/prd_search.php"; // 상품검색 ?>
                </div>
            </div>
        </div>
        <div class="menu"></div>
        <div class="cart"><a href="/child/sub/member/cart.php" title="장바구니 바로가기"></a></div>
    </div>

    <div class="header_bottom">
        <div class="container">
            <div id="gnb">
                <ul class="list">
                    <li><a href="/child/sub/shop/product.php?catcode=101000000">한복의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=101107000"><span>궁중의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=101108000"><span>어우동,황진이</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=101102000"><span>삼국시대</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=101103000"><span>갑옷,무술복(고전)</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=101104000"><span>캐릭터한복</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=101105000"><span>전근대,개화기</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=101106000"><span>조선시대</span></a></li>
                        </ul>
                    </li>
                    <li><a class="c-menu" href="/child/sub/shop/product.php?catcode=102000000">세계의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=102100000"><span>세계의상(서양)</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=102101000"><span>세계의상(동양)</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=102102000"><span>미주</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=102103000"><span>아프리카</span></a></li>
                        </ul>
                    </li>
                    <li><a href="/child/sub/shop/product.php?catcode=103000000">서양시대의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=103100000"><span>중세의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=103101000"><span>전근대의상</span></a></li>
                        </ul>
                    </li>
                    <li><a href="/child/sub/shop/product.php?catcode=104000000">행사의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=104100000"><span>반짝이,장기자랑의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104101000"><span>고적대,퍼레이드</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104102000"><span>월별행사의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104103000"><span>종교,성극의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104104000"><span>여장남자의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104105000"><span>몸빼,타이즈의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104106000"><span>턱시도,정장의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104107000"><span>댄스의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104108000"><span>드레스</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104109000"><span>웨딩드레스</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104110000"><span>코믹,황당의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=104111000"><span>7080, 복고</span></a></li>
                        </ul>
                    </li>
                    <li><a href="/child/sub/shop/product.php?catcode=105000000">할로윈·캐릭터의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=105100000"><span>히어로의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=105101000"><span>마녀의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=105102000"><span>영화,동화의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=105103000"><span>섹시,큐트의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=105104000"><span>호러의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=105105000"><span>삐에로의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=105106000"><span>죄수복</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=105107000"><span>게임,스타의상</span></a></li>
                        </ul>
                    </li>
                    <li><a href="/child/sub/shop/product.php?catcode=106000000">탈인형·동물의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=106100000"><span>탈인형</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=106101000"><span>동물의상</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=106102000"><span>모자탈</span></a></li>
                        </ul>
                    </li>
                    <li><a href="/child/sub/shop/product.php?catcode=107000000">교복의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=107100000"><span>현대교복</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=107101000"><span>옛날교복</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=107102000"><span>외국교복</span></a></li>
                        </ul>
                    </li>
                    <li><a href="/child/sub/shop/product.php?catcode=108000000">직업의상</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=108100000"><span>한국군인</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108101000"><span>해외군인</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108102000"><span>소방관</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108103000"><span>경찰관</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108104000"><span>스포츠</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108105000"><span>요리사</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108106000"><span>의료기관</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108107000"><span>우체부</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=108108000"><span>서비스업외 의상</span></a></li>
                        </ul>
                    </li>
                    <li><a href="/child/sub/shop/product.php?catcode=109000000">커플의상</a></li>
                    <li><a href="/child/sub/shop/product.php?catcode=110000000">소품</a>
                        <ul class="sub">
                            <li><a href="/child/sub/shop/product.php?catcode=110100000"><span>가면</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110101000"><span>가발</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110102000"><span>모자,왕관</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110103000"><span>신발</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110104000"><span>무기류</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110105000"><span>기타소품</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110106000"><span>대형소품</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110107000"><span>안경,선글라스</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110108000"><span>넥타이</span></a></li>
                            <li><a href="/child/sub/shop/product.php?catcode=110109000"><span>가방</span></a></li>
                        </ul>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<? // Mobile Header ?>
<div class="m_gnb">
    <div id="menu-container">
        <ul class="menu-login">
            <li><span class="login_icon"></span><? include "$_SERVER[DOCUMENT_ROOT]/adm/module/toplogin.php"; // Login/Logout ?></li>
        </ul>

        <ul class="menu-list my-page">
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=101000000">한복의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=102000000">세계의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=103000000">서양시대의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=104000000">행사의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=105000000">할로윈·캐릭터의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=106000000">탈인형·동물의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=107000000">교복의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=108000000">직업의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=109000000">커플의상</a>
            </li>
            <li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=110000000">소품</a>
            </li>
			<li class="toggle">
                <span class="icon-plus"></span>
                <a href="/child/sub/shop/product.php?catcode=111000000">개인결제창</a>
            </li>
            <li class="toggle accordion-toggle">
                <span class="icon-plus"></span>
                <a class="menu-link" href="#">광대</a>
            </li>
            <ul class="menu-submenu accordion-content">
                <li><a href="/child/sub/intro.php">회사소개</a></li>
<!--                 <li><a href="/child/sub/location.php">매장위치</a></li> -->
                <li><a href="/child/sub/portfolio.php">포트폴리오</a></li>
                <li><a href="/child/sub/notice.php">공지사항</a></li>
                <li><a href="/child/sub/board1.php">방문예약</a></li>
                <li><a href="/child/sub/board2.php">주문제작</a></li>
                <li><a href="/child/sub/guide.php">대여가이드</a></li>
                <li><a href="/child/sub/photo.php">포토후기</a></li>
                <li><a href="/child/sub/qna.php" target="_blank">Q&A</a></li>

            </ul>
            <li class="toggle accordion-toggle">
                <span class="icon-plus"></span>
                <a class="menu-link" href="#">마이페이지</a>
            </li>
            <ul class="menu-submenu accordion-content">
                <li><a href="/child/sub/member/mypage.php"><p>회원정보수정</p></a></li>
                <li><a href="/child/sub/member/cart.php" title="장바구니 바로가기"><p>장바구니</p></a></li>
                <li><a href="/child/sub/member/order_list.php"><p>주문배송조회</p></a></li>
            </ul>
        </ul>
    </div>

</div>



<? // Quick Menu

if($quick == "on" && $ptype != 'view'){
?>
<div class="quick-menu quick-on" style="top:873px;">
    <button class="quick-toggle" type="button"></button>
    <div class="quick-menu-wrap">
        <div class="quick-button">
            <ul class="button-ul">
                <li><a class="q-btn" href="/child/sub/intro.php"><i class="q1"></i>회사소개 및<br>매장위치</a></li>
                <li><a class="q-btn" href="/child/sub/qna.php"><i class="q2"></i>Q&A</a></li>
                <li><a class="q-btn" href="/child/sub/portfolio.php"><i class="q3"></i>포트폴리오</a></li>
                <li><a class="q-btn" href="/child/sub/board1.php"><i class="q4"></i>방문예약</a></li>
                <li><a class="q-btn" href="/child/sub/board2.php"><i class="q5"></i>주문제작</a></li>
                <li><a class="q-btn" href="/child/sub/member/order_list.php"><i class="q6"></i>배송조회</a></li>
                <li><a class="q-btn" href="/child/sub/guide.php"><i class="q7"></i>대여가이드</a></li>
                <li><a class="q-btn" href="/child/sub/photo.php"><i class="q8"></i>포토후기</a></li>
            </ul>
        </div>
        <div class="quick-prd">
            <? include "$_SERVER[DOCUMENT_ROOT]/adm/module/prd_view.php"; // 오늘본상품 ?>
        </div>
        <div class="quick-info">
            <span class="q-tit">CUSTOMER CENTER</span>
            <ul class="q-ul">
                <li>대표전화 : <strong>02-597-0033</strong></li>
                <li>긴급상담 : <strong>010-2079-9454</strong></li>
                <li>팩스번호 : <strong>02-597-0035</strong></li>
            </ul>
            <em>오전 9시 ~ 오후 9시 전화상담 가능</em>
            <span class="q-tit">BANK INFO</span>
            <p>신한은행 347-13020-101<br>예금주 : 한준영</p>
            <div class="q-talk clearfix">
                <p>카카오톡 아이디<br><strong>ID : kwangdae119</strong></p>
                <img src="/child/img/icon/q-talk.png" alt="">
            </div>

        </div>
        <button class="top-btn" type="button"><span>TOP<i></i></span></button>
    </div>
</div>
<?
}
?>
