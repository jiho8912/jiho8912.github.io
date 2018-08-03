<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
	$(function(){

		var tab1 = <?=$tab1?>;
		var tab2 = <?=$tab2?>;
		var tab3 = <?=$tab3?>;
		var tab4 = <?=$tab4?>;
		var tab5 = <?=$tab5?>;
		var listcount = <?=$listcount?>;
		var rowcount = <?=@$rowcount?>;
		var image_space = <?=@$image_space?>;

		$("#tab1 option[value='"+tab1+"']").prop('selected', true);
		$("#tab2 option[value='"+tab2+"']").prop('selected', true);
		$("#tab3 option[value='"+tab3+"']").prop('selected', true);
		$("#tab4 option[value='"+tab4+"']").prop('selected', true);
		$("#tab5 option[value='"+tab5+"']").prop('selected', true);
		$("#listcount option[value='"+listcount+"']").prop('selected', true);
		$("#rowcount option[value='"+rowcount+"']").prop('selected', true);
		$("#image_space option[value='"+image_space+"']").prop('selected', true);

		//위로 & 아래로 클릭
		$( "[name^='btn_up_down_']" ).each(function(index){
			$(this).click(function(){

				$("#img_sort").val("");
				$("#img_sort").val($(this).attr("title"));

				if($(this).attr("alt") == 'up')
				{
					$("#img_up_down").val("up");
				}else if($(this).attr("alt") == 'down'){
					$("#img_up_down").val("down");
				}else{ //예외처리
					$("#img_up_down").val("up");
				}

				$.post("/admin/main/img_up_down",
					{
						ajax : true,
						img_up_down : $("#img_up_down").val(),
						img_sort : $("#img_sort").val(),
					},

				function(data){
					alert(data.message);
					if(data) window.location.reload();
				});
			});
		});

		// 선택 이미지 삭제
		$(".btn-del").click(function(){
			if($("input[name='no[]']:checked").length){
				if(confirm("삭제하시겠습니까?")){
					$("#main_setting_form").attr("action","/admin/main/background_img_del");
					$('#main_setting_form').submit();
				}else{
					return false;
				}
			}else{
				alert("하나 이상 선택하여야 합니다.");
				return false;
			}
		});

		// 설정 저장
		$(".btn-save").click(function(){

			$("#main_setting_form").submit();
		});
	});

	// 주소검색
	function openDaumPostcode() {
		new daum.Postcode({
			oncomplete: function(data) {

				// 각 주소의 노출 규칙에 따라 주소를 조합한다.
				// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
				var fullAddr = ''; // 최종 주소 변수
				var extraAddr = ''; // 조합형 주소 변수

					// 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
				if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
					fullAddr = data.jibunAddress;

				} else { // 사용자가 지번 주소를 선택했을 경우(J)
					fullAddr = data.jibunAddress;
				}

				// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
				// 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.

				document.getElementById('addr').value = fullAddr;

				//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
				//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
				//var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
				//document.getElementById('addr').value = addr;

				document.getElementById('addr2').focus();
			}
		}).open();
	}

