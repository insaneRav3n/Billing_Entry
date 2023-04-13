<?php
	require_once "includes/headx.php";
	require_once 'includes/header.php';
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
	require_once "includes/classes/admin-class.php";
    $admins	= new Admins($dbh);
    $id = isset($_GET[ 'customer' ])?$_GET[ 'customer' ]:''; 
    ?>
<style> 
 input[type=submit] {
  background-color:#FF0000;
  border: none;
  color: white;
  padding: 4px 8px;
  text-decoration: none;
   
  cursor: pointer;
}
</style>
<body>
<?php
if(isset($_POST['submit'])){
$term = $_POST['term'];
$info = $admins->updateDue($term);

}?>

<?php
if(isset($_POST['submit'])){
$del = $_POST['del'];
$info = $admins->delP($del);

}?>
<div class="container">
        <?php
            $bill = $admins->getBill($id); 
            $info = $admins->getCustomerInfo($id);
        ?>
		<div class="container">
	<h2>Customer Payment Details : </h2>
<font size='3'> Name 	: <b><?=$info -> full_name?></b>
<br>Address : <b><?=$info -> address?></b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Area : <b><?=$info  -> conn_location ?></b></font>
<br><table><th>Previous Due : <b>₹ <?=$info->due?></b></th><th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th><th>Update Due :</th> 
<th><form method="POST" action="details.php">
		<input type="text" name="term" placeholder="amount" size="5">
		<input type="submit" name="submit" value="Submit">
</form></th></table>
<br>
<table class="table table-striped" id="grid-basic">


<?php if (isset($bill) && sizeof($bill) > 0){
	?>
<tr>
<th>Bill Date</th>
<th>Submit Date</th>
<th>Amount</th>
<th></th>
</tr>
<?php
	foreach ($bill as $bills){
		
?>
<tr>

 <?php $bdat = strtotime($bills->bill_date); ?>
<td><?=date('d/m/Y',$bdat); ?>	</td>

<?php $pdat = strtotime($bills->paid_on); ?>
<td><?=date('d/m/Y',$pdat); ?>	</td>
<td><?=$bills->bill_amount?></td>
<td><form method="POST" action="details.php">
		<input type="hidden" name="del" value="<?=$bills->id?>">
		<input type="submit" name="submit" value="del">
</form></td>
</tr>
<?php }?>
</table>
</div>
<?php }?>
</body>
<?php //include 'includes/footer.php'; ?>
