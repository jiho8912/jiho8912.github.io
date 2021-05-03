<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Excel extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('member_m'); //member controller model
		$this->load->model('board_m'); 
		$this->load->model('admin/admin_m');
		$this->load->model('admin/admin_menu_m');
		$this->load->model('admin/admin_excel_m');
		$this->load->library("PHPExcel");
		// 일반 카테고리
		if (!defined('CATEGORY_TYPE_NORMAL')) define('CATEGORY_TYPE_NORMAL', 0);
		$this->evironmentFile = "enviroment.xml";
	}
	public function index()
	{
		$data['url'] = $this->uri->segment(2); //url

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
			$this->load->view('admin/admin_excel_v',$data);
			$this->load->view('admin/admin_footer_v'); // 푸터
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - admin_excel_v()
	내용	 - 관리자 엑셀 플러그인페이지
	------------------------------------------------------------------------------------*/
	public function admin_excel_v()
	{
		$data['url'] = $this->uri->segment(2); //url

		// 카테고리 리스트
		$data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

		//로그인 안했을경우
		if(!$this->session->userdata('mb_id')){;
			$this->load->view('admin/admin_header_v',$data); // 헤더
			$this->load->view('admin/admin_login_v',$data);
			$this->load->view('admin/admin_footer_v',$data); // 푸터
		}else{
			//회원상세정보 가져오기
			$admin_id = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

			if($admin_id['no'] != 1)
			{
				$this->member_m->alert('관리자가 아닙니다.','/');
			}else{
				$this->load->view('admin/admin_header_v',$data); // 헤더
				$this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
				$this->load->view('admin/admin_excel_v',$data);
				$this->load->view('admin/admin_footer_v',$data); // 푸터
			}
		}
	}
	/*------------------------------------[function]-------------------------------------
	함수명   - product_excel_download()
	작성자   - 임지호(2017/02/14),
	목적	 - 엑셀 다운로드
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function product_excel_download($data = array())
	{
		$pl = $this->admin_excel_m->select_book_excel_list();

		$obj = new PHPExcel();
		$obj->getProperties()->setCreator("jiho");
		$obj->getProperties()->setLastModifiedBy("jiho");
		$obj->getProperties()->setTitle("Product Excel List");
		$obj->getProperties()->setSubject("Product Excel List");
		$obj->getProperties()->setDescription(date("Y-m-d"). "Product Excel List");

		$obj->setActiveSheetIndex(0)
			->SetCellValue('A1', '제목')
			->SetCellValue('B1', '분류')
			->SetCellValue('C1', '권수')
			->SetCellValue('D1', '저자')
			->SetCellValue('E1', '책장번호');

		if($pl != null && sizeof($pl)){
			for($i=0; $i<sizeof($pl); $i++){
				
				$p = $pl[$i];

				$c0 = @$p['book_name'] ? $p['book_name'] : '';
				$c1 = @$p['kind'] ? $p['kind'] : '';
				$c2 = @$p['book_count'] ? $p['book_count'] : '';
				$c3 = @$p['writer'] ? $p['writer'] : '';
				$c4 = @$p['position'] ? $p['position'] : '';

				$obj->getActiveSheet()->SetCellValue('A'.($i+2), $c0);
				$obj->getActiveSheet()->SetCellValue('B'.($i+2), $c1);
				$obj->getActiveSheet()->SetCellValue('C'.($i+2), $c2);
				$obj->getActiveSheet()->SetCellValue('D'.($i+2), $c3);
				$obj->getActiveSheet()->SetCellValue('E'.($i+2), $c4);
			}
		}

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.gmdate('y-m-d').'도서리스트.xlsx"');
		header('Cache-Control: max-age=0');
		header('Cache-Control: max-age=1');
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objw = PHPExcel_IOFactory::createWriter($obj, 'Excel2007');
		$objw->save('php://output');
		exit;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - excelup()
	작성자   - 임지호(2017/02/14),
	목적	 - 엑셀 업로드
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function excelup($data = array())
	{
		$config['upload_path'] = 'upload/excel/';
		$config['allowed_types'] = 'xlsx';
		$config['max_size']	= '90000';
		
		$this->load->library('upload');
		$this->upload->initialize($config);

		if ($this->upload->do_upload())
		{

			if(file_exists($config['upload_path'])){
				//delete_files($upload_config['upload_path']); // 기존파일 삭제
				$this->admin_excel_m->delete_booklist(); // 기존리스트 삭제
			}

			$fileData = $this->upload->data();
			//print_r($fileData);exit;
			// 업로드 엑셀 파입에 따른 리더 결정
			$er = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($fileData['full_path']));

			// 엑셀 파일 로드
			$excel = $er->load($fileData['full_path']);
			// 읽을 시트 설정
			$sheet = $excel->getSheet(0);
			// 최대 행 수 구하기
			$lastRowIndex = $sheet->getHighestRow();
			// 최대 열 이름 구하기
			$lastColumnName = $sheet->getHighestColumn();

			// 리스트 배열 만들기
			$ExcelArray = array();

			// 1번은 타이틀이기때문에 제외한 그다음부터 최대 행 까지 로드하여 배열에 저장
			for ($row = 2; $row <= $lastRowIndex; $row++){ 
				$ExcelArray[] = $sheet->rangeToArray('A' . $row . ':' . $lastColumnName . $row, NULL, TRUE, FALSE);
			}

			// 0 제목
			// 1 종류
			// 2 권수
			// 3 저자
			// 4 위치
			$success = 0;

			for ($i=0; $i<sizeof($ExcelArray); $i++){
				$p = $ExcelArray[$i][0];
				// 업로드 맵 작성

				$insertData = array();

				$insertData['book_name'] = $p[0];
				$insertData['kind'] = $p[1];
				$insertData['book_count'] = $p[2];
				$insertData['writer'] = $p[3];
				$insertData['position'] = $p[4];

				$insert_no = $this->admin_excel_m->insert_booklist($insertData);

				if($insert_no){
					$success++;
				}

			}
			//exit;
			$this->member_m->alert(($lastRowIndex-1) . '건의 도서리스트 중 '.$success.'건이 업로드 되었습니다', '/admin/excel');
		}else{
			$this->member_m->alert('선택된 파일이 없습니다.');
		}

	}

}