<?php
  $page_title = 'Add Sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php

  if(isset($_POST['add_sale'])){
    $req_fields = array('s_id','quantity','price','stock_code', 'date', 'v_id');
    validate_fields($req_fields);
        if(empty($errors)){
          $p_id      = $db->escape((int)$_POST['s_id']);
          $s_code     = $db->escape($_POST['stock_code']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
         $s_price     = $db->escape((int)$_POST['price']);
        $s_c_id     = $db->escape((int)$_POST['c_id']);
        $s_v_id     = $db->escape((int)$_POST['v_id']);
          
          $date      = $db->escape($_POST['date']);
          

          $sql  = "INSERT INTO sales (";
          $sql .= " product_id, stock_code ,category_id,vendor_id,qty,price,remarks,date";
          $sql .= ") VALUES (";
          $sql .= "'{$p_id}','{$s_code}','{$s_c_id}','{$s_v_id}','{$s_qty}','{$s_price}',remarks,'{$date}' ";
          $sql .= ")";

                if($db->query($sql)){
                  update_product_qty($s_qty,$p_id);
                  $session->msg('s',"Purchase added. ");
                  redirect('add_sale.php', false);
                } else {
                  $session->msg('d',' Sorry failed to add!');
                  redirect('add_sale.php', false);
                }
        } else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
        }
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
        <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary">Find It</button>
                    </span>
                    <input type="text" id="sug_input" class="form-control" name="title"
                        placeholder="Search for product name">
                </div>
                <div id="result" class="list-group"></div>
            </div>
        </form>
    </div>
</div>
<div class="row">

    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Purchase Edit</span>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="add_sale.php">
                    <table class="table table-bordered">
                        <thead>
                            <th> Item </th>
                            <th> Vendor </th>
                            <th> Price </th>
                            <th> Qty </th>
                            <th> Stock Code </th>
                            <th> Category </th>
                            <th> Total </th>
                            <th> Remarks </th>
                            <th> Date</th>
                            <th> Action</th>
                        </thead>
                        <tbody id="product_info"> </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

</div>

<?php include_once('layouts/footer.php'); ?>