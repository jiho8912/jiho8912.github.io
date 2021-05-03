<? include $_SERVER["DOCUMENT_ROOT"] . '/common/classes/comm/JSON.php'; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . '/common/classes/comm/debug.php'; ?>
<?php
if(! class_exists("Common") )	{
    function formatXml($xmlString)
    {
        $xmlDocument = new DOMDocument('1.0');
        $xmlDocument->preserveWhiteSpace = false;
        $xmlDocument->formatOutput = true;
        $xmlDocument->loadXML($xmlString);

        return $xmlDocument->saveXML();
    }

    function arr_get($array, $key, $default = null){
        return isset($array[$key]) ? $array[$key] : $default;
    }

	function timeStringNow()
	{
		$timestamp = time();
		$dt = new DateTime("now", new DateTimeZone('Asia/Seoul')); //first argument "must" be a string
		$dt->setTimezone(new DateTimeZone('Europe/London')); //adjust the object to correct timestamp
		return $dt->format('Y-m-d\TH:i:s\Z');
	}
	class Common
	{
	// 인증된 IP
	var $auth_ip = array(

		"211.52.72.1" ,
		"211.52.72.2" ,
		"211.52.72.3" ,
		"211.52.72.4" ,
		"211.52.72.5" ,
		"211.52.72.6" ,
		"211.52.72.7" ,
		"211.52.72.8" ,
		"211.52.72.9" ,
		"211.52.72.10" ,

		"211.52.72.11" ,
		"211.52.72.12" ,
		"211.52.72.13" ,
		"211.52.72.14" ,
		"211.52.72.15" ,
		"211.52.72.16" ,
		"211.52.72.17" ,
		"211.52.72.18" ,
		"211.52.72.19" ,
		"211.52.72.20" ,

		"211.52.72.21" ,
		"211.52.72.22" ,
		"211.52.72.23" ,
		"211.52.72.24" ,
		"211.52.72.25" ,
		"211.52.72.26" ,
		"211.52.72.27" ,
		"211.52.72.28" ,
		"211.52.72.29" ,
		"211.52.72.30" ,

		"211.52.72.31" ,
		"211.52.72.32" ,
		"211.52.72.33" ,
		"211.52.72.34" ,
		"211.52.72.35" ,
		"211.52.72.36" ,
		"211.52.72.37" ,
		"211.52.72.38" ,
		"211.52.72.39" ,
		"211.52.72.40" ,

		"211.52.72.41" ,
		"211.52.72.42" ,
		"211.52.72.43" ,
		"211.52.72.44" ,
		"211.52.72.45" ,
		"211.52.72.46" ,
		"211.52.72.47" ,
		"211.52.72.48" ,
		"211.52.72.49" ,
		"211.52.72.50" ,

		"211.52.72.51" ,
		"211.52.72.52" ,
		"211.52.72.53" ,
		"211.52.72.54" ,
		"211.52.72.55" ,
		"211.52.72.56" ,
		"211.52.72.57" ,
		"211.52.72.58" ,
		"211.52.72.59" ,
		"211.52.72.60" ,

		"211.52.72.61" ,
		"211.52.72.62"
	) ;

	var $metaTitle 		= Array(
			"/" => "로얄캐리비안 크루즈, 세계 최대 22만톤 크루즈선 오아시스호 보유 선사"
		,	"/sunsa/sunsa_info.php?top_menu_id=1&menu_id=1" => "로얄캐리비안 크루즈, 로얄캐리비안 인터내셔널 선사소개"
		,	"/sunsa/sunsa_info.php?menu_id=1&sunsa_no=2" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선사소개"
		,	"/sunsa/sunsa_info.php?menu_id=1&sunsa_no=3" => "로얄캐리비안 크루즈, 아자마라 크루즈 선사소개"
		,	"/sunsa/sunsa_ebrochure.php?top_menu_id=1&menu_id=152" => "로얄캐리비안 크루즈 E브로셔"
		,	"/ship/owner_cruise.php?top_menu_id=2&menu_id=2" => "로얄캐리비안 크루즈, 로얄캐리비안 인터내셔널 보유 크루즈쉽"
		,	"/ship/owner_cruise.php?menu_id=2&sunsa_no=2" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 보유 크루즈쉽"
		,	"/ship/owner_cruise.php?menu_id=2&sunsa_no=3" => "로얄캐리비안 크루즈, 아자마라 크루즈 보유 크루즈쉽"
		,	"/cruiseonly/cruise_only_list.php?top_menu_id=3&menu_id=138" => "로얄캐리비안 크루즈, 실시간 일정 조회 및 예약"
		,	"/cruise_guide/guide_template.php?top_menu_id=3&menu_id=23" => "로얄캐리비안 크루즈, 기항지 관광 조회 예약하기"
		,	"/cruise_guide/guide_template.php?top_menu_id=3&menu_id=21" => "로얄캐리비안 크루즈, 항구 정보"
		,	"/cruise_guide/guide_template_popup.php?menu_id=14" => "로얄캐리비안 크루즈, 크루즈와 훼리의 차이점"
		,	"/cruise_guide/guide_template_popup.php?menu_id=15" => "로얄캐리비안 크루즈, 크루즈 요금 포함사항"
		,	"/cruise_guide/guide_template_popup.php?menu_id=75" => "로얄캐리비안 크루즈, 크루즈 운항지역"
		,	"/cruise_guide/guide_template_popup.php?menu_id=84" => "로얄캐리비안 크루즈, 크루즈에서의 하루"
		,	"/cruise_guide/guide_template_popup.php?menu_id=102" => "로얄캐리비안 크루즈, 크루즈 상품종류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=103" => "로얄캐리비안 크루즈, 일정고르기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=139" => "로얄캐리비안 크루즈, 가족여행"
		,	"/cruise_guide/guide_template_popup.php?menu_id=140" => "로얄캐리비안 크루즈, 허니문"
		,	"/cruise_guide/guide_template_popup.php?menu_id=105" => "로얄캐리비안 크루즈, 예약 전 체크사항"
		,	"/cruise_guide/guide_template_popup.php?menu_id=106" => "로얄캐리비안 크루즈, 예약방법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=337" => "로얄캐리비안 크루즈, 온라인으로 예약하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=107" => "로얄캐리비안 크루즈, 예약, 결제, 취소료 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=336" => "로얄캐리비안 크루즈, 크루즈 서류 안내"
		,	"/cruise_guide/guide_template_popup.php?menu_id=335" => "로얄캐리비안 크루즈, 승선서류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=323" => "로얄캐리비안 크루즈, 검역질문서"
		,	"/cruise_guide/guide_template_popup.php?menu_id=321" => "로얄캐리비안 크루즈, 짐택 – 짐표 Luggage tag"
		,	"/cruise_guide/guide_template_popup.php?menu_id=322" => "로얄캐리비안 크루즈, 승선카드 SeaPass Card"
		,	"/cruise_guide/guide_template_popup.php?menu_id=377" => "로얄캐리비안 크루즈, 미국, 중국, 호주 비자 정보"
		,	"/cruise_guide/guide_template_popup.php?menu_id=366" => "로얄캐리비안 크루즈, 안전방침"
		,	"/cruise_guide/guide_template_popup.php?menu_id=363" => "로얄캐리비안 크루즈, 안전훈련"
		,	"/cruise_guide/guide_template_popup.php?menu_id=367" => "로얄캐리비안 크루즈, 승무원 안전훈련"
		,	"/cruise_guide/guide_template_popup.php?menu_id=368" => "로얄캐리비안 크루즈, 사고예방대책"
		,	"/cruise_guide/guide_template_popup.php?menu_id=49" => "로얄캐리비안 크루즈, 여행시 짐꾸리기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=63" => "로얄캐리비안 크루즈, 준비서류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=331" => "로얄캐리비안 크루즈, 승선서류 작성하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=330" => "로얄캐리비안 크루즈, 승선수속"
		,	"/cruise_guide/guide_template_popup.php?menu_id=108" => "로얄캐리비안 크루즈, 하선절차"
		,	"/cruise_guide/guide_template_popup.php?menu_id=340" => "로얄캐리비안 크루즈, 승선에서 하선까지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=359" => "로얄캐리비안 크루즈, 크루즈 플라이 – 싱가포르 CruiseFly"
		,	"/cruise_guide/guide_template_popup.php?menu_id=109" => "로얄캐리비안 크루즈, 사전예약서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=324" => "로얄캐리비안 크루즈, 마이타임다이닝"
		,	"/cruise_guide/guide_template_popup.php?menu_id=325" => "로얄캐리비안 크루즈, 기항지관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=327" => "로얄캐리비안 크루즈, 와인 음료 패키지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=393" => "로얄캐리비안 크루즈, 선내 시설이용 계약서"
		,	"/cruise_guide/guide_template_popup.php?menu_id=394" => "로얄캐리비안 크루즈, 인공파도타기 레슨"
		,	"/cruise_guide/guide_template_popup.php?menu_id=37" => "로얄캐리비안 크루즈, 온라인체크인"
		,	"/cruise_guide/guide_template_popup.php?menu_id=64" => "로얄캐리비안 크루즈, 기항지 관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=58" => "로얄캐리비안 크루즈, 선택관광 신청하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=69" => "로얄캐리비안 크루즈, 선택관광 참여하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=65" => "로얄캐리비안 크루즈, 텐더보트, 기항지 식사"
		,	"/cruise_guide/guide_template_popup.php?menu_id=70" => "로얄캐리비안 크루즈, 선상신문 활용법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=71" => "로얄캐리비안 크루즈, 엔터테인먼트"
		,	"/cruise_guide/guide_template_popup.php?menu_id=72" => "로얄캐리비안 크루즈, 드림웍스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=88" => "로얄캐리비안 크루즈, 브로드웨이 뮤지컬"
		,	"/cruise_guide/guide_template_popup.php?menu_id=282" => "로얄캐리비안 크루즈, 바비 익스피리언스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=90" => "로얄캐리비안 크루즈, 아이스링크"
		,	"/cruise_guide/guide_template_popup.php?menu_id=91" => "로얄캐리비안 크루즈, 암벽등반"
		,	"/cruise_guide/guide_template_popup.php?menu_id=92" => "로얄캐리비안 크루즈, 짚라인"
		,	"/cruise_guide/guide_template_popup.php?menu_id=93" => "로얄캐리비안 크루즈, 인공파도타기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=94" => "로얄캐리비안 크루즈, 미니골프코스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=96" => "로얄캐리비안 크루즈, 면세점 쇼핑"
		,	"/cruise_guide/guide_template_popup.php?menu_id=97" => "로얄캐리비안 크루즈, 미용 & 스파"
		,	"/cruise_guide/guide_template_popup.php?menu_id=98" => "로얄캐리비안 크루즈, 유아, 어린이 & 청소년 프로그램"
		,	"/cruise_guide/guide_template_popup.php?menu_id=99" => "로얄캐리비안 크루즈, 선장파티"
		,	"/cruise_guide/guide_template_popup.php?menu_id=100" => "로얄캐리비안 크루즈, 카지노"
		,	"/cruise_guide/guide_template_popup.php?menu_id=278" => "로얄캐리비안 크루즈, 참여클래스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=402" => "로얄캐리비안 크루즈, 피트니스 센터"
		,	"/cruise_guide/guide_template_popup.php?menu_id=130" => "로얄캐리비안 크루즈, 메인 다이닝"
		,	"/cruise_guide/guide_template_popup.php?menu_id=110" => "로얄캐리비안 크루즈, 원재머 카페 – 뷔페"
		,	"/cruise_guide/guide_template_popup.php?menu_id=115" => "로얄캐리비안 크루즈, 스페셜티 레스토랑"
		,	"/cruise_guide/guide_template_popup.php?menu_id=129" => "로얄캐리비안 크루즈, 룸서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=128" => "로얄캐리비안 크루즈, 음료 패키지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=127" => "로얄캐리비안 크루즈, 바와 라운지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=126" => "로얄캐리비안 크루즈, 카페"
		,	"/cruise_guide/guide_template_popup.php?menu_id=118" => "로얄캐리비안 크루즈, 베이커리 & 아이스크림"
		,	"/cruise_guide/guide_template_popup.php?menu_id=113" => "로얄캐리비안 크루즈, 로얄 브라서리 30 – Royal Brasserie 30"
		,	"/cruise_guide/guide_template_popup.php?menu_id=120" => "로얄캐리비안 크루즈, 조니로켓"
		,	"/cruise_guide/guide_template_popup.php?menu_id=395" => "로얄캐리비안 크루즈, 유아식"
		,	"/cruise_guide/guide_template_popup.php?menu_id=329" => "로얄캐리비안 크루즈, 선내고객서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=333" => "로얄캐리비안 크루즈, 선내 결제"
		,	"/cruise_guide/guide_template_popup.php?menu_id=332" => "로얄캐리비안 크루즈, 룸서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=339" => "로얄캐리비안 크루즈, 인터넷 & 전화 이용"
		,	"/cruise_guide/guide_template_popup.php?menu_id=132" => "로얄캐리비안 크루즈, 선실고르기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=370" => "로얄캐리비안 크루즈, 다인실"
		,	"/cruise_guide/guide_template_popup.php?menu_id=338" => "로얄캐리비안 크루즈, 기본 시설 안내"
		,	"/cruise_guide/guide_template_popup.php?menu_id=279" => "로얄캐리비안 크루즈, 스위트 & 발코니 선실"
		,	"/cruise_guide/guide_template_popup.php?menu_id=280" => "로얄캐리비안 크루즈, 오션뷰/내측 선실"
		,	"/cruise_guide/guide_template_popup.php?menu_id=281" => "로얄캐리비안 크루즈, 크루즈 SOS"
		,	"/cruise_guide/guide_template_popup.php?menu_id=399" => "로얄캐리비안 크루즈, 항구 내 주차 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=398" => "로얄캐리비안 크루즈, 항구 정보"
		,	"/cruise_guide/guide_template_popup.php?menu_id=385" => "로얄캐리비안 크루즈, 카지노 배팅 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=384" => "로얄캐리비안 크루즈, 흡연규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=383" => "로얄캐리비안 크루즈, 투석 관련 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=382" => "로얄캐리비안 크루즈, 휠체어 사용 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=381" => "로얄캐리비안 크루즈, 주류 반입 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=380" => "로얄캐리비안 크루즈, 미성년자 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=379" => "로얄캐리비안 크루즈, 임산부 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=328" => "로얄캐리비안 크루즈, 크루즈 티켓 계약서 내용"
		,	"/cruise_guide/guide_template_popup.php?menu_id=125" => "로얄캐리비안 크루즈, Connect with Us"
		,	"/cruise_guide/guide_template_popup.php?menu_id=123" => "로얄캐리비안 크루즈, 자주 묻는 질문"
		,	"/cruise_guide/guide_template_popup.php?menu_id=122" => "로얄캐리비안 크루즈, 용어사전"
		,	"/cruise_guide/guide_template_popup.php?menu_id=401" => "로얄캐리비안 크루즈, 크루즈 에티켓"
		,	"/cruise_guide/guide_template_popup.php?menu_id=358" => "로얄캐리비안 크루즈, 프로모션 코드"
		,	"/cruise_guide/guide_template_popup.php?menu_id=357" => "로얄캐리비안 크루즈, 아시아 최대 14만톤 마리너호"
		,	"/cruise_guide/guide_template_popup.php?menu_id=356" => "로얄캐리비안 크루즈, 신개념 크루즈 콴텀호"
		,	"/cruise_guide/guide_template_popup.php?menu_id=153" => "로얄캐리비안 크루즈, 셀러브리티 크루즈와 훼리의 차이점"
		,	"/cruise_guide/guide_template_popup.php?menu_id=154" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 요금 포함사항"
		,	"/cruise_guide/guide_template_popup.php?menu_id=159" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 운항지역"
		,	"/cruise_guide/guide_template_popup.php?menu_id=160" => "로얄캐리비안 크루즈, 셀러브리티 크루즈에서의 하루"
		,	"/cruise_guide/guide_template_popup.php?menu_id=155" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 상품 종류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=161" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 일정고르기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=162" => "로얄캐리비안 크루즈, 셀러브리티 갈라파고스 크루즈"
		,	"/cruise_guide/guide_template_popup.php?menu_id=163" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 허니문"
		,	"/cruise_guide/guide_template_popup.php?menu_id=165" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 예약 전 체크사항"
		,	"/cruise_guide/guide_template_popup.php?menu_id=166" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 예약방법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=167" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 예약, 결제, 취소료 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=351" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 서류 안내"
		,	"/cruise_guide/guide_template_popup.php?menu_id=349" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 승선서류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=342" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 검역질문서"
		,	"/cruise_guide/guide_template_popup.php?menu_id=343" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 짐택 – 짐표 Luggage tag"
		,	"/cruise_guide/guide_template_popup.php?menu_id=350" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 승선카드 SeaPass Card 씨패스 카드"
		,	"/cruise_guide/guide_template_popup.php?menu_id=378" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 미국, 중국, 호주 비자 정보"
		,	"/cruise_guide/guide_template_popup.php?menu_id=170" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 여행시 짐꾸리기 준비물"
		,	"/cruise_guide/guide_template_popup.php?menu_id=168" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 준비서류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=345" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 승선서류 작성하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=344" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 승선수속"
		,	"/cruise_guide/guide_template_popup.php?menu_id=171" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 하선절차"
		,	"/cruise_guide/guide_template_popup.php?menu_id=353" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 승선에서 하선까지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=172" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 사전예약가능서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=169" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 온라인 체크인"
		,	"/cruise_guide/guide_template_popup.php?menu_id=348" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 기항지관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=354" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 셀렉트 다이닝"
		,	"/cruise_guide/guide_template_popup.php?menu_id=64" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 기항지 관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=174" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선택관광 신청하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=175" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선택관광 참여하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=176" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 텐더보트, 기항지 식사"
		,	"/cruise_guide/guide_template_popup.php?menu_id=195" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선상신문 활용법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=407" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 스파서비스 – 바디마사지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=406" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 스파서비스 – 피부관리"
		,	"/cruise_guide/guide_template_popup.php?menu_id=408" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=200" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 엔터테인먼트"
		,	"/cruise_guide/guide_template_popup.php?menu_id=201" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 다양한 프로그램"
		,	"/cruise_guide/guide_template_popup.php?menu_id=206" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 컨시어지 서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=196" => "로얄캐리비안 크루즈, 셀러브리티 론 클럽 – Lawn Club"
		,	"/cruise_guide/guide_template_popup.php?menu_id=204" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 iLounge 인터넷"
		,	"/cruise_guide/guide_template_popup.php?menu_id=197" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 핫 글래스 쇼"
		,	"/cruise_guide/guide_template_popup.php?menu_id=203" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 아트옥션"
		,	"/cruise_guide/guide_template_popup.php?menu_id=198" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 갤러리아부티크"
		,	"/cruise_guide/guide_template_popup.php?menu_id=199" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 스파 & 피트니스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=205" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 어린이 & 청소년 프로그램"
		,	"/cruise_guide/guide_template_popup.php?menu_id=207" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 카지노"
		,	"/cruise_guide/guide_template_popup.php?menu_id=371" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 맛 – Taste"
		,	"/cruise_guide/guide_template_popup.php?menu_id=372" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 재충전 – Revive"
		,	"/cruise_guide/guide_template_popup.php?menu_id=373" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 배움 - Learn"
		,	"/cruise_guide/guide_template_popup.php?menu_id=374" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 놀이 – Play"
		,	"/cruise_guide/guide_template_popup.php?menu_id=177" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 메인 다이닝"
		,	"/cruise_guide/guide_template_popup.php?menu_id=179" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 캐주얼 다이닝 & 뷔페"
		,	"/cruise_guide/guide_template_popup.php?menu_id=178" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 스페셜티 레스토랑"
		,	"/cruise_guide/guide_template_popup.php?menu_id=182" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 룸서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=183" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 바와 라운지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=180" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 와인 익스프리언스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=208" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 SOS"
		,	"/cruise_guide/guide_template_popup.php?menu_id=397" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=392" => "로얄캐리비안 크루즈, 셀러브리티 크루즈카지노 배팅 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=391" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 흡연규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=390" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 투석 관련 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=389" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 휠체어 사용 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=388" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 주류 반입 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=387" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 미성년자 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=386" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 임산부 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=347" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 티켓 계약서 내용"
		,	"/cruise_guide/guide_template_popup.php?menu_id=212" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 Connect with Us"
		,	"/cruise_guide/guide_template_popup.php?menu_id=209" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 용어사전"
		,	"/cruise_guide/guide_template_popup.php?menu_id=400" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 에티켓"
		,	"/cruise_guide/guide_template_popup.php?menu_id=192" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 룸서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=346" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선내 결제"
		,	"/cruise_guide/guide_template_popup.php?menu_id=352" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 인터넷 & 전화 이용"
		,	"/cruise_guide/guide_template_popup.php?menu_id=189" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선실고르기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=193" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선실 비품 안내"
		,	"/cruise_guide/guide_template_popup.php?menu_id=186" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 내측, 오션뷰 & 발코니 선실"
		,	"/cruise_guide/guide_template_popup.php?menu_id=355" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 스위트 선실"
		,	"/cruise_guide/guide_template_popup.php?menu_id=188" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 컨시어지 클래스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=187" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 아쿠아 클래스 선실"
		,	"/cruise_guide/guide_template_popup.php?menu_id=213" => "로얄캐리비안 크루즈, 아자마라 크루즈 훼리의 차이점"
		,	"/cruise_guide/guide_template_popup.php?menu_id=214" => "로얄캐리비안 크루즈, 아자마라 크루즈 요금 포함사항"
		,	"/cruise_guide/guide_template_popup.php?menu_id=215" => "로얄캐리비안 크루즈, 아자마라 크루즈 운항지역"
		,	"/cruise_guide/guide_template_popup.php?menu_id=217" => "로얄캐리비안 크루즈, 아자마라 크루즈 상품 종류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=218" => "로얄캐리비안 크루즈, 아자마라 크루즈 일정고르기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=220" => "로얄캐리비안 크루즈, 아자마라 크루즈 예약 전 체크사항"
		,	"/cruise_guide/guide_template_popup.php?menu_id=221" => "로얄캐리비안 크루즈, 아자마라 크루즈 예약방법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=223" => "로얄캐리비안 크루즈, 아자마라 크루즈 승선 준비"
		,	"/cruise_guide/guide_template_popup.php?menu_id=224" => "로얄캐리비안 크루즈, 아자마라 크루즈 온라인체크인"
		,	"/cruise_guide/guide_template_popup.php?menu_id=225" => "로얄캐리비안 크루즈, 아자마라 크루즈 여행시 짐꾸리기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=226" => "로얄캐리비안 크루즈, 아자마라 크루즈 하선절차"
		,	"/cruise_guide/guide_template_popup.php?menu_id=228" => "로얄캐리비안 크루즈, 아자마라 크루즈 기항지 관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=229" => "로얄캐리비안 크루즈, 아자마라 크루즈 선택관광 신청하기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=230" => "로얄캐리비안 크루즈, 아자마라 크루즈 기항지 선택관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=231" => "로얄캐리비안 크루즈, 아자마라 크루즈 기항지 식사"
		,	"/cruise_guide/guide_template_popup.php?menu_id=232" => "로얄캐리비안 크루즈, 아자마라 크루즈 메인 다이닝"
		,	"/cruise_guide/guide_template_popup.php?menu_id=235" => "로얄캐리비안 크루즈, 아자마라 크루즈 뷔페 레스토랑"
		,	"/cruise_guide/guide_template_popup.php?menu_id=239" => "로얄캐리비안 크루즈, 아자마라 크루즈 룸서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=233" => "로얄캐리비안 크루즈, 아자마라 크루즈 아쿠아리나"
		,	"/cruise_guide/guide_template_popup.php?menu_id=234" => "로얄캐리비안 크루즈, 아자마라 크루즈 프라임 씨"
		,	"/cruise_guide/guide_template_popup.php?menu_id=236" => "로얄캐리비안 크루즈, 아자마라 크루즈 풀 그릴"
		,	"/cruise_guide/guide_template_popup.php?menu_id=237" => "로얄캐리비안 크루즈, 아자마라 크루즈 모자이크 카페"
		,	"/cruise_guide/guide_template_popup.php?menu_id=238" => "로얄캐리비안 크루즈, 아자마라 크루즈 와인셀러"
		,	"/cruise_guide/guide_template_popup.php?menu_id=249" => "로얄캐리비안 크루즈, 아자마라 크루즈 선상신문 활용법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=254" => "로얄캐리비안 크루즈, 아자마라 크루즈 엔터테인먼트"
		,	"/cruise_guide/guide_template_popup.php?menu_id=252" => "로얄캐리비안 크루즈, 아자마라 크루즈 면세점 쇼핑"
		,	"/cruise_guide/guide_template_popup.php?menu_id=253" => "로얄캐리비안 크루즈, 아자마라 크루즈 뷰티 살롱"
		,	"/cruise_guide/guide_template_popup.php?menu_id=250" => "로얄캐리비안 크루즈, 아자마라 크루즈 스파"
		,	"/cruise_guide/guide_template_popup.php?menu_id=255" => "로얄캐리비안 크루즈, 아자마라 크루즈 피트니스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=251" => "로얄캐리비안 크루즈, 아자마라 크루즈 침술"
		,	"/cruise_guide/guide_template_popup.php?menu_id=257" => "로얄캐리비안 크루즈, 아자마라 크루즈 카지노"
		,	"/cruise_guide/guide_template_popup.php?menu_id=256" => "로얄캐리비안 크루즈, 아자마라 크루즈 인터넷 서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=241" => "로얄캐리비안 크루즈, 아자마라 크루즈 보유선실"
		,	"/cruise_guide/guide_template_popup.php?menu_id=243" => "로얄캐리비안 크루즈, 아자마라 크루즈 선실고르기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=258" => "로얄캐리비안 크루즈, 아자마라 크루즈 SOS"
		,	"/cruise_guide/guide_template_popup.php?menu_id=259" => "로얄캐리비안 크루즈, 아자마라 크루즈 용어사전"
		,	"/cruise_guide/guide_template_popup.php?menu_id=261" => "로얄캐리비안 크루즈, 아자마라 크루즈 멤버쉽 안내 – Le Club Voyage 르클럽 보야지"
		,	"/cruiseonly/hotDeal.php?top_menu_id=5" => "로얄캐리비안 크루즈 특별요금"
		,	"/hotdeal_plan/plan_list.php?top_menu_id=5&menu_id=158" => "로얄캐리비안 크루즈, 기획전"
		,	"/cruise_guide/guide_template.php?top_menu_id=6&menu_id=38" => "로얄캐리비안 크루즈, 크라운 앵커 멤버쉽 프로그램 - Crown Anchor Membership"
		,	"/cruise_guide/guide_template.php?top_menu_id=6&menu_id=101&sunsa_no=" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 캡틴스 클럽 멤버쉽 신청 - Captains Club"
		,	"/help/applyMember.php?top_menu_id=6&menu_id=42" => "로얄캐리비안 크루즈, 크라운 앵커 멤버쉽 신청 - Crown Anchor Memebership"
		,	"/help/applyMember2.php?top_menu_id=6&menu_id=42" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 캡틴스 클럽 멤버쉽 신청 - Captains Club"
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=1" => "로얄캐리비안 크루즈, 미팅, 인센티브, 차터 - MICE"
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=2" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 미팅, 인센티브, 차터 - MICE"
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=3" => "로얄캐리비안 크루즈, 아자마라 크루즈 미팅, 인센티브, 차터 - MICE"
		,	"/etc2/company.php" => "로얄캐리비안 크루즈"
		,	"/etc2/companyMap.php" => "로얄캐리비안크루즈 한국 총판 찾아가는 방법"
		,	"/help/faqList.php?bd_code=NOFQ" => "로얄캐리비안 크루즈 자주묻는 질문 FAQ"
		,	"/etc2/companySiteMap.php" => "로얄캐리비안 크루즈 홈페이지 사이트맵"
		,	"/etc2/agree.php" => "로얄캐리비안 크루즈 개인정보 취급방침"
	) ;

	var $metaDesc 		= Array(
			"/" => "세계최대크루즈 보유선사, 전세계 크루즈여행 실시간 예약,한국총판 특가할인"
		,	"/sunsa/sunsa_info.php?top_menu_id=1&menu_id=1" => "로얄캐리비안 인터내셔널은 세계 최대 22만톤 크루즈 – 오아시스호, 얼루어호 - 보유 글로벌 리딩 선사로 아쿠아 씨어터, 센트럴 파크. 인공파도타기, 아이스 스케이트 링크, 암벽등반시설 등 혁신적인 선상시설로 크루즈 업계의 역사를 매번 다시 쓰고 있습니다."
		,	"/sunsa/sunsa_info.php?menu_id=1&sunsa_no=2" => "모던 럭셔리 – Modern Luxury – 셀러브리티 크루즈는 클래식한 크루즈의 매력을 현대인의 라이프 스타일에 접목시킨 대표적인 프리미엄 크루즈 선사로 격조 높은 선상시설과 다양한 프로그램, 세심하고 편안한 서비스로 크루즈 애호가들에게 많은 사랑을 받고 있습니다."
		,	"/sunsa/sunsa_info.php?menu_id=1&sunsa_no=3" => "글로벌 디럭스 크루즈의 새로운 기준, 깊고 푸른 바다 위에 빛나는 별인 아자마라 크루즈는 차원이 다른 올 인클루시브 서비스와 함께 기항지에서 하루를 더 머무를 수 있는 오버나잇 일정을 비롯 넉넉한 기항지 체류 시간을 제공합니다. 전세계 곳곳을 만나볼 수 있는 세계 일주 크루즈."
		,	"/sunsa/sunsa_ebrochure.php?top_menu_id=1&menu_id=152" => "로얄캐리비안 크루즈의 로얄캐리비안 인터내셔널과 셀러브리티 크루즈는 다양한 운항지역 – 아시아, 호주, 뉴질랜드, 지중해, 북유럽, 남미, 파나마, 알래스카, 캐나다, 뉴잉글랜드, 카리브해, 바하마, 버뮤다, 갈라파고스, 하와이, 남태평양 - 을 비롯 보유 크루즈쉽 소개를 담은 E-브로셔를 제공합니다. 또한 보유 크루즈선과 크루즈의 일상을 소개한다. "
		,	"/ship/owner_cruise.php?top_menu_id=2&menu_id=2" => "크루즈 업계 대표 아이콘으로 자리한 세계 최대 22만톤 크루즈 오아시스호, 얼루어호를 비롯 아시아 최대 14만톤 보이저호, 마리너호 등의 로얄캐리비안 인터내셔널 소속 22척 크루즈선은 오아시스 클래스, 프리덤 클래스, 보이져 클래스, 레디앙스 클래스, 비전 클래스 등이 있으며, 혁신적인 선상시설 – 아이스 스케이트 링크, 로얄 프라머네이드, 암벽등반, 인공파도타기, 미니골프, 수영장, 스파, 피트니스 – 을 기본으로 한중일, 동남아시아, 지중해 등의 전세계 다양한 지역으로 운항합니다. "
		,	"/ship/owner_cruise.php?menu_id=2&sunsa_no=2" => "바다 위에서 빛나는 가장 아름다운 모던 럭셔리 – Modern Luxury – 셀러브리티 크루즈의 모든 살스티스 클래스는 진정한 웰빙을 즐길 수 있는 아쿠아 스파를 비롯 총 천연잔디의 론클럽까지 최고의 편의시설을 갖추고 있으며, 밀레니엄 클래스를 비롯한 센추리 클래스, 엑스퍼디션 클래스 등 모든 크루즈선은 품격 높은 서비스와 월드 클래스 다이닝으로 크루즈 업계 내 다양한 수상경력을 자랑하고 있습니다."
		,	"/ship/owner_cruise.php?menu_id=2&sunsa_no=3" => "아자마라 크루즈 소속 3만톤 저니호와 퀘스트호는 디럭스 크루즈의 새로운 기준을 제시하며전세계 아름다운 기항지에서 좀 더 많은 오버나잇 일정과 함께 식음료를 포함한 올인클루시브 서비스로 좀 더 특별하고 차별화된 크루즈 여행을 제공합니다."
		,	"/cruiseonly/cruise_only_list.php?top_menu_id=3&menu_id=138" => "크루즈 여행 지역, 출발 월, 출발 항구, 선사, 크루즈쉽 등의 검색 옵션을 변경하시어 로얄캐리비안, 셀러브리티, 아자마라 크루즈의 스케줄 및 일정 요금 선실 가능여부를 실시간으로 조회하거나 예약하실 수 있습니다."
		,	"/cruise_guide/guide_template.php?top_menu_id=3&menu_id=23" => "로얄캐리비안 크루즈 기항지 – LA, 멕시코, 갈라파고스, 남미, 남극, 중동, 바하마, 버뮤다, 북유럽, 아시아, 알래스카 지중해, 유럽, 카리브해, 캐나다, 뉴잉글랜드, 태평양, 파나마, 하와이, 호주, 뉴질랜드 등 전세계 크루즈 기항지의 – 관광 프로그램과 일정을 실시간으로 확인하고 온라인으로 예약할 수 있습니다."
		,	"/cruise_guide/guide_template.php?top_menu_id=3&menu_id=21" => "로얄캐리비안 크루즈 운항 항구 – LA, 멕시코, 갈라파고스, 남미, 남극, 중동, 바하마, 버뮤다, 북유럽, 아시아, 알래스카 지중해, 유럽, 카리브해, 캐나다, 뉴잉글랜드, 태평양, 파나마, 하와이, 호주, 뉴질랜드등 전세계 크루즈 항구 – 위치 정보 및 이동경로 검색이 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=14" => "훼리와는 달리 떠다니는 리조트 로얄캐리비안 크루즈는 크루즈 가격에 수영장, 조깅코스, 스파, 카지노, 암벽등반, 극장, 미니골프, 뷔페 및 정찬 레스토랑까지 이용할 수 있는 모든 것이 포함된 올인클루시브 여행입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=15" => "로얄캐리비안 크루즈 요금은 크루즈 여행의 기본이 되는 객실, 고품격 식사, 엔터테인먼트, 선상 프로그램 및 시설들의 사용료를 모두 포함한 올 인클루시브 금액입니다. 크루즈의 불포함사항을 확인할수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=75" => "글로벌 크루즈 여행 대표선사 로얄캐리비안 크루즈는 1년 365일 유럽, 지중해, 알래스카, 카리브해, 바하마, 버뮤다, 호주, 뉴질랜드, 남미, 아시아 – 동남아, 한국, 중국, 일본, 한중일, 싱가포르 - 등 전세계로 운항합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=84" => "하루 24시간이 모자를 만큼 다양한 선상시설과 엔터테인먼트 프로그램으로 가득 찬 로얄캐리비안 크루즈와 함께하는 크루즈 여행이 더욱 특별해질 수 있도록 크루즈에서의 하루를 미리 다운받아 일정을 계획해 보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=102" => "여행지역, 일정, 기간에 따라 다양한 선택이 가능한 로얄캐리비안 크루즈는 자유개별여행에서부터 시작해, 크루즈와 항공편까지 한번에 편리하게 이용할 수 있는 패키지 여행, 기업 행사 및 인센티브 투어 크루즈까지 예약 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=103" => "로얄캐리비안 크루즈의 환상적인 크루즈 여행 설계는 탑승할 크루즈선, 선실고르기, 기항지 고르기 등 여행시기와 방법등에 따라 다양한 옵션을 선택하시어 나에게 맞는 완벽한 크루즈 일정을 선택하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=139" => "로얄캐리비안 크루즈는 가족 모두가 만족하는 다양한 선상시설, 선상프로그램, 다이닝, 엔터테인먼트 – 드림웍스 익스피리언스, 바비 익스피리언스, 어린이&청소년 프로그램 어드벤처 오션 – 를 제공합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=140" => "단 한번뿐인 특별한 신혼여행, 바다위의 로맨스 허니문 크루즈 – honeymoon at the sea – 일정을 예약하시는 모든 분들께 just married 선실 데코레이션 패키지 – 허니문 패키지 - 를 선사합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=105" => "크루즈 예약관련 체크사항 – 취소료 규정, 서비스 포함 사항, 여행자 보험, 항공, 비자, 결제방법, 탑승 제한 규정 – 에 관한 보다 자세한 사항은 로얄캐리비안 크루즈 한국사무소 대표전화로 문의할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=106" => "로얄캐리비안 크루즈 여행 일정 및 가격 조회와 예약은 한국사무소 홈페이지, 대표전화, 이메일을 통해 요청 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=337" => "로얄캐리비안 크루즈 한국사무소 홈페이지로 접속하시어 전세계 운항 일정, 지역, 선실등급, 크루즈쉽등의 다양한 옵션을 선택하여 나에게 맞는 일정을 온라인으로 예약하세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=107" => "로얄캐리비안 크루즈 한국사무소 발행한 확정서를 통해 예약확정여부, 신청금, 잔금에 대한 비용 결제 방법 – 원화, 외화 – 과 함께 취소료 규정을 확인할수 있다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=336" => "크루즈 티켓에 해당하는 승선서류, 탑승 전 작성이 필요한 검역 질문서 응답지, 선실까지 짐이 안전하게 운송되도록 부착해야 하는 짐택, 크루즈 여행에서 선실 킬, 지불수단, 신분증의 역할을 하는 승선카드 –seapass card - , 크루즈 여행 길잡이 역할을 하는 선상신문 – 크루즈 컴파스, cruise compass – 을 소개합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=335" => "크루즈 여행 출발전 받게되는 승선서류를 어떻게 보는지 어떻게 작성해야되는지, 짐택의 사용방법, 그리고 이용하는 크루즈에 대한 약관등의 내용을 한글로 확인할수 있다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=323" => "크루즈 터미널에서 체크인 시 양식에 맞춰 건강상태를 체크하는 검역 질문서 응답지 – public health questionnaire – 는 크루즈 항구 체크인 터미널에 비치되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=321" => "개인 수화물이 분실되는 것을 방지하기 위해 크루즈 짐택 – lugguage tag – 을 미리 부착하여 크루즈 항구에서 체크인 시 포터에게 짐을 맞기면 기재된 선실정보로 짐이 전달됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=322" => "승선카드 – seapass card – 는 크루즈 여행 중 선실 키, 지불수단, 신분증의 역할을 하며 분실 시 고객데스크에서 재발급 받으실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=377" => "크루즈 여행에 필요한 미국, 호주, 중국 등의 비자 발급은 각 나라에서 요구하는 조건에 맞춰 적법한 서류를 사전에 준비하여야 합니다.  비자발급 방법을 소개하고 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=366" => "국제 해상 안전법에 의해 로얄캐리비안 크루즈 모든 크루즈선에서 실시되는 안전훈련 – muster drill – 은 크루즈 여행 중 발생할 수 있는 응급상황에 대처하기 위한 방법을 연습하는 안전 방침 준수 훈련으로, 이 외에도 해상인명안전협약, 미국 선박보안 및 안전협약, 다양한 국제 규정을 준수합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=363" => "국제법에 의거한 필수사항인 안전훈련 – muster drill - 은 모든 승객과 승무원이 참여해야 하는 훈련으로, 사이렌이 울리면 안전훈련 집결장소로 이동하여 응급상황 발생 시 행동강령과 구명조끼 및 구명보트 사용방법에 대한 훈련을 실시합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=367" => "크루즈선의 모든 승무원은 다양한 응급상황 – 선내 화재, 응급환자 발생, 자연재해, 태풍 – 에 대비한 안전훈련을 매주, 매월, 분기 및 연간으로 정해진 정기훈련을 실시하며 모든 크루즈선에는 전문 안전요원이 탑승하고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=368" => "크루즈 여행 중 발생할 수 있는 모든 응급상황 – 화재, 허리케인, 태풍, 전력공급 차단, 충돌 – 에 대비하며 응급상황 발생 시 신속한 대응을 위한 대응책 및 승무원과 전문요원의 안전훈련은 국제 해상법을 준수하여 진행됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=49" => "크루즈 여행을 위해 챙겨야 할 다양한 필요물품 – 정장, 드레스, 수영복, 운동화, 구두, 상비약, 세면도구, 환전- 을 사전에 체크하시어 미리 준비하도록 합니다. 선내 반입 금지물품 또한 사전에 체크하실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=63" => "크루즈 여행 시 필요한 서류 – 승선서류, 셋세일 패스, 짐택, 항공권, 호텔 바우처, 여권, 비자, 법적 보호자외의 성인과 미성년자가 크루즈 여행시 준비서류, 임산부가 사전에 준비해야되는 서류 – 에 관한 정보를 포함합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=331" => "사전 온라인 체크인을 통해 셋세일 패스를 받은 크루즈 여행 승객은 따로 승선서류를 작성하지 않아도 되지만, 그 밖의 승객은 크루즈 예약번호, 크루즈쉽 명, 승선일, 선실번호, 및 승선카드와 연결할 결제수단 – 현금, 여행자 수표, 신용카드 – 에 대한 선상카드 발급 정보 작성이 필요합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=330" => "크루즈 여행 첫 날 항구 도착 출발 최소 2시간 전까지 해야 하며 크루즈 터미널에 도착하면 수하물수속 – 인당 총 90 키로 허용 – 및 승선서류를 작성하여 승선수속 후 크루즈에 탑승할 수 있습니다. 크루즈 탑승 첫날 어떻게 진행되는지에 대한 내용을 확인하실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=108" => "크루즈 여행의 마지막인 하선을 위해서는 선내에서 사용한 추가 요금 지불 확인 및 고객 만족도 조사를 작성해야 하며, 크루즈 터미널에서 수하물 수령을 할 수 있습니다. 전날 작성한 개인의 귀국 항공편 시간 및 객실 구역에 따라 하선시간을 알리는 안내가 방송됩니다. 안내에 따라 하선을 하며 비행기 예약시 하선절차를 확인해 알맞은 편으로 예약해 주시기 바랍니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=340" => "사전 온라인 체크인 서비스를 신청하지 않은 크루즈 여행 승객은 주요 크루즈 탑승 구비 서류를 들고 크루즈 항구에 도착하여 탑승수속을 해야 하며 수하물 수속 및 수령, 선내 비용 결제 방식 선택 또한 크루즈 터미널에서 가능합니다.또한 크루즈 하선절차는 어떻게되며, 크루즈에서의 화폐기준 등을 확인하실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=359" => "크루즈 플라이 – cruise fly – 는 크루즈 여행 하선 당일 공항에서 소비되는 시간절약과 함께 보다 간편하게 수화물 수속을 도와주는 서비스로 싱가포르 공항에서 다음의 항공사 – 싱가포르 항공, 실크 항공, 에어 차이나. 동방 항공, 남방 항공, 인도항공 – 를 이용하시는 승객에게 유료로 제공됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=109" => "크루즈 여행을 전 사전 예약 서비스 – 기항지 선택관광, 마이 타임 다이닝, 항구 셔틀버스, 스페셜티 레스토랑, 와인 & 음료 패키지, 스파 서비스, 선상 스포츠 시설, 엔터네인먼트 쇼, 기프트, 바비 프리미엄 익스피리언스, 유아용품 – 를 통해 더욱 알찬 크루즈 여행을 계획할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=324" => "마이 타임 다이닝 – my time dining – 은 크루즈 승선 후 원하는 식사시간을 정해서 미리 예약 후 이용할 수 있으며 온라인 사전 예약, 탑승 이후 고객 서비스 데스크 또는 정찬 다이닝 레스토랑에서 예약 가능합니다. 또한 본인의 크루즈 일정에 맞추어 매일 다른시간에 식사를 예약하실수도 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=325" => "전세계 각 지역의 크루즈 기항지를 온라인으로 사전 예약가능한 서비스  – 영문명, 크루즈 예약 번호, 승선일, 크루즈쉽명 정보 필요 - 을 통해 패키지 형태의 기항지 선택관광 – shore excursion - 을 신청할 수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=327" => "알코올 & 무알콜 음료 패키지를 크루즈 여행 시작 전 온라인으로 미리 예약 할 수 있는 서비스로 선내에서 유료로 제공되는 와인, 소다, 주스, 생수 패키지 등의 음료를 할인 된 가격에 예약 할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=393" => "다양한 스포츠 시설 이용을 위해서는 선내 스포츠 시설 이용 참가 신청서 – onboard activity waiver – 를 작성해야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=394" => "오아시스호, 얼루어호, 리버티호, 프리덤호의 인공파도타기 – flow rider – 레슨은 온라인 사전 예약이 가능하며 크루즈 여행 중 꼭 한번 경험해 볼 짜릿한 즐거움입니다. 선내 무료로 이용되는 체험에 비해 전문화된 레슨을 받아보실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=37" => "크루즈 여행의 승선수속 과정을 줄여주는 온라인 체크인 서비스를 위해서는 영문명, 예약번호, 출항일, 크루즈쉽명을 입력하고 조회하여 여권정보, 생년월일, 주소, 연락처, 신용카드 정보 등을 입력하여 셋세일 패스 – setsail pass – 를 출력합니다. 크루즈 터미널에서 보다 신속하고 편리하게 탑승수속을 진행하실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=64" => "크루즈 기항지 관광 shore excursion은 기항지 자유관광과 기항지 선택관광이 있으며 기항지 관광 후 승선 요청 시간 – 크루즈 출항 최소 1시간 전 - 까지 재 승선을 해야 합니다. 크루즈 기항지는 선내 기항지 프로그램을 이용하시거나 혹은 자유여행 가능하십니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=58" => "기항지 선택관광 – shore excursion – 은 온라인으로 브로셔 다운 및 신청이 가능하며 크루즈 승선 후 관광 데스크 예약 및 선내 rctv를 이용해 예약 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=69" => "크루즈 선사 기항지 선택관광 티켓과 영수증을 확인하여 시간에 맞춰 해당 투어 참가 데스크에 집결하여 프로그램 참여 후 재 승선 시간에 맞춰 크루즈쉽으로 재 탑승을 하면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=65" => "크루즈선의 기항지 정박하여 하선을 위해 텐더보트를 사용해야 할 경우, 일반적으로 텐더보트의 티켓에 명시된 시간에 맞춰 무료로 이용하면 되며, 기항지 일정이 있는 날은 관광을 나가지 않고 선내 머무르는 경우 선내에서 제공하는 점심식사를 자유롭게 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=70" => "선상신문 – 크루즈 컴파스, cruise compass – 은 해당일의 일출과 일몰 시간, 재승선 시간, 주요행사, 정찬 다이닝 복장, 레스토랑을 비롯한 시간별 선상 프로그램을 안내하는 일일 신문으로 매일 오후에 선실로 배달되면 고객 안내 데스크에서 언제든 받으실 수 있습니다. 선상신문 샘플로 선내 프로그램을 미리 만나보실수 있으며, 선상신문을 통해 즐거운 크루즈일정을 준비하실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=71" => "다양한 프로덕션쇼, 마술쇼, 코미디쇼, 연주회에서 시작해 YMCA 등 70년대를 테마로 한 디스코 파티, 미니골프, 셔플보드 토너먼트 등을 즐길 수 있으며 크루즈 여행 중 다양한 사람들과 즐거운 사교를 즐길 수 있는 미팅 프로그램까지 다양한 엔터테인먼트를 제공합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=72" => "얼루어호, 오아시스호, 리버티호, 프리덤호, 마리너호, 보이저호에서는 드림웍스 애니매이션의 다양한 캐릭터 – 쿵푸팬더, 슈렉, 장화신은 고양이 – 들을 퍼레이드에서 만나보시거나 함께하는  식사 및 기념 사진 촬영에서 시작해 선상 3D 영화관에서는 드림웍스의 최신 영화를 먼저 만나보실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=88" => "세계 최대 크루즈선인 얼루어호에서는 토니 그래미 수상에 빛나는 시카고, 자매선인 오아시스호에서는 헤어 스프레이, 그리고 유럽 최대 리버티호에서는 토요일 밤의 열기 브로드웨이 뮤지컬을 감상하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=282" => "여자아이들을 위한 바비 익스피리언스 – barbie experience – 의 다양한 프로그램을 사전 예약을 통해 참여할 수 있습니다. 바비 선실 패키지, 인어 댄스 클래스,  패션 디자이너 워크샵, 패션쇼는 방학을 맞은 여자아이들의 크루즈 여행을 더욱 특별하게 만들어 줍니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=90" => "오아시스 클래스, 프리덤 클래스, 보이저 클래스 소속 크루즈쉽에는 전세계 크루즈 선사 최초 도입한 아이스 스케이팅 링크에서 시원한 무대와 음악이 어우러진 아이스 쇼를 감상 할 수 있으며, 직접 스케이팅도 즐기실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=91" => "로얄캐리비안 크루즈 트레이드 마크인 암벽등반은 바다 한 가운데 60m 높이에서 짜릿함을 맛볼 수 있는 선상시설로 rock climbing wall waiver라는 선상시설 이용 동의서 작성 후 이용 할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=92" => "전세계 크루즈 선사 유일한 선상시설인 짚라인 – zip line – 은 줄 하나에 몸을 맡기고 공중을 지나는 짜릿한 경험을 선사합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=93" => "크루즈 선사 최초 도입의 인공파도타기 시설 – flow rider – 는 오직 로얄캐리비안 크루즈 오아시스 클래스, 프리덤 클래스, 콴텀 클래스에서만 제공됩니다. 향후 보이져호에서도 만나보실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=94" => "온 가족 모두가 즐길 수 있는 미니골프코스에서 퍼팅 게임 및 오픈 골프 토너먼트를 즐길 수 있으며 골프 시뮬레이터 예약은 암벽등반 시설에 있는 크루즈 스포츠 스탭에게 요청하면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=96" => "크루즈 선상에 마련된 상점에서 다양한 상품 – 보석, 시계, 패션, 화장품, 기념품 – 을 면세 가격으로 구매 할 수 있으며 특히 클리니크, 에스티로더, 랑콤 등 다양한 화장품과 향수, 스와로브스키와 같은 액세서리를 더욱 저렴한 가격에 구입하실 수 있습니다. 크루즈에서의 쇼핑은 크루즈선이 해상에 있을때만 가능합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=97" => "세계적인 미용 업체인 엘레미스 – elemis – 에서 제공하는 스파 및 미용 프로그램을 유료로 즐길 수 있으며 선상에 마련된 사우나에서 쌓였던 피로를 풀어 보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=98" => "무료로 제공되는 우수 어린이 & 청소년 프로그램인 어드벤처 오션 – adventure ocean – 은 아이들의 연령에 맞춰 다양한 프로그램을 제공하며, 프로그램 참여를 통해 전세계 어린이 크루즈 여행 승객과 자연스럽게 친해지며 영어를 배울 수 있는 좋은 기회를 제공합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=99" => "크루즈 여행 중 최대 하이라이트인 환영 리셉션 파티는 선장 주최 하에 열리는 선산 파티로 선장의 크루즈 여행에 관한 간략한 소개와 환영 인사를 포함 호텔 디렉터, 총 주방장, 크루즈 디렉터, 인터내셔널 엠버서더, 크루즈 승무원, 나라별 탑승객의 인원을 소개하는 시간입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=100" => "라스베가스, 몬테카를로의 카지노가 부럽지 않은 카지노 로얄 – casino royale – 에서 블랙잭, 슬롯 머신, 바카라 등 다양한 테이블 게임을 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=278" => "다양한 댄스 클래스 – 라인댄스, 스윙댄스, 살사댄스, 스윙댄스, 라틴댄스, 디스코, 차차차 - 에서 시작해 타월인형을 직접 접어볼 수 있는 냅킨폴딩 클라스와 나만의 액세서리를 만들어 볼 수 있는 비즈공예, 크루즈 정찬에서 제공하는 디저트 케이크 및 음식 시연 클래스에 참여할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=402" => "모든 크루즈선 내 피트니스 센터는 웨이트 머신, 덤벨, 고정형 스핀 바이크, 스텝퍼, 러닝머신, 사우나, 월풀, 한증막을 이용할 수 있으며, 필라테스, 스피닝, 킥복싱, 펄스널 트레이닝 등 다양한 프로그램을 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=130" => "보는 즐거움과 먹는 즐거움을 동시에 누릴 수 있는 맛의 크루즈 여행 향연 다이닝은 세계적인 주방장이 엄선한 메뉴로 제공되며 정찬식사 시간은 main time, second time, 마이타임 다이닝 – my time dining – 중 선택 할 수 있으며 드레스 코드는 선상신문에 안내됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=110" => "뷔페 스타일로 편하게 식사를 할 수 있는 윈재머 카페는 아침, 점심, 저녁 모두 식사가 가능하며 다양한 세계 각지의 음식을 개인의 취향에 맞게 선택해 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=115" => "좀 더 특별한 다이닝을 원하는 크루즈 승객을 위해 마련된 찹스그릴, 포토피노, 지오바니의 테이블, 이즈미, 150 센트럴 파크 등의 스페셜티 레스토랑에서는 이탈리안, 일식, 전통 스테이크 등을 유료로 줄길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=129" => "크루즈 선실에서 편안한 아침식사를 하고 싶다면 선내 비치된 신청 양식을 작성하여 조식 룸서비스 신청을 하실 수 있으며 또한 선내 전화를 통해 room service 버튼을 눌러 모든 룸서비스를 신청하실 수 있습니다. 룸서비스는 기본 무료이며, 자정부터 새벽 5시까지는 약간의 서비스비용이 발생한다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=128" => "파운티 소다 패키지, 보틀 워터 패키지, 주스 패키지, 와인 패키지 등의 다양한 음료, 생수, 와인 패키지를 신청하시어 크루즈 여행 중 좀 더 저렴한 가격으로 유료 음료 서비스 – beverage service – 혜택을 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=127" => "크루즈 선내 곳곳에 위치한 바와 라운지에서는 음악과 함께 맥주, 와인, 칵테일 등 다양한 주류를 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=126" => "유럽풍 로얄 프라머네이드에 위치한 카페 프라머네이드에서는 커피와 티에서 시작해, 스낵, 패스트리, 샌드위치 등 다양한 음료와 먹을 거리를 제공합니다. 또한 세게 최초 바다에 입점한 스타벅스 카페에서 좀 더 다양한 종류의 커피와 음료를 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=118" => "컵보드 컵케익의 달콤한 컵케익 맛보기와 나만의 컵케익 만들기, 벤엔제리 아이스크림에서 즐기는 아이스크림 선데이, 쉐이크, 스무디, 보드워크 도너츠에서 즐기는 다양한 도너츠로 크루즈 여행을 더욱 달콤하게 해줍니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=113" => "야채, 드레싱, 치킨, 베이컨, 연어 등의 재료를 기호에 맞게 선택하여 자신만의 샐러드를 즉석에서 만들어 즐길 수 있는 로얄 브라서리 30 – royal barasserie 30 – 은 크루즈 여행 중 신선함을 원하는 고객을 위해 마련된 레스토랑으로 오픈시간은 선상신문을 통해 확인 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=120" => "1950년대를 연상시키는 인테리어의 조니로켓은 햄버거와 프렌치 후라이등의 정통 아메리칸 스타일의 메뉴를 즐길 수 있는 레스토랑입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=395" => "유아식 – 이유식 – 은 크루즈 여행 전 사전 구입이 가능하며 이 밖에도 선내 판매하는 이유식, 요거트, 죽등의 대체 음식이 마련되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=329" => "24시간 제공되는 선내 고객서비스는 고객 서비스 데스크인 guest relation desk를 통해 문의가능하며 이 밖에도 의료 서비스, 룸 서비스 – medical service, room service – 를 필요에 따라 사용하실 수 있습니다. 선내에서 전화하는 방법과 결제 및 언어 관한 보다 자세한 정보를 포함합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=333" => "크루즈 선내에서 제공하는 기항지 관광, 면세품 구입, 카지노 칩, 와인, 인터넷 이용 등 모든 결제는 승선카드 – seapass card – 로 지불 가능하며 사용한 금액에 관한 청구서는 하선 전날 선실로 배달됩니다. 선내 결재는 승선시 등록한 신용카드 혹은 현금결재가 가능합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=332" => "크루즈 선실에서 편안한 아침식사를 하고 싶다면 선내 비치된 신청 양식을 작성하여 조식 룸서비스 신청을 하실 수 있으며 선내 전화를 통해 room service 버튼을 누르면 모든 룸서비스를 신청하실 수 있습니다. 룸서비스는 무료로 이용 가능하나 자정부터 새벽 5시까지는 소정의 서비스 비용을 지불하셔야합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=339" => "인터넷 패키지 구입 또는 선상카드 결제를 통해 선상에 마련된 온라인 카페에서 인터넷을 사용할 수 있으며 선실에 비치된 전화를 이용하여 룸서비스 신청 또는 선내 선실간 연락 및 국제전화 사용을 하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=132" => "호텔과 같이 다양한 선택이 가능한 크루즈 선실은 기본적으로 스위트, 발코니, 오션뷰, 내측 선실로 나뉘며 개인의 선택 및 고려사항 – 멀미, 허니문 여행, 그룹 여행, 가족 여행, 휠체어 사용 - 에 따라 크루즈 여행 예약 시 선택하시면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=370" => "크루즈 선실은 다인실 스위트룸에서 시작해 3, 4인 가족이 사용 가능한 선실, 두 선실 사이 벽에 있는 문으로 연결 가능한 커넥팅룸 등 다양한 선택이 가능합니다. 로얄캐리비안 인터네셔널 크루즈는 페밀리룸 -Family room이 있어 5인실 6인실 예약 또한 가능합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=338" => "크루즈 선실은 기본적으로 침대, 욕실, 헤어드라이기, tv, 전화기, 안전금고, 쇼파, 테이블, 옷장, 화장대로 구성되어 있으며 전화 룸서비스 및 개인 선실 온도 조절이 가능하며, 이밖에110v와 220v 모두 사용 가능한 콘센트가 있다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=279" => "다양한 선택이 가능한 선실 중 스위트 선실과 발코니 선실은 기항지 경관을 감상할 수 있어 가장 인기 있는 선실입니다. 로맨틱 선실의 대표인 스위트, 발코니 선실의 내부구조를 확인하실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=280" => "다양한 선택이 가능한 선실 중 오션뷰 선실과 내측선실은 트윈 베드로 변경 가능한 킹사이즈 침대와 함께 개인 욕실 및 쇼파와 테이블, 옷장 등이 마련되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=281" => "크루즈 여행 중 발생할 수 있는 다양한 위급상황 – 비행기 연착, 크루즈 재승선, 멀미, 분실 – 에 대비 할 수 있는 정보를 담고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=399" => "크루즈 터미널 항구 내 주차는 유료이며 항구마다 주차 규정 및 요금이 상이합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=398" => "각 항차별 상이한 크루즈 항구 터미널의 주소와 공항에서 항구까지의 이동방법을 확인 할 수 있습니다. 정확한 항구주소는 승선서류 – cruise ticket bookilet – 를 통해서도 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=385" => "만 18세 이상 이용 가능한 카지노의 배팅 규정 정보입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=384" => "크루즈선의 모든 시설은 금연구역 – smoking policy - 이며 흡연이 가능한 공간은 카지노를 비롯한 지정된 흡연구역으로 한정되며 위반시 $ 250의 과태료가 승선카드로 부과됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=383" => "투석환자 – dialysis- 의 크루즈선 탑승은 사전 공지 하에 가능하며 투석에 필요한 준비물은 최소 2시간 전에 배로 배달되어야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=382" => "크루즈선 탑승 시 개인 휠체어 – wheelchair – 사용은 사전 승인이 요구되며 대여 서비스는 불가능 합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=381" => "주류 반입 규정 - alcohol policy - 에 의거 크루즈 탑승 시 주류는 와인 두병만 선내 반입 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=380" => "미성년자 - minor or child policy - 의 크루즈 탑승 규정은 만 18세에서 만 21세로 지역에 따라 상이하며 가족관계 증명을 위한 영문 주민등록증 등본 사본 또는 영문 부모동의서 사전 공증이 필요합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=379" => "임산부 규정 – pregnancy policy – 은 하선일 기준 24주 미만의 경우 의사의 영문 소견서를 지참한 경우에 한해 탑승 가능하다고 규정짓고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=328" => "㈜투어마케팅코리아에서 제공하는 한굴 크루즈 티켓 계약서는 영어에 익숙하지 못한 한국 이용객의 크루즈 여행에 관한 전반적인 이해를 돕기 위한 용도로 계약 세부 내용 확인을 위해서는 크루즈 티켓 계약 영문 원본을 숙지해야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=125" => "로얄캐리비안 크루즈 한국사무소의 소셜네트워킹 서비스 – 페이스북, 유투브, 플리커, 홈페이지, 트위터, 공식카페 크루즈톡 – 로 크루즈 여행에 관한 다양한 정보 공유에서 시작해 할인혜택 및 이벤트 참여에 관한 정보를 검색해보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=123" => "크루즈 여행에 관한 질문 중 자주 묻는 질문 – 안전, 음주 규정, 흡연 규정, 임산부, 어린이, 청소년, 유아 탑승 규정 – 에 관한 정보를 확인 할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=122" => "크루즈쉽과 관련하여 자주 사용되는 용어 – 스타보드, 포트사이드, 크루즈 톤스, 브릿지, 갤리, 정박, 텐더 – 에 관한 정보를 담고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=401" => "크루즈 여행 중 꼭 지켜야 할 매너인 크루즈 에티켓에 관한 전반적인 정보를 참고해 주시기 바랍니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=358" => "현재 진행중인 이벤트와 더불어 더 많은 할인 혜택을 적용 받을 수 있는 프로모션 및 해당 프로모션 코드에 관한 정보를 확인하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=357" => "가족여행, 허니무너, 각종모임 이벤트등 각종 맞춤 여행이 가능한 크루즈선 마리너호는 한중일을 비롯 아시아 운항 최대 크루즈선으로 14만톤급이며 로얄 프라머네이드, 아이스링크, 암벽등반, 미니골프, 스파, 피트니스등의 다양한 선상시설을 비롯해, 브로드웨이 스타일 엔터테인먼트 공연, 드림웍스, 어린이 청소년 프로그램인 어드벤처까지 다양한 즐길거리가 가득합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=356" => "세계 최초 스카이 다이빙 시뮬레이션과 함께 범퍼카, 롤러스케이트장, 바다 조망 관람차 북극성을 도입한 콴텀호는 다양한 선상시설 외에도 내측 선실에 가상 창문을 설치 하였습니다. 2015년 아시아에서 로얄캐리비안 인터네셔널의 최신 크루즈쉽 퀀텀호를 만나보실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=153" => "훼리와는 달리 떠다니는 리조트 셀러브리티 크루즈는 크루즈 가격에 수영장, 조깅코스, 스파, 카지노, 암벽등반, 극장, 미니골프, 뷔페 및 정찬 레스토랑까지 이용할 수 있는 모든 것이 포함된 올인클루시브 여행입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=154" => "셀러브리티 크루즈 요금은 크루즈 여행의 기본이 되는 객실, 고품격 식사, 엔터테인먼트, 선상 프로그램 및 시설들의 사용료를 모두 포함한 올 인클루시브 금액입니다. 또한 셀러브리티 크루즈의 불포함 사항도 확인하실수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=159" => "고품격, 모던 럭셔리 – modern luxury - 크루즈 여행 대표선사 셀러브리티 크루즈는 1년 365일 유럽, 지중해, 알래스카, 카리브해, 바하마, 버뮤다, 호주, 뉴질랜드, 남미, 갈라파고스, 아시아 – 동남아, 한국, 중국, 일본, 한중일, 싱가포르 - 등 전세계로 운항합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=160" => "하루 24시간이 모자를 만큼 다양한 선상시설과 엔터테인먼트 프로그램으로 가득 찬 셀러브리티 크루즈와 함께하는 크루즈 여행이 더욱 특별해질 수 있도록 크루즈에서의 하루를 미리 다운받아 일정을 계획해 보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=155" => "여행지역, 일정, 기간에 따라 다양한 선택이 가능한 셀러브리티 크루즈는 자유개별여행에서부터 시작해, 크루즈와 항공편까지 한번에 편리하게 이용할 수 있는 패키지 여행, 기업 행사 및 인센티브 투어 크루즈까지 예약 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=161" => "셀러브리티 크루즈의 환상적인 크루즈 여행 설계는 탑승할 크루즈선, 선실고르기, 여행시기와 방법의 등의 다양한 옵션을 선택하시어 나에게 맞는 완벽한 크루즈 일정을 조회하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=162" => "셀러브리티 크루즈는 갈라파고스 크루즈를 연중 운항하는 유일한 선사로 세계 자연 생태의 보고인 갈라파고스 제도로 승객여러분을 안내합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=163" => "셀러브리티 크루즈와 함께 단 한번뿐인 특별한 허니문 크루즈 – honeymoon at the sea – 여행을 예약하시는 평생 기억될 바다 위의 로맨스를 만들어 보세요. 예약하시는 모든 분들께 클래식 로맨스 패키지- 와인과 허니문 데코레이션을 서비스 합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=165" => "크루즈 예약관련 체크사항 – 취소료 규정, 서비스 포함 사항, 여행자 보험, 항공, 비자, 결제방법, 탑승 제한 규정 – 에 관한 보다 자세한 사항은 셀러브리티 크루즈 한국사무소 대표전화로 문의할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=166" => "셀러브리티 크루즈 여행 일정 및 가격 조회와 예약은 한국사무소 홈페이지, 대표전화, 이메일을 통해 요청 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=167" => "셀러브리티 크루즈 한국사무소 발행한 확정서를 통해 예약 신청금, 잔금, 비용 결제 방법 – 원화, 외화 – 과 함께 환불 절차 및 취소 시점에 따른 취소료 확인이 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=351" => "크루즈 티켓에 해당하는 승선서류, 탑승 전 작성이 필요한 검역 질문서 응답지, 선실까지 짐이 안전하게 운송되도록 부착해야 하는 짐택, 크루즈 여행에서 선실 키, 지불수단, 신분증의 역할을 하는 승선카드 –씨패스 카드 - , 크루즈 여행 길잡이 역할을 하는 선상신문 – 크루즈 컴파스, cruise compass – 을 소개합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=349" => "크루즈 여행에 도움되는 팁은 물론 승선카드 연결을 위한 서류작성 및 출력 가능한 짐택을 담은 승선서류 샘플을 확인 바랍니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=342" => "크루즈 터미널에서 체크인 시 양식에 맞춰 건강상태를 체크하는 검역 질문서 응답지 – public health questionnaire – 는 크루즈 항구 체크인 터미널에 비치되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=343" => "개인 수화물이 분실되는 것을 방지하기 위해 크루즈 짐택 – lugguage tag – 을 작성하여 크루즈 항구에서 체크인 시 포터에게 짐을 맞기면 기재된 선실정보로 짐이 전달됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=350" => "승선카드 – seapass card 씨패스 카드 – 는 크루즈 여행 중 선실 키, 지불수단, 신분증의 역할을 하며 분실 시 고객데스크에서 재발급 받으실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=378" => "크루즈 여행에 필요한 미국, 호주, 중국 등의 비자 발급은 각 나라에서 요구하는 조건에 맞춰 적법한 서류를 사전에 준비하여야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=170" => "크루즈 여행을 위해 챙겨야 할 다양한 필요물품 여행준비물 – 정장, 드레스, 수영복, 운동화, 구두, 상비약, 세면도구, 환전- 을 사전에 체크하시어 미리 준비하도록 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=168" => "크루즈 여행 시 필요한 서류 – 승선서류, 셋세일 패스, 짐택, 항공권, 호텔 바우처, 여권, 비자, 미성년자, 임산부 – 에 관한 정보를 포함합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=345" => "사전 온라인 체크인을 통해 셋세일 패스를 받은 크루즈 여행 승객은 따로 승선서류를 작성하지 않아도 되지만, 그 밖의 승객은 크루즈 예약번호, 크루즈쉽 명, 승선일, 선실번호, 및 승선카드와 연결할 결제수단 – 현금, 여행자 수표, 신용카드 – 에 대한 선상카드 발급 정보 작성이 필요합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=344" => "크루즈 여행 첫 날 항구 도착 출발 최소 2시간 전까지 해야 하며 크루즈 터미널에 도착하면 수하물수속 – 인당 총 90 키로 허용 – 및 승선서류를 작성하여 승선수속 후 크루즈에 탑승할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=171" => "크루즈 여행의 마지막인 하선을 위해서는 선내에서 사용한 추가 요금 지불 확인 및 고객 만족도 조사를 작성해야 하며, 크루즈 터미널에서 수하물 수령을 할 수 있습니다. 전날 작성한 개인의 귀국 항공편 시간 및 객실 구역에 따라 하선시간을 알리는 안내가 방송됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=353" => "사전 온라인 체크인 서비스를 신청하지 않은 크루즈 여행 승객은 주요 크루즈 탑승 구비 서류를 들고 크루즈 항구에 도착하여 탑승수속을 해야 하며 수하물 수속 및 수령, 선내 비용 결제 방식 선택 또한 크루즈 터미널에서 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=172" => "크루즈 여행전 사전 예약 가능 서비스 – 기항지 선택관광, 항구 셔틀버스, 스페셜티 레스토랑, 와인 & 음료 패키지, 스파 서비스 – 를 통해 더욱 알찬 크루즈 여행을 계획할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=169" => "크루즈 여행의 승선수속 과정을 줄여주는 온라인 체크인 서비스를 위해서는 영문명, 예약번호, 출항일, 크루즈쉽명을 입력하고 조회하여 여권정보, 생년월일, 주소, 연락처, 신용카드 정보 등을 입력하여 엑스프레스 패스 – xpress pass – 를 출력합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=348" => "온라인 사전 예약 – 영문명, 크루즈 예약 번호, 승선일, 크루즈쉽명 정보 필요 - 을 통해 선사 기항지 선택관광 – shore excursion - 을 신청할 수 있습니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=354" => "셀렉트 다이닝 – select dining – 은 크루즈 승선 후 원하는 식사시간을 정해서 미리 예약 후 이용할 수 있으며 온라인 사전 예약, 고객 서비스 데스크 또는 정찬 다이닝 레스토랑에서 예약 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=64" => "크루즈 기항지 관광 shore excursion은 기항지 자유관광과 선사에서 운영하는 기항지 선택관광이 있으며 기항지 관광 후 승선 요청 시간 – 크루즈 출항 최소 1시간 전 - 까지 재 승선을 해야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=174" => "기항지 선택관광 – shore excursion – 은 온라인으로 브로셔 다운 및 신청이 가능하며 크루즈 승선 후 관광 데스크에서 예약 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=175" => "크루즈 선사 기항지 선택관광 티켓과 영수증을 확인하여 시간에 맞춰 해당 투어 참가 데스크에 집결하여 프로그램 참여 후 재 승선 시간에 맞춰 크루즈쉽으로 재 탑승을 하면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=176" => "크루즈선의 기항지 정박하여 하선을 위해 텐더보트를 사용해야 할 경우, 일반적으로 텐더보트의 티켓에 명시된 시간에 맞춰 무료로 이용하면 되며, 기항지 일정이 있는 날은 관광을 나가지 않고 선내 머무르는 경우 선내에서 제공하는 점심식사를 자유롭게 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=195" => "선상신문은 해당일의 일출과 일몰 시간, 재승선 시간, 주요행사, 정찬 다이닝 복장, 레스토랑을 비롯한 시간별 선상 프로그램을 안내하는 일일 신문으로 매일 오후에 선실로 배달되면 고객 안내 데스크에서 언제든 받으실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=407" => "진정한 재충전의 의미를 35년 명성의 세계적인 스파 브랜드 캐년 랜치 스파클럽 – canyon ranch spaclub – 에서 제공하는 프로그램으로 경험할 수 있으며, 이밖에 몸의 통증을 완화하고 혈액순환을 돕는 침술 서비스도 경험해 보실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=406" => "35년 명성의 세계적인 스파 브랜드 캐년 랜치 스파클럽 – canyon ranch spaclub – 에서 제공하는 피부관리 프로그램인 안티 에이징 트리트먼트, 손상피부 비타민 투여, 스페셜 아이 트리트먼트 등을 통해 얼굴 모공 속 깊은 곳까지 관리하세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=408" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=200" => "다양한 프로덕션쇼, 마술쇼, 코미디쇼, 연주회에서 시작해 론 클럽에서 즐길 수 있는 야외 선상 라이브 뮤직까지 다양한 엔터테인먼트를 제공합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=201" => "세계적인 주방장이 주관하는 요리 시연 강좌, 전문 소믈리에가 참여하는 와인 테스팅에서 시작해 외국어 강좌, 댄스, 컴퓨터 클래스 등 다양한 워크샵과 강의에 참여할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=206" => "개인 컨시어지 서비스를 통해 특별한 이벤트, 개인 취향에 맞는 기항지 관광 신청은 물론 골프 애호가들을 위한 골프 전문 카운셀러를 통해 한층 업그레이드 된 컨시어지 클래스를 경험해 보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=196" => "천연잔디로 마련된 론 클럽 – lawn club – 에서 잔디 볼링, 크리켓, 골프 퍼팅 등 다양한 야외 활동을 즐길 수 있으며 야외 테라스가 있어 여유롭게 음료 및 선상 라이브 뮤직 공연 등을 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=204" => "와이파이를 이용하여 편리한 인터넷 서비스를 즐길 수 있으며 애플사의 최신형 맥북이 마련된i 라운지 – ilounge – 에서는 아이팟, 아이패드 등을 활용하는 방법에 대한 강좌도 참여할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=197" => "유리 공예 장인이 펼치는 핫 글래스 쇼 – hot class show – 는 코닝 뮤지엄에서 관람 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=203" => "거장 피카소에서부터 대중적인 작가인 피터 맥스, 데이비드 호크니에 이르기까지, 크루즈 선상 큐레이터가 심사숙고하여 선정한 미술품 감상 및 아트 옥션에 참가하여 미술품을 구매할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=198" => "크루즈 선내 마련된 갤러리아부티크에서 쥬얼리, 시계, 패션의류, 가방, 주류, 향수, 화장품, 선글라스, 기념품 등의 다양한 상품을 면세가로 구매하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=199" => "35년 명성의 세계적인 스파 브랜드 캐년 랜치 스파클럽 – canyon ranch spaclub – 에서 유료로 제공하는 피부관리, 바디 마사지, 살롱, 침술 서비스에서 시작해 아쿠아 클래스의 승객을 위해 마련된 페르시안 가든, 블루 레스토랑까지 다양한 스파 프로그램이 마련되어 있으며 피트니스 센터, 솔라리움, 적외선 사우나는 모든 승객을 위한 선상시설입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=205" => "어린이, 청소년을 위해 다양한 프로그램이 준비된 셀러브리티 크루즈와 함께라면 크루즈 여행 기간 중 전세계에서 온 다양한 친구와 좀 더 쉽게 소통하는 방법을 터득할 기회를 경험할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=207" => "라스베가스, 몬테카를로의 카지노가 부럽지 않은 선상 카지노에서 블랙잭, 슬롯 머신, 바카라 등 다양한 테이블 게임을 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=371" => "유명 셰프와 함께하는 요리경연대회에서 시작해 와인잔의 명가 리델 크리스탈의 와인 워크샵, 믹솔로지 101 클래스의 환상 칵테일 만들기 및 월드 클라스 다이닝 메뉴에 걸맞는 환상적인 와인 패어링까지 다채로운 강의가 준비되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=372" => "줌바, 살사, 삼바, 힙합등 다양한 리듬과 춤을 즐길 수 있는 댄스 클래스에서 시작해, 싸이클, 침술, 요가, 바디 스컬프트 부트 캠프에 이르기까지 다양한 클래스가 마련되어 있으며 지식도 쌓고 게임을 통해 건강을 관리하는 법을 배울 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=373" => "살사, 볼룸, 라틴은 물론 힙합 댄스까지 다양한 장르의 춤을 배울 수 있는 댄스 클래스와, 크루즈선을 누비며 최첨단 항해 시스템을 돌아볼 수 있는 강의, 아이패드 대여로 선내 곳곳에 다양한 미술품을 감상할 수 있는 셀프 가이드 아트 투어, 나만의 공예품을 만들 수 있는 핸드메이드 아크 클래스를 제공합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=374" => "야외 수영장 발리볼, 퀴즈 콘테스트, 롬 클럽 픽업, 골프 퍼팅 게임, 보링, 테니스, 복싱 등 누구나 좋아할 비디오 게임, 농구, 탁구 등의 스포츠 게임, 수영장 이벤트를 비롯해 어린이 & 청소년 크루즈 승객을 위한 키즈 프로그램에 이르기까지 다양한 선상 프로그램이 마련되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=177" => "보는 즐거움과 먹는 즐거움을 동시에 누릴 수 있는 맛의 크루즈 여행 향연 다이닝은 세계적인 주방장이 엄선한 메뉴로 제공되며 정찬식사 시간은 main time, second time, 셀렉트 다이닝 – select dining – 중 선택 할 수 있으며 드레스 코드는 선상신문에 안내됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=179" => "캐주얼 다이닝 블러바드 및 다이어트 건강식을 즐길 수 있는 아쿠아스파 카페 비스트로 온 파이브, 오션뷰 카페, 마스트 그릴 등 다양한 국가의 요리를 즐길 수 있으며 2시간 제공되는 룸서비스를 통해 선실에서도 편안하게 식사를 하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=178" => "좀 더 럭셔리한 스페셜티 레스토랑 – 큐진, 블루, 무라노, 투스칸 그릴, 실크 하베스트 – 에서는 프렌치, 이탈리안, 글로벌, 퓨전, 웰빙 다이닝을 유료로 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=182" => "크루즈 선실에서 편안한 아침식사를 하고 싶다면 선내 비치된 신청 양식을 작성하여 조식 룸서비스 신청을 하실 수 있으며 선내 전화를 통해 room service 버튼을 누르면 모든 룸서비스를 신청하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=183" => "세련되고 스타일리쉬한 바 – 랑데부 라운지, 마티니 바, 크러시 바, 마이클스 클럽, 셀러 마스터, 선셋 바, 스카이 옵저베이션 라운지, 풀바 – 에서 맥주, 와인, 칵테일 등의 다양한 주류를 음미하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=180" => "크루즈 선내 탑승하고 있는 소믈리에는 승객이 세계적 명성에 걸맞는 다이닝을 즐길 수 있도록 다양한 음식에 걸맞는 와인을 추천해주며, 와인 애호가를 위한 와인 패키지는 좀 더 실속있는 가격으로 크루즈 여행 중 다양한 와인을 즐길 수 있도록 도움을 주고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=208" => "크루즈 여행 중 발생할 수 있는 다양한 상황 – 비행기 연착, 크루즈 재승선, 멀미, 분실 – 에 대비 할 수 있는 정보를 담고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=397" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=392" => "만 18세 이상 이용 가능한 카지노의 배팅 규정 정보입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=391" => "크루즈선의 모든 시설은 금연구역 – smoking policy - 이며 흡연이 가능한 공간은 카지노를 비롯한 지정된 흡연구역으로 한정되며 위반시 $ 250의 과태료가 승선카드로 부과됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=390" => "투석환자 – dialysis- 의 크루즈선 탑승은 사전 공지 하에 가능하며 투석에 필요한 준비물은 최소 2시간 전에 배로 배달되어야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=389" => "크루즈선 탑승 시 개인 휠체어 – wheelchair – 사용은 사전 승인이 요구되며 대여 서비스 또한 사전 신청해야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=388" => "주류 반입 규정 - alcohol policy - 에 의거 크루즈 탑승 시 주류는 와인 두병만 선내 반입 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=387" => "미성년자 - minor or child policy - 의 크루즈 탑승 규정은 만 18세에서 만 21세로 지역에 따라 상이하며 가족관계 증명을 위한 영문 주민등록증 등본 사본 또는 영문 부모동의서 사전 공증이 필요합니다"
		,	"/cruise_guide/guide_template_popup.php?menu_id=386" => "임산부 규정 – pregnancy policy – 은 하선일 기준 24주 미만의 경우 의사의 영문 소견서를 지참한 경우에 한해 탑승 가능하다고 규정짓고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=347" => "㈜투어마케팅코리아에서 제공하는 한글 크루즈 티켓 계약서는 영어에 익숙하지 못한 한국 이용객의 크루즈 여행에 관한 전반적인 이해를 돕기 위한 용도로 계약 세부 내용 확인을 위해서는 크루즈 티켓 계약 영문 원본을 숙지해야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=212" => "로얄캐리비안 크루즈 한국사무소의 소셜네트워킹 서비스 – 페이스북, 유투브, 플리커, 홈페이지, 트위터, 공식카페 크루즈톡 – 로 크루즈 여행에 관한 다양한 정보 공유에서 시작해 할인혜택 및 이벤트 참여에 관한 정보를 검색해보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=209" => "크루즈쉽과 관련하여 자주 사용되는 용어 – 스타보드, 포트사이드, 크루즈 톤스, 브릿지, 갤리, 정박, 텐더 – 에 관한 정보를 담고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=400" => "크루즈 여행 중 꼭 지켜야 할 매너인 크루즈 에티켓에 관한 전반적인 정보를 참고해 주시기 바랍니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=192" => "크루즈 선실에서 편안한 아침식사를 하고 싶다면 선내 비치된 신청 양식을 작성하여 조식 룸서비스 신청을 하실 수 있으며 선내 전화를 통해 room service 버튼을 누르면 모든 룸서비스를 신청하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=346" => "크루즈 선내에서 제공하는 기항지 관광, 면세품 구입, 카지노 칩, 와인, 인터넷 이용 등 모든 결제는 승선카드 – seapass card – 로 지불 가능하며 사용한 금액에 관한 청구서는 하선 전날 선실로 배달됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=352" => "인터넷 패키지 구입 또는 선상카드 결제를 통해 선상에 마련된 온라인 카페에서 인터넷을 사용할 수 있으며 선실에 비치된 전화를 이용하여 룸서비스 신청 또는 선내 선실간 연락 및 국제전화 사용을 하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=189" => "호텔과 같이 다양한 선택이 가능한 크루즈 선실은 기본적으로 스위트, 발코니, 오션뷰, 내측 선실로 나뉘며 개인의 선택 및 고려사항 – 멀미, 허니문 여행, 그룹 여행, 가족 여행, 휠체어 사용 - 에 따라 크루즈 여행 예약 시 선택하시면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=193" => "크루즈 선실은 기본적으로 침대, 욕실, 헤어드라이기, tv, 전화기, 안전금고, 쇼파, 테이블, 옷장, 화장대로 구성되어 있으며 전화 룸서비스 및 개인 선실 온도 조절이 가능하며, 이밖에110v와 220v 모두 사용 가능한 콘센트가 있다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=186" => "다양한 선택이 가능한 선실 중 발코니, 오션뷰, 내측 선실은 트윈 베드로 변경 가능한 킹사이즈 침대와 함께 개인 욕실 및 쇼파와 테이블, 옷장 등이 마련되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=355" => "다양한 선택이 가능한 선실 중 스위트 선실은 텐더 서비스 우선 사용과 함꼐 조기 승선 & 하선 서비스를 받을 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=188" => "다양한 선택이 가능한 선실 중 컨시어지 클래스 선실은 조기 승선 및 하선 서비스가 가능하며 이태리 산 목욕가운이 비치되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=187" => "다양한 선택이 가능한 선실 중 아쿠아 클래스 선실은 컨시어지 클래스 선실과 동일한 사항에 아쿠아 클래스 스파 컨시어지, 설렉션 건강식 메뉴 옵션 등 좀 더 업그레이드 된 서비스를 받아보실 수 있는 선실 형태입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=213" => "훼리와는 달리 떠다니는 리조트 아자마라 크루즈는 크루즈 가격에 수영장, 조깅코스, 스파, 카지노, 암벽등반, 극장, 미니골프, 뷔페 및 정찬 레스토랑까지 이용할 수 있는 모든 것이 포함된 올인클루시브 여행입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=214" => "아자마라 크루즈 요금은 크루즈 여행의 기본이 되는 객실, 고품격 식사, 엔터테인먼트, 선상 프로그램 및 시설들의 사용료를 모두 포함한 올 인클루시브 금액입니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=215" => "디럭스 크루즈 여행 대표선사 아자마라 크루즈는 1년 365일 유럽, 지중해, 알래스카, 카리브해, 바하마, 버뮤다, 호주, 뉴질랜드, 남미, 갈라파고스, 아시아 – 동남아, 한국, 중국, 일본, 한중일, 싱가포르 - 등 전세계로 운항합니다. "
		,	"/cruise_guide/guide_template_popup.php?menu_id=217" => "여행지역, 일정, 기간에 따라 다양한 선택이 가능한 아자마라 크루즈는 자유개별여행에서부터 시작해, 크루즈와 항공편까지 한번에 편리하게 이용할 수 있는 패키지 여행, 기업 행사 및 인센티브 투어 크루즈까지 예약 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=218" => "아자마라 크루즈의 환상적인 크루즈 여행 설계는 탑승할 크루즈선, 선실고르기, 예약시기와 방법의 등의 다양한 옵션을 선택하시어 나에게 맞는 완벽한 크루즈 일정을 조회하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=220" => "크루즈 예약관련 체크사항 – 취소료 규정, 서비스 포함 사항, 여행자 보험, 항공, 비자, 결제방법, 탑승 제한 규정 – 에 관한 보다 자세한 사항은 아자마라 크루즈 한국사무소 대표전화로 문의할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=221" => "아자마라 크루즈 여행 일정 및 가격 조회와 예약은 한국사무소 홈페이지, 대표전화, 이메일을 통해 요청 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=223" => "원할한 크루즈 여행을 위한 승선준비를 위해서는 승선서류, 셋세일 패스, 짐택, 항공권, 호텔 바우처, 여권, 비자 등이 필요합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=224" => "크루즈 온라인 체크인 서비스는 승선수속 과정을 줄여주는 편리한 서비스로, 영문명, 예야번호, 출항일, 크루즈쉽명을 입력하고 조회하여 여권정보, 생년월일, 주소, 연락처, 신용카드 정보 등을 입력하면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=225" => "크루즈 여행을 위해 챙겨야 할 다양한 필요물품 – 정장, 드레스, 수영복, 운동화, 구두, 상비약, 세면도구, 환전- 을 사전에 체크하시어 미리 준비하도록 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=226" => "크루즈 여행의 마지막인 하선을 위해서는 선내에서 사용한 추가 요금 지불 확인 및 고객 만족도 조사를 작성해야 하며, 크루즈 터미널에서 수하물 수령을 할 수 있습니다. 전날 작성한 개인의 귀국 항공편 시간 및 객실 구역에 따라 하선시간을 알리는 안내가 방송됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=228" => "크루즈 기항지 관광 shore excursion은 기항지 자유관광과 기항지 선택관광이 있으며 기항지 관광 후 승선 요청 시간 – 크루즈 출항 최소 1시간 전 - 까지 재 승선을 해야 합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=229" => "기항지 선택관광 – shore excursion – 은 온라인으로 브로셔 다운 및 신청이 가능하며 크루즈 승선 후 관광 데스크 또는 선내 tv를 통해 예약 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=230" => "크루즈 선사 기항지 선택관광 티켓과 영수증을 확인하여 시간에 맞춰 해당 투어 참가 데스크에 집결하여 프로그램 참여 후 재 승선 시간에 맞춰 크루즈쉽으로 재 탑승을 하면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=231" => "기항지 일정이 있는 날은 관광을 나가지 않고 선내 머무르는 경우 선내에서 제공하는 점심식사를 자유롭게 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=232" => "보는 즐거움과 먹는 즐거움을 동시에 누릴 수 있는 맛의 크루즈 여행 향연 다이닝은 세계적인 주방장이 엄선한 메뉴로 제공되며 드레스 코드는 선상신문을 통해 확인 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=235" => "뷔페식 레스토랑 윈도우 카페의 야외 테이블에서는 매일 매일 바뀌는 다양한 메뉴 – 스시, 볶음 요리, 파스타, 셀러드, 구운 생선 – 와 함께 호화롭고 달콤한 디저트를 맛 볼 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=239" => "크루즈 선실에서 편안한 아침식사를 하고 싶다면 선내 비치된 신청 양식을 작성하여 조식 룸서비스 신청을 하실 수 있으며 선내 전화를 통해 room service 버튼을 누르면 모든 룸서비스를 신청하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=233" => "크루즈 여행 중 좀 더 특별한 음식을 원하는 승객을 위해 마련된 씨푸드 전문 스페셜티 레스토랑인 아쿠아리나에서는 랍스타등의 다양한 씨푸드를 유료로 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=234" => "크루즈 여행 중 좀 더 특별한 음식을 원하는 승객을 위해 마련된 클래식 스테이크 하우스 프라임 C에서는 스테이크 외에도 양고기, 포크, 송아지 갈비, 치킨, 씨푸드 요리도 맛볼 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=236" => "크루즈 여행 중 가벼운 스낵을 즐길 수 있는 그릴 바에서는 생선 케밥, 버거류, 프렌치 프라이, 샐러드 등 수영을 마치고 허기진 배를 달래 줄 다양한 음식이 마련되어 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=237" => "온화한 분위기의 카페인 모자이크 카페에서는 에스프레소를 비롯 신선한 비스킷을 곁들인 차, 미니 샌드위치 등 핑거푸드와 함게 스콘을 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=238" => "아자마라의 와인 셀러는 프랑스에서부터 캘리포니아, 아르헨티나, 남아프리카까지 전세계에서 공수 된 와인을 전문 소믈리에의 추천을 통해 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=249" => "선상신문 – pursuits - 은 해당일의 일출과 일몰 시간, 재승선 시간, 주요행사, 정찬 다이닝 복장, 레스토랑을 비롯한 시간별 선상 프로그램을 안내하는 일일 신문으로 매일 오후에 선실로 배달되면 고객 안내 데스크에서 언제든 받으실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=254" => "브로드웨이 뮤지컬 형식의 프로덕션쇼, 클래식 공연, 라이브 밴드. 코미디 쇼 등 다양한 엔터테인먼트가 바를 갖춘 캬바레 라운지에서 무료로 제공됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=252" => "크루즈 선상에 마련된 상점에서 다양한 상품 – 보석, 시계, 패션, 화장품, 기념품 – 을 면세 가격으로 구매 할 수 있으며 특히 클리니크, 에스티로더, 랑콤 등 다양한 화장품과 향수, 스와로브스키와 같은 액세서리를 더욱 저렴한 가격에 구입하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=253" => "남성과 여성 모두를 위해 선내 마련된 아자마라의 뷰티 살롱에서는 헤어 서비스에서 시작해, 매니큐어, 페디큐어, 마사지, 면도 등 다양한 스페셜 패키지를 제공합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=250" => "다양한 스파 프로그램 – 해수요법 스파, 얼굴 스킨 케어, 마사지 테라피, 바디 테라피 – 을 통해 피로에 지친 몸과 마음의 피로를 풀어보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=255" => "선내 마련된 피트니스 센터에서는 선셋요가. 필라테스. 사이클링, 코어 운동, 영양에 대한 강의 및 세미나가 제공되며 원하는 클래스가 없다면 라이프 사이클, 트레이드밀, 스텝퍼와 같은 장비로 운동을 하실 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=251" => "고대 중국의 힐링 요법인 침술을 통해 면역력 강화 및 스트레스 이완을 도와 자연스러운 몸의 균형과 에너지를 회복시킬 수 있으며 침술 프로그램을 통해 통증완화, 금연, 체중감량, 혈액순화, 심장, 위장, 피부를 개선해 보세요."
		,	"/cruise_guide/guide_template_popup.php?menu_id=257" => "라스베가스, 몬테카를로의 카지노가 부럽지 않은 선상 카지노에서 블랙잭, 슬롯 머신, 바카라 등 다양한 테이블 게임을 즐길 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=256" => "크루즈 여행 중 온라인 카페 이커넥션즈 – econnections – 에서 인터넷 서비스를 사용할 수 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=241" => "선실 유형은 크게 내측, 오션뷰, 발코니, 스위트로 나뉘며 크기와 위치에 따라 다양한 선택이 가능합니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=243" => "호텔과 같이 다양한 선택이 가능한 크루즈 선실은 기본적으로 스위트, 발코니, 오션뷰, 내측 선실로 나뉘며 개인의 선택 및 고려사항 – 멀미, 허니문 여행, 그룹 여행, 가족 여행, 휠체어 사용 - 에 따라 크루즈 여행 예약 시 선택하시면 됩니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=258" => "크루즈 여행 중 발생할 수 있는 다양한 상황 – 비행기 연착, 크루즈 재승선, 멀미, 분실 – 에 대비 할 수 있는 정보를 담고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=259" => "크루즈쉽과 관련하여 자주 사용되는 용어 – 스타보드, 포트사이드, 크루즈 톤스, 브릿지, 갤리, 정박, 텐더 – 에 관한 정보를 담고 있습니다."
		,	"/cruise_guide/guide_template_popup.php?menu_id=261" => "아자마라 크루즈 멤버쉽 프로그램인 le club voyage 르클럽 보야지 를 신청하시어 다양한 선상 프로그램 혜택 및 크루즈 여행을 보다 할인 된 가격으로 만나보실 수 있습니다."
		,	"/cruiseonly/hotDeal.php?top_menu_id=5" => "로얄캐리비안, 셀러브리티, 아자마라 크루즈 소속 다양한 크루즈선이 운항하는 다양한 지역과 일정의 상품 중 특별요금을 소개합니다."
		,	"/hotdeal_plan/plan_list.php?top_menu_id=5&menu_id=158" => "로얄캐리비안, 셀러브리티, 아자마라 크루즈가 추천하는 다양한 지역, 일정, 가격과 테마 기획 상품을 확인 할 수 있습니다."
		,	"/cruise_guide/guide_template.php?top_menu_id=6&menu_id=38" => "적립 포인트 별 다양한 혜택 – 선상할인, 포인트 적립, 선내 예약 서비스, 선내 추가 서비스, 기념품 제공 - 을 누릴 수 있는 고품격 크라운 & 앵커 멤버쉽 - crown & anchor membership - 신청 및 회원등급과 포인트 조회가 가능합니다."
		,	"/cruise_guide/guide_template.php?top_menu_id=6&menu_id=101&sunsa_no=" => "적립 포인트 별 다양한 혜택 – 선상할인, 포인트 적립, 선내 예약 서비스, 선내 추가 서비스, 기념품 제공 - 을 누릴 수 있는 고품격 캡틴스 클럽 멤버쉽 – captain’s club membership - 신청 및 회원등급과 포인트 조회가 가능합니다."
		,	"/help/applyMember.php?top_menu_id=6&menu_id=42" => "적립 포인트 별 다양한 혜택 – 선상할인, 포인트 적립, 선내 예약 서비스, 선내 추가 서비스, 기념품 제공 - 을 누릴 수 있는 고품격 캡틴스 클럽 멤버쉽 – captain’s club membership - 신청 및 회원등급과 포인트 조회가 가능합니다."
		,	"/help/applyMember2.php?top_menu_id=6&menu_id=42" => "적립 포인트 별 다양한 혜택 – 선상할인, 포인트 적립, 선내 예약 서비스, 선내 추가 서비스, 기념품 제공 - 을 누릴 수 있는 고품격 캡틴스 클럽 멤버쉽 – captain’s club membership – 신청이 가능합니다."
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=1" => "로얄캐리비안 인터내셔널과 함께라면 다양한 운항 크루즈쉽과 지역에 따라 기업 인센티브 및 단체 크루즈 차터 문의 – MICE - 가 가능합니다. "
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=2" => "로얄캐리비안 인터내셔널과 함께라면 다양한 운항 크루즈쉽과 지역에 따라 기업 인센티브 및 단체 크루즈 차터 문의 – MICE - 가 가능합니다. "
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=3" => "로얄캐리비안 인터내셔널과 함께라면 다양한 운항 크루즈쉽과 지역에 따라 기업 인센티브 및 단체 크루즈 차터 문의 – MICE - 가 가능합니다. "
		,	"/etc2/company.php" => "로얄캐리비안 크루즈 한국사무소는 로얄캐리비안 인터내셔널, 셀러브리티 크루즈, 아자마라 크루즈 – royal caribbean international, celebrity cruise, azamara club cruise – 소속 총 40여척 크루즈선의 다양한 정보, 예약, 조회 및 크루즈 여행 안내를 제공합니다. "
		,	"/etc2/companyMap.php" => "로얄캐리비안 크루즈 한국사무소는 로얄캐리비안 인터내셔널, 셀러브리티 크루즈, 아자마라 크루즈 – royal caribbean international, celebrity cruise, azamara club cruise – 소속 총 40여척 크루즈선의 다양한 정보, 예약, 조회 및 크루즈 여행 안내를 제공하는 회사로 서울시 종로구 인사동에 위치해 있습니다."
		,	"/help/faqList.php?bd_code=NOFQ" => "로얄캐리비안 인터내셔널, 셀러브리티 크루즈, 아자마라 크루즈 여행에 관해 궁금한 사항은 자주묻는 질문 FAQ –  크루즈 운항시기, 지역, 가격, 아시아 운항 크루즈 – 에서 확인 가능합니다."
		,	"/etc2/companySiteMap.php" => "로얄캐리비안 크루즈 한국사무소 사이트 SNS 로얄캐리비안 인터내셔널, 셀러브리티 크루즈, 아자마라 크루즈의 선사소개, 보유크루즈 쉽, 운항일정, 크루즈 길잡이, 특별요금, 기획전, 멤버쉽프로그램, 미팅, 인센티브, 차터, mice 정보를 제공합니다."
		,	"/etc2/agree.php" => "로얄캐리비안 크루즈 한국사무소 – 투어마케팅코리아 – 의 개인정보 취급방침은 고객의 개인정보를 보호하고 보다 빠른 개인정보와 관련한 불만 처리를 위해 다양한 개인정보 취급방침 법률사항을 준수합니다."
	) ;

	var $metaKeyword 	= Array(
			"/" => "크루즈여행, 부산출발크루즈여행, 로얄캐리비안, 로얄캐리비안 크루즈, 알라스카크루즈, 일본크루즈여행, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄크루즈, 크루즈여행가격, 동남아크루즈여행, 북유럽크루즈여행, 지중해크루즈여행, 미국크루즈여행, 크루즈여행사, 로열캐리비안크루즈, 크루즈성지순례, 바하마크루즈, 홍콩크루즈, 마리너호, 크루즈 온라인 체크인, 캐리비안크루즈, 해외크루즈, 이클립스호, 로열캐러비안크루즈, 크루즈 여행 가격, 몬테카를로 카지노, 크루즈여행비용, 알래스카크루즈여행, 로얄캐리비안오아시스호, 크루즈, 부산출발크루즈, 크루즈예약, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 셀러브리티 크루즈, 셀러브리티, 아자마라 크루즈, 아자마라 크루즈, 모던 럭셔리 크루즈, 럭셔리 크루즈"
		,	"/sunsa/sunsa_info.php?top_menu_id=1&menu_id=1" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 인터내셔널, 세계 최대 크루즈선, 오아시스호, 마리너호, 크루즈 선사, 세계 최대 크루즈 선사, 아쿠아 씨어터, 암벽등반, 로얄캐리비안 크루즈 선사소개, 로얄캐리비안 소개, 로얄캐리비안 크루즈 소개, 로얄캐리비안 선사소개"
		,	"/sunsa/sunsa_info.php?menu_id=1&sunsa_no=2" => "로얄캐리비안 크루즈, 셀러브리티 크루즈 선사소개, 셀러브리티 크루즈, 모던 럭셔리, 모던 럭셔리 크루즈, 프리미엄 크루즈, 럭셔리 크루즈, modern luxury, celebrity cruise, celebrity cruises, 셀러브리티, 살스티스호, 알래스카 크루즈, 알래스카 크루즈 여행, 알라스카 크루즈, 셀러브리티 크루즈 선사소개, 셀러브리티 선사소개"
		,	"/sunsa/sunsa_info.php?menu_id=1&sunsa_no=3" => "로얄캐리비안 크루즈, 로얄캐리비안, 아자마라, 아자마라 크루즈, 아자마라 크루즈, 디럭스 크루즈, 퀘스트호, 저니호, azamara, aza, azamara cruise, azamara club cruise, 고품격 크루즈, 올 인클루시브 크루즈, 아자마라 크루즈 선사소개, 아자마라 크루즈 소개, 아자마라 크루즈 소개, 아자마라 크루즈 선사소개"
		,	"/sunsa/sunsa_ebrochure.php?top_menu_id=1&menu_id=152" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 브로셔, 크루즈 브로셔, 로얄캐리비안 크루즈 브로셔, 셀러브리티 크루즈 브로셔, 셀러브리티 브로셔, 로얄캐리비안 크루즈 한글브로셔, 셀러브리티 크루즈 한글 브로셔"
		,	"/ship/owner_cruise.php?top_menu_id=2&menu_id=2" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 보유 크루즈쉽, 보유 크루즈쉽, 크루즈쉽, 마리너호, 오아시스호, 얼루어호, 리버티호, 보이저호, 콴텀호"
		,	"/ship/owner_cruise.php?menu_id=2&sunsa_no=2" => "로얄캐리비안, 로얄캐리비안 크루즈, 셀러브리티, 셀러브리티 크루즈, celebrity cruise, celebrity cruises, 살스티스 클래스, 살스티스호, 이클립스호, 이쿼녹스호, 리플렉션호, 밀레니엄호, 셀러브리티 보유 크루즈쉽, 보유 크루즈쉽, 크루즈쉽, 실루엣호, 인피티니호, 컨스텔레이션호"
		,	"/ship/owner_cruise.php?menu_id=2&sunsa_no=3" => "로얄캐리비안, 로얄캐리비안 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, 저니호, 퀘스트호, 아자마라 보유 크루즈쉽, 보유 크루즈쉽, 크루즈쉽, 아자마라 크루즈 보유 크루즈쉽, 디럭스 크루즈쉽, 디럭스 크루즈"
		,	"/cruiseonly/cruise_only_list.php?top_menu_id=3&menu_id=138" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 예약, 크루즈 예약, 로얄캐리비안 크루즈 일정조회, 크루즈 일정조회, 셀러브리티 일정조회, 셀러브리티 예약, 셀러브리티 크루즈 예약, 아자마라 예약, 아자마라 크루즈 예약, 크루즈 운항지역, 로얄캐리비안 운항지역, 로얄캐리비안 크루즈 운항지역"
		,	"/cruise_guide/guide_template.php?top_menu_id=3&menu_id=23" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 기항지 관광, 크루즈 기항지, 크루즈 기항지 관광, 셀러브리티 크루즈 기항지 관광, 아자마라 크루즈 기항지 관광, 기항지 관광, 기항지 관광 예약하기, 기항지 관광 예약하기"
		,	"/cruise_guide/guide_template.php?top_menu_id=3&menu_id=21" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 항구, 크루즈 항구, 크루즈 터미널, 크루즈 터미널 위치, 크루즈 항구 위치, 셀러브리티 크루즈 항구, 아자마라 크루즈 항구, 크루즈 터니널 정보, 크루즈 항구 정보"
		,	"/cruise_guide/guide_template_popup.php?menu_id=14" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈란, 훼리, 크루즈 교통수단, 크루즈 리조트"
		,	"/cruise_guide/guide_template_popup.php?menu_id=15" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 요금 포함, 크루즈 요금 불포함, 요금포함, 요금 불포함, 크루즈 식사, 크루즈 시설, 크루즈 금액, 크루즈 가격"
		,	"/cruise_guide/guide_template_popup.php?menu_id=75" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 운항지역, 운항지역, 아시아, 지중해, 북유럽, 알래스카, 카리브해, 바하마, 버뮤다, 싱가포르, 한국, 중국, 일본"
		,	"/cruise_guide/guide_template_popup.php?menu_id=84" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 하루, 크루즈 할일, 암벽등반, 조깅, 선상파티, 크루즈 정찬, 크루즈 공연, 크루즈여행 미리보기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=102" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 상품, 크루즈 자유여행, 자유여행, 크루즈 개별여행, 크루즈여행 패키지, 크루즈 패키지, 크루즈 MICE, 크루즈, 크루즈 패키지 상품"
		,	"/cruise_guide/guide_template_popup.php?menu_id=103" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 일정, 크루즈 일정고르기, 크루즈 일정 선택, 크루즈 여행시기, 크루즈 선실, 크루즈선, 크루즈 예약, 크루즈 상품"
		,	"/cruise_guide/guide_template_popup.php?menu_id=139" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 가족여행, 드림웍스, 드림웍스 익스피리언스, 바비 익스피리언스, 어드벤처 오션, 크루즈 어린이 프로그램, 크루즈 청소년 프로그램, 가족 크루즈여행, 가족 크루즈"
		,	"/cruise_guide/guide_template_popup.php?menu_id=140" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 허니문 크루즈, 허니문, honemoon, 크루즈 신혼여행, 신혼여행 크루즈, 크루즈 허니문 패키지, 허니문 크루즈 패키지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=105" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 예약, 크루즈 예약사항, 크루즈 취소, 크루즈 요금결제, 크루즈 보험, 크루즈 취소료 규정, 크루즈 예약 체크사항, 크루즈 탑승 제한조건, 크루즈 탑승 제한"
		,	"/cruise_guide/guide_template_popup.php?menu_id=106" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 온라인 예약, 전화 예약, 크루즈 예약, 이메일 예약, 크루즈 탑승 규정, 크루즈 규정, 크루즈 한국사무소, 크루즈 탑승"
		,	"/cruise_guide/guide_template_popup.php?menu_id=337" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 온라인 예약, 크루즈 온라인 예약, 로얄캐리비안 온라인, 크루즈 온라인, 크루즈 예약, 크루즈 홈페이지, 크루즈 예약 확인, 크루즈 확인, 예약확인"
		,	"/cruise_guide/guide_template_popup.php?menu_id=107" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 신청금, 크루즈 신청, 크루즈 예약, 크루즈 취소료, 환불 규정, 지불 방법, 크루즈 환불, 환불절차, 신청금 입금, 입금 방법, 홀리데이크루즈, 취소방법, 크루즈 예약취소, 취소료, 환불방법, 환불신청, 환불금, 신청금, 예약 규정, 결제방법, 결제"
		,	"/cruise_guide/guide_template_popup.php?menu_id=336" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 서류, 크루즈 여행 서류, 여행 서류, 승선서류, 크루즈 티켓, 승선카드, 선상신문, 크루즈 컴파스, 예약서류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=335" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 서류, 크루즈 여행 서류, 여행 서류, 승선서류, 승선서류 샘플, 승선서류 작성법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=323" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 검역, 검역 질문서, 검역, 검역 양식, 검역서, 검역서 양식"
		,	"/cruise_guide/guide_template_popup.php?menu_id=321" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 짐택, 짐택, luggage tag, luggage, 크루즈 짐, 짐표, 짐 이름표"
		,	"/cruise_guide/guide_template_popup.php?menu_id=322" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 카드, 승선카드, 선상카드, seapass card, 선상결제"
		,	"/cruise_guide/guide_template_popup.php?menu_id=377" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 비자, 호주비자, 미국비자, 중국비자, 관광비자, 크루즈 관광비자, 크루즈 관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=366" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 안전, 안전, 크루즈 세이프티, 크루즈 응급상황, 응급사황, 규정, 크루즈 규정, 안전협약, 해상안전협약, 크루즈 국제규정, 국제규정, 미국 선박보안, 선박보안법, satefy, 선상안전, 선상안전훈련, 안전 규칙사항, 규칙사항, 안전방침"
		,	"/cruise_guide/guide_template_popup.php?menu_id=363" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 안전, 안전, 크루즈 응급상황, 응급사황, 규정, 크루즈 규정, 크루즈 국제규정, 국제규정, satefy, 선상안전, 선상안전훈련, 안전 규칙사항, 규칙사항, 안전방침, 안전훈련, muster drill, 안전훈련방법, 안전훈련 절차, 구명정, 구명조끼, 비상탈출, 구명보트"
		,	"/cruise_guide/guide_template_popup.php?menu_id=367" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 안전, 안전, 크루즈 응급상황, 응급사황, 규정, 크루즈 규정, 크루즈 국제규정, 국제규정, satefy, 선상안전, 선상안전훈련, 안전 규칙사항, 규칙사항, 안전방침, 안전훈련, muster drill, 안전훈련방법, 안전훈련 절차, 비상탈출, 승무원 안전교육, 승무원 훈련, 응급대피, 응급대피훈련"
		,	"/cruise_guide/guide_template_popup.php?menu_id=368" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 안전, 안전, 크루즈 응급상황, 응급사황, 규정, 크루즈 규정, 크루즈 국제규정, 국제규정, satefy, 선상안전, 선상안전훈련, 안전 규칙사항, 규칙사항, 안전방침, 안전훈련, muster drill, 안전훈련방법, 사고예방, 사고예방대책, 태룽, 화재대비, 선내 화재진압, 화재진압 시스템"
		,	"/cruise_guide/guide_template_popup.php?menu_id=49" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 짐 꾸리기, 크루즈 복장, 크루즈 짐, 금지물품, 선내 반입금지, 구비물품, 선내 구비물품, 환전"
		,	"/cruise_guide/guide_template_popup.php?menu_id=63" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 준비서류, 크루즈 서류, 승선서류, 셋세일 패스, setsail pass, 짐택, 여권, 비자, 미성년자 규정, 임산부 규정, 크루즈 나이 제한, 크루즈 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=331" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 승선서류, 승선서류, 승선서류 작성하기, 승선서류 작성, 온라인 체크인, 셋세일 패스, 선상카드 정보, 승선서류 작성방법, 서류 작성방법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=330" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 승선수속, 크루즈 승선, 크루즈 수하물, 수하물 수속, 승선서류, 크루즈 탑승, 선실찾기, 수하물, 수하물 확인, 식사, 탑승일, 탑승수속, 승선방법, 크루즈 터미널, 승선시간"
		,	"/cruise_guide/guide_template_popup.php?menu_id=108" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 하선절차, 하선 날, 하선방법, 결제방법, 수하물 수령, 짐 찾기, 항구에서 공항가기, 하선시간, 입국카드, 선내 사용금액, 사용금액 지불, 수하물, 수하물 수속"
		,	"/cruise_guide/guide_template_popup.php?menu_id=340" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 승선, 하선, 크루즈 승선, 크루즈 하선, 크루즈 터미널, 승선수속, 필요서류, 승선서류, 온라인 체크인, 기항지 관광, 수하물 수속, 선상신문, 승무원 팁, 결제방법, 결제방식, 크루즈 항구, 탑승절차, 하선절차, 탑승시간, 하선시간, 탑스방법, 하선방법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=359" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 플라이cruise fly, Cruise fly, 싱가포르 크루즈, 크루즈 항공, 크루즈 항공 패키지, 크루즈 패키지, 패키지 상품, 크루즈 패키지 상품, 크루즈 항공 패키지 상품"
		,	"/cruise_guide/guide_template_popup.php?menu_id=109" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 사전예약, 사전예약서비스, 크루즈 사전예약, 기항지 관광, 기항지 선택, 마이타임, 마이타임 다이닝, 항구 셔틀버시, 셔틀버스, 스페셜티 레스토랑, 와인 & 음료 패키지, 스파 서비스, 바비 익스피리언스, 유아용품, 유아용품 주분, 어린이 프로그램, 온라인 에약"
		,	"/cruise_guide/guide_template_popup.php?menu_id=324" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 마이타임, 마이타임다이닝, 마이타임 다이닝, 사전예약, 식사예약, 크루즈 식사, 크루즈 식사시간, my time dining, 크루즈 정찬"
		,	"/cruise_guide/guide_template_popup.php?menu_id=325" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 기항지관광, 기항지,, 기항지 사전예약, 기항지 온라인 예약, 기항지 선택, 기항지 신청, 기항지 관광 신청, 크루즈 투어, 온라인예약, 크루즈 랜드투어"
		,	"/cruise_guide/guide_template_popup.php?menu_id=327" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 와인 & 음료 패키지, 와인 패키지, 음료 패키지, 알코올, 무알콜 음료, 무알콜 음료 패키지, 사전에약, 음료수, 주류, 패키지 신청, 패키지 구매, 주류구입, 음료구입"
		,	"/cruise_guide/guide_template_popup.php?menu_id=393" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=394" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 선상시설, 선내시설 인공파도타기, 파도타기 레슨, flow rider, flowrider, 파도타기 수업, 오아시스호, 얼루어호, 리버티호, 프리덤호, 온라인 예약, 사전예약, 온라인 신청"
		,	"/cruise_guide/guide_template_popup.php?menu_id=37" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 온라인체크인, 온라인체크, 체크인, 승선수속, 사전에약, 체크인 서류, 체크인 방법, 사전 체크인, 체크인 서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=64" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 기항지 관광, 기항지 선택, 사전예약, 온라인 예약, 승선시간, 하선시간, 승선절차, 하선절차, 재탑승, 재승선, 크루즈 자유 관광, 자유 관광, 선사 기항지, 선사 기항지 관광, 선택 관광, 자유 관광, 승선서류, shore excursion, 기항지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=58" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 기항지 관광, 기항지 선택, 사전예약, 온라인 예약, 승선시간, 하선시간, 승선절차, 하선절차, 재탑승, 재승선, 선사 기항지, 선사 기항지 관광, 선택 관광, 자유 관광, 승선서류, shore excursion, 기항지, 관광 데스크, 선상 데스크, 기항지 데스크, 안내 데스크, 브로셔, 기항지 브로셔, 선택관광 브로셔"
		,	"/cruise_guide/guide_template_popup.php?menu_id=69" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 기항지 관광, 기항지 선택, 승선시간, 하선시간, 재탑승, 재승선, 선사 기항지, 선사 기항지 관광, 선택 관광, 자유 관광, 승선서류, shore excursion, 기항지, 관광 데스크, 선상 데스크, 기항지 데스크, 안내 데스크, 기항지 관광 티켓, 가이드 언어, 기항지 언어, 기항지 정박, 집결지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=65" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 기항지 관광, 기항지 선택, 승선시간, 하선시간, 재탑승, 재승선, 선사 기항지, 선택 관광, 자유 관광, shore excursion, 기항지, 기항지 관광 티켓, 기항지 정박, 텐더보트, 기항지 식사, 기항지 관광 참여"
		,	"/cruise_guide/guide_template_popup.php?menu_id=70" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=71" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=72" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=88" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=282" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=90" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=91" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=92" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=93" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=94" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=96" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=97" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=98" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=99" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=100" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=278" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=402" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=130" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=110" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=115" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=129" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=128" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=127" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=126" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=118" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=113" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=120" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=395" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=329" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=333" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=332" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=339" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=132" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=370" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=338" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=279" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=280" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=281" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=399" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=398" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=385" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=384" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=383" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=382" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=381" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=380" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=379" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=328" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=125" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=123" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=122" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=401" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=358" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=357" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=356" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=153" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈란, 훼리, 크루즈 교통수단, 크루즈 리조트"
		,	"/cruise_guide/guide_template_popup.php?menu_id=154" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 요금 포함, 크루즈 요금 불포함, 요금포함, 요금 불포함, 크루즈 식사, 크루즈 시설, 크루즈 금액, 크루즈 가격"
		,	"/cruise_guide/guide_template_popup.php?menu_id=159" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 운항지역, 운항지역, 아시아, 지중해, 북유럽, 알래스카, 카리브해, 바하마, 버뮤다, 싱가포르, 한국, 중국, 일본"
		,	"/cruise_guide/guide_template_popup.php?menu_id=160" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 하루, 크루즈 할일, 조깅, 선상파티, 크루즈 정찬, 크루즈 공연, 크루즈여행 미리보기"
		,	"/cruise_guide/guide_template_popup.php?menu_id=155" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 상품, 크루즈 자유여행, 자유여행, 크루즈 개별여행, 크루즈여행 패키지, 크루즈 패키지, 크루즈 MICE, 크루즈, 크루즈 패키지 상품"
		,	"/cruise_guide/guide_template_popup.php?menu_id=161" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 일정, 크루즈 일정고르기, 크루즈 일정 선택, 크루즈 여행시기, 크루즈 선실, 크루즈선, 크루즈 예약, 크루즈 상품"
		,	"/cruise_guide/guide_template_popup.php?menu_id=162" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 갈라파고스, 셀러브리티 갈라파고스, 갈라파고스 크루즈, 갈라파고스 운항일정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=163" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 허니문 크루즈, 허니문, honemoon, 크루즈 신혼여행, 신혼여행 크루즈, 크루즈 허니문 패키지, 허니문 크루즈 패키지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=165" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 예약, 크루즈 예약사항, 크루즈 취소, 크루즈 요금결제, 크루즈 보험, 크루즈 취소료 규정, 크루즈 예약 체크사항, 크루즈 탑승 제한조건, 크루즈 탑승 제한"
		,	"/cruise_guide/guide_template_popup.php?menu_id=166" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 온라인 예약, 전화 예약, 크루즈 예약, 이메일 예약, 크루즈 탑승 규정, 크루즈 규정, 크루즈 한국사무소, 크루즈 탑승"
		,	"/cruise_guide/guide_template_popup.php?menu_id=167" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 신청금, 크루즈 신청, 크루즈 예약, 크루즈 취소료, 환불 규정, 지불 방법, 크루즈 환불, 환불절차, 신청금 입금, 입금 방법, 홀리데이크루즈, 취소방법, 크루즈 예약취소, 취소료, 환불방법, 환불신청, 환불금, 신청금"
		,	"/cruise_guide/guide_template_popup.php?menu_id=351" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 서류, 크루즈 여행 서류, 여행 서류, 승선서류, 크루즈 티켓, 승선카드, 선상신문, 크루즈 컴파스, 예약서류"
		,	"/cruise_guide/guide_template_popup.php?menu_id=349" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 서류, 크루즈 여행 서류, 여행 서류, 승선서류, 승선서류 샘플, 승선서류 작성법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=342" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 검역, 검역 질문서, 검역, 검역 양식, 검역서, 검역서 양식"
		,	"/cruise_guide/guide_template_popup.php?menu_id=343" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 짐택, 짐택, luggage tag, luggage, , 크루즈 짐, 짐표, 짐 이름표"
		,	"/cruise_guide/guide_template_popup.php?menu_id=350" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 카드, 승선카드, 선상카드, seapass card, 선상결제"
		,	"/cruise_guide/guide_template_popup.php?menu_id=378" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 비자, 호주비자, 미국비자, 중국비자, 관광비자, 크루즈 관광비자, 크루즈 관광"
		,	"/cruise_guide/guide_template_popup.php?menu_id=170" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 짐 꾸리기, 크루즈 복장, 크루즈 짐, 금지물품, 선내 반입금지, 구비물품, 선내 구비물품, 환전"
		,	"/cruise_guide/guide_template_popup.php?menu_id=168" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 준비서류, 크루즈 서류, 승선서류, 셋세일 패스, setsail pass, 짐택, 여권, 비자, 미성년자 규정, 임산부 규정, 크루즈 나이 제한, 크루즈 규정"
		,	"/cruise_guide/guide_template_popup.php?menu_id=345" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 크루즈 승선서류, 승선서류, 승선서류 작성하기, 승선서류 작성, 온라인 체크인, 셋세일 패스, 선상카드 정보, 승선서류 작성방법, 서류 작성방법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=344" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 승선수속, 크루즈 승선, 크루즈 수하물, 수하물 수속, 승선서류, 크루즈 탑승, 선실찾기, 수하물, 수하물 확인, 식사, 탑승일, 탑승수속, 승선방법, 크루즈 터미널, 승선시간"
		,	"/cruise_guide/guide_template_popup.php?menu_id=171" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 하선절차, 하선 날, 하선방법, 결제방법, 수하물 수령, 짐 찾기, 항구에서 공항가기, 하선시간, 입국카드, 선내 사용금액, 사용금액 지불, 수하물"
		,	"/cruise_guide/guide_template_popup.php?menu_id=353" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 승선, 하선, 크루즈 승선, 크루즈 하선, 크루즈 터미널, 승선수속, 필요서류, 승선서류, 온라인 체크인, 기항지 관광, 수하물 수속, 선상신문, 승무원 팁, 결제방법, 결제방식, 크루즈 항구, 탑승절차, 하선절차, 탑승시간, 하선시간, 탑스방법, 하선방법"
		,	"/cruise_guide/guide_template_popup.php?menu_id=172" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=169" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=348" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=354" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=64" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 기항지 관광, 기항지 선택, 사전예약, 온라인 예약, 승선시간, 하선시간, 승선절차, 하선절차, 재탑승, 재승선, 크루즈 자유 관광, 자유 관광, 선사 기항지, 선사 기항지 관광, 선택 관광, 자유 관광, 승선서류, shore excursion, 기항지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=174" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 기항지 관광, 기항지 선택, 사전예약, 온라인 예약, 승선시간, 하선시간, 승선절차, 하선절차, 재탑승, 재승선, 선사 기항지, 선사 기항지 관광, 선택 관광, 자유 관광, 승선서류, shore excursion, 기항지, 관광 데스크, 선상 데스크, 기항지 데스크, 안내 데스크, 브로셔, 기항지 브로셔, 선택관광 브로셔"
		,	"/cruise_guide/guide_template_popup.php?menu_id=175" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 기항지 관광, 기항지 선택, 승선시간, 하선시간, 재탑승, 재승선, 선사 기항지, 선사 기항지 관광, 선택 관광, 자유 관광, 승선서류, shore excursion, 기항지, 관광 데스크, 선상 데스크, 기항지 데스크, 안내 데스크, 기항지 관광 티켓, 가이드 언어, 기항지 언어, 기항지 정박, 집결지"
		,	"/cruise_guide/guide_template_popup.php?menu_id=176" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 기항지 관광, 기항지 선택, 승선시간, 하선시간, 재탑승, 재승선, 선사 기항지, 선택 관광, 자유 관광, shore excursion, 기항지, 기항지 관광 티켓, 기항지 정박, 텐더보트, 기항지 식사, 기항지 관광 참여"
		,	"/cruise_guide/guide_template_popup.php?menu_id=195" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=407" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=406" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=408" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=200" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=201" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=206" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=196" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=204" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=197" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=203" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=198" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=199" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=205" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=207" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=371" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=372" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=373" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=374" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=177" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=179" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=178" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=182" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=183" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=180" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=208" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=397" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=392" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=391" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=390" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=389" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=388" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=387" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=386" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=347" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=212" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=209" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=400" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=192" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=346" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=352" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=189" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=193" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=186" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=355" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=188" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=187" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=213" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 크루즈란, 훼리, 크루즈 교통수단, 크루즈 리조트"
		,	"/cruise_guide/guide_template_popup.php?menu_id=214" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 크루즈 요금 포함, 크루즈 요금 불포함, 요금포함, 요금 불포함, 크루즈 식사, 크루즈 시설, 크루즈 금액, 크루즈 가격"
		,	"/cruise_guide/guide_template_popup.php?menu_id=215" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 크루즈 운항지역, 운항지역, 아시아, 지중해, 북유럽, 알래스카, 카리브해, 바하마, 버뮤다, 싱가포르, 한국, 중국, 일본"
		,	"/cruise_guide/guide_template_popup.php?menu_id=217" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 크루즈 상품, 크루즈 자유여행, 자유여행, 크루즈 개별여행, 크루즈여행 패키지, 크루즈 패키지, 크루즈 MICE, 크루즈, 크루즈 패키지 상품"
		,	"/cruise_guide/guide_template_popup.php?menu_id=218" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 크루즈 일정, 크루즈 일정고르기, 크루즈 일정 선택, 크루즈 여행시기, 크루즈 선실, 크루즈선, 크루즈 예약, 크루즈 상품"
		,	"/cruise_guide/guide_template_popup.php?menu_id=220" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 크루즈 예약, 크루즈 예약사항, 크루즈 취소, 크루즈 요금결제, 크루즈 보험, 크루즈 취소료 규정, 크루즈 예약 체크사항, 크루즈 탑승 제한조건, 크루즈 탑승 제한"
		,	"/cruise_guide/guide_template_popup.php?menu_id=221" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 온라인 예약, 전화 예약, 크루즈 예약, 이메일 예약, 크루즈 탑승 규정, 크루즈 규정, 크루즈 한국사무소, 크루즈 탑승"
		,	"/cruise_guide/guide_template_popup.php?menu_id=223" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 승선수속, 크루즈 승선, 크루즈 수하물, 수하물 수속, 승선서류, 크루즈 탑승, 선실찾기, 수하물, 수하물 확인, 식사, 탑승일, 탑승수속, 승선방법, 크루즈 터미널, 승선시간, 승선준비"
		,	"/cruise_guide/guide_template_popup.php?menu_id=224" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 온라인체크인, 온라인체크, 체크인, 승선수속, 사전에약, 체크인 서류, 체크인 방법, 사전 체크인, 체크인 서비스"
		,	"/cruise_guide/guide_template_popup.php?menu_id=225" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 짐 꾸리기, 크루즈 복장, 크루즈 짐, 금지물품, 선내 반입금지, 구비물품, 선내 구비물품, 환전"
		,	"/cruise_guide/guide_template_popup.php?menu_id=226" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 하선절차, 하선 날, 하선방법, 결제방법, 수하물 수령, 짐 찾기, 항구에서 공항가기, 하선시간, 입국카드, 선내 사용금액, 사용금액 지불, 수하물"
		,	"/cruise_guide/guide_template_popup.php?menu_id=228" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 승선수속, 크루즈 승선, 크루즈 수하물, 수하물 수속, 승선서류, 크루즈 탑승, 선실찾기, 수하물, 수하물 확인, 식사, 탑승일, 탑승수속, 승선방법, 크루즈 터미널, 승선시간"
		,	"/cruise_guide/guide_template_popup.php?menu_id=229" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 기항지 관광, 기항지 선택, 사전예약, 온라인 예약, 승선시간, 하선시간, 승선절차, 하선절차, 재탑승, 재승선, 선사 기항지, 선사 기항지 관광, 선택 관광, 자유 관광, 승선서류, shore excursion, 기항지, 관광 데스크, 선상 데스크, 기항지 데스크, 안내 데스크, 브로셔, 기항지 브로셔, 선택관광 브로셔"
		,	"/cruise_guide/guide_template_popup.php?menu_id=230" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, azamara, azamara club cruise, azamara cruise, 기항지 관광, 기항지 선택, 승선시간, 하선시간, 재탑승, 재승선, 선사 기항지, 선택 관광, 자유 관광, shore excursion, 기항지, 기항지 관광 티켓, 기항지 정박, 기항지 식사, 기항지 관광 참여"
		,	"/cruise_guide/guide_template_popup.php?menu_id=231" => "로얄캐리비안, 로얄캐리비안 크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, 셀러브리티 크루즈, 셀러브리티, celebrity cruise, celebrity cruises, 기항지 관광, 기항지 선택, 승선시간, 하선시간, 재탑승, 재승선, 선사 기항지, 선택 관광, 자유 관광, shore excursion, 기항지, 기항지 관광 티켓, 기항지 정박, 텐더보트, 기항지 식사, 기항지 관광 참여"
		,	"/cruise_guide/guide_template_popup.php?menu_id=232" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=235" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=239" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=233" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=234" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=236" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=237" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=238" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=249" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=254" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=252" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=253" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=250" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=255" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=251" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=257" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=256" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=241" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=243" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=258" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=259" => ""
		,	"/cruise_guide/guide_template_popup.php?menu_id=261" => ""
		,	"/cruiseonly/hotDeal.php?top_menu_id=5" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 특별요금, 크루즈 특별요금, 로얄캐리비안 크루즈 특별요금, 셀러브리티 크루즈 특별요금, 크루즈 특가, 크루즈 세일, 크루즈 가격, 크루즈여행 가격, 크루즈 할인 상품, 로얄캐리비안 크루즈 할인, 셀러브리티 크루즈 할인"
		,	"/hotdeal_plan/plan_list.php?top_menu_id=5&menu_id=158" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 기획상품, 크루즈 기획상품, 셀러브리티 크루즈 기획상품, 셀러브리티 기획상품, 특별요금, 크루즈 특별요금, 테마 크루즈, 로얄캐리비안 크루즈 추천상품, 크루즈 추천상품"
		,	"/cruise_guide/guide_template.php?top_menu_id=6&menu_id=38" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 멤버쉽, 로얄캐리비안 멤버쉽, 크라운 & 앵커, 크라운 & 앵커 멤버쉽, 크루즈 멤버, 크루즈 멤버쉽, 로얄캐리비안 크루즈 멤버쉽 적립방법, 로얄캐리비안 멤버쉽 적립방법, 로얄캐리비안 크루즈 멤버쉽 혜택, 크루즈 멤버쉽 혜택, 로얄캐리비안 멤버쉽 혜택. Crown & Anchor, Crown & Anchor membership"
		,	"/cruise_guide/guide_template.php?top_menu_id=6&menu_id=101&sunsa_no=" => "로얄캐리비안, 로얄캐리비안 크루즈, 셀러브리티 크루즈 멤버쉽, 셀러브리티 멤버쉽, 캡틴스 클럽, 셀러브리티 캡틴스 클럽, 셀러브리티 크루즈 멤버쉽 혜택, 크루즈 멤버쉽 혜택, 셀러브리티 멤버쉽 혜택. 셀러브리티 크루즈 멤버쉽 적립방법, 셀러브리티 멤버쉽 적립, captain’s club, captain’s club membership, 셀러브리티 멤버쉽 신청, 멤버쉽 신청, 멤버쉽 신청방법, 캡틴스 클럽 신청, 캡틴스 클럽 회원, 셀러브리티 크루즈 멤버쉽 신청, 캡틴스 클럽 가입신청"
		,	"/help/applyMember.php?top_menu_id=6&menu_id=42" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 멤버쉽, 로얄캐리비안 멤버쉽, 크라운 & 앵커, 크라운 & 앵커 멤버쉽, 크루즈 멤버, 크루즈 멤버쉽, 로얄캐리비안 크루즈 멤버쉽 적립방법, 로얄캐리비안 멤버쉽 적립방법, 로얄캐리비안 크루즈 멤버쉽 혜택, 크루즈 멤버쉽 혜택, 로얄캐리비안 멤버쉽 혜택. Crown & Anchor, Crown & Anchor membership, 멤버쉽 신청, 멤버쉽 신청 방법, 크라운 앤 엥커, 멤버쉽 가입"
		,	"/help/applyMember2.php?top_menu_id=6&menu_id=42" => "로얄캐리비안, 로얄캐리비안 크루즈, 셀러브리티 크루즈 멤버쉽, 셀러브리티 멤버쉽, 캡틴스 클럽, 셀러브리티 캡틴스 클럽, 셀러브리티 크루즈 멤버쉽 혜택, 크루즈 멤버쉽 혜택, 셀러브리티 멤버쉽 혜택. 셀러브리티 크루즈 멤버쉽 적립방법, 셀러브리티 멤버쉽 적립, captain’s club, captain’s club membership, 셀러브리티 멤버쉽 신청, 멤버쉽 신청, 멤버쉽 신청방법, 캡틴스 클럽 신청, 캡틴스 클럽 회원, 셀러브리티 크루즈 멤버쉽 신청, 캡틴스 클럽 가입신청"
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=1" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 크루즈 차터, 차터 크루즈, 로얄캐리비안 크루즈 차터, 로얄캐리비안 차터, MICE, mice"
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=2" => "로얄캐리비안, 로얄캐리비안 크루즈, 셀러브리티 크루즈, 셀러브리티, 셀러브리티 크루즈 차터, 셀러브리티 차터, celebrity cruise. Celebrity cruises, 크루즈 차터, 차터 크루즈, 로얄캐리비안 크루즈 차터, 로얄캐리비안 차터, MICE, mice"
		,	"/etc/etc_template.php?top_menu_id=7&sunsa_no=3" => "로얄캐리비안, 로얄캐리비안 크루즈, 아자마라, 아자마라 크루즈, 아자마라 크루즈, 아자마라 크루즈 차터, 아자마라 차터, azamara club cruise, azamara cruise, azamara, 크루즈 차터, 차터 크루즈, MICE, mice"
		,	"/etc2/company.php" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 한국사무소, 로열캐리비안 크루즈 한국사무소, 로얄캐리비안 한국사무소, 로열캐리비안 한국사무소, 로얄캐리비안 크루즈 연락처, 로얄캐리비안 크루즈 영업시간, 로얄캐리비안 한국사무소 연락처, 로얄캐리비안 한국사무소 영업시간, 로얄캐리비안 한국사무소, 셀러브리티 크루즈, 셀러브리티 크루즈 한국사무소, 아자마라 크루즈, 아자마라 크루즈 한국사무소, 셀러브리티 크루즈 한국사무소 연락처, 셀러브리티 크루즈 영업시간, 셀러브리티 크루즈 한국사무소 위치, 로얄캐리비안 크루즈 위치, 로얄캐리비안 크루즈 한국사무소 위치"
		,	"/etc2/companyMap.php" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 한국사무소 가는 법, 로얄캐리비안 한국사무소 가는 법, 로열캐리비안 한국사무소 찾아가는 법, 로열캐리비안 크루즈 한국사무소 찾아가는 법, 로얄캐리비안 크루즈 지도, 로얄캐리비안 크루즈 한국사무소 지도, 로얄캐리비안 주소, 로얄캐리비안 연락처, 로얄캐리비안 근무시간, 로얄캐리비안 한국사무소 주소, 로얄캐리비안 한국사무소 연락처, 로얄캐리비안 한국사무소 주소, 셀러브리티 한국사무소 주소, 로얄캐리비안 크루즈 한국사무소 위치, 로얄캐리비안 한국사무소 위치, 셀러브리티 크루즈 위치, 아자마라 크루즈 한국사무소 위치"
		,	"/help/faqList.php?bd_code=NOFQ" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 운항지역, 로얄캐리비안 크루즈 운항시기, 로얄캐리비안 승무원 채용, 로얄캐리비안 크루즈 성수기, 크루즈 운항지역, 크루즈 여행시기, 크루즈 운항시기, 크루즈 승무원 채용, 크루즈 성수기, 로얄캐리비안 크루즈 문의, 로얄캐리비안 문의, 셀러브리티 문의, 셀러브리티 크루즈 문의, 아자마라 문의, 아자마라 크루즈 문의, 아자마라 크루즈 문의"
		,	"/etc2/companySiteMap.php" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 사이트맵, 로얄캐리비안 크루즈 홈페이지 사이트맵, 선사소개, 브로셔, 크루즈 갤러리, 보유크루즈쉽, 운항일정, 실시간 조회, 실시간 예약, 기항지 관광, 항구정보, 크루즈 길잡이, 특별요금, 기획전, 멤버쉽프로그램, 셀러브리티 크루즈, 아자마라 크루즈, 아자마라 크루즈, 멤버쉽 싵청, 미팅, 인센티브, 차터, 로얄캐리비안 한국사무소, 로얄캐리비안 찾아가는 길, 로얄캐리바안 FAQ, 로얄캐리비안 크루즈 FAQ, 로얄캐리비안 개인정보 취급방치, 로얄캐리비안 크루즈 한국사무소 개인정보 취급방침, 셀러브리티 크루즈 개인정보, 아자마라 크루즈 개인정보"
		,	"/etc2/agree.php" => "로얄캐리비안, 로얄 캐리비안, 로얄캐리비안 크루즈, 로얄캐리비안크루즈, 로얄케리비안크루즈, 로얄케리비안 크루즈, 로얄크루즈, 크루즈여행, 크루즈예약, 해외크루즈, 크루즈, royalcaribbean, royalcaribbean cruise, royalcarribean, royalcarribean cruise, cruise, cruises, royalcaribbean cruises, 로얄캐리비안 크루즈 개인정보, 로얄캐리비안 개인정보, 로얄캐리비안 크루즈 한국사무소 개인정보, 로얄캐리비안 개인정보 취급방침, 개인정보, 개인정보 취급방침, 셀러브리티 크루즈 개인정보, 아자마라 크루즈 개인정보, 셀러브리티 개인정보, 아자마라 개인정보,"
	) ;


	// EMS 비용
	var $aTran =
	Array("14400","16200","18300","20800","22100","23300","24600","25800","27100","28400","29600","30900","32100","33400","34700","35900","37200","38400","39700","41000","42200","43500","44700","46000","47300","48500","49800","51000","52300","53600","54800","56100","57300","58600","59900","61100","62400","63600","64900","66200","67400","68700","69900","71200","72500","73700","75000","76200","77500","78500","79500","80500","81500","82400","83400","84400","85400","86400","87400","88400") ;

	var $eng = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
				 "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","(",")","'","/",",");

	var $eng2 = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z",
				 "A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","(",")","'","/",","," ",".");
	var $par = array(")");
		var $aCommArea =  Array(288,488,688,888,1088,1288,1488,1688,1888) ;
		var $aComm = Array(48,66,84,102,120,138,156,174,192) ;


        function isTmkOffice(){
            return in_array( $_SERVER["REMOTE_ADDR"], $this->auth_ip);
        }
		// php 배열을 가지고 자바스크립트 배열문자열 생성
		function createArrayFromPhp($arrayNameOfJS,$array)
		{
			$str = "var $arrayNameOfJS = new Array() ;\n" ;

			for($i = 0 ; $i < sizeof($array) ; $i ++)
				$str .= $arrayNameOfJS . '[' . $i . '] = "' . $array[$i]  . "\" ;\n" ;

			return $str ;
		}

		// 자바스크립트 연관 배열로 만든다.
		function createAssocFromPhp($arrayNameOfJS,$assoc)
		{
			$str = "var $arrayNameOfJS = new Array() ;\n" ;

			foreach($assoc as $key => $value )
			{
				$value = str_replace("'","\'",$value) ;
				$value = str_replace("\r\n","\\n",$value) ;
				$value = str_replace("\r\n","\\n",$value) ;

				$str .= $arrayNameOfJS . "['" . $key . "'] = '" . $value . "'  ; \n" ;
			}

			return $str ;
		}

		// 연관 배열을 자바스크립트 형식의 변수 표현의 문자열로 변화한다.
		function createVarFromAssoc($assoc)
		{
			$str = "" ;

			foreach($assoc as $key => $value )
			{
				$str .= "var " . $key . " = '" . $value  . "';\n" ;
			}

			return $str ;
		}

		// 연관 배열을 자바스크립트 Array형식(sParam)의 변수 표현의 문자열로 변화한다.
		function createObjectFromAssoc($assoc)
		{
			$str = "var sParam = {};\n" ;

			foreach($assoc as $key => $value )
			{
				$str .= "sParam['" . $key . "'] = '" . $value  . "';\n" ;
			}

			return $str ;
		}

		// 연관 배열을 자바스크립트 Array형식(sParam)의 변수 표현의 문자열로 변화한다.
		function createObjectFromOrder()
		{
			$str = "var sOrder = {};\n" ;
			$arrOrder = $this->arrOrder ;

			foreach( $arrOrder as $key => $value )
			{
				$str .= "sOrder['" . $key . "'] = {" ;
				$str .= "'title':'" . $value["title"] . "'," ;
				$str .= "'color':'" . $value["color"] . "'," ;
				$str .= "'detail':[" ;

				foreach( $value["detail"] as $dKey => $dValue )
					$str .= "{'" . $dKey . "':'" . $dValue . "'}," ;

				$str = substr($str,0,strlen($str)-1) ;

				$str .= "]};\n" ;
			}

			return $str ;
		}



		function changeCurrency($currency)
		{
			$retVal = "$" ;
			if($currency == "EUR")
			{
				$retVal = "€" ;
			}
			else if($currency == "JPN")
			{
				$retVal = "￥" ;
			}
			else if($currency == "CHN")
			{
				$retVal = "￦" ;
			}
			else if($currency == "GBP")
			{
				$retVal ="￡" ;
			}
			else if($currency == "CAD")
			{
				$retVal = "$" ;
			}

			return $retVal;
		}

		function getListOfCommonCode($cd_type = '')
		{
			$vendor = ( $this->req["vendor"] == "" ) ? "AL" : $this->req["vendor"] ;
			$cd_type = ($cd_type == "") ? $this->req["cd_type"] : $cd_type ;

			$param = Array(
				$vendor ,
				$cd_type
			) ;

			$ret = Array("ret"=>"@ret") ;

			$sql = $this->strCallProc("usp_code_list",$param,$ret) ;

			$result =  $this->getMultiArray($sql) ;

			return $result[0] ;
		}


		function isMail($bd_code)
		{
			$retVal = false ;
			if($bd_code == "NOQA" || $bd_code == "COMP")	// 고객센터 -> Q&A , 고객의 소리
				$retVal = true ;

			return $retVal ;
		}

		// str : 오리지날 변수, spl : split 할 구분자, idx : 몇번째 index를 리턴할것인가
		function toReply($str, $spl, $idx)
		{
			$retVal = "" ;

			if(stristr($str,$spl) != false){
				$strArr = explode($spl,$str) ;
				$retVal = $strArr[$idx] ;
			}

			return $retVal ;
		}

		/* add by dev.lee
		 * val : checkbox value ex) 4
		 * str : 데이터 베이스에서 불러온 값 ex) 1,4,6
		 * spl : 데이터 베이스에서 불러온 값 구분자 ex) ,
		 * */
		function isAutoChecked($val, $str='', $spl)
		{
			$retVal = "" ;

			$str_arr = (stristr($str,$spl) != false) ? explode($spl,$str) : $str ;

			if(is_array($str_arr))
			{
				for($i = 0 ; $i < sizeof($str_arr) ; $i++)
				{
					if($val == $str_arr[$i])
						$retVal = "CHECKED" ;
				}
			}
			else if($val == $str){
				$retVal = "CHECKED" ;
			}

			return $retVal ;
		}

		function getAddZero($seq)
		{
			$seq = "0000000" . $seq ;

			return substr($seq, -3, 3) ;
		}

		//문자열 자르기 함수
		function trimStr($title,$trim)
		{
			$title = strip_tags($title);
			$titleLen = strlen($title);

			$trimLen = strlen(substr($title,0,$trim));	//문자열을 자름

			//만약 문자열이 자를 문자열보다 작으며 자르지 않음
			if($titleLen > $trimLen)
			{
				for($i=0 ; $i < $trimLen ; $i ++)
				{
					$tmp = ord(substr($title, $i, 1)) ;

					//127보다 크면 한글로 가준하여 2바이트씩 자름
					if( $tmp > 127 ) { 	$i ++ ; }
				}

				$title = ( $tmp > 127 ) ? substr($title , 0 , $i) . "..." : substr($title , 0 , $i) ;
			}

			return $title;
		}

		function getStatus($status)
		{
			$bStatus = floor($status / 10) ;
			$arrStatus = $this->arrOrder[$bStatus] ;
			return "<FONT COLOR='".$arrStatus["color"]."'>" . $arrStatus["detail"][$status] . "</FONT>" ;
//			return $bStatus ;
		}



		// 디버깅용 자바스크립트 alert 출력
		function alert($msg)
		{
			echo "<script> alert('" . $msg . "');</script>" ;
		}


		//최대치에 따른 이미지 비율로 축대확소.
		function getRatioImage($url, $maxSize, $class)
		{

			$webPath = $_SERVER["DOCUMENT_ROOT"] . str_replace("%2F", "/", rawurlencode($url)) ;

			list($imgWidth,$imgHeight) = @getimagesize($webPath);

			$isExistImage = ( $imgWidth > 0 && $imgHeight > 0 ) ;


			$addClass = ( $class != "" ) ? ("class='".$class."'") : "" ;


			if( $isExistImage )
			{
				$isHorizontal = ( $imgWidth > $imgHeight ) ;
				$ratio = $maxSize / ( ( $isHorizontal ) ? $imgWidth : $imgHeight ) ;
				$imgTag = "<img src='".$url."' width='". ($imgWidth*$ratio) ."' height='". ($imgHeight*$ratio)."' ".$addClass."/>" ;
			}
			else
			{
				$imgTag = "" ;
			}

			return $imgTag ;

		}

		// nukiboy 추가 (라이브러리로 빼놔야함)
		function getImg($url,$brandKey)
		{
			$url = str_replace("http:/","",$url) ;

			return "/upload_img/" . $brandKey . $url ;
		}

		function getDescImg($url,$brandKey)
		{
			$tmp = str_replace("http:/","",$url) ;

			return "/upload_img/" . $brandKey . $tmp ;
		}

		function getOurImg($path)
		{
			return "/upload_img/" . $path ;
		}

		// 번역하기
		function getChina($cate,$han)
		{
			if( $cate == "COLOR" )
			{
				return $this->color[$han] ;
			}
			else if( $cate == "GITA" )
				return $this->gita[$han] ;


		}


		/**
		* cut string in utf-8
		* @author gony (http://mygony.com)
		* @param $str     source string
		* @param $len     cut length
		* @param $checkmb if this argument is true, the function treats multibyte character as two bytes. default value is false.
		* @param $tail    abbreviation symbol
		* @return string  processed string
		*/
		function strcut_utf8($str, $len, $checkmb=false, $tail='...') {
			preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);

			$m    = $match[0];
			$slen = strlen($str);  // length of source string
			$tlen = strlen($tail); // length of tail string
			$mlen = count($m); // length of matched characters

			if ($slen <= $len) return $str;
			if (!$checkmb && $mlen <= $len) return $str;

			$ret   = array();
			$count = 0;

			for ($i=0; $i < $len; $i++) {
				$count += ($checkmb && strlen($m[$i]) > 1)?2:1;

				if ($count + $tlen > $len) break;
				$ret[] = $m[$i];
			}

			return join('', $ret).$tail;
		}

		function getListOfArrayYear($sail_date)
		{
			$yearArray[] = Array() ;
			$sailArr = explode(",",$sail_date) ;

			for($i = 0; $i < sizeof($sailArr) ; $i++)
			{
				$dateArr = explode("/",$sailArr[$i]) ;

				if (!in_array($dateArr[2],$yearArray)) {
					$yearArray[]=$dateArr[2] ;
				}
			}

			array_multisort($yearArray) ;

			return $yearArray ;
		}

		function getListOfArrayDate($year, $sail_date)
		{
			$dateArray[] = Array() ;
			$sailArr = explode(",",$sail_date) ;

			for($i = 0; $i < sizeof($sailArr) ; $i++)
			{
				$dateArr = explode("/",$sailArr[$i]) ;
				if($year == $dateArr[2]){
					$dateArray[] = $dateArr[0] . "-" . $dateArr[1] ;
				}
			}

			array_multisort($dateArray) ;

			return $dateArray ;
		}

		function getInfoOfEngMonth($month)
		{
			$engNm = "" ;
			switch($month){
				case "01" : $engNm = "JAN" ;
				break ;
				case "02" : $engNm = "FEB" ;
				break ;
				case "03" : $engNm = "MAR" ;
				break ;
				case "04" : $engNm = "APR" ;
				break ;
				case "05" : $engNm = "MAY" ;
				break ;
				case "06" : $engNm = "JUN" ;
				break ;
				case "07" : $engNm = "JUL" ;
				break ;
				case "08" : $engNm = "AUG" ;
				break ;
				case "09" : $engNm = "SEP" ;
				break ;
				case "10" : $engNm = "OCT" ;
				break ;
				case "11" : $engNm = "NOV" ;
				break ;
				case "12" : $engNm = "DEC" ;
				break ;
				default : $engNm = "미정" ;
				break ;
			}

			return $engNm ;
		}

		function getInfoOfKorMonth($month)
		{
			$korNm = "" ;
			switch($month){
				case "01" : $korNm = "&nbsp;1월" ;
				break ;
				case "02" : $korNm = "&nbsp;2월" ;
				break ;
				case "03" : $korNm = "&nbsp;3월" ;
				break ;
				case "04" : $korNm = "&nbsp;4월" ;
				break ;
				case "05" : $korNm = "&nbsp;5월" ;
				break ;
				case "06" : $korNm = "&nbsp;6월" ;
				break ;
				case "07" : $korNm = "&nbsp;7월" ;
				break ;
				case "08" : $korNm = "&nbsp;8월" ;
				break ;
				case "09" : $korNm = "&nbsp;9월" ;
				break ;
				case "10" : $korNm = "10월" ;
				break ;
				case "11" : $korNm = "11월" ;
				break ;
				case "12" : $korNm = "12월" ;
				break ;
				default : $korNm = "미정" ;
				break ;
			}

			return $korNm ;
		}

		function getListOfCabinType($list)
		{
			$cabinTypeArr="" ;	//케빈타입 배열



			for($i = 0; $i < sizeof($list) ; $i++)
			{
				if (@!in_array($list[$i]["sst"],$cabinTypeArr)) {
					$cabinTypeArr[]=$list[$i]["sst"] ;				//방타입 D, B, O, I
				}
			}

			return $cabinTypeArr ;
		}


		function getListOfPrice($list)
		{
			$priceDataArr = "" ;

			$D_Amt = "" ;
			$B_Amt = "" ;
			$O_Amt = "" ;
			$I_Amt = "" ;

			for($i = 0; $i < sizeof($list) ; $i++)
			{

				if($list[$i]["sst"] == "D")
				{
					$D_Amt[] = $list[$i]["g1_price"] ;
					$D_img	 = $list[$i]["sunsil_img1"] ;
					$D_desc	 = $list[$i]["sunsil_desc"] ;

				}
				else if($list[$i]["sst"] == "B")
				{
					$B_Amt[] = $list[$i]["g1_price"] ;
					$B_img	 = $list[$i]["sunsil_img1"] ;
					$B_desc	 = $list[$i]["sunsil_desc"] ;
				}
				else if($list[$i]["sst"] == "O")
				{
					$O_Amt[] = $list[$i]["g1_price"] ;
					$O_img	 = $list[$i]["sunsil_img1"] ;
					$O_desc	 = $list[$i]["sunsil_desc"] ;
				}
				else if($list[$i]["sst"] == "I")
				{
					$I_Amt[] = $list[$i]["g1_price"] ;
					$I_img	 = $list[$i]["sunsil_img1"] ;
					$I_desc	 = $list[$i]["sunsil_desc"] ;
				}
			}

//			echo "MAX_D" . max($D_Amt) ;
//			echo "MIN_D" . min($D_Amt) ;


if($D_Amt==0){
	$tempD_Amt = 0 ;
	$temp2D_Amt = 0;
}else{
	$tempD_Amt = max($D_Amt);
	$temp2D_Amt = min($D_Amt);
}


if($B_Amt==0){
	$tempB_Amt = 0 ;
	$temp2B_Amt = 0;
}else{
	$tempB_Amt = max($B_Amt);
	$temp2B_Amt = min($B_Amt);
}


if($O_Amt==0){
	$tempO_Amt = 0 ;
	$temp2O_Amt = 0;
}else{
	$tempO_Amt = max($O_Amt);
	$temp2O_Amt = min($O_Amt);
}


if($I_Amt==0){
	$tempI_Amt = 0 ;
	$temp2I_Amt = 0;
}else{
	$tempI_Amt = max($I_Amt);
	$temp2I_Amt = min($I_Amt);
}




			$priceDataArr = array(
				"D_MAX"	=> $tempD_Amt ,
				"D_MIN"	=> $temp2D_Amt ,
				"B_MAX"	=> $tempB_Amt ,
				"B_MIN"	=> $temp2B_Amt ,
				"O_MAX"	=> $tempO_Amt ,
				"O_MIN"	=> $temp2O_Amt ,
				"I_MAX"	=> $tempI_Amt ,
				"I_MIN"	=> $temp2I_Amt ,
				"D_img" => $D_img ,
				"B_img" => $B_img ,
				"O_img" => $O_img ,
				"I_img" => $I_img ,
				"D_desc" => $D_desc ,
				"B_desc" => $B_desc ,
				"O_desc" => $O_desc ,
				"I_desc" => $I_desc



			) ;

			return $priceDataArr ;
		}

		function getInfoOfCabinType($type)
		{
			$retStr = "" ;

			switch($type){
				case "D" : $retStr = "DELUXE/SUITES" ;
				break ;
				case "B" : $retStr = "BALCONY" ;
				break ;
				case "O" : $retStr = "OUTSIDE" ;
				break ;
				case "I" : $retStr = "INTERIOR" ;
				break ;
				default : $retStr = "미정" ;
				break ;

			}

			return $retStr ;
		}

		function getListOfCabinData($list, $type)
		{

			$cabinLoop = "" ;
			for($i = 0; $i < sizeof($list) ; $i++)
			{
				if($list[$i]["sst"] == $type)
				{
					$cabinLoop[] = $list[$i] ;
				}
			}

			return $cabinLoop ;
		}


























		/*

		function getInfoOfFx()
		{
			$today = date('Y-m-d') ;

			$row = $this->getRow("select * from niz_fx where tdate='" . $today . "' LIMIT 0,1 ") ;

			return $row ;
		}

		function getUSD($won)
		{
			$row = $this->getInfoOfFx() ;

			return $this->getUSD2($won,$row) ;


		}

		function getUSD2($won,$rowFx)
		{

			$wpu = $rowFx['won_per_usd'] ;

			return ceil(($won * 100) / $wpu ) / 100 ;


		}

		function getCNY($won)
		{
			$row = $this->getInfoOfFx() ;

			return $this->getCNY2($won,$row) ;

		}

		function getCNY2($won,$rowFx)
		{
			$wpu = $rowFx['won_per_usd'] ;
			$cpu = $rowFx['cny_per_usd'] ;

			$usd = $won / $wpu ;

			return ceil($usd * $cpu * 100) / 100  ;

		}

		// 보너스 포인트 가져오기
		function getPoint($won)
		{

			return floor($this->pointRate * $this->getCNY($won)*100)/100 ;
		}

		// 무게 가져오기
		function getW($value)
		{
			return  ( $value * 10 ) / 10 ;
		}

		// 할인 정책에 따라 할인 금액을 리턴한다.
		function getProductDisAmt($row,$addInfo)
		{
			// 일단은 '0' ;
			return 0 ;

		}

		// 현지 배송비를 리턴한다.
		function getKoreaTranAmt($row,$info)
		{
			return $this->costForKTran * $info[cntBrand]  ;
		}



		// 해외 배송비를 리턴한다.
		function getOverTranAmt($row,$info)
		{
			$idx = ceil($info[tWeight] / 0.5) - 1;

			// echo $this->aTran[$idx] ;

			return	$this->getCNY($this->aTran[$idx]) ;
		}

		// 해외 배송비(EMS) 할일 금액을 리턴한다.
		function getOverTranDiscountAmt($row,$info)
		{

			return 0 ;
		}

		// 구매 수수료를 리턴한다.
		function getCommAmt($row,$info)
		{
			$t = $info[tBuyProductAmt] ;		// 총 물건가격(할인 된 금액까지)

			if( $t == 0 )
				return 0 ;

			$idx = -1 ;

			for($i = 0 ; $i < sizeof($this->aCommArea) ; $i++ )
			{
				if( $this->aCommArea[$i] > $t )
				{
					$idx = $i ;
					break ;
				}
			}


			$idx = ( $idx == -1 ) ? sizeof($this->aCommArea) - 1 : $idx ;

			return $this->aComm[$idx] ;
		}

		function getAmtSum($u_id,$is_dbu,$noSQL)
		{
			$sql = "
			SELECT
			sum(PRT.prt_amt) tProductWonAmt ,
			getCNY(sum(PRT.prt_amt),FX.won_per_usd,FX.cny_per_usd) tProductAmt ,
			count(distinct(agent_no)) cntBrand,
			sum(PRT.prt_weight) tWeight
			FROM niz_cart CART , niz_product PRT ,
			( SELECT * FROM niz_fx ORDER BY tdate DESC LIMIT 0,1 ) FX
			WHERE CART.u_id = '" . $u_id . "' AND CART.prt_no = PRT.no AND is_dbu = '" . $is_dbu . "' " . $noSQL  ;

			return $this->getRow($sql) ;
		}


		// 각종 금액 구하기
		function getAmts($sum)
		{

			$sum[tDiscountAmt] = $this->getProductDisAmt(NULL,$sum) ;

			$sum[tBuyProductAmt] = $sum[tProductAmt] - $tDiscountAmt ;	// 상품구매총액(할인포함)

			$sum[tCommAmt] = $this->getCommAmt(NULL,$sum) ;	// 수수료

			$sum[tKoreaTranAmt] = $this->getKoreaTranAmt(NULL,$sum) ;	// 국내물류비용

			$sum[tOverTranAmt]	= $this->getOverTranAmt(NULL,$sum)	;	// 해외물류비용

			$sum[tOverTranDiscountAmt] = $this->getOverTranDiscountAmt(NULL,$sum) ;	// 해외물류할인비용

			$sum[tTranAmt] = $sum[tOverTranAmt] + $sum[tKoreaTranAmt] - $sum[tOverTranDiscountAmt] ;	// 총 물류비용

			$sum[tFinalAmt] = $sum[tBuyProductAmt] + $sum[tTranAmt] + $sum[tCommAmt] ;		// 최종 결제 금액

			return $sum ;

		}
		*/

		//
		function dblog($type,$cus_fk,$memo,$amt)
		{
			$sql =
			"INSERT INTO niz_log (log_type,cus_fk,sdate,memo,amt) VALUES('" . $type . "'," . $cus_fk . ",now(),'" . $memo . "','" . $amt . "')" ;

			$this->update($sql) ;
		}

		function smallDdangDdang($number){
			return substr(number_format($number,2),0,strlen(number_format($number,2))-3).".<font size='0.5em'>".substr(number_format($number,2),-2,2)."</font>";
		}


		function changeNumberToDate($arrNumber)
		{
			$retVal = "" ;
			if($arrNumber!= "" )
				$retVal = substr($arrNumber, 0 , 4)."-".substr($arrNumber, 4 , 2)."-".substr($arrNumber, 6 , 9) ;
			return $retVal;
		}

		function splitRadix($num)
		{

			$arr = explode(".", $num) ;
			$radix = str_pad($arr[1], 2, "0", STR_PAD_RIGHT) ;
			if($arr[0] != "") {
				return Array(number_format($arr[0],0), $radix) ;
			}
			return Array($arr[0], $radix) ;
		}




		function getToday(){
			return date("Ymd",mktime());
		}

		function simpleFileLog($logData)
		{
			$today = $this->getToday() ;

			$fileDirectory = $this->logPath ;

			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}

			if(is_dir($fileDirectory.$today)!=true){
				mkdir($fileDirectory.$today);
			}


			$fileName = $today.".txt";

			$fPath = $fileDirectory.$today."/".$fileName;

			$fp = fopen($fPath,"a+");

			//파일에 쓰는부분 .

			fwrite($fp,"log Date : ".date("Y-m-d H:i:s",time()). " // " . $logData . "\n");
			fwrite($fp,"============================================================================\n");


			//파일 쓰기 끝 닫기

			fclose($fp);
		}

		function getImplStr ($aVal,$sNm) {
			$aRet = array();
			foreach($aVal as $aRow) {
				array_push($aRet, $aRow[$sNm]);
			}

			return implode(',', $aRet);
		}

		function getArrayToStrLoc ($aVal) {
			$aRet = array();
			foreach($aVal as $Row) {
				array_push($aRet, substr($Row,0,2));
			}

			return implode(',', $aRet);
		}

		function getSqlInjFilter($inp) {
			return $inp;
			//return str_replace(array(';', "--", "#", "%00", "/*" , "char("), array('', '\--', '\#', '\\%00', "\/*" , "\char\\("), $inp);
		}


		//셀레브리티 호스트 정보 체크 - By 유현돈
		function isCelebrityHost(){
			/* $found = array_search($this->_CURRENT_HOST, $this->_CELEBRITY_HOST_ARR);
			 echo "found : ".$found;
			 if($found) {
			 return 1;
			 } else {
			 return -1;
			 }*/

			//return strrpos($this->_CURRENT_HOST, $this->_CELEBRITY_HOST);
			$isCelebrityHost = false;
			for($i = 0; $i < count($this->_CELEBRITY_HOST_ARR); $i++){
				if($this->_CURRENT_HOST == $this->_CELEBRITY_HOST_ARR[$i]){
					$isCelebrityHost = true;
					break;
				}
			}

			return $isCelebrityHost;
		}

		//셀레브리티 타이틀 검색용 - By 유현돈
		function getCelebrityAddQueryByWord($columnName){
			$celebrityAddQuery = "";
			if($this->isCelebrityHost() === true){//셀레브리티 호스트
				$celebrityAddQuery = " AND (${columnName} LIKE '".$this->_CELEBRITY_WORD1."%' OR ${columnName} LIKE '%".$this->_CELEBRITY_WORD2."%') ";
			}
			return $celebrityAddQuery;
		}

		//셀레브리티 선사번호 검색용 - By 유현돈
		function getCelebrityAddQueryBySunsaNo($columnName){
			$celebrityAddQuery = "";
			if($this->isCelebrityHost() === true){//셀레브리티 호스트
				$celebrityAddQuery = " AND ${columnName} = '" . $this->_CELEBRITY_SUNSA_NO . "' " ;
			}
			return $celebrityAddQuery;
		}

		//셀레브리티 선사코드 검색용 - By 유현돈
		function getCelebrityAddQueryBySunsaCd($columnName){
			$celebrityAddQuery = "";
			if($this->isCelebrityHost() === true){//셀레브리티 호스트
				$celebrityAddQuery = " AND (${columnName} = '" . $this->_CELEBRITY_SUNSA_CD_C . "' OR ${columnName} = '" . $this->_CELEBRITY_SUNSA_CD_RC . "') " ;
			}
			return $celebrityAddQuery;
		}

		function getMillisecond(){
			list($microtime,$timestamp) = explode(' ',microtime());
			$time = $timestamp.substr($microtime, 2, 3);
			return $time;
		}

		function minusDays3To5($targetDate1, $targetDate2){
			$minusDay1 = -3;
			$minusDay2 = -3;
			if(date('w', strtotime($targetDate1)) < 4) $minusDay1 = -4;
			if(date('w', strtotime($targetDate2)) < 4) $minusDay2 = -4;
			return array($minusDay1, $minusDay2);
		}

		public static function round_up($value, $places)
		{
		    $mult = pow(10, abs($places));
		    return floor(($value * $mult+0.5).'') / $mult;
		}
	}
}
?>
