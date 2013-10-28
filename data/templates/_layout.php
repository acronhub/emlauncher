<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title><?=(isset($page_title))?$title.' | ':''?>EM-Launcher</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php if(mfwServerEnv::getEnv()==='local'): ?>
    <link href="/bootstrap/bootswatch/spacelab/bootstrap.min.css" rel="stylesheet" media="screen">
    <?php else: ?>
    <link href="//netdna.bootstrapcdn.com/bootswatch/3.0.0/flatly/bootstrap.min.css" rel="stylesheet" media="screen">
    <?php endif ?>
    <link rel="stylesheet" href="<?=url('/css/customize.css')?>" type="text/css">
  </head>
  <body>

    <div class="navbar navbar-inverse" role="navigation">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="<?=url('/mypage')?>" class="navbar-brand"><span>EM</span><span>Launcher</span></a>
      </div>
      <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav">
          <li><a href="<?=url('/project')?>">Projects</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">makiuchi-d@klab.com <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="<?=url('/mypage')?>">Mypage</a></li>
              <li><a href="<?=url('/project/create')?>">New project</a></li>
              <li><a href="<?=url('/logout')?>">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>

    <?=$contents?>
  </body>

  <?php if(mfwServerEnv::getEnv()==='local'): ?>
  <script src="/jquery/jquery.js"></script>
  <script src="/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <?php else: ?>
  <script src="//code.jquery.com/jquery.js"></script>
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
  <?php endif ?>

  </script>
</html>