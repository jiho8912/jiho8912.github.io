<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_m extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - get_xml()
	목적	 - xml 파일 읽어 들이기
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function get_xml($url='') {
		$xml_contents	= @file_get_contents($url);
		if(!$xml_contents){
			 $errorData = implode(",",error_get_last());
			 echo $errorData;
		}
		$xml = @simplexml_load_string($xml_contents, 'SimpleXMLElement', LIBXML_NOCDATA);

		if(!$xml){
			 $errorData = implode(",",error_get_last());
			 echo $errorData;
		}
		foreach($xml as $key=>$list){
			$returnValue[$key] = $list; 
		}
		return $returnValue;
	}

	function result_json($success = true, $message = '정상처리됐습니다.', $data = NULL)
	{
		$result = array();
		$result['success'] = $success;
		$result['message'] = $message;
		if($data) $result['data'] = $data;
		
		header('Content-Type: application/json');
		echo json_encode($result); 
		exit;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - insert_background_img()
	내용	 - 배경이미지 등록하기
	------------------------------------------------------------------------------------*/
	public function insert_background_img($upload_data = array())
	{
		$this->db->set('reg_date', 'now()', FALSE);
		$this->db->insert('admin_files', $upload_data);

		$this->db->where('no', $upload_data['contents_no']);
		$this->db->set('contents_no', $upload_data['contents_no']);
		$this->db->update("admin_files");

		//for debug
		//echo $this->db->last_query();

		return $this->db->insert_id();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_background_img()
	내용	 - 배경이미지 가져오기
	------------------------------------------------------------------------------------*/
	public function select_background_img()
	{
		$this->db->select('*');
		$this->db->from('admin_files');
		$this->db->where('type','M');
		$this->db->order_by('contents_no','desc');

		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query();

		return $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_admin_files()
	내용	 - 게시물 첨부파일 이미지 불러오기 
	------------------------------------------------------------------------------------*/
	function select_admin_files($contents_no)
	{
		$this->db->select('*');
		$this->db->from('admin_files');
		$this->db->where_in('no', $contents_no);
		$this->db->order_by('no');
		$query = $this->db->get();
		$result = $query->result_array();

		//for debug
		//echo $this->db->last_query().'<br>';

		return $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete_admin_files()
	내용	 - 첨부파일 이미지 삭제
	------------------------------------------------------------------------------------*/
	function delete_admin_files($contents_no)
	{
		$this->db->where_in('no', $contents_no);

		//for debug
		//echo $this->db->last_query().'<br>';

		return $this->db->delete('admin_files');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_pre_no()
	내용	 - 이전 이미지 번호 가져오기
	------------------------------------------------------------------------------------*/
	public function select_pre_no($content_no)
	{

		$this->db->select('contents_no');
		$this->db->from('admin_files');
		$this->db->where("contents_no  = (
									select max(contents_no)
									from admin_files
									where contents_no < '$content_no'
									and type = 'M'
								)
						");
		$row = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $row;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_next_no()
	내용	 - 다음 이미지 번호 가져오기
	------------------------------------------------------------------------------------*/
	public function select_next_no($content_no)
	{

		$this->db->select('contents_no');
		$this->db->from('admin_files');
		$this->db->where("contents_no  = (
									select min(contents_no)
									from admin_files
									where contents_no > '$content_no'
									and type = 'M'
								)
						");
		$row = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $row;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_max_min_img()
	내용	 - 상품 정렬순서 max & min 가져오기
	------------------------------------------------------------------------------------*/
	function select_max_min_img($params = FALSE){
		if($params['up_down'] == 'up')
		{
			$this->db->select_max('contents_no');
		}else if($params['up_down'] == 'down'){
			$this->db->select_min('contents_no');
		}else{ //예외처리
			$this->db->select_max('contents_no');
		}
		$this->db->from("admin_files");
		$this->db->where("type",'M');
		

		$result = $this->db->get()->result_array();
		//echo $this->db->last_query() . '<br />';
		
		return @$result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_sort_list()
	목적	 - 상품 리스트 순서 가져오기
	------------------------------------------------------------------------------------*/
	function select_sort_list($params = FALSE){
		$this->db->select("*");
		$this->db->from("admin_files");
		$this->db->where("type",'M');
		$this->db->order_by("contents_no", "desc");
		
		$result = $this->db->get()->result_array();
		//echo $this->db->last_query() . '<br />';
		
		return @$result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update_sort_img()
	내용	 - 이미지 순서변경
	------------------------------------------------------------------------------------*/
	function update_sort_img($params = FALSE){
		
		//교체 성공 여부
		$is_change_prev = false; //상단의 이미지를 선택한 이미지와 순서교체 성공여부
		$is_change_current = false; //선택한 이미지를 상단 이미지와 순서교체 성공 여부
		$is_change_next = false; //하단의 이미지를 선택한 이미지와 순서교체 성공여부

		if($params['up_down'] == 'up')
		{
			//상단의 상품을 선택한 이미지와 순서교체
			$this->db->set('contents_no', -1 );
			
			$this->db->where('contents_no', $params['prev_sort'] );
			
			$this->db->update("admin_files") ? $is_change_current = true : $is_change_current = false ;
			
			//echo $this->db->last_query() . '<br />';
			
			//선택한 이미지를 상단 이미지와 순서교체
			$this->db->set('contents_no',$params['prev_sort']);
			
			$this->db->where('contents_no', $params['current_sort']);
			
			$this->db->update("admin_files") ? $is_change_prev = true : $is_change_prev = false ;
			
			//echo $this->db->last_query() . '<br />';
			
			//상단의 이미지를 선택한 이미지와 순서교체
			$this->db->set('contents_no', $params['current_sort'] );
			
			$this->db->where('contents_no', -1 );
			
			$this->db->update("admin_files") ? $is_change_current = true : $is_change_current = false ;
			
			//echo $this->db->last_query() . '<br />';
			
			if($is_change_prev && $is_change_current)
			{
				return true;
			}	
		}else if($params['up_down'] == 'down'){
			//하단의 이미지를 선택한 이미지와 순서교체
			$this->db->set('contents_no', -1 );
			
			$this->db->where('contents_no', $params['next_sort'] );
			
			$this->db->update("admin_files") ? $is_change_current = true : $is_change_current = false ;

			//echo $this->db->last_query() . '<br />';
			
			//선택한 이미지를 하단 이미지와 순서교체
			$this->db->set('contents_no',$params['next_sort']);
			
			$this->db->where('contents_no', $params['current_sort']);

			$this->db->update("admin_files") ? $is_change_prev = true : $is_change_prev = false ;
			
			//echo $this->db->last_query() . '<br />';

			//하단의 이미지를 선택한 이미지와 순서교체
			$this->db->set('contents_no', $params['current_sort'] );

			$this->db->where('contents_no', -1);

			$this->db->update("admin_files") ? $is_change_current = true : $is_change_current = false ;

			//echo $this->db->last_query() . '<br />';
			
			if($is_change_prev && $is_change_current)
			{
				return true;
			}
		}else{ //예외처리
			
		}
	}

}
?>