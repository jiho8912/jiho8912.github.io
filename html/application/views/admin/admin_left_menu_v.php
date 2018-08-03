<div class="col-md-3" style ="padding-right:80px;">
	<p class="lead"></p>
	<div class="list-group">
		<a href="/admin/management" class="list-group-item
			<?if(@$url == 'management'){?>
				active
			<?}?>">관리자메인</a><br>

		<a href="" class="list-group-item">
			<span style = "font-size:15px;">기본설정</span>
		</a>

		<a href="/admin/main/admin_main_v" class="list-group-item
			<?if(@$url == 'main'){?>
				active
			<?}?>"> - 메인설정</a>

		<a href="/admin/menu/admin_menu_v" class="list-group-item
			<?if(@$url == 'menu'){?>
				active
			<?}?>"> - 메뉴관리</a>

		<a href="/admin/member/admin_member_v" class="list-group-item
			<?if(@$url == 'member'){?>
				active
			<?}?>"> - 회원관리</a>

		<a href="" class="list-group-item
			<?if(@$url == 'board_d'){?>
				active
			<?}?>"> - 방문자통계</a>

		<a href="" class="list-group-item">
			<span style = "font-size:15px;">플러그인</span>
		</a>

		<a href="/admin/excel/admin_excel_v" class="list-group-item
			<?if(@$url == 'excel'){?>
				active
			<?}?>"> - 엑셀 플러그인</a>

		<a href="/admin/calender/admin_calender_v" class="list-group-item
			<?if(@$url == 'calender'){?>
				active
			<?}?>"> - 달력 플러그인</a>

		<a href="/admin/instargram/admin_instargram_v" class="list-group-item
			<?if(@$url == 'instargram'){?>
				active
			<?}?>"> - 인스타그램 플러그인</a>


	</div>
</div>