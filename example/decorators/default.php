<html>
  <head>
    <title>MySite :: <?php $page->title(); ?></title>
    <?php $page->head(); ?>
    <style type="text/css">
      body {
        border: 1px dotted red;
        padding: 8px;
      }
    </style>
</head>
<body>

<h1><?php $page->title(); ?></h1>

<?php $page->body(); ?>

</body>
</html>

