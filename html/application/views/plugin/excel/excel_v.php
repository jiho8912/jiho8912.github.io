<link rel="stylesheet" href="<?=plugin_dir?>/excel/css/excel.css" type="text/css" />
<div id="booksearch">
	<form action="/plugin/excel/index" name="searchForm" id="searchForm" method="post">
		<div class="sch_area">
			<span class="sel_box">
				<select id="searchKey" name="searchKey" >
					<option value="book_name" <?php if(@$searchKey == 'book_name' || @$searchKey == '') { echo 'selected'; }?>>책제목</option>
					<option value="writer" <?php if(@$searchKey == 'writer') { echo 'selected'; }?>>저자</option>
				</select>
			</span>

			<span class="inp_box">
				<input type="text" id="searchValue" name="searchValue" value="<?=@$searchValue?>" class="inp_sch"/>
				<span class="inp_btn" id = "search"></span>
			</span>
		</div>

		<ul class="book_list">
			<? if(sizeof($result)){
				  foreach($result as $list){
			?>
				<li>
					<h3 class="book_tit"><?=$list['book_name']?></h3>
					<p>
						<span>분류 : <i class="book_cat"><?=$list['kind']?></i></span>
						<span>권수 : <i class="book_vol"><?=$list['book_count']?>권</i></span>
						<span>저자 : <i class="book_aut"><?=$list['writer']?></i></span>
					</p>
					<p>
						<span>책장번호 : <i class="book_aut"><?=$list['position']?></i></span> 
					</p>
				</li>
				<?}?>
			<?}else{?>
				<li>
					<p>
						<span>등록된 리스트가 없습니다.</span> 
					</p>
				</li>
			<?}?>
		</ul>
	</form>
</div>
<div><?=$paging?></div>

<script>

	$(function() {

		$("#search").click(function() {
			$("#searchForm").submit();
		});

	});
</script>