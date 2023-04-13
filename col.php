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
<table>
<th><font color=red><b>Enter Keyword :&nbsp;&nbsp;</b></font></th>

<th><form method="POST" action="col.php">
		<input type="text" name="term" placeholder="Name">
		<input type="submit" name="search" value="Search">
</form></th>
</table>
<?php

if(isset($_POST['search'])){
$term = $_POST['term'];
$info = $admins->getCustomer_find($term);

}
?>
<?php
if(isset($_POST['submit2sql'])){
$customer_id = $_POST['term2'];
$bill_date 	 = $_POST['term4'];
$bill_amount = $_POST['term3'];
$invnum 	 = $_POST['term66'];

$admins->invPay( $customer_id, $bill_date, $bill_amount );
$url="http://45.123.160.123/webh/entry.php?ino=".$invnum."";
$payload = file_get_contents($url);
//echo "$customer_id $bill_date $bill_amount ";
}
?>

<?php
if (isset($info) && sizeof($info) > 0){
	
?>
<div width="1000" class="container" style="overflow-x:auto;" >
<table class="table table-striped" id="grid-basic">

<tr>
<th><b> .</b></th>
<th >ID </th>
<th > Name</th>
<th >Address</th>
<th >Contact</th>
<th></th>
<th>Bill Date</th>
<th></th>
</tr>
<?php foreach ($info as $infos){
	?>
	
<tr>
<td><button onclick="getDet(<?=$infos->id?>)" class="btn btn-primary">Details</button></td>
<td ><?=$infos->id?>		    </td>
<td><?=$infos->full_name?>	</td>
<td><?=$infos->address ?>	</td>
<td><?=$infos->conn_location ?>	</td>
<td>
		<form method='POST' action='col.php'>
		<input type='hidden' name='term2' value="<?=$infos->id?>">
		<input name='term3' placeholder='amount'>
		<input name='term66' placeholder='Invoice Number'>
		
</td>
<td>
		
		
		<input type='date' name='term4'>
		
</td>
<td><input type='submit' name='submit2sql' value='Submit'></form></td>
</tr>
<?php }?>
</table>
</div>


	
	<?php }?>
	</body>
	<?php include 'includes/footer.php'; ?>
	<script>
    function getDet(id) {
		let left = (screen.width/2)-(700/2);
  	    let top = (screen.height/2)-(800/2);
		let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=700,height=800,left=${left},top=${top}`;
		open('details.php?customer='+id, 'Details!', params)
		}
    </script>