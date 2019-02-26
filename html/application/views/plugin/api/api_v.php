<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>API Documentation</title>

	<!-- Style -->
	<link href='http://fonts.googleapis.com/earlyaccess/nanumgothic.css' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro' rel='stylesheet' type='text/css'>
	<style>
		@charset "utf-8";*{margin:0}body{min-width:960px;background-color:#fdfdfd !important}::-webkit-scrollbar{display:none}p.ico-circle-none{border-radius:3px;border:1px #fdcf42 solid}p.ico-circle{border-radius:3px;background-color:#fdcf42}p.ico-close{width:12px;height:12px;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAW9JREFUSA21ljFvgzAQhWMEEluHrJ2yFqkL7dohan90qw5dGwYqsaZT1w7dkECi9wyHTOOzj1S5Idjnu+/58AHZbCar6/qmqqornp97BQMszk8waJrmNsuytzzPn/8jglwwwAITbAM1OGi8hWMYhve2bZ/KsvzBXGsMN8bcTznfXdc9JH3ffxH0yCAErK3EA8dGj2AbgIUAVSWxXCtwrkgMDu4ssFZEAz8RCIgc6OAf+eAn+Aud1x1yYFJzLCoYQ8UzsSKIoSZQwRHrFcCCsMuDTVLsHHEwUQCLPhH42ei2LG4d+91rUACBkogGjnz7qsDgUhasQNo9b0ZThSjggwMI+J/2DJ6DV0CC41mAgKdNRZETgRA88qB5RRYCGjgqgGljZwFtwogffzU5VkAT6ILdcSzXxAJcmDQOMZI0Ta+p7XacrOltjuUrDh8dxm0MP5iWjQk+0OR4pYBP97WMtTXmVLIj1r4oio85/1J/W34BVf6z7vH0Q60AAAAASUVORK5CYII=);background-size:12px 12px}body.console-active .sidebar-menu-area{padding-bottom:350px}.sidebar-container{position:fixed;width:310px;height:100%;background-color:#2a2e3e;}.sidebar-container .sidebar-brand-area img{width:310px;height:100px}.sidebar-container .sidebar-menu-area{height:100%;padding-bottom:100px}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap{height:100%}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul{display:block;list-style:none;padding:0}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li{margin:10px 0;min-height:32px;padding:6px 20px;display:block}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li>.block{float:left;margin-left:-20px;margin-top:-6px;width:4px;height:32px}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li label>a{color:#fff;font-family:'Nanum Gothic',san-serif;font-weight:700;font-size:16px;margin:0;text-decoration:none}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li ol{display:none}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li label>a:hover,.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li ol>li>a:hover{cursor:pointer}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li:first-child{margin-top:27px}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li.highlight>.block{background-color:#fdcf42}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li.highlight label{color:#fdcf42}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li.highlight ol{display:block;list-style:none;margin:10px 0 0 16px;padding:0}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li.highlight ol li{padding:5px;height:32px}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li.highlight ol li a{font-family:'Nanum Gothic',san-serif;font-weight:400;color:#a3a5b1;text-decoration:none}.sidebar-container .sidebar-menu-area .sidebar-menu-wrap ul>li.highlight ol li.highlight a{color:#fff;text-decoration:none}body.console-active .main-container{padding-bottom:250px}.main-container{margin-left:310px}.main-container .main-header-area{padding:50px}.main-container .main-header-area h1{font-family:'Nanum Gothic',san-serif;font-weight:700;font-size:32px;padding-bottom:22px;border-bottom:1px #d5d5d5 solid;color:#1f2438}.main-container .main-header-area h2{margin:40px 3px 8px 3px;font-family:'Nanum Gothic',san-serif;font-weight:700;font-size:22px;color:#4e5367}.main-container .main-header-area blockquote{margin:0 3px 12px 3px;padding:8px 14px;border-left:4px #e2e2e2 solid;color:#a3a5b1}.main-container .main-header-area section.api-box{margin:12px 3px 0 3px;border:1px rgba(0,0,0,0.07) solid}.main-container .main-header-area section.api-box .method:before{font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:18px;text-align:center;color:#fff;content:attr(data-method)}.main-container .main-header-area section.api-box .method[data-method='GET']{background-color:#55c399}.main-container .main-header-area section.api-box .method[data-method='POST']{background-color:#5ba7ff}.main-container .main-header-area section.api-box .method[data-method='DELETE']{background-color:#fe636b}.main-container .main-header-area section.api-box .method[data-method='PUT']{background-color:#fdcf42}.main-container .main-header-area section.api-box .method{float:left;text-align:center;width:82px;height:30px;padding-top:1px}.main-container .main-header-area section.api-box .endpoint{height:30px;font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:14px;padding:4px 10px 0 92px;background-color:#ededed}.main-container .main-header-area section.api-box .endpoint>a{color:#333}.main-container .main-header-area section.api-box .endpoint>a,.main-container .main-header-area section.api-box .endpoint>a:hover{text-decoration:none}.main-container .main-header-area section.api-box .group{margin:12px 14px 16px 14px}.main-container .main-header-area section.api-box .group label{margin:0;padding-bottom:6px;font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:14px;color:#4e5367}.main-container .main-header-area section.api-box .group label+div{border-top:1px #e2e2e2 solid}.main-container .main-header-area section.api-box .group div.row{height:28px;margin:0}.main-container .main-header-area section.api-box .group div.row div{font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:14px;padding:0 8px;margin-top:3px;color:#4e5367}.main-container .main-header-area section.api-box .group div.row div p{float:left;width:6px;height:6px;margin:8px 6px 0 0}.main-container .main-header-area section.api-box .group div.row div input{font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:12px;display:block;margin-top:-1px;padding:auto 4px;width:100%;height:24px;border-radius:3px;border:1px rgba(0,0,0,0.07) solid}.main-container .main-header-area section.api-box .group div.row div textarea{font-family:'Source Code Pro';height:100px}.main-container .main-header-area section.api-box .group div.row div:first-child{padding-top:2px}.main-container .main-header-area section.api-box .tryit{margin-top:-20px}.main-container .main-header-area section.api-box .tryit>div{margin:10px;text-align:center}.main-container .main-header-area section.api-box .tryit>div button{font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:14px;width:140px;height:26px;border:0;border-radius:3px;background-color:#4e5367;color:#fff;transition:.35s all;-webkit-transition:.35s all}.main-container .main-header-area section.api-box .tryit>div button:hover{background-color:#2a2e3e}body.console-active .footer-container{display:block}.footer-container{position:fixed;display:none;bottom:0;width:100%;height:450px;background-color:#4e5367}.footer-container .footer-header-area{width:100%;height:24px;padding:3px 7px 0 7px;background-color:#696f86}.footer-container .footer-header-area label{font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:12px;color:#fff;width:50%;float:left;margin:0}.footer-container .footer-header-area p{float:right;margin:2px -2px;padding:0}.footer-container .footer-content-area .code-area{padding:0}.footer-container .footer-content-area .code-area pre{font-family:'Source Code Pro';font-weight:400;font-size:12px;margin:0;border:0;border-radius:0;background:transparent}.footer-container .footer-content-area .code-area .description{position:absolute;right:30px;bottom:20px;font-family:'Nanum Gothic',san-serif;font-weight:400;font-size:24px;color:#fff;opacity:.2}.footer-container .footer-content-area .request pre{padding:20px 20px 20px 32px}.footer-container .footer-content-area .response{border-left:1px rgba(255,255,255,0.2) dashed}.footer-container .footer-content-area .response pre{padding:20px 32px 20px 20px}pre.highlighter{color:#fff}pre.highlighter .cross-hatch{color:#fdcf42}pre.highlighter .url{color:#fff}pre.highlighter .spacial-charactor{color:#a3a5b1}pre.highlighter .parameter-key{color:#5ba7ff}pre.highlighter .parameter-value{color:#fff}pre.highlighter .header-key{color:#55c399}pre.highlighter .header-value{color:#fdcf42}pre.highlighter .brackets{color:#fff}pre.highlighter .string{color:#55c399}pre.highlighter .number{color:#fdcf42}pre.highlighter .xml-block{color:#5ba7ff}pre.highlighter .xml-tag-block{color:#55c399}pre.highlighter .xml-field{color:#fe636b}pre.highlighter .xml-content{color:#fff}pre.highlighter .query-key{color:#55c399}pre.highlighter .query-value{color:#fdcf42}
        #loadingDiv{
            position:fixed;
            top:0px;
            right:0px;
            width:100%;
            height:100%;
            background-color:white;
            background-image:url('<?= Img_dir ?>/loading.gif');
            background-repeat:no-repeat;
            background-position:center;
            z-index:10000000;
            opacity: 0.6;
            display: none;
        }
    </style>

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	<!-- Less -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/less.js/2.5.1/less.min.js"></script>
	<!-- Bootstrap -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<!-- underscope -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js"></script>
	<!-- jquery.slimscroll -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.6/jquery.slimscroll.min.js"></script>
	<!-- JS -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<script>
		var _error = false;
		var _error_msg = '';
		var menu_click_flag = false;
		const SCROLL_Y_CONTROL = 50;

        $(document).ajaxStart(function(){
            $("#loadingDiv").show();
        });
        $(document).ajaxStop(function(){
            $("#loadingDiv").hide();
        });

		$(document).ready(function(){
			$(window).scroll(function(){
				if (menu_click_flag)
					return false;

				var _window = $(this);
				var window_scroll_top = _window.scrollTop();

				if (window_scroll_top + _window.height() == $(document).height()) {
			    	$('li.highlight ol .highlight').removeClass('highlight')
			    	$('li.highlight ol li').last().addClass('highlight')
			    }
			    else {
			    	$('div.api-wrap').each(function(index, method_dom){
			    		var _method_dom = $(method_dom);
			    		var method_dom_top = _method_dom.offset().top;

			    		if (window_scroll_top <= method_dom_top + _method_dom.height() / 2){
			    			$('li.highlight ol .highlight').removeClass('highlight');
			    			$('li.highlight ol li').each(function(index, li_dom){
			    				if (_method_dom.find('h2.method-name').text() == $(li_dom).find('a').text()){
			    					$(li_dom).addClass('highlight')
			    					return false
			    				}
			    			});
			    			return false
			    		}
			    	})
			    }
			});

			$('ol li').click(function(event){
				event.preventDefault();
				menu_click_flag = true;

				var _this = $(this);
				$('html, body').stop(true).animate({
					scrollTop: $('.' + _this.text()).offset().top - SCROLL_Y_CONTROL
				}, 500, function() {
				    menu_click_flag = false
				});

				$('li.highlight ol .highlight').removeClass('highlight');
				_this.addClass('highlight');
			});

			$('li.collection label a').click(function(){
			    var controller_name = $(this).text();
                window.location.href = "?active_controller=" + controller_name;
			});

			$(document).on('click', 'button[type="submit"]', function(){
                _error = false;
                _error_msg = '';
                var api_parent = $(this).parents('section');
                var call_type = api_parent.find('.method').attr('data-method');

                var ajax_config = {};
                ajax_config.type = call_type;
                ajax_config.url = ajax_url_binding(api_parent, 'url');
                ajax_config.headers = ajax_header_binding(api_parent, 'header');
                ajax_config.parameter = ajax_data_binding(api_parent, 'parameter');
                ajax_config.service = $("#active_controller").text();

                if(_error){
                    swal({
                        text: _error_msg,
                        icon: "error"
                    });
                    return false;
                }

                var request_data_str = '# ' + call_type + ' ' + ajax_config['url'] + '\n';

                request_data_str += '\n########################## header ########################################\n\n';

                for (header_key in ajax_config.headers) {
                    request_data_str += '+ <span class=\'header-key\'>' + header_key + '</span>:<span class=\'header-value\'>' + ajax_config['headers'][header_key] + '</span>\n'
                }

                request_data_str += '\n########################## parameter ########################################\n';

                $.ajax({
                    url : '/plugin/api/call',
                    data : ajax_config,
                    type : 'post',
                    dataType : 'json',

                    success : function(data){
                        console.log(data);

                        var request_code_wrap = $('.request pre.code-wrap');
                        var response_code_wrap = $('.response pre.code-wrap');

                        request_data_str += '\n';

                        if(data.req) {
                            if (data.req.indexOf("xml") == -1) {
                                request_data_str += formatJson(data.req);
                            } else {
                                request_data_str += formatXml(data.req);
                            }
                        }

                        request_code_wrap.html(request_data_str);
                        response_code_wrap.html(data.res);

                        request_code_wrap.removeClass('highlighter');
                        response_code_wrap.removeClass('highlighter');
                        parse_code_block();
                        $('body').addClass('console-active')
                    }
                });

			});

			$('.footer-header-area').click(function(){
				$('body').removeClass('console-active')
			})

            function formatXml(xml) {
                var formatted = '';
                var reg = /(>)[\s]*(<)(\/*)/g;
                xml = xml.replace(reg, '$1\r\n$2$3');
                var pad = 0;
                jQuery.each(xml.split('\r\n'), function(index, node) {
                    var indent = 0;
                    if (node.match( /.+<\/\w[^>]*>$/ )) {
                        indent = 0;
                    } else if (node.match( /^<\/\w/ )) {
                        if (pad != 0) pad -= 1;
                    } else if (node.match( /^<\w[^>]*[^\/]>.*$/ )) {
                        indent = 1;
                    } else {
                        indent = 0;
                    }

                    var padding = '';
                    for (var i = 0; i < pad; i++) {
                        padding += '    ';
                    }

                    formatted += padding + node + '\r\n';
                    pad += indent;
                });

                return formatted;
            }

            function formatJson(data){
                // brackets
                data = JSON.stringify(JSON.parse(data), null, 4);
                var brackets = /({|}|\(|\)|\[|\])/gm;
                data = data.replace(brackets, "<span class='brackets'>$1</span>");

                // numbers | strings
                var m;
                var lastindex = 0;
                var newdata = "";
                var numberstrings = /(("[ \t\S]*")|('[ \t\S]*')|([\d]+)){0,1}(:)([\s]{1,})((("[ \t\S]*")|('[ \t\S]*')|([\d]+|null))){0,1}/gm;
                while ((m = numberstrings.exec(data)) !== null) {
                    if (m.index === numberstrings.lastIndex) {
                        numberstrings.lastIndex++;
                    }

                    newdata += data.substr(lastindex, m.index - lastindex);

                    if (m[4])
                        newdata += "<span class='number'>" + m[1] + m[5] + "</span>";
                    else
                        newdata += "<span class='string'>" + m[1] + m[5] + "</span>";

                    newdata += m[6];

                    if (m[7]) {
                        if (m[11])
                            newdata += "<span class='number'>" + m[8] + "</span>";
                        else
                            newdata += "<span class='number'>" + m[8] + "</span>";

                        lastindex = m.index + m[0].length;
                    } else {
                        lastindex = m.index + m[0].length;
                    }
                }
                data = newdata + data.substr(lastindex, data.length - lastindex)
                data = data.replace(/(,)/gm, "<span class='brackets'>$1</span>");
                return data;
            }

            function parse_code_block(){
                $("pre.code-wrap").each(function(){
                    if ($(this).hasClass("highlighter"))
                        return;
                    var data = $(this).html();

                    data = _.unescape(data).trim();

                    // header
                    var header = /^(\+)([\s]{1,})([\S]+:)[\s]{0,}([\S]+)$/gm;
                    data = data.replace(header, "<span class='spacial-charactor'>$1</span>$2<span class='header-key'>$3</span><span class='header-value'>$4</span>");

                    // Query Param
                    var newlength = 0;
                    var queryParam = /(((&){0,1}[\w]+=)([\w]+))/gm;
                    while ((m = queryParam.exec(data)) !== null) {
                        if (m.index === queryParam.lastIndex)
                            queryParam.lastIndex ++;
                        newlength += m[1].length;
                    }

                    if (data.length == newlength) {
                        $(".response .description").html("query response");

                        data = data.replace(queryParam, "<span class='query-key'>$2</span><span class='query-value'>$4</span>");

                        // JSON
                    } else if (data.indexOf("xml") == -1) {
                        try {
                            odata = data;
                            data = formatJson(data);

                            $(".response .description").html("json response");


                        } catch(e) {
                            data = odata;
                            $(".response .description").html("response");
                        }

                        // XML
                    } else {
                        data = formatXml(data);

                        $(".response .description").html("xml response");

                        var m;
                        var lastindex = 0;
                        var newdata = "";
                        var xml = /(<)([\/|?]{0,})([^>\s]+)(([\s]+[^>\s]+)*)(>)/gm;
                        while ((m = xml.exec(data)) !== null) {
                            if (m.index === xml.lastIndex) {
                                xml.lastIndex++;
                            }

                            newdata += "<span class='xml-content'>" + data.substr(lastindex, m.index - lastindex) + "</span>";

                            if (m[2] === '?') {
                                newdata += "<span class='xml-block'>" + _.escape(m[0]) + "</span>";
                            } else {
                                newdata += "<span class='xml-tag-block'>"
                                        + _.escape(m[1] + m[2] + m[3]) + "</span>"
                                        + m[4].replace(/([\w]+=)("+[\w\S]+")/g, "<span class='xml-field'>$1</span><span class='number'>$2</span>")
                                        + "<span class='xml-tag-block'>"
                                        + _.escape(m[6])
                                        + "</span>";
                            }

                            lastindex = m.index + m[0].length;
                        }
                        data = newdata + "<span class='xml-content'>" + data.substr(lastindex, data.length - lastindex) + "</span>";
                    }

                    $(this).addClass("highlighter");
                    $(this).html(data);
                });
            }

            function ajax_data_binding(api_parent, group_name){
                var data_str = {};

                $.each(api_parent.find('.' + group_name).children('div[sub_data]'), function(index, row1){
                    var row_div1 = $(row1).children('.row').children('div');
                    var row_key1 = row_div1.eq(0).text();
                    var row_value1 = row_div1.eq(1).children('input[type="text"]').val();
                    data_str[row_key1] = row_value1;

                    if((row_key1 == "givenName" || row_key1 == "surname" || row_key1 == "uniqueId")  && row_value1 == ""){
                        _error = true;
                        _error_msg = row_key1 + '는 필수값입니다.';
                    }

                    if($(row1).attr("sub_data") == 1){
                        data_str[row_key1] = {};

                        $.each($(row1).children('div[sub_data]'), function(index2, row2){
                            var row_div2 = $(row2).children('.row').children('div');
                            var row_key2 = row_div2.eq(0).text();
                            var row_value2 = row_div2.eq(1).children('input[type="text"]').val();
                            data_str[row_key1][row_key2] = row_value2;

                            if($(row2).attr("sub_data") == 1){
                                data_str[row_key1][row_key2] = {};

                                $.each($(row2).children('div[sub_data]'), function(index3, row3){
                                    var row_div3 = $(row3).children('.row').children('div');
                                    var row_key3 = row_div3.eq(0).text();
                                    var row_value3 = row_div3.eq(1).children('input[type="text"]').val();
                                    data_str[row_key1][row_key2][row_key3] = row_value3;

                                    if($(row3).attr("sub_data") == 1){
                                        data_str[row_key1][row_key2][row_key3] = {};

                                        $.each($(row3).children('div[sub_data]'), function(index4, row4){
                                            var row_div4 = $(row4).children('.row').children('div');
                                            var row_key4 = row_div4.eq(0).text();
                                            var row_value4 = row_div4.eq(1).children('input[type="text"]').val();
                                            data_str[row_key1][row_key2][row_key3][row_key4] = row_value4;
                                        });

                                    }
                                });

                            }
                        });

                    }
                });

                return data_str;
            }

            function ajax_header_binding(api_parent, group_name){
                var data_str = {};

                $.each(api_parent.find('.' + group_name).children('.row'), function(index, row){
                    var row_div = $(row).children('div');
                    data_str[row_div.eq(0).text()] = row_div.eq(1).children('input[type="text"]').val();
                });
                return data_str;
            }

            function ajax_url_binding(api_parent, group_name) {
                var data_str = {};

                data_str = api_parent.find('.endpoint').text().replace(/\s/g, '');

                $.each(api_parent.find('.urlparameter').children('.row'), function(index, row){
                    var row_div = $(row).children('div');
                    var key = row_div.eq(0).text();
                    var value = row_div.eq(1).children('input[type="text"]').attr("value");
                    if(typeof(value) != 'undefined' && value.length == 0){
                        _error = true;
                        _error_msg = key + '는 필수값입니다.';
                    }else{
                        data_str = data_str.replace('{' + key + '}', value);
                    }
                });

                return data_str;
            }
		});

	</script>
</head>
<body>
<div>
    <img id="loadingDiv">
</div>
	<aside class="sidebar-container">
		<div class="sidebar-brand-area">
			<img src="https://cdn.rawgit.com/myartame/codeigniter-apidocs/develop/assets/img/brand.png" alt="">
		</div>
		<div class="sidebar-menu-area">
			<div class="sidebar-menu-wrap">
				<ul>
					<?php $highlight_flag = true; ?>
					<?php foreach ($api_list as $controller_key => $api_value){?>
						<li class="collection <?php if ($controller_key == $active_controller) echo 'highlight' ?>">
							<div class="block"></div>
							<label><a><?= $controller_key ?></a></label>
							<ol>
								<?php foreach ($api_value as $method_index => $api_method_name): ?>

									<li class="<?php if (!$method_index) echo 'highlight'; ?>"><a><?= $method_index; ?></a></li>
								<?php endforeach;?>
							</ol>
						</li>
					<?}?>
				</ul>
			</div>
		</div>
	</aside>
	<div class="main-container">
		<div class="main-header-area">
			<h1 id="active_controller"><?= $active_controller ?></h1>
			<?php foreach ($api_detail as $api_item): ?>
				<div class="api-wrap <?= $api_item['method_name']; ?>">
					<h2 class="method-name"><?= $api_item['method_name']; ?></h2>
					<?php if ($api_item['description'] != '') { ?>
					<blockquote>
						<?= $api_item['description']; ?>
					</blockquote>
					<?php } ?>
					<section class="api-box">
						<div class="method" data-method="<?= $api_item['call_type'] ?>"></div>
						<div class="endpoint">
							<?php
                                $api_url = $base_url . explode('_',$api_item['method_name'])[0];
                                foreach($api_item['url_parameter'] as $key => $url_parameter_item){
                                    if($url_parameter_item){
                                        $key = '{' . $key . '}';
                                    }
                                    $api_url .= '/' . $key;
                                }
                            ?>
							<a href="<?= $api_url; ?>" target="_blank"><?= $api_url; ?></a>
						</div>
						<?php if ($api_item['method_name'] != 'index'){ ?>
							<?php if (count($api_item['url_parameter'])) { ?>
								<div class="urlparameter group">
									<label>URL Parameter</label>
									<?php foreach($api_item['url_parameter'] as $key => $url_parameter_item){?>
										<div class="row">
											<div class="col-lg-3"><p class="ico-circle-none"></p><?=$key ?></div>
											<div class="col-lg-9">
                                                <?if($url_parameter_item){?>
												    <input type="text" value=""/>
                                                <?}?>
											</div>
										</div>
									<?php }?>
								</div>
							<?php } ?>
							<?php if (count($api_item['parameter'])) { ?>
								<div class="parameter group">
									<label>Parameter</label>
									<?php foreach($api_item['parameter'] as $key => $parameterList1): ?>
                                    <div sub_data=<?if(sizeof($parameterList1) > 1){?>1<?}else{?>0<?}?>>
										<div class="row">
											<div class="col-lg-3"><p class="ico-circle"></p><?= $key ?></div>
											<div class="col-lg-9">
                                                <?if(sizeof($parameterList1) == 1){?>
												    <input type="text" value="<?=$parameterList1?>" />
                                                <?}?>
											</div>
										</div>

                                        <?php foreach ($parameterList1 as $key2 => $parameterList2){?>
                                        <div sub_data=<?if(sizeof($parameterList2) > 1){?>1<?}else{?>0<?}?>>
                                            <div class="row" style="margin-left:20px;"">
                                                <div class="col-lg-3"><p class="ico-circle"></p><?= $key2 ?></div>
                                                <div class="col-lg-9">
                                                    <?if(sizeof($parameterList2) == 1){?>
                                                        <input type="text" value="<?=$parameterList2?>"/>
                                                    <?}?>
                                                </div>
                                            </div>

                                            <?php foreach ($parameterList2 as $key3 => $parameterList3){?>
                                            <div sub_data=<?if(sizeof($parameterList3) > 1){?>1<?}else{?>0<?}?>>
                                                <div class="row" style="margin-left:40px;">
                                                    <div class="col-lg-3"><p class="ico-circle"></p><?= $key3 ?></div>
                                                    <div class="col-lg-9">
                                                        <?if(sizeof($parameterList3) == 1){?>
                                                            <input type="text" value="<?=$parameterList3?>"/>
                                                        <?}?>
                                                    </div>
                                                </div>

                                                <?php foreach ($parameterList3 as $key4 => $parameterList4){?>
                                                    <div sub_data=<?if(sizeof($parameterList4) > 1){?>1<?}else{?>0<?}?>>
                                                        <div class="row" style="margin-left:60px;">
                                                            <div class="col-lg-3"><p class="ico-circle"></p><?= $key4 ?></div>
                                                            <div class="col-lg-9">
                                                                <input type="text" value="<?=$parameterList4?>"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?}?>

                                            </div>
                                            <?}?>

                                        </div>
                                        <?}?>

                                    </div>
									<?php endforeach; ?>
								</div>
							<?php } ?>
							<?php if (count($api_item['header'])) { ?>
								<div class="header group">
									<label>Header</label>
									<?php foreach($api_item['header'] as $key => $header_item): ?>
										<div class="row">
											<div class="col-lg-3"><p class="ico-circle-none"></p><?= $key ?></div>
											<div class="col-lg-9">
												<input type="text" value="<?=$header_item?>" />
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php } ?>
						<?php } ?>
						<div class="tryit row">
							<div class="col-lg-12">
								<button type="submit">
									Try it
								</button>
							</div>
						</div>
					</section>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<footer class="footer-container">
		<div class="footer-header-area">
			<label>Request Console</label>
			<a href="#">
				<p class="ico-close"></p>
			</a>
		</div>
		<div class="footer-content-area row">
			<div class="code-area request col-md-6">
				<div class="description">api request</div>
				<pre class="code-wrap">
				</pre>
			</div>
			<div class="code-area response col-md-6">
				<div class="description">response</div>
				<pre class="code-wrap">
				</pre>
			</div>
		</div>
	</footer>

	<script type="text/javascript">
		$(function() {
			$('.sidebar-menu-wrap').slimScroll({
		        height: '100%'
		    });
		    $('.code-wrap').slimScroll({
		    	height: '440px'
		    });

		});
	</script>
</body>
</html>