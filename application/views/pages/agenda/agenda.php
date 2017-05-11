<header class="demo-header mdl-layout__header ">
    <div class="row center ColorHeader"><span class=" title">AGENDA<i class="material-icons right">date_range</i></span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m1">AGENDA</div></div>
    
    <div class="noMargen Buscar row column">
        <div class="input-field col s5 m3 l4 offset-s2 offset-l4 center">
            <input  id="searchDatos" type="text"class="validate">
            <label for="searchDatos">BUSCAR</label>
        </div>
        <div class="input-field col s1 center">
           <a href="#" id="searchC"><i class="material-icons">search</i></a>
        </div>
    </div>
    <div class="row">
        <table id="tblAgenda" class=" TblDatos">
            <thead>
                <tr>
                    <th>RUTA</th>
                    <th>VENDEDOR</th>
                    <th>INICIO</th>
                    <th>FINAL</th>
                    <th>VER</th>
                </tr>
            </thead>
            <tbody class="center">
            <?php 
                if(!$agendas){
                } else {
                    foreach($agendas as $index){
                        echo "<tr>
                                    <td class='negra'>".$index['Ruta']."</td>
                                    <td class=''>".$index['Vendedor']."</td>
                                    <td class='negra'>".date('d-m-Y',strtotime($index['Inicia']))."</td>
                                    <td class='negra'>".date('d-m-Y',strtotime($index['Termina']))."</td>
                                    <td class='center details'>
                                        <a  onclick='getview(".'"'.$index['IdPlan'].'",'.'"'.$index['Vendedor'].'",
                                            '.'"'.date('d-m-Y',strtotime($index['Inicia'])).'",'.'"'.date('d-m-Y',strtotime($index['Termina'])).'"'.")' 
                                            href='#' class='noHover'><i class='material-icons'>&#xE417;</i>
                                        </a>
                                    </td>
                              </tr>";
                    }
                }
            ?>
            </tbody>
        </table>
    </div>
</div>
</main>  
<!-- FIN CONTENIDO PRINCIPAL -->

<div id="modalDetalleAgenda" class="modal modal-fixed-footer">
    <div class="modal-content"><br><br>
        <div class="right row">
            <a href="#!" class=" BtnClose modal-action modal-close ">
                <i class="material-icons">highlight_off</i>
            </a>
        </div>
        <div class="row center">
            <p id="idVendedor" class="Datos noMargen"></p>
            <div class="col s2 offset-s4">
                <p id="f1" class="Datos">DESDE</p>
            </div>
            <div class="col s2">
                <p id="f2" class="Datos">HASTA</p>
            </div>
        </div>
        <div class="col s12 m12 l12">
            <div id='calendario'></div>
        </div>
        <div class="row">
            <p class="Datos">OBSERVACIONES</p>
            <textarea id="observaciones" class="materialize-textarea observaciones"></textarea>
        </div>
        <div class="row center">
            <a href="#" id="saveComente" class="waves-effect waves-light btn BtnBlue">
                <i class="material-icons right">save</i>GUARDAR
            </a>
        </div>
    </div>    
</div>