<?php
/**
 * CoreZoneCity
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 14 September 2017, 22:22 WIB
 * @modified date 22 April 2018, 18:37 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_zone_city".
 *
 * The followings are the available columns in table "ommu_core_zone_city":
 * @property integer $city_id
 * @property integer $publish
 * @property integer $province_id
 * @property string $city_name
 * @property string $mfdonline
 * @property integer $checked
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property CoreZoneProvince $province
 * @property CoreZoneDistrict[] $districts
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\behaviors\SluggableBehavior;
use ommu\users\models\Users;
use ommu\core\models\view\CoreZoneCity as CoreZoneCityView;
use ommu\core\models\query\CoreZoneCityQuery;

class CoreZoneCity extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['checked','modified_date','updated_date','modified_search','slug'];

	// Search Variable
	public $province_search;
	public $country_search;
	public $creation_search;
	public $modified_search;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_core_zone_city';
	}

	/**
	 * behaviors model class.
	 */
	public function behaviors() {
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'city_name',
				'immutable' => true,
				'ensureUnique' => true,
			],
		];
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['province_id', 'city_name', 'mfdonline'], 'required'],
			[['publish', 'province_id', 'checked', 'creation_id', 'modified_id'], 'integer'],
			[['creation_date', 'modified_date', 'updated_date'], 'safe'],
			[['city_name', 'slug'], 'string', 'max' => 64],
			[['mfdonline'], 'string', 'max' => 4],
			[['province_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreZoneProvince::className(), 'targetAttribute' => ['province_id' => 'province_id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'city_id' => Yii::t('app', 'City'),
			'publish' => Yii::t('app', 'Publish'),
			'province_id' => Yii::t('app', 'Province'),
			'city_name' => Yii::t('app', 'City'),
			'mfdonline' => Yii::t('app', 'Mfdonline'),
			'checked' => Yii::t('app', 'Checked'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'slug' => Yii::t('app', 'Slug'),
			'province_search' => Yii::t('app', 'Province'),
			'country_search' => Yii::t('app', 'Country'),
			'creation_search' => Yii::t('app', 'Creation'),
			'modified_search' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProvince()
	{
		return $this->hasOne(CoreZoneProvince::className(), ['province_id' => 'province_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDistricts()
	{
		return $this->hasMany(CoreZoneDistrict::className(), ['city_id' => 'city_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCreation()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'creation_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getModified()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'modified_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getView()
	{
		return $this->hasOne(CoreZoneCityView::className(), ['city_id' => 'city_id']);
	}

	/**
	 * @inheritdoc
	 * @return CoreZoneCityQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new CoreZoneCityQuery(get_called_class());
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
		$this->templateColumns['city_name'] = [
			'attribute' => 'city_name',
			'value' => function($model, $key, $index, $column) {
				return $model->city_name;
			},
		];
		if(!Yii::$app->request->get('province')) {
			$this->templateColumns['province_search'] = [
				'attribute' => 'province_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->province) ? $model->province->province_name : '-';
				},
			];
		}
		if(!Yii::$app->request->get('country')) {
			$this->templateColumns['country_search'] = [
				'attribute' => 'country_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->province->country) ? $model->province->country->country_name : '-';
				},
			];
		}
		$this->templateColumns['mfdonline'] = [
			'attribute' => 'mfdonline',
			'value' => function($model, $key, $index, $column) {
				return $model->mfdonline;
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'filter' => Html::input('date', 'creation_date', Yii::$app->request->get('creation_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->creation_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->creation_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creation_search'] = [
				'attribute' => 'creation_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
				},
			];
		}
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'filter' => Html::input('date', 'modified_date', Yii::$app->request->get('modified_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modified_search'] = [
				'attribute' => 'modified_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
				},
			];
		}
		$this->templateColumns['updated_date'] = [
			'attribute' => 'updated_date',
			'filter' => Html::input('date', 'updated_date', Yii::$app->request->get('updated_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->updated_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->updated_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		$this->templateColumns['slug'] = [
			'attribute' => 'slug',
			'value' => function($model, $key, $index, $column) {
				return $model->slug;
			},
		];
		$this->templateColumns['checked'] = [
			'attribute' => 'checked',
			'filter' => $this->filterYesNo(),
			'value' => function($model, $key, $index, $column) {
				return $model->checked ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
			},
			'contentOptions' => ['class'=>'center'],
		];
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'filter' => $this->filterYesNo(),
				'value' => function($model, $key, $index, $column) {
					$url = Url::to(['publish', 'id'=>$model->primaryKey]);
					return $this->quickAction($url, $model->publish);
				},
				'contentOptions' => ['class'=>'center'],
				'format' => 'raw',
			];
		}
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

	/**
	 * function getCity
	 */
	public static function getCity($publish=null, $array=true) 
	{
		$model = self::find()->alias('t');
		if($publish != null)
			$model = $model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('t.city_name ASC')->all();

		if($array == true) {
			$items = [];
			if($model !== null) {
				foreach($model as $val) {
					$items[$val->city_id] = $val->city_name;
				}
				return $items;
			} else
				return false;
		} else 
			return $model;
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			else
				$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
		}
		return true;
	}
}