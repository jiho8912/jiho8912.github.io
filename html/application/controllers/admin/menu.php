<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends CI_Controller {

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
		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

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
				$this->load->view('admin/admin_menu_v');
				$this->load->view('admin/admin_footer_v'); // 푸터
			}
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_menu_v()
	내용	 - 관리자 메뉴관리
	------------------------------------------------------------------------------------*/
	public function admin_menu_v()
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
				// 카테고리 리스트
				$category_list = $this->admin_menu_m->select_admin_category_list(CATEGORY_TYPE_NORMAL);

				// 카테고리 배열을 jsTree 용 json 으로 변환
				$jsTreeArray = array();
				$jsTreeArray[0]['id'] = 'jRoot';
				$jsTreeArray[0]['parent'] = '#';
				$jsTreeArray[0]['text'] = '전체카테고리';
				$jsTreeArray[0]['state'] = array('opened' => true);
				$jsTreeArray[0]['li_attr'] = array('showyn' => 'Y');
				
				if ($category_list != null && sizeof($category_list) > 0) {
					for ($i = 0; $i < sizeof($category_list); $i++) {
						$temp = unserialize($category_list[$i]['etc_option']);
						$jsTreeArray[$i+1]['id'] = 'j'.$category_list[$i]['no'];
						$jsTreeArray[$i+1]['parent'] = $category_list[$i]['parent_no'] == 0 ? 'jRoot' : 'j'.$category_list[$i]['parent_no'];
						$jsTreeArray[$i+1]['text'] = $category_list[$i]['category_name'];
						$jsTreeArray[$i+1]['state'] = array('opened' => true);
						$jsTreeArray[$i+1]['li_attr'] = array(
							'showyn' => $category_list[$i]['show_yn'],
							'board_id' => $category_list[$i]['board_id'],
							'type' => $category_list[$i]['type'],
							'thumb_w' => $temp['thumb_w'],
							'thumb_h' => $temp['thumb_h'],
							'menu_id' => $category_list[$i]['no'],
						);
					}
				}
				$category_list = json_encode($jsTreeArray);
				$data['type'] = CATEGORY_TYPE_NORMAL;
				$data['category_list'] = $category_list;

				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
				$this->load->view('admin/admin_menu_v',$data);
				$this->load->view('admin/admin_footer_v',$data); // 푸터
			}
		}
	}

	// 카테고리 저장
	public function category_save($data = array()){
		
		$no = $this->input->post('no');
		$name = $this->input->post('name');
		$showyn = $this->input->post('showyn');
		$board_id = $this->input->post('board_id');
		$type = $this->input->post('type');

		$deniedArray = array(
				"no", "name", "showyn", "board_id", "type"
		);

		foreach($_POST as $key=>$value){
			$boolResult = true;
			foreach($deniedArray as $dbKey){
				if($key==$dbKey){
					$boolResult = false;
					break;
				}
			}
			if($boolResult) $etcData[$key] = $_POST[$key];
		}

		$etc = serialize($etcData);

		if($type == 'P'){
			$link_url = '/plugin/';
		}else{
			$link_url = '/board/list_v/';
		}

		$updateData = array(
			'category_name' => $name,
			'show_yn' => $showyn,
			'board_id' => $board_id,
			'type' => $type,
			'etc_option' => $etc,
			'link_url' => $link_url,
		);

		$this->db->where('no', $no);
		$this->db->update('menu_category', $updateData);

		$this->board_m->alert('저장 되었습니다.', '/admin/menu/admin_menu_v');
	}

	// 서브 카테고리 추가
	public function subCategory_save($data = array()){
		$name = $this->input->post('name');
		$parent = $this->input->post('no');
		$depth = $this->input->post('depth');
		$type = $this->input->post('type');

		$insertData = array(
			'type' => $type,
			'parent_no' => $parent,
			'depth' => $depth,
			'category_name' => $name,
		);

		$this->db->insert('menu_category', $insertData);

		$this->board_m->alert('추가 되었습니다.', '/admin/menu/admin_menu_v');
	}

	// 카테고리 삭제
	public function category_delete($data = array()){

		$type = $this->input->post('type');
		$nos = $this->input->post('nos');
		$nos = str_replace('j', '', $nos);
		$nos = explode(';', $nos);

		// xml 로드
		if(file_exists($this->evironmentFile)){
			$result = $this->admin_m->get_xml($this->evironmentFile);
			if($result){
				foreach($result as $key=>$value){
					$tab[$key] = $value;
				}
			}
		}
		
		//for debug
		//$this->board_m->debug($tab);
	
		/*
		for($i = 1; $i <= 5; $i++){
			$t = $tab['tab'.$i].',';
		}
		*/

		if ($nos != null && sizeof($nos) > 0) {
			$this->db->or_where_in('no', $nos);
			$this->db->delete('menu_category');

			$this->board_m->alert('삭제 되었습니다.', '/admin/menu/admin_menu_v');
		} else {
			$this->board_m->alert('선택된 카테고리가 없습니다.');
		}
	}

}

