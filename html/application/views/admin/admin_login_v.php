<div class="col-md-12" style = "padding-bottom:50px;">
	<form id="flogin" class="form-horizontal" name="flogin" method="post" action="/admin/management/admin_login" novalidate="novalidate">
		<legend>관리자 로그인</legend>
		
		<div class="form-group">
			<label class="col-md-3 control-label" for="mb_id">아이디</label>
			<div class="col-md-9">
				<input type="text" id="mb_id" name="mb_id" class="form-control span3" maxlength="20" value="">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label" for="mb_password">비밀번호</label>
			<div class="col-md-9">
				<input type="password" id="mb_password" name="mb_password" class="form-control span3" maxlength="20">
				<button type="submit" class="btn btn-primary">로그인</button>
			</div>
		</div>
	</form>
</div>
