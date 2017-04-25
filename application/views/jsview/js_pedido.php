<script>
	$(document).ready(function() {
	$('#tblPedidos').DataTable({
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

	});
    $('#searchDatos').on( 'keyup', function () {
            var table = $('#tblPedidos').DataTable();
            table.search(this.value).draw();
        });
    function getview(id,cliente,vendedor) {
        $('#modalDetalleFact').openModal();
        $("#datosPedido").hide();
        $('#loadIMG').show();
        $('#codPedido').text(id);
        $('#codCliente').text(cliente);
        $('#codVendedor').text(vendedor);
        $('#total').text("Espere...");
        limpiarTabla(TbDetalleFactura);
        $('#TbDetalleFactura').DataTable({
                "order": [[ 1, "desc" ]],
                ajax: "detallepedido/"+ id,
                "searching": false,
                "info":    false,
                "bPaginate": false,
                "paging": false,
                "pagingType": "full_numbers",
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
                    { "data": "ARTICULO" },
                    { "data": "DESCRIPCION" },
                    { "data": "CANTIDAD" },
                    { "data": "PRECIO" },
                    { "data": "TOTAL" },
                    { "data": "BONIFICADO" }
              ]
            });
            $('#TbDetalleFactura').on( 'init.dt', function () {
                $('#TbDetalleFactura').show();
                $('#loadIMG').hide();
                $("#datosPedido").show();
                var total=0;
                    obj = $('#TbDetalleFactura').DataTable();
                    obj.rows().data().each( function (index,value) {
                        total += parseFloat(obj.row(value).data().TOTAL.replace(",", "."));
                    });
                $('#total').text(addCommas(total)+" C$");
            }).dataTable();        
    }
    $("#btnProcesar").click(function(){
        if ($("#codPedido").text().length>10 && $("#codPedido").text()!="")
        {
            swal({
              title: "¿CONFIRMA EL PEDIDO?",
              text: "Se marcara el pedido como procesado...",
              type: "info",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true,
            },
            function(){
              $.ajax({
                url: "ajaxUpdatePedido/3/"+ $("#codPedido").text(),
                type: "post",
                async:true,
                success:
                function(clsAplicados){
                    $(location).attr('href',"pedidos");
                }
                });
            });
        }
    });
    function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
    function limpiarTabla (idTabla) {
        idTabla = $(idTabla).DataTable();
        idTabla.destroy();
        idTabla.clear();
        idTabla.draw();
    }
</script>