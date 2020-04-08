<?php
use Cake\Core\Configure;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php echo $this->Html->charset(); ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title><?php echo h($this->get('title', $this->fetch('title'))); ?></title>

    <!-- build:css -->
    <?php echo $this->Html->css('bootstrap.css', ['fullBase' => true]); ?>
    <?php echo $this->Html->css('main.css', ['fullBase' => true]); ?>
    <!-- endbuild -->

</head>
<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Twitter Search</a>
    </div>
    <div id="navbar" class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <!--
        <li><a href="#">Home</a></li>
        <li><a href="#about">About</a></li>
        <li><a href="#contact">Contact</a></li>
        -->
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>

<div class="container">
    <div class="container">
        <?php
            echo $this->fetch('content');
        ?>
    </div>
</div><!-- /.container -->


    <!-- Scripts -->
    <?php echo $this->Html->script('vendor/jquery.js', ['fullBase' => true]); ?>
    <?php echo $this->Html->script('vendor/bootstrap.min.js', ['fullBase' => true]); ?>
    <!-- endbuild -->
    <?php echo $this->fetch('script'); ?>

</body>
</html>

