<?php
  $page_title = 'All Purchases';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
?>
<?php
$sales = join_sales_table();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>All PURCHASES</span>
                </strong>
                <div class="pull-right">
                    <a href="exportxlsx.php" class="btn btn-primary">Export to XLSX</a>
                </div>
                <div class="pull-right" style="margin-right: 1%;">
                    <a href="add_sale.php" class="btn btn-primary">Add Purchase</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th> Product name </th>
                            <th class="text-center" style="width: 15%;"> Vendor Name</th>
                            <th class="text-center" style="width: 15%;"> Quantity</th>
                            <th class="text-center" style="width: 15%;"> Price </th>
                            <th class="text-center" style="width: 15%;"> Remarks </th>
                            <th class="text-center" style="width: 15%;"> Date </th>
                            <th class="text-center" style="width: 100px;"> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $sale):?>
                        <tr>
                            <td class="text-center"><?php echo count_id();?></td>
                            <td style="width: 30%;"><?php echo remove_junk($sale['name']); ?></td>
                            <td class="text-center"><?php echo $sale['vendor']; ?></td>
                            <td class="text-center"><?php echo (int)$sale['qty']; ?></td>
                            <td class="text-center"><?php echo remove_junk($sale['price']); ?></td>
                            <td class="text-center"><?php echo $sale['remarks']; ?></td>
                            <td class="text-center"><?php echo $sale['date']; ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="edit_sale.php?id=<?php echo (int)$sale['id'];?>"
                                        class="btn btn-warning btn-xs" title="Edit" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
                                    <a href="delete_sale.php?id=<?php echo (int)$sale['id'];?>"
                                        class="btn btn-danger btn-xs" title="Delete" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>