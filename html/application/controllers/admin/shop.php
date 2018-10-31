<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shop extends MY_Controller {

    /**
     * 생성자
     *사용할 모델을 로드해온다
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/admin_shop_category_m');
    }

    /*------------------------------------[function]-------------------------------------
    함수명   - admin_category_list_v()
    내용	 -
    ------------------------------------------------------------------------------------*/
    public function admin_category_list_v()
    {
        $data['categoryList']= $this->admin_shop_category_m->select_category_list(0, 0);
        $this->setViewAdmin('admin/shop/admin_category_list_v',$data);

    }

}

