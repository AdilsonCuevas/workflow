<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '3veFEMEt3eqIQvoyM2a4PQ20JZrAUnrc',
        ],
        'workflowSource' => [
            'class' => 'app\components\WorkflowDbSource', // La clase de tu componente
            // Otras configuraciones de tu componente
        ],
        'my_workflow_source' => [
            'class'            => 'raoul2000\workflow\source\file\WorkflowFileSource',
  
            // Cache component name
            'definitionCache'  => 'cache',
  
            // load workflow as PHP class from the @app/models/workflows namespace
            'definitionLoader' => [
                'class'      => 'raoul2000\workflow\source\file\PhpClassLoader',
                'namespace'  => '@app/models/workflows'
            ],
  
            // workflow provided by PHP class will be defined as a minimal array
            'parser'           => 'raoul2000\workflow\source\file\MinimalArrayParser',          
  
             // we provide our own implementation for simple workflow base objects
            'classMap'        => [
                //self::TYPE_WORKFLOW   => 'my\custom\implementation\Workflow',
                //self::TYPE_STATUS     => 'my\custom\implementation\Status',
                //self::TYPE_TRANSITION => 'my\custom\implementation\Transition'
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
