<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_excel_m extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - insert_booklist()
	작성자   - 임지호(2017/02/15),
	목적     - 책 리스트 저장
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function insert_booklist($insertData = false)
	{
		if (!$insertData) return false;
		$this->db->insert('booksearch_data', $insertData);
		return $this->db->insert_id();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete_booklist()
	작성자   - 임지호(2017/02/15),
	목적     - 책 리스트 삭제
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function delete_booklist()
	{
		$this->db->like('no','');
		$this->db->delete('booksearch_data');
		$this->db->query('ALTER TABLE booksearch_data AUTO_INCREMENT 1');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_booklist()
	작성자   - 임지호(2017/02/15),
	목적     - 책 리스트 가져오기
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function select_booklist($paging = array())
	{
		$this->db->select("SQL_CALC_FOUND_ROWS *", false);
		$this->db->from("booksearch_data");
		if(!@$paging['off_set']) $paging['off_set'] = 0;
		if(@$paging['per_page'])
		{
			$this->db->limit($paging['per_page'],$paging['off_set']);
		}
		if(@$paging['searchValue']){
			 $this->db->like($paging['searchKey'], @$paging['searchValue']);
		}

		$this->db->order_by("no", "desc");
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query();

		$this->db->select("FOUND_ROWS() as cnt", false);
		$totalResult = $this->db->get();
		$totalCount = $totalResult->row(1)->cnt;

		//for debug
		//echo $this->db->last_query();

		return array($totalCount, $result);
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_book_excel_list()
	작성자   - 임지호(2017/02/15),
	목적     - 책 엑셀 리스트 가져오기
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function select_book_excel_list($post = array())
	{
		$this->db->select("*");
		$this->db->from("booksearch_data");
		$result = $this->db->get()->result_array();

		return $result;
	}


}
?>