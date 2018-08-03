<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Board extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('board_m');
		$this->load->model('member_m');
		$this->load->model('/admin/admin_menu_m');
		$this->load->library('pagination');
		$this->load->library('common');
		$this->load->helper('cookie');
		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
	}

	public function index()
	{
		$this->load->view('head');
		$this->load->view('index');
		$this->load->view('footer');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - list_v()
	내용	 - 게시판 리스트 화면
	------------------------------------------------------------------------------------*/
	public function list_v()
	{
		$urlArray = @$this->seg_exp['query_string']; //쿼리스트링 사용
		$paging['board_id'] = $this->uri->segment(3); //게시판 ID
		$data['board_id'] = $paging['board_id'];

		$menu_id = $this->board_m->select_board_type($paging['board_id']);//게시판 번호 가져오기

		//메뉴 url 변경되었을경우
		if(!$menu_id){
			$this->board_m->alert('게시판 정보가 변경되었습니다.\n 새로고침 해주시기 바랍니다.');
		}

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

		$paging['per_page'] = 11; //한페이지당 표시할 개수
		$paging['off_set'] = $paging['per_page'] * ($paging['page']-1);//페이징 offset 가져오기
		unset($urlArray['page']);
		$paging['addLink'] = "";

		if(sizeof($urlArray)){
			foreach(array_filter($urlArray) as $key=> $value){
				$paging['addLink'] .= "&".$key."=".$value;
			}
		}

		$data['addUrl'] = $paging['addLink'];
		$paging['base_url'] = '/board/list_v/'.$paging['board_id'].'?'.$paging['addLink'].''; //페이지 주소

		//$this->board_m->debug($paging);

		list($paging['recordCount'], $data['board_list']) = $this->board_m->select_board_list($paging,$menu_id);//게시판 리스트 가져오기

		$paging['total_rows'] = $paging['recordCount'] ; //개시물 총 개수
		$data['recordCount'] = $paging['total_rows'];
		$data['totalPage'] = ceil($paging['recordCount'] / $paging['per_page']); // 총페이지

		$this->pagination->initialize($paging); 
		$data['paging'] = $this->pagination->create_links();
		//페이징 종료

		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		$data['board_type'] = $this->board_m->select_board_type($data['board_id']);//게시판 타입 가져오기

		$data['etc_option'] = unserialize($data['board_type']['etc_option']); //썸네일 사이즈

		// 카테고리 리스트
		$data['category_list'] = $this->admin_menu_m->select_category_tree();

		//for debug
		//$this->board_m->debug($data['board_list']);

		if(!$data['board_type']){
			$this->board_m->alert('잘못된 접근입니다.');
		}else{
			switch($data['board_type']['type']){
				//리스트형일경우
				case ('L'):
					$this->load->view('head',$data);
					$this->load->view('board/list_v',$data);
					$this->load->view('footer');
					break;
				//갤러리형일경우
				case ('G'):
					$this->load->view('board/gellary_head',$data);
					$this->load->view('board/gellary_v',$data);
					$this->load->view('footer');
					break;
				//앨범형일경우
				case ('A'):
					$this->load->view('head',$data);
					$this->load->view('board/album_v',$data);
					$this->load->view('footer');
					break;
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - write_v()
	내용	 - 게시판 글쓰기 화면
	------------------------------------------------------------------------------------*/
	public function write_v()
	{
		if(!$this->session->userdata('mb_id')){;
			$this->board_m->alert('회원만 작성가능합니다.');
		}else{
			//회원상세정보 가져오기
			$data['mb_detail'] = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));
		}

		// contents_no 생성
		if($this->input->post('contents_no')){
			$data['contents_no'] = $this->input->post('contents_no');
		}else{
			$data['contents_no'] = $this->board_m->insert_contents_seq(3);
		}

		set_cookie('contents_no', $data['contents_no'], 86400);

		$data['board_id'] =  $this->uri->segment(3); //게시판 ID
		$data['menu_id'] = $this->board_m->select_board_type($data['board_id']);//게시판 번호 가져오기

		//메뉴 url 변경되었을경우
		if(!$data['menu_id']){
			$this->board_m->alert();
		}

		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		// 카테고리 리스트
		$data['category_list'] = $this->admin_menu_m->select_category_tree();

		$this->load->view('head',$data);
		$this->load->view('board/write_v',$data);
		$this->load->view('footer');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - write()
	내용	 - 글쓰기
	------------------------------------------------------------------------------------*/
	public function write()
	{
		if(!$this->input->post('mb_name'))
		{
			$this->board_m->alert('이름을 입력하세요.');
		}

		if(!$this->input->post('subject'))
		{
			$this->board_m->alert('제목을 입력하세요.');
		}

		if(!$this->input->post('board_id'))
		{
			$this->board_m->alert('메뉴 url이 없습니다.');
		}else{
			$board_id =$this->input->post('board_id');
		}

		$board_info = array(
			'mb_id' => $this->session->userdata('mb_id'),
			'mb_name' => $this->input->post('mb_name'),
			'mb_email' => $this->input->post('mb_email'),
			'subject' => $this->input->post('subject'),
			'contents' => $this->input->post('contents'),
			'menu_id' => $this->input->post('menu_id'),
			'contents_no' => $this->input->post('contents_no'),
		);

		//for debug
		//$this->board_m->debug($board_info);

		$insert_id  = $this->board_m->insert_board($board_info);

		delete_cookie('contents_no');

		if($insert_id > 0)
		{	
			$this->board_m->alert('성공적으로 등록되었습니다.','/board/list_v/'.$board_id);
		}else{
			$this->board_m->alert('글등록에 실패하였습니다.');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - view_v()
	내용	 - 게시물 상세 페이지
	------------------------------------------------------------------------------------*/
	public function view_v()
	{
		$paging['board_id'] = $this->uri->segment(3); //게시판 ID
		$data['board_id'] = $paging['board_id'];

		$menu_id = $this->board_m->select_board_type($paging['board_id']);//게시판 번호 가져오기

		//메뉴 url 변경되었을경우
		if(!$menu_id){
			$this->board_m->alert('게시판 정보가 변경되었습니다.\n 새로고침 해주시기 바랍니다.');
		}

		//글번호 가져오기
		if(!$this->uri->segment(4)){
			$this->board_m->alert('잘못된 접근입니다.');
		}elseif($this->uri->segment(4) == 'first'){
			$this->board_m->alert('이전 게시물이 없습니다.');
		}elseif($this->uri->segment(4) == 'last'){
			$this->board_m->alert('다음 게시물이 없습니다.');
		}else{
			$content_no = $this->uri->segment(4);
		}
		//조회수 증가
		$this->board_m->add_view_count($content_no);

		//이전글 번호 가져오기
		$data['select_pre_no'] = $this->board_m->select_pre_no($content_no,$menu_id);

		//다음글 번호 가져오기
		$data['select_next_no'] = $this->board_m->select_next_no($content_no,$menu_id);

		//게시판 리스트 가져오기
		//$data['board_list'] = $this->board_m->select_board_list($paging);

		//게시판 상세정보 가져오기
		$data['board_detail'] = $this->board_m->select_board_detail($content_no,$menu_id);

		//댓글 리스트 가져오기
		$data['comment_list'] = $this->board_m->select_comment_list($content_no);

		//없는 글번호일경우
		if(@$data['board_detail']['no'] != $content_no){
			$this->board_m->alert('글번호가 없습니다.');
		}

		if(!$data['select_pre_no']) $data['select_pre_no']['no'] = 'first';
		if(!$data['select_next_no']) $data['select_next_no']['no'] = 'last';

		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		// 카테고리 리스트
		$data['category_list'] = $this->admin_menu_m->select_category_tree();

		//for debug
		//$this->board_m->debug($data['board_detail']);

		$this->load->view('head',$data);
		$this->load->view('board/view_v',$data);
		$this->load->view('footer');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update_v()
	내용	 - 게시판 글수정 화면
	------------------------------------------------------------------------------------*/
	public function update_v()
	{
		$paging['board_id'] = $this->uri->segment(3); //게시판 ID
		$data['board_id'] = $paging['board_id'];
		$menu_id = $this->board_m->select_board_type($data['board_id']);//게시판 번호 가져오기

		//메뉴 url 변경되었을경우
		if(!$menu_id){
			$this->board_m->alert('게시판 정보가 변경되었습니다.\n새로고침 해주시기 바랍니다.');
		}

		//글번호 가져오기
		$content_no = $this->uri->segment(4);
		//게시판 상세정보 가져오기
		$data['board_detail'] = $this->board_m->select_board_detail($content_no,$menu_id);

		set_cookie('contents_no', $data['board_detail']['contents_no'], 86400);

		//없는 글번호일경우
		if(@$data['board_detail']['no'] != $content_no){
			$this->board_m->alert('글번호가 없습니다.');
		}

		//글쓴이와 로그인 아이디가 일치하지않을경우
		if($this->session->userdata('mb_id') != $data['board_detail']['mb_id']){
			$this->board_m->alert('아이디가 일치하지않습니다.');
		}

		//로그인 하지않았을경우
		if(!$this->session->userdata('mb_id')){
			$this->board_m->alert('로그인후 사용가능합니다.');
		}

		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		// 카테고리 리스트
		$data['category_list'] = $this->admin_menu_m->select_category_tree();
		//for debug
		//$this->board_m->debug($data['board_detail']);

		$this->load->view('head',$data);
		$this->load->view('board/update_v',$data);
		$this->load->view('footer');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update()
	내용	 - 글수정
	------------------------------------------------------------------------------------*/
	public function update()
	{
		$board_id = $this->input->post('board_id'); //게시판 ID
		$content_no = $this->input->post('content_no');//글번호

		$board_info = array(
			'mb_name' => $this->input->post('mb_name'),
			'mb_email' => $this->input->post('mb_email'),
			'subject' => $this->input->post('subject'),
			'contents' => $this->input->post('contents'),
		);

		//for debug
		//$this->board_m->debug($board_info);

		$update_id  = $this->board_m->update_board($board_info,$content_no);

		delete_cookie('contents_no');

		if($update_id)
		{	
			$this->board_m->alert('성공적으로 수정되었습니다.','/board/list_v/'.$board_id);
		}else{
			$this->board_m->alert('글수정에 실패하였습니다.');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete()
	내용	 - 글삭제
	------------------------------------------------------------------------------------*/
	public function delete()
	{
		$board_id = $this->uri->segment(3); //게시판 ID
		$content_no = $this->uri->segment(4); //글번호 가져오기
		$contents_no = $this->uri->segment(5); //이미지번호 가져오기

		$files = $this->board_m->select_admin_files($contents_no);
		foreach($files as $files_list){
			if(file_exists('upload/'.$files_list['file_name'])){ // 파일이 있는지 체크 
				if(unlink('upload/'.$files_list['file_name'])){ // 파일삭제 완료 후 
					$this->board_m->delete_admin_files($contents_no); //admin_files에서 해당 db 삭제됨 
				}else{
					$this->board_m->alert('이미지 삭제중 오류가 발생하였습니다.');
				}
			}
		}

		$delete_id  = $this->board_m->delete_board($content_no);

		if($delete_id)
		{	
			$this->board_m->alert('성공적으로 삭제되었습니다.','/board/list_v/'.$board_id);
		}else{
			$this->board_m->alert('글삭제에 실패하였습니다.');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - write_comment()
	내용	 - 댓글등록
	------------------------------------------------------------------------------------*/
	public function write_comment()
	{
		if(!$this->session->userdata('mb_id')){;
			$this->board_m->alert('댓글은 회원만 작성가능합니다.');
		}

		//회원상세정보 가져오기
		$mb_detail = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

		if($this->input->post('board_id'))
		{
			$board_id = $this->input->post('board_id');
		}else{
			$this->board_m->alert('게시판 ID가 없습니다.');
		}

		if($this->input->post('content_no'))
		{
			$content_no = $this->input->post('content_no');
		}else{
			$this->board_m->alert('글번호가 없습니다.');
		}

		if($this->input->post('cmt_contents'))
		{
			$cmt_contents = $this->input->post('cmt_contents');
		}else{
			$this->board_m->alert('내용을 입력하세요.');
		}

		if($this->input->post('is_secret'))
		{
			$is_secret = $this->input->post('is_secret');
		}else{
			$is_secret = "N";
		}

		$comment_info = array(
			'contents' => $cmt_contents,
			'content_no' => $content_no,
			'name' => $mb_detail['mb_name'],
			'id' => $this->session->userdata('mb_id'),
			'is_secret' => $is_secret,
		);

		//for debug
		//$this->board_m->debug($comment_info);

		$insert_id  = $this->board_m->insert_comment($comment_info);

		if($insert_id > 0)
		{	
			$this->board_m->alert('성공적으로 등록되었습니다.','/board/view_v/'.$board_id.'/'.$content_no);
		}else{
			$this->board_m->alert('댓글등록에 실패하였습니다.');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update_comment()
	내용	 - 댓글수정
	------------------------------------------------------------------------------------*/
	public function update_comment()
	{
		if(!$this->session->userdata('mb_id')){;
			$this->board_m->alert('댓글은 회원만 작성가능합니다.');
		}

		//회원상세정보 가져오기
		$mb_detail = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

		if($this->input->post('board_id'))
		{
			$board_id = $this->input->post('board_id');
		}else{
			$this->board_m->alert('게시판 ID가 없습니다.');
		}

		if($this->input->post('comment_no'))
		{
			$comment_no = $this->input->post('comment_no');
		}else{
			$this->board_m->alert('댓글번호가 없습니다.');
		}

		if($this->input->post('content_no'))
		{
			$content_no = $this->input->post('content_no');
		}else{
			$this->board_m->alert('글번호가 없습니다.');
		}

		if($this->input->post('cmt_contents'))
		{
			$cmt_contents = $this->input->post('cmt_contents');
		}else{
			$this->board_m->alert('내용을 입력하세요.');
		}

		if($this->input->post('is_secret'))
		{
			$is_secret = $this->input->post('is_secret');
		}else{
			$is_secret = "N";
		}

		$comment_info = array(
			'contents' => $cmt_contents,
			'name' => $mb_detail['mb_name'],
			'id' => $this->session->userdata('mb_id'),
			'is_secret' => $is_secret,
		);

		//for debug
		//$this->board_m->debug($comment_info);

		$update_id  = $this->board_m->update_comment($comment_info,$comment_no);

		if($update_id > 0)
		{	
			$this->board_m->alert('성공적으로 수정되었습니다.','/board/view_v/'.$board_id.'/'.$content_no);
		}else{
			$this->board_m->alert('댓글수정에 실패하였습니다.');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete_comment()
	내용	 - 댓글삭제
	------------------------------------------------------------------------------------*/
	public function delete_comment()
	{
		$board_id = $this->uri->segment(3); //게시판 ID
		$content_no = $this->uri->segment(4); //게시글번호
		$comment_no = $this->uri->segment(5); //댓글번호

		$delete_id  = $this->board_m->delete_comment($comment_no);

		if($delete_id)
		{	
			$this->board_m->alert('성공적으로 삭제되었습니다.','/board/view_v/'.$board_id.'/'.$content_no);
		}else{
			$this->board_m->alert('댓글삭제에 실패하였습니다.');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */