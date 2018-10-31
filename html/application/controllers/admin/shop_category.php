<?php
header("Content-Type:application/json");

class Shop_category extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin/admin_shop_category_m');
    }

    /**
     * 카테고리 생성
     */
    function add() {
        $params = file_get_contents('php://input');
        $category = json_decode($params);

        try {
            $category = $this->admin_shop_category_m->save($category);

            $data = new stdClass();
            $data->category->categorySeq = $category->categorySeq;
            $data->category->name = $category->name;
            unset($category);

            $result = new stdClass();
            $result->result = true;
            $result->message = "생성 되었습니다.";
            $result->data = $data;

            echo json_encode($result, JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {

            $result = new stdClass();
            $result->result = false;

            if(!json_decode($e->getMessage())) {
                $result->message = $e->getMessage();
            }
            else {
                $result->message = '카테고리 생성 오류';
                $result->errors = json_decode($e->getMessage());
            }

            echo json_encode($result, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 카테고리 목록 불러오기
     */
    function getSubCategoryList() {

        $pr = new stdClass();

        $params = file_get_contents('php://input');

        $category = json_decode($params);

        //debug($category);

        try {

            $categoryList = $this->admin_shop_category_m->select_category_list($category->categorySeq, $category->depth);

            foreach ($categoryList as $category) {
                unset($category->sellerSeq, $category->parentSeq, $category->depth, $category->listOrder, $category->isDel, $category->regTime, $category->updateTime);
            }

            $pr->data->categoryList = $categoryList;

            $pr->result = true;
            echo json_encode($pr, JSON_UNESCAPED_UNICODE);
        }
        catch (Exception $e) {
            $pr->result = false;
            $pr->message = $e->getMessage();

            echo json_encode($pr, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 카테고리 수정
     */
    function update() {

        $pr = new stdClass();

        $params = file_get_contents('php://input');
        $category = json_decode($params);
        try {
            $this->admin_shop_category_m->save($category);

            $pr->result = true;
            $pr->message = "수정 되었습니다.";

            echo json_encode($pr, JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            $pr->result = false;

            if(!json_decode($e->getMessage())) {
                $pr->message = $e->getMessage();
            }
            else {
                $pr->message = '카테고리 수정 오류';
                $pr->errors = json_decode($e->getMessage());
            }

            echo json_encode($pr, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 카테고리 삭제
     */
    function delete() {
        $pr = new stdClass();

        $params = file_get_contents('php://input');
        $category = json_decode($params);

        try {

            $this->admin_shop_category_m->delete($category->categorySeq);

            $pr->result = true;
            $pr->message = "삭제 되었습니다.";

            echo json_encode($pr, JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            $pr->result = false;
            $pr->message = $e->getMessage();

            echo json_encode($pr, JSON_UNESCAPED_UNICODE);
        }
    }

    /**
     * 카테고리 정렬 순서 변경
     */
    function updateSort() {

        $pr = new stdClass();

        $params = file_get_contents('php://input');
        $params = json_decode($params);

        try {

            if (count($params->listOrder) == 0) {
                throw new Exception('카테고리가 없습니다.');
            }

            foreach ($params->listOrder as $key => $param) {
                $category = new stdClass();
                $category->categorySeq = $param;
                $category->listOrder = $key;
                array_push($categoryList, $category);
            }

            $categoryList = array();

            foreach ($params->listOrder as $key => $categorySeq) {
                $category = new stdClass();
                $category->categorySeq = $categorySeq;
                $category->listOrder = $key;
                array_push($categoryList, $category);
            }

            foreach ($categoryList as $key => $category) {
                //$oCategory = $this->admin_shop_category_m->findOne($category->categorySeq);
                //$oCategory->listOrder = $category->listOrder;
                //$categoryList[$key] = $oCategory;
            }

            //debug($categoryList);

            $this->admin_shop_category_m->saves($categoryList);

            $pr->result = true;
            $pr->message = '수정 되었습니다.';

            echo json_encode($pr, JSON_UNESCAPED_UNICODE);
        } catch (Exception $e) {

            $pr->result = false;
            $pr->message = $e->getMessage();
            echo json_encode($pr, JSON_UNESCAPED_UNICODE);
        }
    }
}
