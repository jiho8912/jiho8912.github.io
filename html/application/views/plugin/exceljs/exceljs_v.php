<html>
<script src="/js/jquery.csv.min.js"></script>
<script src="/js/jquery.jexcel.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jexcel/1.5.7/css/jquery.jexcel.min.css" type="text/css" />

<div id="excel"></div>

<br><button type="button" class="btn btn-primary btn-lg" id="download">엑셀 다운로드</button>
123
<script>
    $(function() {
        $('#excel').jexcel({
            // Full CSV URL
            //csv:'https://bossanova.uk/components/bossanova-ui/demo/demo2.csv',
            csv:'/upload/excel/demo1.csv',
            // Use the first row of your CSV as the headers
            csvHeaders:true,
            // Headers
            colWidths: [70, 200, 300],
            csvFileName:'test',
        });

        $('#download').on('click', function () {
            $('#excel').jexcel('download');
        });
    });
</script>