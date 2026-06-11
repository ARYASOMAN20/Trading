
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
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Sales</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    
                            <li>
                            	<a href="welcome.php?page=deliveryNodeView">
                                	<i class="fa fa-circle-o"></i>Delivery Notes
                                </a>
                            </li>
                            
                            <li>
                            	<a href="welcome.php?page=salesInvoice">
                                	<i class="fa fa-circle-o"></i>Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=localSalesInvoice">
                                	<i class="fa fa-circle-o"></i>Satff Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=editDeliveryNote">
                                	<i class="fa fa-circle-o"></i>Edit Delivery Notes
                                </a>
                            </li>
                            
                            <li>
                            	<a href="welcome.php?page=invoiceEdit">
                                	<i class="fa fa-circle-o"></i>Sales Invoice Edit 
                                </a>
                            </li>
                            
                            <li>
                            	<a href="welcome.php?page=localInvoiceEdit">
                                	<i class="fa fa-circle-o"></i>Staff Invoice Edit 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=invoiceCreditNote">
                                	<i class="fa fa-circle-o"></i>Invoice Credit Note
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=invoiceCreditNoteSearch">
                                	<i class="fa fa-circle-o"></i>Invoice Creditnote Search
                                </a>
                            </li>
                            
                  		</ul>
                	</li>
                	
                
                	<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-money"></i> <span>Payments</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    <li>
                            	<a href="welcome.php?page=customerSalaesPayment">
                                	<i class="fa fa-circle-o"></i>Invoice Payment
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=vendorPaymentView">
                                	<i class="fa fa-circle-o"></i>purchase Payment
                                </a>
                            </li>
                    		<li>
                            	<a href="welcome.php?page=paymentVouchers">
                                	<i class="fa fa-circle-o"></i>Payment Voucher
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=receiptVouchers">
                                	<i class="fa fa-circle-o"></i>Receipt Voucher
                                </a>
                            </li>
                            
                  		</ul>
                	</li>
                   
              		<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-file-text"></i> <span>Quotation</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                      	<ul class="treeview-menu">
                            <li>
                            	<a href="welcome.php?page=quotation">
                                	<i class="fa fa-circle-o"></i> Add
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=quotationSearchByQuotationNo">
                                	<i class="fa fa-circle-o"></i> Quotation(Search)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=clientQuotation">
                                	<i class="fa fa-circle-o"></i>Client Quotation 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=clientQuotationSearchByQuotationNo">
                                	<i class="fa fa-circle-o"></i> Client Quotation(Search)
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
                                <i class="fa fa-clipboard"></i> <span>Sales</span>
                                
                              	    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                                </a>
                                    <ul class="treeview-menu">
                                    <li>
                                	<a href="welcome.php?page=generalSalesReport">
                                    	Sales Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=salesReportByCustomerWise">
                                    	Sales Report(customerwise)
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=salesReportByItem">
                                    	Sales Report(Itemwise)
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=salesReportByVessel">
                                    	Sales Report(vessel)
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=salesReportByEmployeeWise">
                                    	Satff Sales Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=staffSalesReport">
                                    	Satff Sales Report By date
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
                            	<a href="welcome.php?page=deliveryNoteSearch">
                                	<i class="fa fa-circle-o"></i> Print For Deliverynote
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=invoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i>Print For Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=localInvoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i>Print For Staff Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=deliveryNoteAdditionalDetailsReport">
                                	<i class="fa fa-circle-o"></i>DeliveryNote(additional details)
                                </a>
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
        
