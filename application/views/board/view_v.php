<style>
.sect{margin-right:15px;}
.share_btn { cursor: pointer; }
</style>
<!-- 게시판 상세내용 시작 -->
<legend>게시판</legend>
<legend style = "font-weight:bold"><?=$board_detail['subject']?></legend>

<p class="text-right">
	<span class="glyphicon glyphicon-user"></span>
		<?=$board_detail['mb_name']?><!-- 글쓴이 --->
	<span class="sect"></span>
	<span class="glyphicon glyphicon-time"></span>
		<?=$board_detail['reg_date']?><!-- 등록날짜 --->
	<span class="sect"></span>
	<span class="glyphicon glyphicon-comment"></span>
		<?=$this->board_m->comment_count($board_detail['no'])?><!-- 댓글수 --->
	<span class="sect"></span>
	<span class="glyphicon glyphicon-bell"></span>
		<?=$board_detail['hit']?><!-- 조회수 --->
	<span class="sect"></span>
	<?if($board_detail['mb_email']){?>
		<span class="glyphicon glyphicon-envelope"></span>
			<?=$board_detail['mb_email']?><!-- 이메일 --->
		<span class="sect"></span>
	<?}?>
</p>
<hr>
<div id ="contents">
	<?=$board_detail['contents']?>
</div>
<!-- 게시판 상세내용 종료 -->

<!-- sns 버튼 시작 -->
<div class="sns_button">
	<!--페이스북 공유-->
	<img src="<?=board_Img_dir?>/icon/social_facebook.png" width="22" height="22" onclick="sns_share('fb')" class="share_btn">

	<!--트위터 공유-->
	<img src="<?=board_Img_dir?>/icon/social_twitter.png" width="22" height="22"onclick="sns_share('tw')" class="share_btn">

	<!--카카오스토리 공유-->
	<img src="<?=board_Img_dir?>/icon/social_kakao.png" width="22" height="22"onclick="sns_share('ks')" class="share_btn">

	<img src="<?=board_Img_dir?>/icon/social_google.png" width="22" height="22"onclick="sns_share('')" class="share_btn">
	
	<img src="<?=board_Img_dir?>/icon/social_naver.png" width="22" height="22"onclick="sns_share('')" class="share_btn">

</div>
<!-- sns 버튼 종료 -->

<!-- 댓글 리스트 시작 -->
<hr>
<?foreach($comment_list as $key => $list){?>
<tr>
	<td style="word-break: break-all;">
		<div style="float:left">
			<span class="comment_name"><?=$list['name']?></span>
				<!--신규글 아이콘 시작-->
				<?
					if((strtotime($list['reg_date'])+86400)>=time()) {
						echo '<img src='.board_Img_dir.'/icon/new_comment.gif width="16" height="11" alt="new">';
					}
				?>
				<!--신규글 아이콘 종료-->
			<span class="sect"></span>
			<span class="glyphicon glyphicon-time"></span>
			<span><?=$list['reg_date']?></span>
		<!--로그인상태에서만 댓글쓰기 및 수정 삭제 버튼 노출-->
		<?if($this->session->userdata('mb_id')){?>
			<!--본인이 작성한 댓글일때만 수정 삭제 버튼 노출-->
			<?if($this->session->userdata('mb_id') == $list['id']){?>
				<a id ="update_reply_<?=$list['no']?>" class="btn btn-success btn-sm" alt="<?=$list['no']?>" value="<?=$list['contents']?>">수정</a>
				<a id="delete-comment_<?=$list['no']?>" class="btn btn-danger btn-sm" value="<?=$list['no']?>">삭제</a>
			<?}?>
		<?}?>


		</div>
		<div style="float:right">
		</div>
		<div style="clear:both"></div>
		<div id="" class="comment_contents" style="padding-top:5px">
			<?if($list['is_secret']=="Y" and $list['id'] != $this->session->userdata('mb_id')){?>
				<img src="<?=board_Img_dir?>/icon/icon_secret.gif" width="11" height="11">
				비밀글 입니다.<hr>
			<?}elseif($list['is_secret']=="N"){?>
				<?=$list['contents']?><hr>
			<?}else{?>
				<?=$list['contents']?><hr>
			<?}?>
		</div>
	</td>
</tr>
<?}?>
<!-- 댓글 리스트 종료 -->

