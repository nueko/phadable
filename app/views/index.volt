<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">

    {{ get_title() }}

    {{ stylesheet_link('css/jquery.dataTables.css') }}
    {{ stylesheet_link('css/demo.css') }}
    <style type="text/css" class="init">

    </style>

    {{ javascript_include('js/jquery.js') }}
    {{ javascript_include('js/jquery.dataTables.js') }}
</head>

<body class="dt-example">
<div class="container">
    <section>
        {{ content() }}
    </section>
</div>

</body>
</html>