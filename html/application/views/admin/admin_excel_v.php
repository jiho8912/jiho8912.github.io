<div class="col-md-9">
	<h3>엑셀업로드</h3>

	<div style = "margin:20px 0 20px 0 ; text-align:left;">
		<form id="excel_upload_form" method="post" action="/admin/excel/excelup" enctype="multipart/form-data">
			<span class="btn btn-default btn-file">
				<input type="hidden">
				<input type="file" multiple="" name ="userfile" >
			</span>
			<button type="button" id = "upload" class="btn btn-sm btn-primary">등록</button>
		</form>
	</div>
		<button type="button" id="download" class="btn btn-sm btn-primary">엑셀다운로드</button>
</div>

<script>

$(function() {

	$("#upload").click(function() {
		$("#excel_upload_form").submit();
	});

	$("#download").click(function() {
		location.replace("/admin/excel/product_excel_download");
	});
});
</script>