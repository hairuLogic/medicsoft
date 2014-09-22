<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" type="text/css" href="../style.css">
<script src="../script/jquery-1.8.3.js"></script>
</head>

<body>
<table align="center" width="85%">
<tr>
            <td width="100%" id="menu">
                 <?php
                    include('../nav/nav_form.php');
                ?>
            </td>
        </tr>
  <tr>
    <td>
        <div class="alongdiv">
            <div class="smalltitle"><p>Menu Information</p></div>
            <div class="bodydiv">
            <form>
                <table align="center">
                      <tr>
                        <td><label for="lineno">Line No</label></td>
                        <td><input type="text" name="lineno" id="lineno"></td>
                        <td><label for="programname">Description</label></td>
                        <td colspan="3"><input name="programname" type="text" id="programname" size="60"></td>
                  </tr>
                      <tr>
                        <td><label for="programtype">Program Type</label></td>
                        <td><select name="programtype" id="programtype"><option value="p">P</option><option value="m">M</option>
                        </select></td>
                        <td><label for="programid">Program Id</label></td>
                        <td><input type="text" name="programid" id="programid"></td>
                        <td><label for="bmpid">Bmpid</label>
                        </td>
                        <td><input type="text" name="bmpid" id="bmpid"></td>
                  </tr>
                      <tr>
                        <td><label for="condition1">Condition1</label></td>
                        <td><input type="text" name="condition1" id="condition1"></td>
                        <td><label for="condition2">Condition 2</label></td>
                        <td><input type="text" name="condition2" id="condition2"></td>
                        <td><label for="condition3">Condition3</label>
                        </td>
                        <td><input type="text" name="condition3" id="condition3"></td>
                  </tr>
                      <tr>
                        <td><label for="remarks">Remarks</label></td>
                        <td ><input type="text" name="remarks" id="remarks"></td>
                        <td><label for="url">URL</label></td>
                        <td colspan="3"><input name="url" type="text" id="url" size="60">                        </td>
                  </tr>
                </table>
                </form>
            <div>
            </div>
        </div>
    </td>
  </tr>
</table>
</body>
</html>