<link rel="stylesheet" href="<?=plugin_dir?>/calender/css/calender.css" type="text/css" />
<script>
$(document).ready(function(){
	//해당달의 모든 날짜
	$(".day_area").each(function( index ) {
		$(this).click(function() {
			select_day(index+1); //달력에서 날짜 클릭
		});
	});
});

//달력에서 날짜 선택
function select_day(val)
{
	//모든 객실 숨기기 : 앞서 다른 객실을 선택하여 보여져 있던 객실을 숨기기 위해
	$("[id^=room_lst_day_]").each(function( index ) {
		$(this).hide();
	});

	$(".room_lst").show(); //객실현황 보이기
	$("#reserv_select_day").text(val); //일자 표시

	$("#room_lst_day_"+val).show(); //해당 날짜의 객실정보 표시
}

</script>
<div class="top_area">
	<div class="ymd">
		<a href="?year=<?=$prevYear?>&month=<?=$prevMonth?>">&#60;</a>
		<span class="bold1"><?=$nowYear;?>년<br /><b><?=$nowMonth;?>월</b></span>
		<a href="?year=<?=$nextYear?>&month=<?=$nextMonth?>">&#62;</a>
	</div>

	<p class="today">TODAY : <?=$month;?>월 <?=$day;?>일 &#40;<?=$weekString?>요일&#41;</p>
	<!-- <?=$year;?> -->
</div>

<!-- 구 버전 -->
<table class="booking_table">
	<thead class="week">
	<tr>
		<th class="bold_red">일</th>
		<th>월</th>
		<th>화</th>
		<th>수</th>
		<th>목</th>
		<th>금</th>
		<th class="bold_blue">토</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<? foreach($calArray as $key=>$list){?>

			<td class="<?=$list['class']?>"><!-- 달력 구조 -->
			<? if($list['day']){?>
					<div class="calendar_area">
						<div class="day_area">
							<?=$list['day']?>
							<?if($list['no']){?>
								<p><?=$list['subject'];?></p>
							<?}?>
						</div>
					</div>
				<? }?>
			<!-- 달력 구조 --></td>
			<? if(($key+1)%7==0)echo "</tr><tr>";?>
		<? }?>
	</tr>
	</tbody>
</table>
<span class="table_line"></span>
<div id = "room_lst" name = "room_lst" class="room_lst" style = "display:none;">
	<dl>
		<dt><?=@$nowYear?>년 <?=@$nowMonth?>월 <span id = "reserv_select_day" name = "reserv_select_day"></span>일 일정</dt>
		<?php
		//for debug
		//print_r($calArray);
		?>
		<? foreach($calArray as $key=>$list){?> 
			<dd id = "room_lst_day_<?=$list['day']?>" name = "room_lst_day_<?=$list['day']?>">
				<dl>
					<dd></dd><!--line 처리-->
					<dd>
						<? if(@$list['no']) {?>
							<?=$list['no'];?>
						<?}else{?>
							<span class="">등록된 일정이 없습니다.</span>
						<?}?>
					</dd>
				</dl>
			</dd>
			
		<? }?>
	</dl>
</div><br>