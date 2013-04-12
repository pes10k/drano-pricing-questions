<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$page_title?> | Drano Pricing Rules</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?=static_url('css/bootstrap.min.css')?>" rel="stylesheet">
    <link href="<?=static_url('css/bootstrap-responsive.min.css')?>" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body data-spy="scroll" data-target=".subnav" data-offset="57">
    <div class="container" id="main-container">

      <?php if (!empty($alert_error)): ?>
        <div class="alert alert-error">
          <?=$alert_error?>
        </div>
      <?php endif; ?>

      <?php if (!empty($alert)): ?>
        <div class="alert">
          <?=$alert?>
        </div>
      <?php endif; ?>

      <?php if (!empty($alert_success)): ?>
        <div class="alert alert-success">
          <?=$alert_success?>
        </div>
      <?php endif; ?>

      <?php if (!empty($alert_info)): ?>
        <div class="alert alert-info">
          <?=$alert_info?>
        </div>
      <?php endif; ?>

      <?=$yield?>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
    <script src="<?=static_url('js/bootstrap.min.js')?>"></script>
    <?php foreach ($additional_scripts as $script): ?>
      <script src="<?=base_url('js/' . $script)?>"></script>
    <?php endforeach; ?>
  </body>
</html>
