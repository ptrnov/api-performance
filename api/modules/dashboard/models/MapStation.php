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
class MapStation extends DynamicModel
{
    
    
    public function searchStationOperator($thn,$bln,$operator)
    {
        $setTahun=$thn!=''?$thn:date('Y');
        $setBulan=$bln!=''?$bln:date('m');
        $opr=$operator=="IVM"?"1":($operator=="SCTV"?"2":"0");
    
        if ($operator=="IVM" or $operator=="SCTV"){
            $qryStation="
                SELECT * FROM dept_region_site where is_publish='1' AND ID_DRS !='S-75' 
                AND ID_DRS !='S-74' AND ID_DRS !='S-83' AND client_id=".$opr."
                #order by description ASC
            ";
        }else{
            $qryStation="
                SELECT * FROM dept_region_site where is_publish='1' AND ID_DRS !='S-75' 
                AND ID_DRS !='S-74' AND ID_DRS !='S-83'
                #order by description ASC
            ";
        }
        
        $rsltStation= Yii::$app->db1->createCommand($qryStation)->queryAll(); 	
		
        return $rsltStation;
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


