<form id="flogin" class="form-horizontal" name="flogin" method="post" action="/member/in" novalidate="novalidate">
    <legend>로그인</legend>
    
    <div class="form-group">
        <label class="col-md-3 control-label" for="mb_id">아이디</label>
        <div class="col-md-9">
            <input type="text" id="mb_id" name="mb_id" class="form-control span3" maxlength="20" value="">

            <div class="btn-group" data-toggle="buttons">
                <label id="reId" class="btn btn-xs btn-default">
                    <input type="checkbox" name="reId" value="1">
                    <span class="glyphicon glyphicon-unchecked"></span> 아이디 저장하기
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3 control-label" for="mb_password">비밀번호</label>
        <div class="col-md-9">
            <input type="password" id="mb_password" name="mb_password" class="form-control span3" maxlength="20">
            <button type="submit" class="btn btn-primary">로그인</button>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-9 text-center well-sm  clearfix">
            <form id="sns_login" method="post">
                <img src="<?= board_Img_dir ?>/icon/social_facebook.png" width="22" height="22" style="cursor: pointer;" id="login_facebook" scope="public_profile,email,user_birthday">
                <img src="<?= board_Img_dir ?>/icon/social_naver.png" width="22" height="22" style="cursor: pointer;" id="login_naver">
                <img src="<?= board_Img_dir ?>/icon/social_kakao.png" width="22" height="22" style="cursor: pointer;" id="login_kakao">
                <img src="<?= board_Img_dir ?>/icon/social_google.png" width="22" height="22">
            </form>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-3 control-label"></label>
        <div class="col-md-9">
            <p>
                <span class="glyphicon glyphicon-exclamation-sign"></span> 아직 회원이 아니십니까?
                <a href="/member/join_v" class="btn btn-sm btn-success">회원가입</a>
            </p>
            <p>
                <span class="glyphicon glyphicon-question-sign"></span> 아이디/비밀번호를 잊으셨습니까?
                <a href="/member/forget_idpwd" class="btn btn-sm btn-warning">ID/비밀번호분실</a>
            </p>
        </div>
    </div>
</form>