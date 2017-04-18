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
    
    <div class="row" id="monitoreo1">
        <div class="input-field col s6 l2 offset-l10">
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
        <div class="col s12 m12 l12">
            <div id='calendario'></div>
        </div>
    </div>

</div>
</main>  
<!-- FIN CONTENIDO PRINCIPAL -->