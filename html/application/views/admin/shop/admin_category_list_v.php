<div class="col-md-3">
    <div id="depth0" class="box box-solid" data-parent-seq="0" data-depth="0">
        <div class="box-header no-padding with-border text-center">
            <h5 class="bold">대분류</h5>
        </div>
        <div class="box-header with-border text-center">
            <div class="form-inline">
                <div class="form-group">
                    <button name="addCategoryModal" class="btn btn-mini btn-info">등록</button>
                    <button name="updateCategoryModal" class="btn btn-mini btn-success">수정</button>
                    <button name="deleteCategory" class="btn btn-mini btn-danger">삭제</button>
                </div>
            </div>
        </div><br>
        <div class="box-body text-center">
            <select class="form-control" size="10" style="overflow-y: auto;">
                <? foreach ($categoryList as $category) : ?>
                    <option value="<?=$category->categorySeq?>"><?=$category->name?></option>
                <? endforeach; ?>
            </select>
            <br>
            <a name="sortUp" class="top_sm_btn">
                <span class="top_arrow_con">▲</span>위로
            </a>
            <a  name="sortDown" class="down_sm_btn">
                <span class="down_arrow_con">▼</span>아래로
            </a>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div id="depth1" class="box box-solid" data-depth="1">
        <div class="box-header no-padding with-border text-center">
            <h5 class="bold">중분류</h5>
        </div>
        <div class="box-header with-border text-center">
            <div class="form-inline">
                <div class="form-group">
                    <button name="addCategoryModal" class="btn btn-mini btn-info">등록</button>
                    <button name="updateCategoryModal" class="btn btn-mini btn-success">수정</button>
                    <button name="deleteCategory" class="btn btn-mini btn-danger">삭제</button>
                </div>
            </div>
        </div><br>
        <div class="box-body text-center">
            <select class="form-control" size="10" style="overflow-y: auto;">
            </select>
            <br>
            <a name="sortUp" class="top_sm_btn">
                <span class="top_arrow_con">▲</span>위로
            </a>
            <a  name="sortDown" class="down_sm_btn">
                <span class="down_arrow_con">▼</span>아래로
            </a>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div id="depth2" class="box box-solid" data-depth="2">
        <div class="box-header no-padding with-border text-center">
            <h5 class="bold">소분류</h5>
        </div>
        <div class="box-header with-border text-center">
            <div class="form-inline">
                <div class="form-group">
                    <button name="addCategoryModal" class="btn btn-mini btn-info">등록</button>
                    <button name="updateCategoryModal" class="btn btn-mini btn-success">수정</button>
                    <button name="deleteCategory" class="btn btn-mini btn-danger">삭제</button>
                </div>
            </div>
        </div><br>
        <div class="box-body text-center">
            <select class="form-control" size="10" style="overflow-y: auto;">
            </select>
            <br>
            <a name="sortUp" class="top_sm_btn">
                <span class="top_arrow_con">▲</span>위로
            </a>
            <a  name="sortDown" class="down_sm_btn">
                <span class="down_arrow_con">▼</span>아래로
            </a>
        </div>
    </div>
