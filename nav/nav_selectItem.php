<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="">
$(function(){
    $("#tableList").click(function(){
        $("#but_edit").prop("disabled",false)
    });
    $('#but_refresh').click(function(){
            $('#tableList').trigger("reloadGrid");
            $("#but_edit").prop("disabled",true);
    });
    $('#but_close').click(function(){
        window.close();
    });
});
</script>

</head>

<body>
    <div  align="right">
        <button type="button" class="but_add" id="but_add">
            <img src="../img/icon/but_add.png"/>
        </button>
        <button type="button" class="but_edit" id="but_edit" disabled="true">
            <img src="../img/icon/but_edit.png"/>
        </button>
        <button type="button" class="but_refresh" id="but_refresh">
            <img src="../img/icon/but_refresh.png"/>
        </button>
        <button type="button" class="but_close" id="but_close">
            <img src="../img/icon/but_close.png"/>
        </button>
    </div>
    <?php
         /*<select id="drop">
        <option value="none">NONE</option>
        <option value="select">SELECT</option>
    </select>*/
     ?>
    
</body>
</html>