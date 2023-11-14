<?php
  $page_title = 'Edit Vendor';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  //Display all catgories.
  $vendor = find_by_id('vendor',(int)$_GET['id']);
  if(!$vendor){
    $session->msg("d","Missing Vendor id.");
    redirect('vendor.php');
  }
?>

<?php
if(isset($_POST['edit_cat'])){
  $req_field = array('vendor_name');
  validate_fields($req_field);
  $cat_name = remove_junk($db->escape($_POST['vendor_name']));
  if(empty($errors)){
        $sql = "UPDATE vendor SET vendor_name='{$cat_name}'";
       $sql .= " WHERE id='{$vendor['id']}'";
     $result = $db->query($sql);
     if($result && $db->affected_rows() === 1) {
       $session->msg("s", "Successfully updated Categorie");
       redirect('vendor.php',false);
     } else {
       $session->msg("d", "Sorry! Failed to Update");
       redirect('vendor.php',false);
     }
  } else {
    $session->msg("d", $errors);
    redirect('vendor.php',false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-5">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Editing <?php echo remove_junk(ucfirst($vendor['vendor_name']));?></span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_vendor.php?id=<?php echo (int)$vendor['id'];?>">
                    <div class="form-group">
                        <input type="text" class="form-control" name="vendor_name"
                            value="<?php echo remove_junk(ucfirst($vendor['vendor_name']));?>">
                    </div>
                    <button type="submit" name="edit_cat" class="btn btn-primary">Update Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once('layouts/footer.php'); ?>