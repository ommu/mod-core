<?php
/**
 * CorePages
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 ECC UGM (ecc.ft.ugm.ac.id)
 * @created date 2 October 2017, 21:40 WIB
 * @modified date 22 April 2018, 19:28 WIB
 * @link https://ecc.ft.ugm.ac.id
 *
 * This is the model class for table "_view_core_pages".
 *
 * The followings are the available columns in table "_view_core_pages":
 * @property integer $page_id
 * @property integer $media
 * @property string $views
 * @property string $view_all
 *
 */

namespace ommu\core\models\view;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

class CorePages extends \app\components\ActiveRecord
{
	public $gridForbiddenColumn = [];

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return '_view_core_pages';
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
			[['page_id', 'media'], 'integer'],
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
			'media' => Yii::t('app', 'Media'),
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

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class'  => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['page_id'] = [
			'attribute' => 'page_id',
			'value' => function($model, $key, $index, $column) {
				return $model->page_id;
			},
		];
		$this->templateColumns['media'] = [
			'attribute' => 'media',
			'value' => function($model, $key, $index, $column) {
				return $model->media;
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
			$model = self::find()
				->select([$column])
				->where(['page_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}
}
