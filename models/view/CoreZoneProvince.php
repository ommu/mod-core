<?php
/**
 * CoreZoneProvince
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 18 September 2017, 00:03 WIB
 * @modified date 22 April 2018, 19:30 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_core_zone_province".
 *
 * The followings are the available columns in table "_core_zone_province":
 * @property integer $province_id
 * @property string $province_name
 *
 */

namespace ommu\core\models\view;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class CoreZoneProvince extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_core_zone_province';
	}

	/**
	 * @return string the primarykey column
	 */
	public static function primaryKey()
	{
		return ['province_id'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['province_name'], 'required'],
			[['province_id'], 'integer'],
			[['province_name'], 'string', 'max' => 130],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'province_id' => Yii::t('app', 'Province'),
			'province_name' => Yii::t('app', 'Province Name'),
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
			'header' => Yii::t('app', 'No'),
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['province_id'] = [
			'attribute' => 'province_id',
			'value' => function($model, $key, $index, $column) {
				return $model->province_id;
			},
		];
		$this->templateColumns['province_name'] = [
			'attribute' => 'province_name',
			'value' => function($model, $key, $index, $column) {
				return $model->province_name;
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
				->where(['province_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
