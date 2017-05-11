<header class="demo-header mdl-layout__header ">
    <div class="row center ColorHeader"><span class=" title">PEDIDOS<i class="material-icons right">equalizer</i></span></div>
</header>
<!--  CONTENIDO PRINCIPAL -->
<main class="mdl-layout__content mdl-color--grey-100">
<div class="contenedor">        
    <div class="noMargen row TextColor center"><div class="col s12 m8 l12 offset-m1">PEDIDOS</div></div>
    
    <div class="noMargen Buscar row column">
        <div class="input-field col s6 m4 l4 offset-l4 center">
            <input  id="searchDatos" type="text"class="validate">
            <label for="searchDatos">BUSCAR</label>
        </div>
    </div>
            
    <div class="row" id="monitoreo1" style="overflow-y:scroll;">
        <table id="tblPedidos" class=" TblDatos">
            <thead>
                <tr>
                    <th>ID PEDIDO</th>
                    <th>VENDEDOR</th>
                    <th>CLIENTE</th>
                    <th>NOMBRE CLIENTE</th>
                    <th>FECHA</th>
                    <th>MONTO</th>
                    <th>ESTADO</th>
                    <th>VER</th>
                </tr>
            </thead>
            <tbody class="center">
                <?php if (!($data)) {}
                        else{
                            foreach ($data as $key) {
                                echo 
                                "<tr>
                                    <td class='negra'>".$key['IDPEDIDO']."</td>
                                    <td>".$key['VENDEDOR']."</td>
                                    <td>".$key['CLIENTE']."</td>
                                    <td>".$key['NOMBRE']."</td>
                                    <td>".$key['FECHA_CREADA']."</td>
                                    <td>".number_format($key['MONTO'],4)."</td>";
                                switch ($key['ESTADO']) {
                                        case '1':
                                            $estado = '<i class="material-icons">check</i>';
                                            break;
                                        case '2':
                                            $estado = '<i class="material-icons">done_all</i>';
                                            break;
                                        case '3':
                                            $estado = '<i class="green-text material-icons">done_all</i>';
                                            break;
                                        default:
                                            
                                            break;
                                    }    
                                echo"<td class='regular'>".$estado."</td>";
                                echo  "<td class='regular'><a  onclick='getview(".'"'.$key['IDPEDIDO'].'"'.",".'"'.$key['NOMBRE']." ".$key['CLIENTE'].'"'.",".'"'.$key['VENDEDOR'].'"'.",".'"'.$key['ESTADO'].'"'.")' href='#' class='noHover'><i class='material-icons'>&#xE417;</i></a>
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

<div id="modalDetalleFact" class="modal">
    <div class="modal-content">
        <div class=" row">
            <div class="right col s1 m1 l1">
                <a href="#!" class=" BtnClose modal-action modal-close noHover"><i class="material-icons">highlight_off</i></a>
            </div>
        </div>
      <div class="row" id="datosPedido">
        <h6  class="TextColor noMargen center negra breadcrumbs-title">PEDIDO: <span class="bold" id="codPedido">0.00</span></h6>
        <h6  class="TextColor noMargen center negra breadcrumbs-title">CLIENTE: <span class="bold" id="codCliente">0.00</span></h6>
        <h6  class="TextColor noMargen center negra breadcrumbs-title">VENDEDOR: <span class="bold" id="codVendedor">0.00</span></h6>
      </div>
        <div class="row">
            <div class="col s12 center">
                <div id="loadIMG" style="display:none" class="preloader-wrapper big active">
                    <div class="spinner-layer spinner-blue-only">
                        <div class="circle-clipper left"><div class="circle"></div></div>
                            <div class="gap-patch"><div class="circle"></div></div>
                        <div class="circle-clipper right"><div class="circle"></div></div>
                    </div>
                </div>
                <table id="TbDetalleFactura" class="TblDatos center">
                    <thead>
                        <tr>
                            <th>ARTICULO.</th>
                            <th>DESCRIPCIÓN</th>
                            <th>CANTIDAD.</th>
                            <th>PRECIO</th>
                            <th>TOTAL</th>
                            <th>BONIFICADO</th>
                        </tr>
                    </thead>

                    <tbody></tbody>
                </table>
            </div>
        </div>
        <div class="row center valign-wrapper">
          <div class="col s2 offset-s5 Mcolor center">
            <a href="#" id="btnProcesar" class="Procesar waves-effect btn">procesar</a>
          </div>
          <div class="col s3 Mcolor valign-wrapper left">
            <p class="negra">TOTAL: </p>
            <p id="total" class="bold breadcrumbs-title">0.00</p>
          </div>
        </div>
    </div>
</div>