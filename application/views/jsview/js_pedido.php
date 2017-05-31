<script>
	$(document).ready(function() {
	$('#tblPedidos').DataTable({
            "scrollCollapse": true,
            //"paging":         false,
            "order": [5,'desc'],
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
    function getview(id,cliente,vendedor,estado) {
        $("#btnProcesar").show();
        $("#btnAnular").show();
        if (estado >= 3) {
            $("#btnProcesar").hide();
            $("#btnAnular").hide();
        }
        
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
                        var subtotal = obj.row(value).data().TOTAL.replace(",", "");
                        subtotal = parseFloat(obj.row(value).data().TOTAL.replace(",", ""));
                        //total += obj.row(value).data().TOTAL.replace(",", "");
                        total += subtotal;
                    });
                $('#total').text(" C$ "+addCommas(total));
            }).dataTable();
            $.ajax({
                url: "ajaxPedidoComen/"+id,
                async:true,
                success:
                function(comen){
                        $("#observaciones").html(comen);
                    }
                });
    }
    $("#btnProcesar").click(function(){
        if ($("#codPedido").text().length>10 && $("#codPedido").text()!=""){
            swal({
              title: "Esta seguro?",
              text: "Se marcara el pedido como procesado!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Procesar!",
              cancelButtonText: "Cancelar!",
              closeOnConfirm: false,
              closeOnCancel: true
            },
            function(isConfirm){
              if (isConfirm) {
                $.ajax({
                url: "ajaxUpdatePedido/3/"+ $("#codPedido").text(),
                type: "post",
                async:true,
                success:
                function(clsAplicados){
                    swal("Procesado!", "El pedido ha sido marcado como procesado.", "success");
                    setInterval(function(){ $(location).attr('href',"pedidos"); }, 1500);                    
                    }
                });
              }
            });
        }
    });
    $("#btnAnular").click(function(){
        swal({
          title: "ANULACION",
          text: "Escriba una razon:",
          type: "input",
          showCancelButton: true,
          closeOnConfirm: false,
          animation: "slide-from-top",
          inputPlaceholder: "Razon de la anulacion"
        },
        function(inputValue){
          if (inputValue === false) return false;
          
          if (inputValue === "") {
            swal.showInputError("Necesita escribir una razon!");
            return false
          }
          swal("Anulado!", "Esperee..: " + inputValue, "success");
          var form_data = {
                comentario: inputValue,
                idPedido: $("#codPedido").text()
          };
          $.ajax({
                url: "ajaxAnulacion",
                type: "post",
                async:true,
                data: form_data,
                success:
                function(clsAplicados){
                    swal("Procesado!", "El pedido ha sido marcado como anulado.", "success");
                    setInterval(function(){ $(location).attr('href',"pedidos"); }, 1400);                    
                    }
                });
        });
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
    $( "#selectRuta" ).change(function() {
        var table = $('#tblPedidos').DataTable();
        table.columns(1).search($(this).val()).draw();
    });
</script>