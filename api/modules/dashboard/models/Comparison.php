<?php

namespace api\modules\dashboard\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Response;
use yii\data\ArrayDataProvider;
use yii\base\Model;
use \yii\base\DynamicModel;
use yii\debug\components\search\Filter;
use yii\debug\components\search\matchers;
use yii\data\ActiveDataProvider;

// class Semua extends \yii\db\ActiveRecord
class Comparison extends DynamicModel
{
    
    
    public function searchKombobox1()
    {
     
        $qryCombo1="
            SELECT 
            x2.grade, 
            x1.name_station, 
            x1.kd_station 
            FROM performance.konstanta x1
            INNER JOIN performance.konstanta_detail x2
            ON (x1.kd_konstanta = x2.kd_ko)
        ";
        
        $rsltCombo1= Yii::$app->db->createCommand($qryCombo1)->queryAll(); 	
		
        return $rsltCombo1;
    }

    public function searchKombobox2($kd_Station)
    {
        $qryCariGrade="
            SELECT 
                x2.grade 
            FROM performance.konstanta x1
                INNER JOIN performance.konstanta_detail x2  
                ON (x1.kd_konstanta = x2.kd_ko)
            WHERE x1.kd_station='".$kd_Station."'
        ";

        $rsltCariGrade= Yii::$app->db1->createCommand($qryCariGrade)->queryOne(); 	
     
        $qryCombo2="
            SELECT grade,name_station,kd_station 
            FROM
            (   SELECT 
                x2.grade, 
                x1.name_station, 
                x1.kd_station 
                FROM performance.konstanta x1
                INNER JOIN performance.konstanta_detail x2
                ON (x1.kd_konstanta = x2.kd_ko)
            ) a1
            WHERE a1.grade='".$rsltCariGrade['grade']."'
        ";
        
        $rsltCombo2= Yii::$app->db1->createCommand($qryCombo2)->queryAll(); 	
		
        return $rsltCombo2;
    }


    public function addCondition(Filter $filter, $attribute, $partial = false)
    {
        $value = $this->$attribute;
        if (mb_strpos($value, '>') !== false) {
            $value = intval(str_replace('>', '', $value));
            $filter->addMatcher($attribute, new matchers\GreaterThan(['value' => $value]));
        } elseif (mb_strpos($value, '<') !== false) {
            $value = intval(str_replace('<', '', $value));
            $filter->addMatcher($attribute, new matchers\LowerThan(['value' => $value]));
        } else {
            $filter->addMatcher($attribute, new matchers\SameAs(['value' => $value, 'partial' => $partial]));
        }
    }	

}


