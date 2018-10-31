<?

class Visitor_m extends CI_Model
{

    public function __construct()
    {
        parent:: __construct();
        $this->load->database();
    }

    function select_visitor_list($paging = false)
    {

        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
        $this->db->from('user_log');
        $this->db->order_by('no', 'desc');

        if (!@$paging['off_set']) $paging['off_set'] = 0;
        if (@$paging['per_page']) {
            $this->db->limit($paging['per_page'], $paging['off_set']);
        }

        if (@$paging['searchValue']) {
            $this->db->like($paging['searchKey'], @$paging['searchValue']);
        }

        $result = $this->db->get()->result_array();
        $this->db->select("FOUND_ROWS() as cnt", false);
        $totalResult = $this->db->get();
        $totalCount = $totalResult->row(1)->cnt;

        //for debug
        //debug($this->db->last_query());

        return array($totalCount, $result);
    }

    function select_current_visitor_list()
    {
        $sql = "SELECT a.session_id,a.ip_address,a.user_agent,a.current_page,a.last_activity,b.user_data FROM user_log AS a
            JOIN ci_sessions AS b
            ON a.session_id = b.session_id
            WHERE NO IN
            (SELECT MAX(NO)
                FROM user_log AS a
                JOIN ci_sessions AS b
                ON a.session_id = b.session_id
                GROUP BY a.session_id
                ORDER BY a.no DESC)
            ORDER BY b.last_activity desc
        ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }


    function insertVisitor()
    {
        $session_id = $this->session->userdata['session_id'];

        $this->db->trans_start();

        /*
        $this->db->select('last_activity');
        $this->db->from('user_log');
        $this->db->where("no = (select max(no) from user_log where session_id = '$session_id')", NULL, FALSE);
        $row = $this->db->get()->row_array();
        */

        //debug($row,$this->session->userdata);

        $logData = array(
            'session_id' => $session_id,
            'ip_address' => $this->session->userdata['ip_address'],
            'user_agent' => $this->session->userdata['user_agent'],
            'current_page' => $_SERVER['REQUEST_URI'],
            'last_activity' => now(),
        );

        $this->db->insert('user_log', $logData);


        $this->db->trans_complete();
    }
}