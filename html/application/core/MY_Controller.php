<?php

class MY_Controller extends CI_Controller
{
    private $headerInfo;

    function __construct()
    {
        parent::__construct();
        $this->load->model('admin/admin_menu_m');

        // 정적 파일 정보
        define('__ROOT__', dirname(dirname(__FILE__)));
        define('CSS_DIR', '/static/css');
        define('JS_DIR', '/static/js');

        // 사이트 타이틀
        $_SERVER['DOCUMENT_TITLE'] = 'jiho';
        // 리턴 url
        $returnURL = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/';
        $this->returnURL = preg_replace('/http[s]?:\/\/' . $_SERVER['HTTP_HOST'] . '/', '', $returnURL);
        $this->URL = $_SERVER['REQUEST_URI']; // 현재 URL

        if(!$this->uri->segment(3)){
            alert('잘못된 접근입니다.');
        }
        //$this->is_login = $this->session->userdata(''); //
    }

    // 관리자 페이지 설정
    function setViewUser($viewPath, $data)
    {
        $urlArray = $this->seg_exp['query_string'];
        $board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
        $data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기
        $data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기
        $data['category_list'] = $this->admin_menu_m->select_category_tree();

        $this->_makeHeaderInfo();
        $data['headerInfo'] = $this->headerInfo;

        $this->load->view('head',$data); // 헤더
        $this->load->view($viewPath);
        $this->load->view('footer'); // 푸터
    }

    // 관리자 페이지 설정
    function setViewAdmin($viewPath, $data)
    {
        $data['url'] = $this->uri->segment(2);

        // 카테고리 리스트
        $data['admin_category_list'] = $this->admin_menu_m->select_category_tree();

        $this->_makeHeaderInfo();
        $data['headerInfo'] = $this->headerInfo;
        //$data['admin_menu'] = $this->admin_category(); // 좌측 카테고리 추후 추가예정

        $this->load->view('admin/admin_header_v',$data); // 헤더
        $this->load->view('admin/admin_left_menu_v',$data); // 좌측메뉴
        $this->load->view($viewPath);
        $this->load->view('admin/admin_footer_v'); // 푸터
    }

