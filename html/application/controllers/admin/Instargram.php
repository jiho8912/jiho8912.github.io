<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Instargram extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('member_m'); //member controller model
		$this->load->model('admin/admin_m');
		$this->load->model('admin/admin_menu_m');
	}
	public function index()
	{
		$data['url'] = $this->uri->segment(2); //url

		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		//로그인 안했을경우
		if(!$this->session->userdata('mb_id')){;
			$this->load->view('admin/admin_header_v',$data); // 헤더
			$this->load->view('admin/admin_login_v');
			$this->load->view('admin/admin_footer_v'); // 푸터
		}else{
			//관리자정보 가져오기
			$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

			if($admin_id['no'] != 1)
			{
				$this->member_m->alert('관리자가 아닙니다.','/');
			}else{
				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
				$this->load->view('admin/admin_index_v');
				$this->load->view('admin/admin_footer_v'); // 푸터
			}
		}

	}
	/*------------------------------------[function]-------------------------------------
	함수명   - admin_login_v()
	내용	 - 로그인페이지
	------------------------------------------------------------------------------------*/
	public function admin_login_v()
	{
		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		//로그인 안했을경우
		if(!$this->session->userdata('mb_id')){;
			$this->load->view('admin/admin_header_v',$data); // 헤더
			$this->load->view('admin/admin_login_v');
			$this->load->view('admin/admin_footer_v'); // 푸터
		}else{
			//회원상세정보 가져오기
			$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

			if($admin_id['no'] != 1)
			{
				$this->member_m->alert('관리자가 아닙니다.','/');
			}else{
				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v'); // 좌측메뉴
				$this->load->view('admin/admin_index_v');
				$this->load->view('admin/admin_footer_v'); // 푸터
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_login()
	내용	 - 괸리자 로그인
	------------------------------------------------------------------------------------*/
	public function admin_login()
	{
		if($this->input->post('mb_id'))
		{
			$mb_id = $this->input->post('mb_id');
		}else{
			$this->member_m->alert('아이디를 입력해주세요.');
		}

		if($this->input->post('mb_password'))
		{
			$mb_password = $this->input->post('mb_password');
		}else{
			$this->member_m->alert('비밀번호를 입력해주세요.');
		}

		//회원상세정보 가져오기
		
		$admin_id = $this->member_m->select_mb_detail($mb_id);

		if(@$admin_id['no'] != 1)
		{
			$this->member_m->alert('관리자가 아닙니다.');
		}

		//비밀번호 확인
		$pw = $this->member_m->select_member_pw($mb_id);
		if($pw['mb_password'] != $mb_password)
		{
			$this->member_m->alert('비밀번호를 확인해주세요.');
		};

		$user_data = array(
			'mb_id'=>$mb_id,
			'mb_password'=>$mb_password,
			);

		$this->session->set_userdata($user_data);
		$this->member_m->alert('로그인 되었습니다.','/admin/management');
		exit;
	}

}

