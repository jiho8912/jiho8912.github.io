<style>
    .center {text-align:center !important; vertical-align:middle !important;}
</style>
<div class="col-md-9">
    <h3>방문자통계</h3>

    <!-- 메인 메뉴 설정 -->
    <div style="margin-top:30px !important;">

        <!--검색-->
        <form name="searchForm" method="post" action="/admin/visitor/admin_visitor_v">
            <div class="clearfix">
                <select name="searchKey" id="searchKey" class="form-control input-sm auto pull-left">
                    <option value="ip_address">ip주소</option>
                </select>
                <div class="span4 pull-left">
                    <div class="input-group">
                        <input name="searchValue" class="form-control input-sm" maxlength="15" value="<?=@$searchValue?>">
                        <span class="input-group-btn">
							<button type="submit" class="btn btn-sm btn-primary">검색</button>
						</span>
                    </div>
                </div>
                <div class="pull-right">
                    <?=@$paging?>
                    total : <?=$cnt['total_rows']?>
                </div>
            </div>
        </form><br>

        <form id="main_setting_form" method="post" enctype="multipart/form-data" action="">
            <input type = "hidden" id = "img_sort" name = "img_sort" value = "">
            <!-- 순서변경을 위해-->
            <input type = "hidden" id = "img_up_down" name = "img_up_down" value = "">

            <table class="table table-bordered" style="margin-bottom:10px !important;">
                <colgroup>
                    <col width="80px;"/>
                    <col width="80px;"/>
                    <col width="200px;"/>
                    <col width="300px;"/>
                    <col width="100px;"/>
                    <col width="100px;"/>
                </colgroup>
                <tbody class = "center">
                <tr>
                    <th class ="center">선택</th>
                    <th class ="center">세션아이디</th>
                    <th class ="center">ip주소</th>
                    <th class ="center">접속환경</th>
                    <th class ="center">접속페이지</th>
                    <th class ="center">접속시간</th>
                </tr>

                <?if(sizeof($visitor_list)){?>
                    <?foreach($visitor_list as $list){?>
                        <tr>
                            <td class ="center"><input type="checkbox" name="no[]" value="<?=$list['no']?>"></td>
                            <td class ="center"><?=$list['session_id']?></td>
                            <td class ="center"><?=$list['ip_address']?></td>
                            <td class ="center"><?=$list['user_agent']?></td>
                            <td class ="center"><?=$list['current_page']?></td>
                            <td class ="center"><?=date("Y/m/d H:i:s", $list['last_activity'])?></td>
                        </tr>
                    <?}?>
                <?}else{?>
                    <tr>
                    <tr>
                        <td colspan="6" style ="color:red;">
                            해당하는 기록이 없습니다.
                        </td>
                    </tr>
                    </tr>
                <?}?>
                </tbody>

            </table>

            <div class="btn-group pull-right" style="margin-bottom:10px !important;">
                <div class="btn-group">
                    <div class="right">
                        <a href="#" class="btn-del btn btn-mini btn-danger">삭제</a>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<script>
    $(document).ready(function() {
        //검색어 유지
        var searchKey = "<?=@$searchKey?>";

        $("#searchKey option").each(function(){
            var val = $(this).val();
            if(searchKey == $(this).val()){
                $(this).attr("selected",true);
            }
        });
        //회원정보수정 팝업창 호출
        $("[id*='popbutton_']").each(function(){
            $(this).click(function(){
                $("#msg_mb_email").empty();
                $("[class*='tooltip']").empty();
                $.post("/admin/member/admin_member_update_v",
                    {
                        ajax : true,
                        member_id : $(this).attr("title"),
                    },

                    function(data){

                        var member_data = JSON.parse(data);

                        $("#mb_id").html(member_data.mb_id); //아이디
                        $("input[name='mb_id']").val(member_data.mb_id); //아이디 히든값
                        $("#mb_name").val(member_data.mb_name); //이름
                        $("#reg_date").html(member_data.reg_date.substring(0,11)); //가입일
                        $("#reg_mb_point").html(member_data.point); //포인트
                        $("#reg_mb_email").val(member_data.mb_email); //이메일
                        $("#mb_hp").val(member_data.mb_hp); //핸드폰

                        $('div.modal').modal('show');
                    });

            })
        });

        // 선택 이미지 삭제
        $(".btn-del").click(function(){
            if($("input[name='no[]']:checked").length){
                if(confirm("삭제하시겠습니까?")){
                    $("#main_setting_form").attr("action","/admin/member/admin_member_delete");
                    $('#main_setting_form').submit();
                }else{
                    return false;
                }
            }else{
                alert("하나 이상 선택하여야 합니다.");
                return false;
            }
        });

        // 설정 저장
        $(".btn-save").click(function(){

            $("#main_setting_form").submit();
        });

        $('#update_mb_data').validate({
            onkeyup: false,
            rules: {
                mb_password: { required:false, minlength:3 },
                mb_password_re: { required:false, equalTo:'#mb_password'},
                mb_name: { required:true,  minlength:2, hangul:true },
                mb_email: { required:true, },
            },
            messages: {
                mb_email: '이메일 확인 결과가 올바르지 않습니다.',
                mb_password: { required:'비밀번호를 입력하세요.', minlength:'최소 3자 이상 입력하세요.' },
                mb_password_re: { required:'비밀번호 확인을 입력하세요.', equalTo:'비밀번호가 일치하지 않습니다.' },
                mb_name: { required:'이름을 입력하세요.', minlength:'최소 2자 이상 입력하세요.' },
            }
        });

    });
