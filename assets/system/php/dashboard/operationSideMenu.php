
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
                            <!--<li>
                            	<a href="welcome.php?page=availabilityChecking">
                                	<i class="fa fa-circle-o"></i>Availability Checking
                                </a>
                            </li>-->
                            <li>
                            	<a href="welcome.php?page=itemMasterList">
                                	<i class="fa fa-circle-o"></i>item Master(List & Edit)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=setSellingPrice">
                                	<i class="fa fa-circle-o"></i>Set Selling Price
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=addCategory">
                                	<i class="fa fa-circle-o"></i>Item Category
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=addSubCategory">
                                	<i class="fa fa-circle-o"></i>Sub Category
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
                            	<a href="welcome.php?page=addRegCusName">
                                	<i class="fa fa-circle-o"></i>Customer
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=customerSearch">
                                	<i class="fa fa-circle-o"></i>Customer search
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=stockEditView">
                                	<i class="fa fa-circle-o"></i> Edit Stock
                                </a>
                            </li>-->
                            
                           <!--<li>
                            	<a href="welcome.php?page=addEmployeeView">
                                	<i class="fa fa-circle-o"></i> Employee
                                </a>-->
                          
                      	</ul>
                	</li>
               		<li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Stock Transfer</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    <li>
                            	<a href="welcome.php?page=stockRequest">
                                	<i class="fa fa-circle-o"></i> Stock Request
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockTransferConfirm">
                                	<i class="fa fa-circle-o"></i> Stock Transfer(Confirm)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=goodsReceivedConfirm">
                                	<i class="fa fa-circle-o"></i> Stock Received(Confirm)
                                </a>
                            </li>
                        </ul>
                	 </li>
                	 <!--<li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Purchase</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    <li>
                            	<a href="welcome.php?page=importPurchase">
                                	<i class="fa fa-circle-o"></i>Import Purchase
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=importPurchaseOrder">
                                	<i class="fa fa-circle-o"></i>Import Purchase Order
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=addPurchaseItem">
                                	<i class="fa fa-circle-o"></i>Local Purchase
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=localPurchaseOrder">
                                	<i class="fa fa-circle-o"></i>Local Purchase Order
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=storeImportPurchase">
                                	<i class="fa fa-circle-o"></i>Stock Receipt(Import)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=storeImportPurchasePrint">
                                	<i class="fa fa-circle-o"></i>Stock Receipt(Search)
                                </a>
                            </li>
                            
                  		</ul>
                	</li>-->
                
                	 <li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Sales</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		    
                            <!--<li>
                            	<a href="welcome.php?page=deliveryNodeView">
                                	<i class="fa fa-circle-o"></i>Delivery Notes
                                </a>
                            </li>-->
                            
                            <li>
                            	<a href="welcome.php?page=salesInvoice">
                                	<i class="fa fa-circle-o"></i>Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReturnItemWise">
                                	<i class="fa fa-circle-o"></i>Invoice(Return)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=debitNote">
                                	<i class="fa fa-circle-o"></i>Debit Note
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=creditNote">
                                	<i class="fa fa-circle-o"></i>Credit Note
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=salesInvoiceThermal">
                                	<i class="fa fa-circle-o"></i>Vansale Invoice
                                </a>
                            </li>-->
                            <!--<li>
                            	<a href="welcome.php?page=localSalesInvoice">
                                	<i class="fa fa-circle-o"></i>Satff Invoice
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=editDeliveryNote">
                                	<i class="fa fa-circle-o"></i>Edit Delivery Notes
                                </a>
                            </li>-->
                            
                            <!--<li>
                            	<a href="welcome.php?page=invoiceEdit">
                                	<i class="fa fa-circle-o"></i>Sales Invoice Edit 
                                </a>
                            </li>-->
                            
                           
                            
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
                                	<i class="fa fa-circle-o"></i>Cash Receipt
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=openingBalanceFoeSalesareaCustomer">
                                	<i class="fa fa-circle-o"></i>Opening Balance
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
                  		   
                            <!--<li>
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
                            </li>-->
                            
                            <li>
                            	<a href="">
                                <i class="fa fa-clipboard"></i> <span>Sales</span>
                                
                              	    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                                </a>
                                    <ul class="treeview-menu">
                                    <li>
                                	<a href="welcome.php?page=salesAreaSalesReport">
                                    	Sales Summary
                                    </a>
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=salesReportByDateWise">
                                    	Sales Report
                                    </a>
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=salesAreaSalesReportByDateWise">
                                    	Sales Report By Date
                                    </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=cashReceiptReportByDate">
                                        	Cash Receipt Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=cashReceiptReportByVoucherno">
                                        	Cash Receipt Report(voucher No)
                                        </a>
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=branchWiseCustomerStatementReport">
                                    	Customer Statement Report
                                    </a>
                                
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=salesAreaOutStandinReport">
                                        	Customer Outstanding Report
                                        </a>
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=salesAreaItemWiseReport">
                                    	Stock Transaction Report
                                    </a>
                                
                                    </li>
                                    
                                    <li>
                                    	<a href="welcome.php?page=totalStockReport">
                                        	 Total Stock Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockReturnReportByDate">
                                        	 Stock Return Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockSearchView">
                                        	 Stock Report(item)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockSearchByCategory">
                                        Stock Report(Item Category)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=stockSearchBySection">
                                        	Stock Report(Sub Category)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=itemTrackingReport">
                                        	Item Tracking Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=itemTrackingReportByDate">
                                        	Item Tracking Report(itemwise)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=customerDetailsReportByDateWise">
                                        	Over All Report
                                        </a>
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=damageGoodReturnReport">
                                    	Damage Goods Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=monthlySalesAndCashReport">
                                    	Sales and cash receipt report
                                    </a>
                                
                                    </li>
                                    <!--<li>
                                	<a href="welcome.php?page=staffSalesReport">
                                    	Satff Sales Report By date
                                    </a>
                                
                                    </li>-->
                             
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
                                	<i class="fa fa-circle-o"></i>Invoice Print
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=customersalespaymentPrint">
                                	<i class="fa fa-circle-o"></i>Cash Receipt Print
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockReturnSearchByReturnNo">
                                	<i class="fa fa-circle-o"></i>Stock Return Print
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockTransferSearchByTransferNumber">
                                	<i class="fa fa-circle-o"></i>Stock Transfer Print 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockTransferConfirmPrint">
                                	<i class="fa fa-circle-o"></i>Stock Transfer Cofirm 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReturnsearch">
                                	<i class="fa fa-circle-o"></i>Print For Salesreturn
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
        
