<?php

require_once('../../../../modules/addSubCategory/admin/controllers/addSubCategoryController.php');
require_once("../../../../settings/path.php");
$objPath          = new Path();
$addCategoryController=new addCategoryController();
class addCategorys
{
	public function addCategory()
	{
		$objPath          = new Path();
		$addCategoryController=new addCategoryController();
		$addCategoryResult=$addCategoryController->listSubcategory();
		
	    if($addCategoryResult!=''){
		$i=1;
		while($addCategoryResults=mysqli_fetch_array($addCategoryResult))
		{
			
				
?>

        <tr>
         <td><center><?php echo $i++;?></center></td>
         <td><?php echo $addCategoryResults['categoryName'];?> </td> 
         <td><?php echo $addCategoryResults['subCategoryName'];?></td> 
		  <td><?php echo $addCategoryResults['subCategoryNameArabic'];?> </td> 
        <td>
         
             <form method="post">
                <input type="hidden" name="subCategoryId" value="<?php echo $addCategoryResults['subCategoryId'];?>"/>
				<button class="btn btn-sm" data-toggle="modal" type="button" name="update" onclick="getData('<?php echo $addCategoryResults['subCategoryId']?>');" value="update" style="border-radius: 50%;" data-target="#categoryModalEdit">
										<i class="fa fa-edit" style="color:#1af516;"></i>
									</button>
                
             </form>
            
    	</td>
         <td>
             <form action=<?php echo $objPath->setAction('addSubCategory','addSubCategory'); ?> method="post">
                <input type="hidden" name="subCategoryId" value="<?php echo $addCategoryResults['subCategoryId'];?>"/>
               
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
$category = $addCategoryController->getCategoryName();

if(isset($_POST['submit']))
{
	$categoryName =$_POST['categoryName'];
	$subcategoryName      =$_POST['subcategoryName'];
	$subcategoryNameArabic =$_POST['subcategoryNameArabic'];
	require_once('../../../../modules/addSubCategory/admin/models/addSubCategoryModel.php');
	$objaddCategoryModel=new addCategoryModel();
	$noOfRows=$objaddCategoryModel->nameDuplication($subcategoryName,$categoryName);
	if($noOfRows==0){
	$addCategoryController=new addCategoryController();
	$addCategoryResult=$addCategoryController->insertCategoryDetails($categoryName,$subcategoryName,$subcategoryNameArabic);
	
	$objPath->setHeader('addSubCategory','Success','addSubCategory');
	}
	else
		$objPath->setHeader('addSubCategory','Sub Category Name Exist','addSubCategory');
		
}


if(isset($_POST['delete'])){
			$subCategoryId = $_POST['subCategoryId'];
			$addCategoryController=new addCategoryController();
			$addCategoryController->deleteCategory($subCategoryId);
			$objPath->setHeader('addSubCategory','Deleted','addSubCategory');
			
		}
		

if(isset($_POST['submitEdit']))
{
	$addCategoryController=new addCategoryController();
	$subCategoryId=$_POST['subCategoryIdEdit'];
	$categoryId=$_POST['categoryIdEdit'];
	$subCategoryName=$_POST['subCategoryNameEdit'];
	$subcategoryNameArabicEdit = $_POST['subcategoryNameArabicEdit'];
	require_once('../../../../modules/addSubCategory/admin/models/addSubCategoryModel.php');
	$objaddCategoryModel=new addCategoryModel();
	$noOfRows=$objaddCategoryModel->nameDuplicationCheck($subCategoryName,$categoryId,$subCategoryId);
	if($noOfRows==0){
	$update_Category=$addCategoryController->update_CategoryList($categoryId,$subCategoryId,$subCategoryName,$subcategoryNameArabicEdit);
	 $objPath->setHeader('addSubCategory','Success','addSubCategory');
	}
	else
		$objPath->setHeader('addSubCategory','SubcategoryName Exist','addSubCategory');
}
		
		
?>


<style type="text/css">
	

</style>



    
    <div class="col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-info">
        <div class="panel-heading"><i class="fa fa-list-ul"></i> <strong>SUBCATEGORY</strong>
        </div>
        <div class="panel-body" >  
						<table  border="0" cellpadding="0" id="example1"  class="table  table-striped" >        			
							<thead style="background-color:#d0e8d2">
        						<tr class="contentForFont">
                			<th width="5%">#</th>
							<th width="25%">Category</th>
                 			<th width="25%">Subcategory</th>
							<th width="35%">Subcategory(Arabic)</th>
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
        <h4 class="modal-title">Add SubCategory</h4>
      </div>
      <div class="modal-body">
	  	<form name="form1" method="post" action="">
			
				<div class="form-group">
                	<label for="categoryName">Category :</label><span style="color:red;" class="mandatory">*</span>
               <select name="categoryName" id="categoryName" required="" class="form-control input-sm" >
			   <?php echo $category; ?>
			   </select>
                  
				</div>
            	<div class="form-group">
                	<label for="remarks">SubCategory :</label>
                   <input type="text" name="subcategoryName" id="subcategoryName" required="" class="form-control input-sm" autocomplete="off" onchange="nameDuplication();"/>
                   <span id="user"></span></td>
                </div>
				<div class="form-group">
                	<label for="categoryName">SubCategory(Arabic) :</label>
                   <input type="text" name="subcategoryNameArabic" id="subcategoryNameArabic" class="form-control input-sm" autocomplete="off"/>
                  
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
        <h4 class="modal-title">Edit SubCategory</h4>
      </div>
      <div class="modal-body fetcheddata" >
			<form name="form1" method="post" action="">
			   <input type="hidden" name="subCategoryIdEdit" id="subCategoryIdEdit" >
				<div class="form-group">
                	<label for="categoryName">Category :</label><span style="color:red;" class="mandatory">*</span>
               <select name="categoryIdEdit" id="categoryIdEdit" required="" class="form-control input-sm" >
			  
			   </select>
                  
				</div>
            	<div class="form-group">
                	<label for="remarks">SubCategory :</label>
                   <input type="text" name="subCategoryNameEdit" id="subCategoryNameEdit" required="" class="form-control input-sm" autocomplete="off" onchange="nameDuplicationChecks();"/>
                   <span id="user"></span></td>
                </div>
				<div class="form-group">
                	<label for="categoryName">SubCategory(Arabic) :</label>
                   <input type="text" name="subcategoryNameArabicEdit" id="subcategoryNameArabicEdit" class="form-control input-sm" autocomplete="off"/>
                  
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
            url : '../../../../modules/addSubCategory/admin/ajax/getSubCategoryData.php', //Here you will fetch records 
            data :  'rowid='+ rowid,
            dataType:'JSON',			//Pass $id
            success : function(data){
            $('#categoryIdEdit').html(data.categoryList);
			 $('#subCategoryNameEdit').val(data.subCategoryName);
			 $('#subCategoryIdEdit').val(data.subCategoryId);
			 $('#subcategoryNameArabicEdit').val(data.subCategoryNameArabic);
			
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
			 // var categoryName = $('#categoryName').val();
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
  