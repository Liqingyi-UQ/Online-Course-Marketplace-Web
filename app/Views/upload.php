<div class="container">
	<div class="row clearfix">
		<div class="col-md-6 column">
        <h2 class="text-center">Create Course</h2>   
        <?php echo form_open(base_url().'upload/createCourse'); ?>
			<form role="form">
				<div class="form-group">
					<label for="courseTitle">Course Title</label><input type="text" class="form-control" id="title" name="title" required="required"/>
				</div>
                <div class="form-group">
					<label for="description">Course Description</label><input type="text" class="form-control" id="description" name="description" required="required"/>
				</div>
                <div class="form-group">
					<label for="price">Course Price</label><input type="number" class="form-control" id="price" name="price" required="required" min = "0"/>
				</div>

                <div class="form-group">
					<?php echo $success; ?>
				</div>

                <div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Create Course</button>
				</div>

			</form>
        <?php echo form_close(); ?>
		</div>

		<div class="col-md-6 column">
			<h2 class="text-center">Upload Course Cover Picture</h2>
			<?= form_open_multipart(base_url() . 'upload/upload_basic_file') ?>
			
			<?php if ($upload_state== "<div class=\"alert alert-success\" role=\"alert\"> Upload Successfully </div>"): ?>
				<li>name: <?= esc($original_info->getBasename()) ?></li>
				<img src="<?php echo $original; ?>" alt="Original Image.">   
				<li>The Picture Has Been Watermakered</li>  
				<img src="<?php echo $watermarker; ?>" alt="Watermakered Image."> <br>
			<?php endif; ?>


			<form role="form">
				<label for="title">Course Name</label>
				<input type="text" name="course_name" size="20">
				<br><br>
				<input type="file" name="userfile" size="20">
				<br><br>
				<input type="submit" value="upload">
				<div class="form-group">
					<?php echo $upload_state; ?>
				</div>
			</form>



			<div class="row clearfix">
				<div class="col-md-12 column">
					<h3 class="text-center">
						Upload multi files
					</h3> 
					<?= form_open_multipart(base_url() . 'upload/addSessionCourse') ?>
					<form role="form">
						<label for="title">Course You Want To Choose</label>
						<input type="text" name="session_course_name" size="20">
						<br><br>
						<div class="form-group">
							<button type="submit" class="btn btn-primary btn-block">Confirm Course</button>
				        </div>
						<div class="form-group">
							<?php echo $confirm_state; ?>
						</div>
					</form>
					<div style="text-align: center;">
					<a href="<?php echo base_url(); ?>upload_serveral_files" class="btn btn-link btn-lg" style="display: inline-block;">Go to upload multi files</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>