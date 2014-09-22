<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script>
    $(function() {
        $( "#accordion" ).accordion();
        $( "#accordion1" ).accordion();
    });
</script>
<style type="">.ui-accordion .ui-accordion-header {
    display: block;
    cursor: pointer;
    position: relative;
    margin-top: 2px;
    padding: .5em .5em .5em .7em;
    min-height: 0; /* support: IE7 */
}
.ui-accordion .ui-accordion-icons {
    padding-left: 2.2em;
}
.ui-accordion .ui-accordion-noicons {
    padding-left: .7em;
}
.ui-accordion .ui-accordion-icons .ui-accordion-icons {
    padding-left: 2.2em;
}
.ui-accordion .ui-accordion-header .ui-accordion-header-icon {
    position: absolute;
    left: .5em;
    top: 50%;
    margin-top: -8px;
}
.ui-accordion .ui-accordion-content {
    padding: 1em 2.2em;
    border-top: 0;
    overflow: auto;
}</style>
</head>

<body>
<div id="accordion" width="100px">
  <h3>Section 1</h3>
  <div id="accordion1">
    <h3>Section 1</h3>
  <div>
    
  </div>
  <h3>Section 2</h3>
  <div>
   
  </div>
  <h3>Section 3</h3>
  <div>
    
  </div>
  <h3>Section 4</h3>
  <div>
   
  </div>
  </div>
  <h3>Section 2</h3>
  <div>
   
  </div>
  <h3>Section 3</h3>
  <div>
    
  </div>
  <h3>Section 4</h3>
  <div>
   
  </div>
</div>
</body>
</html>
