<?php
    $file = "Manual_de_Uso___Mocovi_Extensi_n.pdf";

    if(!file_exists($file)) die("Disculpe hubo un error al momento de obtener el Manual intente nuevamente.");

    $type = filetype($file);
    // Get a date and timestamp
    $today = date("F j, Y, g:i a");
    $time = time();
    // Send file headers
    header("Content-type: $type");

    header("Content-Disposition: attachment;filename=Manual_Ayuda.pdf");
    header("Content-Transfer-Encoding: binary"); 
    header('Pragma: no-cache'); 
    header('Expires: 0');
    // Send the file contents.
    set_time_limit(0);
    ob_clean();
    flush();
    readfile($file);
?>