</script>

<!--회원정보수정 팝업창-->
<div class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    회원정보 수정
                </h4>
            </div>

            <div>
                <form id="update_mb_data" class="form-horizontal" method="post" action="/admin/member/admin_member_update" novalidate="novalidate">
                    <input type="hidden" name="mb_id" value="">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="reg_mb_id">아이디</label>
                        <div class="col-md-9">
                            <div id = "mb_id" style = "margin-top:7px;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="reg_mb_id">가입일</label>
                        <div class="col-md-9">
                            <div id = "reg_date" style = "margin-top:7px;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mb_password"><span class="glyphicon glyphicon-exclamation-sign"></span> 비밀번호</label>
                        <div class="col-md-9">
                            <input type="password" id="mb_password" name="mb_password" class="form-control span3" maxlength="20"> 3 ~ 20자
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mb_password_re"><span class="glyphicon glyphicon-exclamation-sign"></span> 비밀번호 확인</label>
                        <div class="col-md-9">
                            <input type="password" id="mb_password_re" name="mb_password_re" class="form-control span3" maxlength="20" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mb_name"><span class="glyphicon glyphicon-exclamation-sign"></span> 이름</label>
                        <div class="col-md-9">
                            <input type="text" id="mb_name" name="mb_name" class="form-control span2" maxlength="10" value="">
                            공백없이 한글만 입력 가능
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="mb_hp"><span class="glyphicon glyphicon-phone"></span>휴대폰</label>
                        <div class="col-md-3">
                            <input type="tel" id="mb_hp" name="mb_hp" class="form-control" maxlength="14" value=""/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="reg_mb_email"><span class="glyphicon glyphicon-exclamation-sign"></span> 이메일</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                <input type="email" id="reg_mb_email" name="mb_email" class="form-control" maxlength="60" value="">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <button type="button" id="btn_email" class="btn btn-info" data-loading-text="확인 중...">중복확인</button>
                            <span id="msg_mb_email"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="reg_mb_point"><span class="glyphicon glyphicon-gift"></span> 포인트</label>
                        <div class="col-md-4">
                            <div id="reg_mb_point" style = "margin-top:7px;">
                            </div>
                        </div>
                    </div>

                    <p class="text-center">
                        <button type="submit" class="btn btn-lg btn-success">수정</button>
                        <button type="submit" class="btn btn-lg btn-default" data-dismiss="modal">닫기</button>
                    </p>
                </form>
            </div>

            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

