<?php
	include_once('config.php');
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Untitled Document</title>
        <script src="../script/jquery-1.8.3.js"></script>
        <link href="style_main.css" rel="stylesheet" type="text/css"></head>
    <link rel="stylesheet" href="style.css">

    <body>
        <div id="barHolder" class="slim">
            <div id="bar" class="fixed">
                <div id="pageHeader" class="clearfix" role="banner">
                    <h1 id="compLogo">
                        <a>Medicsoft</a>
                    </h1>
                    
                </div>   
            </div>
        </div>
        <div id="page-outer">
            <div id="page-container" class="wrapper wrapper-home white">
                <div role="main" class="login-main" id="timeline">
                    <!--<div class="content-header">
                    <div class="header-inner">
                    <h2 id="content-main-heading" class="title">Timeline</h2>
                    </div>
                    </div>-->
                    <div class="login-container" >
                        <div class="login">
							<div class="login-form">
                            	 <form method="post" name="login" action="prslogin.php">
                                    <table>
                                    <tr><td><label>LoginID</label></td><td><input type="text" id="username" name="username"/></td></tr>
                                    <tr><td><label>Password</label></td><td><input type="password" id="password" name="password"/></td></tr>
                                    </table>
                                    <select name="comp">
                                        <?php
                                            $sql='select * from company';
                                            $res=mysql_query($sql);
                                            while($obj=mysql_fetch_object($res)){
                                                echo "<option value={$obj->compcode}>{$obj->name}</option>";
                                            }
                                        ?>
                                    </select>
                                    <input type="submit" value="LOGIN" id="button"/>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="footer">
                        <h3>
                        	© 2013 Medicsoft Sdn. Bhd.
                        </h3>
                    </div>
                </div>
            </div>

        </div>
    </body>
</html>