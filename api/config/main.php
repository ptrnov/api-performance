<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
		'login' => [
            'basePath' => '@app/modules/login',
            'class' => 'api\modules\login\Module',
        ],
        'dashboard' => [
            'basePath' => '@app/modules/dashboard',
            'class' => 'api\modules\dashboard\Module',
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
			'loginUrl' => null,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
		/*input Json -ptr.nov- */
		'request' => [
			'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
			'parsers' => [
				'application/json' => 'yii\web\JsonParser',
			]
		],
		/*
		'errorHandler' => [
			'errorAction' => ''v1/country',
		],
		*/
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
				[
					'class' => 'yii\rest\UrlRule',
                    'controller' =>
						[   //ptr,.nov penting buat API
							'site/error',
							'login/user'						
                        ],
                        'patterns' => [
                            'PUT,PATCH' => 'update',
                            'DELETE' => 'delete',
                            'GET,HEAD' => 'view',
                            'POST' => 'create',
                            'GET,HEAD' => 'index',
                            '{id}' => 'options',
                            '' => 'options',
                        ],
                        'extraPatterns' => [
							'GET list-user' => 'list-user'
						]
                ],
                [
					'class' => 'yii\rest\UrlRule',
                    'controller' =>
						[   //ptr,.nov penting buat API
							'dashboard/semua',
                            'dashboard/map-station',
                            'dashboard/sctv',						
                        ],
                        'patterns' => [
                            'PUT,PATCH' => 'update',
                            'DELETE' => 'delete',
                            'GET,HEAD' => 'view',
                            'POST' => 'create',
                            'GET,HEAD' => 'index',
                            '{id}' => 'options',
                            '' => 'options',
                        ],
                        'extraPatterns' => [
                            'POST box-all' => 'box-all',
                            'OPTIONS box-all' => 'box-all',
                            'POST box-operator' => 'box-operator',
                            'OPTIONS box-operator' => 'box-operator',
                            'POST top3-all' => 'top3-all',
                            'OPTIONS top3-all' => 'top3-all',
                            'POST top3-operator' => 'top3-operator',
                            'POST top3-close-all' => 'top3-close-all',
                            'POST top3-close-operator' => 'top3-close-operator',
                            'POST top3-fastest-all' => 'top3-fastest-all',
                            'POST top3-fastest-operator' => 'top3-fastest-operator',
                        ]
                ],
            ],
        ],
		/* Author -ptr.nov- : Test Project  */
		'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=performance',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'db1' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=202.58.124.112:3306;dbname=tt_scm',
            'username' => 'root',
            'password' => 'SIPan1nD0!!#@#',
            'charset' => 'utf8',
        ],
        'db2' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=pm_scm_v3',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
		'errorHandler' => [
            'maxSourceLines' => 20,
        ],
		/**
		 * Handle Ajax content parsing & _CSRF
		 * @author ptrnov  <piter@lukison.com>
		 * @since 1.1
		 */
		// 'request' => [
        //     'cookieValidationKey' => 'dWut4SrmYAaXg0NfqpPwnJa23RMIUG7j_it',
        //     'parsers' => [
        //         'application/json' => 'yii\web\JsonParser', // required for POST input via `php://input`
        //     ]
        // ],
    ],
    'params' => $params,
];



