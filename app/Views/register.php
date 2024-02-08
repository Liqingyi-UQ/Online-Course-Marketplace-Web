<div class="container">
      <div class="col-4 offset-4">
			<?php echo form_open(base_url().'register/check_register'); ?>
				<h2 class="text-center">Register</h2>       
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" placeholder="Password" required="required" name="password">
					</div>
					
					<div class="form-group">
						<input type="email" class="form-control" placeholder="Email" required="required" name="email">
					</div>
                    
                    <div>
						<label for="role">Role:</label>
						<select name="role" id="role">
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select>
					</div>

					<div>
						<label for="security question">Set Your Security Question:</label>
						<select name="security_question" id="security_question">
							<option value="What is your real name?">"What is your real name?"</option>
							<option value="What is your role?">"What is your role?"</option>
							<option value="What is your pet's name?">"What is your pet's name?"</option>
						</select>
					</div>

					<div class="form-group">
						<input type="text" class="form-control" placeholder="Security Answer" required="required" name="security_answer">
					</div>
					
					<div class="form-group">
					<?php echo $error; ?>
					<?php echo $success; ?>
					</div>

					<div class="g-recaptcha" data-sitekey="6Lc_faElAAAAAO5oitQQZtvZfXF5umsCSr2ZNxMO"></div>

					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Sign Up</button>
					</div>
					<div class="clearfix">
						<a href='/LearnLion/login' class="float-right">Already has an account</a>
					</div>    
			<?php echo form_close(); ?>
	</div>
</div>