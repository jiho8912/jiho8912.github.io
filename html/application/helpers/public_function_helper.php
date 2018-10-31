<?php
if (!function_exists('debug')) {
    function debug() {
        $sapi_name = php_sapi_name();

        $args = func_get_args();
        $style2 = "word-break:break-all;word-wrap:break-word;";
        $style = "margin:5px 0px 5px 0px;color:white;background-color:black;line-height:1.5em;font-size:11px;font-family:Verdana;padding:5px;text-align:left;float:none;clear:both;display:block;position: static;";
        if (preg_match('/msie ([\d\.]+)/i', $_SERVER['HTTP_USER_AGENT'])) {
            $style2 = "word-break:break-all;word-wrap:break-word;";
        }
        $_DEBUG_ID = 'nKDebug';
        /*스타일 적용*/
        if (is_string($args[0])) {
            if (preg_match('/^(style=)(.+)/i', $args[0])) {
                $style .= str_replace(array('\'', "\"", "style="), '', array_shift($args));
            }
            else if (preg_match('/^(id=)(.+)/i', $args[0])) {
                $_DEBUG_ID = str_replace(array('\'', "\"", "style="), '', array_shift($args));
            }
        }
        if ($sapi_name != 'cli') {
            echo "\n<!--{{" . $_DEBUG_ID . "}}-->\n<div style=\"$style\">\n<xmp style='$style2;white-space:pre-wrap;'>";
        }
        print_r(count($args) > 1 ? $args : $args[0]);
        if ($sapi_name != 'cli') {
            echo "</xmp></div>\n";
        }
    }
}

/*------------------------------------[function]-------------------------------------
함수명   - alert()
내용	 - 경고메시지
------------------------------------------------------------------------------------*/
function alert($msg = '', $url = '') {
    $CI =& get_instance();
    if (!$msg) {
        $msg = '올바른 방법으로 이용해 주십시오.';
    }
    echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=" . $CI->config->item('charset') . "\">";
    echo "<script type='text/javascript'>";
    echo "alert('" . $msg . "');";
    if ($url) {
        echo "location.replace('" . $url . "');";
    }
    else {
        echo "history.go(-1);";
    }
    echo "</script>";
    exit;
}

/**
 * Paging Method
 * params {전체갯수, 페이지, 리스트갯수, 페이징갯수}
 */
function getPaging($totCnt, $page, $rScale, $pScale) {
    if ($rScale <= 0) {
        $rScale = 100000;
    }
    /*--------  전체 페이지 수 구하기 --------*/

    $Pages['totPage'] = ceil($totCnt / $rScale);

    $totPage = $Pages['totPage'];

    /*--------  처음, 마지막 페이지 구하기 --------*/
    if ($totPage < $pScale) {
        if ($page > $pScale) {
            $Pages['first'] = 1;
        }
        if (($Pages['totPage'] - $page) > $pScale) {
            $Pages['last'] = $Pages['totPage'];
        }
    }

    if ($page > 0 && $totCnt > $rScale) {
        $Pages['first'] = 1;
    }
    if ($Pages['totPage'] - $page > 0 && $totCnt > $rScale) {
        $Pages['last'] = $Pages['totPage'];
    }

    /*--------  이전, 다음 페이지 구하기 --------*/
    if ($page > 1) {
        $Pages['prev'] = $page - 1;
    } // 이전 페이지
    if ($page + 1 <= $Pages['totPage']) {
        $Pages['next'] = $page + 1;
    }

    if ($Pages['totPage'] >= ($pScale + $page)) {
        $Pages['back'] = $pScale + $page;
    }
    else if ($pScale + $page - $Pages['totPage'] > 0) {
        $Pages['back'] = $Pages['totPage'];
    }

    /*--------  이전, 다음 페이지 블럭 구하기 --------*/
    //if($page - $pScale > 0) $Pages['next'] = $Pages['back']-($pScale*2);

    //if($Pages['next'] < 0 )$Pages['next'] =1;

    /*--------  각 페이지 구하기 --------*/
    // 각 페이지 번호 구하기
    $nBlock = ceil($page / $pScale);
    $nExpire = $nBlock * $pScale;
    if ($nExpire >= $Pages['totPage']) {
        $nExpire = $Pages['totPage'];
    }

    $nInspire = ($nBlock - 1) * $pScale;
    if ($nInspire < 1) {
        $nInspire = 1;
    }

    $Pages['list'] = null;
    for ($nIndex = $nInspire; $nIndex <= $nExpire; $nIndex++) $Pages['list'][] = $nIndex;

    return $Pages;
}

