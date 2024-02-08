<!--Reference: S. Kumar, "CodeIgniter 4 Tutorial: Load More using AJAX," Geek Culture, Medium, Sep. 8, 2021. [Online]. 
Available: https://medium.com/geekculture/codeigniter-4-tutorial-load-more-using-ajax-2d7926042ff9. 
Accessed: Apr. 27, 2023.(How to continuously loading data when scrolling using ajax) -->
<?php if($courses): ?>
    <?php foreach($courses as $data): ?>
        <div class="card w-75 post">
            <div class="card-body">
                <h5 class="card-title"><?php echo $data->title; ?></h5>
                <p class="card-text">Description: <?php echo $data ->description; ?></p>
                <p class="card-text">Price: <?php echo $data->price; ?> Dollar</p>
                <a href= "<?php echo base_url(); ?>course_profile/<?php echo $data->id;?>" class="btn btn-primary">Go To The Course Detailed Page）</a>
			</div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>