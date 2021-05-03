<div class="col-md-9">
	<form id="reg_schedule" class="form-horizontal" name="write" method="post" action="/admin/calender/reg_scheule" novalidate="novalidate">
	<input type = "hidden" name = "date" value = "<?=$year?>-<?=$month?>-<?=$day?>"/>
	<input type = "hidden" name = "no" value = "<?=$no?>"/>
		<legend>일정등록</legend>
		<div class="form-group">
			<label class="col-md-3 control-label"><span class="glyphicon glyphicon-exclamation-sign"></span> 날짜</label>
			<div class="col-md-9">
				<p class="form-control-static">
					<?=$year;?>년 <?=$month;?>월 <?=$day;?>일
				</p>
			</div>
		</div>

		<div class="form-group">
			<label class="col-md-3 control-label"><span class="glyphicon glyphicon-exclamation-sign"></span> 제목</label>
			<div class="col-md-4">
				<input type="text" id="subject" name="subject" class="form-control" maxlength="20" value="<?=@$schedule_detail['subject']?>">
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 control-label"><span class="glyphicon glyphicon-exclamation-sign"></span> 내용</label>
			<div class="col-md-7">
				<input type="text" id="contents" name="contents" class="form-control" maxlength="20" value="<?=@$schedule_detail['contents']?>">
			</div>
		</div>
	<p class="text-center">
			<button type="submit" id="write_form" class="btn btn-lg btn-primary btn-mm" data-loading-text="등록 중..."></span> 글쓰기</button>&nbsp;&nbsp;&nbsp;
			<button type = "button" class="btn btn-lg btn-default btn-mm" onClick="location.href = '/admin/calender/admin_calender_v'" >달력보기</button>
		</p>
	</form>
</div>

<script type="text/javascript" src="/js/validate.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	$('#reg_schedule').validate({
		onkeyup: false,
		rules: {
			subject: { required:true, maxlength:20 },
			contents: { required:true, minlength:2 },
			//contents: { required:true},
		},
		messages: {
			subject: { required:'제목을 입력하세요.' },
			contents: { required:'내용을 입력하세요.', minlength:'최소 2자 이상 입력하세요.' },
			//contents: { required:'내용을 입력하세요.'},
		}
	});

	$('#write_form').click(function(){
		$("#w_comment").submit();
	});

});
</script>