<?php
//phpinfo()
// cargo una extensión u otra dependiendo del sistema operativo
/*if (!extension_loaded('soap')) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        dl('php_soap.dll');
    } else {
        dl('soap.so');
    }
}*/

//print_r(get_loaded_extensions());
mail("ocmchile@gmail.com", "Ojala llegue el correo", "Esto va en el mensaje");
?>