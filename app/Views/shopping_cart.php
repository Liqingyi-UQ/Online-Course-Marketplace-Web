<!DOCTYPE html>
<html>


</body>

<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3>
				Welcome to your shopping cart
			</h3>
			<?php if($cart_list == "The cart list is empty now"): ?>
				<p><?= $cart_list ?></p>
			<?php else: ?>
				<?php foreach($cart_list as $course): ?>
					<div>
					<?php echo form_open(base_url().'shoppingcart/process'); ?>
			        <form role="form">
						Course ID: <?= $course['id'] ?>
						Course Name: <?= $course['title'] ?>
						Price: <?= $course['price'] ?>
						<button type="submit" name="remove" value="<?= $course['id'] ?>">Remove</button>
						<button type="submit" name="buy" value="<?= $course['id'] ?>">Buy</button>
					</form>
                    <?php echo form_close(); ?>
					</div>
				<?php endforeach; ?>
            <?php endif; ?>


			<a href="<?php echo base_url(); ?>" class="btn btn-link btn-lg" style="display: inline-block;">Go back home to choose the course you like</a>
		</div>

	</div>
</div>

</body>

</html>