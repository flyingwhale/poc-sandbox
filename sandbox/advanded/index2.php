<?php
require_once ("../../autoload.php");
require_once (__DIR__."/lib/common.php");

use Poc\Poc;
use Poc\Cache\CacheImplementation\FileCache;

use Silex\Provider\FormServiceProvider;

$app = new Silex\Application;

$app->register(new FormServiceProvider());


$app->match('/form', function (Request $request) use ($app) {
    // some default data for when the form is displayed the first time
    $data = array(
        'name' => 'Your name',
        'email' => 'Your email',
    );

    $form = $app['form.factory']->createBuilder('form', $data)
        ->add('name')
        ->add('email')
        ->add('gender', 'choice', array(
            'choices' => array(1 => 'male', 2 => 'female'),
            'expanded' => true,
        ))
        ->getForm();

    if ('POST' == $request->getMethod()) {
        $form->bindRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            // do something with the data

            // redirect somewhere
            return $app->redirect('...');
        }
    }

    // display the form
    return $app['twig']->render('index.twig', array('form' => $form->createView()));
});



$db = new Dasboard;
$poc  = new Poc(array(Poc::PARAM_CACHE => new FileCache(array(\Poc\Cache\CacheImplementation\Cache::PARAM_TTL=>10)),
               Poc::PARAM_DEBUG => $db->getValue('Debug')
        ));

$poc->getFilter()->addBlacklistCondition( (isset($_POST) && !empty($_POST)) );

foreach ($plugins as $plugin => $val){

    
    if($db->getValue($plugin)){
        echo $plugin."<br>";
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

