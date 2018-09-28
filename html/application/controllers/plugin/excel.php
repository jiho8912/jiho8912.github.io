<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends CI_Controller {

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
		$paging['base_url'] = '/plugin/excel?'.$paging['addLink'].''; //페이지 주소

		list($paging['recordCount'], $data['result']) = $this->admin_excel_m->select_booklist($paging);//게시판 리스트 가져오기

		$paging['total_rows'] = $paging['recordCount'] ; //개시물 총 개수
		$data['recordCount'] = $paging['total_rows'];
		$data['totalPage'] = ceil($paging['recordCount'] / $paging['per_page']); // 총페이지

		$this->pagination->initialize($paging); 
		$data['paging'] = $this->pagination->create_links();
		//페이징 종료

		$this->load->view('head',$data);
		$this->load->view('plugin/excel/excel_v',$data);
		$this->load->view('footer',$data);
		
	}

}

