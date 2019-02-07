<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calender extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		$this->load->model('member_m'); //member controller model
		$this->load->model('board_m'); 
		$this->load->model('admin/admin_calender_m'); 
		$this->load->model('admin/admin_m');
		$this->load->model('admin/admin_menu_m');
		$this->load->library('common');
		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
	}
	public function index()
	{
		$urlArray = @$this->seg_exp['query_string'];

		$data['year'] = date("Y");
		$data['month'] = date("m");
		$data['day'] = date("d");
		$week = array("","월", "화", "수", "목", "금", "토", "일" );
		$data['weekString'] = $week[date("N")];	

		//사용자가 다음 또는 이전월을 클릭하지 않고 처음 페이지가 로딩시에는 오늘 날짜를 기준으로 처리
		if(!@$urlArray['year']) $urlArray['year'] = $data['year'];
		if(!@$urlArray['month']) $urlArray['month'] = $data['month'];
		
		$data['nowYear'] = $urlArray['year'];//현재 선택된 년도
		$data['nowMonth'] = $urlArray['month'];//현재 선택된 월
		
		if(($data['nowMonth']-1)<=0){
			$data['prevYear'] = $data['nowYear']-1;
			$data['prevMonth'] = 12;	
		}else{
			$data['prevYear'] = $data['nowYear'];
			$data['prevMonth'] = $data['nowMonth'] - 1;
		}
		if(($data['nowMonth']+1)>12){
			$data['nextYear'] = $data['nowYear']+1;
			$data['nextMonth'] = 1;	
		}else{
			$data['nextYear'] = $data['nowYear'];
			$data['nextMonth'] = $data['nowMonth'] + 1;
		}

		$startDay = mktime(0,0,0,$urlArray['month'],1,$urlArray['year']);//사용자 선택 월의 첫째날
		$col = date('w',$startDay);//해당월의 첫번째일자  및 달력간을 한줄에 7개씩만 나올수 있도록 제어하기 위한 변수 - 첫주는 첫번째 일자 다음날부터 날자값이 표시 
		$totalDay = date("t", $startDay);//해당월의 총일 수

		$i=0;
		//해당월 시작일 이전 비어 있는 칸 처리
		for($i=0;$i<$col;$i++){
			$data['calArray'][$i]['day'] = "0";
			$data['calArray'][$i]['class'] = "bold_top";
		}

		$schedule_list = $this->admin_calender_m->select_scheulelist(); // 일정리스트 가져오기

		$todayDate = mktime(0,0,0,$data['month'],date("d"),$data['year']);//오늘 날짜
		$k=0;
		for($i=0,$j=1;$i<$totalDay;$i++,$j++){//해당월의 날자 구간 $i:배열 인덱스처리, $j:실 날자 처리
			$nowIndex = $i+$col;//배열로 저장할때는 앞에 비어 있는 칸도 처리 해야 하므로
			$nowTodayDate = strtotime($data['nowYear']."-".$data['nowMonth']."-".$j);//출력일 시간 데이터
			$weekDayIndex = date("N", $nowTodayDate);//토요일인지 일요일인지 판단하기 위함
			$data['calArray'][$nowIndex]['day'] = $j;
						
			if($weekDayIndex==7)$data['calArray'][$nowIndex]['class'] = "boldRed_top";//일요일
			elseif($weekDayIndex==6)$data['calArray'][$nowIndex]['class'] = "boldBlue_top";//토요일
			else $data['calArray'][$nowIndex]['class'] = "bold_top";//평일
			
			$data['calArray'][$nowIndex]['subject']="";
			$data['calArray'][$nowIndex]['contents']="";
			$data['calArray'][$nowIndex]['no']="";

				foreach($schedule_list as $list){
					if($nowTodayDate == strtotime($list['date'])){
						/*
						$data['calArray'][$nowIndex]['no'] .= $list['no'];
						$data['calArray'][$nowIndex]['subject'] .= $list['subject'].'<br>';
						$data['calArray'][$nowIndex]['contents'] .= $list['contents'].'<br>';
						*/

						$data['calArray'][$nowIndex]['subject'] .= $list['subject'].'<br>';

						$data['calArray'][$nowIndex]['no'] .=

							'<table  class="lst_area">
								<colgroup>
									<col width="*" />
								</colgroup>
								<thead>
									<tr>
										<th style = "text-align:center;">스케쥴</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<p>일정 : '.$list['subject'].'</p>
											<p>메모 : '.$list['contents'].'</p>
										</td>
									</tr>
								</tbody>
							</table>';

					}
				}
		}

		for($i+=$col;$i%7!=0;$i++){//해당월의 나머지 비어 있는 구간
			$data['calArray'][$i]['day'] = "0";
			$data['calArray'][$i]['class'] = "bold_top";
			$data['calArray'][$i]['peak'] = ""; 
			$data['calArray'][$i]['room'] = "";
		}

		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		$data['category_list'] = $this->admin_menu_m->select_category_tree();

		$this->load->view('head',$data);
		$this->load->view('plugin/calender/calender_v',$data);
		$this->load->view('footer',$data);
		
	}


}

