<?php

$file = __DIR__ . '/../_phar/JobQueue.phar';

if (ini_get('Phar.readonly')) {
    die('Error: Cannot create Phar. "Phar.readonly" must be set to Off in php.ini' . PHP_EOL);
}

if ($argc < 4) {
    die('Usage : ' . $argv[0] . ' <project-name> <src-dir> <target-dir> [<stub-filename>]' . PHP_EOL);
}

$project = $argv[1];
$src = $argv[2];
$target = $argv[3];
$file = $target . '/' . $project . '.phar';

if (isset($argv[4])) {
    $stub = $argv[4];
} else {
    $stub = __DIR__ . '/../templates/PharStub.php';
}

$stub = realpath($stub);
$dir = realpath(dirname($file));

print 'Creating Phar file "' . $file . '"' . PHP_EOL . 
      'for project "' . $project . '"' . PHP_EOL .
      'from directory "' . $src . '"' . PHP_EOL .
      'based on stub "' . $stub . '"' . PHP_EOL . PHP_EOL;

if (!Phar::isValidPharFilename($file)) {
    die('Filename "' . $file . '" is not a valid Phar filename' . PHP_EOL);
}

if (!file_exists($dir)) {
    mkdir($dir);
    print 'Created target directory ' . $dir . PHP_EOL;
}

if (file_exists($file)) {
    unlink($file);
    print 'Deleted existing file ' . $file . PHP_EOL;
}

$phar = new Phar($file, 0, $project . '.phar');
$phar->buildFromDirectory($src);
$phar->setStub(str_replace('__PROJECT__', $project, file_get_contents($stub)));

print 'Wrote Phar file' . PHP_EOL . PHP_EOL;

print 'Done.' . PHP_EOL;

?>
