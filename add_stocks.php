<?php
  $page_title = 'Add Stocks';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_products = find_all('products');
  $all_photo = find_all('media');
?>
<?php
 if(isset($_POST['add_stocks'])){
   $req_fields = array('s_quantity' );
   validate_fields($req_fields);
   if(empty($errors)){
     $s_quantity  = remove_junk($db->escape($_POST['s_quantity']));
     $s_product_id  = remove_junk($db->escape($_POST['product_id']));
    
     
    
     $date    = make_date();
     $query  = "INSERT INTO stocks (";
     $query .="  product_id, quantity, date ";
     $query .=") VALUES (";
     $query .="  '{$s_product_id}','{$s_quantity}', '{$date}' ";
     $query .=")";

     if($db->query($query)){
       $session->msg('s',"Stock added ");
       redirect('add_stocks.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('stocks.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_stocks.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Add Current Stock On Hand</span>
                </strong>
            </div>
            <div class="panel-body">
                <div class="col-md-12">
                    <form method="post" action="add_stocks.php" class="clearfix">

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <select class="form-control" name="product_id">
                                        <option value="">Select Product</option>
                                        <?php  foreach ($all_products as $cat): ?>
                                        <option value="<?php echo (int)$cat['id'] ?>">
                                            <?php echo $cat['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="glyphicon glyphicon-shopping-cart"></i>
                                        </span>
                                        <input type="number" class="form-control" name="s_quantity"
                                            placeholder="Product Quantity">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <button type="submit" name="add_stocks" class="btn btn-danger">Add Stocks</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>