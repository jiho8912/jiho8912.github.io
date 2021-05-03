<form id="join" class="form-horizontal" name="join" method="post" action="/member/join" novalidate="novalidate">
	<fieldset>
		<legend>회원 가입</legend>
		<div class="form-group">
			<label class="col-md-3 control-label" for="reg_mb_id"><span class="glyphicon glyphicon-exclamation-sign"></span> 아이디</label>
			<div class="col-md-9">
				<input id="reg_mb_id" name="mb_id" class="form-control span3" maxlength="20">
				<button type="button" id="btn_id" class="btn btn-info" data-loading-text="확인 중...">중복확인</button>
				<span id="msg_mb_id"></span>
				<span class="help-block">※ 영문자, 숫자, _ 만 입력 가능. 최소 3자이상 입력하세요.</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="mb_password"><span class="glyphicon glyphicon-exclamation-sign"></span> 비밀번호</label>
			<div class="col-md-9">
				<input type="password" id="mb_password" name="mb_password" class="form-control span3" maxlength="20"> 3 ~ 20자
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="mb_password_re"><span class="glyphicon glyphicon-exclamation-sign"></span> 비밀번호 확인</label>
			<div class="col-md-9">
				<input type="password" id="mb_password_re" name="mb_password_re" class="form-control span3" maxlength="20" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="mb_name"><span class="glyphicon glyphicon-exclamation-sign"></span> 이름</label>
			<div class="col-md-9">
				<input type="text" id="mb_name" name="mb_name" class="form-control span2" maxlength="10" value="">
				공백없이 한글만 입력 가능
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="mb_hp"><span class="glyphicon glyphicon-phone"></span>휴대폰</label>
			<div class="col-md-3">
				<input type="tel" id="mb_hp" name="mb_hp" class="form-control" maxlength="14" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="reg_mb_email"><span class="glyphicon glyphicon-exclamation-sign"></span> 이메일</label>
			<div class="col-md-4">
				<div class="input-group">
					  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
					<input type="email" id="reg_mb_email" name="mb_email" class="form-control" maxlength="50">
				</div>
			</div>
			<div class="col-md-5">
				<button type="button" id="btn_email" class="btn btn-info" data-loading-text="확인 중...">중복확인</button>
				<span id="msg_mb_email"></span>
			</div>
		</div>

		<hr>
		
		<p class="text-center">
			<button type="submit" class="btn btn-lg btn-success">가입</button>
		</p>
	</fieldset>
</form>


<script type="text/javascript" src="/js/validate.js"></script>
<script type="text/javascript" src="/js/validate_reg.js"></script>
<script type="text/javascript" src="/js/validate_ext.js"></script>
<script type="text/javascript">

$(function() {
    $('#join').validate({
        onkeyup: false,
        rules: {
            mb_id: { required:true, minlength:3, reg_mb_id:true },
            mb_password: { required:true, minlength:3 },
			mb_password_re: { required:true, equalTo:'#mb_password'},
            mb_name: { required:true,  minlength:2, hangul:true },
            mb_email: { required:true,  },
        },
        messages: {
            mb_id: '아이디 확인 결과가 올바르지 않습니다.',  minlength:'최소 3자 이상 입력하세요.' ,
            mb_email: '이메일 확인 결과가 올바르지 않습니다.',
            mb_password: { required:'비밀번호를 입력하세요.', minlength:'최소 3자 이상 입력하세요.' },
			mb_password_re: { required:'비밀번호 확인을 입력하세요.', equalTo:'비밀번호가 일치하지 않습니다.' },
            mb_name: { required:'이름을 입력하세요.', minlength:'최소 2자 이상 입력하세요.' },
        }
    });
});
</script>