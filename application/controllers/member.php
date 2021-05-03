<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	 /**
	 * 생성자
	 *사용할 모델을 로드해온다 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation'); //폼검증 라이브러리
		$this->load->model('member_m'); //member controller model
		$this->load->model('board_m');
		$this->load->model('/admin/admin_m');
		$this->load->model('/admin/admin_menu_m');
	}
	public function index()
	{
		$this->load->view('head');
		$this->load->view('index');
		$this->load->view('footer');
	}
	/*------------------------------------[function]-------------------------------------
	함수명   - login_v()
	내용	 - 로그인페이지
	------------------------------------------------------------------------------------*/
	public function login_v()
	{
		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		$data['category_list'] = $this->admin_menu_m->select_category_tree();

		$data['is_member'] = "1";

		if($this->session->userdata('mb_id'))
		{
			$this->member_m->alert('로그인 상태입니다.','/');
		}else{

			$this->load->view('head',$data);
			$this->load->view('member/login_v',$data);
			$this->load->view('footer');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - in()
	내용	 - 로그인
	------------------------------------------------------------------------------------*/
	public function in()
	{
		if($this->input->post('mb_id'))
		{
			$mb_id = $this->input->post('mb_id');
		}else{
			$this->member_m->alert('아이디를 입력해주세요.');
		}

		if($this->input->post('mb_password'))
		{
			$mb_password = $this->input->post('mb_password');
		}else{
			$this->member_m->alert('비밀번호를 입력해주세요.');
		}

		//아이디 확인
		$id = $this->member_m->select_member_id($mb_id);
		if($id == 0)
		{
			$this->member_m->alert('등록된 아이디가 없습니다.');
		}

		//비밀번호 확인
		$pw = $this->member_m->select_member_pw($mb_id);
		if($pw['mb_password'] != md5($mb_password))
		{
			$this->member_m->alert('비밀번호를 확인해주세요.');
		};

		$user_data = array(
			'mb_id'=>$mb_id,
			'mb_password'=>$mb_password,
        );

		$this->session->set_userdata($user_data);
		$this->member_m->alert('로그인 되었습니다.','/');
		exit;
	}

    /*------------------------------------[function]-------------------------------------
    함수명   - sns_in_front()
    내용	 - sns 로그인
    ------------------------------------------------------------------------------------*/
    public function sns_in_front()
    {
        $mb_id = $this->input->post('type') . '_' .$this->input->post('mb_id');
        $mb_password = $this->input->post('mb_password');
        $mb_name = $this->input->post('mb_name');
        $mb_hp = $this->input->post('mb_hp');
        $mb_email = $this->input->post('mb_email');

        if(!$mb_id)
        {
            $this->admin_m->result_json(false, '아이디를 입력해주세요.');
        }

        //sns id로 가입
        $is_id = $this->member_m->is('mb_id',$mb_id);

        if($is_id == 0 ){

            $reg_date = date("Y-m-d H:i:s");

            $mb_info = array(
                'mb_id' => $mb_id,
                'mb_password' => $mb_password,
                'mb_name' => $mb_name,
                'mb_hp' => $mb_hp,
                'mb_email' => $mb_email,
                'reg_date' => $reg_date,
            );

            $insert_id = $this->member_m->insert_member_info($mb_info);

            if($insert_id > 0)
            {
                //세션값 삽입
                $this->session->set_userdata(array('mb_id'=>$mb_id));
                $this->admin_m->result_json(true, '로그인되었습니다.');
            }else{
                $this->admin_m->result_json(false, '로그인에 실패하였습니다.');
            }
        }else{
            //세션값 삽입
            $this->session->set_userdata(array('mb_id'=>$mb_id));
            $this->admin_m->result_json(true, '로그인되었습니다.');
        }
    }

	/*------------------------------------[function]-------------------------------------
	함수명   - sns_in_backend()
	내용	 - sns 로그인
	------------------------------------------------------------------------------------*/
	public function sns_in_backend($params = array())
	{
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

        $mb_id = $params['type'] . '_' . $params['mb_id'];
        $mb_password = $params['mb_password'];
        $mb_name = $params['mb_name'];
        $mb_hp = $params['mb_hp'];
        $mb_email = $params['mb_email'];


		if(!$mb_id)
		{
            echo '<script>alert("아이디값이 없습니다."); self.close();</script>';
		}

        //회원상세정보 가져오기
        $data = $this->member_m->select_mb_detail($mb_id);

		if(!$data){

			$reg_date = date("Y-m-d H:i:s");

			$mb_info = array(
				'mb_id' => $mb_id,
				'mb_password' => $mb_password,
				'mb_name' => $mb_name,
				'mb_hp' => $mb_hp,
				'mb_email' => $mb_email,
				'reg_date' => $reg_date,
			);

			$insert_id = $this->member_m->insert_member_info($mb_info);
			
			if($insert_id > 0)
			{
                //세션값 삽입
                $this->session->set_userdata(array('mb_id'=>$mb_id));
                echo '<script>alert("로그인 되었습니다.");</script>';
			}else{
                echo '<script>alert("로그인에 실패하였습니다.");</script>';
            }
		}else{
            //세션값 삽입
            $this->session->set_userdata(array('mb_id'=>$mb_id));
            echo '<script>alert("로그인 되었습니다.");</script>';
		}

        echo '<script>opener.location.href = "/"; self.close();</script>';

        //header("location:" . $this->session->userdata('return_url'));
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - logout_v()
	내용	 - 로그아웃
	------------------------------------------------------------------------------------*/
	public function logout_v()
	{
	    // 네이버 연동 아이디일경우

        if(strpos($this->session->userdata('mb_id'), 'naver') !== false){
            $urlArray = array(
                'grant_type' => 'delete',
                'client_id' => NAVER_CLIENT_ID,
                'client_secret' => NAVER_CLIENT_SECRET,
                'access_token' => $this->session->userdata('access_token'),
                'service_provider' => 'NAVER'
            );

            $naver_curl = 'https://nid.naver.com/oauth2.0/token';
            $naver_curl = $naver_curl . '?' . http_build_query($urlArray);

            curlCall($naver_curl);
        }


		$this->session->sess_destroy();
		$this->member_m->alert('로그아웃 되었습니다.','/member/login_v');
		exit;
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - join_v()
	내용	 - 회원가입
	------------------------------------------------------------------------------------*/
	public function join_v()
	{
		$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
		$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

		$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

		$data['category_list'] = $this->admin_menu_m->select_category_tree();

		$data['is_member'] = "1";

		$this->load->view('head',$data);
		$this->load->view('member/join_v',$data);
		$this->load->view('footer');
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - join()
	내용	 - 회원가입
	------------------------------------------------------------------------------------*/
	public function join()
	{

		if($this->input->post('mb_id'))
		{
			$mb_id = $this->input->post('mb_id');
		}else{
			$this->member_m->alert('아이디를 입력해주세요.');
		}

		if($this->input->post('mb_password'))
		{
			$mb_password = $this->input->post('mb_password');
		}else{
			$this->member_m->alert('비밀번호를 입력해주세요.');
		}

		if($this->input->post('mb_name'))
		{
			$mb_name = $this->input->post('mb_name');
		}else{
			$this->member_m->alert('이름을 입력해주세요.');
		}

		if($this->input->post('mb_email'))
		{
			$mb_email = $this->input->post('mb_email');
		}else{
			$this->member_m->alert('이메일을 입력해주세요.');
		}

		$reg_date = date("Y-m-d H:i:s");

		$mb_info = array(
			'mb_id' => $mb_id,
			'mb_password' => md5($mb_password),
			'mb_name' => $mb_name,
			'mb_hp' => $this->input->post('mb_hp'),
			'mb_email' => $mb_email,
			'reg_date' => $reg_date,
		);

		$insert_id = $this->member_m->insert_member_info($mb_info);
		
		if($insert_id > 0)
		{	
			$this->member_m->alert('회원가입이 완료되었습니다.','/');
		}else{
			$this->member_m->alert('회원가입에 실패하였습니다.','/');
		}
	}

	/*------------------------------------[function]-------------------------------------
	함수명   - id_check()
	내용	 - id 중복 확인
	------------------------------------------------------------------------------------*/
	public function id_check()
	{
		$reg_mb_id = $this->input->post('reg_mb_id');
		$TRUE = $FALSE = FALSE;

		if (preg_match("/[^0-9a-z_]+/i", $reg_mb_id))
			$FALSE = '영문자, 숫자, _ 만 입력하세요.';
		else if (strlen($reg_mb_id) < 3)
			$FALSE = '최소 3자이상 입력하세요.';
		else {
			$row = $this->member_m->is('mb_id',$reg_mb_id);
			if ($row != 0)
				$FALSE = '이미 사용중인 아이디 입니다.';
			else {
				if (preg_match("/[\,]?".$reg_mb_id."/i", $this->config->item('cf_prohibit_id')))
					$FALSE = '예약어로 사용할 수 없는 아이디 입니다.';
				else
					$TRUE = '사용하셔도 좋은 아이디 입니다.';
			}
		}

		if ($TRUE)
			echo '<span class="text-success">'.$TRUE.'</span>';
		else if ($FALSE)
			echo '<span class="text-danger">'.$FALSE.'</span>';
	}
	/*------------------------------------[function]-------------------------------------
	함수명   - email_check()
	내용	 - 이메일 중복확인
	------------------------------------------------------------------------------------*/
	function email_check() {
		$reg_mb_email = $this->input->post('reg_mb_email');
		$mb_id = $this->input->post('mb_id');

		if(!$mb_id){
			$mb_id = $this->session->userdata('mb_id');
		}

		$TRUE = $FALSE = FALSE;

		//회원상세정보 가져오기
		$data['mb_detail'] = $this->member_m->select_mb_detail($mb_id);

		if (trim($reg_mb_email) == '')
			$FALSE = '이메일 주소를 입력하세요.';
		else if (!preg_match("/^[0-9a-zA-Z_-]+@[a-zA-Z]+(\.[a-zA-Z]+){1,2}$/", $reg_mb_email))
			$FALSE = '이메일 주소가 형식에 맞지 않습니다.';
		else {
			$row = $this->member_m->is('mb_email', $reg_mb_email);
			// 기존 메일과 입력한메일이 같을경우 제외
			if($data['mb_detail']['mb_email'] == $reg_mb_email){
                $row = $row - 1;
            }
			if ($row > 0){
				$FALSE = '이미 존재하는 이메일 주소입니다.';
			}else{
				$TRUE = '사용가능한 이메일 주소입니다.';
			}
		}

		if ($TRUE)
			echo "<span class='text-success'>".$TRUE.'</span>';
		else if ($FALSE)
			echo '<span class="text-danger">'.$FALSE.'</span>';
	}
	/*------------------------------------[function]-------------------------------------
	함수명   - update_v()
	내용	 - 회원정보 수정
	------------------------------------------------------------------------------------*/
	public function update_v()
	{
		if($this->session->userdata('mb_id'))
		{
			//회원상세정보 가져오기
			$data['mb_detail'] = $this->member_m->select_mb_detail($this->session->userdata('mb_id'));

			$board_data['limit'] = 5; //메인 노출 게시판 표시할 리스트개수
			$data['select_main_new_data'] = $this->board_m->select_new_content($board_data);//최근 게시물 가져오기

			$data['select_new_reply'] = $this->board_m->select_new_reply($board_data);//최근 댓글물 가져오기

			$data['category_list'] = $this->admin_menu_m->select_category_tree();

			$data['is_member'] = "1";

			//for debug
			//$this->member_m->debug($data['mb_detail']);

			$this->load->view('head',$data);
			$this->load->view('member/update_v',$data);
			$this->load->view('footer');
		}else{
			$this->member_m->alert('잘못된 접근입니다.','/');
		}
	}
	/*------------------------------------[function]-------------------------------------
	함수명   - update()
	내용	 - 회원정보 수정
	------------------------------------------------------------------------------------*/
	public function update()
	{
		$config = array(
			array('field'=>'mb_password', 'label'=>'비밀번호', 'rules'=>'trim|required|max_length[20]'),
			array('field'=>'mb_name', 'label'=>'이름', 'rules'=>'trim|required|max_length[10]'),
			array('field'=>'mb_email', 'label'=>'이메일', 'rules'=>'trim|required|max_length[50]|valid_email'),
		);

		$this->form_validation->set_rules($config);
		
		if ($this->form_validation->run() == FALSE) {
			$this->update_v();
		}else{
			$mb_id = $this->input->post('mb_id');

            $data['mb_detail'] = $this->member_m->select_mb_detail($mb_id);

            $row = $this->member_m->is('mb_email', $this->input->post('mb_email'));
            // 기존 메일과 입력한메일이 같을경우 제외
            if($data['mb_detail']['mb_email'] == $this->input->post('mb_email')){
                $row = $row - 1;
            }
            if($row > 0){
                alert('이미 존재하는 이메일 입니다.');
            }

			$mb_info = array(
				'mb_password' => md5($this->input->post('mb_password')),
				'mb_name' => $this->input->post('mb_name'),
				'mb_hp' => $this->input->post('mb_hp'),
				'mb_email' => $this->input->post('mb_email'),
			);

			$update_id = $this->member_m->update_member_info($mb_info,$mb_id);

			if($update_id){
                alert('정상적으로 수정되었습니다.','/');
			}else{
                alert('회원정보 수정에 실패하였습니다.');
			}
			$this->load->view('head');
			$this->load->view('member/update_v');
			$this->load->view('footer');
		}
	}

    /**
     * @return string
     */
    public function generate_state(){

        // 상태 토큰으로 사용할 랜덤 문자열을 생성
        $mt = microtime();
        $rand = mt_rand();
        $state = md5($mt . $rand);

        // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
        $return_array = array(
            'state' => $state,
            'return_url' => $_SERVER['HTTP_REFERER']
        );

        $this->session->set_userdata($return_array);

        echo $state;
    }

    /**
     *
     */
    public function callback_url(){

        $return_code = $this->input->get('code');
        $return_state = $this->input->get('state');
        $state = $this->session->userdata('state');
        if($state != $return_state){
            alert('토큰값 불일치!', '',true);
        }else{
            $urlArray = array(
                'grant_type' => 'authorization_code',
                'client_id' => NAVER_CLIENT_ID,
                'client_secret' => NAVER_CLIENT_SECRET,
                'redirect_uri' => NAVER_CALLBACK_URL,
                'code' => $return_code,
                'state' => $return_state
             );

            $naver_curl = 'https://nid.naver.com/oauth2.0/token';
            $naver_curl = $naver_curl . '?' . http_build_query($urlArray);

            $result = curlCall($naver_curl);

            if($result['res_code'] == 200){
                $responseArr = json_decode($result['response'], true);
                // 토큰값으로 네이버 회원정보 가져오기
                $headers = array(
                    'Host: openapi.naver.com',
                    'Pragma: no-cache',
                    'Accept: */*',
                    sprintf('Authorization: Bearer %s', $responseArr['access_token'])
                );
                $this->session->set_userdata(array('access_token' => $responseArr['access_token']));
                unset($response,$responseArr);

                $url = 'https://openapi.naver.com/v1/nid/me';
                $result = curlCall($url,$headers);

                $responseArr = json_decode($result['response'], true);

                if($result['res_code'] == 200) {
                    $parmas = array(
                        'mb_id' => $responseArr['response']['id'],
                        'mb_name' => $responseArr['response']['name'],
                        'mb_email' => $responseArr['response']['email'],
                        'mb_password' => $this->session->userdata('access_token'),
                        'type' => 'naver'
                    );

                    $this->sns_in_backend($parmas);
                }else{
                    alert('네이버 정보가져오기에 실패하였습니다.', '',true);
                }
            }else{
                alert('토큰값을 가져오지못했습니다.', '',true);
            }

        }

        //header("location:" . $this->session->userdata('return_url'));
    }

    public function callback_url_kakao(){
        $return_code = $this->input->get('code');
        $return_state = $this->input->get('state');
        $state = $this->session->userdata('state');

        if($state != $return_state){
            alert('토큰값 불일치!', '',true);
        }else{
            $parmas = array(
                'grant_type' => 'authorization_code',
                'client_id' => KAKAO_APP_KEY,
                //'client_secret' => KAKAO_CLIENT_SECRET,
                'redirect_uri' => KAKAO_CALLBACK_URL,
                'code' => $return_code
            );

            $headers = array(
                'Content-type: application/x-www-form-urlencoded;charset=utf-8'
            );

            $kakao_curl = 'https://kauth.kakao.com/oauth/token';

            $result = curlCall($kakao_curl, $headers, $parmas, 'post');
debug($parmas,$result);
exit;
            if($result['res_code'] == 200){
                $responseArr = json_decode($result['response'], true);
                // 토큰값으로 네이버 회원정보 가져오기
                $headers = array(
                    'Host: openapi.naver.com',
                    'Pragma: no-cache',
                    'Accept: */*',
                    sprintf('Authorization: Bearer %s', $responseArr['access_token'])
                );
                $this->session->set_userdata(array('access_token' => $responseArr['access_token']));
                unset($response,$responseArr);

                $url = 'https://openapi.naver.com/v1/nid/me';
                $result = curlCall($url,$headers);

                $responseArr = json_decode($result['response'], true);

                if($result['res_code'] == 200) {
                    $parmas = array(
                        'mb_id' => $responseArr['response']['id'],
                        'mb_name' => $responseArr['response']['name'],
                        'mb_email' => $responseArr['response']['email'],
                        'mb_password' => $this->session->userdata('access_token'),
                        'type' => 'naver'
                    );

                    $this->sns_in_backend($parmas);
                }else{
                    alert('네이버 정보가져오기에 실패하였습니다.', '',true);
                }
            }else{
                alert('토큰값을 가져오지못했습니다.', '',true);
            }

        }
    }

}

