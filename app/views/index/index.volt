<table id="example" class="display">
    <thead>
    <tr>
        {% for i, o in th %}
            {% if i is numeric %}
                <th>{{ o }}</th>
            {% else %}
                <th>{{ i }}</th>
            {% endif %}
        {% endfor %}
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
