<?php 
class ContactoModel extends Model {

    const CODIGO = 'xmxwebdemo2';

    const USUARIO_PREFIJO = 'XMX';
    const USUARIO_LONGITUD = 6;

    const NOMBRE_LONG_MIN = 5;
    const NOMBRE_LONG_MAX = 15;

    const CARGO_LONG_MIN = 5;
    const CARGO_LONG_MAX = 10;

    const TEL_PREFIJO = "+57";
    const TEL_LONGITUD = 7;

    private $contacto = null;
    static private $tiposContacto = [
        '1' => 'Contacto Comercial',
        '2' => 'Pago de factura',
        '3' => 'Representante legal',
        '4' => 'Retiro de mercadería'
    ];

    function __construct() {
        parent::__construct();
    }

    function formLoad() {
        $data = IS_POST ? $_POST : ['infoCodigo'=>self::CODIGO];
        $data['tiposContacto'] = self::$tiposContacto;
        return $data;
    }
    
    function formSubmit() {

        extract($_POST);
        
        // ----- Validaciones ----
        $errores = [];

        // Código fijo
        if ($infoCodigo !== self::CODIGO)
            $errores[] = 'Código de cliente inválido.';

        // Usuario
        $infoUsuario = trim($infoUsuario);
        $usrPref = strpos($infoUsuario, self::USUARIO_PREFIJO) === 0; // Inicia con prefijo
        $usrLen = strlen($infoUsuario) == self::USUARIO_LONGITUD;
        if (!$usrPref || !$usrLen) {
            $error = [];
            if (!$usrPref)
                $error[] = 'debe empezar con '.self::USUARIO_PREFIJO;
            if (!$usrLen)
                $error[] = 'debe tener '.self::USUARIO_LONGITUD.' caracteres de longitud';
            
            $errores[] = 'Usuario inválido: '.implode(', ', $error).'.';
        }

        // Nombre
        $infoNombre = trim($infoNombre);
        $nombreLen = strlen($infoNombre);
        if ($nombreLen < self::NOMBRE_LONG_MIN || $nombreLen > self::NOMBRE_LONG_MAX)
            $errores[] = "Nombre inválido: debe tener entre ".self::NOMBRE_LONG_MIN." y ".self::NOMBRE_LONG_MAX." caracteres.";

        // Cargo
        $infoCargo = trim($infoCargo);
        $cargoLen = strlen($infoCargo);
        if ($cargoLen < self::CARGO_LONG_MIN || $cargoLen > self::CARGO_LONG_MAX)
            $errores[] = "Cargo inválido: debe tener entre ".self::CARGO_LONG_MIN." y ".self::CARGO_LONG_MAX." caracteres.";

        // Teléfono
        $infoTelefono = trim($infoTelefono);
        $telLen = strlen($infoTelefono);
        if ($telLen != self::TEL_LONGITUD)
            $errores[] = "Teléfono inválido: debe tener ".self::TEL_LONGITUD." dígitos.";
        $infoTelefono = self::TEL_PREFIJO . $infoTelefono;

        // Correo (verificación simple, aplica a casi todo el RFC5321)
        $infoEmail = trim($infoEmail);
        if (!filter_var($infoEmail, FILTER_VALIDATE_EMAIL)) {
            $errores[] = "Correo eletrónico inválido.";
        }

        // Tipo de contacto
        $infoTipoContacto = (int)$infoTipoContacto;
        if ($infoTipoContacto <= 0) {
            $errores[] = "Tipo de contacto inválido.";
        }

        if ($errores) {
            return ErrorHandler::throw("Los datos a guardar tienen errores", $errores);
        }

        // Generación de contraseña
        $letras = '';
        $cantLetras = 4;
        while ($cantLetras-- > 0)
            $letras .= chr(65 + rand(0,25));
        
        $numeros = '';
        $cantNumeros = 4;
        while ($cantNumeros-- > 0)
            $numeros .= rand(0, 9);
        
        $password = str_shuffle($numeros . $letras);
        
        // Armado de registro
        $contacto = [
            'codigo_cliente' => $infoCodigo,
            'usuario' => $infoUsuario,
            'nombre' => $infoNombre,
            'cargo' => $infoCargo,
            'telefono' => $infoTelefono,
            'celular' => $infoCelular,
            'email' => $infoEmail,
            'tipo_contacto_id' => $infoTipoContacto,
            'password' => $password,
            'webstore' => (int)(bool)$infoAutorizaWebStore,
            'ordenes_crear' => (int)(bool)$infoAutorizaCrearOrdenes,
            'envio_acceso' => (int)(bool)$infoEnvioAcceso,
        ];

        $this->contacto = DB::query("
            INSERT INTO contacto (".implode(",",array_keys($contacto)).") 
            values ('".implode("','", $contacto)."')
        ");

        if (!$this->contacto) {
            return ErrorHandler::throw("No se pudo guardar el registro.");
        }

        return $this->contacto;
    }
}