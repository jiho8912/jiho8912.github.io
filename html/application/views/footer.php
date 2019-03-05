</div>

<div class="col-md-3">
    <p class="lead"></p>
    <? if (!$this->session->userdata("mb_id") and @$is_member != 1) { ?>
        <!--로그인박스-->
        <div class="loginbox mb30">
            <form id="flogin" class="form-horizontal" name="flogin" method="post" action="/member/in"
                  novalidate="novalidate">
                <input type="text" class="form-control mb10" name="mb_id" placeholder="Enter User ID" value="">
                <input type="password" class="form-control mb10" name="mb_password" placeholder="Enter Password">
                <button class="btn btn-primary btn-sm pull-left" type="submit">로그인</button>

                <ul class="text pull-right" style="padding-top:15px;">
                    <li style="float:left; padding-right:5px;">
                        <a href="/member/join_v" title="회원가입">회원가입</a>
                    </li>
                    <li style="float:left; padding-right:5px;">|</li>
                    <li style="float:left; padding-right:5px;">
                        <a href="/member/forget_idpwd" title="회원정보찾기">회원정보찾기</a>
                    </li>
                </ul>

            </form>
            <div class="col-lg-12 text-center well-sm  clearfix">

                <form id="sns_login" method="post">
                    <img src="<?= board_Img_dir ?>/icon/social_facebook.png" width="22" height="22" style="cursor: pointer;" id="login_facebook" scope="public_profile,email,user_birthday">
                    <img src="<?= board_Img_dir ?>/icon/social_naver.png" width="22" height="22" style="cursor: pointer;" id="login_naver" >
                    <img src="<?= board_Img_dir ?>/icon/social_kakao.png" width="22" height="22">
                    <img src="<?= board_Img_dir ?>/icon/social_google.png" width="22" height="22">
                </form>

            </div>
        </div>
        <!--로그인박스 종료-->

    <? } else { ?>

    <? } ?>

    <!--우측네비 시작-->
    <div class="clearfix">
    </div>
    <ul class="nav nav-pills nav-stacked">
        <!--메뉴 리스트 시작-->
        <? if ($category_list) { ?>
            <!--홈메뉴-->
            <li class="<? if (!@$board_id) { ?>
										active
								<? } ?>">
                <a href="/">
                    HOME
                </a>
            </li>
            <!--홈메뉴-->

            <!--1차메뉴리스트 시작-->
            <? foreach ($category_list as $category_1_depth) { ?>
                <!--2차메뉴있을경우 시작-->
                <? if (@$category_1_depth["sub"]) { ?>
                    <!--메뉴 노출 Y/N 시작-->
                    <? if ($category_1_depth["show_yn"] == 'Y') { ?>
                        <li class="dropdown
									<? foreach ($category_1_depth["sub"] as $category_2_depth) { ?>
										<? if (@$board_id == $category_2_depth["board_id"]) { ?>
											active
										<? } ?>
									<? } ?>"
                        >
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">
                            <?= $category_1_depth["category_name"] ?>
                            <span class="caret">
										</span>
                        </a>
                    <? } ?>
                    <!--메뉴 노출 Y/N 종료-->
                    <!--2차메뉴있을경우 종료-->
                <? } else { ?>
                    <? if ($category_1_depth["show_yn"] == 'Y') { ?>
                        <li class="
									<? if (@$board_id == $category_1_depth["board_id"]) { ?>
										active
									<? } ?>">
                            <a href="<?= $category_1_depth['link_url'] ?><?= $category_1_depth["board_id"] ?>">
                                <?= $category_1_depth["category_name"] ?>
                            </a>
                        </li>
                    <? } ?>
                <? } ?>
                <? if (@$category_1_depth["sub"]) { ?>
                    <ul class="dropdown-menu">
                        <? foreach ($category_1_depth["sub"] as $category_2_depth) { ?>
                            <? if ($category_2_depth["show_yn"] == 'Y') { ?>
                                <li class="
												<? if (@$board_id == $category_2_depth["board_id"]) { ?>
													active
												<? } ?>">
                                    <a href="<?= $category_2_depth['link_url'] ?><?= $category_2_depth["board_id"] ?>">
                                        <?= $category_2_depth["category_name"] ?>
                                    </a>
                                    <? if (@$category_2_depth["sub"]) { ?>
                                        <ul class="ul_depth_3 ul_action_3">
                                            <? foreach (@$category_2_depth["sub"] as $category_3_depth) { ?>
                                                <? if ($category_3_depth["show_yn"] == 'Y') { ?>
                                                    <a style="color:#333; "
                                                       href="<?= $category_3_depth['link_url'] ?><?= $category_3_depth["board_id"] ?>">
                                                        - <?= $category_3_depth["category_name"] ?>
                                                    </a>
                                                <? } ?>
                                            <? } ?>
                                        </ul>
                                    <? } ?>
                                </li>
                            <? } ?>
                        <? } ?>
                    </ul>
                    </li>
                <? } ?>
            <? } ?>
            <!--1차메뉴 종료-->
        <? } ?>
    </ul>
    <!--우측네비 종료-->

    <!--최근 게시물 시작-->
    <div class="board-row pull-left">
        <div class="latest_main_title">

					<span class="board_name">
						<span id="new_content">
							최근 게시물
						</span>
					</span>
        </div>
        <table class="table table-hover">
            <tbody>
            <? if (sizeof($select_main_new_data)) { ?>
                <? foreach ($select_main_new_data as $key => $list) { ?>
                    <tr>
                        <td>
                            <a href="/board/view_v/<?= $list['board_id'] ?>/<?= $list['no'] ?>">
                                <?= $list['subject'] ?>
                            </a>
                            <!--신규글 아이콘 시작-->
                            <?
                            if ((strtotime($list['reg_date']) + 86400) >= time()) {
                                echo '<img src=' . board_Img_dir . '/icon/new_comment.gif width="16" height="11" alt="new">';
                            }
                            ?>
                            <!--신규글 아이콘 종료-->
                            <!--댓글 아이콘 시작-->
                            <?
                            if (!$this->board_m->comment_count($list['no']) == 0) {
                                ?>
                                <span class="pull-right">
												<span class="comment_count label label-default">
													<?= $this->board_m->comment_count($list['no']) ?>
												</span>
											</span>
                                <?
                            }
                            ?>
                            <!--댓글 아이콘 종료-->
                        </td>
                        <td class="px50">
                            <?= substr($list['reg_date'], 5, 6) ?>
                        </td>
                    </tr>
                <? } ?>
            <? } else { ?>
                <tr>
                    <td style="color:black;">
                        등록된 글이 없습니다.
                    </td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
    <!--최근게시물 종료-->

    <!--최근 댓글 시작-->
    <div class="board-row pull-left">
        <div class="latest_main_title">

					<span class="board_name">
						<span id="new_reply">
							최근 댓글
						</span>
					</span>
        </div>
        <table class="table table-hover">
            <tbody>
            <? if (sizeof($select_new_reply)) { ?>

                <? foreach ($select_new_reply as $key => $list) { ?>
                    <tr>
                        <td>
                            <a href="/board/view_v/<?= $list['board_id'] ?>/<?= $list['no'] ?>">
                                <?= $list['contents'] ?>
                            </a>
                            <!--신규글 아이콘 시작-->
                            <?
                            if ((strtotime($list['reg_date']) + 86400) >= time()) {
                                echo '<img src=' . board_Img_dir . '/icon/new_comment.gif width="16" height="11" alt="new">';
                            }
                            ?>
                            <!--신규글 아이콘 종료-->
                        </td>
                        <td class="px50">
                            <?= substr($list['reg_date'], 5, 6) ?>
                        </td>
                    </tr>
                <? } ?>
            <? } else { ?>
                <tr>
                    <td style="color:black;">
                        등록된 글이 없습니다.
                    </td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
    <!--최근댓글 종료-->
</div>
</div>
<!--인스타그램 api-->
<div class="instar_title"></div>
<div class="slider"></div>
<!--인스타그램 api-->
</div>
<!-- Footer -->
<footer id="footer" class="midnight-blue">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-left" style="padding-right:74px">
                © CodeIgniter 지호 2017. All Rights Reserved.
            </div>
        </div>
    </div>
</footer>

</body>
</html>

<style>
    #footer {
        padding-top: 30px;
        padding-bottom: 30px;
        color: #fff;
        background: #333;
    }

    #footer ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    #footer ul > li {
        display: inline-block;
        margin-left: 15px;
    }

