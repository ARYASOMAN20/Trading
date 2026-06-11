<?php

require_once('../../../../modules/addCategory/admin/controllers/addCategoryController.php');
require_once("../../../../settings/path.php");
$objPath          = new Path();
class addCategorys
{
	public function addCategory()
	{
		$objPath          = new Path();
		$addCategoryController=new addCategoryController();
		$addCategoryResult=$addCategoryController->CategoryList();
		
	    if($addCategoryResult!=''){
		$i=1;
		while($addCategoryResults=mysqli_fetch_array($addCategoryResult))
		{
			
				
?>

        <tr>
         <td><center><?php echo $i++;?></center></td>
         <td><?php echo $addCategoryResults['categoryName'];?> </td> 
		 <td><?php echo $addCategoryResults['categoryNameArabic'];?> </td> 
         <td><?php echo $addCategoryResults['remarks'];?></td> 
        <td>
         
             <form method="post">
                <input type="hidden" name="categoryId" value="<?php echo $addCategoryResults['categoryId'];?>"/>
				<button class="btn btn-sm" data-toggle="modal" type="button" name="update" onclick="getData('<?php echo $addCategoryResults['categoryId']?>');" value="update" style="border-radius: 50%;" data-target="#categoryModalEdit">
										<i class="fa fa-edit" style="color:#1af516;"></i>
									</button>
                
             </form>
            
    	</td>
         <td>
             <form action=<?php echo $objPath->setAction('addCategory','addCategory'); ?> method="post">
                <input type="hidden" name="categoryId" value="<?php echo $addCategoryResults['categoryId'];?>"/>
               
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
	$categoryName =$_POST['categoryName'];
	$categoryNameArabic = $_POST['categoryNameArabic'];
	$remarks      =$_POST['remarks'];
	require_once('../../../../modules/addCategory/admin/models/addCategoryModel.php');
	$objaddCategoryModel=new addCategoryModel();
	$noOfRows=$objaddCategoryModel->nameDuplication($categoryName);
	if($noOfRows==0){
	$addCategoryController=new addCategoryController();
	$addCategoryResult=$addCategoryController->insertCategoryDetails($categoryName,$remarks,$categoryNameArabic);
	
	$objPath->setHeader('addCategory','Success','addCategory');
	}
	else
		$objPath->setHeader('addCategory','categoryName Exist','addCategory');
		
}


if(isset($_POST['delete'])){
			$categoryId = $_POST['categoryId'];
			$addCategoryController=new addCategoryController();
			$addCategoryController->deleteCategory($categoryId);
			$objPath->setHeader('addCategory','Deleted','addCategory');
			
		}
		

if(isset($_POST['submitEdit']))
{
	$addCategoryController=new addCategoryController();
	$categoryId=$_POST['categoryIdEdit'];
	$categoryName=$_POST['categoryNameEdit'];
	$categoryNameArabicEdit = $_POST['categoryNameArabicEdit'];
	$remarks=$_POST['remarksEdit'];
	require_once('../../../../modules/addCategory/admin/models/addCategoryModel.php');
	$objaddCategoryModel=new addCategoryModel();
	$noOfRows=$objaddCategoryModel->nameDuplicationCheck($categoryId,$categoryName);
	if($noOfRows==0){
	$update_Category=$addCategoryController->update_CategoryList($categoryId,$categoryName,$remarks,$categoryNameArabicEdit);
    $objPath->setHeader('addCategory','Success','addCategory');
	}
	else
	$objPath->setHeader('addCategory','categoryName Exist','addCategory');
}
		
		
?>


<style type="text/css">
	

</style>



    
    <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-list-ul"></i> <strong>CATEGORY</strong>
        </div>
        <div class="panel-body" >  
						<table  border="0" cellpadding="0" id="example1"  class="table  table-striped" >        			
							<thead style="background-color:#d0e8d2">
        						<tr class="contentForFont">
                			<th width="5%">#</th>
							<th width="25%">Name</th>
							<th width="25%">Name(Arabic)</th>
                 			<th width="35%">Remarks</th>
                	 		<th width="8%">Update</th>
							<th width="8%">Delete</th>
               			</tr>
                 	</thead>
                    <tbody>
							<?php
	  
						   $addCategory=new addCategorys();
						   $addCategory->addCategory();
						   
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
        <h4 class="modal-title">Add Category</h4>
      </div>
      <div class="modal-body">
	  	<form name="form1" method="post" action="">
			
				<div class="form-group">
                	<label for="categoryName">Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="categoryName" id="categoryName" required="" class="form-control input-sm" autocomplete="off" onchange="nameDuplication();"/>
                   <span id="user"></span>
				</div>
				<div class="form-group">
                	<label for="categoryName">Name(Arabic) :</label>
                   <input type="text" name="categoryNameArabic" id="categoryNameArabic" class="form-control input-sm" autocomplete="off"/>
                  
				</div>
            	<div class="form-group">
                	<label for="remarks">Remarks :</label>
                    <textarea name="remarks" id="remarks" class="form-control input-sm"></textarea>
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

 <div id="categoryModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">×</button>
        <h4 class="modal-title">Edit Category</h4>
      </div>
      <div class="modal-body fetcheddata" >
			<form name="form1" method="post" action="">
			   <input type="hidden" name="categoryIdEdit" id="categoryIdEdit" >
				<div class="form-group">
                	<label for="categoryName">Name :</label><span style="color:red;" class="mandatory">*</span>
                   <input type="text" name="categoryNameEdit" id="categoryNameEdit"  required="" onchange="nameDuplicationChecks();" class="form-control input-sm" autocomplete="off"/>
                </div>
				<div class="form-group">
                	<label for="categoryName">Name(Arabic) :</label>
                   <input type="text" name="categoryNameArabicEdit" id="categoryNameArabicEdit" class="form-control input-sm" autocomplete="off"/>
                  
				</div>
            	<div class="form-group">
                	<label for="remarks">Remarks</label>
                    <textarea name="remarksEdit" id="remarksEdit" class="form-control input-sm"></textarea>
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

<!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script type="text/javascript">
function getData(rowid){
		
        $.ajax({
            type : 'post',
            url : '../../../../modules/addCategory/admin/ajax/getCategoryData.php', 
            data :  'rowid='+ rowid,
            dataType:'JSON',			
            success : function(data){
            $('#categoryIdEdit').val(data.categoryId);
			 $('#categoryNameEdit').val(data.categoryName);
			 $('#remarksEdit').val(data.remarks);
			  $('#categoryNameArabicEdit').val(data.categoryNameArabic);
			
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
			
			 var categoryName = $('#categoryName').val();
			// alert(categoryName); 
            $.ajax({
                type: "GET",
                url: "../../../../modules/addCategory/admin/ajax/nameDuplication.php?categoryName="+categoryName,
                success: function(data)
                { 
				//alert($.trim(data));
				var val=$.trim(data);
                    if(val=='1') 
                    {
                       alert("categoryName Exist!!");
							$('#categoryName').val(null);
                    }
                    else 
                    {
                        
                    }
                } 
            })              
        }

   
 </script>     

<style>
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




<!------------------- End Modal For Add Category ---------------->
<script>



 function nameDuplicationChecks()

        {

			

			 var categoryId    = $('#categoryIdEdit').val();

			 var categoryName = $('#categoryNameEdit').val();

            $.ajax({

                type: "POST",

                url: "../../../../modules/addCategory/admin/ajax/nameDuplicationCheck.php",

				 data:{categoryId:categoryId,categoryName:categoryName},

				 cache:false,

                success: function(data)

                {
					var val=$.trim(data);

                    if(val === '1')

                    {

                      
                             alert("categoryName Exist!!");
							document.getElementById("categoryNameEdit").value= "";

                    }

                    else 

                    {

                      

                    }

                }

            })              

        }	
   
   </script>
  