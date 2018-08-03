

<legend>게시판</legend>
<div class="panel panel-default">
	<div class="panel-body row">
		<?if(sizeof($board_list)){?>
			<?foreach($board_list as $key => $list){?>
			<div class="col-sm-3 col-xs-6 gallery-body">
				<div class="thumbnail">
					<a href="/board/view_v/<?=$board_id?>/<?=$list['no']?>" title="">
						<?if(isset($list['file_name'])){?>
							<img src="<?=$list['file_name']?>" class="img-rounded img-responsive center-block" style="width:500px;">
						<?}?>
					</a>
					<div class="caption">
						<p>
							<?=$list['subject']?>

							<!--신규글 아이콘 시작-->
							<?
								if((strtotime($list['reg_date'])+86400)>=time()) {
									echo '<img src='.board_Img_dir.'/icon/new_comment.gif width="16" height="11" alt="new">';
								}
							?>
							<!--신규글 아이콘 종료-->
							<!--댓글 아이콘 시작-->
							<?
								if(!$this->board_m->comment_count($list['no']) == 0){?>
								<span class="comment_count label label-default">
									<?=$this->board_m->comment_count($list['no'])?>
								</span> 
							<?
								}
							?>
							<!--댓글 아이콘 종료-->
						</p>
					</div>
				</div>
			</div>
			<?}?>
		<?}else{?>
			등록된 글이 없습니다.
		<?}?>
	</div>
</div>


<div class="clearfix">
	<span class="btn-group mb50"></span>
	<div class="pull-right">
		<?if($this->session->userdata('mb_id')){?>
			<a href="/board/write_v/<?=$board_id?>">
				<button type="button" class="btn btn-primary btn-sm" id ="">글쓰기</button>
			</a>
		<?}?>
	</div>
</div>

<form name="searchForm" method="post" action="/board/list_v/<?=$board_id?>">
	<div class="clearfix">
		<select name="searchKey" id="searchKey" class="form-control input-sm auto pull-left">
			<option value="subject">제목</option>
			<option value="contents">내용</option>
			<option value="subject.contents">제목+내용</option>
			<option value="mb_name">글쓴이</option>
		</select>
		<div class="span4 pull-left">
			<div class="input-group">
				<input name="searchValue" class="form-control input-sm" maxlength="15" value="<?=@$searchValue?>">
				<span class="input-group-btn">
					<button type="submit" class="btn btn-sm btn-primary">검색</button>
				</span>
			</div>
		</div>

		<div class="pull-right">
			<?=@$paging?>
		</div>
	</div>
</form>
<script>
$(document).ready(function() {
	//검색어 유지
	var searchKey = "<?=@$searchKey?>";

	$("#searchKey option").each(function(){
		var val = $(this).val();
		if(searchKey == $(this).val()){
			$(this).attr("selected",true);
		}
	});
});
</script>