/**
 * @param $totalCount 전체 개수
 * @param $currentPage 현재 페이지
 * @param $itemCount 보여줄 아이템 개수
 * @param $pageCount 보여줄 페이지 개수
 * @return stdClass
 */
function getPageInfo($totalCount, $currentPage, $itemCount, $pageCount) {
    $pageInfo = new stdClass();

    // 전체 글 수
    $pageInfo->totalCount = $totalCount;

    // 전체 페이지 수
    $pageInfo->totalPage = ceil($totalCount / $itemCount);

    // 현재 페이지
    $pageInfo->currentPage = $currentPage;

    // 이전 페이지
    if ($currentPage < 1) {
        $pageInfo->prevPage = 1;
    }
    else {
        $pageInfo->prevPage = $currentPage - 1;
    }

    // 다음 페이지
    if ($currentPage > $pageInfo->totalPage) {
        $pageInfo->nextPage = $pageInfo->totalPage;
    }
    else {
        $pageInfo->nextPage = $currentPage + 1;
    }

    if ($pageInfo->nextPage > $pageInfo->totalPage) {
        $pageInfo->nextPage = $pageInfo->totalPage;
    }

    // 처음 페이지
    $pageInfo->firetPage = 1;

    // 마지막 페이지
    $pageInfo->lastPage = $pageInfo->totalPage;

    $std = floor($currentPage / $pageCount);

    // 시작 페이지
    $pageInfo->startPage = $std * $pageCount + 1;

    if ($pageInfo->startPage == $currentPage + 1) {
        $pageInfo->startPage = $pageInfo->startPage - $currentPage;
    }

    if ($pageInfo->startPage < 1) {
        $pageInfo->startPage = 1;
    }

    // 종료 페이지
    $pageInfo->endPage = $pageInfo->startPage + $pageCount - 1;

    if ($pageInfo->endPage > $pageInfo->lastPage) {
        $pageInfo->endPage = $pageInfo->lastPage;
    }

    // 페이지 목록
    $pageInfo->pageList = array();
    for ($i = $pageInfo->startPage; $i <= $pageInfo->endPage; $i++) {
        array_push($pageInfo->pageList, $i);
    }


    if (empty($_SERVER['REQUEST_URI']) == false) {
        $url = parse_url($_SERVER['REQUEST_URI']);
        $pageInfo->query = $url['query'];
        $pageInfo->path = $url['path'];
    }

    $pageInfo->query = preg_replace('/\&page=(\d+)/i', '', $pageInfo->query);
    $pageInfo->query = preg_replace('/page=(\d+)/i', '', $pageInfo->query);
    $pageInfo->query = $pageInfo->query . '&page=';


    return $pageInfo;

}

/**
 * 자바스크립트 삭제
 * @param $value
 * @return mixed
 */
function removeJsScript($value) {
    return preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $value);
}

/**
 * 자바스크립트 삭제
 * @param $object
 * @param $keyNames
 * @return mixed
 */
function removeJsScripts($object, $keyNames) {
    foreach($keyNames as $keyName) {
        $object->$keyName = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $object->$keyName);
    }

    return $object;
}

