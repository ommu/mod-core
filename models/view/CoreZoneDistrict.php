<?php
/**
 * CoreZoneDistrict
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 18 September 2017, 00:04 WIB
 * @modified date 22 April 2018, 19:29 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_core_zone_district".
 *
 * The followings are the available columns in table "_core_zone_district":
 * @property integer $district_id
 * @property string $district_name
 *
 */

namespace ommu\core\models\view;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class CoreZoneDistrict extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_core_zone_district';
	}

	/**
	 * @return string the primarykey column
	 */
	public static function primaryKey()
	{
		return ['district_id'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['district_name'], 'required'],
			[['district_id'], 'integer'],
			[['district_name'], 'string', 'max' => 262],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'district_id' => Yii::t('app', 'District'),
			'district_name' => Yii::t('app', 'District Name'),
		];
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		if(!$this->hasMethod('search'))
			return;

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['district_id'] = [
			'attribute' => 'district_id',
			'value' => function($model, $key, $index, $column) {
				return $model->district_id;
			},
		];
		$this->templateColumns['district_name'] = [
			'attribute' => 'district_name',
			'value' => function($model, $key, $index, $column) {
				return $model->district_name;
			},
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find();
			if(is_array($column))
				$model->select($column);
			else
				$model->select([$column]);
			$model = $model->where(['district_id' => $id])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
