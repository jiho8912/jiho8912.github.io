<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_calender_m extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - insert_schedule_data()
	작성자   - 임지호(2017/04/07),
	목적     - 스케쥴 저장
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function insert_schedule_data($insertData = false)
	{
		if (!$insertData) return false;
		$this->db->insert('scheule_data', $insertData);
		return $this->db->insert_id();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_scheulelist()
	작성자   - 임지호(2017/02/15),
	목적     - 스케쥴 리스트 가져오기
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function select_scheulelist()
	{
		$this->db->select("*");
		$this->db->from("scheule_data");
		$this->db->order_by("no", "asc");
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query();

		return $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_scheule_detail()
	작성자   - 임지호(2017/02/15),
	목적     - 스케쥴 상세정보 가져오기
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function select_scheule_detail($no)
	{
		$this->db->select("*");
		$this->db->from("scheule_data");
		$this->db->order_by("no", "asc");
		$this->db->where('no',$no);
		$result = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $result;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update_schedule_data()
	작성자   - 임지호(2017/02/15),
	목적     - 스케쥴 수정
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function update_schedule_data($insertData,$no)
	{
		$this->db->where('no', $no);
		$this->db->update('scheule_data', $insertData);

		//for debug
		//echo $this->db->last_query();

		return true; 
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - delete_schedule_data()
	작성자   - 임지호(2017/02/15),
	목적     - 스케쥴 삭제
	-------------------------------------------------------------------------------------
		
	작업내역 및 예외사항
	------------------------------------------------------------------------------------*/	
	function delete_schedule_data($no)
	{
		$this->db->where('no',$no);
		$this->db->delete('scheule_data');

		//for debug
		//echo $this->db->last_query();
		//exit;

		return true; 
	}

}
?>