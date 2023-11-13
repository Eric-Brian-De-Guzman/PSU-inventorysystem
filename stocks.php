<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
  $stocks = join_stocks_table();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-right">
                    <a href="add_product.php" class="btn btn-primary">Add New</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center" style="width: 20%;"> Stock Code </th>
                            <th class="text-center" style="width: 10%;"> Product Name </th>
                            <th class="text-center" style="width: 10%;"> Vendor</th>
                            <th class="text-center" style="width: 10%;"> UOI</th>
                            <th class="text-center" style="width: 10%;"> Quantity</th>
                            <th class="text-center" style="width: 10%;"> Category</th>
                            <th class="text-center" style="width: 10%;"> Updated at</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stocks as $stock):?>
                        <tr>
                            <td class="text-center"><?php echo count_id();?></td>

                            <td class="text-center"> <?php echo remove_junk($stock['stock_code']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($stock['name']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($stock['vendor_name']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($stock['UOI']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($stock['quantity']); ?></td>
                            <td class="text-center"> <?php echo remove_junk($stock['categorie']); ?></td>

                            <td class="text-center"> <?php echo read_date($stock['date']); ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_product.php?id=<?php echo (int)$stock['id'];?>"
                                        class="btn btn-info btn-xs" title="Edit" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="delete_product.php?id=<?php echo (int)$stock['id'];?>"
                                        class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </tabel>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>