<!-- 댓글 등록 시작 -->
<div id="comment_write_box">
	<div class="well comment_write_box_inner">
		<form action="/board/write_comment" name="w_comment" id="w_comment" method="post" accept-charset="utf-8" novalidate="novalidate">
		<input type = "hidden" name = "content_no" id = "content_no" value ="<?=$board_detail['no']?>">
		<input type = "hidden" id ="comment_no" name = "comment_no" value = "">
		<input type = "hidden" name = "board_id" value = "<?=$board_id?>">
			<textarea class="form-control" name="cmt_contents" id="cmt_contents" rows="5" ></textarea>
		<div class="comment_write_button_area">
			<div id="write_comment_div" class="form-group pull-left">
				<button type="button" class="btn btn-danger btn-sm" id="write_comment">댓글등록</button>
			</div>

			<div id="update_comment_div" class="form-group pull-left" style ="display:none;">
				<button type="button" class="btn btn-primary btn-sm" id="update_comment">댓글수정</button>
				<button type="button" class="btn btn-danger btn-sm" id="update_cancel">취소</button>
			</div>

			<div class="btn-group pull-right">
				<div class="checkbox pull-left mr10">
					<label for="is_secret">
						<input type="checkbox" name="is_secret" id="is_secret" value="Y">비밀글
					</label>
				</div>
			</div>
		</div>
		</form>
	</div>
</div>
<!-- 댓글 등록 종료 -->

<div class="border_button mt20 mb70">
	<div class="btn-group pull-left">
		<a href="/board/list_v/<?=$board_id?>" class="btn btn-default btn-sm">목록</a>
		<a href="/board/view_v/<?=$board_id?>/<?=@$select_pre_no['no']?>" class="btn btn-default btn-sm"  title ="<?=@$select_pre_no['no']?>">
		이전글
		</a>
		<a href="/board/view_v/<?=$board_id?>/<?=@$select_next_no['no']?>" class="btn btn-default btn-sm" title ="<?=@$select_next_no['no']?>">
		다음글</a>
	</div>
	<div class="btn-group pull-right">
		<!--로그인상태에서만 글쓰기 및 수정 삭제 버튼 노출-->
		<?if($this->session->userdata('mb_id')){?>
			<a href="/board/write_v/<?=$board_id?>" class="btn btn-primary btn-sm">글쓰기</a>
			<!--본인이 작성한 글일때만 수정 삭제 버튼 노출-->
			<?if($this->session->userdata('mb_id') == $board_detail['mb_id']){?>
				<a href="/board/update_v/<?=$board_id?>/<?=$board_detail['no']?>" class="btn btn-success btn-sm">수정</a>
				<a id="delete-contents" class="btn btn-danger btn-sm">삭제</a>
			<?}?>
		<?}?>
	</div>
</div>

<script type="text/javascript">

$(function() {

	$("#write_comment").click(function(){
		var result = confirm('등록하시겠습니까?');

		if(result) {
			$("#w_comment").submit();
		} else {
			//no
		}
	});

	//댓글 수정
	$("[id*='update_reply_']").each(function(){
		$(this).click(function(){
			var no = $(this).attr("alt"); //댓글번호 가져오기
			var contents = $(this).attr("value");//댓글내용 가져오기
			$("#comment_no").val(no); 
			$("#cmt_contents").val(contents);
			$("#write_comment_div").hide(); //댓글입력 div숨김
			$("#update_comment_div").show(); //댓글수정 div보이기
		});
	});

	//댓글 수정 등록
	$("#update_comment").click(function(){
		var result = confirm('수정하시겠습니까?');

		if(result) {
			$("#w_comment").attr("action","/board/update_comment");
			$("#w_comment").submit();
		} else {
			//no
		}
	});

	//댓글 수정 취소
	$("#update_cancel").click(function(){
		$("#update_comment_div").hide();
		$("#write_comment_div").show();
		$("#cmt_contents").val("");
	});

	//댓글삭제
	$("[id*='delete-comment_']").each(function(){
		$(this).click(function(){
			var no = $(this).attr("value");//댓글번호 가져오기
			var result = confirm('삭제하시겠습니까?');

			if(result) {
				location.replace("/board/delete_comment/<?=$board_id?>/<?=$board_detail['no']?>/"+no);
			} else {
				//no
			}
		});
	});

	//글삭제
	$("#delete-contents").click(function(){
		var result = confirm('삭제하시겠습니까?');

		if(result) {
			location.replace("/board/delete/<?=$board_id?>/<?=$board_detail['no']?>/<?=$board_detail['contents_no']?>");
		} else {
			//no
		}
	});
});
</script>