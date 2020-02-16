<?php
/**
 * CorePages
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 21:40 WIB
 * @modified date 31 January 2019, 16:46 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "_core_pages".
 *
 * The followings are the available columns in table "_core_pages":
 * @property integer $page_id
 * @property string $views
 * @property string $view_all
 *
 */

namespace ommu\core\models\view;

use Yii;

class CorePages extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_core_pages';
	}

	/**
	 * @return string the primarykey column
	 */
	public static function primaryKey()
	{
		return ['page_id'];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['page_id'], 'integer'],
			[['views', 'view_all'], 'number'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'page_id' => Yii::t('app', 'Page'),
			'views' => Yii::t('app', 'Views'),
			'view_all' => Yii::t('app', 'View All'),
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
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['page_id'] = [
			'attribute' => 'page_id',
			'value' => function($model, $key, $index, $column) {
				return $model->page_id;
			},
		];
		$this->templateColumns['views'] = [
			'attribute' => 'views',
			'value' => function($model, $key, $index, $column) {
				return $model->views;
			},
		];
		$this->templateColumns['view_all'] = [
			'attribute' => 'view_all',
			'value' => function($model, $key, $index, $column) {
				return $model->view_all;
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
			$model = $model->where(['page_id' => $id])->one();
			return is_array($column) ? $model : $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
