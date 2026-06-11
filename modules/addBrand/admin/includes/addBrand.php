<?php

require_once('../../../../modules/addBrand/admin/controllers/addBrandController.php');
require_once("../../../../settings/path.php");
$objPath          = new Path();
class addBrands
{
	public function addBrand()
	{
		$objPath          = new Path();
		$addBrandController=new addBrandController();
		$addBrandResult=$addBrandController->brandList();
	    if($addBrandResult!=''){
		$i=1;
		while($addBrandResults=mysqli_fetch_array($addBrandResult))
		{
				
?>

        <tr>
         <td><center><?php echo $i++;?></center></td>
		 <td><?php echo $addBrandResults['brandCode'];?></td>  
         <td><?php echo $addBrandResults['brandName'];?> </td> 
		  <td>
         
             <form method="post">
                <input type="hidden" name="categoryId" value="<?php echo $addCategoryResults['brandId'];?>"/>
				<button class="btn btn-sm" data-toggle="modal" type="button" name="update" onclick="getData('<?php echo $addBrandResults['brandId']?>');" value="update" style="border-radius: 50%;" data-target="#brandModalEdit">
										<i class="fa fa-edit" style="color:#1af516;"></i>
									</button>
                
             </form>
            
    	</td>
		<td>
         
             <form action=<?php echo $objPath->setAction('addBrand','addBrand'); ?> method="post">
                <input type="hidden" name="brandId" value="<?php echo $addBrandResults['brandId'];?>"/>
                <button class="btn btn-sm" type="submit" name="delete" value="delete" style="border-radius: 50%;">
										<i class="fa fa-times" style="color:red;"></i>
									</button>
             </form>
            
    	</td>
		
      </tr>
      
      <?php 
		}
		}
}

}

if(isset($_POST['submit']))
{
	$brandCode    =$_POST['brandCode'];
	$brandName    =$_POST['brandName'];
	$brandFormat  ='';
	$addBrandController=new addBrandController();
	require_once('../../../../modules/addBrand/admin/models/addBrandModel.php');
				$addBrandModel=new addBrandModel();
	   $noOfRows=$addBrandModel->nameDuplication($brandCode);
	   if($noOfRows==0){
	$addBrandResult=$addBrandController->insertBrandDetails($brandCode,$brandName,$brandFormat);
	
	$objPath->setHeader('addBrand','Success','addBrand');
	   }
	   
	   else
		 $objPath->setHeader('addBrand','BrandCode Exist','addBrand');  
}


if(isset($_POST['delete'])){
			$brandId = $_POST['brandId'];
			$addBrandController=new addBrandController();
			$resDelete=$addBrandController->deleteBrand($brandId);
			$objPath->setHeader('addBrand','Deleted','addBrand');
			
		}
	

		  
if(isset($_POST['submitEdit']))
{
	$addBrandController=new addBrandController();
	$brandId      =$_POST['brandIdEdit'];
	$brandName    =$_POST['brandNameEdit'];
	$brandCode    =$_POST['brandCodeEdit'];
	$brandFormat  ='';
	require_once('../../../../modules/addBrand/admin/models/addBrandModel.php');
	$objaddCategoryModel=new addBrandModel();
	$noOfRows=$objaddCategoryModel->nameDuplicationCheck($brandId,$brandCode);
	if($noOfRows==0){
	$update_Brand=$addBrandController->update_BrandList($brandId,$brandCode,$brandName,$brandFormat);
	 $objPath->setHeader('addBrand','Success','addBrand');
	}
	else
		$objPath->setHeader('addBrand','BrandCode Exist','addBrand');  
}	

	
?>


<style type="text/css">
	
.dataTables_filter {
   float: left !important;
}

#example1_paginate .paginate_button current{
	background-color:#000 !important;
}

#example1_length{
	 margin-left:10%!important;
}

table.dataTable thead th {
    border-bottom: 0px solid #111!important;
}
 
table.dataTable tfoot td {
    border-top: 0px solid  #111!important;
}

table td ,table th {
	border:0.5px solid #e4e4da!important;
	border-collapse:collapse!important;
}

