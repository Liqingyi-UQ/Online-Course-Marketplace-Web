<!DOCTYPE html>
<html>

<style>
header{
	width: 100%;
	position: fixed;
	top: 0;
	z-index: 2;
}
footer{
	width: 100%;
	position:fixed;
	bottom: 0;
}
</style>

<head>
    <meta charset="UTF-8">
    <div class="jumbotron">
		<h1>
			Hello, world!
		</h1>
		<p>
        bcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYb.
        The Introduction words.
		</p>
	</div>
	</style>
</head>

<!--Reference: S. Kumar, "CodeIgniter 4 Tutorial: Load More using AJAX," Geek Culture, Medium, Sep. 8, 2021. [Online]. 
Available: https://medium.com/geekculture/codeigniter-4-tutorial-load-more-using-ajax-2d7926042ff9. 
Accessed: Apr. 27, 2023.(How to continuously loading data when scrolling using ajax) -->

<body>
    <div class="container">
        <?php if($courses): ?>
            <?php foreach($courses as $data): ?>
				<div class="card w-75 post">
					<div class="card-body">
						<h5 class="card-title"><?php echo $data['title']; ?></h5>
						<p class="card-text">Description: <?php echo $data['description']; ?></p>
						<p class="card-text">Price: <?php echo $data['price']; ?> Dollar</p>
						<a href= "<?php echo base_url(); ?>course_profile/<?php echo $data['id']?>" class="btn btn-primary">Go To The Course Detailed Page</a>
					</div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <div id="loadMoreBlock"></div>
    </div>
</body>


<script>
    var baseURL = "<?php echo base_url(); ?>";
    var page = 1;
    var triggerScrollLoader = true;
    var isLoading = false;

    $(window).scroll(function () {
        if ($(window).scrollTop() + $(window).height() >= $(document).height() - 555) {
            if (isLoading == false) {
                isLoading = true;
                page++;
                if (triggerScrollLoader) {
                    initLoadMore(page);
                }
            }
        }
    });

    function initLoadMore(page) {
        $.ajax({
            url: baseURL+"Home/onScrollLoadMore?page=" + page,
            type: "GET",
            dataType: "html",
        }).done(function (data) {
			console.log(data.length); 
            isLoading = false;
            if (data.length == 0) {
                triggerScrollLoader = false;
                $('#loader').hide();
				$('#loadMoreBlock').append('<p>Already load all the courses</p>');
                return;
            }
            $('#loader').hide();
            $('#loadMoreBlock').append(data).show('slow');
        }).fail(function (jqXHR, ajaxOptions, thrownError) {
            console.error('Error:', thrownError);
        });
    }
</script>

</html>