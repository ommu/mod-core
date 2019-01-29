<?php
/**
 * CoreZoneDistrict
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 15 September 2017, 10:24 WIB
 * @modified date 22 April 2018, 18:38 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_zone_district".
 *
 * The followings are the available columns in table "ommu_core_zone_district":
 * @property integer $district_id
 * @property integer $publish
 * @property integer $city_id
 * @property string $district_name
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
 * @property CoreZoneCity $city
 * @property CoreZoneVillage[] $villages
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
use ommu\core\models\view\CoreZoneDistrict as CoreZoneDistrictView;
use ommu\core\models\query\CoreZoneDistrict;

class CoreZoneDistrict extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['checked','modified_date','modified_search','updated_date','slug'];

	// Search Variable
	public $city_search;
	public $province_search;
	public $country_search;
	public $creation_search;
	public $modified_search;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_core_zone_district';
	}

	/**
	 * behaviors model class.
	 */
	public function behaviors() {
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'district_name',
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
			[['city_id', 'district_name', 'mfdonline'], 'required'],
			[['publish', 'city_id', 'checked', 'creation_id', 'modified_id'], 'integer'],
			[['creation_date', 'modified_date', 'updated_date'], 'safe'],
			[['district_name', 'slug'], 'string', 'max' => 64],
			[['mfdonline'], 'string', 'max' => 7],
			[['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreZoneCity::className(), 'targetAttribute' => ['city_id' => 'city_id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'district_id' => Yii::t('app', 'District'),
			'publish' => Yii::t('app', 'Publish'),
			'city_id' => Yii::t('app', 'City'),
			'district_name' => Yii::t('app', 'District'),
			'mfdonline' => Yii::t('app', 'Mfdonline'),
			'checked' => Yii::t('app', 'Checked'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'slug' => Yii::t('app', 'Slug'),
			'city_search' => Yii::t('app', 'City'),
			'province_search' => Yii::t('app', 'Province'),
			'country_search' => Yii::t('app', 'Country'),
			'creation_search' => Yii::t('app', 'Creation'),
			'modified_search' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCity()
	{
		return $this->hasOne(CoreZoneCity::className(), ['city_id' => 'city_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getVillages()
	{
		return $this->hasMany(CoreZoneVillage::className(), ['district_id' => 'district_id']);
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
		return $this->hasOne(CoreZoneDistrictView::className(), ['district_id' => 'district_id']);
	}

	/**
	 * @inheritdoc
	 * @return CoreZoneDistrict the active query used by this AR class.
	 */
	public static function find()
	{
		return new CoreZoneDistrict(get_called_class());
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
		$this->templateColumns['district_name'] = [
			'attribute' => 'district_name',
			'value' => function($model, $key, $index, $column) {
				return $model->district_name;
			},
		];
		if(!Yii::$app->request->get('city')) {
			$this->templateColumns['city_search'] = [
				'attribute' => 'city_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->city) ? $model->city->city_name : '-';
				},
			];
		}
		if(!Yii::$app->request->get('province')) {
			$this->templateColumns['province_search'] = [
				'attribute' => 'province_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->city->province) ? $model->city->province->province_name : '-';
				},
			];
		}
		if(!Yii::$app->request->get('country')) {
			$this->templateColumns['country_search'] = [
				'attribute' => 'country_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->city->province->country) ? $model->city->province->country->country_name : '-';
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
				->where(['district_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * function getDistrict
	 */
	public static function getDistrict($publish=null, $array=true) 
	{
		$model = self::find()->alias('t');
		if($publish != null)
			$model = $model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('t.district_name ASC')->all();

		if($array == true) {
			$items = [];
			if($model !== null) {
				foreach($model as $val) {
					$items[$val->district_id] = $val->district_name;
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
