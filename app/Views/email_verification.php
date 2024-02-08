<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
</head>
    <body>
    
    <div class="col-4 offset-4">
    <?= form_open('emailcontroller/send') ?>
                    <div class="form-group">
                        <label for="username">Username:</label>
						<input type="text" class="form-control" placeholder="Username" required="required" name="username" value="<?= esc($username) ?>">
					</div>
                    <div class="form-group">
                        <label for="email">Email:</label>
						<input type="email" class="form-control" placeholder="Email" required="required" name="email" value="<?= esc($email) ?>">
					</div>
                    <div class="form-group">
                        <label for="role">Role:</label>
						<input type="text" class="form-control" placeholder="Role" required="required" name="role" value="<?= esc($role) ?>">
					</div>               
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Ask Verification Code</button>
					</div>
                    <div class="form-group">
					<?php echo $error; ?>
					<?php echo $success; ?>
					</div>
    <?= form_close() ?>
	</div>
    
    <div class="col-4 offset-4">
    <?= form_open('emailcontroller/verify') ?>
                    <div class="form-group">
                        <label for="verification_code">Verification Code:</label>
						<input type="text" class="form-control" placeholder="Verification Code" required="required" name="verification_code" >
					</div>   
                    
                    <div class="form-group">
                    <?php if (isset($verify_state)): ?>
                        <?php echo $verify_state;?>
                    <?php endif; ?>
					</div>
                    
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Confirm Verfication Code</button>
					</div>
    <?= form_close() ?>
	</div>

    </body>
</html>