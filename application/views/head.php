<!DOCTYPE html>
<html lang="en">
<head>
	<title>지호 홈페이지</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <link rel="stylesheet" href="/static/bootstrap/css/bootstrap.min.css"> -->
	<link rel="stylesheet" href="/static/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/static/bootstrap/css/instargram.css">
	<link rel="stylesheet" href="/static/main/css/style.css">
	<script src="/js/jquery-1.10.1.min.js"></script>
    <script src="/js/common.js"></script>
	<script src="/js/jquery.bpopup.min.js"></script>
	<script src="/static/bootstrap/js/bootstrap.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=<?=@$google_apikey?>" type="text/javascript"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<link href="http://code.google.com/apis/maps/documentation/javascript/examples/standard.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://static.nid.naver.com/js/naveridlogin_js_sdk_2.0.0.js" charset="utf-8"></script>
    <meta content="IE=Edge" http-equiv="X-UA-Compatible">
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
			<!--상단네비 메뉴 시작-->
			<ul class="nav navbar-nav">
				<? if($category_list) {?>
					<? foreach ($category_list as $category_1_depth) { ?>
					<li class="dropdown">
						<? if(@$category_1_depth["sub"]) {?>
							<?if($category_1_depth["show_yn"] == 'Y'){?>
								<a class="dropdown-toggle" data-toggle="dropdown" href="<?=$category_1_depth['link_url']?><?=$category_1_depth["board_id"]?>">
								<?=$category_1_depth["category_name"]?>
								<span class="caret">
								</span>
							<?}?>
						<? } else { ?>
							<?if($category_1_depth["show_yn"] == 'Y'){?>
								<a class="dropdown-toggle" href="<?=$category_1_depth['link_url']?><?=$category_1_depth["board_id"]?>">
								<?=$category_1_depth["category_name"]?>
							<?}?>
						<? } ?>
							</a>
						<? if(@$category_1_depth["sub"]) {?>
							<ul class="dropdown-menu">
							<? foreach ($category_1_depth["sub"] as $category_2_depth) { ?>
								<?if($category_2_depth["show_yn"] == 'Y'){?>
									<li>
										<a href="<?=$category_2_depth['link_url']?><?=$category_2_depth["board_id"]?>">
											<?=$category_2_depth["category_name"]?>
										</a>
										<? if(@$category_2_depth["sub"]) {?>
											<ul class="ul_depth_3 ul_action_3">
											<? foreach (@$category_2_depth["sub"] as $category_3_depth) { ?>
												<?if($category_3_depth["show_yn"] == 'Y'){?>
													<a style = "color:#9d9d9d; "href="<?=$category_3_depth['link_url']?>/<?=$category_3_depth["board_id"]?>">
														- <?=$category_3_depth["category_name"]?>
													</a>
												<?}?>
											<? } ?>
											</ul>
										<? } ?>
									</li>
								<?}?>
							<? } ?>
							</ul>
						<? } ?>
					</li>
					<? } ?>
				<? } ?>
			</ul>
			<!--상단네비 메뉴 종료-->

			<!--우측네비 메뉴-->
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
			<!--우측네비 메뉴-->
		</div>

	</div>
</nav>

<!-- Page Content -->
<div class="container">
	<div class="row" style ="font-family:나눔고딕;">
		<div class="col-md-9">