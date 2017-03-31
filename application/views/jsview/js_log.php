<script>
	$(document).ready(function() {
		$('#tbllog').DataTable({
            "scrollCollapse": true,
            //"paging":         false,
            "info":    false,            
            "lengthMenu": [[5,10,50,100,-1], [5,10,50,100,"Todo"]],
            "language": {
                "zeroRecords": "NO HAY RESULTADOS",
                "paginate": {
                    "first":      "Primera",
                    "last":       "Última ",
                    "next":       "Siguiente",
                    "previous":   "Anterior"                    
                },
                "lengthMenu": "MOSTRAR _MENU_",
                "emptyTable": "NO HAY DATOS DISPONIBLES",
                "search":     "BUSCAR"
            }
        });
        $("#cmbVendedor").change(function(){
		    var table = $('#tbllog').DataTable();
        	table.columns(0).search($(this).val()).draw();
		});
		$('#search').on( 'keyup', function () {
        	var table = $('#tbllog').DataTable();
        	table.search(this.value).draw();
    	});
	});
</script>