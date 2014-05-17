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
    <tbody></tbody>
    <tfoot>
        
        <tr>
            {% for i, o in th %}
                {% if i is numeric %}
                    <th>{{ o }}</th>
                {% else %}
                    <th>{{ i }}</th>
                {% endif %}
            {% endfor %}
        </tr>
    </tfoot>
</table>
<script type="text/javascript" language="javascript" class="init">
    jQuery(document).ready(function($) {

        var table = $('#example').DataTable( {
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

        $("#example tfoot th").each( function ( i, o ) {
            var select = $('<select><option value=""></option></select>')
                .appendTo( $(this).empty() )
                console.info(table.column( i ).data())

            table.columns( i ).data().unique().sort().each( function ( d, j ) {
                select.append( '<option value="'+d+'">'+d+'</option>' )
            } );
        } );

    } );

</script>
