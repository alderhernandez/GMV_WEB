<script>
$(document).ready(function() {
    //getCliente("F04");

    $(".tab").click(function(){
        $(".tab").removeClass("mitabactive");
        $(".tab").addClass("mitab");
        $(this).addClass("mitabactive");
    });
    var bandera =0;
	$('#tblmonitoreo,#tblmonitoreo2').DataTable({
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
        var table = $('#tblmonitoreo').DataTable();
        table.search(this.value).draw();
        var table = $('#tblmonitoreo2').DataTable();
        table.search(this.value).draw();
    });
    $('#searchView').on( 'keyup', function () {
        var table = $('#tblDetalleReportes').DataTable();
        table.search(this.value).draw();
    });
    $('#searchClientes').on( 'keyup', function () {
        var table = $('#tblMetaCobro').DataTable();
        table.search(this.value).draw();
        var table = $('#tblVentaValores').DataTable();
        table.search(this.value).draw();
        var table = $('#tblItemsFacturados').DataTable();
        table.search(this.value).draw();
        var table = $('#tblMontoFactura').DataTable();
        table.search(this.value).draw();
        var table = $('#tblpromItemFact').DataTable();
        table.search(this.value).draw();
    });
    
    
    $( "#cmbVendedor" ).change(function() {
        var table = $('#tblmonitoreo').DataTable();
        table.columns(0).search($(this).val()).draw();
        var table = $('#tblmonitoreo2').DataTable();
        table.columns(0).search($(this).val()).draw();
    });
    $( "#chkTipo" ).change(function() {
        if ($(this).is(':checked')) {
            $("#monitoreo1").hide();
            $("#monitoreo2").show();
        }else{
            $("#monitoreo1").show();
            $("#monitoreo2").hide();
        }
    });
});
function getDetalle (ruta,texto,tipo) {
            $("#modalView").openModal();
            $("#titulM").html(texto);
            $('#loadDetalle').show();
            if(ruta !=""){
            $('#loadIMG').show();
            $('#view').html('');
            $('#view').html('<table id="tblDetalleReportes" class="TblDatos center"><thead><tr></tr></thead></table>');

            var data,
                tableName= '#tblDetalleReportes',
                columns,
                str,
                jqxhr = $.ajax("detalleMonitoreo/"+ruta+"/"+tipo)
                        .done(function () {
                            data = JSON.parse(jqxhr.responseText);
                $.each(data.columns, function (k, colObj) {
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo(tableName+'>thead>tr');
                });
                data.columns[0].render = function (data, type, row) {
                    return data;
                }
                $(tableName).dataTable({
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo base_url(); ?>assets/data/swf/copy_csv_xls_pdf.swf",
                    },
                    "data": data.data,
                    "columns": data.columns,
                    "info":false,
                    "order": [[ 1, "desc" ]],
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, -1], [10, "Todo"]],
                    "language": {
                        "emptyTable": "NO HAY DATOS DISPONIBLES",
                        "lengthMenu": '_MENU_ ',
                        "search": '<i class=" material-icons">search</i>',
                        "loadingRecords": "Cargando...",
                        "paginate": {
                            "first": "Primera",
                            "last": "Última ",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        }
                    },                    
                    "fnInitComplete": function () {
                    $('#tblDetalleReportes').on( 'init.dt', function () {
                        $('#loadDetalle').hide();                     
                    }).dataTable();
                    }
                });
            })
            .fail(function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                console.log(msg);
                mensaje(msg,"error");
            });
        }else{mensaje("SELECCIONE UN RANGO DE FECHAS","error");}
}

    function getCliente (ruta) {
        $('#titulC').html('CLIENTES '+ruta);
        $('#modalMonClientes').openModal();
            if(ruta !=""){
            $('#loadIMG').show();
            $('#view').html('');
            $('#metaCobro').html('');
            $('#ventaEnValores').html('');
            $('#itemsFacturados').html('');
            $('#montoFactura').html('');
            $('#promItemFact').html('');

                $('#metaCobro').html('<table id="tblMetaCobro" class="TblDatos center"><thead><tr></tr></thead></table>');
                $('#ventaEnValores').html('<table id="tblVentaValores" class="TblDatos center"><thead><tr></tr></thead></table>');
                $('#itemsFacturados').html('<table id="tblItemsFacturados" class="TblDatos center"><thead><tr></tr></thead></table>');
                $('#montoFactura').html('<table id="tblMontoFactura" class="TblDatos center"><thead><tr></tr></thead></table>');
                $('#promItemFact').html('<table id="tblpromItemFact" class="TblDatos center"><thead><tr></tr></thead></table>');
                cargarDato("tblMetaCobro",ruta,"metaCobroCliente","#load1");
                cargarDato("tblVentaValores",ruta,"ventaValores","#load2");
                cargarDato("tblItemsFacturados",ruta,"itemFacturados","#load3");
                cargarDato("tblMontoFactura",ruta,"montoFactura","#load4");
                cargarDato("tblpromItemFact",ruta,"promedioItemFact","#load5");
        }else{mensaje("SELECCIONE UN VENDEDOR","error");}
    }
    function cargarDato (tabla,ruta,url,carga) {
        $(carga).show();
        var data,
                tableName= '#'+tabla,
                columns,
                str,
                jqxhr = $.ajax(url+"/"+ruta)
                        .done(function () {
                            data = JSON.parse(jqxhr.responseText);
                $.each(data.columns, function (k, colObj) {
                    str = '<th>' + colObj.name + '</th>';
                    $(str).appendTo(tableName+'>thead>tr');
                });
                data.columns[0].render = function (data, type, row) {
                    return data;
                }
                $(tableName).dataTable({
                    "dom": 'T<"clear">lfrtip',
                    "tableTools": {
                        "sSwfPath": "<?php echo base_url(); ?>assets/data/swf/copy_csv_xls_pdf.swf",
                    },
                    "data": data.data,
                    "columns": data.columns,
                    "info":false,
                    "order": [[ 1, "desc" ]],
                    "pagingType": "full_numbers",
                    "lengthMenu": [[10, -1], [10, "Todo"]],
                    "language": {
                        "emptyTable": "NO HAY DATOS DISPONIBLES",
                        "lengthMenu": '_MENU_ ',
                        "search": '<i class=" material-icons">search</i>',
                        "loadingRecords": "Cargando...",
                        "paginate": {
                            "first": "Primera",
                            "last": "Última ",
                            "next":       "Siguiente",
                            "previous":   "Anterior"
                        }
                    },                    
                    "fnInitComplete": function () {
                    $(tableName).on( 'init.dt', function () {
                        $(carga).hide();
                    }).dataTable();
                    }
                });
            })
            .fail(function (jqXHR, exception) {
                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                $(carga).hide();
                mensaje(msg,"error");
            });
    }    
   
</script>