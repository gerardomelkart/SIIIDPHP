<?php
spl_autoload_register(function ($class) {
    log_message('debug', 'Cargando clase: ' . $class);
    $prefixes = [
        'PhpOffice\\PhpSpreadsheet\\' => __DIR__ . '/src/PhpSpreadsheet/',
        'Psr\\SimpleCache\\'          => APPPATH . 'libraries/Psr/SimpleCache/',
    ];

    foreach ($prefixes as $prefix => $base_dir) {
        $len = strlen($prefix);
        if (strncmp($class, $prefix, $len) === 0) {
            $relative_class = substr($class, $len);
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
});

