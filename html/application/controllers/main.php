<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('board_m');
		$this->load->model('admin/admin_m');
		$this->load->model('/admin/admin_menu_m');
		$this->evironmentFile = "enviroment.xml";
	}
	public function index()
	{
		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수

		// xml 로드
		if(file_exists($this->evironmentFile)){
			$result = $this->admin_m->get_xml($this->evironmentFile);
			if($result){
				foreach($result as $key=>$value){
					$data[$key] = $value;
				}
			}
		}

		//좌표구하기
		/*
		$addr =urlencode($data['addr'].' '.$data['addr2']);
		$xml_contents=$this->getgooglemapXml2('address='.$addr.'&sensor=true');
		$xml=simplexml_load_string($xml_contents, 'SimpleXMLElement', LIBXML_NOCDATA);

		$xml_array = (array)$xml;
		$xml_array = $xml_array['result'];

		$xml_array = (array)$xml_array;
		$xml_array = $xml_array['geometry'];

		$xml_array = (array)$xml_array;
		$xml_array = $xml_array['location'];

		$position = (array)$xml_array;
		
		$data['positionX'] = $position['lat'];
		$data['positionY'] = $position['lng'];
		*/
		//print_R($position);

		//좌표구하기

		//3탭 게시판 설정
		$board_data['board_tab_id'] = array(
			$data['tab1'],
			$data['tab2'],
			$data['tab3'],
		);

		$data['main_tab_board_data'] = $this->board_m->select_main_tab_board_list($board_data,$data);//게시판 다중 리스트 가져오기

		//게시판 ID (admin에서 설정하도록 개발해야함)
		$board_data['board_id'] = $data['tab4'];

		$data['main_board_data_1'] = $this->board_m->select_main_board_list($board_data,$data);//게시판 리스트 가져오기 1

		//게시판 이름 가져오기 1
		$data['main_board_1'] = $this->board_m->select_board_info($board_data['board_id']);

		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		$paging['per_page'] = 4; //한페이지당 표시할 개수

		$menu_id['no'] = $data['tab5']; //메인 이미지 노출 게시판 주소

		$main_thumbnail_url = $this->board_m->select_board_info($menu_id['no']);
		$data['main_thumbnail_url'] = $main_thumbnail_url['board_id']; //메인 이미지 게시판 board_id

		list($paging['recordCount'], $data['board_list']) = $this->board_m->select_board_list($paging,$menu_id);//게시판 리스트 가져오기

		// 카테고리 리스트
		$data['category_list'] = $this->admin_menu_m->select_category_tree();
		//debug($data['category_list']);
		//메인 로테이션 이미지 불러오기
		$data['main_back_img'] = $this->admin_m->select_background_img();

		//for debug
		//$this->board_m->debug($data['category_list']);

		$this->load->view('head',$data);
		$this->load->view('index',$data);
		$this->load->view('footer');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - getgooglemapXml2()
	내용	 - 주소 파싱
	------------------------------------------------------------------------------------*/
	function getgooglemapXml2($google_local_url, $type="coord2addr"){

		$pquery = $google_local_url;
		$fp = fsockopen ("maps.google.co.kr", 80, $errno, $errstr, 30);

		if (!$fp) {
			echo "$errstr ($errno)";
		} else {
			fputs($fp, "GET /maps/api/geocode/xml?");
			fputs($fp, $pquery);
			fputs($fp, " HTTP/1.1\r\n");
			fputs($fp, "Host: maps.googleapis.com\r\n");
			fputs($fp, "Connection: Close\r\n\r\n");

			$header = "";
			while (!feof($fp)) {
				$out = fgets ($fp,512);
				if (trim($out) == "") {
					break;
				}
				$header .= $out;
			}

			$mapbody = "";
			while (!feof($fp)) {
				$out = fgets ($fp,512);
				//$mapbody .= getEUC_KR($out);
				$mapbody .= $out;
			}

			$idx = strpos(strtolower($header), "transfer-encoding: chunked");

			if ($idx > -1) { // chunk data
				$temp = "";
				$offset = 0;

				do {
					$idx1 = strpos($mapbody, "\r\n", $offset);
					$chunkLength = hexdec(substr($mapbody, $offset, $idx1 - $offset));

					if ($chunkLength == 0) {
						break;
					} else {
						$temp .= substr($mapbody, $idx1+2, $chunkLength);
						$offset = $idx1 + $chunkLength + 4;
					}
				} while(true);

				$mapbody = $temp;
			}

			fclose ($fp);
		}

		// 여기까지 주소 검색 xml 파싱
		return $mapbody;
	}//end function

}