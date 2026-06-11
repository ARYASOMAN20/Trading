
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
                            <li>
                            	<a href="welcome.php?page=addCountry">
                                	<i class="fa fa-circle-o"></i>Country
                                </a>
                            </li>
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
                            	<a href="welcome.php?page=addUnit">
                                	<i class="fa fa-circle-o"></i>Unit
                                </a>
                            </li>-->
                            <li>
                            	<a href="welcome.php?page=addEmployeeView">
                                	<i class="fa fa-circle-o"></i>Employee
                                </a>
                            </li>
                            
                      	</ul>
                	</li>
                		<li class="treeview">
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
                            <!--<li>
                            	<a href="welcome.php?page=advanceAmountReport">
                                	Advance Amount report
                                </a>
                            </li>-->

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
                            	<a href="welcome.php?page=storeImportPurchasePrint">
                                	<i class="fa fa-circle-o"></i>Stock Receipt(Search)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=importPurchaseOrder">
                                	<i class="fa fa-circle-o"></i>Import Purchase Order
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=importPurchaseOrderEdit">
                                	<i class="fa fa-circle-o"></i>Import Purchase Order(Edit)
                                </a>
                            </li>
                  		</ul>
                	</li>
                	<li class="treeview">
                  		<a href="">
                    		<i class="fa fa-cart-plus"></i> <span>Rental Invoice</span>
                            <span class="pull-right-container">
                              	<i class="fa fa-angle-left pull-right"></i>
                            </span>
                  		</a>
                  		<ul class="treeview-menu">
                  		   <li>
                            	<a href="welcome.php?page=rentalInvoice">
                                	<i class="fa fa-circle-o"></i>Rental Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=rentalInvoiceEdit">
                                	<i class="fa fa-circle-o"></i>Rental Invoice Edit
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=rentalnvoiceReportByDate">
                                    <i class="fa fa-circle-o"></i>Rental Invoice Report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=perfomaInvoice">
                                	<i class="fa fa-circle-o"></i>Performa Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=perfomaInvoiceEdit">
                                	<i class="fa fa-circle-o"></i>Performa Invoice Edit
                                </a>
                            </li>
                            
                  		</ul>
                	</li>
                	<!--<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-file-text"></i> <span>Report</span>
                    		<span class="pull-right-container">
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
                                	<a href="welcome.php?page=stockTransitReportByDate">
                                    	Stock Transit Report
                                    </a>
                            </li>
                             <li>
                                	<a href="welcome.php?page=stockTransitReportByItemWise">
                                    	Stock Transit Report(itemwise)
                                    </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=totalStockReportByDate">
                                	Stock Report(without expiry)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=totalStockReportBranchByExpiryDate ">
                                	Stock Report(with expiry)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=totalStockReportBranchByDate">
                                	Stock Report(warehouse/salesarea)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportByBranch">
                                	Sales Report(Salesarea wise)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportByMainBranchWise">
                                	Sales Report(Branch wise)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportsBySalesAreaWise">
                                	Sales Report(All Salesarea)
                                </a>
                            </li>
                           <li>
                            	<a href="welcome.php?page=salesAreaSalesReport">
                                	Sales Summary(Salesarea)
                                </a>
                            </li> 
                            <li>
                                <a href="welcome.php?page=localPurchseReportItemWise">
                                        	Purchase Report(itemwise)
                                        </a>
                            </li>
                            <li>
                                <a href="welcome.php?page=purchseReportByCategory">
                                        	Purchase Report(Category)
                                        </a>
                            </li>
                            <li>
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
                                    </li>
                                    <!--<li>
                                    	<a href="welcome.php?page=purchseReportSummarySubCategoryWise">
                                        	Purchase Report(Subcategory Summary)
                                        </a>
                                    </li>-->
                      	<!--</ul>-->
                      	<!--<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-file-text"></i> <span>Zacta</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                      	<ul class="treeview-menu">
                            <li>
                            	<a href="welcome.php?page=simplifiedInvoiceSearchByDate">
                                Invoice(zatca upload)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=rentalInvoiceConnectWithZakat">
                                Rental Invoice(zatca upload)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=zakatConnectInvoiceSearchByDate">
                                Report(Uploaded invoices)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=zakatConnectRentalInvoiceSearchByDate">
                                Rental Report(Uploaded invoices)
                                </a>
                            </li>
                      	</ul>-->
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
                                	<a href="welcome.php?page=importVariationReport">
                                    	Import Variation Report
                                    </a>
                                
                            </li>
                            <li>
                                	<a href="welcome.php?page=importPurchaseReportByVendor">
                                    	Store Import Purchase Report
                                    </a>
                                
                            </li>
                             <li>
                                	<a href="welcome.php?page=localPurchaseReport">
                                    	Local Purchase Report
                                    </a>
                                
                            </li>
                            
                            <li>
                                	<a href="welcome.php?page=vendorReport">
                                    	Vendor Report(Import)
                                    </a>
                            </li>
                            <li>
                                	<a href="welcome.php?page=stockTransitReportByDate">
                                    	Stock Transit Report
                                    </a>
                            </li>
                             <li>
                                	<a href="welcome.php?page=stockTransitReportByItemWise">
                                    	Stock Transit Report(itemwise)
                                    </a>
                            </li>
                            <li>
                                	<a href="welcome.php?page=transitStockReportSummary">
                                    	Stock Transit Report(total qty)
                                    </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=totalStockReportByDate">
                                	Stock Report(without expiry)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=totalStockReportBranchByExpiryDate ">
                                	Stock Report(with expiry)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=totalStockReportBranchByDate">
                                	Stock Report(warehouse/salesarea)
                                </a>
                            </li>
                            <li>
                                <a href="welcome.php?page=localPurchseReportItemWise">
                                        	Purchase Report(itemwise)
                                        </a>
                            </li>
                            <li>
                                <a href="welcome.php?page=purchseReportByCategory">
                                        	Purchase Report(Category)
                                        </a>
                            </li>
                            <li>
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
                            </li>
                            <li>
                                <a href="welcome.php?page=purchseReportSummarySubCategoryWise">
                                        	Purchase Report(Subcategory Summary)
                                </a>
                            </li>
                            <li>
                                <a href="welcome.php?page=openingStockReportInAllWarehouse">
                                        	Opening Stock
                                </a>
                            </li>
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
                            	<a href="welcome.php?page=salesReportByBranch">
                                	Sales Report(Salesarea wise)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportByMainBranchWise">
                                	Sales Report(Branch wise)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportsBySalesAreaWise">
                                	Sales Report(All Salesarea)
                                </a>
                            </li>
                           <li>
                            	<a href="welcome.php?page=salesAreaSalesReport">
                                	Sales Summary(Salesarea)
                                </a>
                            </li> 
                             <li>
                            	<a href="welcome.php?page=salesReportByDateAndItemWise">
                                	Sales Report(Itemwise)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportByDateAndCategoryWise">
                                	Sales Report(Category)
                                </a>
                            </li> 
                             <li>
                            	<a href="welcome.php?page=salesReportByDateAndSubCategoryWise">
                                	Sales Report(Subcategory)
                                </a>
                            </li> 
                            <li>
                            	<a href="welcome.php?page=salesReportByDateAndAllItem">
                                	Sales Report(AllItem)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesAreaSalesReportByCategoryAndSubCategory">
                                	Sales Report(Category & Sub category)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=totalSalesReportMonthWise">
                                	Total Sales& Cash(Month Wise)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=itemTrackingReport">
                                	Item tracking report
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportSummaryCategoryWise">
                                	Sales Report Summary(Category wise)
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=salesReportSummarySubCategoryWise">
                                	Sales Report Summary(Subcategory wise)
                                </a>
                            </li>
                            </ul>
                            </li>
                           
                            </ul>
                           </li>
                      	<li class="treeview">
                  		<a href="#">
                    		<i class="fa fa-file-text"></i> <span>Search</span>
                    		<span class="pull-right-container">
                      			<i class="fa fa-angle-left pull-right"></i>
                    		</span>
                  		</a>
                      	<ul class="treeview-menu">
                            <li>
                            	<a href="welcome.php?page=importPurchaseSearchByInvoiceNo">
                                Print For Import Purchase
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=purchaseLocalinvoiceSearchByInvoiceNo">
                                Print For Local Purchase
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=invoiceSearchByInvoiceNo">
                                Print For Invoice
                                </a>
                            </li>
                             <li>
                            	<a href="welcome.php?page=rentalInvoiceSearchByNo">
                                Print For Rental Invoice
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashReceiptSearch">
                                Print For Cash Receipt
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=cashPaymentSearch">
                                Print For Cash Payment
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=importPurchaseOrderSearch">
                                Print For Import Purchase Order
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
                            	<a href="welcome.php?page=openingBalanceFoeVendor">
                                	<i class="fa fa-circle-o"></i> Vendor Opening Balance 
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
                            	<a href="welcome.php?page=journalVoucherUpdate">
                                	<i class="fa fa-circle-o"></i> Edit-JV,CR,CP,BR,BP
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=JournelSearchView">
                                	<i class="fa fa-circle-o"></i> Journal Report
                                </a>
                            </li>-->
                            <li>
                            	<a href="welcome.php?page=JournalVoucherPrint">
                                	<i class="fa fa-circle-o"></i> Re print-JV,CR,CP,BR,BP
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=JournalVoucherCancelView">
                                	<i class="fa fa-circle-o"></i> Journal Voucher Cancel
                                </a>
                            </li>
                            <!--<li>
                            	<a href="welcome.php?page=debitNote">
                                	<i class="fa fa-circle-o"></i> Debit Note
                                </a>
                            </li>
                            <li>
                            	<a href="welcome.php?page=creditNote">
                                	<i class="fa fa-circle-o"></i> Credit Note
                                </a>
                            </li>-->
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
                            </li>-->
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
        
