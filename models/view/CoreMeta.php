<?php
/**
 * CoreMeta
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.co)
 * @created date 22 April 2018, 19:28 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_core_meta".
 *
 * The followings are the available columns in table "_core_meta":
 * @property integer $id
 * @property string $city_name
 * @property string $province_name
 * @property string $country_name
 *
 */

namespace ommu\core\models\view;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class CoreMeta extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_core_meta';
	}

	/**
	 * @return string the primarykey column
	 */
	public static function primaryKey()
	{
		return ['id'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['id'], 'integer'],
			[['city_name', 'province_name', 'country_name'], 'string', 'max' => 64],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'city_name' => Yii::t('app', 'City'),
			'province_name' => Yii::t('app', 'Province'),
			'country_name' => Yii::t('app', 'Country'),
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
		$this->templateColumns['id'] = [
			'attribute' => 'id',
			'value' => function($model, $key, $index, $column) {
				return $model->id;
			},
		];
		$this->templateColumns['city_name'] = [
			'attribute' => 'city_name',
			'value' => function($model, $key, $index, $column) {
				return $model->city_name;
			},
		];
		$this->templateColumns['province_name'] = [
			'attribute' => 'province_name',
			'value' => function($model, $key, $index, $column) {
				return $model->province_name;
			},
		];
		$this->templateColumns['country_name'] = [
			'attribute' => 'country_name',
			'value' => function($model, $key, $index, $column) {
				return $model->country_name;
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
			$model = $model->where(['id' => $id])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
