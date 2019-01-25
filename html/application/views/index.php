1234444
<div class="row carousel-holder">
	<div class="col-md-12" style = "margin-bottom:10px;">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<?if(sizeof($main_back_img)){?>
					<?foreach($main_back_img as $key => $list){?>
						<li data-target="#carousel-example-generic" data-slide-to="<?=$key?>" class="<?if($key == 0){?> active <?}?>"></li>
					<?}?>
				<?}else{?>
					등록된 이미지가 없습니다.
				<?}?>
			</ol>
			<div class="carousel-inner">
				<?if(sizeof($main_back_img)){?>
					<?foreach($main_back_img as $key => $list){?>
						<div class="item <?if($key == 0){?> active <?}?>">
							<img class="img-rounded img-responsive center-block" style = "width:1000px; height:auto;" src="/upload/main/<?=$list['original_name']?>" alt="">
						</div>
					<?}?>
				<?}else{?>
					등록된 이미지가 없습니다.
				<?}?>
			</div>
			<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
				<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
				<span class="glyphicon glyphicon-chevron-right"></span>
			</a>
		</div>
	</div>

</div>

<div class="row" style ="font-family:나눔고딕;">
	<!--메인 노출 게시판(3탭) 시작-->
	<div class="col-md-6">
		<div class="board-row pull-left">

			<div class="latest_main_title">

				<span class = "board_name">
					<?foreach($main_tab_board_data as $key => $main_board_list){?>
						<span id = "board_name_<?=$key+1?>" alt = "<?=$main_board_list['board_id']?>" style ="color:gray;">
							<?=$main_board_list['category_name']?>
						</span>
						<?if($key != 2){?>
							|
						<?}?>
					<?}?>
				</span>

				<div class="pull-right">
					<a href="/board/list_v/" id="more">
						더보기
					</a>
				</div>
			</div>

			<table class="table table-hover">
				<tbody>
					<?if(sizeof($main_tab_board_data)){?>
						<? $Count = 0;?>
						<?foreach($main_tab_board_data as $key => $main_board_list){?>
							<?$Count++;?>
							<?foreach($main_board_list['board_data'] as $key => $list){?>
								<tr id = "board_content_<?=$Count?>">
									<?if($list['subject'] == 'no_contents'){?>
										<td>
											등록된 글이 없습니다.
										</td>
									<?}else{?>
										<td>
											<a href="/board/view_v/<?=$main_board_list['board_id']?>/<?=$list['no']?>">
												<?=$list['subject']?>
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
												<span class="pull-right">
													<span class="comment_count label label-default">
														<?=$this->board_m->comment_count($list['no'])?>
													</span>
												</span>
											<?
												}
											?>
											<!--댓글 아이콘 종료-->
										</td>
										<td class="px50">
											<?=substr($list['reg_date'],5,6)?>
										</td>
									<?}?>
								</tr>
							<?}?>
						<?}?>
					<?}else{?>
						<tr>
							<td>
						등록된 글이 없습니다.
							</td>
						</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
	<!--메인 노출 게시판(3탭) 종료-->
	<!--메인 노출 게시판 시작-->
	<div class="col-md-6" style = "margin-bottom:20px;">
		<div class="board-row pull-left">

			<div class="latest_main_title">

				<span class = "board_name">
					<span id = "new_content">
						<?=$main_board_1['category_name']?>
					</span>
				</span>

				<div class="pull-right">
					<a href="/board/list_v/<?=$main_board_1['board_id']?>" title="일반게시판">
						더보기
					</a>
				</div>
			</div>

			<table class="table table-hover">
				<tbody>
					<?if(sizeof($main_board_data_1)){?>
							<?foreach($main_board_data_1 as $key => $list){?>
								<tr>
									<td>
										<a href="/board/view_v/<?=$main_board_1['board_id']?>/<?=$list['no']?>">
											<?=$list['subject']?>
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
											<span class="pull-right">
												<span class="comment_count label label-default">
													<?=$this->board_m->comment_count($list['no'])?>
												</span>
											</span>
										<?
											}
										?>
										<!--댓글 아이콘 종료-->
									</td>
									<td class="px50">
										<?=substr($list['reg_date'],5,6)?>
									</td>
								</tr>
							<?}?>
					<?}else{?>
						<tr>
							<td>
						등록된 글이 없습니다.
							</td>
						</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
	<!--메인 노출 게시판 종료-->
</div>

<div class="row">

	<div class="row wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
		<style type="text/css">
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
									<a href="/board/view_v/<?=$main_thumbnail_url?>/<?=$list['no']?>" >
										<img src="<?=$list['file_name']?>" class="img-rounded img-responsive center-block" >
									</a>
									<div class="caption" style ="height:30px !important;">
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

			<!--구글맵 시작-->
			<div style ="padding:10px 25px 20px 25px;">
				<div id="map_canvas"style="width:100%; height:270px;"></div> 
			</div>
			<!--구글맵 종료-->

		</div>
	</div>
</div>
<!-- /.container -->
<script>
$(document).ready(function() {

	//인스타그램 api 시작
	$.ajax({
		url: 'https://api.instagram.com/v1/users/self/media/recent/?count=<?=@$listcount?>&access_token=<?=@$tokenvalue?>',
		cache: false,
		dataType: 'jsonp'
	}).done(function( msg ) {
		var result = new Array();
		if(msg.data == undefined){
			$(".slider").html("인스타그램 플러그인 token값이 올바르지 않습니다.<br>환경설정에서 token값을 입력해주세요.");
		}else{
			$.each(msg.data, function(index, value) {
				var link = value.link;
				var imageUrl = value.images.standard_resolution.url;
				var instaId = value.id;
				var likes = value.likes.count;
				var comments = value.comments.count;
				
				result.push( '<span class="multiple">'
								+'<a href="'+link+'" target="_blank">'
								+'<div class="bg_bg"></div>'
								+'<div class="lc_wrap">'
									+'<span class="lc_wrap_bg"></span>'
									+'<span class="insta_like"><img border="0" src="/application/views/images/like_ic.png" width="18px" class="like_img" />'+likes+'</span>'
									+'<span class="insta_comment"><img border="0" src="/application/views/images/comment_ic.png" width="18px" class="comment_img" />'+comments+'</span></div>'
									+'<img border="0" src="'+imageUrl+'" class="insta_img" /></a></span>');
				$(".slider").html(result.join(""));
				
				//마우스 오버시 보여주기.	
				$(".multiple").hover(function(){
					$(this).find('.lc_wrap').stop().show();
				},function(){
					$(this).find('.lc_wrap').stop().hide();
				});

				// 브라우저가 IE일경우
				if(navigator.userAgent.indexOf('MSIE') > 0 || (navigator.userAgent.indexOf('Trident/7.0') > 0)){
					resizing();
				}else{ //그외 브라우저일경우
					$(window).load(function(){
						resizing();
					});
				}
			});
		}
	});
	//인스타그램 api 종료

	//구글 api 시작
	var map = new google.maps.Map(document.getElementById("map_canvas"), {
	scaleControl: false});
	map.setCenter(new google.maps.LatLng(37.7137403, 127.04798630000005));
	map.setZoom(16);
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP); 

	var marker = new google.maps.Marker({map: map, position:
		map.getCenter()});
	//구글 api 종료

	//배경 로테이트
	$('.carousel').carousel({
	 interval: 5000,
	 wrap: true
	})

	$("[id*=board_content_2]").hide();
	$("[id*=board_content_3]").hide();
	$("#board_name_1").addClass("active-board"); // 선택된 탭 색상 유지
	var board_id = $("#board_name_1").attr("alt"); // 클릭한 게시판 id
	var board_href = "/board/list_v/"+board_id; // 클릭한 게시판 주소
	$("#more").attr("href",board_href); // 더보기 버튼 주소변경

	// 게시판 탭 클릭 이벤트
	$("[id^='board_name_']").each(function( index ){
		// 탭 클릭시
		$(this).click(function(){
			var board_id = $(this).attr("alt"); // 클릭한 게시판 id
			var board_href = "/board/list_v/"+board_id; // 클릭한 게시판 주소
			$("#more").attr("href",board_href); // 더보기 버튼 주소변경

			$("[id^=board_content_]").hide(); // 클릭한 게시판 제외하고 숨기기
			$("[id=board_content_"+(index+1)+"]").show(); // 클릭한 게시판 보이기

			$("[id^='board_name_']").removeClass("active-board"); // 모든 탭 유지 색상 초기화
			$(this).addClass("active-board"); // 선택된 탭 색상 유지
			$("[id^='board_name_']").css("color","gray"); // 모든 탭 기존색상으로 초기화
			$(this).css("color","black"); // 선택된 탭 색상 변경

		});
		// 탭 색상 변경
		$(this).hover(function(){
			$(this).css("color","black");
		}, function(){
			if(!$(this).hasClass("active-board")){
				$(this).css("color","gray"); 
			}
		});
	});
});


