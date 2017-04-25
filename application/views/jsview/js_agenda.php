<script>
    var idGlo;
    $(document).ready(function() {
    $('#calendario').fullCalendar({
         header: {
                left: '',
                center: 'title',
                right: ''},
            lang: 'es',//PONE EL LENGUAJE A ESPAÑOL
            defaultView: 'basicWeek',//MUESTRA EL CALENDARIO EN SEMANA
            hiddenDays: [0,6], //CODIGO PARA OCULTAR EL DOMINGO
            editable: false, //EKISDE
    });
    $('#tblAgenda').DataTable({
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
    function getview(id,vendedor,f1,f2) {
        idGlo=id;
        $("#modalDetalleAgenda").openModal();
        $(".progress").show();
        $('#calendario').fullCalendar('destroy');        
        $("#idVendedor").text(vendedor);
        $("#f1").text("DESDE: "+f1);
        $("#f2").text("HASTA: "+f2);
        $('#calendario').fullCalendar({
                            header: {
                                left: '',
                                center: 'title',
                                right: '',
                                left: 'prev,next today myCustomButton',
                                right: 'month,basicWeek,agendaDay',
                            },
                            displayEventTime: false,
                            lang: 'es',
                            defaultView: 'basicWeek',
                            hiddenDays: [0,6], 
                            editable: false,
                            events: "ajaxCalendario/"+id,
                            eventAfterAllRender: function(){
                                var form_data = {
                                IdPlan: idGlo
                                };
                                $.ajax({
                                    url: "traerComentario",
                                    type: "post",
                                    async:true,
                                    data: form_data,
                                    success:
                                    function(json){
                                        $("#observaciones").val("");
                                        $("#observaciones").val(json);
                                    }
                                });
                            }
        }); 
    $('#calendar').fullCalendar('gotoDate', currentDate);

        setTimeout(function(){ $(".progress").hide(); }, 2200);
    }

    $("#saveComente").click(function(){
        /*var clientevents = $('#calendar').fullCalendar('clientEvents');
        jQuery.each( clientevents, function( i, val ) {
            alert(val);
        });*/    
        var form_data = {
            IdPlan: idGlo,
            Comen: $("#observaciones").val()
            };
            $.ajax({
                url: "guardarComentario",
                type: "post",
                async:true,
                data: form_data,
                success:
                function(json){
                    if (json==1) {
                        mensaje("COMENTARIO GUARDADO CORRECTAMENTE... ESPERE");
                        window.setTimeout($(location).attr('href',"agenda"), 3500);
                    }else{mensaje("ERROR AL GUARDAR EL COMENTARIO, INTENTELO DE NUEVO","error");}
                }
            });
    })    
</script>