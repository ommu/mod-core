<?php
/**
 * CoreZoneVillage
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 18 September 2017, 00:05 WIB
 * @modified date 22 April 2018, 19:30 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_core_zone_village".
 *
 * The followings are the available columns in table "_core_zone_village":
 * @property integer $village_id
 * @property string $village_name
 *
 */

namespace ommu\core\models\view;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class CoreZoneVillage extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_core_zone_village';
	}

	/**
	 * @return string the primarykey column
	 */
	public static function primaryKey()
	{
		return ['village_id'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['village_name'], 'required'],
			[['village_id'], 'integer'],
			[['village_name'], 'string', 'max' => 328],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'village_id' => Yii::t('app', 'Village'),
			'village_name' => Yii::t('app', 'Village Name'),
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
		$this->templateColumns['village_id'] = [
			'attribute' => 'village_id',
			'value' => function($model, $key, $index, $column) {
				return $model->village_id;
			},
		];
		$this->templateColumns['village_name'] = [
			'attribute' => 'village_name',
			'value' => function($model, $key, $index, $column) {
				return $model->village_name;
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
				->where(['village_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
