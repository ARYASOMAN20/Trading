<?php
require_once("../../../../libraries/class/utils.php");
require_once("../../../../modules/insertToLocalServer/admin/controllers/displayDataController.php");
require_once('../../../../modules/itemMaster/admin/controller/ItemMasterController.php');
require_once("../../../../settings/path.php");


$objPath          		= 	new Path();
$objUtils 	 			= 	new Utils();
$objCDispSyncData 		= 	new C_dispSyncData();
//$objItemMasterController=   new ItemMasterController();
$branchId = $_COOKIE['branchId'];
$itemMasterDetailsTable	= $objCDispSyncData->getItemMasterDetailsTable($branchId);	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


    <title>Sync Data</title>
</head>
<body>
    <!-- <div class="container">
        <div class="row" style="padding-top: 20px;">
            <div class="col-sm-12 col-md-12 col-lg-12" style="text-align: center;">
                <form action='welcome.php?page=insertToLocalServer' method="post">
                    <input name="syncData" type="submit" value="syncData" class="btn btn-success btn-sm">
                </form>
            </div>
        </div>
    </div> -->

    <!-- new -->

    <style>
select {
    font-size: 10px !important;
}
.form-control {
    height: 25px !important;
}
td, th {
	font-size: 13px !important;
}
.panel-heading {
    padding: 5px 15px !important;
}
.modal-dialog {
  
    margin: 30px auto;
}
.modal {
    position: fixed;
    margin-top: 0%;
}
table td ,table th {
	border:0.5px solid #e4e4da;
	border-collapse:collapse;
}
 td {
    padding: 0px 10px !important;
}
.modal{
	position: fixed;
	margin-top:10%;
}
.modal-footer {
    padding: 6px;
    text-align: right;
	}

body {padding-right: 0px !important;}

.btn-success {
    background-color: #00c4ff !important;
}

.submitBtn {
	background-color:#0c8473 !important;
}
.col-sm-12 .col-md-12 .col-lg-12
{
	margin-top: 3% !important;
}

.panel-heading {
    color: #31708f !important;
    background-color: #d9edf7 !important;
    border-color: #bce8f1 !important;
}
.panel-heading {
    padding: 10px 15px !important;
    border-bottom: 1px solid transparent !important;
    border-top-left-radius: 3px !important;
    border-top-right-radius: 3px !important;
}
.panel-info {
    border-color: #bce8f1;
}
.paginate_button{
	background: #d9edf7 !important;
	border-radius: 50px !important;
}
</style>
        
  <div class="col-sm-12 col-md-12 col-lg-12">
	<div class="panel panel-info">
		<div class="panel-heading" style="" >
			<table width="100%">
				<tr>
					<i class="fa fa-list-ul"></i> ITEM DETAILS
					
				
						<!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float:right;">Add </button> -->
                    <form action='welcome.php?page=insertToLocalServer' method="post">
                        <input name="syncData" type="submit" value="Sync Data" class="btn btn-info btn-sm" style="float:right;">
                    </form>
<!-- <form action="" method="POST" enctype="multipart/form-data" >  
<button name="insertStockTbl" class='btn btn-success' ><i class="fa fa-save"></i>&nbsp;Submi</button></form>
  <input type="file" class="form-control input-sm" name='importExcel' id="importExcel"  />
<button type="button" onclick='importExcelData()' name='importExcels' class='btn btn-success' ><i class="fa fa-save"></i>&nbsp;Submit</button></form>-->
				</tr>
			</table>
		</div>
		<div class="panel-body" >
			<table width="100%" border="0" cellpadding="0" id="table_id"  class="" style="font-size: 1px !important;">
						<thead style="background-color:#d0e8d2">
							<tr>
								<th width="5%"><b>NO</b></th>							
								<th width="13%"><b>BARCODE</b></th>
								<th width="25%"><b>ITEM NAME</b></th> 
								<th width="8%"><b>CATEGORY</b></th>
								<!-- <th width="12%"><b>SUBCATEGORY</b></th> -->
                                <th width="14%"><b>BASE UNIT</b></th>
								<th width="16%"><b>SELLING PRICE</b></th>
								<!-- <th width="5%"><b>EDIT</b></th>
								<th width="5%"><b>DELETE</b></th> -->
                                <th width="5%"><b>STOCK</b></th>
								<th width="14%"><b>EXPIRY DATE</b></th>
							</tr>
						</thead>	
						<tbody>
							<?php echo $itemMasterDetailsTable;?>
						
						</tbody>
			</table>			
			
            </div>
		</div>
	</div>
    <script src="../../../../modules/deliveryNode/admin/ajax/sweetAlert.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>

<script>

$(document).ready( function () {
	$.noConflict();
    $('#table_id').DataTable();
} );

</script>
</body>
</html>