</script>
<style>
.center {text-align:center !important; vertical-align:middle !important;}
</style>
<div class="col-md-9">
	<h3>메인설정</h3>

	<!-- 메인 메뉴 설정 -->
	<div style="margin-top:30px !important;">
		<form id="main_setting_form" method="post" enctype="multipart/form-data" action="/admin/main/main_setting_save">
			<input type = "hidden" id = "img_sort" name = "img_sort" value = "">
			<!-- 순서변경을 위해-->
			<input type = "hidden" id = "img_up_down" name = "img_up_down" value = "">
			<input type="hidden" name="contents_no" id="contents_no" value="<?=$contents_no?>"/>
			<input type="hidden" class="no" name="no"/>
			<table class="table table-bordered" style="margin-bottom:10px !important;">
				<colgroup>
					<col width="120px;"/>
					<col width="100px;"/>
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="2">메인 로테이션 이미지 설정</th>
					</tr>
					<tr>
						<th>이미지 업로드</th>
						<td>
							<span class="btn btn-default btn-file"><input type="hidden"><input type="file" multiple="" name ="userfile"></span>
							<span class="fileinput-filename"></span><span class="fileinput-new">
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-bordered" style="margin-bottom:10px !important;">
				<colgroup>
					<col width="80px;"/>
					<col width="350px;"/>
					<col width="400px;"/>
					<col width="100px;"/>
				</colgroup>
				<tbody class = "center">
					<tr>
						<th class ="center">선택</th>
						<th class ="center">이미지</th>
						<th class ="center">이미지명</th>
						<th class ="center">출력순서</th>
					</tr>

					<?if(sizeof($main_back_img)){?>
						<?foreach($main_back_img as $list){?>
							<tr>
								<td class ="center"><input type="checkbox" name="no[]" value="<?=$list['no']?>"></td>
								<td class ="center">
									<img src="/upload/main/<?=$list['original_name']?>" width="100" height="50" class="img-rounded img-responsive center-block">
								</td>
								<td class ="center"><?=$list['file_name']?></td>
								<td class ="center">
									<div style="margin-bottom:10px; margin-top:5px;">
										<a id = "btn_up_down_<?=@$list['contents_no']?>" name = "btn_up_down_<?=@$list['contents_no']?>" class="top_sm_btn" title="<?=$list['contents_no']?>" alt = "up">
										<span class="top_arrow_con">▲</span>위로</a>
									</div>
									<div style="margin-bottom:10px; margin-top:10px; ">
										<a id = "btn_up_down_<?=@$list['contents_no']?>" name = "btn_up_down_<?=@$list['contents_no']?>" title="<?=$list['contents_no']?>" alt = "down" class="down_sm_btn"><span class="down_arrow_con">▼</span>아래로</a>
									</div>
								</td>
							</tr>
						<?}?>
					<?}else{?>
						<tr>
							<tr>
								<td colspan="4" style ="color:red;">
									등록된 이미지가 없습니다.
								</td>
							</tr>
						</tr>
					<?}?>
				</tbody>
			</table>

			<div class="btn-group pull-right" style = "margin-bottom:10px;">
				<div class="btn-group">				
					<div class="right">
						<a href="#" class="btn-del btn btn-mini btn-danger">삭제</a>
					</div>
				</div>
			</div>

			<table class="table table-bordered" style="margin-bottom:10px !important;">
				<colgroup>
					<col width="120px;"/>
					<col width="100px;"/>
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="5">3탭 게시판 설정</th>
					</tr>
					<tr>
						<th>첫번째탭</th>
						<td>
							<select class="form-control" name="tab1" id ="tab1">
								<?foreach($board_list as $list){?>
									<option value="<?=$list['no']?>"><?=$list['category_name']?></option>
								<?}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>두번째탭</th>
						<td>
							<select class="form-control" name="tab2" id ="tab2">
								<?foreach($board_list as $list){?>
									<option value="<?=$list['no']?>"><?=$list['category_name']?></option>
								<?}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>세번째탭</th>
						<td>
							<select class="form-control" name="tab3" id ="tab3">
								<?foreach($board_list as $list){?>
									<option value="<?=$list['no']?>"><?=$list['category_name']?></option>
								<?}?>
							</select>
						</td>
					</tr>
					<tr>
						<th>노출개수</th>
						<td>
							<input class = "form-control" type="text" name="tab_limit" value="<?=$tab_limit?>" placeholder="숫자만 입력하세요">
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-bordered" style="margin-bottom:10px !important;">
				<colgroup>
					<col width="120px;"/>
					<col width="100px;"/>
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="2">메인 노출 게시판<br>설정</th>
					</tr>
					<tr>
						<th>노출게시판</th>
						<td>
							<select class="form-control" name="tab4" id ="tab4">
								<?foreach($board_list as $list){?>
									<option value="<?=$list['no']?>"><?=$list['category_name']?></option>
								<?}?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-bordered" style="margin-bottom:10px !important;">
				<colgroup>
					<col width="120px;"/>
					<col width="100px;"/>
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="2">메인 갤러리 노출<br>설정</th>
					</tr>
					<tr>
						<th>노출게시판</th>
						<td>
							<select class="form-control" name="tab5" id ="tab5">
								<?foreach($gallery_board_list as $list){?>
									<option value="<?=$list['no']?>"><?=$list['category_name']?></option>
								<?}?>
							</select>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-bordered" style="margin-bottom:10px !important;">
				<colgroup>
					<col width="120px;"/>
					<col width="100px;"/>
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="2">구글맵 api 설정</th>
					</tr>
					<tr>
						<th>노출될 주소</th>
						<td>
							<a class="btn btn-mini btn-info" onclick="openDaumPostcode()" style="margin-bottom:10px !important;">주소찾기</a>
							<p>
								<input class="form-control" type="text" id="google_apikey" name="google_apikey" value="<?=@$google_apikey?>" title="api key" />
								api key
							</p>
							<p>
								<input class="form-control" type="text" id="addr" name="addr" value="<?=@$addr?>" title="기본 주소" />
								기본주소
							</p>
							<p>
								<input class="form-control" type="text" id="addr2" name="addr2" value="<?=@$addr2?>" title="나머지 주소" />
								나머지주소
							</p>
						</td>
					</tr>
				</tbody>
			</table>

			<table class="table table-bordered" style="margin-bottom:10px !important;">
				<colgroup>
					<col width="120px;"/>
					<col width="100px;"/>
					<col />
				</colgroup>
				<tbody>
					<tr>
						<th rowspan="2">인스타그램 api 설정</th>
					</tr>
					<tr>
						<th>세부설정</th>
						<td>
							<p>
								<input type="text" name="tokenvalue" id="tokenvalue" value="<?=@$tokenvalue?>" class="form-control">
								token value
								<div class="check_tokenvlaue"></div>
							</p>
							<p>
								<select class = "form-control" id = "listcount" name = "listcount">
									<? for($i=1; $i<=20; $i++){?>
										<option value = "<?=$i?>"><?=$i?></option>
									<?}?>
								</select>
								노출개수
							</p>
							<p>
								<select class = "form-control" id = "rowcount" name = "rowcount">
									<? for($i=2; $i<=5; $i++){?>
										<option value = "<?=$i?>"><?=$i?></option>
									<?}?>
								</select>
								열의 개수
							</p>
							<p>
								<select class = "form-control" id = "image_space" name = "image_space">
									<? for($i=1; $i<=20; $i++){?>
										<option value = "<?=$i?>"><?=$i?></option>
									<?}?>
								</select>
								이미지 간격
							</p>
						</td>
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
