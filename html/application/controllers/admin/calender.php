<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calender extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('member_m'); //member controller model
		$this->load->model('board_m'); 
		$this->load->model('admin/admin_m');
		$this->load->model('admin/admin_menu_m');
		$this->load->model('admin/admin_calender_m');
		$this->load->library('common');
		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
		// 일반 카테고리
		if (!defined('CATEGORY_TYPE_NORMAL')) define('CATEGORY_TYPE_NORMAL', 0);
	}
	public function index()
	{
		$data['url'] = $this->uri->segment(2); //url

		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		//회원상세정보 가져오기
		$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

		if($admin_id['no'] != 1)
		{
			$this->member_m->alert('관리자가 아닙니다.','/');
		}else{
			$this->load->view('admin/admin_header_v',$data); // 헤더
			$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
			$this->load->view('admin/admin_calender_v',$data);
			$this->load->view('admin/admin_footer_v'); // 푸터
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_calender_v()
	내용	 - 관리자 달력 플러그인페이지
	------------------------------------------------------------------------------------*/
	public function admin_calender_v()
	{
		$data['url'] = $this->uri->segment(2); //url
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

						$data['calArray'][$nowIndex]['no'] .=

							'<table  class="lst_area">
								<colgroup>
									<col width="*" />
									<col width="85px" />
								</colgroup>
								<thead>
									<tr>
										<th style = "text-align:center;">스케쥴</th>
										<th>관리</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<p>일정 : '.$list['subject'].'</p>
											<p>메모 : '.$list['contents'].'</p>
										</td>
										<td>
											<button type="button" id="update_schedule_'.$list['no'].'" class="btn-success btn-xs" value = "'.$list['no'].'">수정</button>
											<button type="button" id="delete_schedule_'.$list['no'].'" class="btn-danger btn-xs" value = "'.$list['no'].'">삭제</button>
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

		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		//로그인 안했을경우
		if(!$this->session->userdata('mb_id')){;
			$this->load->view('admin/admin_header_v',$data); // 헤더
			$this->load->view('admin/admin_login_v',$data);
			$this->load->view('admin/admin_footer_v',$data); // 푸터
		}else{
			//회원상세정보 가져오기
			$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

			if($admin_id['no'] != 1)
			{
				$this->member_m->alert('관리자가 아닙니다.','/');
			}else{
				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
				$this->load->view('admin/admin_calender_v',$data);
				$this->load->view('admin/admin_footer_v',$data); // 푸터
			}
		}

	}
	/*------------------------------------[function]-------------------------------------
	함수명   - reg_schedule_v()
	작성자   - 임지호(2017/02/14),
	목적	 - 일정등록 view
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function reg_schedule_v($data = array())
	{
		$urlArray = @$this->seg_exp['query_string'];

		$data['year'] = $urlArray['year'];
		$data['month'] = $urlArray['month'];
		$data['day'] = $urlArray['day'];
		$data['no'] = @$urlArray['no'];

		$data['schedule_detail'] = $this->admin_calender_m->select_scheule_detail($data['no']); // 일정리스트 가져오기
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		//로그인 안했을경우
		if(!$this->session->userdata('mb_id')){;
			$this->load->view('admin/admin_header_v',$data); // 헤더
			$this->load->view('admin/admin_login_v',$data);
			$this->load->view('admin/admin_footer_v',$data); // 푸터
		}else{
			//회원상세정보 가져오기
			$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

			if($admin_id['no'] != 1)
			{
				$this->member_m->alert('관리자가 아닙니다.','/');
			}else{
				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
				$this->load->view('admin/admin_reg_schedule_v',$data);
				$this->load->view('admin/admin_footer_v',$data); // 푸터
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - reg_scheule()
	작성자   - 임지호(2017/02/14),
	목적	 - 일정등록
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function reg_scheule($data = array())
	{
		$subject = $this->input->post('subject');
		$contents = $this->input->post('contents');
		$date = $this->input->post('date');
		$no = $this->input->post('no');

		if($subject){
			$insertData['subject'] = $subject;
		}else{
			$this->member_m->alert('제목을 입력하세요.');
		}

		if($contents){
			$insertData['contents'] = $contents;
		}else{
			$this->member_m->alert('내용을 입력하세요.');
		}

		if($date){
			$insertData['date'] = $date;
		}else{
			$this->member_m->alert('날짜를 입력하세요.');
		}

		if($no){
			$update_id = $this->admin_calender_m->update_schedule_data($insertData,$no);
			if($update_id){
				$this->member_m->alert('정상적으로 수정되었습니다.','/admin/calender/admin_calender_v');
			}else{
				$this->member_m->alert('일정수정에 실패하였습니다..');
			}

		}else{
			$insert_id = $this->admin_calender_m->insert_schedule_data($insertData);

			if($insert_id){
				$this->member_m->alert('정상적으로 등록되었습니다.','/admin/calender/admin_calender_v');
			}else{
				$this->member_m->alert('일정등록에 실패하였습니다..');
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete_schedule_data()
	내용	 - 일정삭제
	------------------------------------------------------------------------------------*/
	public function delete_schedule_data()
	{
		$urlArray = @$this->seg_exp['query_string'];

		$no = $urlArray['no'];

		$delete_id  = $this->admin_calender_m->delete_schedule_data($no);

		if($delete_id)
		{	
			$this->board_m->alert('성공적으로 삭제되었습니다.','/admin/calender/admin_calender_v');
		}else{
			$this->board_m->alert('일정삭제에 실패하였습니다.');
		}
	}

}