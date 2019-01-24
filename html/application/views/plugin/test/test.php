<script>

    function test() {
        $.ajax({
            url : "/plugin/ajaxTest/multiTest",
            dataType : 'json',
            type : "post",
            async : true,
            success : function (data) {
                console.log(data);
            }
        });
    }
</script>
<?php
    for($i=0; $i<=5; $i++){?>
        <script>
            test();
        </script>
    <?}?>

