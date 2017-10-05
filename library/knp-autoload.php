<?php

/**
 * Simple autoloader that follow the PHP Standards Recommendation #0 (PSR-0)
 * @see https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md for more informations.
 *
 * Code inspired from the SplClassLoader RFC
 * @see https://wiki.php.net/rfc/splclassloader#example_implementation
 */
spl_autoload_register(function($className) {
    $package = 'Knp\\Snappy';
    $className = ltrim($className, '\\');
    if (0 === strpos($className, $package)) {
        $fileName = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        if (is_file($fileName)) {
            require $fileName;
            return true;
        }
    }
    return false;
});
/*$mapping = array(
    'Knp\Snappy\AbstractGenerator'  => __DIR__ . '/Knp/Snappy/AbstractGenerator.php',
    'Knp\Snappy\GeneratorInterface' => __DIR__ . '/Knp/Snappy/GeneratorInterface.php',
    'Knp\Snappy\Image'              => __DIR__ . '/Knp/Snappy/Image.php',
    'Knp\Snappy\Pdf'                => __DIR__ . '/Knp/Snappy/Pdf.php',
    'Knp\Snappy\Process'            => __DIR__ . '/Knp/Snappy/Process.php',
    'Knp\Snappy\Process\Exception'  => __DIR__ . '/Knp/Snappy/Exception/Process.php'
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        require $mapping[$class];
    }
}, true);
*/