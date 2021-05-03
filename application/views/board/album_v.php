<div class="row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;"><style type="text/css">
.caption {height:46px; overflow:hidden;}
.width-full {width:100%;}
</style>
	<div class="col-md-6 width-full">
		<div class="panel panel-default">
			<div class="panel-body row">
				<?if(sizeof($board_list)){?>
					<?foreach($board_list as $key => $list){?>
						<div class="col-sm-3 col-xs-6 gallery-body">

							<div class="thumbnail">
								<a href="/board/view_v/<?=$board_id?>/<?=$list['no']?>">
									<img src="<?=$list['file_name']?>" class="img-rounded img-responsive center-block" >
								</a>
								<div class="caption">
									<p>
										<?=$list['subject']?>
									</p>
								</div>
							</div>

						</div>
					<?}?>
				<?}else{?>
					<tr>
						<td colspan="6" style ="text-align:center;">
							등록된 글이 없습니다.
						</td>
					</tr>
				<?}?>
			</div>
		</div>
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
	<div class="clearfix" style = "margin-bottom:20px;">
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