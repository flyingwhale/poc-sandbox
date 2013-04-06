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


$poc  = new Poc(array(Poc::PARAM_CACHE => new FileCache(array(FileCache::PARAM_TTL=>20)), Poc::PARAM_TOOLSET => new \Poc\Toolsets\NativeOutputHandlers\HttpCapture()));
$poc->addPlugin(new \Poc\PocPlugins\CacheInvalidationProtection\ROIProtector());
$poc->addPlugin(new \Poc\PocPlugins\Logging\PocLogs());
//new CIAProtectorLogger(array(PocLogsParams::PARAM_POC => $poc));

$poc->start();

include('lib/text_generator_ten_seconds.php');
