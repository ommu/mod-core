<?php
/**
 * CoreZoneCity
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 18 September 2017, 00:04 WIB
 * @modified date 22 April 2018, 19:29 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_core_zone_city".
 *
 * The followings are the available columns in table "_core_zone_city":
 * @property integer $city_id
 * @property string $city_name
 *
 */

namespace ommu\core\models\view;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class CoreZoneCity extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_core_zone_city';
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

		if(!(Yii::$app instanceof \app\components\Application))
			return;

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'yii\grid\SerialColumn',
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
			$model = self::find();
			if(is_array($column))
				$model->select($column);
			else
				$model->select([$column]);
			$model = $model->where(['city_id' => $id])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
