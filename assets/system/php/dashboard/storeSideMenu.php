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
                            	<a href="welcome.php?page=addUnit">
                                	<i class="fa fa-circle-o"></i>Unit
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=openingStockForItem">
                                	<i class="fa fa-circle-o"></i>Opening Stock
                                </a>
                            </li>
                        	<!--<li>
                            	<a href="welcome.php?page=addRegCusName">
                                	<i class="fa fa-circle-o"></i>Customer
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
                            	<a href="welcome.php?page=addVessel">
                                	<i class="fa fa-circle-o"></i> Vessel
                                </a>
                            </li>
                            </ul>
                            </li>-->
                           
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
                            	<a href="welcome.php?page=addCountry">
                                	<i class="fa fa-circle-o"></i>Country
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=branch">
                                	<i class="fa fa-circle-o"></i>Warehouse/Salesarea
                                </a>
                            </li>-->
                            <li>
                            	<a href="welcome.php?page=addCurrency">
                                	<i class="fa fa-circle-o"></i>Currency
                                </a>
                            </li>
                           
                            <li>
                            	<a href="welcome.php?page=addUnit">
                                	<i class="fa fa-circle-o"></i>Unit
                                </a>
                            </li>
                            
                            <!--<li>
                            	<a href="welcome.php?page=stockEditView">
                                	<i class="fa fa-circle-o"></i> Edit Stock
                                </a>
                            </li>-->
                            <!--li>
                            	<a href="welcome.php?page=addUsers">
                                	<i class="fa fa-circle-o"></i> Add Users
                                </a>
                            </li>-->
                           <!--<li>
                            	<a href="welcome.php?page=addEmployeeView">
                                	<i class="fa fa-circle-o"></i> Employee
                                </a>-->
                          
                      	</ul>
                	</li>
                	<!--<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-file-text"></i> <span>Salary Management</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                      	<ul class="treeview-menu">
                            <li>
                            	<a href="welcome.php?page=advancePaymentView">
                                	Advance Amount
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=timeSheet">
                                	Payslip
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salarySheetReport">
                                	 Salary Report 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=advanceAmountReport">
                                	Advance Amount report
                                </a>
                            </li>

                      	</ul>
                	</li>-->
                    <li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Stock Transfer</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                            <li>
                            	<a href="welcome.php?page=branchTransfer">
                                	<i class="fa fa-circle-o"></i> Stock Transfer
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockTransferEdit">
                                	<i class="fa fa-circle-o"></i> Stock Transfer Edit
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockTransferConfirm">
                                	<i class="fa fa-circle-o"></i> Stock Transfer(Confirm)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=goodsReceived">
                                	<i class="fa fa-circle-o"></i>Stock Addition
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=goodsReceivedEdit">
                                	<i class="fa fa-circle-o"></i>Stock Addition(Edit)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=goodsReceivedConfirm">
                                	<i class="fa fa-circle-o"></i> Stock Addition(Confirm)
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=stockTransferWarehouseConfirmView">
                                	<i class="fa fa-circle-o"></i> Stock Return(Confirm)
                                </a>
                            </li>-->
                            <li>
                            	<a href="welcome.php?page=stockReturnBySalesArea">
                                	<i class="fa fa-circle-o"></i> Stock Return(Sales Area)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockRequestLIstWarehouse">
                                	<i class="fa fa-circle-o"></i> Stock Request(From Sales Area)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockRequsetConfirmEdit">
                                	<i class="fa fa-circle-o"></i> Stock Request(Edit)
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
                            
                            <!--<li>
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
                            </li>-->
                            
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
                                	<i class="fa fa-circle-o"></i> Debit Note
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=creditNote">
                                	<i class="fa fa-circle-o"></i> Credit Note
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
                            
                            <!--<li>
                            	<a href="welcome.php?page=localInvoiceEdit">
                                	<i class="fa fa-circle-o"></i>Staff Invoice Edit 
                                </a>
                            </li>-->
                            <!--<li>
                            	<a href="welcome.php?page=invoiceCreditNote">
                                	<i class="fa fa-circle-o"></i>Invoice Credit Note
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=invoiceCreditNoteSearch">
                                	<i class="fa fa-circle-o"></i>Invoice Creditnote Search
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
                            
                            
                  		</ul>
                	</li>
                   
              		<!--<li class="treeview">
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
                            <!--<li>
                            	<a href="welcome.php?page=clientQuotation">
                                	<i class="fa fa-circle-o"></i>Client Quotation 
                                </a>
                            </li>-->
                            <!--<li>
                            	<a href="welcome.php?page=clientQuotationSearchByQuotationNo">
                                	<i class="fa fa-circle-o"></i> Client Quotation(Search)
                                </a>
                            </li>-->

                      	<!--</ul>
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
                                <i class="fa fa-clipboard"></i> <span>Purchase</span>
                                
                              	    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                                </a>
                                    <ul class="treeview-menu">
                                    <li>
                                	<a href="welcome.php?page=importPurchaseReport">
                                    	 Import Purchase Report
                                    </a>
                                
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=vendorReport">
                                        	Vendor Report(Import)
                                        </a>
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=localPurchaseReport">
                                    	 Local Purchase Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=localVendorPurchaseReport">
                                    	 Local Vendor Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=transferReportByDate">
                                    	 Stock Transfer Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=stockRequestConfirmReport">
                                    	 Stock Request Confirm Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=stockRequestAndTransferReport">
                                    	 Stock Request transfer Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=totalStockAndNetweightReportByDate">
                                    	 Goods Receipt Report
                                    </a>
                                
                                    </li>
                                    <!--<li>
                                	<a href="welcome.php?page=vendorReport">
                                    	Vendor Purchase Report
                                    </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=balanceAmountReportByVendor">
                                        	Vendor Purchase Payment
                                        </a>
                                    </li>-->
                                    <li>
                                    	<a href="welcome.php?page=totalStockReport">
                                        	 Total Stock Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=totalStockReportWithOutExpiry">
                                        	 Stock Report(Without Expiry)
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
                                    	<a href="welcome.php?page=itemTrackingReport">
                                        	Item Tracking Report
                                        </a>
                                    </li>
                                   <li>
                                    	<a href="welcome.php?page=openingStockReport">
                                        	Opening Stock Report
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=goodReceivedReport">
                                        	Goods Received Report
                                        </a>
                                    </li>
                                    <!--<li>
                                    	<a href="welcome.php?page=purchseReportBySubCategory">
                                        	Purchase Report(Sub Category)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=purchseReportAllItem">
                                        	Purchase Report(All Item)
                                        </a>
                                    </li>
                                    <li>
                                    	<a href="welcome.php?page=purchseReportSummaryCategoryWise">
                                        	Purchase Report(Summary)
                                        </a>
                                    </li>-->
                                    <!--<li>
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
                                    </li>-->
                                 </ul>
                            </li>
                            
                            <li>
                            	<a href="">
                                <i class="fa fa-clipboard"></i> <span>Sales</span>
                                
                              	    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                                </a>
                                    <ul class="treeview-menu">
                                    <li>
                                	<a href="welcome.php?page=salesAreaSalesReportByDateWise">
                                    	Sales Report
                                    </a>
                                
                                    </li>
                                    <li>
                                	<a href="welcome.php?page=dailyReportByWarehouseWise">
                                    	Daily Report
                                    </a>
                                
                                    </li>
                                    <!--<li>
                                    	<a href="welcome.php?page=customerStatementReport">
                                        	Customer Statement
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
                                    <!--<li>
                                	<a href="welcome.php?page=salesReportByEmployeeWise">
                                    	Satff Sales Report
                                    </a>
                                
                                    </li>
                                    <li>
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
                      	    <!--<li>
                            	<a href="welcome.php?page=importPurchaseSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i> Print For Import Purchase
                                </a>
                            </li>-->
                        	<li>
                            	<a href="welcome.php?page=purchaseLocalinvoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i> Print For Local Purchase
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=invoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i>Print For Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=customersalespaymentPrint">
                                	<i class="fa fa-circle-o"></i>Cash Receipt Print
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockReturnSearchByReturnNo">
                                	<i class="fa fa-circle-o"></i>Print For Stock Return 
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=stockTransferSearchByTransferNumber">
                                	<i class="fa fa-circle-o"></i>Print For Stock Transfer 
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=invoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i>Print For Vansale Invoice
                                </a>
                            </li>-->
                            <li>
                            	<a href="welcome.php?page=stockTransferConfirmPrint">
                                	<i class="fa fa-circle-o"></i>Stock Transfer Cofirm 
                                </a>
                            </li>
                           <!-- <li>
                            	<a href="welcome.php?page=stockReturnSearchByReturnNo">
                                	<i class="fa fa-circle-o"></i>Print For Stock Return 
                                </a>
                            </li>-->
                            
                            <!--<li>
                            	<a href="welcome.php?page=localInvoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i>Print For Staff Invoice
                                </a>
                            </li>-->
                            <!--<li>
                            	<a href="welcome.php?page=deliveryNoteAdditionalDetailsReport">
                                	<i class="fa fa-circle-o"></i>DeliveryNote(additional details)
                                </a>
                            </li>-->
                            <!--<li>
                            	<a href="welcome.php?page=invoiceSearchByInvoiceNo">
                                	<i class="fa fa-circle-o"></i> InvoiceNo Search
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=quotationSearchByDate">
                                	<i class="fa fa-circle-o"></i> Quotation Search
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=quotationSearchByQuotationNo">
                                	<i class="fa fa-circle-o"></i> QuotationNo Search
                                </a>
                            </li>-->
                            
                      	</ul>
              		</li>
              		 <li class="treeview">
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
                            <li>
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
                            
                    		<li>
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
        
