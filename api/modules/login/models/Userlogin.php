<?php

namespace api\modules\login\models;
use api\modules\login\models\Employe;
use api\modules\login\models\Userprofile;
use Yii;

class Userlogin extends \yii\db\ActiveRecord
{
	
	 public static function getDb()
	{
		/* Author -ptr.nov- : HRD | Dashboard I */
		return \Yii::$app->db;  
	}
	
    public static function tableName()
    {
        return '{{user}}';
    }

    public function rules()
    {
        return [
            [['user_id','user_email','user_nama','user_password'], 'required'],
            [['user_id','user_email','user_nama','user_password'], 'string']
            //,
			//[['id','status','created_at','updated_at'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User.ID'),
            'user_email' => Yii::t('app', 'User Email'),
			'user_email' => Yii::t('app', 'user_email'),
			'user_password' => Yii::t('app', 'user_password')
        ];
    }      
}