</div>
<div id="categoryModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <input type="text" name="name" class="form-control"/>
            </div>
            <div class="modal-footer">
                <div class="pull-right">
                    <button class="btn btn-flat" data-dismiss="modal">취소</button>
                    <button id="addCategory" class="btn btn-navy btn-flat hide">등록</button>
                    <button id="updateCategory" class="btn btn-primary btn-flat hide">수정</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function () {

        // 카테고리 등록, 수정 모달
        $("button[name='addCategoryModal'], button[name='updateCategoryModal'").click(function () {
            var button = $(this);
            var box = $(this).closest("div.box");
            var categoryModal = $("div#categoryModal");
            var params = {};

            params.categorySeq = box.find("select option:selected").val();
            params.parentSeq = box.data("parentSeq");
            params.name = box.find("select option:selected").text();
            params.depth = box.data("depth");

            categoryModal.find("#addCategory").addClass("hide");
            categoryModal.find("#updateCategory").addClass("hide");

            if (button.attr("name") == "addCategoryModal") {
                categoryModal.data("type", "add");

                categoryModal.find("#addCategory").removeClass("hide");
                categoryModal.find(".modal-title").text("카테고리 등록");

                if (params.depth > 0) {
                    var parentDepth = params.depth - 1;
                    var parentCategory = $("div#depth" + parentDepth);
                    var parent = {};

                    parent.categorySeq = parentCategory.find("select option:selected").val();

                    if (typeof parent.categorySeq === "undefined") {
                        swal("", "상위 카테고리를 선택하여 주십시오.", "error");
                        return 0;
                    }

                    params.parentSeq = parent.categorySeq;
                }
            }
            else if (button.attr("name") == "updateCategoryModal") {

                if (typeof params.categorySeq === "undefined") {
                    swal("", "카테고리를 선택하여 주십시오.", "error");
                    return 0;
                }

                categoryModal.data("type", "update");
                categoryModal.data("categorySeq", params.categorySeq);
                categoryModal.find("#updateCategory").removeClass("hide");
                categoryModal.find(".modal-title").text("카테고리 수정");
                categoryModal.find("input[name='name']").val(params.name);
            }


            categoryModal.data("parentSeq", params.parentSeq);
            categoryModal.data("depth", params.depth);


            categoryModal.modal("show");
        });

        // 카테고리 등록 및 수정
        $("button#addCategory, button#updateCategory").click(function () {
            var categoryModal = $("div#categoryModal");
            var type = categoryModal.data("type");
            var params = {};
            var dialogText;
            var url;

            if (type == "add") {
                dialogText = "카테고리를 등록중 입니다.";
                url = "/admin/Shop_category/add";
            }
            else if (type == "update") {
                dialogText = "카테고리를 수정중 입니다.";
                url = "/admin/Shop_category/update";
                params.categorySeq = categoryModal.data("categorySeq");
            }

            params.name = categoryModal.find("input[name='name']").val();
            params.parentSeq = categoryModal.data("parentSeq");
            params.depth = categoryModal.data("depth");

            swal({
                text: dialogText,
                onOpen: function () {
                    swal.showLoading();

                    $.ajax({
                        method: "post",
                        url: url,
                        contentType: "application/json",
                        data: JSON.stringify(params),
                        success: function (process) {
                            if (process.result == true) {
                                swal("", process.message, "success").then(function () {

                                    var box = $("div#depth" + params.depth);

                                    if (type == "add") {
                                        var category = process.data.category;
                                        box.find("select").append('<option value="' + category.categorySeq + '">' + category.name + '</option>');
                                    }
                                    else if (type == "update") {
                                        box.find("select option:selected").text(params.name);
                                    }

                                    categoryModal.modal("hide");
                                });

                            }
                            else {
                                if (process.errors) {
                                    process.message = process.errors[Object.keys(process.errors)[0]];
                                }

                                swal("", process.message, "error");
                            }
                        }
                    });
                }
            });
        });

        // 모달이 사라졌을때
        $("div#categoryModal").on("hidden.bs.modal", function () {
            $("div#categoryModal input[name='name']").val('');
        });

        // 카테고리 선택했을때
        $(document).on("click", "div.box select option", function () {

            var params = {};
            params.categorySeq = $(this).val();
            params.depth = $(this).closest("div.box").data("depth") + 1;

            //console.log(params);

            if (params.depth == 1) {
                $("div#depth1 select option").remove();
                $("div#depth2 select option").remove();
            }
            else if (params.depth == 2) {
                $("div#depth2 select option").remove();
            }

            console.log(params.depth);

            if (params.depth < 3) {

                var subBox = $("div#depth" + (params.depth));

                swal({
                    text: "하위 카테고리 로딩중",
                    onOpen: function () {
                        swal.showLoading();

                        $.ajax({
                            method: "post",
                            url: "/admin/Shop_category/getSubCategoryList",
                            contentType: "application/json",
                            data: JSON.stringify(params),
                            success: function (process) {

                                if (process.result == true) {
                                    swal.close();

                                    var categoryList = process.data.categoryList;

                                        if (categoryList.length > 0) {
                                        subBox.data("parentSeq", params.categorySeq);
                                        console.log(subBox.data());
                                        categoryList.forEach(function (category) {
                                            subBox.find("select").append('<option value="' + category.categorySeq + '">' + category.name + '</option>');
                                        });
                                    }
                                }
                                else {
                                    swal("", process.message, "error");
                                }
                            }
                        });
                    }
                });
            }
        });

        // 카테고리 삭제
        $("button[name='deleteCategory']").click(function () {

            var box = $(this).closest("div.box");
            var selected = box.find("select option:selected");

            var params = {};
            params.categorySeq = selected.val();

            if (typeof params.categorySeq === "undefined") {
                swal("", "카테고리를 선택하여 주십시오.", "error");
                return 0;
            }

            swal({
                html: "<b>" + selected.text() + "</b> " +
                    "카테고리를 삭제 하시겠습니까?<br/>" +
                    "하위 카테고리가 존재하는 경우 삭제되지 않습니다.",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "삭제",
                cancelButtonText: "취소",
                allowOutsideClick: false
            }).then(function () {
                swal({
                    text: "카테고리를 삭제하는 중입니다.",
                    allowOutsideClick: false,
                    onOpen: function () {
                        swal.showLoading();

                        $.ajax({
                            method: "post",
                            url: "/admin/shop_category/delete",
                            contentType: "application/json",
                            data: JSON.stringify(params),
                            success: function (process) {

                                if (process.result == true) {
                                    swal("", process.message, "success").then(function () {
                                        selected.remove();
                                    });

                                }
                                else {
                                    swal("", process.message, "error");
                                }
                            }
                        });
                    }
                });
            }, function (dismiss) {
                if (dismiss === "cancel") {
                    return 0;
                }
            });
        });

        // 카테고리 위로
        $("a[name='sortUp']").click(function () {

            var box = $(this).closest("div.box");

            var selected = box.find("select option:selected");
            var before = selected.first().prev();
            selected.insertBefore(before);
            updateSort(box);
        });

        // 카테고리 아래로
        $("a[name='sortDown']").click(function () {

            var box = $(this).closest("div.box");

            var selected = box.find("select option:selected");

            var after = selected.last().next();
            selected.insertAfter(after);
            updateSort(box);
        });

        // 카테고리 순서 저장
        function updateSort(box) {

            var params = {};
            params.listOrder = [];

            box.find("select option").each(function () {
                params.listOrder.push($(this).val());
            });

            console.log(params);

            $.ajax({
                method: "post",
                url: "/admin/shop_category/updateSort",
                contentType: "application/json",
                data: JSON.stringify(params),
                success: function (process) {
                    if (process.result == false) {
                        swal({
                            text: process.message,
                            type: 'error'
                        });
                    }
                }
            });


        }
    });


</script>
