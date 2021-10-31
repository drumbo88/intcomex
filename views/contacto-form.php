<form method="POST" action="?a=formSubmit" name="formSubmit">
    <div class="container col-6 d-grid gap-3">
        <h4 class="mb-3">Información de contacto</h4>
        <div class="row">
            <div class="col">
                <label for="infoCodigo" class="form-label">Código de cliente</label>
            </div>
            <div class="col">
                <input 
                    type="text" class="form-control" id="infoCodigo" name="infoCodigo" 
                    value="<?=$infoCodigo?>" readonly required
                >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoUsuario" class="form-label">Usuario *</label>
            </div>
            <div class="col">
                <input 
                    type="text" class="form-control" id="infoUsuario" name="infoUsuario" 
                    value="<?=$infoUsuario?>" placeholder="Usuario *"
                    max="<?=ContactoModel::USUARIO_LONGITUD?>" required
                >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoNombre" class="form-label">Nombre *</label>
            </div>
            <div class="col">
                <input 
                    type="text" class="form-control" id="infoNombre" name="infoNombre" 
                    value="<?=$infoNombre?>" placeholder="Nombre *"
                    max="<?=ContactoModel::NOMBRE_LONG_MAX?>" required
                >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoCargo" class="form-label">Cargo *</label>
            </div>
            <div class="col">
                <input 
                    type="text" class="form-control" id="infoCargo" name="infoCargo" 
                    value="<?=$infoCargo?>" placeholder="Cargo *"
                    max="<?=ContactoModel::CARGO_LONG_MAX?>" required
                >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoTelefono" class="form-label">Teléfono *</label>
            </div>
            <div class="col">
                <input 
                    type="text" class="form-control" id="infoTelefono" name="infoTelefono" 
                    value="<?=$infoTelefono?>" placeholder="Teléfono (<?=ContactoModel::TEL_PREFIJO?>)*"
                    max="<?=ContactoModel::TEL_LONGITUD?>" required
                >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoEmail" class="form-label">Correo electrónico *</label>
            </div>
            <div class="col">
                <input 
                    type="email" class="form-control" id="infoEmail" name="infoEmail" 
                    value="<?=$infoEmail?>" placeholder="Correo electrónico *" required
                >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoCelular" class="form-label">Número celular *</label>
            </div>
            <div class="col">
                <input 
                    type="tel" class="form-control" id="infoCelular" name="infoCelular" 
                    value="<?=$infoCelular?>" placeholder="Número celular *" required
                >
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoTipoContacto" class="form-label">Tipo de contacto *</label>
            </div>
            <div class="col">
                <select type="tel" class="form-control" id="infoTipoContacto" name="infoTipoContacto">
                    <option value="">-- Seleccione un tipo de contacto --</option>
                    <?php 
                    foreach ($tiposContacto as $id => $tipoContacto)
                        echo "<option value=\"$id\" ".(($infoTipoContacto == $id) ? 'selected' : '') .">$tipoContacto</option>";
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoAutorizaWebStore" class="form-check-label">Autorizado para acceder a WebStore</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="infoAutorizaWebStore" name="infoAutorizaWebStore"
                    <?= $infoAutorizaWebStore ? 'checked' : '' ?>>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoAutorizaCrearOrdenes" class="form-check-label">Autorizado para crear órdenes</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="infoAutorizaCrearOrdenes" name="infoAutorizaCrearOrdenes"
                    <?= $infoAutorizaCrearOrdenes ? 'checked' : '' ?>>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="infoEnvioAcceso" class="form-check-label">¿Desea que se envíe la información de acceso al usuario?</label>
            </div>
            <div class="col">
                <input type="checkbox" class="form-check-input" id="infoEnvioAcceso" name="infoEnvioAcceso"
                    <?= $infoEnvioAcceso ? 'checked' : '' ?>>
            </div>
        </div>
        <div class="d-flex justify-content-end gap-3">
            <button id="btnSubmit" name="btnSubmit" class="btn btn-primary" type="submit">Aceptar</button>
            <button id="btnCancel" name="btnCancel" class="btn btn-danger" onclick="">Cancelar</button>
        </div>
    </div>
</form>

<script>
    document.getElementById('btnCancel').addEventListener('click', function (e) {
        e.preventDefault(); location.href = '<?=ROOT_DIR?>'
    });

    window.formSubmit.addEventListener('submit', function (e) {
        
        // Validaciones
        var errores = [];
        if (this.infoCodigo.value != '<?=ContactoModel::CODIGO?>')
            errores.push('Código de cliente inválido.');

        // Usuario
        const infoUsuario = this.infoUsuario.value.trim();
        const usrPref = infoUsuario.indexOf('<?=ContactoModel::USUARIO_PREFIJO?>') === 0; // Inicia con prefijo
        const usrLen = infoUsuario.length == <?=ContactoModel::USUARIO_LONGITUD?>;
        if (!usrPref || !usrLen) {
            var error = [];
            if (!usrPref)
                error.push('debe empezar con <?=ContactoModel::USUARIO_PREFIJO?>');
            if (!usrLen)
                error.push('debe tener <?=ContactoModel::USUARIO_LONGITUD?> caracteres de longitud');
            
            errores.push('Usuario inválido: '+error.join(', ')+'.');
        }

        // Nombre
        const infoNombre = this.infoNombre.value.trim();
        const nombreLen = infoNombre.length;
        if (nombreLen < <?=ContactoModel::NOMBRE_LONG_MIN?> || nombreLen > <?=ContactoModel::NOMBRE_LONG_MAX?>)
            errores.push("Nombre inválido: debe tener entre <?=ContactoModel::NOMBRE_LONG_MIN?> y <?=ContactoModel::NOMBRE_LONG_MAX?> caracteres.");

        // Cargo
        const infoCargo = this.infoCargo.value.trim();
        const cargoLen = infoCargo.length;
        if (cargoLen < <?=ContactoModel::CARGO_LONG_MIN?> || cargoLen > <?=ContactoModel::CARGO_LONG_MAX?>)
            errores.push("Cargo inválido: debe tener entre <?=ContactoModel::CARGO_LONG_MIN?> y <?=ContactoModel::CARGO_LONG_MAX?> caracteres.");

        // Teléfono
        var infoTelefono = this.infoTelefono.value.trim();
        const telLen = infoTelefono.length;
        if (telLen != <?=ContactoModel::TEL_LONGITUD?>)
            errores.push("Teléfono inválido: debe tener <?=ContactoModel::TEL_LONGITUD?> dígitos.");
        infoTelefono = <?=ContactoModel::TEL_PREFIJO?> . infoTelefono;

        // Correo (verificación simple, aplica a casi todo el RFC5321)
        const infoEmail = this.infoEmail.value.trim();
        if (!validarEmail(infoEmail)) {
            errores.push("Correo eletrónico inválido.");
        }

        // Tipo de contacto
        const infoTipoContacto = parseInt(this.infoTipoContacto.value);
        if (infoTipoContacto == 0) {
            errores.push("Tipo de contacto inválido.");
        }

        if (errores.length) {
            alert('Verifique los datos del formulario:\n'+errores.map(function (v) { return ' - '+v }).join('\n'));
            e.preventDefault();
            return false;
        }
    });
    function validarEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }
</script>