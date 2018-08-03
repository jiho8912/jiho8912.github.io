<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*------------------------------------[class]----------------------------------------
클래스명 - Paging - 페이지 처리를 수행하기위한 클래스
작성자   - 원종필(2010/03/04),
목적     - 게시판 자료 관련 처리(입력, 수정, 삭제)

-------------------------------------------------------------------------------------
관련요소
작업내역
        - 2010/03/04(수) : 시작 

------------------------------------------------------------------------------------*/
class Paging  extends CI_Model {
    private $pageSize      = 10;//한 화면에 보여질 페이지 목록 갯수
	private $listSize      = 10;//한 화면에 보여질 게시물 갯수
	private $page          = 1;//현재 작업중인 페이지
	private $recordCount   = 0;//게시물의 총 수
	private $addLink       = "";//페이지 번호에 붙일 링크 정보
	private $nowPageColor  = "red";//현재 선택된 페이지 번호를 표시하기 위한 색깔
	private $prevBlockImg  = "<<";//이전 페이지 블록(이전 10개 페이지)가기 이미지 또는 문자
	private $prevImg       = "<";//이전 페이지 가기 이미지 또는 문자
	private $middleImg     = "";//페이지 번호 중간에 들어갈 문자 또는 이미지
	private $nextImg       = ">";//다음 페이지 가기 이미지 또는 문자
	private $nextBlockImg  = ">>";//다음 페이지 블록 가기 이미지 또는 문자
	private $pageLinkType  = "";//페이지 정보를 어떨걸로 걸지 쿼리스트링으로 걸지 아니면 uri로 걸지
	
	function init(){
		$args = func_get_args();//함수에 전달된 인수를 배열로 가져옮
		$argNum = func_num_args();//함수에 전달된 인수의 갯수를 가져옮
		
		switch($argNum){
			case 1: $this->init1($args[0]); break;
			case 2: $this->init2($args[0], $args[1]); break;
			default:
				log_message("error", "페이징 속성 설정 인수 값이 너무 많습니다. , setInitCount : ".$argNum.", setInitArgs : ".serialize($args));
				show_error("페이징 속성 설정 인수 값이 너무 많습니다. , setInitCount : ".$argNum.", setInitArgs : ".serialize($args));
		}
		return true;
	}
	
    function init1($valArray = array()){
		if(count($valArray)>0){
			foreach($valArray as $key=>$val){
				if($val) $this->{$key} = $val;
			}
		}
	}
	
    function init2($key='', $val= ''){
		$this->{$key} = $val;
	}	
	
    function proc($post=array()){//페이지 처리를 위한 메소드
		if(count($post)>0) $initResult = $this->init($post);
		if(!$initResult) return false;
		if(!$this->recordCount) return false;//게시물이 존재하지 않으면 페이징이 필요 없음
		$totalPage = ceil($this->recordCount / $this->listSize); //전체 페이지 수
		$totalBlock = ceil($totalPage/$this->pageSize);
		$block = ceil($this->page/$this->pageSize);
		$firstPage = ($block-1)*$this->pageSize+1;
		$lastPage = $block * $this->pageSize;
		if($totalBlock<=$block) $lastPage = $totalPage;

		$pageList = "<ul class='paging' id='pagingMainBase'>";//전체를 감쌀 레이어

		//첫 페이지와 이전 10개  페이지를 구한다
		$pageList .= "<li id='prevBlockButton'>";//왼쪽 이전 10개블록으로 이동할 버튼을 감쌀 레이어
		if($block>1){
		   $prevBlockPage = $firstPage-1;
		   $pageList .= "<a href='".$this->addLink."&page=$prevBlockPage'>".$this->prevBlockImg."</a>";
		}else{
		   $pageList .= $this->prevBlockImg;
		}
		$pageList .= "</li>";
		
		$pageList .= "<li id='prevPageButton'>";
		$prevPage = $this->page-1;
		if($prevPage<1) $prevPage=1; 
		if($this->pageLinkType=="queryString"){
	    	$pageList .= "<a href='".$this->addLink."&page=$prevPage'>".$this->prevImg."</a>";
    	}else{
    		$pageList .= "<a href='".$this->addLink."&page=$prevPage'>".$this->prevImg."</a>";
    	}
		$pageList .= "</li>";
		
		//$pageList .= "<div id='pagingSubBase'>";
		for($i=$firstPage;$i<=$lastPage;$i++){
			
			if($i==$this->page){
				$pageList .= "<li id='page".$i."' class='bold'>";
				if($this->pageLinkType=="queryString"){
					$pageList .= "<a href='".$this->addLink."&page=$i'><font color='".$this->nowPageColor."'>$i</font></a>";
				}else{
					$pageList .= "<a href='".$this->addLink."&page=$i'><font color='".$this->nowPageColor."'>$i</font></a>";
				}
			}else{
				$pageList .= "<li id='page".$i."'>";
				if($this->pageLinkType=="queryString"){
					$pageList .= "<a href='".$this->addLink."&page=$i'>$i</a>";
				}else{
					$pageList .= "<a href='".$this->addLink."&page=$i'>$i</a>";
				}
			} 
			$pageList .= "</li>";
			$pageList .= ($i==$lastPage)?"":"<li id='pageMiddle$i' class='pageMiddleClass'>".$this->middleImg."</li>";
		}
		//$pageList.= "</div>";
		
		$pageList .= "<li id='nextPageButton'>";
		if($this->page>=$totalPage) $nextPage = $lastPage; else $nextPage = $this->page+1;

		if($this->pageLinkType=="queryString"){
			$pageList.="<a href='".$this->addLink."&page=$nextPage'>".$this->nextImg."</a>";
		}else{
			$pageList.="<a href='".$this->addLink."&page=$nextPage'>".$this->nextImg."</a>";
		}
		$pageList.= "</li>";
		
		$pageList .= "<li id='nextBlockButton'>";
		if($block<$totalBlock){
		   $nextBlockPage = $lastPage+1;
		   if($this->pageLinkType=="queryString"){
		   		$pageList.= "<a href='".$this->addLink."&page=$nextBlockPage'>".$this->nextBlockImg."</a>";
		   }else{
		   		$pageList.= "<a href='".$this->addLink."&page=$nextBlockPage'>".$this->nextBlockImg."</a>";
		   }
		}else{
		   $pageList.= $this->nextBlockImg;	
		}
		$pageList .= "</li>";
		
		$pageList .= "</ul>";
		return $pageList;
	}
}
/* End of file Paging.php */
/* Location: /application/libraries/Paging.php */