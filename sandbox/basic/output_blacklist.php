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

use Poc\Plugins\TestPlugin\TestPlugin;

use Poc\Cache\CacheInvalidationProtection\CIAProtector;
use Poc\Cache\Filtering\OutputFilter;
use Poc\PocParams;
use Poc\Pocparameters;
use Poc\Cache\Cache\CacheImplementationtation\AbstractPocCacheSpecific;
use Poc\Cache\Header\HeaderManipulator;
use Poc\Cache\Filtering\Evaluateable;
use Poc\Handlers\TestOutput;
use Poc\Cache\PocCache;
use Poc\Cache\CacheImplementation\CacheParams;
use Poc\Cache\CacheImplementation\MemcachedCache;
use Poc\Cache\CacheImplementation\RediskaCache;
use Poc\Cache\CacheImplementation\MongoDBCache;
use Poc\Cache\Filtering\Hasher;
use Poc\Cache\Filtering\Filter;
use Poc\Cache\Tagging\MysqlTagging;
use Poc\PocPlugins\PocLogsParams;
use Poc\PocPlugins\PocLogs;
use Poc\PocPlugins\MinifyHtmlOutput;

$outputFilter = new OutputFilter();
$outputFilter->addBlacklistCondition('/lorem/');

$poc  = new Poc(array(Poc::PARAM_CACHE => new FileCache(),
                      Poc::PARAM_DEBUG => true,
                      Poc::PARAM_OUTPUTFILTER => $outputFilter));

$pl = new PocLogs(array(PocLogsParams::PARAM_POC => $poc));
new MinifyHtmlOutput($poc->getPocDispatcher());
$poc->start();
include('lib/text_generator.php');
