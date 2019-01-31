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
class Box extends DynamicModel
{
    
    public function searchBoxAll($thn,$bln)
    {
        $setTahun=$thn!=''?$thn:date('Y');
        $setBulan=$bln!=''?$bln:date('m');

        $qryStrTT="
            SELECT
                SUM(total_ticket) AS tot_tt,
                SUM(open_ticket) AS tot_open,
                SUM(self_tt_tot) AS closed_tt,
                SUM(total_aging) AS tot_aging
            FROM
                data_tt_station_bulanan_v3
            WHERE
                tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
        ";
        $rsltTT= Yii::$app->db->createCommand($qryStrTT)->queryAll(); 

        $qryStrPM="
                SELECT 
                SUM(total_pm_submited) AS tot_pms,
                SUM(total_pm_expired) AS tot_pme,
                SUM(total_pm_open) AS tot_pmo
            FROM
                data_pm_station_bulanan_v3
            WHERE
                tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
        ";
        $rsltPM= Yii::$app->db->createCommand($qryStrPM)->queryAll(); 

        $qryStation="
            SELECT count(ID) as ttl_station FROM dept_region_site where is_publish='1' AND ID_DRS !='S-75' 
            AND ID_DRS !='S-74' AND ID_DRS !='S-83'  AND (client_id=1 OR client_id=2) #order by description ASC

        ";
        $rsltStation= Yii::$app->db1->createCommand($qryStation)->queryAll(); 

        $qryEmploye=" SELECT count('user_id') AS jml_emp FROM user";
        $rsltEmploye= Yii::$app->db->createCommand($qryEmploye)->queryAll(); 	
		
        return [
            'box_tt'=>$rsltTT[0],
            'box_pm'=>$rsltPM[0],
            'station'=>$rsltStation[0]['ttl_station'],
            't_employe'=>$rsltEmploye[0]['jml_emp']
        ];
    }

    public function searchBoxOperator($thn,$bln,$operator)
    {
        $setTahun=$thn!=''?$thn:date('Y');
        $setBulan=$bln!=''?$bln:date('m');
        $opr=$operator=="IVM"?"1":($operator=="SCTV"?"2":"0");
        
        $qryStrTT="
            SELECT
                SUM(total_ticket) AS tot_tt,
                SUM(open_ticket) AS tot_open,
                SUM(self_tt_tot) AS closed_tt,
                SUM(total_aging) AS tot_aging
            FROM
                data_tt_station_bulanan_v3
            WHERE
                operator='".$operator."'
                AND tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
        ";
        $rsltTT= Yii::$app->db->createCommand($qryStrTT)->queryAll(); 

        $qryStrPM="
                SELECT 
                SUM(total_pm_submited) AS tot_pms,
                SUM(total_pm_expired) AS tot_pme,
                SUM(total_pm_open) AS tot_pmo
            FROM
                data_pm_station_bulanan_v3
            WHERE
                operator='".$operator."'
                AND tahun='".$setTahun."'
                AND bulan = '".$setBulan."'
        ";
        $rsltPM= Yii::$app->db->createCommand($qryStrPM)->queryAll(); 

        $qryStation="
            SELECT count(ID) as ttl_station FROM dept_region_site where is_publish='1' AND ID_DRS !='S-75' 
            AND ID_DRS !='S-74' AND ID_DRS !='S-83' AND client_id=".$opr."
            #order by description ASC
        ";
        $rsltStation= Yii::$app->db1->createCommand($qryStation)->queryAll(); 

        $qryEmploye=" SELECT count('user_id') AS jml_emp FROM user";
        $rsltEmploye= Yii::$app->db->createCommand($qryEmploye)->queryAll(); 


		// $provider = new ArrayDataProvider([
		// 	'allModels' => $qrySql,
		// 	'pagination' => [
		// 		'pageSize' => 12,
		// 	],
		// ]);		
		
        return [
            'box_tt'=>$rsltTT[0],
            'box_pm'=>$rsltPM[0],
            'station'=>$rsltStation[0]['ttl_station'],
            't_employe'=>$rsltEmploye[0]['jml_emp']
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


