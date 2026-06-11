<?php //echo $_SESSION['loggedin_time'] = time(); ?>
		<!-- Left side column. contains the logo and sidebar -->
      	<aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              	
                <!-- Sidebar user panel -->
              	<div class="user-panel">
           			<div class="pull-left image">
                  		<img src="../../../../assets/dist/img/user1-128x128.jpg" class="img-circle" alt="User Image">
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
                            	<a href="welcome.php?page=addRegCusName">
                                	<i class="fa fa-circle-o"></i> Add Customer
                                </a>
                            </li>
						  <li>
                            	<a href="welcome.php?page=insertToLocalServerView">
                                	<i class="fa fa-circle-o"></i> Items Export
                                </a>
                            </li>
          
                      	</ul>
                	</li>
                
                
                	<li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Sales</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    
                            <li>
                            	<a href="welcome.php?page=counterSalesInvoice">
                                	<i class="fa fa-circle-o"></i>Invoice
                                </a>
                            </li>
							<li>
                            	<a href="welcome.php?page=invoiceEdit">
                                	<i class="fa fa-circle-o"></i>Invoice(Edit)
                                </a>
                            </li>
							<li>
                            	<a href="welcome.php?page=salesReturnCounterSale">
                                	<i class="fa fa-circle-o"></i>Sales Return
                                </a>
                            </li>
							<!--<li>
                            	<a href="welcome.php?page=salesInvoiceConnect">
                                	<i class="fa fa-circle-o"></i>Invoice Import 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReturnConnect">
                                	<i class="fa fa-circle-o"></i>Sales Return Import 
                                </a>
                            </li>-->
                            
                            
                            </ul>
                	</li>
                	
					<li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Import Details</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    
							<li>
                            	<a href="welcome.php?page=salesInvoiceConnect">
                                	<i class="fa fa-circle-o"></i>Invoice Import 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReturnConnect">
                                	<i class="fa fa-circle-o"></i>Sales Return Import 
                                </a>
                            </li>
                            
                  		</ul>
                	</li>
                	<!--<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-money"></i> <span>Payments</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    <li>
                            	<a href="welcome.php?page=customerSalaesPayment">
                                	<i class="fa fa-circle-o"></i>Cash Receipt
                                </a>
                            </li>
                            
                            
                  		</ul>
                	</li>-->
                   
              		
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
                                <i class="fa fa-clipboard"></i> <span>Sales</span>
                                
                              	    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                                </a>
                                    <ul class="treeview-menu">
                                    <li>
                                	<a href="welcome.php?page=counterSalesInvoiceReportByDate">
                                    	Sales Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=dailyReportByWarehouseWise">
                                    	Daily Report
                                    </a>
                                
                                    </li>
                   
                                 </ul>
                            </li>
                           
                            </ul>
                           </li>
                        
                       
                        <li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-search"></i> <span>Search</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                      	<ul class="treeview-menu">
                      	  
                            <li>
                            	<a href="welcome.php?page=invoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i>Print For Invoice
                                </a>
                            </li>
                      	</ul>
              		</li>
              		 <!--<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-money"></i> <span>Accounts</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                  		 
                  		<ul class="treeview-menu">
                  		    <li>
                            	<a href="welcome.php?page=addFinancialYear">
                                	<i class="fa fa-circle-o"></i> Add Financial Year
                                </a>
                            </li>  
                  		    <li>
                            	<a href="welcome.php?page=addRegCusName">
                                	<i class="fa fa-circle-o"></i>Chart Of Accounts
                                	<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                                </a>
                            
                            <ul class="treeview-menu">
                            <li>
                            	<a href="welcome.php?page=addAccountHeadView">
                                	<i class="fa fa-circle-o"></i> Account Head
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=primaryAccountHead">
                                	<i class="fa fa-circle-o"></i> Primary Account
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=secondaryLevelAccountHead">
                                	<i class="fa fa-circle-o"></i> Second Level Account
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=thirdLevelAccountHead">
                                	<i class="fa fa-circle-o"></i> Third Level Account
                                </a>
                            </li>
                            </ul>
                            </li>
                  		    <!--<li>
                            	<a href="welcome.php?page=addAccountHeadView">
                                	<i class="fa fa-circle-o"></i> Add Account Head
                                </a>
                            </li>-->
                            <!--<li>
                            	<a href="welcome.php?page=subAccountheadView">
                                	<i class="fa fa-circle-o"></i> Add Account Ledger
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=clientOtherPayment">
                                	<i class="fa fa-circle-o"></i> Opening Balance 
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=openingBalanceEditView">
                                	<i class="fa fa-circle-o"></i> Opening Balance Edit
                                </a>
                            </li>-->
                            
                    		<!--<li>
                            	<a href="welcome.php?page=journalVoucherPayment">
                                	<i class="fa fa-circle-o"></i> Journal Voucher
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashReceipt">
                                	<i class="fa fa-circle-o"></i> Cash Receipt
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashReceiptSearch">
                                	<i class="fa fa-circle-o"></i> Cash Receipt Search
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashPayment">
                                	<i class="fa fa-circle-o"></i> Cash Payment
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashPaymentSearch">
                                	<i class="fa fa-circle-o"></i> Cash Payment Search
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=bankReceipt">
                                	<i class="fa fa-circle-o"></i> Bank Receipt
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=bankPayment">
                                	<i class="fa fa-circle-o"></i> Bank Payment
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=journalVoucherUpdate">
                                	<i class="fa fa-circle-o"></i> Journal Voucher Edit
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
                            	<a href="welcome.php?page=JournalVoucherCancelView">
                                	<i class="fa fa-circle-o"></i> Journal Voucher Cancel
                                </a>
                            </li>
                            
                            <li>
                            	<a href="welcome.php?page=purchaseVatReport">
                                	<i class="fa fa-circle-o"></i> 
                                Purchase Vat Report</a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesVatReport">
                                	<i class="fa fa-circle-o"></i> Sales Vat Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=Ledger">
                                	<i class="fa fa-circle-o"></i> Ledger Report
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=trialBalanceAjax">
                                	<i class="fa fa-circle-o"></i> Trial Balance
                                </a>
                            </li>-->
                            <!--<li>
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
                    <!--<li class="treeview">
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
                            	<a href="welcome.php?page=openingBalanceEditView">
                                	<i class="fa fa-circle-o"></i> Opening Balance Edit
                                </a>
                            </li>
                            
                    		<li>
                            	<a href="welcome.php?page=journalVoucherPayment">
                                	<i class="fa fa-circle-o"></i> Journal Voucher
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=journalVoucherUpdate">
                                	<i class="fa fa-circle-o"></i> Journal Voucher Edit
                                </a>
                            </li>
                            <li>
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
                            	<a href="welcome.php?page=JournalVoucherCancelView">
                                	<i class="fa fa-circle-o"></i> Journal Voucher Cancel
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=debitNote">
                                	<i class="fa fa-circle-o"></i> Debit Note
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=creditNote">
                                	<i class="fa fa-circle-o"></i> Credit Note
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=purchaseVatReport">
                                	<i class="fa fa-circle-o"></i> 
                                Purchase Vat Report</a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesVatReport">
                                	<i class="fa fa-circle-o"></i> Sales Vat Report
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
        
