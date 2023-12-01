<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$product = find_by_id('products',(int)$_GET['id']);
$all_categories = find_all('categories');
$all_photo = find_all('media');
if(!$product){
  $session->msg("d","Missing product id.");
  redirect('product.php');
}
?>
<?php
 if(isset($_POST['product'])){
    $req_fields = array('stock_code','category_id','product_id' );
    validate_fields($req_fields);

   if(empty($errors)){
       $p_code  = remove_junk($db->escape($_POST['stock_code']));
       $p_id   = (int)$_POST['product_id'];
       $p_cat   = remove_junk($db->escape((int)$_POST['category_id']));
       $date   = remove_junk($db->escape($_POST['date']));
       if (is_null($_POST['product-photo']) || $_POST['product-photo'] === "") {
         $media_id = '0';
       } else {
         $media_id = remove_junk($db->escape($_POST['product-photo']));
       }
        $lip_soh = remove_junk($db->escape((int)$_POST['lip_soh']));
        $hl_soh = remove_junk($db->escape((int)$_POST['hl_soh']));
        $it_soh = remove_junk($db->escape((int)$_POST['it_soh']));
        $stock_onhand = $lip_soh + $hl_soh + $it_soh;
        $cat_sulq = remove_junk($db->escape((int)$_POST['cat_sulq']));
        $com_sulq = remove_junk($db->escape((int)$_POST['com_sulq']));
        $ptfi_sulq = remove_junk($db->escape((int)$_POST['ptfi_sulq']));
        $submitted_usage = $cat_sulq + $com_sulq + $ptfi_sulq;
        $cat_rqucq = remove_junk($db->escape((int)$_POST['cat_rqucq']));
        $com_rqucq = remove_junk($db->escape((int)$_POST['com_rqucq']));
        $ptfi_rqucq = remove_junk($db->escape((int)$_POST['ptfi_rqucq']));
        $req_qty = $cat_rqucq + $com_rqucq + $ptfi_rqucq;
       $query   = "INSERT INTO stocks ( stock_code, product_id, category_id, stock_onhand, submitted_usage, req_qty, date)";
       $query  .=" VALUES";
       $query  .=" ( '{$p_code}', '{$p_id}', '{$p_cat}', '{$stock_onhand}', '{$submitted_usage}', '{$req_qty}', '{$date}')";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Stocks added ");
                 redirect('stocks.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('adding_stocks.php?id='.$product['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('adding_stocks.php?id='.$product['id'], false);
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
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Add Stocks to Product</span>
            </strong>
        </div>
        <div class="panel-body">
            <div class="col-md-120">
                <form method="post" action="adding_stocks.php?id=<?php echo (int)$product['id'] ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="hidden" class="form-control" name="product_id"
                                value="<?php echo remove_junk($product['id']);?>">
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" class="form-control" name="stock_code"
                                value="<?php echo remove_junk($product['stock_code']);?>">
                        </div>
                        <div class="col-md-3">
                            <input type="hidden" class="form-control" name="category_id"
                                value="<?php echo remove_junk($product['categorie_id']);?>">
                        </div>
                        <div class="col-md-3">
                            <input type="text" readonly class="form-control text-center" name="product-title"
                                value="<?php echo remove_junk($product['name']);?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Stock On Hand Last Quarter</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="lip_soh" placeholder="32 LIP">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="hl_soh" placeholder="68 HL">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="it_soh" placeholder="In Transit">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="">Submitted Usage Last Quarter</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="cat_sulq" placeholder="CAT">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="com_sulq" placeholder="COM">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="ptfi_sulq" placeholder="PTFI Depts">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="">Required Quantity Usage Current Quarter</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="cat_rqucq" placeholder="CAT">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="com_rqucq" placeholder="COM">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th-large"></i>
                                    </span>
                                    <input type="text" class="form-control" name="ptfi_rqucq" placeholder="PTFI Depts">
                                </div>
                            </div>

                        </div>
                        <div class="row mt-5">

                            <div class="col-md-4">
                                <div class="input-group">.
                                    <label for="">Date:</label>
                                    <input type="date" class="form-control " name="date" data-date
                                        data-date-format="yyyy-mm-dd">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="product" class="btn btn-danger">Insert</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>