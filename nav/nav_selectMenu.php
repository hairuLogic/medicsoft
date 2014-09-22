<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script type="">
$(function(){
    $('#but_close').click(function(){
        window.close();
    });

});
</script>

</head>

<body>
    <div  align="right">
        <button type="button" class="but_add" id="but_add" disabled="true">
            <img src="../img/icon/but_add.png"/>
        </button>
        <button type="button" class="but_edit" id="but_edit" disabled="true">
            <img src="../img/icon/but_edit.png"/>
        </button>
        <button type="button" class="but_delete" id="but_delete" disabled="true">
            <img src="../img/icon/but_delete.png"/>
        </button>
        <button type="button" class="but_save" id="but_save" disabled="true">
            <img src="../img/icon/but_save.png"/>
        </button>
        <button type="button" class="but_refresh" id="but_refresh" disabled="true">
            <img src="../img/icon/but_refresh.png"/>
        </button>
        <button type="button" class="but_cancel" id="but_cancel" disabled="true">
            <img src="../img/icon/but_cancel.png"/>
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