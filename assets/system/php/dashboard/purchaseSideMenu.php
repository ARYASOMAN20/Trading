
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
                   
                    <li class="treeview">
                      	<a href="#">
                        	<i class="fa fa-cogs"></i>
                        	<span>Masters</span>
                        	<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                      	</a>
                      	<ul class="treeview-menu">
                      	  
                      	    <li>
                            	<a href="welcome.php?page=itemMaster">
                                	<i class="fa fa-circle-o"></i>Item Master
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=itemMasterList">
                                	<i class="fa fa-circle-o"></i>item Master Edit
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=addCategory">
                                	<i class="fa fa-circle-o"></i>Item Category
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=addBrand">
                                	<i class="fa fa-circle-o"></i>Item Brand
                                </a>
                            </li>
                           	<li>
                            	<a href="welcome.php?page=addVendor">
                                	<i class="fa fa-circle-o"></i>Vendor
                                </a>
                            </li>
                           <li>
                            	<a href="welcome.php?page=addUnit">
                                	<i class="fa fa-circle-o"></i>Unit
                                </a>
                            </li>
                
                            <li>
                            	<a href="welcome.php?page=stockEditView">
                                	<i class="fa fa-circle-o"></i> Edit Stock
                                </a>
                            </li>
                            
                           
                        
                      	</ul>
                	</li>
              
                    
                	
                
                	<li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Purchase</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                            <li>
                            	<a href="welcome.php?page=addPurchaseItem">
                                	<i class="fa fa-circle-o"></i> Add Purchase
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=editPurchaseItem">
                                	<i class="fa fa-circle-o"></i> Edit Purchase 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=purchaseOrder">
                                	<i class="fa fa-circle-o"></i> Purchase Order
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=purchaseReturn">
                                	<i class="fa fa-circle-o"></i> Purchase Return
                                </a>
                            </li>
                            
                  		</ul>
                	</li>
                
                
                
    <li class="treeview">
                  		<a href="">
                    		<i class="fa fa-clipboard"></i> <span>Reports</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		   
                            <li>
                            	<a href="">
                                <i class="fa fa-clipboard"></i> <span>Purchase</span>
                                
                              	    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                                </a>
                                    <ul class="treeview-menu">
                                    <li>
                                	<a href="welcome.php?page=generalPurchaseReport">
                                    	 Purchase Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=vendorReport">
                                    	Vendor Purchase Report
                                    </a>
                                
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=balanceAmountReportByVendor">
                                        	Vendor Purchase Payment
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockSearchView">
                                        	 Stock Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockSearchByCategory">
                                        Stock Report(Item Category)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockSearchBySection">
                                        	Stock Report(section)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockReportByDateView">
                                        	Stock Report By Date
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=purchaseReturnReport">
                                        	Purchase Return Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=purchaseReturnReportByVendor">
                                        	Vendor Purchase Rtn Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=PurchaseOrderReport">
                                        	Purchase Order Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=purchaseAndSalesReportByItem">
                                         Item Transaction Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=openingStockCostPrice">
                                         Opening Stock Report
                                        </a>
                                    </li>
                                 </ul>
                            </li>
                            
                           
                           
                            </ul>
                           </li>
                        
                       
                   
                      
                           <!--</li>
                            	<a href="welcome.php?page=customerOrSalesReport ">
                                	<i class="fa fa-circle-o"></i> Customer/Salesman Report
                                </a>
                            </li>-->
                            
                            <!--<li>
                            	<a href="welcome.php?page=vendorReport">
                                	<i class="fa fa-circle-o"></i> Vendor Purchase Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockSearchView">
                                	<i class="fa fa-circle-o"></i> Stock Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=customerQuotationPaymentReport">
                                	<i class="fa fa-circle-o"></i> Customer Payment Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesmanWiseReport">
                                	<i class="fa fa-circle-o"></i> Salesman Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=payementReport">
                                	<i class="fa fa-circle-o"></i> Payment Report By Invoiceno
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=payementReportByDate">
                                	<i class="fa fa-circle-o"></i> Credit Report
                                </a>
                            </li>
                             <li>
                            	<a href="welcome.php?page=purchaseReturnReport">
                                	<i class="fa fa-circle-o"></i>Purchase Return Report
                                </a>
                            </li>
                            
                  		</ul>
                  		 <li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-money"></i> <span>Accounts</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    <li>
                            	<a href="welcome.php?page=addAccountHeadView">
                                	<i class="fa fa-circle-o"></i> Add Account Head
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=subAccountheadView">
                                	<i class="fa fa-circle-o"></i> Add Subaccount Head
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=clientOtherPayment">
                                	<i class="fa fa-circle-o"></i> Opening Balance 
                                </a>
                            </li>
                    		<li>
                            	<a href="welcome.php?page=journalVoucherPayment">
                                	<i class="fa fa-circle-o"></i> Journal Voucher
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=journelVoucherEdit">
                                	<i class="fa fa-circle-o"></i> Journel Voucher Edit
                                </a>
                            </li>-->
                            <!--<li>
                            	<a href="welcome.php?page=JournelSearchView">
                                	<i class="fa fa-circle-o"></i> Journal Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=JournalVoucherPrint">
                                	<i class="fa fa-circle-o"></i> Journal Voucher Print
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=Ledger">
                                	<i class="fa fa-circle-o"></i> Ledger Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=trialBalanceView">
                                	<i class="fa fa-circle-o"></i> Trial Balance
                                </a>
                            </li>
                             <li>
                            	<a href="welcome.php?page=ProfitLossReport">
                                	<i class="fa fa-circle-o"></i> Profit & Loss Report
                                </a>
                            </li>
                             <li>
                            	<a href="welcome.php?page=balanceSheet">
                                	<i class="fa fa-circle-o"></i> Balance Sheet
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=DayReport">
                                	<i class="fa fa-circle-o"></i> Day Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashBook">
                                	<i class="fa fa-circle-o"></i> Cash Book
                                </a>
                            </li>
                  		</ul>
                	</li>-->
                	</li>
              	</ul>
			</section>
			<!-- /.sidebar -->
		</aside>
        