    // 관리자 카테고리
    function admin_category()
    {

        $admin_menu = array(
            'top_menu' => array(
                array('title' => '상품관리', 'link' => '/seller/product/list')
            , array('title' => '주문관리', 'link' => '/')
            , array('title' => '회원관리', 'link' => '/')
            , array('title' => '문의관리', 'link' => '/')
            , array('title' => 'SMS관리', 'link' => '/')
            , array('title' => '정산/통계', 'link' => '/')
            , array('title' => '환경설정', 'link' => '/seller/setting/myinfo')
            )
        , 'left_menu' => array(
                'product' => array(
                    array(
                        'title' => '상품관리'
                    , 'icon' => 'fa fa-list-alt'
                    , 'link' => array(
                        array('text' => '내 상품리스트', 'url' => '/seller/product/list')
                    , array('text' => '상품등록(개별)', 'url' => '/seller/product/register')
                    , array('text' => '대량상품관리', 'url' => '/')
                    , array('text' => '카테고리 관리', 'url' => '/seller/product/category/list')
                    )
                    )
                , array(
                        'title' => '상품공급자 관리'
                    , 'icon' => 'fa fa-shopping-cart'
                    , 'link' => array(
                            array('text' => '상품공급자 리스트', 'url' => '/')
                        , array('text' => '개별 계약관리', 'url' => '/')
                        )
                    )
                , array(
                        'title' => '네오클라우드'
                    , 'icon' => 'fa fa-cloud'
                    , 'link' => array(
                            array('text' => '네오클라우드란', 'url' => '/')
                        , array('text' => '환경설정', 'url' => '/')
                        , array('text' => '상품수집(베이직)', 'url' => '/')
                        , array('text' => '상품수집(아마존)', 'url' => '/')
                        , array('text' => '쇼핑몰 분석신청', 'url' => '/')
                        , array('text' => '분석 신청관리현황', 'url' => '/')
                        )
                    )
                )

            , 'setting' => array(
                    array(
                        'title' => '환경설정'
                    , 'icon' => 'fa fa-cog'
                    , 'link' => array(
                        array('text' => '판매자정보', 'url' => '/seller/setting/myinfo')
                    , array('text' => '결제수단 설정', 'url' => '/')
                    , array('text' => '도서산간 추가배송비 설정', 'url' => '/')
                    , array('text' => 'ID추가', 'url' => '/')
                    , array('text' => '엑셀 다운로드 설정', 'url' => '/')
                    , array('text' => '반품/교환 정보 설정', 'url' => '/seller/setting/refund')
                    , array('text' => '구매 전 공지사항 설정', 'url' => '/seller/setting/purNotice')
                    , array('text' => '판매자 샵 설정', 'url' => '/')
                    , array('text' => '판매자 샵 정책설정', 'url' => '/')
                    , array('text' => '공급자 관리', 'url' => '/')
                    , array('text' => '부계정 설정', 'url' => '/')
                    )
                    )
                )

            , 'main' => array(
                    array(
                        'title' => '회원관리'
                    , 'icon' => 'fa fa-user'
                    , 'link' => array(
                        array('text' => '셀러 리스트', 'url' => '/admin/main/sellerList')
                    , array('text' => '관리자 리스트', 'url' => '/admin/main/adminList')
                    )
                    )
                , array(
                        'title' => '게시판관리'
                    , 'icon' => 'fa fa-comments-o'
                    , 'link' => array(
                            array('text' => '공지사항', 'url' => '/admin/main/list/notice')
                        , array('text' => '1:1문의', 'url' => '/admin/main/list/question')
                        , array('text' => '자주묻는 질문', 'url' => '/admin/main/list/faq')
                        )
                    )
                )
            )
        );

        // 로그인상태일경우 메뉴변경
        if ($this->is_admin) {
            $admin = array('title' => '관리자 설정', 'link' => '/admin/main/sellerList');
            array_push($admin_menu['top_menu'], $admin);
        }
        return $admin_menu;
    }

    function _makeHeaderInfo()
    {
        $_uri = array();
        $exp_uri = explode('/', $_SERVER['REQUEST_URI']);

        foreach ($exp_uri as $i => $uri) {
            if (empty($uri)) continue;
            preg_match('/(.*)\?.*/i', $uri, $match);
            //if(count($match)>0) continue;
            $_uri[] = $uri;
        }
        /*------------------------------------
        cmd별 자동 JS / CSS 로드
        ------------------------------------*/
        $addJS = array();
        $addCSS = array();
        $fileNames = array();
        if (count($_uri) < 1) {
            $_uri[] = 'main';
        }
        foreach ($_uri as $name) {
            $fileNames[] = $name;
            $jsFile = $this->_checkFile($fileNames, 'js');
            $cssFile = $this->_checkFile($fileNames, 'css');
            if ($jsFile) $addJS = array_merge($addJS, $jsFile);
            if ($cssFile) $addCSS = array_merge($addCSS, $cssFile);
        }
        unset($fileNames);
        $this->headerInfo = array('JS' => $addJS, 'CSS' => $addCSS, 'url' => $_uri);
    }


    function _checkFile($files, $ext = 'js', $dir = '')
    {
        $rootDir = $_SERVER['DOCUMENT_ROOT'];
        if ($ext == 'js') $defaultDir = $dir ? $dir : JS_DIR;
        else if ($ext == 'css') $defaultDir = $dir ? $dir : CSS_DIR;

        $addFile = array();
        if (is_array($files)) {
            $filePath = $rootDir . $defaultDir;
            $file = '/' . implode('/', $files);
            if (file_exists($filePath . $file . '.' . $ext)) $addFile[] = $defaultDir . $file . '.' . $ext;
        } else {
            $filePath = $rootDir . $defaultDir;
            $file = '/' . $files;
            if (file_exists($filePath . $file . '.' . $ext)) $addFile[] = $defaultDir . $file . '.' . $ext;
        }
        return $addFile;
    }

}
