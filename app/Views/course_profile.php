<div class="container">
	<div class="row clearfix">
		<div class="col-md-12 column">
			<h3> 
                <?php echo 'Class Name: '.$courses[0]['title'];?>
			</h3>
			<?php
			    if($cover_filename==NULL){
					echo "The Cover Picture Dose Not Exist";
				} else {
					$filepath = base_url('writable/uploads/'.$cover_filename);
					echo '<img alt="cover_file_picture" src="' . $filepath . '" style="width: 600px; height: 400px; display:block; margin: 0 auto;;"/>';
				}
			?>
			<!-- show the course detailed and file -->
			<dl>
				<dt>
					Description:
				</dt>
				<dd>
                    <?php echo $courses[0]['description'];?>
				</dd>
				<dt>
					Price:
				</dt>
				<dd>
                    <?php echo $courses[0]['price'];?> Dollars
				</dd>
				<dt>
					Teacher Name: 
				</dt>
				<dd>
                    <?php echo $courses[0]['teacher_name'];?> 
				</dd>
				<dt>
					Files 
				</dt>
				<dd>
				<?php
				  if($other_files==NULL){
					echo "The Content Dose Not Exist";
				  } else {
					foreach($other_files as $other_file)
					{
						$check_image = '';
						$other_filename = $other_file['file_name'];
						$filepath = base_url('writable/uploads/'.$other_filename);
						if($info = getimagesize(WRITEPATH . 'uploads/' . $other_filename)){
							$check_image = true;
						} else {
							$check_image = false;
						}

						if ($check_image) {
							echo '<li>';
							echo '<img alt="other_file_picture" src="' . $filepath . '" style="width: 600px; height: 400px; display:block; margin: 0 auto;;"/>';
							echo '</li>';
						} else {
							echo '<li>';
							echo 'This is not picture. It can not be seen now.';
							echo '</li>';
						}
					}
				  }
				?> 
				</dd>
			</dl>
        
		<!-- Add comments -->
		<div class="col-md-8 column">
            <?php echo form_open(base_url().'courseshow/add_comment'); ?>
				<h3 class="text-center">Add your comment here</h3>       
				
					<div class="form-group">
						<input type="text" class="form-control" placeholder="Comment" required="required" name="comment">
					</div>
					
					<div class="form-group">
						<?php if (isset($commentError)): ?>
							<?php echo $commentError; ?>
							<?php endif; $session=session();$session->remove('commentError');?>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Add Your Comment</button>
					</div>  
			<?php echo form_close(); ?>
		</div>

		
		<!-- Show comments -->
		<div class="comments">
			<?php if ($comments == NULL): ?>
				<div class="media">
					<div class="media-body">
						<h4 class="media-heading">Sorry, this course has no comment now</h4>
					</div>
                </div>
            <?php else: ?>
				<?php foreach (array_reverse($comments) as $c): ?>
                <div class="media">
                    <div class="media-body">
						<h4 class="media-heading">User: <?php echo $c['username']; ?></h4>
						<p>Comment: <?php echo $c['comment']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
		</div>
		 
		<!-- Add Rating -->
		<div class="rating">
			<div class="row clearfix">
				<div class="col-md-6 column">
					<?php echo form_open(base_url().'courseshow/add_rating'); ?>
					<form role="form">
						<div class="form-group">
							<label for="RatingScore">Enter Your Rating Score Below(Score: 1-10)</label>
							<input type="number" class="form-control" id="ratingScore" name="ratingScore" max = "10" min="1"/>
						</div>
						<div class="form-group">
							<?php if (isset($ratingError)): ?>
							<?php echo $ratingError; ?>
							<?php endif; $session=session();$session->remove('ratingError');?>
					    </div>
						<button type="submit" class="btn btn-primary btn-default">Confirm</button>
			        </form>
					<?php echo form_close(); ?>
		        </div>
				<div class="col-md-6 column">
					<dl>
						<dt>
							The Average Score:
						</dt>
						<dd>
							<?php echo $averageRating?>
						</dd>
						<dt>
							The Times Of Being Given The Score:
						</dt>
						<dd>
							<?php echo $totalRatingPeople?>
						</dd>
					</dl>
		        </div>
	        </div>
        </div>

		<!-- add collection -->
		<div class="col-md-8 column">
            <?php echo form_open(base_url().'courseshow/add_favorite_course'); ?>
				<h3 class="text-center">If You Like, Clikc Here To Add To Shopping Cart</h3>  
				<div class="form-group">
					<?php $session=session(); if($session->has('AddingShoppingCartError')): ?>
                    <?php echo $session->get('AddingShoppingCartError'); ?>
                    <?php $session->remove('AddingShoppingCartError'); ?>
                    <?php endif;?>
				</div>     
					<div class="form-group">
						<button type="submit" class="btn btn-primary btn-block">Add This Course</button>
					</div>  
					
			<?php echo form_close(); ?>
		</div>

		</div>
	</div>
</div>