function resizing(){
	$(window).resize(function(){
		var $slider = $('.slider');
		var $multiple = $slider.find('.multiple');
		var $multipleA = $multiple.children('a');
		var sliderWrap = $slider.width();
		var col = <?=$rowcount?>;			//칼럼수
		var colMg = <?=$image_space?>;		//칼럼 간격

		//각 칼럼의 가로값, 간격 계산 및 적용
		var multipleW = (sliderWrap-(col*colMg*2))/col;
		$multipleA.css({'width':multipleW, 'height':multipleW, 'margin':colMg});

		$multiple.each(function(i, e){
			var $eImg = $(e).find('.insta_img');
			var imgW = $eImg.width();
			var imgH = $eImg.height();

			//가로값이 클때
			if( imgW > imgH ){
				$eImg.animate({'width':'auto', 'height':multipleW}, 0, function(){
					$eImg.css({'margin-left':-(($eImg.width()-multipleW)/2)});
				});
			}

			//세로값이 클때
			else if( imgW < imgH ){
				$eImg.animate({'width':multipleW, 'height':'auto'}, 0, function(){
					$eImg.css({'margin-top':-(($eImg.height()-multipleW)/2)});
				});
			}

			//가로 세로가 같은 때
			else if( imgW == imgH ){
				$eImg.css({'width':multipleW, 'height':multipleW});
			}
		});
	}); $(window).trigger('resize');
}

</script>
