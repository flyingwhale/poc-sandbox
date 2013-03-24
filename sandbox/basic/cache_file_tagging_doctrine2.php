<?php
/*Copyright 2011 Imre Toth <tothimre at gmail>

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/

require ("../../autoload.php");

use Poc\Poc;
use Poc\Cache\CacheImplementation\FileCache;
use Poc\PocPlugins\PocLogsParams;
use Poc\PocPlugins\PocLogs;
use Poc\Toolsets\NativeOutputHandlers\HttpCapture;

$options['orm.entity_managers.default.connection'] = 'sqlite';
$tagging = new \Poc\PocPlugins\Tagging\Doctrine2Tagging($options);
$poc  = new Poc(array(Poc::PARAM_CACHE => new FileCache(array(FileCache::PARAM_TTL => 300)), Poc::PARAM_TOOLSET => new HttpCapture()));
$poc->addPlugin($tagging);
if(isset($_GET)){
  if(isset($_GET['delcache'])){
    if($_GET['delcache']){
        $tagging->addCacheInvalidationTags(true, 'user');
    }
  }
}
$tagging->addCacheAddTags(true,"user,customer");

$pl = new \Poc\PocPlugins\Logging\PocLogs();
$poc->addPlugin($pl);

$poc->start();
include('lib/text_generator.php');

