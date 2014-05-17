<table id="example" class="display">
    <thead>
    <tr>
        <?php foreach ($th as $i => $o) { ?>
            <?php if (is_numeric($i)) { ?>
                <th><?php echo $o; ?></th>
            <?php } else { ?>
                <th><?php echo $i; ?></th>
            <?php } ?>
        <?php } ?>
    </tr>
    </thead>

</table>
<script type="text/javascript" language="javascript" class="init">
    jQuery(document).ready(function($) {
        $('#example').dataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                type: "GET"
            }
            /*"columns": [
                { "data": "first_name" },
                { "data": "last_name" },
                { "data": "position" },
                { "data": "office" },
                { "data": "start_date" },
                { "data": "salary" }
            ]*/
        } );
    } );

</script>
