<?php
	include_once('../ip-header.php');
?>
<span id="pagetitle">Patient Registration</span>
	
<div id="formmenu">
            <div id="menu">
           		<button type="button" onClick="window.close();" id="extbut"></button>
                <button type="button" id="canbut" ></button>
                <button type="button" id="updbut" ></button>
                <button type="button" id="addbut" ></button>
                <button type="button" id="daypbut" ></button>
                <button type="button" id="inpbut" ></button>
                <button type="button" id="outpbut" ></button>
                <button type="button" id="mykbut">mykad</button>
                <button type="button" id="savbut" ></button>
            </div>
            <input id="determine" value="<?php echo $_GET['det']; ?>" type="hidden"/>
            <form id="cr8user" method="post" name="cr8user" action="cr8user.php">
                <div class="alongdiv" id="alongdivatas">
                    <div class="smalltitle"><p>Patient Information</p></div>
                    <div class="bodydiv">
                        <div id="animate"><div class="wrapper2">
                        	<div class="block" style="width:15%"><label style="width:30%">MRN</label>
                            	<input type="hidden" id="mrn" name="mrn" value="<?php echo $_GET['mrn']; ?>">
                        	  	<input type="field" perdis id="mrnlabel" style="width:60%" value="<?php echo $_GET['mrn']; ?>">
                        	</div>
                        	<div class="block" style="width:25%"><label for="title" style="width:10%">Title</label>
                                <input style="width:20%;" type="field" name="title" id="title" ck/><input style="width: 35%;margin-left:1%	" type="text" perdis>
                                <input style="width:20%;" type="button" value="..." class="dialogbutton" table="title" title="Title Selection"/></div>
                            <div class="block" style="width:54%"><label for="name" style="width:7%">Name</label>
                                <input style="width:86%;" name="name" type="text" id="name" value='' req /></div>
                        </div>
                    		
                      	<div class="wrapper2" style="width:48%; margin:1%; clear:none; float:left" >
                        	<div class="block" style="width:38%"><label style="width:15%">I/C</label><input style="width:85%" name="newic" type="text" id="newic"  value='' req2/></div>
                            <div class="block" style="width:58%"><label style="width:30%">Other No.</label><input style="width:85%" name="othno" type="text" id="othno"  value='' req2></div>
                        </div>
                        
                        <div class="wrapper2" style="background:#CCCCCC; margin:1% 1% 1% 0%; width:48%; border-radius: 5px; clear:none; float:left">
                        	<div class="block" style="width:47%"><label>DOB</label><input style="width:88%" type="field" name="dob" id="dob" readonly req/></div>
                            <div class="block" style="width:15%"><label>Year</label><input style="width:90%" type="field" id="year" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Month</label><input style="width:90%" type="field" id="month" size="4" perdis/></div>
                            <div class="block" style="width:15%"><label>Day</label><input style="width:90%" type="field" id="day" size="4" perdis/></div>
                        </div>
                        <div class="wrapper2">
                        	<input type="button" value="verify" id="verify" class="orgbut" style="float:right;margin-right:5px;margin-bottom:5px"/>
                        	<input type="button" value="Read MyCard" class="orgbut" onClick="try2()" id="read" style="float:right;margin-right:5px;margin-bottom:5px">
                        </div></div>
                        <img name="" src="../image/mykad1.png" width="100" height="150" alt="" id="imgmk">
                    </div>
                </div>
                

                <div class="sideleft">
                    <div class="smalltitle"><p>Address</p></div>
                    <div class="bodydiv">
                        <div id="tabs">
                            <ul>
                            <li><a href="#curaddr">Current</a></li>
                            <li><a href="#offaddr">Office</a></li>
                            <li><a href="#peraddr">Permenant</a></li>
                            </ul>
                            <div id="curaddr">
                                <input type="text" name="curaddr1" id="curaddr1"  req/>
                                <input type="text" name="curaddr2" id="curaddr2"  class=""/>
                                <input type="text" name="curaddr3" id="curaddr3"  class=""/>
                                <br/><br/>Postcode: <input type="text" name="postcode" id="postcode" req/>
                            </div>
                            <div id="offaddr">
                                <input type="text" name="offaddr1" id="offaddr1" />
                                <input type="text" name="offaddr2" id="offaddr2" />
                                <input type="text" name="offaddr3" id="offaddr3" />
                                <br/><br/>Postcode: <input type="text" name="postcode2" id="postcode2"/>
                            </div>
                            <div id="peraddr">
                                <input type="text" name="peraddr1" id="peraddr1" />
                                <input type="text" name="peraddr2" id="peraddr2" />
                                <input type="text" name="peraddr3" id="peraddr3" />
                                <br/><br/>Postcode: <input type="text" name="postcode3" id="postcode3"/>
                            </div>
                         </div>
                         <div class="block" style="width:98%">
                            <label>Area:</label><input style="width:10%;" type="field" name="area" id="area" req ck/>
                            <input type="text" perdis style="width:50%;">
                            <input type="button" value="..." class="dialogbutton" table="areacode" title="Area Selection" style="width:5%;"/>
                        </div>
                  </div>
                </div>
                
                <div class="sideright" id="dgbdy">
                	<div class="smalltitle"><p>Other Information</p></div>
                    <div class="bodydiv">
                        <div class="wrapper2">
                        	<div class="block" style="width:48%">
                            	<label>Citizen:</label><input type="field" name="citizen" id="citizen" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="citizen" title="Citizen Selection"/>
                            </div>
                            <div class="block" style="width:48%">
                            	 <label>Race:</label><input type="field" name="race" id="race" req ck/>
                                 <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="racecode" title="Race Selection"/>
                            </div>
                        	<div class="block" style="width:48%">
                            	<label>Religion:</label><input type="field" id="religion" name="religion" req ck/>
                                <input type="text" perdis><input type="button" value="..." table="religion" class="dialogbutton" title="Religion Selection"/>
                            </div>
                            <div class="block" style="width:48%">
                            	<label>Blood Group:</label><input type="field" name="bloodgroup" id="bloodgroup" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="bloodgroup" title="Blood Group Selection">
                            </div>
                            <div class="block" style="width:48%">
                            	<label>Language:</label><input type="field" name="language" id="language" req ck/>
                                <input type="text" perdis><input type="button" value="..." class="dialogbutton" table="languagecode" title="Language Selection"/>
                            </div>
                        </div>
                        
                        <div class="wrapper2">
                        	<div class="block" style="width:48%">Sex:<select name="sex" id="sex"><option>F</option><option>M</option></select></div>
                            <div class="block" style="width:48%">Marital:<select name="marital" id="marital"><option>M</option><option>S</option></select></div>
                        </div>
               		</div>         
                </div>
                
                <div class="sideright">
                	<div class="smalltitle"><p>Phone Number</p></div>
                    <div class="bodydiv">
                    	<div class="block" style="width:31%"><label>House</label><input style="width:92%" type="text" name="house" id="house"/></div>
                        <div class="block" style="width:31%"><label>H/P</label><input style="width:92%" type="text" name="hp" id="hp"/></div>
                        <div class="block" style="width:31%"><label>Office</label><input style="width:92%" type="text" name="telo" id="telo"/></div>
                    </div>
                </div>
                
                <div class="alongdiv">
                    <div class="smalltitle"><p>Payer Information</p></div>
                    <div class="bodydiv">
                    	<div id="wrapper2" style="width:59%;clear:none;float:left">
                        	<div class="block" style="width:100%">
                                <label>Occupation</label><input style="width:10%;" type="field" name="occupation" id="occupation" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="occupation" title="Occupation Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%">
                                <label>Company</label><input style="width:10%;" type="field" name="company" id="company" ck/>
                                <input type="text" perdis style="width:60%;">
                                <input type="button" value="..." class="dialogbutton" table="debtormast" title="Company Selection" style="width:5%;"/>
                            </div>
                            <div class="block" style="width:100%"><label>E-mail</label><input type="text" name="email" id="email" style="width:71%"/></div>
                        </div>
                        
                        <div id="wrapper2" style="width:39%;clear:none;float:left">
                        	<div class="block" style="width:100%">
                            	<label>Relationship Code</label><input style="width:10%" type="field" id="relcode" name="relcode" ck/>
                                <input type="text" perdis style="width:50%;">
                               	<input type="button" value="..." class="dialogbutton" table="relatcode" title="Relationship Code Selection" style="width:5%;"/>
                           	</div>
                            <div class="block" style="width:100%"><label>Staff ID</label><input style="width:61%" type="text" id="staffid" name="staffid"/></div>
                            <div class="block" style="width:100%"><label>Child No</label><input style="width:61%" type="text" id="chno" name="chno"/></div>
                        </div>
                        	
                            
                    </div>
                </div>
                
                <div class="alongdiv">
                	<div class="smalltitle"><p>Patient Record</p></div>
                    <div class="bodydiv">
                    	<table>
                        	<tr>
                            <td>Active<select name="active" id="active" perdis><option>Yes</option><option>No</option></select></td>
                            <td>Confidential<select name="confidential" id="confidential" perdis><option>Yes</option><option>No</option></select></td>
                            <td>Medical record<select name="MRecord" id="MRecord" perdis><option>Yes</option><option>No</option></select></td>
                            <td>New MRN<input type="field" size='4' name="newmrn" id="newmrn" perdis/></td>
                            <td>Old MRN<input type="field" size='4' name="oldmrn" id="oldmrn" perdis/></td>
                            <td>Financial Status<input type="field" size='4' name="fstatus" id="fstatus" perdis/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        	</div>

<?php
	include_once('../ip-footer.php');
?>