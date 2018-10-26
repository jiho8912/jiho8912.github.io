<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Visitor extends CI_Controller {

    /**
     * 생성자
     *사용할 모델을 로드해온다
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('visitor_m');
        $this->load->model('member_m');
        $this->load->model('admin/admin_m');
        $this->load->model('admin/admin_menu_m');
        // 일반 카테고리
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
        }
    }

    /*------------------------------------[function]-------------------------------------
    함수명   - admin_visitor_v()
    내용	 - 방문자통계
    ------------------------------------------------------------------------------------*/
    public function admin_visitor_v()
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

        $paging['per_page'] = 50; //한페이지당 표시할 개수
        $paging['off_set'] = $paging['per_page'] * ($paging['page']-1);//페이징 offset 가져오기
        unset($urlArray['page']);
        $paging['addLink'] = "";

        if(sizeof($urlArray)){
            foreach(array_filter($urlArray) as $key=> $value){
                $paging['addLink'] .= "&".$key."=".$value;
            }
        }

        $data['addUrl'] = $paging['addLink'];
        $paging['base_url'] = '/admin/visitor/admin_visitor_v/'.'?'.$paging['addLink'].''; //페이지 주소

        list($paging['recordCount'], $data['visitor_list']) = $this->visitor_m->select_visitor_list($paging); // 방문자 리스트 가져오기

        $paging['total_rows'] = $paging['recordCount'] ; //개시물 총 개수
        $data['recordCount'] = $paging['total_rows'];
        $data['totalPage'] = ceil($paging['recordCount'] / $paging['per_page']); // 총페이지

        $this->pagination->initialize($paging);
        $data['cnt'] = $paging;
        $data['paging'] = $this->pagination->create_links();
        //페이징 종료

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
                $this->load->view('admin/admin_visitor_v');
                $this->load->view('admin/admin_footer_v'); // 푸터
            }
        }
    }

}

