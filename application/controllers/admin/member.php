<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); //폼검증 라이브러리
		$this->load->model('member_m'); //member controller model
		$this->load->model('board_m'); 
		$this->load->model('admin/admin_m');
		$this->load->model('admin/admin_menu_m');
		// 일반 카테고리
		if (!defined('CATEGORY_TYPE_NORMAL')) define('CATEGORY_TYPE_NORMAL', 0);
		$this->evironmentFile = "enviroment.xml";
		$this->load->library('pagination');
		$this->load->library('common');
		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
	}
	public function index()
	{
		$url = $this->uri->segment(4); //url

		if(!$url)
		{
			$this->member_m->alert('잘못된 접근입니다.');
		}else{
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
				$this->load->view('admin/admin_member_v');
				$this->load->view('admin/admin_footer_v'); // 푸터
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_member_v()
	내용	 - 회원관리
	------------------------------------------------------------------------------------*/
	public function admin_member_v()
	{
		$urlArray = @$this->seg_exp['query_string']; //쿼리스트링 사용
		$data['url'] = $this->uri->segment(2); //url

		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		//검색시작
		if(@$urlArray['searchKey']){
			$paging['searchKey'] = $data['searchKey'] =  @$urlArray['searchKey'];
		}else{		
			$searchKey = $this->input->post("searchKey");
			if($searchKey){
				$paging['searchKey'] = $data['searchKey'] = $urlArray['searchKey'] = $searchKey;
			}
        }

		if(@$urlArray['searchValue']){
			$paging['searchValue'] = $data['searchValue'] =  @$urlArray['searchValue'];
		}else{		
			$searchValue = $this->input->post("searchValue");
			if($searchValue){
				$paging['searchValue'] = $data['searchValue'] = $urlArray['searchValue'] = $searchValue;
			}
		}
		//검색 종료

		//페이징 시작
		if(@$urlArray['page']){
			$paging['page'] = $urlArray['page'];
		}else{
			$paging['page'] = 1;
		}

		$paging['per_page'] = 5; //한페이지당 표시할 개수
		$paging['off_set'] = $paging['per_page'] * ($paging['page']-1);//페이징 offset 가져오기
		unset($urlArray['page']);
		$paging['addLink'] = "";

		if(sizeof($urlArray)){
			foreach(array_filter($urlArray) as $key=> $value){
				$paging['addLink'] .= "&".$key."=".$value;
			}
		}

		$data['addUrl'] = $paging['addLink'];
		$paging['base_url'] = '/admin/member/admin_member_v/'.'?'.$paging['addLink'].''; //페이지 주소

		list($paging['recordCount'], $data['mb_list']) = $this->member_m->select_mb_list($paging);//게시판 리스트 가져오기

		$paging['total_rows'] = $paging['recordCount'] ; //개시물 총 개수
		$data['recordCount'] = $paging['total_rows'];
		$data['totalPage'] = ceil($paging['recordCount'] / $paging['per_page']); // 총페이지

		$this->pagination->initialize($paging); 
		$data['paging'] = $this->pagination->create_links();
		//페이징 종료

		//for debug
		//$this->board_m->debug($paging);

		//회원상세정보 가져오기
		$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

		//로그인 안했을경우
		if(!$this->session->userdata('mb_id')){;
			$this->load->view('admin/admin_header_v',$data); // 헤더
			$this->load->view('admin/admin_login_v',$data);
			$this->load->view('admin/admin_footer_v',$data); // 푸터
		}else{
			if($admin_id['no'] != 1)
			{
				$this->member_m->alert('관리자가 아닙니다.','/');
			}else{
				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
				$this->load->view('admin/admin_member_v');
				$this->load->view('admin/admin_footer_v'); // 푸터
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_member_update_v()
	내용	 - 회원정보 수정
	------------------------------------------------------------------------------------*/
	public function admin_member_update_v()
	{
		$member_id = $this->input->post('member_id');

		//회원상세정보 가져오기
		$data['mb_detail'] = $this->member_m->select_mb_detail($member_id);

		//for debug
		//$this->member_m->debug($data['mb_detail']);
		
		echo json_encode($data['mb_detail']);
		exit;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_member_update()
	내용	 - 회원정보 수정
	------------------------------------------------------------------------------------*/
	public function admin_member_update()
	{
		$config = array(
			array('field'=>'mb_password', 'label'=>'비밀번호', 'rules'=>'trim|required|max_length[20]'),
			array('field'=>'mb_name', 'label'=>'이름', 'rules'=>'trim|required|max_length[10]'),
			array('field'=>'mb_email', 'label'=>'이메일', 'rules'=>'trim|required|max_length[50]|valid_email'),
		);

		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE) {
			$this->admin_member_v();
		}else{
			$mb_id = $this->input->post('mb_id');
			$mb_info = array(
				'mb_password' => md5($this->input->post('mb_password')),
				'mb_name' => $this->input->post('mb_name'),
				'mb_hp' => $this->input->post('mb_hp'),
				'mb_email' => $this->input->post('mb_email'),
			);

			$update_id = $this->member_m->update_member_info($mb_info,$mb_id);

			if($update_id){
				$this->member_m->alert('정상적으로 수정되었습니다.','/admin/member/admin_member_v');
			}else{
				$this->member_m->alert('회원정보 수정에 실패하였습니다.');
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_member_delete()
	내용	 - 회원정보 삭제
	------------------------------------------------------------------------------------*/
	public function admin_member_delete()
	{

		$no = $this->input->post('no');

		$delete_id = $this->member_m->delete_member_list($no);

		if($delete_id){
			$this->member_m->alert('정상적으로 삭제되었습니다.','/admin/member/admin_member_v');
		}else{
			$this->member_m->alert('회원정보 삭제에 실패하였습니다.');
		}
	}


}

