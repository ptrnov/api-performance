<?php

namespace api\modules\dashboard\controllers;

use yii;
use kartik\datecontrol\Module;
use yii\helpers\Json;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use common\models\User;
use api\modules\dashboard\models\MapStation;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
//use yii\data\ActiveDataProvider;

/**
  * Controller Pilotproject Class  
  *
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
  * @link https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
  * @see https://github.com/C12D/advanced/blob/master/api/modules/chart/controllers/PilotpController.php
 */
class MapStationController extends ActiveController
{	
	/**
	  * Source Database declaration 
	 */
    public $modelClass = 'api\modules\dashboard\models\MapStation';
	// public $serializer = [
	// 	'class' => 'yii\rest\Serializer',
	// 	'collectionEnvelope' => 'box_tt',
	// ];
	
	/**
     * @inheritdoc
     */
    public function behaviors()    {
        return ArrayHelper::merge(parent::behaviors(), [
            'authenticator' => 
            [
                'class' => CompositeAuth::className(),
				'authMethods' => 
                [
                    #Hapus Tanda Komentar Untuk Autentifikasi Dengan Token               
                   // ['class' => HttpBearerAuth::className()],
                   // ['class' => QueryParamAuth::className(), 'tokenParam' => 'access-token'],
                ],
                'except' => ['options']
            ],
			'bootstrap'=> 
            [
				'class' => ContentNegotiator::className(),
				'formats' => 
                [
					'application/json' => Response::FORMAT_JSON,"JSON_PRETTY_PRINT"
				],
				
			],
			'corsFilter' => [
				'class' => \yii\filters\Cors::className(),
				'cors' => [
					// restrict access to
					'Origin' => ['*','http://localhost:8100/'],

					'Access-Control-Allow-Headers' => ['X-Requested-With','Content-Type'],
					'Access-Control-Request-Method' => ['POST', 'GET', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
					// 'Access-Control-Request-Method' => ['POST', 'PUT','GET'],
					// Allow only POST and PUT methods
					// 'Access-Control-Request-Headers' => ['X-Wsse'],
					'Access-Control-Request-Headers' => ['*'],
					// Allow only headers 'X-Wsse'
					'Access-Control-Allow-Credentials' => true,
					// Allow OPTIONS caching
					'Access-Control-Max-Age' => 6600,
					// Allow the X-Pagination-Current-Page header to be exposed to the browser.
					'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
				]		
			],
		]);	
		
	}
	
	/**
     * @inheritdoc
     */
	public function actions()
	 {
		 $actions = parent::actions();
		unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 //unset($actions['update'], $actions['create'], $actions['delete'], $actions['view']);
		 return $actions;
	 }

	 public function actionCreate(){
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		$paramsBody	= Yii::$app->getRequest()->bodyParams;
		$thn			= isset($paramsBody['tahun'])!=''?$paramsBody['tahun']:'';
		$bln			= isset($paramsBody['bulan'])!=''?$paramsBody['bulan']:'';
		$opr			= isset($paramsBody['operator'])!=''?$paramsBody['operator']:'';
		$searchModel  = new MapStation();
		$dataProvider = $searchModel->searchStationOperator($thn,$bln,$opr);
		
		return ['result'=>$dataProvider];
		
	} 
}


