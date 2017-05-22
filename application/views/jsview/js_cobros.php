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

        /************GRAFICOS HIGHTCHARTS************/

        var options = {
        chart: {
            type: 'pie',
            renderTo: 'container',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'ESTADO DE PEDIDOS'
        },
        plotOptions: {
        pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            type: 'pie',
            name: 'CANTIDAD',
            data: []
            }]
        }
        $.getJSON("ajaxGrafica", function(json) {
            options.series[0].data = json;
            chart = new Highcharts.Chart(options);
        });

        /***************************************/
        var options2 = {
            chart: {
                type: 'column',
                renderTo: 'container2',
                options3d: {
                    enabled: true,
                    alpha: 0,
                    beta: 20
                }
            },
            title: {
                text: 'PEDIDOS POR VENDEDOR'
            },
            xAxis: {
                categories: []
            },
            yAxis: {
                title: {
                    text: 'NUMERO DE PEDIDOS'
                }
            },
            series: [{
                colorByPoint: true,
                data: [],
                showInLegend: false
            }]
        }
        $.getJSON("ajaxGraficaColum", function(json) {
            options2.xAxis.categories = json.name;
            options2.series[0].data = json.data;
            chart = new Highcharts.Chart(options2);
        });
	});

$('#polar').click(function () {
    chart.update({
        chart: {
            inverted: false,
            polar: true
        },
        subtitle: {
            text: 'Polar'
        }
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
    $( "#selectRuta" ).change(function() {
        var table = $('#tblCobros').DataTable();
        table.columns(2).search($(this).val()).draw();
    });
</script>