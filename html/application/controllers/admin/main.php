<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

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
		// 일반 카테고리
		if (!defined('CATEGORY_TYPE_NORMAL')) define('CATEGORY_TYPE_NORMAL', 0);
		$this->evironmentFile = "enviroment.xml";
	}
	public function index()
	{
		$url = $this->uri->segment(4); //url
		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		if(!$url)
		{
			$this->member_m->alert('잘못된 접근입니다.');
		}else{
			//회원상세정보 가져오기
			$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

			if($admin_id['no'] != 1)
			{
				$this->member_m->alert('관리자가 아닙니다.','/');
			}else{
				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
				$this->load->view('admin/admin_main_v',$data);
				$this->load->view('admin/admin_footer_v'); // 푸터
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_main_v()
	내용	 - 관리자 메인페이지
	------------------------------------------------------------------------------------*/
	public function admin_main_v()
	{
		$data['url'] = $this->uri->segment(2); //url

		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		// 게시판 리스트
		$data['board_list'] = $this->board_m->select_admin_board_list();

		// 갤러리 게시판 리스트
		$data['gallery_board_list'] = $this->board_m->select_admin_board_list("A");

		// xml 로드
		if(file_exists($this->evironmentFile)){
			$result = $this->admin_m->get_xml($this->evironmentFile);
			if($result){
				foreach($result as $key=>$value){
					$data[$key] = $value;
				}
			}
		}

		// contents_no 생성
		if($this->input->post('contents_no')){
			$data['contents_no'] = $this->input->post('contents_no');
		}else{
			$data['contents_no'] = $this->board_m->insert_contents_seq(3);
		}

		//echo $data['contents_no'];

		//메인 로테이션 이미지 불러오기
		$data['main_back_img'] = $this->admin_m->select_background_img();

		if(!@$data['tab1']){
			$data['tab1'] = 0;
		}
		if(!@$data['tab2']){
			$data['tab2'] = 0;
		}
		if(!@$data['tab3']){
			$data['tab3'] = 0;
		}
		if(!@$data['tab4']){
			$data['tab4'] = 0;
		}
		if(!@$data['tab5']){
			$data['tab5'] = 0;
		}
		if(!@$data['listcount']){
			$data['listcount'] = 0;
		}
		if(!@$data['rowcount']){
			$data['rowcount'] = 0;
		}
		if(!@$data['image_space']){
			$data['image_space'] = 0;
		}

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
				$this->load->view('admin/admin_main_v',$data);
				$this->load->view('admin/admin_footer_v',$data); // 푸터
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - main_setting_save()
	내용	 - 메인페이지 설정 저장
	------------------------------------------------------------------------------------*/
	public function main_setting_save($data = array()){

		$config['upload_path'] = 'upload/main/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '90000';
		
		$this->load->library('upload', $config);

		if ($this->upload->do_upload())
		{
			$data = $this->upload->data();

			$addName = date("YmdHis");  //현재날짜,시간,분초구하기
			$file_name = $addName . '_' . $data['file_name'];

			$upload_data = array(
				'original_name' => $data['file_name'],
				'file_type' => $data['file_type'],
				'file_size' => $data['file_size'] * 1024,
				'file_name' => $file_name,
				'type' => 'M',
				'contents_no' => $this->input->post('contents_no'),
			);

			//메인 로테이션 이미지 dB저장
			$this->admin_m->insert_background_img($upload_data);

		}

		$tab1 = $this->input->post('tab1');
		$tab2 = $this->input->post('tab2');
		$tab3 = $this->input->post('tab3');
		$tab4 = $this->input->post('tab4');
		$tab5 = $this->input->post('tab5');
		$tab_limit = $this->input->post('tab_limit');
		$google_apikey = $this->input->post('google_apikey');
		$tokenvalue = $this->input->post('tokenvalue');
		$listcount = $this->input->post('listcount');
		$rowcount = $this->input->post('rowcount');
		$image_space = $this->input->post('image_space');

		$addr = $this->input->post('addr');
		$addr2 = $this->input->post('addr2');

		$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
		$xml .= "\n<config>";
		$xml .= "\n<tab1>$tab1</tab1>";
		$xml .= "\n<tab2>$tab2</tab2>";
		$xml .= "\n<tab3>$tab3</tab3>";
		$xml .= "\n<tab4>$tab4</tab4>";
		$xml .= "\n<tab5>$tab5</tab5>";
		$xml .= "\n<tab_limit>$tab_limit</tab_limit>";
		$xml .= "\n<google_apikey>$google_apikey</google_apikey>";
		$xml .= "\n<tokenvalue>$tokenvalue</tokenvalue>";
		$xml .= "\n<listcount>$listcount</listcount>";
		$xml .= "\n<rowcount>$rowcount</rowcount>";
		$xml .= "\n<image_space>$image_space</image_space>";

		$xml .= "\n<addr>$addr</addr>";
		$xml .= "\n<addr2>$addr2</addr2>";
		$xml .= "\n</config>";

		$fp = fopen($this->evironmentFile, "wb");
		fwrite($fp, $xml);
		fclose ($fp);

		$this->board_m->alert('저장 되었습니다.', '/admin/main/admin_main_v');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - background_img_del()
	내용	 - 배경이미지 삭제
	------------------------------------------------------------------------------------*/
	public function background_img_del($data = array()){

		$no = $this->input->post('no');

		$files = $this->admin_m->select_admin_files($no);
		foreach($files as $files_list){
			if(file_exists('upload/main/'.$files_list['original_name'])){ // 파일이 있는지 체크 
				if(unlink('upload/main/'.$files_list['original_name'])){ // 파일삭제 완료 후 
					$this->admin_m->delete_admin_files($no); //admin_files에서 해당 db 삭제됨
                    $this->board_m->alert('삭제 되었습니다.', '/admin/main/admin_main_v');
				}else{
					$this->board_m->alert('이미지 삭제중 오류가 발생하였습니다.');
				}
			}
            $this->board_m->alert('이미지 삭제중 오류가 발생하였습니다.');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - img_up_down()
	내용	 - 이미지 순서 변경
	------------------------------------------------------------------------------------*/
	function img_up_down($data=array()){

		if( $this->input->post('img_up_down') )
		{
			$img_up_down = $this->input->post('img_up_down'); 
		}

		if( $this->input->post('img_sort') )
		{
			$img_sort = $this->input->post('img_sort'); 
		}

		$param = array();
		
		if($img_up_down == 'up')
		{
			$param['up_down'] = 'up';
		}else if($img_up_down == 'down'){
			$param['up_down'] = 'down';
		}else{ //예외처리
			$param['up_down'] = 'up';
		}

		$up_down_result = $this->admin_m->select_max_min_img($param); //상품 리스트 테이블에서 max,min 가져오기

		$param['content_no'] = $img_sort;

		//움직이려는 상품의 순서가 최상단 or 최하단인지 체크
		if($img_up_down == 'up')
		{
			if( $img_sort >= $up_down_result['0']['contents_no'])
			{
				$this->admin_m->result_json(false, '선택하신 이미지는 이미 최상단의 순서입니다.');
			}
		}else if($img_up_down == 'down'){

			if( $img_sort <= $up_down_result['0']['contents_no'])
			{
				$this->admin_m->result_json(false, '선택하신 이미지는 이미 최하단의 순서입니다.');
			}
		}else{ //예외처리
			if( $img_sort >= $up_down_result['0']['contents_no'])
			{
				$this->admin_m->result_json(false, '서비스 장애입니다. 개발자에게 문의하세요');
			}
		}

		$data['img_list'] = $this->admin_m->select_sort_list(); //이미지 리스트 가져오기.

		$array_sort = array(); //순서값이 저장될 배열
		
		//초기화
		$prev_sort = ''; //이전 상품
		$current_sort = ''; //현재 상품
		$next_sort = ''; //다음 상품
		
		$current_sort = $img_sort;

		foreach ($data['img_list'] as $key => $value)
		{
			array_push($array_sort,$value['contents_no']);
		}
		
		//움직이려는 상품의 순서가 최상단 or 최하단인지 체크
		if($img_up_down == 'up')
		{
			$prev_sort = $array_sort[ ( array_search($img_sort, $array_sort) - 1 ) ];
		}else if($img_up_down == 'down'){
			$next_sort = $array_sort[ ( array_search($img_sort, $array_sort) + 1 ) ];
		}else{ //예외처리
			$prev_sort = $array_sort[ ( array_search($img_sort, $array_sort) - 1 ) ];
		}

		$sort_param = array();
		$sort_param['prev_sort'] = $prev_sort;
		$sort_param['current_sort'] = $current_sort;
		$sort_param['next_sort'] = $next_sort;
		$sort_param['up_down'] = $img_up_down;


		if($this->admin_m->update_sort_img($sort_param))
		{
			$this->admin_m->result_json(false, '정상적으로 순서가 변경되었습니다.');
		}else{
			$this->admin_m->result_json(false, '서비스 장애입니다. 개발자에게 문의하세요.');
		}
		
		unset($param);
		unset($array_sort);
		unset($sort_param);
	}

}

