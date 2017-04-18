$(document).ready(function() {
    $('#calendario').fullCalendar({
         header: {
                left: '',
                center: 'title',
                right: ''},
            lang: 'es',//PONE EL LENGUAJE A ESPAÑOL
            defaultView: 'basicWeek',//MUESTRA EL CALENDARIO EN SEMANA
            hiddenDays: [0], //CODIGO PARA OCULTAR EL DOMINGO
            editable: false, //EKISDE
    });
    /*evento para cargar los eventos por ruta*/
    $("#selectRuta").change(function(){
        $(".progress").show();
        //alert(this.value);
        $('#calendario').fullCalendar( 'destroy' );//DESTRUYE EL CALENDARIO PARA LIMPIARLO
        $('#calendario').fullCalendar({//SE VUELVE A CREAR EL CALENDARIO
                            header: {
                                left: '',
                                center: 'title',
                                right: ''
                            },
                            displayEventTime: false,
                            lang: 'es',//PONE EL LENGUAJE A ESPAÑOL
                            defaultView: 'basicWeek',//MUESTRA EL CALENDARIO EN SEMANA
                            hiddenDays: [0], //CODIGO PARA OCULTAR EL DOMINGO
                            editable: false, //EKISDE
                            eventDurationEditable:true,
                            events: "ajaxCalendario/"+this.value,//RUTA DEL AJAX PARA TRAER LOS EVENTOS                                 
        }); 
        setTimeout(function(){ $(".progress").hide(); }, 2200);   
    });
});



  



