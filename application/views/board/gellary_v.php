<legend>게시판</legend>
<div class="content">
	<div class="grid">
		<?if(sizeof($board_list)){?>
			<?foreach($board_list as $key => $list){?>
				<div class="grid__item" data-size="<?=$etc_option['thumb_w']?>x<?=$etc_option['thumb_h']?>">
					<a href="<?=@$list['file_name']?>" class="img-wrap"><img src="<?=@$list['file_name']?>" class="img-rounded img-responsive center-block" />
						<div class="description description--grid">
							<a href="/board/view_v/<?=$board_id?>/<?=$list['no']?>" style="color:white;">
								<h3>
									<?=$list['subject']?>
								</h3>
								<h5>
									<span class="glyphicon glyphicon-user"></span>
									<?=$list['mb_name']?><!-- 글쓴이 --->
								
									<span class="glyphicon glyphicon-time"></span>
									<?=substr($list['reg_date'],0,10)?><!-- 등록날짜 --->
								
									<span class="glyphicon glyphicon-comment"></span>
									<?=$this->board_m->comment_count($list['no'])?><!-- 댓글수 --->
									<span class="glyphicon glyphicon-bell"></span>
									<?=$list['hit']?><!-- 조회수 --->
								</h5>
							</a>
						</div>
					</a>
				</div>
			<?}?>
		<?}else{?>
			<span style ="color:black">등록된 글이 없습니다.</span>

		<?}?>
	</div>
	<!-- /grid -->
	<div class="preview">
		<button class="action action--close"><i class="fa fa-times"></i><span class="text-hidden">Close</span></button>
		<div class="description description--preview"></div>
	</div>
	<!-- /preview -->

	<div class="clearfix">
		<span class="btn-group mb50"></span>
		<div class="pull-right">
			<?if($this->session->userdata('mb_id')){?>
				<a href="/board/write_v/<?=$board_id?>">
					<button type="button" class="btn btn-primary btn-sm" id ="">글쓰기</button>
				</a>
			<?}?>
		</div>
	</div>

	<form name="searchForm" method="post" action="/board/list_v/<?=$board_id?>">
		<div class="clearfix">
			<select name="searchKey" id="searchKey" class="form-control input-sm auto pull-left">
				<option value="subject">제목</option>
				<option value="contents">내용</option>
				<option value="subject.contents">제목+내용</option>
				<option value="mb_name">글쓴이</option>
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
			</div>
		</div>
	</form>
</div>
<!-- /container -->
<script src="/static/imagegrid/js/imagesloaded.pkgd.min.js"></script>
<script src="/static/imagegrid/js/masonry.pkgd.min.js"></script>
<script src="/static/imagegrid/js/classie.js"></script>
<script src="/static/imagegrid/js/main.js"></script>
<script>
	(function() {
		var support = { transitions: Modernizr.csstransitions },
			// transition end event name
			transEndEventNames = { 'WebkitTransition': 'webkitTransitionEnd', 'MozTransition': 'transitionend', 'OTransition': 'oTransitionEnd', 'msTransition': 'MSTransitionEnd', 'transition': 'transitionend' },
			transEndEventName = transEndEventNames[ Modernizr.prefixed( 'transition' ) ],
			onEndTransition = function( el, callback ) {
				var onEndCallbackFn = function( ev ) {
					if( support.transitions ) {
						if( ev.target != this ) return;
						this.removeEventListener( transEndEventName, onEndCallbackFn );
					}
					if( callback && typeof callback === 'function' ) { callback.call(this); }
				};
				if( support.transitions ) {
					el.addEventListener( transEndEventName, onEndCallbackFn );
				}
				else {
					onEndCallbackFn();
				}
			};

		new GridFx(document.querySelector('.grid'), {
			imgPosition : {
				x : -0.5,
				y : 1
			},
			onOpenItem : function(instance, item) {
				instance.items.forEach(function(el) {
					if(item != el) {
						var delay = Math.floor(Math.random() * 50);
						el.style.WebkitTransition = 'opacity .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1), -webkit-transform .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1)';
						el.style.transition = 'opacity .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1), transform .5s ' + delay + 'ms cubic-bezier(.7,0,.3,1)';
						el.style.WebkitTransform = 'scale3d(0.1,0.1,1)';
						el.style.transform = 'scale3d(0.1,0.1,1)';
						el.style.opacity = 0;
					}
				});
			},
			onCloseItem : function(instance, item) {
				instance.items.forEach(function(el) {
					if(item != el) {
						el.style.WebkitTransition = 'opacity .4s, -webkit-transform .4s';
						el.style.transition = 'opacity .4s, transform .4s';
						el.style.WebkitTransform = 'scale3d(1,1,1)';
						el.style.transform = 'scale3d(1,1,1)';
						el.style.opacity = 1;

						onEndTransition(el, function() {
							el.style.transition = 'none';
							el.style.WebkitTransform = 'none';
						});
					}
				});
			}
		});
	})();
</script>