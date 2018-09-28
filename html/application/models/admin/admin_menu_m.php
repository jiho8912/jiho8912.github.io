<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_menu_m extends CI_Model {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
	}

	// 카테고리 추출
	function select_admin_category_list($type = CATEGORY_TYPE_NORMAL){
	
		$this->db->select('*');
		$this->db->from('menu_category');
		/*
		$this->db->where('type', $type);
		*/
		$result = $this->db->get()->result_array();

		//for debug
		//echo $this->db->last_query();

		return $result;

	}

	// 일반 카테고리 리스트
	function select_category_list($parent_no = 0, $depth = false, $type = false)
	{
		$this->db->select('a.*');
		$this->db->select('(select count(b.no) from menu_category b where b.parent_no = a.no) sub_count', false);
		$this->db->from('menu_category a');
		/*
		$this->db->where('a.type', $type);
		*/
		if ($parent_no >= 0) $this->db->where('a.parent_no', $parent_no);

		if ($depth) $this->db->where('a.depth', $depth);
		$this->db->order_by('a.position', 'asc');

		$result = $this->db->get()->result_array();
		//debug($this->db->last_query());

		return $result;
	}

	// 일반 카테고리 전체 리스트
	function select_category_total_list_array($type = CATEGORY_TYPE_NORMAL)
	{
		$result = $this->select_category_list(-1, false, $type);
	
		if ($result) {
			foreach ($result as $key => $row) {
				// 부모가 있을 경우. 부모정보 추출
				if ($row['parent_no']) {
					$result[$key]['category_name'] = $this->_select_category_parent_name($row['parent_no'], $row['category_name']);
				}
			}
		}

		sort($result);

		return $result;
	}

	// 부모 이름정보 추출
	function _select_category_parent_name($parent_no, $name)
	{
		$this->db->select('a.*');
		$this->db->from('menu_category a');
		//$this->db->where('a.type', CATEGORY_TYPE_NORMAL);
		$this->db->where('a.no', $parent_no);
		
		$result = $this->db->get()->row_array();

		$name = $result['category_name'] . ' > ' . $name;

		// 부모가 있으면 재귀호출
		if ($result['parent_no']) $name = $this->_select_category_parent_name($result['parent_no'], $name);
		return $name;
	}

	// 일반 카테고리 전체리스트 트리구조
	function select_category_tree($parent_no = 0)
	{
		$result = $this->select_category_list($parent_no);

		foreach ($result as $key => $row) {
			if ($row['sub_count']) $result[$key]['sub'] = $this->select_category_tree($row['no']);
		}
		return $result;
	}

	// 일반 카테고리 전체리스트 트리구조
	function select_category($category_no = 0)
	{
		$this->db->select('a.*');
		$this->db->from('menu_category a');
		$this->db->where('a.type', CATEGORY_TYPE_NORMAL);
		$this->db->where('a.no', $category_no);

		$result = $this->db->get()->row_array();

		if (@$result['parent_no']) $result['parent'] = $this->select_category($result['parent_no']);

		// 카테고리 정보 배열 (1,2,3)
		$category = $result;
		@$result['category' . $category['depth']] = $category['no'];
		for ( ; ;) {
			if (!@$category['parent']) break;
			if (@$category['parent']) {
				$category = $category['parent'];
				$result['category' . $category['depth']] = $category['no'];
			}
		}

		return $result;
	}

								//1    2    3
	function select_findCategory($c1, $c2, $c3){
		$q = "";
		if ($c3 != "" && $c2 != "" && $c1 != ""){
			$q = "SELECT * 
					FROM menu_category
					WHERE category_name =  '".$c3."'
						AND parent_no = ( 
							SELECT no
							FROM menu_category
							WHERE category_name =  '".$c2."'
								AND parent_no = ( 
								SELECT no
								FROM menu_category
								WHERE category_name =  '".$c1."' 
									) 
							) ";
		} else if ($c2 != "" && $c1 != ""){
			$q = "SELECT * 
					FROM menu_category
					WHERE category_name =  '".$c2."'
						AND parent_no = ( 
							SELECT no
							FROM menu_category
							WHERE category_name =  '".$c1."'
							) ";
		} else {
			$q = "SELECT * 
					FROM menu_category
					WHERE category_name =  '".$c1."'";
		}
		return $this->db->query($q)->result_array();


	}

	function updateCategory($upData, $no){	
		$this->db->trans_start();

		$this->db->where('no', $no);
		$this->db->update('menu_category', $upData);

		$this->db->trans_complete();

		debug($this->db->last_query());

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}else{
			return true;
		}

	}

}
?>
