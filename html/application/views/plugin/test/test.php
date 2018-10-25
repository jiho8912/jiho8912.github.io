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