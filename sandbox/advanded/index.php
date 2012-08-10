<?php
require ("../../autoload.php");
require (__DIR__."/lib/common.php");

use Poc\Poc;
use Poc\Cache\CacheImplementation\FileCache;

$poc  = new Poc(array(Poc::PARAM_CACHE => new FileCache(array(\Poc\Cache\CacheImplementation\Cache::PARAM_TTL=>10)),
               Poc::PARAM_DEBUG => false
        ));


$db = new Dasboard;

foreach ($plugins as $plugin){

    if($db->getValue($plugin)){
        $poc->getHasher()->addDistinguishVariable($plugin);
        switch ($plugin)
        {
            case 'ETAG':
                $poc->addPlugin(new \Poc\PocPlugins\HttpCache\Etag);
                break;
            case 'Compress':
                $poc->addPlugin(new \Poc\PocPlugins\Output\Compress);
                break;
        }
    }
}


$poc->start();
include('lib/text_generator.php');