/**
 * HTML 삭제
 * @param $object
 * @param $keyNames
 * @param null $allowTags
 * @return mixed
 */
function removeHtmlTags($object, $keyNames, $allowTags = null) {
    foreach ($keyNames as $keyName) {
        $object->$keyName = strip_tags($object->$keyName, $allowTags);
    }

    return $object;
}

/**
 * 체크박스나 라디오버튼 체크용
 * @param $formValue
 * @param $checkValue
 */
function attrChecked($formValue, $checkValue) {

    if (is_bool($formValue) && is_numeric($checkValue)) {
        if ($formValue == filter_var($checkValue, FILTER_VALIDATE_BOOLEAN)) {
            echo 'checked="checked"';
        }
    }
    else {
        if ($formValue === $checkValue) {
            echo 'checked="checked"';
        }
    }
}

/**
 * 셀렉트 목록에서 옵션값 셀렉트용
 * @param $optionValue
 * @param $selectValue
 */
function attrSelected($optionValue, $selectValue) {
    if (is_bool($optionValue) && is_numeric($selectValue)) {
        if ($optionValue == filter_var($selectValue, FILTER_VALIDATE_BOOLEAN)) {
            echo 'selected="selected"';
        }
    }
    else {
        if ($optionValue === $selectValue) {
            echo 'selected="selected"';
        }
    }
}

/**
 * 카멜 표기법으로 변경한다.
 * @param $input
 * @param string $separator
 * @param bool $lcFirst
 * @return mixed
 */
function toCamelCase($input, $separator = '_', $lcFirst = true) {

    if ($lcFirst == true) {
        return lcfirst(str_replace($separator, '', ucwords($input, $separator)));
    }
    else {
        return str_replace($separator, '', ucwords($input, $separator));
    }
}

/**
 * 객체의 키값을 카멜표기법으로 변경한다.
 * @param $object
 * @param string $separator 구분자
 * @param bool $lcFirst
 * @return mixed
 */
function toKeyCamelCase($object, $separator = '_', $lcFirst = true) {

    $array = get_object_vars($object);
    foreach ($array as $key => $value) {
        if (strpos($key, $separator) == true) {
            $camelName = toCamelCase($key, $separator, $lcFirst);
            $object->$camelName = $value;
            unset($object->$key);
        }
    }

    return $object;
}

/**
 * 객체의 키값을 카멜표기법으로 변경한다.
 * @param $object
 * @param string $separator
 * @param bool $lcFirst
 * @return mixed
 */
function toKeyCamelCaseList($object, $separator = '_', $lcFirst = true) {
    foreach ($object as $key => $value) {
        $object[$key] = toKeyCamelCase($value, $separator, $lcFirst);
    }

    return $object;
}

/**
 * 카멜표기법에서 구분자 넣은 표기법으로 변경한다.
 * @param $input
 * @param string $separator
 * @return string
 */
function fromCamelCase($input, $separator = '_') {
    return strtolower(preg_replace('/(?<!^)[A-Z]+|(?<!^|\d)[\d]+/', $separator . '$0', $input));
}

/**
 * 객체의 키값을 카멜표기법에서 구분자 넣은 표기법으로 변경한다.
 * @param $object
 * @param string $separator
 * @return mixed
 */
function fromKeyCamelCase($object, $separator = '_') {
    $array = get_object_vars($object);
    foreach ($array as $key => $value) {
        $camelName = fromCamelCase($key, $separator);
        if($key != $camelName) {
            $object->$camelName = $value;
            unset($object->$key);
        }
    }

    return $object;
}

/**
 * 객체의 키값을 카멜표기법에서 구분자 넣은 표기법으로 변경한다.
 * @param $object
 * @param string $separator
 * @return mixed
 */
function fromKeyCamelCasList($object, $separator = '_') {
    foreach ($object as $key => $value) {
        $object[$key] = fromKeyCamelCase($value, $separator);
    }

    return $object;
}