.paginate_button{
	background: #d9edf7 !important;
    border-radius: 50px !important;
	
}
#example1 td {
    font-size: 13px !important;
	padding: 2px !important;
}
tbody tr {
    background-color: #ffffff !important;
}
</style>

       <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-list-ul"></i> <strong>BRAND</strong>
        </div>
        <div class="panel-body" >  
						<table  border="0" cellpadding="0" id="example1"  class="table  table-striped" >        			
							<thead style="background-color:#d0e8d2">
        						<tr class="contentForFont" >
                			<th width="5%">#</th>
							<th width="35%">Brand Code</th>
							<th width="35%">Brand Name</th>
							<th width="5%">Update</th>
							<th width="5%">Delete</th>
               			</tr>
                 	</thead>
                    <tbody>
							<?php
	  
						   $addBrand=new addBrands();
						   $addBrand->addBrand();
						   
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
        <h4 class="modal-title">Add Brand</h4>
      </div>
      <div class="modal-body">
	  <form name="form1" method="post" action="">
			
			    <div class="form-group">
                	<label for="brandCode">Brand Code :</label>
                   <input type="text" name="brandCode" id="brandCode" onChange="nameDuplication();"  required class="form-control input-sm"  autocomplete="off"/>
                </div>
			
				<div class="form-group">
                	<label for="brandName">Brand Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="brandName" id="brandName" required="" class="form-control input-sm"  autocomplete="off"/>
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
</div>
			
	
 <div id="brandModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit Brand</h4>
      </div>
      <div class="modal-body fetched-data" >
			<form name="form1" method="post" action="">
			   <input type="hidden" name="brandIdEdit" id="brandIdEdit"  >
			    <div class="form-group">
                	<label for="brandCode">Brand Code :</label>
                   <input type="text" name="brandCodeEdit" onChange="nameDuplicationChecks();"  id="brandCodeEdit" required class="form-control input-sm"  autocomplete="off"/>
                </div>
				<div class="form-group">
                	<label for="brandName">Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="brandNameEdit" id="brandNameEdit" required="" class="form-control input-sm" autocomplete="off"/>
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
		


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>



<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
 
function getData(rowid){
		
        $.ajax({
            type : 'post',
            url : '../../../../modules/addBrand/admin/ajax/getBrandDATA.php', 
            data :  'rowid='+ rowid,
            dataType:'JSON',			//Pass $id
            success : function(data){
            $('#brandIdEdit').val(data.brandId);
			 $('#brandCodeEdit').val(data.brandCode);
			 $('#brandNameEdit').val(data.brandName);
			
            }
        });
}
$(document).ready( function () {
	$.noConflict();
    $('#example1').DataTable({
		"dom": '<"toolbar">frltip',
		'aoColumnDefs': [{'bSortable': false,'aTargets':[0,3,4]}]
		

		 
	});
   $("div.toolbar").html('<button type="button" style="float:right" class="btn btn-info" data-toggle="modal" data-target="#myModal">&nbsp; ADD</button>');

 } );
 

</script>
<script>		
 function nameDuplication()
        {
			
			 var brandName = $('#brandCode').val();
			//alert(brandName); 
            $.ajax({
                type: "GET",
                url: "../../../../modules/addBrand/admin/ajax/nameDuplication.php?brandName="+brandName,
                success: function(data)
                { 
				//alert($.trim(data));
				var val=$.trim(data);
                    if(val=='1') 
                    {
                       alert("Brand Code Exist!!");
							$('#brandCode').val(null);
                    }
                    else 
                    {
                        
                    }
                } 
            })              
        }
 function nameDuplicationChecks()

        {

			

			 var brandId    = $('#brandIdEdit').val();

			 var brandName = $('#brandCodeEdit').val();

            $.ajax({

                type: "POST",

                url: "../../../../modules/addBrand/admin/ajax/nameDuplicationCheck.php",

				 data:{brandId:brandId,brandName:brandName},

				 cache:false,

                success: function(data)

                {
					var val=$.trim(data);

                    if(val === '1')

                    {

                      
                             alert("BrandCode Exist!!");
							document.getElementById("brandCodeEdit").value= "";

                    }

                    else 

                    {

                      

                    }

                }

            })              

        }	
 </script>  		
  
   
      

