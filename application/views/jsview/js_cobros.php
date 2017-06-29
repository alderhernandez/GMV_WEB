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
            text: 'ESTADO DE PEDIDOS (MES ACTUAL)'
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
                text: 'PEDIDOS POR VENDEDOR (MES ACTUAL)'
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
                name: 'CANTIDAD',
                showInLegend: false
            }]
        }
        $.getJSON("ajaxGraficaColum", function(json) {
            options2.xAxis.categories = json.name;
            options2.series[0].data = json.data;
            chart = new Highcharts.Chart(options2);
        });
        /***************************************/
        var options3 = {
            chart: {
                type: 'area',
                renderTo: 'container3'
            },
            title: {
                text: 'PEDIDOS POR VENDEDOR (ULTIMO MES)'
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
                name: 'CANTIDAD',
                showInLegend: false
            }]
        }
        $.getJSON("ajaxGraficaLogaritmica", function(json) {
            options3.xAxis.categories = json.name;
            options3.series[0].data = json.data;
            chart = new Highcharts.Chart(options3);
        });
	});



Highcharts.theme = {
   colors: ['#2b908f', '#59d35e', '#f45b5b', '#7798BF', '#aaeeee', '#ff0066', '#eeaaee',
      '#55BF3B', '#DF5353', '#7798BF', '#aaeeee'],
   chart: {
      backgroundColor: {
         linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
         stops: [
            [0, '#2a2a2b'],
            [1, '#3e3e40']
         ]
      },
      style: {
         fontFamily: '\'Unica One\', sans-serif'
      },
      plotBorderColor: '#606063'
   },
   title: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase',
         fontSize: '20px'
      }
   },
   subtitle: {
      style: {
         color: '#E0E0E3',
         textTransform: 'uppercase'
      }
   },
   xAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      title: {
         style: {
            color: '#A0A0A3'

         }
      }
   },
   yAxis: {
      gridLineColor: '#707073',
      labels: {
         style: {
            color: '#E0E0E3'
         }
      },
      lineColor: '#707073',
      minorGridLineColor: '#505053',
      tickColor: '#707073',
      tickWidth: 1,
      title: {
         style: {
            color: '#A0A0A3'
         }
      }
   },
   tooltip: {
      backgroundColor: 'rgba(0, 0, 0, 0.85)',
      style: {
         color: '#F0F0F0'
      }
   },
   plotOptions: {
      series: {
         dataLabels: {
            color: 'white'
         },
         marker: {
            lineColor: '#333'
         }
      },
      boxplot: {
         fillColor: '#505053'
      },
      candlestick: {
         lineColor: 'white'
      },
      errorbar: {
         color: 'white'
      }
   },
   legend: {
      itemStyle: {
         color: '#E0E0E3'
      },
      itemHoverStyle: {
         color: '#FFF'
      },
      itemHiddenStyle: {
         color: '#606063'
      }
   },
   credits: {
      style: {
         color: '#666'
      }
   },
   labels: {
      style: {
         color: '#707073'
      }
   },

   drilldown: {
      activeAxisLabelStyle: {
         color: '#F0F0F3'
      },
      activeDataLabelStyle: {
         color: '#F0F0F3'
      }
   },

   navigation: {
      buttonOptions: {
         symbolStroke: '#DDDDDD',
         theme: {
            fill: '#505053'
         }
      }
   },

   // scroll charts
   rangeSelector: {
      buttonTheme: {
         fill: '#505053',
         stroke: '#000000',
         style: {
            color: '#CCC'
         },
         states: {
            hover: {
               fill: '#707073',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            },
            select: {
               fill: '#000003',
               stroke: '#000000',
               style: {
                  color: 'white'
               }
            }
         }
      },
      inputBoxBorderColor: '#505053',
      inputStyle: {
         backgroundColor: '#333',
         color: 'silver'
      },
      labelStyle: {
         color: 'silver'
      }
   },

   navigator: {
      handles: {
         backgroundColor: '#666',
         borderColor: '#AAA'
      },
      outlineColor: '#CCC',
      maskFill: 'rgba(255,255,255,0.1)',
      series: {
         color: '#7798BF',
         lineColor: '#A6C7ED'
      },
      xAxis: {
         gridLineColor: '#505053'
      }
   },

   scrollbar: {
      barBackgroundColor: '#808083',
      barBorderColor: '#808083',
      buttonArrowColor: '#CCC',
      buttonBackgroundColor: '#606063',
      buttonBorderColor: '#606063',
      rifleColor: '#FFF',
      trackBackgroundColor: '#404043',
      trackBorderColor: '#404043'
   },

   // special colors for some of the
   legendBackgroundColor: 'rgba(0, 0, 0, 0.5)',
   background2: '#505053',
   dataLabelsColor: 'white',
   textColor: '#C0C0C0',
   contrastTextColor: '#F0F0F3',
   maskColor: 'rgba(255,255,255,0.3)'
};

// Apply the theme
Highcharts.setOptions(Highcharts.theme);

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