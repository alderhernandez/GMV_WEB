<script>
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

    //$("#selectRuta").change(function(){
        
    //});    
});
    function getview(id) {
        $("#modalDetalleAgenda").openModal();
        $(".progress").show();
        $('#calendario').fullCalendar('destroy');
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
                            editable: true,
                            events: "ajaxCalendario/"+id,
        }); 
        setTimeout(function(){ $(".progress").hide(); }, 2200);   
    }
</script>