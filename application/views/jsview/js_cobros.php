<script>
	$(document).ready(function() {

	$('#tblCobros').DataTable({
            "scrollCollapse": true,
            //"paging":         false,
            "info":    false,            
            "lengthMenu": [[20,30,50,100,-1], [20,30,50,100,"Todo"]],
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

        $('#searchDatos').on( 'keyup', function () {
            var table = $('#tblCobros').DataTable();
            table.search(this.value).draw();
        });
	});

    $("#searchC").click(function(){
        limpiarTabla(tblCobros);
        $('#tblCobros').DataTable({
                "order": [[ 1, "desc" ]],
                ajax: "searchCobros/"+ $("#f1").val()+"/"+$("#f2").val(),
                "searching": false,
                "info":    false,

                "pagingType": "full_numbers",
                "lengthMenu": "MOSTRAR _MENU_",
                "lengthMenu": [[10, -1], [10, "Todo"]],
                "language": {
                    "emptyTable": "No hay datos disponibles en la tabla",
                    "lengthMenu": '_MENU_ ',
                    "search": '<i class=" material-icons">search</i>',
                    "loadingRecords": "cargando...",
                    "paginate": {
                        "first": "Primera",
                        "last": "Última ",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    }
                },
               columns: [
                    { "data": "IDCOBRO" },
                    { "data": "CLIENTE" },
                    { "data": "VENDEDOR" },
                    { "data": "TOTAL" },
                    { "data": "TIPOPAGO" },
                    { "data": "OBSERVACION" },
                    { "data": "FECHA" }
              ]
            });
            /*$('#tblCobros').on( 'init.dt', function () {
                $('#TbDetalleFactura').show();
                $('#loadIMG').hide();
                $("#datosPedido").show();
                var total=0;
                    obj = $('#TbDetalleFactura').DataTable();
                    obj.rows().data().each( function (index,value) {
                        total += parseFloat(obj.row(value).data().TOTAL.replace(",", "."));
                    });
                $('#total').text(addCommas(total)+" C$");
            }).dataTable();*/
    });
    function limpiarTabla (idTabla) {
        idTabla = $(idTabla).DataTable();
        idTabla.destroy();
        idTabla.clear();
        idTabla.draw();
    }
</script>