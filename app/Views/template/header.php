<?php
$session = session();
$username = $session->get('username');
$role = $session->get('role');
if (!$role && !$username && isset($_COOKIE['username']) && isset($_COOKIE['role'])) {
    $username = $_COOKIE['username'];
    $role = $_COOKIE['role'];
}
?>



<html>
        <head>
                <title>LearnLion</title>
                <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
                <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
                <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
                <script src="https://www.google.com/recaptcha/api.js" async defer></script>

                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
                <style>
                .select2-container--default .select2-selection--single {
                  height: 30px;
                  width: 200px;
                  top: 50%;
                  margin-left: -160px;
                }
                .select2-container--open .select2-dropdown{
                 left:-160px
                }
                </style>

        </head>
        <body>
  
  <header>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">LearnLion</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item mr-3">
            <a href="<?php echo base_url(); ?>"> Home </a>
      </li>
        
      <li class="nav-item mr-3">
        <?php if (!$username): ?>
          <a href="<?php echo base_url(); ?>register"> Register</a>
        <?php endif; ?>
        <?php if ($username): ?>
          <span>welcome <?php echo $username; ?></span>
          <a href="<?php echo base_url(); ?>login/logout"> Logout</a>
        <?php endif; ?>
      </li>
      
      <li class="nav-item mr-3">
        <?php if ($username): ?>
          <a href="<?php echo base_url(); ?>user"> User Profile</a>
        <?php endif; ?>
      </li>

      <li class="nav-item mr-3">
        <?php if ($role == 'student'): ?>
          <a href="<?php echo base_url(); ?>shoppingcart"> Shopping Cart</a>
        <?php endif; ?>
        <?php if ($role == 'teacher'): ?>
          <a href="<?php echo base_url(); ?>upload"> Create Or Upload</a>
        <?php endif; ?>
      </li>

    </ul>

    <ul class="navbar-nav my-lg-0">
    </div>
    <form class="form-inline my-2 my-lg-0">
      <!-- <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button> -->
      <select class="search form-control mr-sm-2" name="search"></select>
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
</nav>

</header>

<script>
      $('.search').select2({
        placeholder: '--- Search Course ---',
        dropdownAutoWidth: true,
        ajax: {
          url: '<?php echo base_url('autocompleteSearch/ajaxSearch');?>',
          dataType: 'json',
          delay: 250,
          processResults: function(data){
            return {
              results: data
            };
          },
          cache: true
        }
      }).on('change', function() {
        var id = $(this).val();  // 获取选中的值
        if (id) {
          window.location.href = '<?php echo base_url('course_profile');?>/' + id;  // 跳转到相应的页面
        }
      });;
      
</script>

<div class="container">

