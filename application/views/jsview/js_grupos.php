<script>
$(document).ready(function() {
        $("#modalEdit").openModal();
		$('#tblCobros').DataTable({
            "scrollCollapse": true,
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
        $('#tbl1,#tbl2').DataTable({
            "scrollCollapse": true,
            "info":    false,            
            "lengthMenu": [[100-1], [100,"Todo"]],
            "paging": false,
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
        $('#tbl1 tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        });
        $('#tbl2 tbody').on( 'click', 'tr', function () {
            $(this).toggleClass('selected');
        });
});
    
    $("#guardarGrupo").click(function(){
        if ($('#grupo').val()=="" || $('#grupo').val().length<5) {
            mensaje("DIGITE UN NOMBRE VALIDO","error");$('#grupo').focus();return false;
        }if ($("#ListUser").val()==null) {
            mensaje("SELECCIONE UN RESPONSABLE DE GRUPO","error");$('#ListUser').focus();return false;
        }else{
            $('#loadDetalle').show();
            document.getElementById("formNuevoGrupo").submit();
        }
    });
    function editGrupo (id,nombre) {
        $("#modalEdit").openModal();
        $("#titul").html("GRUPO: "+nombre);
        $("#loadTabla").show();
        $("#tbl2").hide();
        var tbl2 = $("#tbl2").DataTable();
            limpiarTabla(tbl2);
            $('#tbl2').DataTable({
                ajax: "getVendedoresGrupo/"+ id,
                "info":    false,
                "bPaginate": false,
                "paging": false,
                "ordering": false,
                "pagingType": "full_numbers",
                "emptyTable": "No hay datos disponibles en la tabla",
                    columns: [
                            { "data": "FECHA" },
                            { "data": "FACTURA" },
                            { "data": "DISPONIBLE" },
                            { "data": "CAM1" },
                            { "data": "CAM2" }
                        ]
                });
            $("#loadTabla").hide();
            $("#tbl2").show();
    }
    function limpiarTabla (idTabla) {
        idTabla = $(idTabla).DataTable();
        idTabla.destroy();
        idTabla.clear();
        idTabla.draw();
    }
</script>