<?php
use Doctrine\ORM\EntityManager,
    Doctrine\ORM\Configuration;

$isDevMode = true;

if ($isDevMode) {
    $cache = new \Doctrine\Common\Cache\ArrayCache;
} else {
    $cache = new \Doctrine\Common\Cache\ApcCache;
}

$config = new Configuration;
$config->setMetadataCacheImpl($cache);

$driverImpl = $config->newDefaultAnnotationDriver(__DIR__ . DS . 'src/App/Entities');

$config->setMetadataDriverImpl($driverImpl);
$config->setQueryCacheImpl($cache);
$config->setProxyDir(__DIR__ . DS . 'src/App/Proxies');
$config->setProxyNamespace('App\Proxies');

if ($isDevMode) {
    $config->setAutoGenerateProxyClasses(true);
} else {
    $config->setAutoGenerateProxyClasses(false);
}

// Parâmetros de Configuração do Banco de Dasdos
$conn = parse_ini_file(__DIR__ . DS . 'config.ini');

// Obtendo o Entity Manager
$entityManager = EntityManager::create($conn, $config);
$GLOBALS['em'] = $entityManager;