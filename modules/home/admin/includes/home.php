
<?php
/*require_once("../../../../modules/home/admin/class/m_home.php");
require_once ("../../../../settings/path.php");
	$objPath = new Path();
	$objMHome = new M_Home();
	$countOfStock =0;
	$table='';
	$i=1;
	$resStock = $objMHome->listStockContainingLessThan10();
	
	$privelegeId = $_SESSION['privillegeId'];
	
	
	if ( $row = mysqli_fetch_array($resStock))
	{
		$countOfStock  = $row['count'];
	}
	if(isset($_POST['btnListMaterials'])){
		
	$resStockList = $objMHome->listStocks();
	
	$count = mysqli_num_rows($resStockList );
	
			while ( $rowListMaterials = mysqli_fetch_array($resStockList))
	{
		
		$table .='<tr><td>'.$i.'</td><td>'.$rowListMaterials['materialsName'].'</td>
		<td>'.$rowListMaterials['unitPrice'].'</td><td>'.$rowListMaterials['stock'].'</td></tr>';
		$i++;
	}

	}
	
	if($privelegeId == 1 || $privelegeId == 2 || $privelegeId ==3 || $privelegeId =4 )
	{*/
?> 
  
   <!--<div class="row">
   
   
   <div class="col-md-4 col-sm-6 col-xs-12">
        <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Materials</span>
                
                <span class="info-box-number" style="font-size: 26px; font-weight: bold;"><?php //echo $countOfStock; ?></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 100%"></div>
                </div>
                <span class="progress-description">
                    Stock less Than 10 
                </span>
                <span class="progress-description">
                <div class="pull-right">
                	<form method='POST' action="" style="margin-bottom: 0">
					  <button type="submit" name="btnListMaterials" class="btn btn-xs btn-success" 
                      style="background: #7c9e32 !important;  height:20px; line-height:10px !important;">
					  More Info <i class="fa fa-angle-double-right"></i></button> 
					</form>
                    </div>
              	</span>
            </div>
            <!-- /.info-box-content -->
        <!--</div>
        <!-- /.info-box -->
        	</div><!-- /.col -->
           
         	<?php 
			//if(isset($_POST['btnListMaterials'])){
				?>
       
        <!--<div class="col-sm-6 col-md-6 col-lg-6">
            <div class="box box-solid box-success">
                <div class="box-header">
                    <h5 class="box-title bigger lighter ui-sortable-handle">
                        <i></i> Material List
                    </h5>
                </div>
                <div class="box-body">
				<table width="100%" border="1" cellpadding="0" cellspacing="0"
                        data-page-navigation=".pagination" data-page-size="10" data-sort="false" 
                            class="table table-condensed table-responsive table-bordered footable">
                            
                                <thead>
                                    <tr>
                                    <th>#</th>
                                        <th width="80%">Materials</th>
                                        <th width="80%">Unit Price</th>
                                        <th width="20%">Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php //echo $table; ?>
                                </tbody>
                                                    <tfoot>
                    	<tr>
                        	<td colspan="5">
                    			<div class="pagination pagination-centered hide-if-no-paging"></div>
                           	</td>
                       	</tr>
                    </tfoot>

                          </table>
                          </div>
                          </div>
                          </div>
                         
      <?php //}?>  
      
      
      

</div><!-- /.row -->

<?php //}?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script type="text/javascript">
	$(function () {
		$('.footable').footable();
	});
</script> 
