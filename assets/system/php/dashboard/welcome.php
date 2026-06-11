<?php 
  ini_set('display_errors', 1);
  //ini_set('session.gc_maxlifetime',60);
  error_reporting(~0);
  @session_start();
  
  include( "../../../../assets/system/php/dashboard/header.php" );
 
	$privillege = $_COOKIE['privillegeId'];
	if($privillege==''){
	    @session_start();
	}
//	echo $_SESSION['time'];

    switch($privillege) {
		
		case '1'  :  
		    //include( "../../../../assets/system/php/dashboard/sideMenu.php" );
		    include("../../../../assets/system/php/dashboard/adminSideMenu.php" );
		    break;
		   
		case '2'  :  
				include("../../../../assets/system/php/dashboard/storeSideMenu.php" );
		   		break;
		   
		case '3'  :  
				include("../../../../assets/system/php/dashboard/operationSideMenu.php" );
		  		break;
		   
		case '4'  :  
				include("../../../../assets/system/php/dashboard/casherSideMenu.php" );
		  		break;
					
		case '5'  :  
		        include("../../../../assets/system/php/dashboard/purchaseSideMenu.php" );
		  		break;
		case '6'  :  
		        include("../../../../assets/system/php/dashboard/counterSideMenu.php" );
		  		break;
		
		case '10'  :  
		        include("../../../../assets/system/php/dashboard/branchSideMenu.php" );
		  		break;
		case '11'  :  
		        include("../../../../assets/system/php/dashboard/adminSideMenu.php" );
		  		break;
		case '12'  :  
		        include("../../../../assets/system/php/dashboard/accountsSideMenu.php" );
		  		break;
		case '13'  :  
		        include("../../../../assets/system/php/dashboard/editUserSidemenu.php" );
		  		break;
	}

?>
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
    	<!--<section class="content-header">
      			<h1>
        			Dashboard
        			<small>Control panel</small>
      			</h1>
      			<!--<ol class="breadcrumb">
        			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        			<li class="active">Dashboard</li>
      			</ol>-->
                <!--<ol class="breadcrumb">
        			<li>
                    	<a href="#">
                        	<i class="fa fa-user"></i>
							<?php //echo $lang["USERNAME"];?>  : <?php //echo $userName; ?>
                       	</a>
                  	</li>
        			<li class="active">
                    	<?php //echo $disStoreOrBranch;?> : <?php //echo $branchName; ?>
                    </li>
      			</ol>
    		</section>-->

    		<!-- Main content -->
    		<section class="content" style="height: 100% !important; min-height: 500px;">
            	<script>
                	window.setTimeout(function() {
						$(".alert").fadeTo(500, 0).slideUp(500, function(){
							$(this).remove(); 
						});
					}, 4000);
                </script>
				<?php	   
               		if( isset($_GET['message']) )
                  		echo '<div class="alert alert-danger" id="success-alert">
    					<button type="button" class="close" data-dismiss="alert">x</button>
    					<strong>'. $_GET['message'].'</strong></div>';
                   
                       $choice = $_GET['page'];
                       switch($privillege) {
                        
                        case '1'  :  
                                    include( "switchAdmin.php" );
                                    break;
                                    
                        case '2'  :  
                                    include( "switchAdmin.php" );
                                    break;
                           
                        case '3'  :  
                                    include( "switchSalesArea.php" );
                                    break;
                           
                        case '4'  :  
                                    include( "switchAdmin.php" );
                                    break;
                        case '5'  :  
                                    include( "switchAdmin.php" );
                                    break;
                        case '6'  :  
                                    include( "switchAdmin.php" );
                                    break;
                        case '7'  :  
                                    include( "switchAdmin.php" );
                                    break;
                        case '10'  :  
                                    include( "switchAdmin.php" );
                                    break;
                        case '11'  :  
                                    include( "switchAdmin.php" );
                                    break;
                        case '12'  :  
                                    include( "switchAdmin.php" );
                                    break;
                        case '13'  :  
                                    include( "switchAdmin.php" );
                                    break;
                    }
                ?>
     		</section>
<?php    
  include( "../../../../assets/system/php/dashboard/footer.php" );
  ob_flush();
?>
 
