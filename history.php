<?php
include('class/Appointment.php');
global $connection;

$object1 = new Appointment;
$object1->query = "
SELECT * FROM patient_history 
WHERE patient_id = '".$_SESSION["patient_id"]."'
";
$result1 = $object1->get_result();
include('header.php');

?>

<div class="container-fluid">
	<?php include('navbar.php'); ?>

	<div class="row justify-content-md-center">
		<div class="col col-md-6">
			<br />
			<?php
			if(isset($_GET['action']) && $_GET['action'] == 'edit')
			{
			?>
			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							Edit Medical History Details
						</div>
						<div class="col-md-6 text-right">
							<a href="history.php" class="btn btn-secondary btn-sm">View</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" id="edit_history_form">
						<div class="row">
							<div class="col-md-6">
								<label>Patient Current Height<span class="text-danger">*</span></label>
								<input type="number" name="patient_height" id="patient_height" class="form-control" step=".01" placeholder="Height in cm" required data-parsley-trigger="keyup"/>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Patient Current Weight<span class="text-danger">*</span></label>
									<input type="number" name="patient_weight" id="patient_weight" class="form-control" step=".01" placeholder="Weight in Kg" required data-parsley-trigger="keyup" />
								</div>
							</div>
						</div>
						<div class="form-group">
							<label>Mediactions<span class="text-danger">*</span></label>
							<textarea name="patient_medication" id="patient_medication" class="form-control" required data-parsley-trigger="keyup"></textarea>
						</div>
						<div class="form-group">
							<label>Medical History<span class="text-danger">*</span></label>
							<textarea name="patient_history" id="patient_history" class="form-control" required data-parsley-trigger="keyup"></textarea>
						</div>
						<div class="form-group text-center">
							<input type="hidden" name="action" value="edit_history" />
							<input type="submit" name="edit_history_button" id="edit_history_button" class="btn btn-primary" value="Edit" />
						</div>
					</form>
				</div>
			</div>

			<br />
			<br />
			

			<?php
			}
			else
			{

				if(isset($_SESSION['success_message']))
				{
					echo $_SESSION['success_message'];
					unset($_SESSION['success_message']);
				}
			?>

			<div class="card">
				<div class="card-header">
					<div class="row">
						<div class="col-md-6">
							Medical History Details
						</div>
						<div class="col-md-6 text-right">
							<a href="history.php?action=edit" class="btn btn-secondary btn-sm">Edit</a>
						</div>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-striped">
					<?php 
						foreach($result1 as $rows){
						?>
						<tr>
							<th class="text-right" width="40%">Current Height</th>
							<td><?php echo $rows["patient_height"]."cm"; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Current Weight</th>
							<td><?php echo $rows["patient_weight"]."Kg"; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Medications</th>
							<td><?php echo $rows["patient_medication"]; ?></td>
						</tr>
						<tr>
							<th class="text-right" width="40%">Medical History</th>
							<td><?php echo $rows["patient_history"]; ?></td>
						</tr>
						<?php }
						?>	
					</table>					
				</div>
			</div>
			<br />
			<br />
			<?php
			}
			?>
		</div>
	</div>
</div>

<?php

include('footer.php');


?>

<script>

$(document).ready(function(){

<?php
	foreach($result1 as $rows)
	{

?>
$('#patient_height').val("<?php echo $rows['patient_height']; ?>");
$('#patient_weight').val("<?php echo $rows['patient_weight']; ?>");
$('#patient_medication').val("<?php echo $rows['patient_medication']; ?>");
$('#patient_history').val("<?php echo $rows['patient_history']; ?>");


<?php

	}

?>

	$('#edit_history_form').parsley();

	$('#edit_history_form').on('submit', function(event){

		event.preventDefault();

		if($('#edit_history_form').parsley().isValid())
		{
			$.ajax({
				url:"action.php",
				method:"POST",
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#edit_history_button').attr('disabled', 'disabled');
					$('#edit_history_button').val('wait...');
				},
				success:function(data)
				{
					window.location.href = "history.php";
				}
			})
		}

	});

});

</script>