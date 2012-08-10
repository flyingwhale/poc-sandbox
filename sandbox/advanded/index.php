<?php
require_once ("../../autoload.php");
require_once (__DIR__."/lib/common.php");

use Poc\Poc;
use Poc\Cache\CacheImplementation\FileCache;

$db = new Dasboard;

$poc  = new Poc(array(Poc::PARAM_CACHE => new FileCache(array(\Poc\Cache\CacheImplementation\Cache::PARAM_TTL=>10)),
               Poc::PARAM_DEBUG => $db->getValue('Debug')
        ));

$poc->getFilter()->addBlacklistCondition( (isset($_POST) && !empty($_POST)) );
//$poc->getFilter()->addBlacklistCondition( );


foreach ($plugins as $plugin => $val){

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
            case 'CIA':
                $poc->addPlugin(new \Poc\PocPlugins\CacheInvalidationProtection\CIAProtector);
                break;

        }
    }
}


$poc->start();
include_once('lib/text_generator.php');

