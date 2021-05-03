<?php

class Admin_shop_category_m extends CI_Model {

    private $TABLE_NAME = 'shop_category_list';

    function __construct() {
        parent::__construct();
    }

    /**
     * 상품 카테고리 추가 또는 업데이트 후 해당 객체 리턴
     * @param $category
     * @return null
     */
    public function save($category) {
        $this->db->trans_start();

        $category->updateTime = date('Y-m-d H:i:s');

        $lastId = '';

        //debug($category);

        // 해당 카테고리 주키가 없으면 추가 있으면 업데이트
        if (!$category->categorySeq) {
            $category->isDel = false;
            $this->db->set('reg_time', 'now()', false);

            $category = fromKeyCamelCase($category);
            $this->db->insert($this->TABLE_NAME, $category);

            $lastId = $this->db->insert_id();
        }
        else {
            $this->db->where('category_seq', $category->categorySeq);
            $category = fromKeyCamelCase($category);
            $this->db->update($this->TABLE_NAME, $category);
            //debug($this->db->last_query());
        }

        $this->db->trans_complete();

        if (!$category->categorySeq) {
            return $this->findOne($lastId);
        }
        else {
            return $this->findOne($category->categorySeq);
        }

    }

    /**
     * 여러 상품 카테고리 추가 또는 업데이트 후 해당 객체 리턴
     * @param $categoryList
     */
    public function saves($categoryList) {
        foreach ($categoryList as $category) {
            $this->save($category);
        }
    }

    /**
     * 카테고리 받기
     * @param $categorySeq 카테고리 주키
     * @return mixed
     */
    public function findOne($categorySeq) {
        $this->db->where('category_seq', (int)$categorySeq);
        $query = $this->db->get($this->TABLE_NAME);
        return $query->row(0);
    }

    /**
     * 전체 상품 카테고리 받기
     * @return mixed
     */
    public function findAll() {
        return toKeyCamelCaseList($this->db->get($this->TABLE_NAME)->result());
    }

    /**
     * 카테고리 목록 받기
     * 삭제 안된것, list_order 오름 차순 정렬
     * @param $sellerSeq 판매자 주키
     * @param $parentSeq 상위 카테고리 주키
     * @param $depth 카테고리 깊이
     * @return array
     */
    public function select_category_list($parentSeq, $depth) {
        $this->db->select('category_seq as categorySeq, name, parent_seq as parentSeq, depth');
        $this->db->where('parent_seq', $parentSeq);
        $this->db->where('depth', $depth);
        $this->db->where('is_del', false);
        $this->db->order_by('list_order', 'ASC');
        $query = $this->db->get($this->TABLE_NAME);
        //debug($this->db->last_query());
        return $query->result();
    }

    /**
     * 상품 카테고리 삭제
     * @param $categorySeq 카테고리 주키
     */
    public function delete($categorySeq) {

        $category = $this->findOne($categorySeq);
        $category->isDel = true;
        $category->update_time = date('Y-m-d H:i:s');
        $this->db->where('category_seq', $categorySeq);

        $category = fromKeyCamelCase($category);
        $this->db->update($this->TABLE_NAME, $category);
    }

    /**
     * 해당 개수 반환
     * @param $seller_seq 판매자 주키
     * @param $name 카테고리 이름
     * @return mixed
     */
    public function countBySellerSeqAndName($seller_seq, $name) {
        $this->db->select('count(*) as count');
        $this->db->where('seller_seq', $seller_seq);
        $this->db->where('seller_seq', $name);
        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }

    /**
     * 해당 개수 반환
     * 삭제 되지 않은 것으로
     * @param $sellerSeq 판매자 주키
     * @param $name 카테고리 이름
     * @return mixed
     */
    public function countBySellerSeqAndNameAndIsDelFalse($sellerSeq, $name) {
        $this->db->select('count(*) as count');
        $this->db->where('seller_seq', $sellerSeq);
        $this->db->where('name', $name);
        $this->db->where('is_del', false);
        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }

    /**
     * 해당 개수 반환
     * 삭제 되지 않은 것으로
     * @param $sellerSeq 판매자 주키
     * @param $name 카테고리 이름
     * @param $depth 카테고리 깊이
     * @return mixed
     */
    public function countBySellerSeqAndNameAndDepthAndIsDelFalse($sellerSeq, $name, $depth) {
        $this->db->select('count(*) as count');
        $this->db->where('seller_seq', $sellerSeq);
        $this->db->where('name', $name);
        $this->db->where('depth', $depth);
        $this->db->where('is_del', false);
        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }

    /**
     * 해당 개수 반환
     * 삭제 되지 않은 것으로
     * @param $sellerSeq 판매자 주키
     * @param $name 카테고리 이름
     * @param $parentSeq 상위 카테고리 주키
     * @param $depth 카테고리 깊이
     * @return mixed
     */
    public function countBySellerSeqAndNameAndParentSeqAndDepthAndIsDelFalse($sellerSeq, $name, $parentSeq, $depth) {
        $this->db->select('count(*) as count');
        $this->db->where('seller_seq', $sellerSeq);
        $this->db->where('name', $name);
        $this->db->where('parent_seq', $parentSeq);
        $this->db->where('depth', $depth);
        $this->db->where('is_del', false);

        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }

    /**
     * 해당 개수 반환
     * 삭제 되지 않은 것으로
     * @param $seller_seq 판매자 주키
     * @return mixed
     */
    public function countBySellerSeqAndIsDelFalse($seller_seq) {
        $this->db->select('count(*) as count');
        $this->db->where('seller_seq', $seller_seq);
        $this->db->where('is_del', false);
        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }

    /**
     * 해당 개수 반환
     * 삭제 되지 않은 것으로
     * @param $sellerSeq 판매자 주키
     * @param $parentSeq 상위 카테고리 주키
     * @return mixed
     */
    public function countBySellerSeqAndParentSeqAndIsDelFalse($sellerSeq, $parentSeq) {
        $this->db->select('count(*) as count');
        $this->db->where('seller_seq', $sellerSeq);
        $this->db->where('parent_seq', $parentSeq);
        $this->db->where('is_del', false);
        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }

    /**
     * 해당 개수 반환
     * 삭제 되지 않은 것으로
     * @param $sellerSeq 판매자 주키
     * @param $parentSeq 상위 카테고리 주키
     * @param $depth 카테고리 깊이
     */
    public function countBySellerSeqAndParentSeqAndDepthAndIsDelFalse($sellerSeq, $parentSeq, $depth) {
        $this->db->select('count(*) as count');
        $this->db->where('seller_seq', $sellerSeq);
        $this->db->where('parent_seq', $parentSeq);
        $this->db->where('is_del', false);
        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }

    /**
     * 해당 개수 반환
     * @param $category_seq 카테고리 주키
     * @param $seller_seq 판매자 주키
     * @return mixed
     */
    public function countByCategorySeqAndSellerSeq($category_seq, $seller_seq) {

        $this->db->select('count(*) as count');
        $this->db->where('category_seq', $category_seq);
        $this->db->where('seller_seq', $seller_seq);
        $query = $this->db->get($this->TABLE_NAME);

        return $query->row(0)->count;
    }
}
