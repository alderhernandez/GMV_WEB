<header class="demo-header mdl-layout__header ">
    <div class="row center ColorHeader"><span class=" title">GRUPOS<i class="material-icons right">view_quilt</i></span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m1">REPORTES</div></div>
    

    <div class="row center">        
            <a href="#" onclick="FiltrarReporte('PEDIDOS POR VENDEDOR','pedidos_por_vendedor')" class=" IconBlue ">
                <i class="medium material-icons iconoCenter">person_add</i>
                <p class="TextIconos">PEDIDOS POR VENDEDOR</p>
            </a>
    </div>
</div>
</main>  
<!-- FIN CONTENIDO PRINCIPAL -->


<div id="modalFiltrado" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>

        <h6 id="tituloFiltrado" class="center Mcolor AdUser"></h6>

        <div class="row">
            <form class="col s12" action=""method="post" name="formSP">

                <div class="row">
                    <div class="input-field col s6">
                        <input name="fecha1" placeholder="Desde" id="fecha1" type="text" class="datepicker1">
                    </div>
                    <div class="input-field col s6">
                        <input name="fecha2" placeholder="Hasta" id="fecha2" type="text" class="datepicker1">

                    </div>
                </div>
            </form>
        </div>
        <div class="row center">
                <a href="#" id="generarDetalleReporte" class="Btnadd btn">GENERAR</a>
        </div>
    </div><!-- FIN CONTENIDO MODAL -->
</div>


<div id="SPdet" class="modal">
    <div class="modal-content">
        <div class="right row">
                <a href="#!" class=" BtnClose modal-action modal-close ">
                    <i class="material-icons">highlight_off</i>
                </a>
        </div>
        <h6 id="tituloFiltrado2" class="center Mcolor AdUser">MASTER CLIENTES SP</h6>

        <div class="row noMargen">
            <div class="col s5 m4 l3 offset-l3 offset-m3 offset-s1">
                <p id="f1Detail" class="fecha"></p>
                <p class="rango">Desde</p>
            </div>
            <div class="col s5 m4 l3">
                <p id="f2Detail" class="fecha"></p>
                <p class="rango">Hasta</p>
            </div>
        </div>
        <div class="noMargen Buscar row column">
            <div class="col s1 m1 l1 offset-l3 offset-s1 offset-m2">
                <i class="material-icons ColorS">search</i>
            </div>

            <div class="input-field col s9 m7 l4">
                <input  id="searchReporte" type="text" placeholder="Buscar" class="validate">
                <label for="searchReporte"></label>
            </div>
        </div>
        <div id="Total2" class="right row text noMargen" style="display:none;">
            <div class="col s8 m8 l12">
                <p class="Dato">TOTAL DE PUNTOS: <span id="spanTotal" class="dato"></span></p>
            </div>
        </div>
        <div id="loadIMG" style="display:none" class="progress">
            <div class="indeterminate"></div>
        </div>
        <div class="row" id="miTablaReportes">
            
            <table id="tblDetalleReportes" class="TblDatos">
               <thead><tr></tr></thead>
            </table>
        </div>
    </div><!-- Fin Contenido Modal -->
</div>
