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
class Top3close extends Model
{
    
    public function searchTop3CloseAll($thn,$bln)
    {
        $setTahun=$thn!=''?$thn:date('Y');
        $setBulan=$bln!=''?$bln:date('m');
        
        $qryStrTop3Close="
            SELECT 
                kd_station, nm_station, (p2_ticket*1) AS p2_ticket, 
                rank_ticket FROM data_tt_station_bulanan_v3
            WHERE 
                tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
            ORDER BY rank_ticket ASC
            limit 3
        ";
        $rsltTop3close= Yii::$app->db->createCommand($qryStrTop3Close)->queryAll(); 

      	
        return [
            'top3close'=>$rsltTop3close
        ];
    }

    public function searchTop3CloseOperator($thn,$bln,$operator)
    {
        $setTahun=$thn!=''?$thn:date('Y');
        $setBulan=$bln!=''?$bln:date('m');
        $opr=$operator=="IVM"?"1":($operator=="SCTV"?"2":"0");
        
        $qryStrTop3Close="
            SELECT 
                kd_station, nm_station, (p2_ticket*1) AS p2_ticket, 
                rank_ticket FROM data_tt_station_bulanan_v3
            WHERE 
                operator='".$operator."'
                AND tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
            ORDER BY rank_ticket ASC
            limit 3
        ";
        $rsltTop3close= Yii::$app->db->createCommand($qryStrTop3Close)->queryAll(); 

        
        return [
            'top3close'=>$rsltTop3close
        ];
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