</style>

<script>
    $(document).ready(function () {
        var width = $("#contents img").width();
        $("#contents img").width("100%");

        // 페이스북 api 시작
        $("#login_facebook").click(function () {

            FB.login(function (response) {
                var accessToken = response.authResponse.accessToken;
                if (response.status === 'connected') {

                    FB.getLoginStatus(function (response) {
                        //console.log(JSON.stringify(response));
                    });

                    FB.api('/me?fields=name,email', function (response) {
                        var params = {};
                        params.mb_id = response.id;
                        params.mb_name = response.name;
                        params.mb_email = response.email;
                        params.type = 'facebook';

                        $.ajax({
                            method: "post",
                            url: '/member/sns_in_front',
                            data: params,
                            success: function (res) {
                                alert(res.message);
                                if (res) location.href = '/';
                            }
                        });
                    });
                }
            }, {scope: 'public_profile,email'});
        });
        // 페이스북 api 종료

        // 네이버 로그인 api
        $("#login_naver").click(function () {
            $.ajax({
                method: "post",
                url: '/member/generate_state',
                contentType: "application/json",
                data: '',
                success: function (res) {
                    if(res){
                        var client_id = "<?=NAVER_CLIENT_ID?>";
                        var redirect_url = "<?=NAVER_CALLBACK_URL?>";
                        var url = "https://nid.naver.com/oauth2.0/authorize?client_id=" +client_id+ "&response_type=code&redirect_uri=" +redirect_url+ "&state=" +res;
                        popup(url, 600, 500);
                    }else{
                        swal({
                            text: '네이버 로그인 실패!',
                            type: 'error'
                        });
                    }
                }
            });
        });
    });

    /* 페이스북 api */
    window.fbAsyncInit = function () {
        FB.init({
            appId: '629623190526314',
            cookie: true,  // enable cookies to allow the server to access
                           // the session
            xfbml: true,  // parse social plugins on this page
            version: 'v2.5' // use graph api version 2.5
        });
    };
    // Load the SDK asynchronously
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    //sns공유 함수(sns_type : 공유할 sns)
    function sns_share(sns_type) {
        var url = "http://<?=$_SERVER['HTTP_HOST']?><?=$_SERVER['REQUEST_URI']?>"; //현재 위치 url
        var href = "" //보내고자 하는 경로
        var win = ""; //새창으로열기

        if (sns_type == "fb") //페이스북일경우
        {
            href = "http://www.facebook.com/sharer.php?u=" + encodeURIComponent(url);
        }
        if (sns_type == "tw") //트위터의경우
        {
            href = "http://twitter.com/intent/tweet?text=" + encodeURIComponent(url);
        }
        if (sns_type == "ks") //카카오스토리의경우
        {
            href = "https://story.kakao.com/s/share?url=" + encodeURIComponent(url);
        }

        win = window.open(href, "_blank", "width=600, height=500, resizable=yes"); //600*500 새창으로열기

        if (win) {
            win.focus();
        }
    }
</script>
<?
$CI =& get_instance();
$CI->load->model('visitor_m');
$CI->visitor_m->insertVisitor();
?>