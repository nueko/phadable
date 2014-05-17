<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

    <?php echo $this->tag->getTitle(); ?>

    <?php echo $this->tag->stylesheetLink('css/jquery.dataTables.css'); ?>
    <?php echo $this->tag->stylesheetLink('css/demo.css'); ?>
    <style type="text/css" class="init">

    </style>

    <?php echo $this->tag->javascriptInclude('js/jquery.js'); ?>
    <?php echo $this->tag->javascriptInclude('js/jquery.dataTables.js'); ?>
</head>

<body class="dt-example">
<div class="container">
    <section>
        <?php echo $this->getContent(); ?>
    </section>
</div>

</body>
</html>