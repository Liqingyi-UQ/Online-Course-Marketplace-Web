<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
    <body>
    
    <div class="col-4 offset-4">
    <?= form_open('resetpassword/verify') ?>
                    <div class="form-group">
                        <label for="username">Username:</label>
						<input type="text" class="form-control" placeholder="Username" required="required" name="username">
					</div>
                    <div>
						<label for="role">Role:</label>
						<select name="role" id="role">
							<option value="student">Student</option>
							<option value="teacher">Teacher</option>
						</select>
					</div>
                    <div>
						<label for="security question">Choose Your Security Question:</label>
						<select name="security_question" id="security_question">
							<option value="What is your real name?">"What is your real name?"</option>
							<option value="What is your role?">"What is your role?"</option>
							<option value="What is your pet's name?">"What is your pet's name?"</option>
						</select>
					</div>
                    <div class="form-group">
                        <label for="Answer">Security Answer:</label>
						<input type="text" class="form-control" placeholder="Security Answer" required="required" name="security_answer">
					</div>              
                    <div class="form-group">
					<?php echo $error; ?>
					<?php echo $success; ?>
					</div>
                    <div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Confirm Security Answer</button>
					</div>
    <?= form_close() ?>
	</div>
    
    <div class="col-4 offset-4">
    <?= form_open('resetpassword/changepassword') ?>
                    <div class="form-group">
                        <label for="new_password">New Password:</label>
						<input type="text" class="form-control" placeholder="New Password" required="required" name="new_password" >
					</div>   
                    
                    <div class="form-group">
                    <?php if (isset($change_state)): ?>
                        <?php echo $change_state;?>
                    <?php endif; ?>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Confirm New Password</button>
					</div>
                    <div class="clearfix">
                        <?php if (isset($change_state)&&$change_state): ?>
                            <a href="<?php echo base_url(); ?>login" class="float-right">Log In</a>
                            <?php endif; ?>
                        </div>  
    <?= form_close() ?>
	</div>

    </body>
</html>