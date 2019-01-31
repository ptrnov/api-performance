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
class Top3 extends Model
{
    
    public function searchTop3All($thn,$bln)
    {
        $setTahun=$thn!=''?$thn:date('Y');
        $setBulan=$bln!=''?$bln:date('m');

        $qryStrTop3="
            SELECT 
                kd_station, nm_station, p3_minor, p3_major, p3_critical, total_hasil, 
                rank FROM data_tt_station_bulanan_v3
            WHERE 
                tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
            ORDER BY rank ASC
            limit 3
        ";
        $rsltTop3= Yii::$app->db->createCommand($qryStrTop3)->queryAll(); 

        return [
            'top3'=>$rsltTop3
        ];
    }

    public function searchTop3Operator($thn,$bln,$operator)
    {
        $setTahun=$thn!=''?$thn:date('Y');
        $setBulan=$bln!=''?$bln:date('m');
        $opr=$operator=="IVM"?"1":($operator=="SCTV"?"2":"0");
        
        $qryStrTop3="
            SELECT 
                kd_station, nm_station, p3_minor, p3_major, p3_critical, total_hasil, 
                rank FROM data_tt_station_bulanan_v3
            WHERE 
                operator='".$operator."'
                AND tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
            ORDER BY rank ASC
            limit 3
        ";
        $rsltTop3= Yii::$app->db->createCommand($qryStrTop3)->queryAll(); 

        return [
            'top3'=>$rsltTop3
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


