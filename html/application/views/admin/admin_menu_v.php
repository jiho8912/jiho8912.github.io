<link rel="stylesheet" href="/static/admin/css/category.css">
<link rel="stylesheet" href="/static/admin/css/style.min.css">
<script src="/static/admin/js/jstree.js"></script>
<script>
	var $category = null;

	$(function(){

		$.jstree.defaults.checkbox.three_state = false; // 선택한 것만 체크
		$.jstree.defaults.checkbox.whole_node = false; // 선택한 것만 활성화

		$category = $(".category_list")
			.on('changed.jstree', function (e, data) {
				var sel = data.instance.get_node(data.selected[0]);

				if(sel){
					var selName = sel.text;
					var selNo = sel.id == "jRoot" ? 0 : parseInt(sel.id.replace("j",""));;
					var selShowYN = sel.li_attr.showyn;
					var selDepth = sel.parents.length - 1;

					var sel_board_id = sel.li_attr.board_id;
					var sel_type = sel.li_attr.type;
					var sel_thumb_w = sel.li_attr.thumb_w;
					var sel_thumb_h = sel.li_attr.thumb_h;
					var sel_menu_id = sel.li_attr.menu_id

					$("#addSubForm .category_name").text(selName);
					$("#categoryForm .category_name").text(selName);
					$("#categoryForm .menu_id").text(sel_menu_id);
					
					$("#categoryForm input[name='board_id']").val(sel_board_id);
					$("#categoryForm input[name='name']").val(selName);
					$("#addSubForm input[name='no']").val(selNo);
					$("#addSubForm input[name='depth']").val(selDepth + 1);
					$("#categoryForm input[name='no']").val(selNo);
					$("#categoryForm option[value='"+selShowYN+"']").prop('selected', true);
					$("#categoryForm option[value='"+sel_type+"']").prop('selected', true);
					$("#categoryForm input[name='thumb_w']").val(sel_thumb_w);
					$("#categoryForm input[name='thumb_h']").val(sel_thumb_h);
				} else {
					$("#addSubForm .category_name").text("");
					$("#categoryForm .category_name").text("");
					$("#categoryForm .menu_id").text("");
					$("#categoryForm input[name='board_id']").val("");
					$("#categoryForm input[name='name']").val("");
					$("#addSubForm input[name='no']").val(0);
					$("#addSubForm input[name='depth']").val(0);
					$("#categoryForm input[name='no']").val(0);
					$("#categoryForm .showyn option[value='Y']").prop('selected', true);
				}
			})
			.jstree({
				"core" : {				
					"check_callback" : true,
					"data" : <?=$category_list?> // 카테고리 로드
				},
				 "plugins" : ["checkbox","dnd"]
			});

		// 설정 저장
		$(".btn-save").click(function(){
			var selChecked = $category.jstree("get_checked", true);
			
			if(!selChecked.length){
				alert("카테고리를 선택해주세요.");
				return false;
			}

			if($("#categoryForm input[name='name']").val() == ""){
				alert("추가 할 카테고리 명을 입력해주세요.");
				$("#categoryForm input[name='name']").focus();
				return false;
			}

			if($("#categoryForm input[name='board_id']").val() == ""){
				alert("메뉴url을 입력해주세요.");
				$("#categoryForm input[name='board_id']").focus();
				return false;
			}

			$("#categoryForm").submit();
		});

		// 선택 카테고리 삭제
		$(".btn-del").click(function(){
			var selChecked = $category.jstree("get_checked", true);
			
			if(!selChecked.length){
				alert("카테고리를 선택해주세요.");
				return false;
			}

			for(var i=0; i<selChecked.length; i++){
				if(selChecked[i].children.length > 0){
					alert("선택한 " + selChecked[i].text + "에 하위카테고리가 있어 삭제가 불가능합니다.\r\n하위 카테고리를 삭제 후 시도해주세요.");
					return false;
				}
			}

			if(confirm("선택한 " + selChecked.length + "개의 카테고리를 삭제 하시겠습니까?")){
				var selCheckedArray = new Array();
				$(selChecked).each(function(){
					selCheckedArray.push(this.id);
				});
				$("#delForm input[name='nos']").val(selCheckedArray.join(";"));
				$("#delForm").submit();
			}
		});

		// 서브카테고리 추가
		$(".btn-addsub").click(function(){

			var ref = $category.jstree(true),
				parent = ref.get_selected();

			if(!parent.length) {
				alert("카테고리를 선택해주세요.");
				return false;
			}

			if(parent.length > 1){
				alert("카테고리는 한개만 선택해주세요.");
				return false;
			}

			if($("#addSubForm input[name='name']").val() == ""){
				alert("추가 할 카테고리 명을 입력해주세요.");
				return false;
			}
			
			if($category.jstree('get_node', $category.jstree('get_selected')).parents.length > 3){
				alert("더이상 카테고리를 추가할 수 없습니다.");
				$("#addSubForm input[name='name']").val("");
				return false;
			}

			$("#addSubForm").submit();
		});
	});
	var a; 
