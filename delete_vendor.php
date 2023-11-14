<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $vendor = find_by_id('vendor',(int)$_GET['id']);
  if(!$vendor){
    $session->msg("d","Missing Vendor id.");
    redirect('vendor.php');
  }
?>
<?php
  $delete_id = delete_by_id('vendor',(int)$vendor['id']);
  if($delete_id){
      $session->msg("s","Vendor deleted.");
      redirect('vendor.php');
  } else {
      $session->msg("d","Vendor deletion failed.");
      redirect('vendor.php');
  }
?>