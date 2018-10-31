
<!DOCTYPE html>
<html lang="en">
<head>
	<title>지호 홈페이지</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="/static/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/static/main/css/style.css">
	<script src="/js/jquery-1.10.1.min.js"></script>
	<script src="/js/jquery.bpopup.min.js"></script>
	<script src="/static/bootstrap/js/bootstrap.js"></script>

    <!-- 자동 include -->
    <?	foreach($headerInfo['CSS'] as $css_file) print '<link href="'.$css_file.'?v=1" rel="stylesheet">';?>
    <?	foreach($headerInfo['JS'] as $js_file) print '<script src="'.$js_file.'?v='.date('mdHis').'" ></script>';?>

    <? # SweetAlert2 ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.10.1/sweetalert2.min.css" />

<script>
$(document).ready(function() {
	//이미지 리사이징
	$("#contents img").each(function(){
		var width = $(this).width();
		if(width > 847.5){
			$(this).width("100%");
		}
	});

	$('.carousel').carousel({
	 interval: 2500,
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
</script>
</head>
<body>

<style>
.label-default {font-weight: normal !important;
padding: 2px 4px 2px 4px !important;}
.active-board {color:black !important;}
</style>

<nav class="navbar navbar-inverse">
	<div class="container-fluid" style = "text-align:left;">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">
				<span class="glyphicon glyphicon-home">
				</span>
			</a>
		</div>

		<div class="collapse navbar-collapse" id="myNavbar">

			<ul class="nav navbar-nav">
				<? if($admin_category_list) {?>
					<? foreach ($admin_category_list as $category_1_depth) { ?>
					<li class="dropdown">
						<? if(@$category_1_depth["sub"]) {?>
							<a class="dropdown-toggle" data-toggle="dropdown" href="/board/list_v/<?=$category_1_depth["board_id"]?>">
							<?=$category_1_depth["category_name"]?>
							<span class="caret">
							</span>
						<? } else { ?>
							<a class="dropdown-toggle" href="/board/list_v/<?=$category_1_depth["board_id"]?>">
							<?=$category_1_depth["category_name"]?>
						<? } ?>
							</a>
						<? if(@$category_1_depth["sub"]) {?>
							<ul class="dropdown-menu">
							<? foreach ($category_1_depth["sub"] as $category_2_depth) { ?>
								<li>
									<a href="<?=$category_2_depth['link_url']?><?=$category_2_depth["board_id"]?>">
										<?=$category_2_depth["category_name"]?>
									</a>
									<? if(@$category_2_depth["sub"]) {?>
										<ul class="ul_depth_3 ul_action_3">
										<? foreach (@$category_2_depth["sub"] as $category_3_depth) { ?>
												<a style = "color:#9d9d9d; "href="<?=$category_3_depth['link_url']?>/<?=$category_3_depth["board_id"]?>">
													- <?=$category_3_depth["category_name"]?>
												</a>
										<? } ?>
										</ul>
									<? } ?>
								</li>
							<? } ?>
							</ul>
						<? } ?>
					</li>
					<? } ?>
				<? } ?>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<?if($this->session->userdata("mb_id")){?>
					<li class="active">
						<a href="/member/update_v"><span class="glyphicon glyphicon-user"></span>
							<?=$this->session->userdata("mb_id").'님'?>
						</a>
					</li>
				<?}else{?>
					<li>
						<a href="/member/join_v">
							<span class="glyphicon glyphicon-user"></span>
								Sign Up
						</a>
					</li>
				<?}?>
				<li>
					<?if($this->session->userdata("mb_id")){?>
						<a href="/member/logout_v">
							<span class="glyphicon glyphicon-log-out">
							</span> Logout
						</a>
					<?}else{?>
						<a href="/member/login_v">
							<span class="glyphicon glyphicon-log-in">
							</span> Login
						</a>
					<?}?>
				</li>
				<li>
					<a href="/admin/management">
						<span class="glyphicon glyphicon-cog">
						</span> admin
					</a>
				</li>
			</ul>

		</div>
	</div>
</nav>

<!-- Page Content -->
<div class="container" style ="padding-left:0px;">
	<div class="row" style ="font-family:나눔고딕;">