</script>
<div class="col-md-9">
<h3 style = "font-size:24px !important;">메뉴관리</h3><br>
	<div class="category_wrap" style="margin-top:10px;">
		<div class="category_list_wrap" style="float:left;width:368px;margin-right:10px;">
			<div  style="display:inline-block;width:100%;height:100%;">
				<form id="delForm" method="post" action="/admin/menu/category_delete">
					<input type="hidden" class="nos" name="nos" value="" />
					<input type="hidden" class="type" name="type" value="<?=$type?>" />
					<div class="category_list" style="border:1px solid silver;">
						<ul>
							<li data-jstree='{ "opened" : true }'>전체 카테고리
							</li>
						</ul>
					</div>

				<div class="btn-group pull-right" style = "margin-top:10px;">
					<div class="btn-group">				
						<div class="right">
							<a href="#" class="btn-del btn btn-mini btn-danger">선택한 카테고리를 삭제</a>
						</div>
					</div>
				</div>

				</form>
			</div>
		</div>

		<div class="category_setting" style="float:left;width:338px;min-height:400px;">
			
			<div>
				<form id="addSubForm" method="post" action="/admin/menu/subCategory_save">
					<input type="hidden" class="no" name="no" value="" />
					<input type="hidden" name="depth" value="" />
					<input type="hidden" name="type" value="<?=$type?>" />
					<table summary="서브 카테고리 추가" class="table table-bordered" style="margin-bottom:10px !important; >
						<colgroup>
							<col width="120px;"/>
							<col />
						</colgroup>
						<thead>
							<tr>
								<th colspan="2">서브 카테고리 추가</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th>현재선택 카테고리</th>
								<td><span class="category_name"></span></td>
							</tr>
							<tr>
								<th>추가 할 카테고리 명</th>
								<td>
									<input  class = "form-control" type="text" class="sub_name" name="name" />
								</td>
							</tr>
						</tbody>
					</table>
					<div class="btn-group pull-right" style="margin-bottom:10px;">
						<div class="btn-group">
							<div class="right">
								<a href="#" class="btn-addsub btn btn-mini btn-info">카테고리 추가</a>
							</div>
						</div>
					</div>
				</form>
			</div>

			<!-- 카테고리 설정 변경 -->
			<div>
				<form id="categoryForm" method="post" action="/admin/menu/category_save">
					<input type="hidden" class="no" name="no" value="" />
					<table class="table table-bordered" style="margin-bottom:10px !important;">
						<colgroup>
							<col width="120px;"/>
							<col />
						</colgroup>
						<thead>
							<tr>
								<th colspan="2">카테고리 설정 변경</th>
							</tr>
						</thead>
						<tbody>
						<tr>
							<th>현재선택 카테고리</th>
								<td><span class="category_name"></span></td>
							</tr>
							<th>메뉴 ID</th>
								<td><span class="menu_id"></span></td>
							</tr>
							<tr>
								<th>이름</th>
								<td><input class = "form-control" type="text" name="name" value=""/></td>
							</tr>
							<tr>
								<th>메뉴url</th>
								<td><input class = "form-control" type="text" name="board_id" value=""/></td>
							</tr>
							<tr>
								<th>타입</th>
								<td>
									<select class="form-control" name="type">
										<option value="L">리스트형</option>
										<option value="G">갤러리형</option>
										<option value="A">앨범형</option>
										<option value="P">플러그인</option>
									</select>
								</td>
							</tr>
							<tr>
								<th>사용여부</th>
								<td>
									<select class="form-control" name="showyn">
										<option value="Y">Y</option>
										<option value="N">N</option>
									</select>
								</td>
							</tr>
							<tr>
								<th>썸네일 가로 크기</th>
								<td><input class = "form-control" type="text" name="thumb_w" value="" placeholder = "숫자만 입력하세요"/></td>
							</tr>
							<tr>
								<th>썸네일 세로 크기</th>
								<td><input class = "form-control" type="text" name="thumb_h" value="" placeholder = "숫자만 입력하세요"/></td>
							</tr>
						</tbody>
					</table>
					<div class="btn-group pull-right" style="margin-bottom:10px !important;">
						<div class="btn-group">
							<div class="right">
								<a href="#" class="btn-save btn btn-mini btn-info">카테고리 저장</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

