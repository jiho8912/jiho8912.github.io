<?
class Member_m extends CI_Model {

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
	함수명   - select_member_id()
	내용	 - 아이디 확인
	------------------------------------------------------------------------------------*/
	public function select_member_id($id)
	{
		$this->db->where('mb_id',$id);

		//for debug
		//echo $this->db->last_query();

		return $this->db->count_all_results('members');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_member_pw()
	내용	 - 비밀번호 확인
	------------------------------------------------------------------------------------*/
	public function select_member_pw($id)
	{
		$this->db->select('mb_password');
		$this->db->from('members');
		$this->db->where('mb_id',$id);

		$row = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $row;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - is()
	내용	 - id 유무 확인
	------------------------------------------------------------------------------------*/
	public function is($kind,$id)
	{
		$this->db->where($kind,$id);
		$count = $this->db->count_all_results('members');

		//for debug
		//echo $this->db->last_query();

		return $count;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - insert_member_info()
	내용	 - 회원가입
	------------------------------------------------------------------------------------*/
	public function insert_member_info($mb_info)
	{
		$this->db->insert('members',$mb_info);

		//for debug
		//echo $this->db->last_query();

		return $this->db->insert_id();
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_mb_detail()
	내용	 - 회원상세정보 가져오기
	------------------------------------------------------------------------------------*/
	public function select_mb_detail($mb_id)
	{
		$this->db->select('*');
		$this->db->from('members');
		$this->db->where('mb_id',$mb_id);

		$row = $this->db->get()->row_array();

		//for debug
		//echo $this->db->last_query();

		return $row;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - update_member_info()
	내용	 - 회원정보수정
	------------------------------------------------------------------------------------*/
	public function update_member_info($mb_info,$mb_id)
	{
		$this->db->where('mb_id',$mb_id);
		$this->db->update('members',$mb_info);
		//for debug
		//echo $this->db->last_query();

		return true;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_mb_list()
	내용	 - 회원리스트 가져오기
	------------------------------------------------------------------------------------*/
	public function select_mb_list($paging = false)
	{
		$this->db->select('SQL_CALC_FOUND_ROWS *', false);
		$this->db->from('members');
		$this->db->order_by('no','desc');

		if(!@$paging['off_set']) $paging['off_set'] = 0;
		if(@$paging['per_page'])
		{
			$this->db->limit($paging['per_page'],$paging['off_set']);
		}

		if(@$paging['searchValue']){
			$this->db->like($paging['searchKey'], @$paging['searchValue']);
		}

		$result = $this->db->get()->result_array();
		$this->db->select("FOUND_ROWS() as cnt", false);
		$totalResult = $this->db->get();
		$totalCount = $totalResult->row(1)->cnt;

		//for debug
		//echo $this->db->last_query();

		return array($totalCount, $result);
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - select_mb_list()
	내용	 - 회원정보 삭제
	------------------------------------------------------------------------------------*/
	public function delete_member_list($no)
	{
		$this->db->where_in('no', $no);
		$this->db->delete('members');
		//for debug
		//echo $this->db->last_query();

		return true;
	}

}
?>
