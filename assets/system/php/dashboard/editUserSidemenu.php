<?php //echo $_SESSION['loggedin_time'] = time(); ?>
		<!-- Left side column. contains the logo and sidebar -->
      	<aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              	
                <!-- Sidebar user panel -->
              	<div class="user-panel">
           			<div class="pull-left image">
                  		<img src="../../../../assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                	</div>
            		<div class="pull-left info">
              			<p><?php //echo $_SESSION['sesUsername']; ?></p>
              			<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            		</div>
          		</div>
          		
                <!-- search form -->
          		<!--<form action="#" method="get" class="sidebar-form">
            		<div class="input-group">
              			<input type="text" name="q" class="form-control" placeholder="Search...">
                     	<span class="input-group-btn">
                         	<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                       		</button>
                      	</span>
            		</div>
          		</form>-->
          		<!-- /.search form -->
          		<!-- sidebar menu: : style can be found in sidebar.less -->
              	<ul class="sidebar-menu">
                	<!--<li class="header">MAIN NAVIGATION</li>-->
                	<li class="active">
                      	<a href="welcome.php?page=home">
                        	<i class="fa fa-home"></i> <span>HOME</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=storeImportPurchaseEdit">
                        	<i class="fa fa-cart-plus"></i> <span>Store Import Purchase(Edit)</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=localPurchaseEdit">
                        	<i class="fa fa-cart-plus"></i> <span>Local Purchase(Edit)</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=stockTransferEdit">
                        	<i class="fa fa-cogs"></i> <span>Stock Transfer(Edit)</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=invoiceEdit">
                        	<i class="fa fa-cogs"></i> <span>Sales Invoice(Edit)</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=stockReturnEdit">
                        	<i class="fa fa-cogs"></i> <span>Stock Return(Edit)</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=salesReturnItemWiseEdit">
                        	<i class="fa fa-cogs"></i> <span>Sales Return(Edit)</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=customerSalesPaymentEdit">
                        	<i class="fa fa-cogs"></i> <span>Cash Receipt(Edit)</span>
                      	</a>
               		</li>
               		<li class="">
                      	<a href="welcome.php?page=openingStockEdit">
                        	<i class="fa fa-cogs"></i> <span>Opening Stock(Edit)</span>
                      	</a>
               		</li>
               		<li class="treeview">
                  		<a href="">
                    		<i class="fa fa-money"></i> <span>Accounts</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		
                            <li>
                            	<a href="welcome.php?page=jvEdit">
                                	<i class="fa fa-circle-o"></i> Journal Voucher(Edit)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashPaymentEdit">
                                	<i class="fa fa-circle-o"></i> Cash Payment(Edit)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashReceiptEdit">
                                	<i class="fa fa-circle-o"></i> Cash Receipt(Edit)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=bankPaymentEdit">
                                	<i class="fa fa-circle-o"></i> Bank Payment(Edit)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=bankReceiptEdit">
                                	<i class="fa fa-circle-o"></i> Bank Receipt(Edit)
                                </a>
                            </li>
                  		</ul>
                	</li>
                   </li>
              	</ul>
			</section>
			<!-- /.sidebar -->
		</aside>
        
