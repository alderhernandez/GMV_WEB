<header class="demo-header mdl-layout__header ">
    <div class="row center ColorHeader"><span class=" title">PLAN DE TRABAJO<i class="material-icons right">backup</i></span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m1">PLANES DE TRABAJO</div></div>
    
    <div class="noMargen Buscar row column">
        <div class="input-field col s5 m3 l4 offset-s2 offset-l4 center">
            <input  id="searchDatos" type="text"class="validate">
            <label for="searchDatos">BUSCAR</label>
        </div>
        <div class="input-field col s1 center">
           <a href="#" id="searchC"><i class="material-icons">search</i></a>
        </div>
    </div>    
    <div class="row right">
        <div class="col s3 left">
            <select class="regular" id="selectRuta">
                <option value="" disabled selected>Seleccione la ruta...</option>
                <?php 
                    if (!($ruta)) {}
                    else{
                        foreach ($ruta as $key) {
                            echo "<option value=".$key['IdUser'].">".$key['Usuario']."</option>";
                        }                               
                    }
                ?>
            </select>
        </div>
        <div class="col s6 right">
            <a href="#modal1" class="modal-trigger waves-effect waves-light btn BtnBlue">
                <i class="material-icons right">backup</i>SUBIR
            </a>
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

<!-- Modal #1 -->
<div id="modal1" class="modal">
    <div class="btnCerrar right"><i style='color:red;' class="material-icons modal-action modal-close">highlight_off</i></div>
    
    <div class="modal-content">
        <div class="row TextColor center">
            <div class="col s12 m12 l12">
                ingreso de artículos atravez de archivo<i class="material-icons">assignment_turned_in</i>
            </div>
        </div>
     
        <div>
            <form id="formExcel" name="formExcel" enctype="multipart/form-data" class="col s6 m6 l6" action="<?PHP echo base_url('index.php/subirPlan');?>" method="post">
                <input id="bandera" name="bandera" type="hidden" value="0">
                
                    <div class="row">
                        <div class="input-field offset-l1 col s9" style="margin-top: 0rem;">
                             <div class="file-field input-field">
                              <div class="redondo waves-effect waves-light btn btnArchivo BtnBlue">
                                <span>ARCHIVO EXCEL</span>
                                <input name='file' id="csv" type="file">
                              </div>
                              <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder"INGRESE EL ARCHIVO CSV">
                              </div>
                            </div>
                        </div>
                    </div>
          
                    <div class="row">                        
                        <div id="BtnAddArto" class="col s12 m12 l12 center">
                            <a id="subirExcel" class="redondo waves-effect waves-light btn BtnBlue">SUBIR</a>
                            
                            <div id="loadArchivoExcel" style="display:none" class="preloader-wrapper big active">
                                <div class="spinner-layer spinner-blue-only">
                                    <div class="circle-clipper left"><div class="circle"></div></div>
                                    <div class="gap-patch"><div class="circle"></div></div>
                                    <div class="circle-clipper right"><div class="circle"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>