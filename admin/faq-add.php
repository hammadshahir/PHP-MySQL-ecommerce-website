<?php require_once('header.php'); ?>

<?php
if(isset($_POST['form1'])) {
	$valid = 1;

	if(empty($_POST['faq_title'])) {
		$valid = 0;
		$error_message .= 'Title can not be empty<br>';
	}

	if(empty($_POST['faq_content'])) {
		$valid = 0;
		$error_message .= 'Content can not be empty<br>';
	}

	if($valid == 1) {
	
		$statement = $pdo->prepare("INSERT INTO tbl_faq (faq_title,faq_content) VALUES (?,?)");
		$statement->execute(array($_POST['faq_title'],$_POST['faq_content']));
			
		$success_message = 'FAQ is added successfully!';

		unset($_POST['faq_title']);
		unset($_POST['faq_content']);
	}
}
?>

<section class="content-header">
	<div class="content-header-left">
		<h1>Add FAQ</h1>
	</div>
	<div class="content-header-right">
		<a href="faq.php" class="btn btn-primary btn-sm">View All</a>
	</div>
</section>


<section class="content">

	<div class="row">
		<div class="col-md-12">

			<?php if($error_message): ?>
			<div class="callout callout-danger">
				<p>
					<?php echo $error_message; ?>
				</p>
			</div>
			<?php endif; ?>

			<?php if($success_message): ?>
			<div class="callout callout-success">
				<p><?php echo $success_message; ?></p>
			</div>
			<?php endif; ?>

			<form class="form-horizontal" action="" method="post">
				<div class="box box-info">
					<div class="box-body">
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Title <span>*</span></label>
							<div class="col-sm-6">
								<input type="text" autocomplete="off" class="form-control" name="faq_title" value="<?php if(isset($_POST['faq_title'])){echo $_POST['faq_title'];} ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label">Content <span>*</span></label>
							<div class="col-sm-9">
								<textarea class="form-control" name="faq_content" id="editor1" style="height:200px;"><?php if(isset($_POST['faq_content'])){echo $_POST['faq_content'];} ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label for="" class="col-sm-2 control-label"></label>
							<div class="col-sm-6">
								<button type="submit" class="btn btn-success pull-left" name="form1">Submit</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

</section>

<?php require_once('footer.php'); ?>