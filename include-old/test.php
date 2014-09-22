<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>

<script>
function enableBeforeUnload() {
    window.onbeforeunload = function (e) {
        return "Discard changes?";
    };
}
function disableBeforeUnload() {
    window.onbeforeunload = null;
}
</script>
</head>

<body>
<form method="POST" action="" onsubmit="disableBeforeUnload();">
    <textarea name="text"
              onchange="enableBeforeUnload();"
              onkeyup="enableBeforeUnload();">
    </textarea>
    <button type="submit">Save</button>
</form>
</body>
</html>