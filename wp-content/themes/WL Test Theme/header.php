
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://use.typekit.net/fkf2hvj.css">
    <link rel="stylesheet" href="https://use.typekit.net/uwr6lyz.css">

    <title><?php wp_title()?></title>
</head>
<body>
<?php wp_head() ;
$number = "+380"?>
<header class="header">
  <a href="<?php echo get_home_url()?>">
      <div class="header-logo logo">
        <?php echo get_custom_logo()?>
      </a>
    </div>
    <a class="phone-number" type="number" href="tel:<?php echo $number .get_option('site_telephone'); ?>">Call us: <?php echo $number .get_option('site_telephone')?></a>
   <span class="header-bg"></span>
</header>




