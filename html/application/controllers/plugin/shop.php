<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends MY_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('pagination');
		$this->load->model('member_m'); //member controller model
		$this->load->model('board_m'); 
		$this->load->model('admin/admin_excel_m');
		$this->load->model('admin/admin_menu_m');
		$this->load->library('common');
		$this->seg_exp = $this->common->segment_explode($this->uri->uri_string());
	}

    public function PgTest()
    {
        $this->setViewUser('plugin/shop/stdpay/INIStdPaySample/INIStdPayRequest',$data);
    }

	function close(){
        $this->setViewUser('plugin/shop/stdpay/INIStdPaySample/close',$data);
    }

    function INIStdPayReturn(){
        $this->setViewUser('plugin/shop/stdpay/INIStdPaySample/INIStdPayReturn',$data);
    }

    function INIStdcancel(){
        $this->setViewUser('plugin/shop/stdpay/INIStdPaySample/INIStdcancel',$data);
    }

    function INIcancel(){
        $this->setViewUser('plugin/shop/stdpay/INIStdPaySample/INIcancel',$data);
    }

    function INIRecancel(){
        $this->setViewUser('plugin/shop/stdpay/INIStdPaySample/INIRecancel',$data);
    }

    function INIrepay(){
        $this->setViewUser('plugin/shop/stdpay/INIStdPaySample/INIrepay',$data);
    }

}

