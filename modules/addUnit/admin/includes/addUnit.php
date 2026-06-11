<?php

require_once('../../../../modules/addUnit/admin/controllers/addUnitController.php');
require_once("../../../../settings/path.php");
$objPath          = new Path();

class addUnits
{
	public function addUnit()
	{
		$objPath          = new Path();
		$addUnitController=new addUnitController();
		$addUnitResult=$addUnitController->UnitList();
		
	    if($addUnitResult!=''){
		$i=1;
		$tbody =null;
		while($addUnitResults=mysqli_fetch_array($addUnitResult))
		{
			
		$tbody .='<tr>
					<td align="center">'.$i++.'</td>
					<td>'.$addUnitResults['unitName'].'</td> 
					
		
		
      </tr>';
      
   
		}
	}
	echo $tbody;
}

}

/*<td align="center"><form action="';
					
		$tbody .= $objPath->setAction("editUnit","addUnit");
		
		$tbody .='" method="post">
						<input type="hidden" name="unitId" value="'.$addUnitResults['unitId'].'"/>
						<button type="submit" name="update" value="update" class="btn btn-sm" style="border-radius: 50%;background-color:#efefef"  >
								<i class="fa fa-edit" style="color:#1af516;"></i></button>
						</form>
            
    	</td><td align="center">
				<form action="';
				
		$tbody .=	$objPath->setAction("addUnit","addUnit");
		
		$tbody .='" method="post">
                <input type="hidden" name="unitId" value="'.$addUnitResults['unitId'].'"/>
                <button type="submit" name="delete" value="delete" class="btn btn-sm" style="border-radius: 50%;background-color:#efefef"  >
										<i class="fa fa-times" style="color:red;"></i></button>
             </form>
            
    	</td>*/

if(isset($_POST['submit']))
{
	$unitName =$_POST['unitName'];
	
	require_once('../../../../modules/addUnit/admin/models/addUnitModel.php');
	$objaddUnitModel=new addUnitModel();
	$noOfRows=$objaddUnitModel->nameDuplication($unitName);
	// echo $noOfRows;exit;
	if($noOfRows==0){
	$addUnitController=new addUnitController();
	$addCategoryResult=$addUnitController->insertUnitDetails($unitName);
	
	$objPath->setHeader('addUnit','Success','addUnit');
	}
	else{
		$objPath->setHeader('addUnit','unitName Exist','addUnit');
	}
		
}


if(isset($_POST['delete'])){
			$unitId    = $_POST['unitId'];
			$addUnitController=new addUnitController();
			$addUnitController->deleteUnit($unitId);
			$objPath->setHeader('addUnit','Deleted','addUnit');
			
		}
		
?>




<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4">
    	<div class="box box-solid box-primary">
        	<div class="box-header"  style="background-color:#d9edf7">
            	<h4 class="box-title"><strong style="color:#31708f;font-size: 14px;">Add Unit</strong></h4>
            </div>
            <div class="box-body">
         	<form name="form1" method="post" action="">
			
				<div class="form-group">
                	<label for="unitName">Unit Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="unitName" id="unitName" required="" class="form-control input-sm" autocomplete="off" onchange="nameDuplication();"/>
                   <span id="user"></span></td>
				</div>
            	
                <div class="form-group">
                	<center>
               			<button type="submit" name="submit" value="submit" class="btn btn-primary">
                        	<i class="fa fa-plus"></i> Add
                        </button>
           		 	</center>
             	</div>
			</form> 	
            </div>
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6 col-lg-6">
    	<div class="box box-solid box-success">
        	<div class="box-header" style="background-color:#d9edf7">
            	<h4 class="box-title"><strong style="color:#31708f;font-size: 14px;"><i class="fa fa-list-ul"></i>&nbsp;All Unit</strong></h4>
            </div>
            <div class="box-body">
            	<table width="100%"   id="table_id">
               		<thead style="background-color:#d0e8d2">
                    	<tr>
                			<th width="15%">SL No</th>
							<th width="65%">Unit Name</th>
                 			<!--<th width="10%">Update</th>
							<th width="10%">Delete</th>-->
               			</tr>
                 	</thead>
                    <tbody>
							<?php
	  
						   $addUnit=new addUnits();
						   $addUnit->addUnit();
						   
							?>
    						</td>
     					</tr>
                    </tbody>
				</table>
			</div>
      	</div>
    </div>
</div>



<script>		
 function nameDuplication()
        {
			
			 var unitName = $('#unitName').val();
			// alert(categoryName); 
            $.ajax({
                type: "GET",
                url: "../../../../modules/addUnit/admin/ajax/nameDuplication.php?unitName="+unitName,
                success: function(data)
                { 
				//alert($.trim(data));
				var val=$.trim(data);
                    if(val=='1') 
                    {
                       alert("unitName Exist!!");
							$('#unitName').val(null);
                    }
                    else 
                    {
                        
                    }
                } 
            })              
        }

   
 </script>     



<STYLE>
.dataTables_filter {
   float: left !important;
}

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

</STYLE>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript"  src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">



<script>
$(document).ready( function () {
	$.noConflict();
    $('#table_id').DataTable({
		"dom": '<"toolbar">frltip',
		'aoColumnDefs': [{'bSortable': false}]
	});

  });
</script>


