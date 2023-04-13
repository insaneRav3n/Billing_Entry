<?php
	require_once 'includes/header.php';
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
?>
<body>
<?php
if(isset($_POST['submit2sql'])){
$from = $_POST['term2'];
$to   = $_POST['term4'];
//$bill_amount = $_POST['term3'];
$bill = $admins->fetchBills($from, $to);
$totals = $admins->fetchSum($from, $to);

//echo "$customer_id $bill_date $bill_amount ";
}
?>

<font color=red><b>Select Dates for Report:</b></font><br>
<form method="POST" action="view.php">
		<input type="date" name="term2" placeholder="From">
		-To-
		<input type="date" name="term4" placeholder="Upto">
		<input type="submit" name="submit2sql" value="Search">
		
</form>

<div class="container">
<table class="table table-striped" id="grid-basic">
<?php if (isset($bill) && sizeof($bill) > 0){
	?>
<b><font size=+2>Total Collected : &#8377;<?php echo $totals[0]->TotalSum;

?></b></font>
<tr>
<th>Sl.</th>
<th>Name</th>
<th>Address</th>
<th>Zone</th>
<th>Bill Date</th>
<th>Submit Date</th>
<th>Amount</th>
</tr>
<?php
	foreach ($bill as $bills){
	$info = $admins->getCustomerInfo($bills->customer_id);	
?>
<tr>
<td>
<button onclick="getDet(<?=$bills->customer_id?>)" class="btn btn-primary">Details</button>

</td>
<td ><?=$info -> full_name?>		</td>
<td><?=$info  -> address?>			</td>
<td><?=$info  -> conn_location ?>	</td>

<?php $bdat = strtotime($bills->bill_date); ?>
<td><?=date('d/m/Y',$bdat); ?>	</td>

<?php $pdat = strtotime($bills->paid_on); ?>
<td><?=date('d/m/Y',$pdat); ?>	</td>
<td><?=$bills->bill_amount?></td>
</tr>
<?php }?>
</table>
</div>
<?php }?>
	</body>
	<?php include 'includes/footer.php'; ?>
<script>
    function getDet(id) {
		let left = (screen.width/2)-(600/2);
  	    let top = (screen.height/2)-(800/2);
		let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=600,height=800,left=${left},top=${top}`;
		open('details.php?customer='+id, 'Details!', params)
		}
    </script>
