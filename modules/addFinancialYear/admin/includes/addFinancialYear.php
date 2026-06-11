<?php 
require_once('../../../../modules/addFinancialYear/admin/controller/c_addFinancialYear.php');
$objaddFinancialYear = new c_addFinancialYear();
require_once("../../../../settings/path.php");
$objPath    = new Path();
$financialYear='';
$financialYear                  =   $objaddFinancialYear->listFinancialYear();	
if(isset($_POST['Save']))
{
		$fromDate=date("Y-m-d", strtotime($_POST['fromDate']));
		$toDate=date("Y-m-d", strtotime($_POST['toDate']));
     	$objaddFinancialYear->setFinancialYear($fromDate,$toDate);	
       $objPath->setHeader('addFinancialYear','Success','addFinancialYear');
}

		  
if(isset($_POST['submitEdit']))
{

	$financialId     =$_POST['financialId'];
	$fromDate=date("Y-m-d", strtotime($_POST['fromDateEdit']));
		$toDate=date("Y-m-d", strtotime($_POST['toDateEdit']));

	$update_Brand=$objaddFinancialYear->update_List($financialId,$fromDate,$toDate);
	 $objPath->setHeader('addFinancialYear','Success','addFinancialYear');

}	

?>
    <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-list-ul"></i> <strong>FINANCIAL YEAR</strong>
        </div>
        <div class="panel-body" >  
						<table  border="0" cellpadding="0" id="example1"  class="table  table-striped" >        			
							<thead style="background-color:#d0e8d2">
        						<tr class="contentForFont">
                			<th width="5%">#</th>
							<th width="25%">From Date</th>
							<th width="25%">To Date</th>
                 			
                	 		<th width="8%">Update</th>
							
               			</tr>
                 	</thead>
                    <tbody>
							<?php
	                            echo $financialYear;
						   
							?>
    						</td>
     					</tr>
                    </tbody>
				</table>
			</div>
      	</div>
    </div>

	


<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Add Financial Year</h4>
      </div>
      <div class="modal-body">
	  	<form name="form1" method="post" action="">
			
				<div class="form-group">
				<label>From Date</label><strong class="forMandatory">*</strong>:
						<input type="text" name="fromDate" id="fromDate" required="required" autocomplete="off" class="form-control  input-sm datepicker" placeholder="From Date">
					
				</div>
				<div class="form-group">
						<label>To Date</label> <strong class="forMandatory">*</strong>:
						<input type="text" name="toDate" id="toDate" required="required" autocomplete="off" class="form-control  input-sm datepicker" placeholder="To Date">
					</div>
					
									
            		<div class="form-group" style="margin-top: 18px;"><center>
						<button type="submit" id="search"  name="Save"  class="btn btn-success" title="search" style="">
							<i class="fa fa-save">Save</i> 
						</button></center>
						
					</div>
			</form> 	
			   </div>
      
    </div>

  </div>
</div>

	
 <div id="brandModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit Financial Year</h4>
      </div>
      <div class="modal-body fetched-data" >
			<form name="form1" method="post" action="">
			   <input type="hidden" name="financialId" id="financialId"  >
			    <div class="form-group">
                	<label for="brandCode">From Date :</label>
                   <input type='text' name='fromDateEdit' id='fromDateEdit' placeholder="TO DATE" 
						class='input-sm datepicker' required style="width:97%" autocomplete="OFF">
                </div>
				<div class="form-group">
                	<label for="brandName">To Date :</label><span style="color:red;" class="mandatory">*</span>
                 	<input type='text' name='toDateEdit' id='toDateEdit' placeholder="TO DATE" 
						class='input-sm datepicker' required style="width:97%" autocomplete="OFF"> 
                </div>
            	
                <div class="form-group">
                	<center>
               			<button type="submit" name="submitEdit" value="submit" class="btn btn-primary">
                        	<i class="fa fa-plus"></i> update
                        </button>
           		 	</center>
             	</div>
			</form> 
				
				
			</div>
			
		</div>
	</div>
	
</div>
		

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript"  src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">


<script type="text/javascript">
function getData(rowid){
		
        $.ajax({
            type : 'post',
            url : '../../../../modules/addFinancialYear/admin/ajax/getDATAs.php', 
            data :  'rowid='+ rowid,
            dataType:'JSON',			//Pass $id
            success : function(data){
            $('#financialId').val(data.financialYearId);
			 $('#fromDateEdit').val(data.fromDate);
			 $('#toDateEdit').val(data.toDate);
			
            }
        });
}

$(document).ready( function () {
	$.noConflict();
    $('#example1').DataTable({
		"dom": '<"toolbar">frltip',
		'aoColumnDefs': [{'bSortable': false,'aTargets':[0]}]
		

		 
	});
   $("div.toolbar").html('<button type="button" style="float:right" class="btn btn-info" data-toggle="modal" data-target="#myModal">&nbsp; ADD</button>');

 } );
 

</script>


<style>
.dataTables_filter {
   float: left !important;
}
.dataTables_filter{margin-right: 62px;}

#table_id_paginate .paginate_button current{
	background-color:#000 !important;
}

#table_id_length{
	 margin-left:10%;
}

table.dataTable thead th {
    border-bottom: 0px solid #111;
}
 
table.dataTable tfoot td {
    border-top: 0px solid  #111;
}

table td ,table th {
	border:0.5px solid #e4e4da;
	border-collapse:collapse;
}

.paginate_button{
	background: #d9edf7 !important;
    border-radius: 50px !important;
	
}


form{
	margin-bottom:0px !important;}
	
#table_id th , #table_id td {
	font-size:13px !important;
}
#table_id td {
	padding : 2px !important;
}

</style>
