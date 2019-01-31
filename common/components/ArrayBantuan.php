<?php
/**
 * Created by PhpStorm.
 * User: ptr.nov
 * Date: 10/08/15
 * Time: 19:44
 */

namespace common\components;
use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\base\Component;
use Yii\base\Model;
use yii\data\ArrayDataProvider;


/** 
  * ARRAY HELEPER CUSTOMIZE
  * @author ptrnov  <piter@lukison.com>
  * @since 1.1
*/
class ArrayBantuan extends Component{	
	
	/**
	* Array Where of Rows query.	*
	* @param array $array
	* @param array $search
	* @return array
	* Yii::$app->arrayBantuan->findWhere($array, $matching);
	*/
	function findWhere($array, $matching) {
		foreach ($array as $item) {
			$is_match = true;
			foreach ($matching as $key => $value) {

				if (is_object($item)) {
					if (! isset($item->$key)) {
						$is_match = false;
						break;
					}
				} else {
					if (! isset($item[$key])) {
						$is_match = false;
						break;
					}
				}

				if (is_object($item)) {
					if ($item->$key != $value) {
						$is_match = false;
						break;
					}
				} else {
					if ($item[$key] != $value) {
						$is_match = false;
						break;
					} 
				}
			}

			if ($is_match) {
				return $item;   
			}
		}

		return false;
	}
	
	
	/**
   * Multi-array search
   *
   * @param array $array
   * @param array $search
   * @return array
   * Yii::$app->arrayBantuan->multi_array_search($array, $search);
   */
  function array_searchrow($array, $search)
  {

    // Create the result array
    $result = array();

    // Iterate over each array element
    foreach ($array as $key => $value)
    {

      // Iterate over each search condition
      foreach ($search as $k => $v)
      {

        // If the array element does not meet the search condition then continue to the next element
        if (!isset($value[$k]) || $value[$k] != $v)
        {
          continue 2;
        }

      }

	  
      // Add the array element's key to the result array
      $result[] = $key;

    }

    // Return the result array
    return $result;

	}
  
