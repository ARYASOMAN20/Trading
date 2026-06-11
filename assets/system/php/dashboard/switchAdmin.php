<?php
switch($choice) {
	case 'salesReturnConnect'  :  
		include("../../../../modules/importSalesReturnToServer/admin/includes/salesReturnConnect.php");
		break;
	case 'conectLocalToServer'  :  
		  include("../../../../modules/importLocalToServer/admin/includes/conectLocalToServer.php");
		  break;
	case 'salesInvoiceConnect'  :  
		  include("../../../../modules/importLocalToServer/admin/includes/salesInvoiceConnect.php");
		  break;
	case 'salesReturnCounterSalePrint'  :  
		  include("../../../../modules/salesReturnCounterSale/admin/includes/salesReturnCounterSalePrint.php");
		  break;
    case 'salesReturnCounterSale'  :  
		  include("../../../../modules/salesReturnCounterSale/admin/includes/salesReturnCounterSale.php");
		  break;
	case 'insertToLocalServer'  :  
		include("../../../../modules/insertToLocalServer/admin/controllers/insertToLocalServer.php" );
		break;
	case 'insertToLocalServerView'  :  
		  include("../../../../modules/insertToLocalServer/admin/views/insertToLocalServerView.php" );
		  break;
	case 'counterSalesInvoiceReportByDate'  :  
		  include("../../../../modules/counterSalesInvoiceReportByDate/admin/includes/counterSalesInvoiceReportByDate.php" );
		  break;
	case 'counterSalesInvoiceReportByDate'  :  
		  include("../../../../modules/counterSalesInvoiceReportByDate/admin/includes/counterSalesInvoiceReportByDate.php" );
		  break;
	case 'counterSalesInvoiceThermalPrint'  :  
		  include("../../../../modules/counterSalesInvoice/admin/includes/counterSalesInvoiceThermalPrint.php" );
		  break;
	case 'countersalesInvoicePrint'  :  
		  include("../../../../modules/counterSalesInvoice/admin/includes/countersalesInvoicePrint.php" );
		  break;
    case 'counterSalesInvoice'  :  
		  include("../../../../modules/counterSalesInvoice/admin/includes/counterSalesInvoice.php" );
		  break;
     case 'printCustomerSalesPaymentnew'  :  
		  include("../../../../modules/cashReceiptPrint/admin/includes/printCustomerSalesPaymentnew.php" );
		  break;
    case 'customerSalesPaymentReceiptPrint'  :  
		  include("../../../../modules/cashReceiptPrint/admin/includes/customerSalesPaymentReceiptPrint.php" );
		  break;
    case 'zakatConnectRentalInvoiceSearchByDate'  :  
		  include("../../../../modules/zakatConnectRentalInvoiceSearchByDate/admin/includes/zakatConnectRentalInvoiceSearchByDate.php" );
		  break;
    case 'rentalInvoiceConnectWithZakat'  :  
		  include("../../../../modules/rentalInvoiceConnectWithZakat/admin/includes/rentalInvoiceConnectWithZakat.php" );
		  break;
    case 'rentalInvoiceConnectWithZakat'  :  
		  include("../../../../modules/rentalInvoiceConnectWithZakat/admin/includes/rentalInvoiceConnectWithZakat.php" );
		  break;
    case 'simplifiedInvoiceSearchByDate'  :  
		  include("../../../../modules/simplifiedInvoiceSearchByDate/admin/includes/simplifiedInvoiceSearchByDate.php" );
		  break;
	case 'zakatConnectInvoiceSearchByDate'  :  
		  include("../../../../modules/zakatConnectInvoiceSearchByDate/admin/includes/zakatConnectInvoiceSearchByDate.php" );
		  break;
    case 'goodsReceivedDetails'  :  
		  include("../../../../modules/goodsReceivedConfirm/admin/includes/goodsReceivedDetails.php" );
		  break;
    case 'goodsReceivedConfirm'  :  
		  include("../../../../modules/goodsReceivedConfirm/admin/includes/goodsReceivedConfirm.php" );
		  break;
    case 'cashPaymentSearch'  :  
		  include("../../../../modules/cashPaymentSearch/admin/includes/cashPaymentSearch.php" );
		  break;
	case 'cashReceiptSearch'  :  
		  include("../../../../modules/cashReceiptSearch/admin/includes/cashReceiptSearchView.php" );
		  break;
    case 'goodReceivedPrint'  :  
		  include("../../../../modules/goodReceived/admin/includes/goodReceivedPrint.php" );
		  break;
    case 'goodReceivedReport'  :  
		  include("../../../../modules/goodReceivedReport/admin/includes/goodReceivedReport.php" );
		  break;
    case 'salesReturnsearch'  :  
		  include("../../../../modules/salesReturnSearch/admin/includes/salesReturnsearch.php" );
		  break;
	case 'goodsReceivedEdit'  :  
		  include("../../../../modules/goodsReceivedEdit/admin/includes/goodsReceivedEdit.php" );
		  break;
    case 'customerSearch'  :  
		  include("../../../../modules/customerSearch/admin/includes/customerSearch.php" );
		  break;
    case 'goodsReceived'  :  
		  include("../../../../modules/goodReceived/admin/includes/goodReceived.php" );
		  break;
    case 'setSellingPrice'  :  
		  include("../../../../modules/setSellingPrice/admin/includes/setSellingPrice.php" );
		  break;
    case 'perfomaInvoiceEdit'  :  
		  include("../../../../modules/perfomaInvoiceEdit/admin/includes/perfomaInvoiceEdit.php" );
		  break;
    case 'perfomaInvoicePrint'  :  
		  include("../../../../modules/perfomaInvoice/admin/includes/perfomaInvoicePrint.php" );
		  break;
    case 'perfomaInvoice'  :  
		  include("../../../../modules/perfomaInvoice/admin/includes/perfomaInvoice.php" );
		  break;
    case 'importPurchaseOrderEdit'  :  
		  include("../../../../modules/importPurchaseOrderEdit/admin/includes/importPurchaseOrderEdit.php" );
		  break;
    case 'importPurchaseOrderSearch'  :  
		  include("../../../../modules/importPurchaseOrderSearch/admin/includes/importPurchaseOrderSearch.php" );
		  break;
    case 'importPurchaseOrderPrint'  :  
		  include("../../../../modules/importPurchaseOrder/admin/includes/importPurchaseOrderPrint.php" );
		  break;
    case 'rentalnvoiceReportByDate'  :  
		  include("../../../../modules/rentalnvoiceReportByDate/admin/includes/rentalInvoiceReportByDate.php" );
		  break;
    case 'rentalInvoiceEdit'  :  
		  include("../../../../modules/rentalInvoiceEdit/admin/includes/rentalInvoiceEdit.php" );
		  break;
    case 'rentalInvoiceSearchByNo'  :  
		  include("../../../../modules/rentalInvoiceSearchByNo/admin/includes/rentalInvoiceSearchByInvoiceNo.php" );
		  break;
    case 'totalStockReportByDateWarehouse'  :  
		  include("../../../../modules/totalStockReportByDateWarehouse/admin/includes/totalStockReportByDateWarehouse.php" );
		  break;
    case 'salesReportSummarySubCategoryWise'  :  
		  include("../../../../modules/salesReportSummarySubCategoryWise/admin/includes/salesReportSummarySubCategoryWiseView.php" );
		  break;
    case 'salesReportSummaryCategoryWise'  :  
		  include("../../../../modules/salesReportSummaryCategoryWise/admin/includes/salesReportSummaryCategoryWiseView.php" );
		  break;
    case 'rentalInvoiceEdit'  :  
		  include("../../../../modules/rentalInvoiceEdit/admin/includes/rentalInvoiceEdit.php" );
		  break;
    case 'totalSalesReportMonthWise'  :  
		  include("../../../../modules/totalSalesReportMonthWise/admin/includes/totalSalesReportMonthWise.php" );
		  break;
    case 'sellingPricePrint'  :  
		  include("../../../../modules/itemMasterEdit/admin/includes/sellingPricePrint.php" );
		  break;
    case 'payRollPrint'  :  
		  include("../../../../modules/timeSheet/admin/includes/payRollPrint.php" );
		  break;
    case 'transitStockReportSummary'  :  
		  include("../../../../modules/transitStockReportSummary/admin/includes/transitStockReportSummary.php" );
		  break;
    case 'addFinancialYear'  :  
		  include("../../../../modules/addFinancialYear/admin/includes/addFinancialYear.php" );
		  break;
    case 'rentalInvoicePrint'  :  
		  include("../../../../modules/rentalInvoice/admin/includes/rentalInvoicePrint.php" );
		  break;
    case 'rentalInvoice'  :  
		  include("../../../../modules/rentalInvoice/admin/includes/rentalInvoice.php" );
		  break;
    case 'allInvoicePrint'  :  
		  include("../../../../modules/allInvoicePrint/admin/includes/allInvoicePrintV.php" );
		  break;
    case 'importVariationReport'  :  
		  include("../../../../modules/importVariationReport/admin/includes/importVariationReport.php" );
		  break;
    case 'dotmertocprint'  :  
		  include("../../../../modules/salesInvoice/admin/includes/dotmertocprint.php" );
		  break;
    case 'customerDetailsReportByDateWise'  :  
		  include("../../../../modules/customerDetailsReportByDateWise/admin/includes/customerDetailsReportByDateWise.php" );
		  break;
    case 'storeImportPurchaseEdit'  :  
		  include("../../../../modules/storeImportPurchaseEdit/admin/includes/storeImportPurchaseEditV.php" );
		  break;
    case 'stockRequestAndTransferReport'  :  
		  include("../../../../modules/stockRequestAndTransferReport/admin/includes/stockRequestAndTransferReportV.php" );
		  break;
    case 'stockRequsetConfirmEdit'  :  
		  include("../../../../modules/stockRequsetConfirmEdit/admin/includes/stockRequsetConfirmEdit.php" );
		  break;
    case 'stockRequestPrint'  :  
		  include("../../../../modules/stockRequestLIstWarehouse/admin/includes/stockRequestPrint.php" );
		  break;
    case 'stockRequestConfirmReport'  :  
		  include("../../../../modules/stockRequestConfirmReport/admin/includes/stockRequestConfirmReport.php" );
		  break;
    case 'accountHeadTree'  :  
		  include("../../../../modules/Subaccounthead/admin/includes/accountHeadTree.php" );
		  break;
    case 'importPurchaseReportByVendor'  :  
		  include("../../../../modules/importPurchaseReportByVendor/admin/includes/importPurchaseReportByVendorView.php" );
		  break;
    case 'stockRequestListDetails'  :  
		  include("../../../../modules/stockRequestLIstWarehouse/admin/includes/stockRequestListDetails.php" );
		  break;
    case 'cashReceiptEdit'  :  
		  include("../../../../modules/cashReceiptEdit/admin/includes/cashReceiptEdit.php" );
		  break;
    case 'bankReceiptEdit'  :  
		  include("../../../../modules/bankReceiptEdit/admin/includes/bankReceiptEdit.php" );
		  break;
    case 'bankPaymentEdit'  :  
		  include("../../../../modules/bankPaymentEdit/admin/includes/bankPaymentEdit.php" );
		  break;
    case 'cashPaymentEdit'  :  
		  include("../../../../modules/cashPaymentEdit/admin/includes/cashPaymentEdit.php" );
		  break;
    case 'jvEdit'  :  
		  include("../../../../modules/jvEdit/admin/includes/jvEdit.php" );
		  break;
    case 'exportExcel'  :  
		  include("../../../../modules/exportExcel/admin/includes/exportExcel.php" );
		  break;
    case 'trialBalanceAjax'  :  
		  include("../../../../modules/trialBalanceAjax/admin/includes/trialBalanceView.php" );
		  break;
    case 'salesReturnItemWisePrint'  :  
		  include("../../../../modules/salesReturnItemWise/admin/includes/salesReturnItemWisePrint.php" );
		  break;
    case 'bankReceiptPrint'  :  
		  include("../../../../modules/bankReceipt/admin/includes/bankReceiptPrint.php" );
		  break;
    case 'cashPaymentPrint'  :  
		  include("../../../../modules/cashPayment/admin/includes/cashPaymentPrint.php" );
		  break;
    case 'bankPaymentPrint'  :  
		  include("../../../../modules/bankPayment/admin/includes/bankPaymentPrint.php" );
		  break;
    case 'cashReceiptPrint'  :  
		  include("../../../../modules/cashReceipt/admin/includes/cashReceiptPrint.php" );
		  break;
    case 'jvPrint'  :  
		  include("../../../../modules/journalVoucher/admin/includes/jvPrint.php" );
		  break;
    case 'cashPayment'  :  
		  include("../../../../modules/cashPayment/admin/includes/cashPaymentV.php" );
		  break;
    case 'cashReceipt'  :  
		  include("../../../../modules/cashReceipt/admin/includes/cashReceiptV.php" );
		  break;
    case 'bankPayment'  :  
		  include("../../../../modules/bankPayment/admin/includes/bankPaymentV.php" );
		  break;
	case 'bankReceipt'  :  
		  include("../../../../modules//bankReceipt/admin/includes/bankReceiptV.php" );
		  break;
    case 'openingStockEdit'  :  
		  include("../../../../modules/openingStockEdit/admin/includes/openingStockEdit.php" );
		  break;
    case 'customerSalesPaymentEdit'  :  
		  include("../../../../modules/customerSalesPaymentEdit/admin/includes/customerSalesPaymentEdit.php" );
		  break;
    case 'salesReturnItemWiseEdit'  :  
		  include("../../../../modules/salesReturnItemWiseEdit/admin/includes/salesReturnItemWiseEditView.php" );
		  break;
     case 'salesAreaSalesReportByCategoryAndSubCategory'  :  
		  include("../../../../modules/salesAreaSalesReportByCategoryAndSubCategory/admin/includes/salesAreaSalesReportByCategoryAndSubCategoryView.php" );
		  break;
    case 'salesReportByDateAndAllItem'  :  
		  include("../../../../modules/salesReportByDateAndAllItem/admin/includes/salesReportByDateAndAllItem.php" );
		  break;
    case 'salesReportByDateAndSubCategoryWise'  :  
		  include("../../../../modules/salesReportByDateAndSubCategoryWise/admin/includes/salesReportByDateAndSubCategoryWise.php" );
		  break;
    case 'salesReportByDateAndCategoryWise'  :  
		  include("../../../../modules/salesReportByDateAndCategoryWise/admin/includes/salesReportByDateAndCategoryWise.php" );
		  break;
    case 'salesReportByDateAndItemWise'  :  
		  include("../../../../modules/salesReportByDateAndItemWise/admin/includes/salesReportByDateAndItemWise.php" );
		  break;
	case 'openingStockReportInAllWarehouse'  :  
		  include("../../../../modules/openingStockReportInAllWarehouse/admin/includes/openingStockReportInAllWarehouse.php" );
		  break;
    case 'cashReceiptReportByVoucherno'  :  
		  include("../../../../modules/cashReceiptReportByVoucherno/admin/includes/cashReceiptReportByVouchernoView.php" );
		  break;
    case 'purchseReportSummarySubCategoryWise'  :  
		  include("../../../../modules/purchseReportSummarySubCategoryWise/admin/includes/purchseReportSummarySubCategoryWiseView.php" );
		  break;
    case 'openingStockReport'  :  
		  include("../../../../modules/openingStockReport/admin/includes/openingStockReport.php" );
		  break;
    case 'purchseReportSummaryCategoryWise'  :  
		  include("../../../../modules/purchseReportSummaryCategoryWise/admin/includes/purchseReportSummaryCategoryWiseView.php" );
		  break;
    case 'purchseReportAllItem'  :  
		  include("../../../../modules/purchseReportAllItem/admin/includes/purchseReportAllItemView.php" );
		  break;
    case 'purchseReportBySubCategory'  :  
		  include("../../../../modules/purchseReportBySubCategory/admin/includes/purchseReportBySubCategoryView.php" );
		  break;
    case 'purchseReportByCategory'  :  
		  include("../../../../modules/purchseReportByCategory/admin/includes/purchseReportByCategoryView.php" );
		  break;
    case 'localPurchseReportItemWise'  :  
		  include("../../../../modules/localPurchseReportItemWise/admin/includes/localPurchseReportItemWiseView.php" );
		  break;
    case 'stockReturnEdit'  :  
		  include("../../../../modules/stockReturnEdit/admin/includes/stockReturnEdit.php" );
		  break;
    case 'stockTransitReportByItemWise'  :  
		  include("../../../../modules/stockTransitReportByItemWise/admin/includes/stockTransitReportByItemWise.php" );
		  break;
    case 'localPurchaseEdit'  :  
		  include("../../../../modules/localPurchaseEdit/admin/includes/localPurchaseEdit.php" );
		  break;
    case 'totalStockAndNetweightReportByDate'  :  
		  include("../../../../modules/totalStockAndNetweightReportByDate/admin/includes/totalStockAndNetweightReportByDate.php" );
		  break;
    case 'transferReportByDate'  :  
		  include("../../../../modules/transferReportByDate/admin/includes/transferReportByDate.php" );
		  break;
    case 'salesInvoiceThermalPrint'  :  
		  include("../../../../modules/salesInvoice/admin/includes/salesInvoiceThermalPrint.php" );
		  break;
    case 'dailyReportByWarehouseWise'  :  
		  include("../../../../modules/dailyReportByWarehouseWise/admin/includes/dailyReportByWarehouseWise.php" );
		  break;
    case 'salesAreaSalesReportByDateWise'  :  
		  include("../../../../modules/salesAreaSalesReportByDateWise/admin/includes/salesAreaSalesReportByDateWise.php" );
		  break;
    case 'branchTransferDetailsPrint'  :  
		  include("../../../../modules/stockTransferConfirmPrint/admin/includes/branchTransferDetailsPrint.php" );
		  break;
     case 'stockTransferConfirmPrint'  :  
		  include("../../../../modules/stockTransferConfirmPrint/admin/includes/stockTransferConfirmPrint.php" );
		  break;
    case 'stockTransferEdit'  :  
		  include("../../../../modules/stockTransferEdit/admin/includes/stockTransferEdit.php" );
		  break;
    case 'stockRequestLIstWarehouse'  :  
		  include("../../../../modules/stockRequestLIstWarehouse/admin/includes/stockRequestLIstWarehouse.php" );
		  break;
    case 'stockRequestPrint'  :  
		  include("../../../../modules/stockRequest/admin/includes/stockRequestPrint.php" );
		  break;
    case 'stockRequest'  :  
		  include("../../../../modules/stockRequest/admin/includes/stockRequest.php" );
		  break;
    case 'salesReportsBySalesAreaWise'  :  
		  include("../../../../modules/salesReportsBySalesAreaWise/admin/includes/salesReportsBySalesAreaWise.php" );
		  break;
	case 'itemTrackingReportByDate'  :  
		  include("../../../../modules/itemTrackingReportByDate/admin/includes/itemTrackingReportByDate.php" );
		  break;
    case 'totalStockReportBranchByExpiryDate'  :  
		  include("../../../../modules/totalStockReportBranchByExpiryDate/admin/includes/totalStockReportBranchByExpiryDateView.php" );
		  break;
    case 'totalStockReportByExpiryDate'  :  
		  include("../../../../modules/totalStockReportByExpieryDate/admin/includes/totalStockReportByExpieryDateView.php" );
		  break;
    case 'totalStockReportBranchByDate'  :  
		  include("../../../../modules/totalStockReportBranchByDate/admin/includes/totalStockReportBranchByDateView.php" );
		  break;
    case 'salesReportByMainBranchWise'  :  
		  include("../../../../modules/salesReportByMainBranchWise/admin/includes/salesReportByMainBranchWise.php" );
		  break;
    case 'salesReportByBranch'  :  
		  include("../../../../modules/salesReportByBranch/admin/includes/salesReportByBranch.php" );
		  break;
    case 'openingStockForItem'  :  
		  include("../../../../modules/openingStockForItem/admin/includes/openingStockForItem.php" );
		  break;
    case 'totalStockReportByDate'  :  
		  include("../../../../modules/totalStockReportByDate/admin/includes/totalStockReportByDateView.php" );
		  break;
    case 'openingBalanceFoeVendor'  :  
		  include("../../../../modules/openingBalanceFoeVendor/admin/includes/openingBalanceFoeVendor.php" );
		  break;
    case 'stockTransferSearchByTransferNumber'  :  
		  include("../../../../modules/stockTransferSearchByTransferNumber/admin/includes/stockTransferSearchByTransferNumberView.php" );
		  break;
    case 'stockReturnSearchByReturnNo'  :  
		  include("../../../../modules/stockReturnSearchByReturnNo/admin/includes/stockReturnSearchByReturnNoView.php" );
		  break;
    case 'totalStockReportWithOutExpiry'  :  
		  include("../../../../modules/totalStockReportWithOutExpiry/admin/includes/totalStockReportWithOutExpiry.php" );
		  break;
    case 'itemTrackingReport'  :  
		  include("../../../../modules/itemTrackingReport/admin/includes/itemTrackingReport.php" );
		  break;
    case 'importPurchaseSearchByInvoiceNo'  :  
		  include("../../../../modules/importPurchaseSearchByInvoiceNo/admin/includes/importPurchaseSearchByInvoiceNoView.php" );
		  break;
    case 'vendorReportPrint'  :  
		  include("../../../../modules/vendorReport/admin/includes/vendorReportPrint.php" );
		  break;
    case 'importPurchaseOrder'  :  
		  include("../../../../modules/importPurchaseOrder/admin/includes/importPurchaseOrder.php" );
		  break;
    case 'importPurchasePrint'  :  
		  include("../../../../modules/importPurchase/admin/includes/importPurchasePrint.php" );
		  break;
    case 'purchaseLocalinvoiceSearchByInvoiceNo'  :  
		  include("../../../../modules/purchaseLocalinvoiceSearchByInvoiceNo/admin/includes/purchaseLocalinvoiceSearchByInvoiceNoView.php" );
		  break;
    case 'localPurchaseOrder'  :  
		  include("../../../../modules/localPurchaseOrder/admin/includes/localPurchaseOrder.php" );
		  break;
    case 'stockTransitReportByDate'  :  
		  include("../../../../modules/stockTransitReportByDate/admin/includes/stockTransitReportByDateV.php" );
		  break;
    case 'openingBalanceFoeSalesareaCustomer'  :  
		  include("../../../../modules/openingBalanceFoeSalesareaCustomer/admin/includes/openingBalanceFoeSalesareaCustomer.php" );
		  break;
    case 'customersalespaymentPrint'  :  
		  include("../../../../modules/cashReceiptPrint/admin/includes/cashReceiptPrint.php" );
		  break;
    case 'branchWiseCustomerStatementReport'  :  
		  include("../../../../modules/branchWiseCustomerStatementReport/admin/includes/branchWiseCustomerStatementReport.php" );
		  break;
    case 'stockReturnReportByDate'  :  
		  include("../../../../modules/stockReturnReportByDate/admin/includes/stockReturnReportByDateView.php" );
		  break;
    case 'cashReceiptReportByDate'  :  
		  include("../../../../modules/cashReceiptReportByDate/admin/includes/cashReceiptReportByDateView.php" );
		  break;
    case 'salesReportByDateWise'  :  
		  include("../../../../modules/salesReportByDateWise/admin/includes/salesReportByDateWise.php" );
		  break;
    case 'stockReturnBySalesAreaPrint'  :  
		  include("../../../../modules/stockReturnBySalesArea/admin/includes/stockReturnBySalesAreaPrint.php" );
		  break;
    case 'salesAreaOutStandinReport'  :  
		  include("../../../../modules/salesAreaOutStandinReport/admin/includes/salesAreaOutStandinReport.php" );
		  break;
    case 'totalStockReport'  :  
		  include("../../../../modules/totalStockReport/admin/includes/totalStockReportView.php" );
		  break;
    case 'salesAreaSalesReport'  :  
		  include("../../../../modules/salesAreaSalesReport/admin/includes/salesAreaSalesReportV.php" );
		  break;
    case 'stockReturnBySalesArea'  :  
		  include("../../../../modules/stockReturnBySalesArea/admin/includes/stockReturnBySalesAreaView.php" );
		  break;
   case 'salesDetailsReport'  :  
		  include("../../../../modules/generalSalesReport/admin/includes/salesDetailsReport.php" );
		  break;
   case 'localVendorPurchaseReport'  :  
		  include("../../../../modules/localVendorPurchaseReport/admin/includes/localVendorPurchaseReport.php" );
		  break;
   case 'localPurchaseReport'  :  
		  include("../../../../modules/localPurchaseReport/admin/includes/localPurchaseReport.php" );
		  break;
   case 'importPurchaseReport'  :  
		  include("../../../../modules/importPurchaseReport/admin/includes/importPurchaseReport.php" );
		  break;
   case 'stockReportByCountryWise'  :  
		  include("../../../../modules/stockReportByCountryWise/admin/includes/stockReportByCountryWise.php" );
		  break;
   case 'branchTransferDetails':
		include( "../../../../modules/stockTransferConfirm/admin/includes/branchTransferDetails.php");
		break;
   case 'addOpeningStock':
		include( "../../../../modules/addOpeningStock/admin/includes/addOpeningBalanceView.php");
		break;
    case 'stockTransferConfirm':
		include( "../../../../modules/stockTransferConfirm/admin/includes/stockTransferConfirm.php");
		break;
    case 'thirdLevelAccountHead':
		include( "../../../../modules/thirdLevelAccountHead/admin/includes/thirdLevelAccountHead.php");
		break;
    case 'secondaryLevelAccountHead':
		include( "../../../../modules/secondaryLevelAccountHead/admin/includes/secondaryLevelAccountHead.php");
		break;
    case 'primaryAccountHead':
		include( "../../../../modules/primaryAccountHead/admin/includes/primaryAccountHead.php");
		break;
    case 'storeImportPurchase':
		include( "../../../../modules/storeImportPurchase/admin/includes/storeImportPurchaseV.php");
		break;
    case 'importPurchaseEdit':
		include( "../../../../modules/importPurchase/admin/includes/importPurchaseEdit.php");
		break;
    case 'addCountry':
		include( "../../../../modules/addCountry/admin/includes/addCountry.php");
		break;
    case 'addSubCategory':
		include( "../../../../modules/addSubCategory/admin/includes/addSubCategory.php");
		break;
    case 'importPurchase':
		include( "../../../../modules/importPurchase/admin/includes/importPurchaseV.php");
		break;
    case 'vansalePrint':
		include( "../../../../modules/salesInvoiceThermal/admin/includes/vansalePrint.php");
		break;
    case 'vansaleInvoiceSearch':
		include( "../../../../modules/invoiceSearchByInvoiceNoForBarcode/admin/includes/invoiceSearchByInvoiceNoForBarcode.php");
		break;
    case 'salesInvoiceThermal':
		include( "../../../../modules/salesInvoiceThermal/admin/includes/salesInvoiceThermalView.php");
		break;
    case 'seperateAllData':
		include( "../../../../modules/seperateAllData/admin/includes/seperateAllData.php");
		break;
    case 'searchSeperateInvoice':
		include( "../../../../modules/seperateInvoice/admin/includes/searchSeperateInvoice.php");
		break;
    case 'seperateDeliveryNotePrint':
		include( "../../../../modules/seperateDeliveryNote/admin/includes/seperateDeliveryNotePrint.php");
		break;
	case 'seperateDeliveryNote':
		include( "../../../../modules/seperateDeliveryNote/admin/includes/seperateDeliveryNote.php");
		break;
    case 'seperateInvoicePrint':
		include( "../../../../modules/seperateInvoice/admin/includes/seperateInvoicePrint.php");
		break;
    case 'seperateInvoice':
		include( "../../../../modules/seperateInvoice/admin/includes/seperateInvoiceView.php");
		break;
    case 'seperateQuotationViewPrint':
		include( "../../../../modules/seperateQuotation/admin/includes/seperateQuotationViewPrint.php");
		break;
	case 'seperateQuotationEdit':
		include( "../../../../modules/seperateQuotationEdit/admin/includes/seperateQuotationEdit.php");
		break;
    case 'seperateQuotation':
		include( "../../../../modules/seperateQuotation/admin/includes/seperateQuotationView.php");
		break;
    case 'addToStockPurchase':
		include( "../../../../modules/purchase/admin/includes/addToStockPurchase.php" );
		break;
    case 'editDiscount':
		include( "../../../../modules/discount/admin/includes/editDiscount.php" );
		break;
    case 'discount':
		include( "../../../../modules/discount/admin/includes/discount.php" );
		break;
    case 'branchTransferPrint':
		include( "../../../../modules/branchTransfer/admin/includes/branchTransferPrint.php" );
		break;
    case 'customerStatementReport':
		include( "../../../../modules/customerStatementReport/admin/includes/customerStatementReport.php" );
		break;
    case 'branchTransferConfirm':
		include( "../../../../modules/branchTransferConfirm/admin/includes/branchTransferConfirmView.php" );
		break;
    case 'branchTransfer':
		include( "../../../../modules/branchTransfer/admin/includes/branchTransfer.php" );
		break;
    case 'fileUp':
		include( "../../../../modules/victoryschoolsXlInsert/admin/view/index.php" );
		break;
    case 'editBranch':
		include( "../../../../modules/branch/admin/includes/editBranch.php" );
		break;
    case 'branch':
		include( "../../../../modules/branch/admin/includes/branch.php" );
		break;
    case 'availabilityChecking':
		include( "../../../../modules/availabilityChecking/admin/includes/availabilityCheckingView.php" );
		break;
    case 'transferDetails':
		include( "../../../../modules/transferDetails/admin/includes/transferDetails.php" );
		break;
    case 'salaryDetails':
		include( "../../../../modules/salarySheetReport/admin/includes/salaryDetails.php" );
		break;
    case 'balanceAmountReportByVendor':
		include( "../../../../modules/balanceAmountReportByVendor/admin/includes/balanceAmountReportByVendor.php" );
		break;
    case 'openingStockCostPrice':
		include( "../../../../modules/openingStockCostPrice/admin/includes/openingStockCostPrice.php" );
		break;
	case 'JournalVoucherCancelView':
		include( "../../../../modules/journalVoucherCancel/admin/includes/JournalVoucherCancelView.php" );
		break;
    case 'additionalDetailsView':
		include( "../../../../modules/deliveryNoteAdditionalDetailsReport/admin/includes/additionalDetailsView.php" );
		break;
    case 'openingBalanceEditView':
		include( "../../../../modules/openingBalanceEdit/admin/views/openingBalanceEditView.php" );
		break;
	case 'deliveryNoteAdditionalDetailsReport':
		include( "../../../../modules/deliveryNoteAdditionalDetailsReport/admin/includes/deliveryNoteAdditionalDetailsReport.php" );
		break;
	case 'Print_invoiceCreditNote':
		include( "../../../../modules/invoiceCreditNote/admin/views/Print_invoiceCreditNote.php" );
		break;
	case 'invoiceCreditNoteSearch':
		include( "../../../../modules/invoiceCreditNoteSearch/admin/views/invoiceCreditNoteSearch.php" );
		break;
	case 'invoiceCreditNote':
		include( "../../../../modules/invoiceCreditNote/admin/views/invoiceCreditNote.php" );
		break;
	case 'salesReturnReportByCustomer':
		include( "../../../../modules/salesReturnReportByCustomer/admin/includes/salesReturnReportByCustomer.php" );
		break;
    case 'advanceAmountReport':
		include( "../../../../modules/advanceAmountReport/admin/includes/advanceAmountReport.php" );
		break;
    case 'localInvoiceEdit':
		include( "../../../../modules/localSalesInvoiceEdit/admin/includes/localInvoiceEdit.php" );
		break;
    case 'salarySheetReport':
		include( "../../../../modules/salarySheetReport/admin/includes/salarySheetReport.php" );
		break;
    case 'timeSheet':
		include( "../../../../modules/timeSheet/admin/includes/timeSheet.php" );
		break;
    case 'advancePaymentView':
		include( "../../../../modules/advancePayment/admin/includes/advancePaymentView.php" );
		break;
    case 'staffSalesReport':
		include( "../../../../modules/staffSalesReport/admin/includes/staffSalesReport.php" );
		break;
    case 'purchaseAndSalesReportByItem':
		include( "../../../../modules/purchaseAndSalesReportByItem/admin/includes/purchaseAndSalesReportByItem.php" );
		break;
    case 'clientQuotationSearchByQuotationNo':
		include( "../../../../modules/clientQuotationSearchByQuotationNo/admin/includes/clientQuotationSearchByQuotationNo.php" );
		break;
    case 'clientQuotation':
		include( "../../../../modules/clientQuoation/admin/includes/clientQuotation.php" );
		break;
    case 'localInvoiceSearchByInvoiceNo':
		include( "../../../../modules/localinvoiceSearchByInvoiceNo/admin/includes/localInvoiceSearchByInvoiceNo.php" );
		break;
	case 'stockReportByDateView':
		include( "../../../../modules/stockReportByDate/admin/includes/stockReportByDateView.php" );
		break;
    case 'creditNote':
		include( "../../../../modules/creditNote/admin/includes/creditNote.php" );
		break;
    case 'debitNote':
		include( "../../../../modules/debitNote/admin/includes/debitNote.php" );
		break;
    case 'purchaseOrderPrint':
		include( "../../../../modules/purchaseOrder/admin/includes/purchaseOrderPrint.php" );
		break;
    case 'PurchaseOrderReport':
		include( "../../../../modules/PurchaseOrderReport/admin/includes/PurchaseOrderReport.php" );
		break;
		
    case 'stockSearchBySection':
		include( "../../../../modules/stockSearchBySection/admin/includes/stockSearchBySection.php" );
		break;
		
    case 'stockSearchByCategory':
		include( "../../../../modules//stockSearchByCategory/admin/includes/stockSearchByCategory.php" );
		break;
    
    case 'LocalInvoicePrint':
		include( "../../../../modules/localSalesInvoice/admin/includes/LocalInvoicePrint.php" );
		break;
    case 'salesReportByEmployeeWise':
		include( "../../../../modules/salesReportByEmployeeWise/admin/includes/salesReportByEmployeeWise.php" );
		break;
    case 'generalPurchaseReport':
		include( "../../../../modules/generalPurchaseReport/admin/includes/journelPurchaseReportSearch.php" );
		break;
	case 'salesReportByItem':
		include( "../../../../modules/salesReportByItem/admin/includes/salesReportByItem.php" );
		break;
	case 'localSalesInvoice':
		include( "../../../../modules/localSalesInvoice/admin/includes/localSalesInvoice.php" );
		break;
	case 'salesReportByVessel':
		include( "../../../../modules/salesReportByVessel/admin/includes/salesReportByVessel.php" );
		break;
    case 'salesReturnReport':
		include( "../../../../modules/salesReturnReport/admin/includes/salesReturnReport.php" );
		break;
	 case 'salesReturnItemDetails':
		include( "../../../../modules/salesReturnReport/admin/includes/salesReturnItemDetails.php" );
		break;
	case 'invoiceEdit':
		include( "../../../../modules/invoiceEdit/admin/includes/invoiceEdit.php" );
		break;
		
	case 'stockEditView':
		include( "../../../../modules/stockEdit/admin/includes/stockEditView.php" );
		break;
	case 'salesVatReport':
		include( "../../../../modules/salesVatReport/admin/includes/salesVatReport.php" );
		break;
	case 'salesReturnView':
		include( "../../../../modules/salesReturn/admin/includes/salesReturnView.php" );
		break;
	case 'purchaseVatReport':
		include( "../../../../modules/purchaseVatReport/admin/includes/purchaseVatReport.php" );
		break;
		
	case 'deliveryNoteSearch':
		include( "../../../../modules/deliveryNoteSearch/admin/includes/deliveryNoteSearch.php" );
		break;
	case 'editDeliveryNote':
		include( "../../../../modules/deliveryNode/admin/includes/editDeliveryNote.php" );
		break;
		
	case 'paymentVouchers':
		include( "../../../../modules/paymentVouchers/admin/includes/paymentVouchers.php" );
		break;
	case 'receiptVouchers':
		include( "../../../../modules/receiptVouchers/admin/includes/receiptVouchers.php" );
		break;
	 case 'printDeliveryNote':
		include( "../../../../modules/deliveryNode/admin/includes/printDeliveryNote.php" );
		break;
	 case 'salesReportByCustomerWise':
		include( "../../../../modules/salesReportByCustomerWise/admin/includes/salesReportByCustomerWise.php" );
		break;
	case 'customerPaymentDetailsView':
		include( "../../../../modules/salesReportByCustomerWise/admin/includes/customerPaymentDetailsView.php" );
		break;
		
	case 'purchaseReturnReportByVendor':
		include( "../../../../modules/purchaseReturnReportByVendor/admin/includes/purchaseReturnReportByVendor.php" );
		break;
	
	case 'addVessel':
		include( "../../../../modules/addVessel/admin/includes/addVessel.php" );
		break;
	case 'editVessel':
		include( "../../../../modules/addVessel/admin/includes/editVessel.php" );
		break;
	case 'purchaseOrder':
		include( "../../../../modules/purchaseOrder/admin/includes/purchaseOrder.php" );
		break;
	case 'updateItemDetails':
		include( "../../../../modules/itemMaster/admin/includes/updateItemDetails.php" );
		break;
	case 'generalPurchaseReport':
		include( "../../../../modules/generalPurchaseReport/admin/includes/generalPurchaseReport.php" );
		break;
	case 'deliveryNodeView':
		include( "../../../../modules/deliveryNode/admin/includes/deliveryNodeView.php" );
		break;
	case 'itemMasterList':
		include( "../../../../modules/itemMasterEdit/admin/includes/itemMasterList.php" );
		break;
	case 'itemMasterEdit':
		include( "../../../../modules/itemMasterEdit/admin/includes/itemMasterEdit.php" );
		break;	
    case 'addUnit':
		include( "../../../../modules/addUnit/admin/includes/addUnit.php" );
		break;
	case 'editUnit':
		include( "../../../../modules/addUnit/admin/includes/editUnit.php" );
		break;
	case 'addCurrency':
		include( "../../../../modules/addCurrency/admin/includes/addCurrency.php" );
		break;
	case 'editCurrency':
		include( "../../../../modules/addCurrency/admin/includes/editCurrency.php" );
		break;	
	case 'addCustomerItem':
		include( "../../../../modules/addCustomerItem/admin/includes/addCustomerItem.php" );
		break;
	case 'customerItemsEdit':
		include( "../../../../modules/addCustomerItem/admin/includes/customerItemsEdit.php" );
		break;
		
	case 'addCategory':
		include( "../../../../modules/addCategory/admin/includes/addCategory.php" );
		break;
	case 'addBrand':
		include( "../../../../modules/addBrand/admin/includes/addBrand.php" );
		break;
	case 'addBrandUpdate':
		include( "../../../../modules/addBrand/admin/includes/addBrandUpdate.php" );
		break;
	case 'addCategoryUpdate':
		include( "../../../../modules/addCategory/admin/includes/addCategoryUpdate.php" );
		break;
	case 'itemMaster':
		include( "../../../../modules/itemMaster/admin/includes/itemMaster.php" );
		break;
		
	case 'editPurchaseItem':
		include( "../../../../modules/purchaseEdit/admin/includes/editPurchaseItem.php" );
		break;
	case 'purchaseDetailsView':
		include( "../../../../modules/purchaseDetails/admin/includes/purchaseDetailsView.php" );
		break;
	case 'generalSalesReport':
		include( "../../../../modules/generalSalesReport/admin/includes/generalSalesReport.php" );
		break;
	case 'invoicePrintByInvoiceNo':
		include( "../../../../modules/salesInvoice/admin/includes/invoicePrintByInvoiceNo.php" );
		break;
    case 'salesInvoicePrint':
		include( "../../../../modules/salesInvoice/admin/includes/salesInvoicePrint.php" );
		break;
	case 'printCustomerSalesPayment':
		include( "../../../../modules/customerSalaesPayment/admin/includes/printCustomerSalesPayment.php" );
		break;
	case 'discountEdit':
		include( "../../../../modules/discountEdit/admin/includes/discountEdit.php" );
		break;
	case 'payementReportByDate':
		include( "../../../../modules/payementReportByDate/admin/includes/payementReportByDate.php" );
		break;
	case 'salesmanWiseReport':
		include( "../../../../modules/salesmanWiseReport/admin/includes/salesmanWiseReportView.php" );
		break;
	case 'payementReport':
		include( "../../../../modules/payementReport/admin/includes/paymentInvoiceReportView.php" );
		break;
     case 'advanceAmount':
		include( "../../../../modules/advanceAmount/admin/includes/advanceAmount.php" );
		break;
	case 'editQuotation':
		include( "../../../../modules/editQuotation/admin/includes/quotationEdit.php" );
		break;
	case 'quotationSearchByQuotationNo':
		include( "../../../../modules/quotationSearchByQuotationNo/admin/includes/quotationSearchByQuotationNo.php" );
		break;
	case 'invoiceSearchByInvoiceNo':
		include( "../../../../modules/invoiceSearchByInvoiceNo/admin/includes/invoiceSearchByInvoiceNo.php" );
		break;
	case 'quotationSearchByDate':
		include( "../../../../modules/quotationSearchByDate/admin/includes/quotationSearchByDateView.php" );
		break;
	case 'quotationSearchByDate_Print':
		include( "../../../../modules/quotationSearchByDate/admin/includes/quotationSearchByDate_Print.php" );
		break;
	case 'quotationPrintByQuotationNo':
		include( "../../../../modules/quotationNew/admin/includes/quotationPrintByQuotationNo.php" );
		break;
    case 'addUsers':
		include( "../../../../modules/settings/admin/includes/addUsers.php" );
		break;
	case 'customerSalaesPayment':
		include( "../../../../modules/customerSalaesPayment/admin/includes/customerSalesPayment.php" );
		break;
	case 'salesInvoice':
		include( "../../../../modules/salesInvoice/admin/includes/salesInvoice.php" );
		break;
	case 'editVendorDetails':
		include("../../../../modules/vendor/admin/includes/editVendorDetails.php");
		break;
	case 'invoiceSearchByDateView':
		include("../../../../modules/invoiceSearchByDate/admin/includes/invoiceSearchByDateView.php");
		break;
	case 'invoiceSearchByDate_print':
		include("../../../../modules/invoiceSearchByDate/admin/includes/invoiceSearchByDate_print.php");
		break;
	case 'salesModelView':
         include("../../../../modules/salesModel/admin/views/salesModelView.php");
         break;
	case 'salesModelEditView':
         include("../../../../modules/salesModel/admin/views/salesModelEditView.php");
         break;
	case 'addVendor':
		include("../../../../modules/vendor/admin/includes/addVendor.php");
		break;
	case 'addUsers':
		include("../../../../modules/settings/admin/includes/addUsers.php");
		break;
	case 'resetPassword':
		include("../../../../modules/settings/admin/includes/resetPassword.php" );
		break;
	case 'resetPasswordForAll':
		include("../../../../modules/settings/admin/includes/resetPasswordForAll.php" );
		break;
	case 'addPurchaseItem':
				include("../../../../modules/purchase/admin/includes/addPurchaseItem.php" );
		        break;
	case 'home'  :  
		        include("../../../../modules/home/admin/includes/home.php" );
		        break;
	case 'addMaterialsView':  
		        include("../../../../modules/addMaterials/admin/includes/addMaterialsView.php" );
		        break;
	case 'materialsEdit'  :  
		      include("../../../../modules/addMaterials/admin/includes/materialsEdit.php" );
		        break;	        
	case 'assignJobType'  :  
		        include("../../../../modules/assignJobType/admin/includes/assignJobType.php" );
		        break;
	case 'viewDetails_assignJobType'  :  
		        include("../../../../modules/assignJobType/admin/includes/viewDetails_assignJobType.php" );
		        break;	
	case 'edit_assignJobType'  :  
		        include("../../../../modules/assignJobType/admin/includes/edit_assignJobType.php");
		        break;
	case 'confirmStock'  :  
		    	include("../../../../modules/confirmStock/admin/includes/confirmStock.php");
		   		break;
	case 'quotationConfirmationView'  :  
		    	include("../../../../modules/quotationConfirmation/admin/includes/quotationConfirmationView.php");
		   		break;
	case 'estimate':  
		        include( "../../../../modules/estimate/admin/includes/estimate.php" );
		        break;
	case 'addRegCusName':  
		        include( "../../../../modules/regularCustomer/admin/includes/addRegCusName.php" );
		        break;
	case 'editRegCusName':  
		        include( "../../../../modules/regularCustomer/admin/includes/editRegCusName.php" );
		        break;	        
	case 'quotation'  :  
		        include( "../../../../modules/quotationNew/admin/includes/quotation.php" );
		        break;	
	case 'addSalesman'  :  
		        include( "../../../../modules/salesman/admin/includes/addSalesman.php" );
		        break;
	case 'editSalesman'  :  
		        include( "../../../../modules/salesman/admin/includes/editSalesman.php" );
		        break;
	case 'estimateQuotationReport'  :  
		    	include("../../../../modules/estimateQuotationReport/admin/includes/estimateQuotationReport.php");
			break;
	case 'updateJobProgress'  :  
		        include("../../../../modules/jobProgress/admin/includes/updateJobProgress.php" );
		        break;
	case 'workProgressSearchView'  :  
		        include("../../../../modules/workProgressSearch/admin/includes/workProgressSearchView.php" );
		        break;
	case 'estimateReportViewDetails'  :  
		        include("../../../../modules/estimateQuotationReport/admin/includes/estimateReportViewDetails.php" );
		        break;
	case 'quotationReportViewDetails'  :  
		    	include("../../../../modules/estimateQuotationReport/admin/includes/quotationReportViewDetails.php");
			break;	
	case 'purchaseReturn'  :  
		    	include("../../../../modules/purchaseReturn/admin/includes/purchaseReturn.php");
			break;	
	case 'vendorPaymentView'  :  
		    	include("../../../../modules/vendorPayment/admin/includes/vendorPaymentView.php");
			break;	
	case 'customerBalancePayment'  :  
		    	include("../../../../modules/customerPayment/admin/includes/customerBalancePayment.php");
			break;
	case 'printCustomerBalancePayment'  :  
		    	include("../../../../modules/customerPayment/admin/includes/printCustomerBalancePayment.php");
			break;	
	case 'customerOrSalesReport'  :  
		    	include("../../../../modules/customerOrSalesReport/admin/includes/customerOrSalesReport.php");
			break;
	case 'quotationCancelView'  :  
		    	include("../../../../modules/quotationConfirmation/admin/includes/quotationCancelView.php");
			break;	
	case 'vendorReport'  :  
		    	include("../../../../modules/vendorReport/admin/includes/vendorReport.php");
			break;
	case 'vendorPaymentDetailsView'  :  
		    	include("../../../../modules/vendorReport/admin/includes/vendorPaymentDetailsView.php");
			break;
	case 'stockSearchView'  :  
		    	include("../../../../modules/stockSearch/admin/includes/stockSearchView.php");
			break;	
	case 'purchasePrint'  :  
		    	include("../../../../modules/purchase/admin/includes/purchasePrint.php");
			break;		
	case 'estimatePrint'  :  
		    	include("../../../../modules/estimate/admin/includes/estimatePrint.php");
			break;	
	case 'quotationPrint'  :  
		    	include("../../../../modules/quotation/admin/includes/quotationPrint.php");
			break;	
	case 'customerQuotationPaymentReport'  :  
		    include("../../../../modules/customerQuotationPaymentReport/admin/includes/customerQuotationPaymentReport.php");
			break;	
	case 'invoiceSearch'  :  
		    	include("../../../../modules/invoiceSearch/admin/includes/invoiceSearch.php");
			break;	
	case 'printVendorPayment'  :  
		    	include("../../../../modules/vendorPayment/admin/includes/printVendorPayment.php");
			break;	
	case 'printQuotationInvoice'  :  
		    	include("../../../../modules/quotationConfirmation/admin/includes/printQuotationInvoice.php");
			break;	
	case 'logout'  :  
		        include( "../../../../modules/login/admin/includes/logout.php" );
		        break;	
        case 'materialStokDetails'  :  
		        include( "../../../../modules/quotation/admin/includes/materialStokDetails.php" );
		        break;
        case 'addEmployeeView'  :  
		        include( "../../../../modules/addEmployee/admin/includes/addEmployeeView.php" );
		        break;
        case 'editEmployeeView'  :  
		        include( "../../../../modules/addEmployee/admin/includes/editEmployeeView.php" );
		        break;
        case 'printQuotationInvoiceSave'  :  
		        include( "../../../../modules/quotationConfirmation/admin/includes/printQuotationInvoiceSave.php" );
		        break;
        case 'customerQuotationPaymentDetails'  :  
		      include("../../../../modules/customerQuotationPaymentReport/admin/includes/customerQuotationPaymentDetails.php" );
		        break;
        case 'purchaseReturnReport'  :  
		      include("../../../../modules/purchaseReturnReport/admin/includes/purchaseReturnReport.php" );
		        break;
       case 'purchaseReturnItemDetails'  :  
		      include("../../../../modules/purchaseReturnReport/admin/includes/purchaseReturnItemDetails.php" );
		        break;
        case 'estimateAdvancedSearch'  :  
		      include("../../../../modules/estimateAdvancedSearch/admin/includes/estimateAdvancedSearch.php" );
		        break;
        case 'quotationAdvancedSearch'  :  
		      include("../../../../modules/quotationAdvancedSearch/admin/includes/quotationAdvanceSearchView.php" );
		        break;
		case 'addAccountHeadView'  :  
		      include("../../../../modules/accountHead/admin/includes/addAccountHeadView.php" );
		        break;
		case 'subAccountheadView'  :  
		      include("../../../../modules/Subaccounthead/admin/includes/subAccountheadView.php" );
		        break;
		case 'journalVoucherPayment'  :  
		      include("../../../../modules/journalVoucher/admin/includes/journalVoucherPayment.php" );
		        break;
		case 'subAccounthead_editView'  :  
		      include("../../../../modules/Subaccounthead/admin/includes/subAccounthead_editView.php" );
		        break;
		case 'addAccountHeadUpdate'  :  
		      include("../../../../modules/accountHead/admin/includes/addAccountHeadUpdate.php" );
		        break;
		case 'JournelSearchView'  :  
		      include("../../../../modules/JournelSearch/admin/includes/JournelSearchView.php" );
		        break;
        case 'JournalVoucherPrint'  :  
		      include("../../../../modules/journalVoucherPrint/admin/includes/JournalVoucherPrint.php" );
		        break;
		case 'clientOtherPayment'  :  
		      include("../../../../modules/openingBalance/admin/includes/clientOtherPayment.php" );
		        break;
		case 'Ledger'  :  
		      include("../../../../modules/Ledger/admin/includes/accountDetailsView.php" );
		        break;
	    case 'ProfitLossReport'  :  
		      include("../../../../modules/profitLossReport/admin/includes/ProfitLossReport.php" );
		        break;
		case 'DayReport'  :  
		      include("../../../../modules/dayReport/admin/includes/dayReportView.php" );
		        break;
	    case 'balanceSheet'  :  
		      include("../../../../modules/balanceSheet/admin/includes/balanceSheet.php" );
		        break;
		case 'cashBook'  :  
		      include("../../../../modules/cashBook/admin/includes/cashBook.php" );
		        break;
		case 'trialBalanceView'  :  
		      include("../../../../modules/trialBalance/admin/includes/trialBalanceView.php" );
		        break;
		case 'journalVoucherUpdate'  :  
		      include("../../../../modules/JournelVoucherUpdate/admin/includes/journalVoucherUpdateView.php" );
		        break;
				
		case 'stockTransitReport'  :  
		      include("../../../../modules/stockTransitReport/admin/includes/stockTransitReportV.php" );
		        break;
				
		case 'storeImportPurchasePrint'  :  
		      include("../../../../modules/storeImportPurchase/admin/includes/storeImportPurchasePrint.php" );
		        break;
				
		case 'salesAreaItemWiseReport'  :  
		      include("../../../../modules/salesAreaItemWiseReport/admin/includes/salesAreaItemWiseReportV.php" );
		        break;
				
		case 'stockTransferWarehouseConfirmView'  :  
		      include("../../../../modules/stockTransferWarehouseConfirm/admin/includes/stockTransferWarehouseConfirmView.php" );
		        break;
				
		case 'salesReturnItemWise'  :  
		      include("../../../../modules/salesReturnItemWise/admin/includes/salesReturnItemWiseV.php");
		        break;
				
		default :  
		        include( "../../../../modules/home/admin/includes/home.php" );
		        break;	
	   }
