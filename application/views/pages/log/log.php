<header class="demo-header mdl-layout__header ">
    <div class="row center ColorHeader"><span class=" title">LOG DE SISTEMA<i class="material-icons right">equalizer</i></span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m1">LOG DE SISTEMA</div></div>
    <div class="Buscar row column">               
      <div class="col s1 m1 l1 offset-l3 offset-m2"><i class="material-icons ColorS">search</i></div>
        <div class="input-field col s11 m6 l5">
        <input  id="search" type="text" placeholder="Buscar" class="validate mayuscula">
      </div>
      <div class="noMargen col s6 m2 l2">
            <select id="cmbVendedor">
              <option value="" selected>USUARIO</option>
              <?php foreach ($rutas as $key) {
                  echo "<option value=".$key['Usuario'].">".$key['Usuario']."</option>";
                }
               ?>
            </select>
        </div>
    </div>
            
    <div class="row" id="monitoreo1">
        <table id="tbllog" class="TblDatos">
            <thead>
                <tr>
                    <th>USUARIO</th>
                    <th>FECHA</th>
                    <th>MÓDULO</th>
                    <th>ACCIÓN</th>
                </tr>
            </thead>
            <tbody class="center">
               <?php if (!($datos)) {}else{
                  foreach ($datos as $key) {
                    echo "<tr>
                            <td class='negra'>".$key['Usuario']."</td>
                            <td>".date('H:i:s d-m-Y',strtotime($key['Fecha']))."</td>
                            <td>".$key['Modulo']."</td>
                            <td class='negra'>".$key['Accion']."</td>
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
