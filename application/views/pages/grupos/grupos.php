<header class="demo-header mdl-layout__header ">
    <div class="row center ColorHeader"><span class=" title">GRUPOS<i class="material-icons right">view_quilt</i></span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m1">GRUPOS</div></div>
    
    <div class="noMargen Buscar row column">
        <div class="input-field col s6 m4 l4 offset-l4 center">
            <input  id="searchDatos" type="text"class="validate">
            <label for="searchDatos">BUSCAR</label>
        </div>
        <div class="col offset-s2 s2 right">
            <a href="#modalView" class="BtnBlue waves-effect btn modal-trigger">NUEVO GRUPO</a>
        </div>
    </div>            
    <div class="row" id="monitoreo1">
        <table id="tblCobros" class=" TblDatos">
            <thead>
                <tr>
                    <th>ID GRUPO</th>
                    <th>NOMBRE</th>
                    <th>RESPONSABLE</th>
                    <th>FECHA CREACIÓN</th>
                    <th>EDITAR</th>
                </tr>
            </thead>
            <tbody class="center">
                <?php 
                    if (!($data)) {}
                    else{
                        foreach ($data as $key ) {
                            echo "<tr>
                                    <td>".$key['IdGrupo']."</td>
                                    <td class='negra'>".$key['NombreGrupo']."</td>
                                    <td>".$key['Responsable']."</td>
                                    <td>".$key['FechaCreada']."</td>                                    
                                    <td class='center'>
                                        <a  onclick='editGrupo(".'"'.$key['IdGrupo'].'","'.$key['NombreGrupo'].'"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>
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
<!-- Modal #1 de detalles-->
<div id="modalView" class="modal">
    <div class="modal-content">
            <div class="right row noMargen">
                <a href="#!" class=" BtnClose modal-action modal-close noHover">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
            <div class="row center">
                <span id="titulM" class="Mcolor">NUEVO GRUPO</span>
            </div>
            <form id="formNuevoGrupo" action="<?PHP echo base_url('index.php/nuevoGrupo');?>" method="post" name="formNuevoGrupo">
                <div class="row">
                    <div class="input-field offset-l1 col s12 m6 l5 ">
                        <input name="grupo" id="grupo" type="text" class="validate mayuscula">
                        <label for="grupo">NOMBRE DEL GRUPO:</label><label id="labelPass1" class="labelValidacion">DIGITE EL NOMBRE</label>
                    </div>
                    <div class="input-field offset-l1 col s12 m6 l5 ">
                        <select class="chosen-select browser-default" name="usuario" id="ListUser">
                        <option value="" disabled selected>RESPONSABLE</option>
                        <?php
                            if(!$dato){}
                            else{
                                    foreach($dato as $key){
                                        echo '<option value="'.$key['IdUser'].'">'.$key['Usuario'].'| '.$key['Nombre'].'</option>';
                                }
                            }
                        ?>
                    </select>
                    </div>
                </div>
            </form>
            <div class="row center">
                <a id="guardarGrupo" class="redondo waves-effect waves-light btn">GUARDAR</a>
                <div id="loadDetalle" style="display:none" class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left"><div class="circle"></div></div>
                        <div class="gap-patch"><div class="circle"></div></div>
                        <div class="circle-clipper right"><div class="circle"></div></div>
                    </div>
                </div>
            </div>
    </div>
</div>


<!-- Modal #1 de detalles-->
<div id="modalEdit" class="modal">
    <div class="modal-content">
            <div class="right row noMargen">
                <a href="#!" class=" BtnClose modal-action modal-close noHover">
                    <i class="material-icons">highlight_off</i>
                </a>
            </div>
            <div class="row center">
                <span id="titul" class="Mcolor">EDICION</span>
            </div>
                <div class="row">
                    <div class="col s5 m5 l5">
                        <div class="row center"><p>VENDEDORES NO AGREGADOS</p></div>
                        <div class="row center">
                            <table id="tbl1" class=" TblDatos">
                                <thead>
                                    <tr>
                                        <th>ID USUARIO</th>
                                        <th>RUTA</th>
                                        <th>NOMBRE</th>
                                    </tr>
                                </thead>
                                <tbody class="center">
                                </tbody>
                            </table>
                            <div id="loadTabla1" style="display:none" class="preloader-wrapper big active">
                                <div class="spinner-layer spinner-blue-only">
                                    <div class="circle-clipper left"><div class="circle"></div></div>
                                    <div class="gap-patch"><div class="circle"></div></div>
                                    <div class="circle-clipper right"><div class="circle"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s2 m2 l2">
                        <br><br><br><br>
                        <div class="row center">
                            <a id="addRight" class="redondo waves-effect waves-light btn"><i class="material-icons center">chevron_right</i></a>
                        </div>
                        <div class="row center">
                            <a id="addLeft" class="redondo waves-effect waves-light btn"><i class="material-icons center">chevron_left</i></a>
                        </div>

                    </div>
                    <div class="col s5 m5 l5">
                        <div class="row center"><p>VENDEDORES AGREGADOS</p></div>
                        <div class="row center">
                            <table id="tbl2" class=" TblDatos">
                                <thead>
                                    <tr>
                                        <th>ID USUARIO</th>
                                        <th>RUTA</th>
                                        <th>NOMBRE</th>
                                    </tr>
                                </thead>
                                <tbody class="center">
                                </tbody>
                            </table>
                            <div id="loadTabla" style="display:none" class="preloader-wrapper big active">
                                <div class="spinner-layer spinner-blue-only">
                                    <div class="circle-clipper left"><div class="circle"></div></div>
                                    <div class="gap-patch"><div class="circle"></div></div>
                                    <div class="circle-clipper right"><div class="circle"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="row center">
                <a id="guardarEdicion" class="redondo waves-effect waves-light btn">GUARDAR</a>
                <div id="loadDetalle2" style="display:none" class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left"><div class="circle"></div></div>
                        <div class="gap-patch"><div class="circle"></div></div>
                        <div class="circle-clipper right"><div class="circle"></div></div>
                    </div>
                </div>
            </div>
    </div>
</div>
