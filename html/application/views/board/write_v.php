<form id="write" class="form-horizontal" name="write" method="post" action="/board/write" novalidate="novalidate">
<input type="hidden" name="contents_no" id="contents_no" value="<?=$contents_no?>"/>
<input type = "hidden" name = "menu_id" value = "<?=$menu_id['no']?>">
<input type = "hidden" name = "board_id" value = "<?=$board_id?>">
	<legend>글쓰기</legend>
	<div class="form-group">
		<label class="col-md-3 control-label" for="mb_name"><span class="glyphicon glyphicon-exclamation-sign"></span> 이름</label>
		<div class="col-md-4">
			<input type="text" id="mb_name" name="mb_name" class="form-control" maxlength="20" value="<?=$mb_detail['mb_name']?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="mb_email"></span> 이메일</label>
		<div class="col-md-4">
			<div class="input-group">
				  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
				<input type="email" id="mb_email" name="mb_email" class="form-control" maxlength="50" value="<?=$mb_detail['mb_email']?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3 control-label" for="subject"><span class="glyphicon glyphicon-exclamation-sign"></span> 제목</label>
		<div class="col-md-7">
			<input type="text" id="subject" name="subject" class="form-control" maxlength="20" value="">
		</div>
	</div>

	<div class="form-group">
		<textarea name="contents" id="contents" rows="15" cols="138"></textarea>
	</div>

<p class="text-center">
		<button type="submit" id="write_form" class="btn btn-lg btn-primary btn-mm" data-loading-text="등록 중..."></span> 글쓰기</button>&nbsp;&nbsp;&nbsp;
		<button type = "button" class="btn btn-lg btn-default btn-mm" onClick="location.href = '/board/list_v/<?=$board_id?>'" >목록</button>
		
	</p>
</form>

<script type="text/javascript" src="/js/validate.js"></script>
<script type="text/javascript" src="/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "contents",
	sSkinURI: "/smarteditor/SmartEditor2Skin.html",
	fCreator: "createSEditor2"
});

function submitContents(elClickedObj) {
	// 에디터의 내용이 textarea에 적용된다.
	oEditors.getById["contents"].exec("UPDATE_CONTENTS_FIELD", []);

	// 에디터의 내용에 대한 값 검증은 이곳에서
	// document.getElementById("contents").value를 이용해서 처리한다.
	/*
	if($("#ir1").val()=="<p>&nbsp;</p>"){
		alert("내용을 입력해주세요");
		return false;
	}
	*/

	try {
		elClickedObj.form.submit();
	} catch(e) {}
}

</script>
<script type="text/javascript">

$(document).ready(function() {
	$('#write').validate({
		onkeyup: false,
		rules: {
			mb_name: { required:true, maxlength:5 },
			subject: { required:true, minlength:2 },
			contents: { required:true},
		},
		messages: {
			mb_name: { required:'이름을 입력하세요.' },
			subject: { required:'제목을 입력하세요.', minlength:'최소 2자 이상 입력하세요.' },
			contents: { required:'내용을 입력하세요.'},
		}
	});

	$('#write_form').click(function(){
		submitContents();
	});

});
</script>