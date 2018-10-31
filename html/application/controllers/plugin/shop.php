<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('member_m'); //member controller model
		$this->load->model('board_m'); 
		$this->load->model('admin/admin_excel_m');
		$this->load->model('admin/admin_menu_m');
		$this->load->library('common');
		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
	}
	public function index()
	{
		$urlArray = @$this->seg_exp['query_string'];
		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		$data['category_list'] = $this->admin_menu_m->select_category_tree();

		$this->load->view('head',$data);
		$this->load->view('plugin/shop/stdpay/INIStdPaySample/INIStdPayRequest',$data);
		$this->load->view('footer',$data);
	}

	function close(){
        $urlArray = @$this->seg_exp['query_string'];
        $board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
        $data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

        $data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

        $data['category_list'] = $this->admin_menu_m->select_category_tree();

        $this->load->view('head',$data);
        $this->load->view('plugin/shop/stdpay/INIStdPaySample/close',$data);
        $this->load->view('footer',$data);
    }

    function INIStdPayReturn(){
        $urlArray = @$this->seg_exp['query_string'];
        $board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
        $data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

        $data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

        $data['category_list'] = $this->admin_menu_m->select_category_tree();

        $this->load->view('head',$data);
        $this->load->view('plugin/shop/stdpay/INIStdPaySample/INIStdPayReturn',$data);
        $this->load->view('footer',$data);
    }

    function INIStdcancel(){
        $urlArray = @$this->seg_exp['query_string'];
        $board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
        $data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

        $data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

        $data['category_list'] = $this->admin_menu_m->select_category_tree();

        $this->load->view('head',$data);
        $this->load->view('plugin/shop/stdpay/INIStdPaySample/INIStdcancel',$data);
        $this->load->view('footer',$data);
    }

    function INIcancel(){
        $urlArray = @$this->seg_exp['query_string'];
        $board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
        $data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

        $data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

        $data['category_list'] = $this->admin_menu_m->select_category_tree();

        $this->load->view('head',$data);
        $this->load->view('plugin/shop/stdpay/INIStdPaySample/INIcancel',$data);
        $this->load->view('footer',$data);
    }

}