	/**
	* ARRAY LIST OF RANGE DATE OF MONTH.	*
	* @param tgl
	* @return array
	* Default current date.
	* Yii::$app->arrayBantuan->ArrayDayOfMonth($tgl);
	*/
	function ArrayDayOfMonth($tgl){
		$tglParam=$tgl!=''?$tgl:date('Y-m-d');
		$bulan = date('F - Y', strtotime($tglParam));
		//GET ROWS DATE FROM RANGE DATE.
		$qryRangeTgl= Yii::$app->db_esm->createCommand("
			SELECT	DATE_FORMAT(a.Date,'%d') as DAY, 
					DATE_FORMAT(a.Date,'%m') as MONTH,
					DATE_FORMAT(a.Date,'%Y') as YEAAR,
					DATE_FORMAT(a.Date,'%Y-%m-%d') AS TGL,
					DATE_FORMAT(a.Date,'%d') as label
			FROM (
					select (LAST_DAY('".$tglParam."')) - INTERVAL (a.a + (10 * b.a) + (100 * c.a)) DAY as Date
					from (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as a
					cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as b
					cross join (select 0 as a union all select 1 union all select 2 union all select 3 union all select 4 union all select 5 union all select 6 union all select 7 union all select 8 union all select 9) as c
			) a
			WHERE a.Date BETWEEN  (LAST_DAY('".$tglParam."')-INTERVAL(1)MONTH + INTERVAL(1)DAY) and LAST_DAY('".$tglParam."') ORDER BY a.Date ASC;
		")->queryAll();		
		$adpRangeDate= new ArrayDataProvider([
			//'key' => 'ID',
			'allModels'=>$qryRangeTgl,
			'pagination' => [
				'pageSize' => 500,
			]
		]);
		return $adpRangeDate->getModels();
	}
	
	
	function ArrayPaletteColors(){
		$hexColor="#0B1234,#68acff,#00fd83,#e700c4,#8900ff,#fb0909,#0000ff,#ff4040,#7fff00,#ff7f24,#ff7256,#ffb90f,#006400,#030303,#ff69b4,#8b814c,#3f6b52,#744f4f,#6fae93,#858006,#426506,#055c5a,#a7630d,#4d8a9c,#449f9c,#8da9ab,#c4dfdd,#bf7793,#559e96,#afca84,#608e97,#806d88,#688b94,#b5dfe7,#b29cba,#83adb5,#c7bbc9,#2d5867,#e1e9b7,#bcd2d0,#f96161,#c9bbbb,#bfc5ce,#8f6d4d,#a87f99,#62909b,#a0acc0,#94b9b8";		
		return $hexColor;
	}
	function ArrayRowPaletteColors(){
		$hexColor=["#0B1234","#68acff","#00fd83","#e700c4","#8900ff","#fb0909","#0000ff","#ff4040","#7fff00","#ff7f24","#ff7256","#ffb90f","#006400","#030303","#ff69b4","#8b814c","#3f6b52","#744f4f","#6fae93","#858006","#426506","#055c5a","#a7630d","#4d8a9c","#449f9c","#8da9ab","#c4dfdd","#bf7793","#559e96","#afca84","#608e97","#806d88","#688b94","#b5dfe7","#b29cba","#83adb5","#c7bbc9","#2d5867","#e1e9b7","#bcd2d0","#f96161","#c9bbbb","#bfc5ce","#8f6d4d","#a87f99","#62909b","#a0acc0","#94b9b8"];		
		return $hexColor;
		// foreach($hexColor as $rows => $value){
			// $rslt[]=[$rows =>$value];
		// };
		// return $rslt;
	}
	
	/**
	 * ARRAY GROUPING 
	 * @author Piter Novian [ptr.nov@gmail.com] 
	*/	
	public static function array_group_by($arr, $key)
	{
		if (!is_array($arr)) {
			trigger_error('array_group_by(): The first argument should be an array', E_USER_ERROR);
		}
		if (!is_string($key) && !is_int($key) && !is_float($key)) {
			trigger_error('array_group_by(): The key should be a string or an integer', E_USER_ERROR);
		}
		// Load the new array, splitting by the target key
		$grouped = [];
		foreach ($arr as $value) {
			$grouped[$value[$key]][] = $value;
		}
		// Recursively build a nested grouping if more parameters are supplied
		// Each grouped array value is grouped according to the next sequential key
		if (func_num_args() > 2) {
			$args = func_get_args();
			foreach ($grouped as $key => $value) {
				$parms = array_merge([$value], array_slice($args, 2, func_num_args()));
				$grouped[$key] = call_user_func_array('array_group_by', $parms);
			}
		}
		return $grouped;
	}
	/**
	 * Kasus Json decode tidak berjalan.
	 * 1. pastikan tidak ada tanda quote di belakang.
	 * 2. patikan tidak ada nilai 0 di depan dalam dua digit. contoh 09 atau 010.
	 * 3. untuk tanggal to string, customize. contoh 2017-01-22 dijadikan string "2017-01-22", penambahan tanda petik depan belakang.
	*/
	public static function fix_json_format_value($result_json){
		$fixSpasi= str_replace(' ','',$result_json); 
		$fixKomaDibelakang= str_replace(', }','}',$fixSpasi); 
		$fixValueDigitNolDidepan= str_replace(':0',':',$fixKomaDibelakang); 
		$fixFormatJson = json_decode($fixValueDigitNolDidepan);
		return $fixFormatJson;
	}
	
	/**
	 * ARRAY Multi Sort.
	 * @author Piter Novian [ptr.nov@gmail.com] 
	*/	
	function sort_multi_array($array, $key)
	{
	  $keys = array();
	  for ($i=1;$i<func_num_args();$i++) {
		$keys[$i-1] = func_get_arg($i);
	  }

	  // create a custom search function to pass to usort
	  $func = function ($a, $b) use ($keys) {
		for ($i=0;$i<count($keys);$i++) {
		  if ($a[$keys[$i]] != $b[$keys[$i]]) {
			return ($a[$keys[$i]] < $b[$keys[$i]]) ? -1 : 1;
		  }
		}
		return 0;
	  };

	  usort($array, $func);

	  return $array;
	}
}