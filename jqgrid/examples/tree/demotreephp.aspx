<%@ Page Language="C#" AutoEventWireup="true" CodeBehind="demophp.aspx.cs" Inherits="GridTest.demophp" %>
<%@ Register src="loginstrip.ascx" tagname="loginstrip" tagprefix="site" %>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Demos -- Trirand jqGrid for ASP.NET</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="jquery,user interface,ui,widgets,interaction,javascript, asp.net, asp.net mvc, jqgrid, grid, table, interface, component, themeroller" />
	    <meta name="description" content="jqGrid for ASP.NET is a server side component for ASP.NET based on industry standards - jQuery, jQuery UI, ThemeRoller" />
	    <meta name="author" content="Tony Tomov, Rumen Stankov" />
	    <link rel="Shortcut Icon" type="image/ico" href="i/favicon.ico" />	    
		<link rel="stylesheet" type="text/css" href="css/main.css" media="screen"/>        
		<link rel="stylesheet" type="text/css" href="themes/redmond/jquery-ui-custom.css" media="screen" />
        <script src="js/jquery-1.4.2.min.js" type="text/javascript"></script>        
        <script src="js/jquery-ui-1.8.2.custom.min.js" type="text/javascript"></script>
            
        <script type="text/javascript">            
            jQuery(document).ready(function() {
                $("#accordion").accordion();
                $("#demoFrame").attr("src", "http://www.trirand.com/blog/phpjqgrid/examples/tree/nested_model/default.php");
            });
        </script>
	</head>
	<body>
	    <form id="form1" runat="server">                                      
		<div id="Wrapper">
			<div id="Header">
			    <site:loginstrip ID="loginstrip1" runat="server" />
				<div id="Logo">
					<a href=""><img src="i/logo.gif" alt="jqGrid" /></a>
				</div><div id="Menu">
					<ul>
						<li class="first">
							<a href="default.aspx">jqGrid</a>
						</li><li>
							<strong>Demo</strong>
						</li>
						<li>
							<a href="documentation.aspx">Documentation</a>
						</li>
						<li>
							<a href="download.aspx">Download</a>
						</li><li>
							<a href="licensing.aspx">Licensing/Pricing</a>
						</li><li>
							<a href="support.aspx">Support</a>
						</li><li class="last">
							<a href="about.aspx">About</a>
						</li>
					</ul>
				</div>
			</div><div id="Body">
				<div id="Content">									
			            <!-- Demo Content Here -->				            
			            <p>
			                <table cellspacing="10" cellpadding="10">
			                    <tr>
			                        <td width="250px" valign="top">
                                        <div id="accordion" style="font-size: 75%; height: 600px; width: 240px;">
                                            <h3><a href="#">Tree Models</a></h3>
	                                        <div>		                                        
                                                <ul class="examples">
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/nested_model/default.php" target="demoFrame">Nested set model</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/adj_model/default.php" target="demoFrame">Adjacency model<sup><font style="color:red">New</font></sup></a>
                                                    </li>
                                                </ul>		                                        
	                                        </div>
	                                        <h3><a href="#">Loading</a></h3>
	                                        <div>		                                 
	                                            <ul class="examples">
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/autoloadnodes/default.php" target="demoFrame">Auto loading nodes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/loadallcollapsed/default.php" target="demoFrame">Load all nodes collapsed</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/loadallexpanded/default.php" target="demoFrame">Load all nodes expanded</a>
                                                    </li>
                                                </ul>      
	                                        </div>
	                                        <h3><a href="#">Look and Feel</a></h3>
	                                        <div>
	                                            <ul class="examples">
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/expandcolclick/default.php" target="demoFrame">Expand a node by click the name</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/fixedheight/default.php" target="demoFrame">Fixed height</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/iconchange/default.php" target="demoFrame">Icon can be changed</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/icondb/default.php" target="demoFrame">Use icon from database field</a>
                                                    </li>
                                                </ul>                                                                                           
	                                        </div>
	                                        <h3><a href="#">Functionalities</a></h3>
	                                        <div>
	                                             <ul class="examples">
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/keyboardnav/default.php" target="demoFrame">Navigation with keyboard</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/onselectevent/default.php" target="demoFrame">Action on selecting node</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/simpletree/default.php" target="demoFrame">Simulate simple tree</a>
                                                    </li>
	                                            </ul> 
	                                        </div>
	                                        <h3><a href="#">Add/Update/Delete</a></h3>
	                                        <div>
	                                            <ul class="examples">
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/addnodes/default.php" target="demoFrame">Ading Node</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/delnodes/default.php" target="demoFrame">Delete nodes</a>
                                                    </li>
                                                    <li>
                                                        <a href="http://www.trirand.com/blog/phpjqgrid/examples/tree/addeditdelete/default.php" target="demoFrame">Add, edit, delete nodes</a>
                                                    </li>
	                                            </ul>                                       
	                                        </div>

                                        </div> 
			                        </td>
			                        <td width="700px" valign="top">
			                            <iframe id="demoFrame" 
			                                    name="demoFrame" 
			                                    style="width: 700px; height:600px; border-width:0; border-style:none; border-color:black;">
			                            </iframe>			                            
			                        </td>
			                    </tr>
			                </table>                            
                        </p>
				</div>
			</div><div id="Footer">
				<p>
					&copy; 2007-2009 <a href="">Trirand Inc., &trade;</a>
				</p>
			</div>
		</div>
		
		<!-- Google Analytics Section -->
		<script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
        </script>
        <script type="text/javascript">
            try {
                var pageTracker = _gat._getTracker("UA-5463047-2");
                pageTracker._trackPageview();
            } catch (err) { }
        </script>
    </form>		
	</body>
</html>
