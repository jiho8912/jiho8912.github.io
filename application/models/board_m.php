<?
class Board_m extends CI_Model {

	public function __construct()
	{
		parent :: __construct();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->database();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - alert()
	내용	 - 경고메시지
	------------------------------------------------------------------------------------*/
	function alert($msg='', $url='') {
		$CI =& get_instance();
		if (!$msg) $msg = '올바른 방법으로 이용해 주십시오.';
			echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=".$CI->config->item('charset')."\">";
			echo "<script type='text/javascript'>alert('".$msg."');";
		if ($url)
			echo "location.replace('".$url."');";
		else
			echo "history.go(-1);";
			echo "</script>";
		exit;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - debug()
	내용	 - 배열 디버그
	------------------------------------------------------------------------------------*/
	function debug($val)
	{
		echo '<pre>';
		print_r($val);
		echo '</pre>';
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - insert_board()
	내용	 - 게시판 글 등록하기
	------------------------------------------------------------------------------------*/
	public function insert_board($board_info)
	{
		$this->db->set('reg_date', 'now()', FALSE);
		$this->db->insert('board', $board_info);

		//for debug
		//echo $this->db->last_query();

		return $this->db->insert_id();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_board_list()
	내용	 - 게시판 리스트 가져오기
	------------------------------------------------------------------------------------*/
	public function select_board_list($paging = false,$menu_id = false)
	{
		$this->db->select('SQL_CALC_FOUND_ROWS *', false);
		$this->db->from('board');
		//$this->db->group_by('no');
		$this->db->order_by('no','desc');
		if(!@$paging['off_set']) $paging['off_set'] = 0;
		if(@$paging['per_page'])
		{
			$this->db->limit($paging['per_page'],$paging['off_set']);
		}

		if(@$paging['searchValue']){
			//searchKey값이 2개일경우
			if(strpos($paging['searchKey'],'.') > 0){
				$searchKey = explode('.',$paging['searchKey']);
				$this->db->like($searchKey[0], @$paging['searchValue']);
				$this->db->like($searchKey[1], @$paging['searchValue']); 
			//searchKey값이 1개일경우
			}else{
				$this->db->like($paging['searchKey'], @$paging['searchValue']);
			}
		}
		$this->db->where('menu_id',$menu_id['no']);
		$result = $this->db->get()->result_array();

		$this->db->select("FOUND_ROWS() as cnt", false);
		$totalResult = $this->db->get();
		$totalCount = $totalResult->row(1)->cnt;

		//등록된 첫번째 이미지 가져오기(썸네일)
		if($result){
			foreach( $result as $key => $value ){
				//게시판 정보가져오기
				$boardInfo = $this->select_board_info($value['menu_id']);
				$files = $this->select_admin_files($value['contents_no']);

				$temp = unserialize($boardInfo['etc_option']);

				if(sizeof($files)){ // 썸네일있을경우
					$file_ex = explode(".",$files[0]['file_name']);
					if($file_ex[1] != 'gif'){ // gif 제외하고 썸네일 이미지 만들기
						$result[$key]['file_name'] = $this->create_thumb($files[0]['file_name'],$temp['thumb_w'],$temp['thumb_h'],$boardInfo);

					}else{ // gif 확장자일경우 그대로
						$result[$key]['file_name'] = '/upload/'.$files[0]['file_name'];
					}
				}else{ // 이미지가 없을경우
					if($boardInfo['type'] != 'L'){ //리스트형일경우 썸네일 생성안함
						$result[$key]['file_name'] = $this->create_thumb('noimage.gif',$temp['thumb_w'],$temp['thumb_h'],$boardInfo);
					}
				}

			}
		}

		//for debug
		//echo $this->db->last_query();

		return array($totalCount, $result);
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - create_thumb()
	내용	 - 썸네일 생성
	------------------------------------------------------------------------------------*/
	function create_thumb($image_file_name, $width, $height, $boardInfo, $thumb_file_name ='')
	{
		$this->load->library('image_lib');
		
		$this->thumb_image_path = "upload/thumb";
		$this->thumb_image_url = "/upload/thumb";
				
		if (!is_dir($this->thumb_image_path))  // 디렉토리 체크 없다면 생성 
		{
			@ mkdir($this->thumb_image_path, 0777);
		}

		$file_ex = explode(".",$image_file_name);

		if($thumb_file_name =='')
			$image_thumb = $this->thumb_image_path."/".$file_ex[0]."_thumb_".$width."_".$height.".".$file_ex[1];
		else
			$image_thumb = $this->thumb_image_path."/".$file_ex[0]."_".$thumb_file_name."_".$width."_".$height.".".$file_ex[1];

		//이미지 없을경우 경로
		if($image_file_name == 'noimage.gif'){
			$config['source_image'] =  "application/views/board/images/".$image_file_name;
		}else{ //업로드된 이미지 경로
			$config['source_image'] =  "upload/".$image_file_name;
		}
		$config['new_image'] = $image_thumb;
		$config['image_library'] = 'GD2' ;
		$config['thumb_marker'] = ""; 
		$config['create_thumb'] = TRUE;
		$config['master_dim'] = 'auto';

		if($boardInfo['type'] == 'A'){
			$config['maintain_ratio'] = FALSE;
		}
		$config['width'] = $width;
		$config['height'] = $height;

		if(!file_exists($image_thumb) && file_exists($config['source_image']))
		{
			$this->image_lib->initialize($config);
			if(!$this->image_lib->resize())
			{	
				return false;
			}else{
				if($thumb_file_name ==''){
					return $this->thumb_image_url."/".$file_ex[0]."_thumb_".$width."_".$height.".".$file_ex[1];
				}else{
					return $this->thumb_image_url."/".$file_ex[0]."_".$thumb_file_name."_".$width."_".$height.".".$file_ex[1];
				}
			}
		}else{
			if($thumb_file_name =='')
			{
				return $this->thumb_image_url."/".$file_ex[0]."_thumb_".$width."_".$height.".".$file_ex[1];
			}else{
				return $this->thumb_image_url."/".$file_ex[0]."_".$thumb_file_name."_".$width."_".$height.".".$file_ex[1];
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_board_detail()
	내용	 - 글 상세내용 가져오기
	------------------------------------------------------------------------------------*/
	//글삽입
	public function select_board_detail($content_no,$menu_id)
	{
		$this->db->select('*');
		$this->db->from('board');
		$this->db->where('no',$content_no);
		$this->db->where('menu_id',$menu_id['no']);
		$row = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $row;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update_board()
	내용	 - 글수정하기
	------------------------------------------------------------------------------------*/
	public function update_board($board_info,$content_no)
	{
		$this->db->where('no',$content_no);
		$this->db->update('board',$board_info);

		//for debug
		//echo $this->db->last_query();

		return true; 
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete_board()
	내용	 - 글삭제하기
	------------------------------------------------------------------------------------*/
	public function delete_board($content_no)
	{
		$this->db->where('no', $content_no);
		$this->db->delete('board');

		//for debug
		//echo $this->db->last_query();

		return true;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_pre_no()
	내용	 - 이전글 번호 가져오기
	------------------------------------------------------------------------------------*/
	public function select_pre_no($content_no,$menu_id)
	{
		$menu_id = $menu_id['no'];

		$this->db->select('no');
		$this->db->from('board');
		$this->db->where("no  = (
									select max(no)
									from board
									where no < '$content_no'
									and menu_id = '$menu_id'
								)
						");
		$row = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $row;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_next_no()
	내용	 - 다음글 번호 가져오기
	------------------------------------------------------------------------------------*/
	public function select_next_no($content_no,$menu_id)
	{
		$menu_id = $menu_id['no'];

		$this->db->select('no');
		$this->db->from('board');
		$this->db->where("no  = (
									select min(no)
									from board
									where no > '$content_no'
									and menu_id = '$menu_id'
								)
						");
		$row = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $row;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - insert_comment()
	내용	 - 댓글 등록하기
	------------------------------------------------------------------------------------*/
	public function insert_comment($comment_info)
	{
		$this->db->set('reg_date', 'now()', FALSE);
		$this->db->insert('comment', $comment_info);

		//for debug
		//echo $this->db->last_query();

		return $this->db->insert_id();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update_comment()
	내용	 - 댓글 수정하기
	------------------------------------------------------------------------------------*/
	public function update_comment($comment_info,$comment_no)
	{
		$this->db->set('reg_date', 'now()', FALSE);
		$this->db->where('no', $comment_no);
		$this->db->update('comment', $comment_info);

		//for debug
		//echo $this->db->last_query();

		return true; 
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_comment_list()
	내용	 - 댓글 리스트 가져오기
	------------------------------------------------------------------------------------*/
	public function select_comment_list($content_no,$paging = false)
	{

		$this->db->select('*');
		$this->db->from('comment');
		$this->db->where('content_no',$content_no);
		$this->db->order_by('no','asc');
		if($paging)
		{
			$this->db->limit($paging['per_page'],$paging['off_set']);
		}
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query();

		return $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - comment_count()
	내용	 - 댓글 개수 가져오기
	------------------------------------------------------------------------------------*/
	public function comment_count($no)
	{
		$this->db->where('content_no',$no);
		//for debug
		//echo $this->db->last_query();

		return $this->db->count_all_results('comment');

	}

	/*------------------------------------[function]-------------------------------------
	함수명   - add_view_count()
	내용	 - 조회수 증가
	------------------------------------------------------------------------------------*/
	public function add_view_count($no)
	{
		// 세션을 확인하여 브라우저를 닫기 전까지는 조회수 증가를 안함
		$session_borad_hit_no = 'session_borad_hit_'.$no;

		if (!$this->session->userdata($session_borad_hit_no)) 
		{
			$sql = "update board set hit=hit+1 where no = '".$no."' ";
			$this->db->query($sql);

			/* 참고소스
			if(!$this->session->userdata($session_board_view_name)){
				$this->db->set('hit', 'hit+1', FALSE);
				$this->db->where('no' , $no);
				$this->db->update('board');
			}
			*/

			//for debug
			//echo $this->db->last_query();

		}

		//세션에 기록
		$this->session->set_userdata($session_borad_hit_no,'Y');

		//for debug
		//$this->debug($this->session->userdata);
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_main_tab_board_list()
	내용	 - 메인 게시판 다중 리스트 가져오기
	------------------------------------------------------------------------------------*/
	public function select_main_tab_board_list($board_data = array(),$data = array())
	{
		if(sizeof($board_data['board_tab_id']))
		{
			foreach($board_data['board_tab_id'] as $key => $list)
			{
				$this->db->select('*');
				$this->db->from('board');
				$this->db->order_by('no','desc');
				$this->db->where('menu_id',$list);
				$this->db->limit($data['tab_limit']);
				$result[]['board_data'] = $this->db->get()->result_array();

				//등록된 글이 없을때
				if(!$result[$key]['board_data']){
					$result[$key]['board_data'][0]['subject'] = 'no_contents';
				}

				//for debug
				//$this->debug($result[$key]['board_data']);
				//게시판 정보 가져오기
				$boardInfo = $this->select_board_info($list);

				$result[$key]['category_name'] = $boardInfo['category_name'];
				$result[$key]['board_id'] = $boardInfo['board_id'];

				//for debug
				//echo $this->db->last_query().'<br>';
			}
		}
		return  $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_main_board_list()
	내용	 - 메인 게시판 리스트 가져오기
	------------------------------------------------------------------------------------*/
	public function select_main_board_list($board_data = array(),$data = array())
	{
		$this->db->select('*');
		$this->db->from('board');
		$this->db->order_by('no','desc');
		$this->db->where('menu_id',$board_data['board_id']);
		$this->db->limit($data['tab_limit']);
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query().'<br>';

		return  $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_new_content()
	내용	 - 최근게시물 가져오기
	------------------------------------------------------------------------------------*/
	public function select_new_content($board_data = array())
	{
		$this->db->select('a.no,a.contents,a.subject,a.reg_date,b.board_id');
		$this->db->from('board a');
		$this->db->join('menu_category b', 'b.no = a.menu_id');
		$this->db->order_by('a.no','desc');
		$this->db->limit($board_data['limit']);
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query().'<br>';

		return  $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_new_reply()
	내용	 - 최근 댓글 가져오기
	------------------------------------------------------------------------------------*/
	public function select_new_reply($board_data = array())
	{
		$this->db->select('a.contents,a.reg_date,b.menu_id,b.no,c.board_id');
		$this->db->from('comment a');
		$this->db->join('board b', 'b.no = a.content_no');
		$this->db->join('menu_category c', 'c.no = b.menu_id');
		$this->db->order_by('a.reg_date','desc');
		$this->db->limit($board_data['limit']);
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query().'<br>';

		return  $result;
	}


	/*------------------------------------[function]-------------------------------------
	함수명   - select_board_info()
	내용	 - 게시판 정보 가져오기
	------------------------------------------------------------------------------------*/
	public function select_board_info($data = array())
	{
		$this->db->select('*');
		$this->db->from('menu_category');
		$this->db->where('no',$data);

		$result = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query().'<br>';

		return  $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_admin_board_list()
	내용	 - 메인 게시판 리스트 가져오기
	------------------------------------------------------------------------------------*/
	public function select_admin_board_list($type = false)
	{
		$this->db->select('no,category_name');
		$this->db->from('menu_category');
		if($type){
			$this->db->where('type',$type);
		}
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query().'<br>';

		return  $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete_comment()
	내용	 - 댓글삭제하기
	------------------------------------------------------------------------------------*/
	public function delete_comment($content_no)
	{
		$this->db->where('no', $content_no);
		$this->db->delete('comment');

		//for debug
		//echo $this->db->last_query();

		return true;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_board_type()
	내용	 - 게시판 타입가져오기
	------------------------------------------------------------------------------------*/
	public function select_board_type($board_id)
	{
		$this->db->select('*');
		$this->db->from('menu_category');
		$this->db->where('board_id', $board_id);

		$result = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - insert_contents_seq()
	내용	 - 컨텐츠 시퀀스 생성
	------------------------------------------------------------------------------------*/
	function insert_contents_seq()
	{
		$this->db->query('insert into admin_contents_seq values()');

		//for debug
		//echo $this->db->last_query();

		return $this->db->insert_id();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_admin_files()
	내용	 - 게시물 첨부파일 이미지 불러오기 
	------------------------------------------------------------------------------------*/
	function select_admin_files($contents_no)
	{
		$this->db->select('*');
		$this->db->from('admin_files');
		$this->db->where('contents_no', $contents_no);
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
		$this->db->where('contents_no', $contents_no);

		//for debug
		//echo $this->db->last_query().'<br>';

		return $this->db->delete('admin_files');
	}
}
?>
