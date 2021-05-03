<table class="table table-hover">
	<legend>게시판</legend>
	<colgroup>
		<col width="7%"/>
		<col width="43%"/>
		<col width="17%"/>
		<col width="19%"/>
		<col width="14%"/>
	</colgroup>
	<thead>
		<tr class="active">
			<th>no</th>
			<th>제목</th>
			<th>글쓴이</th>
			<th>날짜</th>
			<th>조회수</th>
		</tr>
	</thead>
		<div class="pull-right" style = "margin-bottom:10px;">
			<span class="glyphicon glyphicon-list-alt"></span>
			Total : <?=$recordCount?><!--게시물총개수-->
		</div>
	<tbody>
		<?if(sizeof($board_list)){?>
			<?foreach($board_list as $key => $list){?>
				<tr>
				<th scope="row"><?=$list['no']?></th><!--글번호-->
					<td>
						<a href="/board/view_v/<?=$board_id?>/<?=$list['no']?>" style ="color:black;">
							<?=$list['subject']?><!--제목-->
						</a>
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
					</td>
					<td><?=$list['mb_name']?></td><!--글쓴이-->
					<td><?=substr($list['reg_date'],0,10)?></td><!--등록날짜-->
					<td><?=$list['hit']?></td><!--조회수-->
				</tr>
			<?}?>
		<?}else{?>
			<tr>
			<td colspan="6" style ="text-align:center;">등록된 글이 없습니다.</td>
			</tr>
		<?}?>
	</tbody>
</table>

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