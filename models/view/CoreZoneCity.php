<?php
/**
 * CoreZoneCity
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 18 September 2017, 00:04 WIB
 * @modified date 22 April 2018, 19:29 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_view_core_zone_city".
 *
 * The followings are the available columns in table "_view_core_zone_city":
 * @property integer $city_id
 * @property string $city_name
 *
 */

namespace ommu\core\models\view;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

class CoreZoneCity extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_view_core_zone_city';
	}

	/**
	 * @return string the primarykey column
	 */
	public static function primaryKey()
	{
		return ['city_id'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['city_name'], 'required'],
			[['city_id'], 'integer'],
			[['city_name'], 'string', 'max' => 196],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'city_id' => Yii::t('app', 'City'),
			'city_name' => Yii::t('app', 'City Name'),
		];
	}

	/**
	 * Set default columns to display
	 */
	public function init() 
	{
		parent::init();

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class'  => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['city_id'] = [
			'attribute' => 'city_id',
			'value' => function($model, $key, $index, $column) {
				return $model->city_id;
			},
		];
		$this->templateColumns['city_name'] = [
			'attribute' => 'city_name',
			'value' => function($model, $key, $index, $column) {
				return $model->city_name;
			},
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find()
				->select([$column])
				->where(['city_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
