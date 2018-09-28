<html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.8.3/jquery.csv.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jexcel/1.5.7/js/jquery.jexcel.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jexcel/1.5.7/css/jquery.jexcel.min.css" type="text/css" />

<div id="my"></div>

<br>
<a target="_blank" href="https://github.com/jiho8912/jiho8912.github.io">
    <button type="button" class="btn btn-primary btn-lg" id="download">엑셀 다운로드</button>
</a>

<script>
    $('#my').jexcel({
        // Full CSV URL
        //csv:'https://bossanova.uk/components/bossanova-ui/demo/demo2.csv',
        csv:'/upload/excel/demo1.csv',
        // Use the first row of your CSV as the headers
        csvHeaders:true,
        // Headers
        colWidths: [70, 200, 300],
    });

    $('#download').on('click', function () {
        $('#my').jexcel('download');
    });
    $(function() {

        $("#download_jsExcelTarget").click(function(){
            return div2xls("jsExcelTarget", "EXCEL_검색통계.xls");
        }) ;

    });

    function div2xls(divId, xlsFileName)
    {
        tempDiv = document.createElement('div');
        $(tempDiv).attr('id', "tempDiv").html($("#"+divId).html());
        document.body.appendChild(tempDiv);

        $('div[id$=tempDiv]').find("table").css('border', "1px solid #000000");
        $('div[id$=tempDiv]').find("th").css('border', "1px solid #000000");
        $('div[id$=tempDiv]').find("th").css('background-color', "#c8e0fb");
        $('div[id$=tempDiv]').find("td").css('border', "1px solid #000000");

        var tT = new XMLSerializer().serializeToString(tempDiv); //Serialised table
        var tB = new Blob([tT]); //Blub
        if(window.navigator.msSaveOrOpenBlob){
            //Store Blob in IE
            window.navigator.msSaveOrOpenBlob(tB, xlsFileName)
        }
        else{
            //Store Blob in others
            var tA = document.body.appendChild(document.createElement('a'));
            tA.href = URL.createObjectURL(tB);
            tA.download = xlsFileName;
            tA.style.display = 'none';
            tA.click();
            tA.parentNode.removeChild(tA)
        }
        document.body.removeChild(tempDiv);
        return false;
    }


</script>