<?php
/**
 * CoreZoneVillage
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 22 April 2018, 18:39 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_zone_village".
 *
 * The followings are the available columns in table "ommu_core_zone_village":
 * @property integer $village_id
 * @property integer $publish
 * @property integer $district_id
 * @property string $village_name
 * @property string $zipcode
 * @property string $mfdonline
 * @property string $creation_date
 * @property integer $creation_id
 * @property string $modified_date
 * @property integer $modified_id
 * @property string $updated_date
 * @property string $slug
 *
 * The followings are the available model relations:
 * @property CoreZoneDistrict $district
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
use ommu\core\models\view\CoreZoneVillage as CoreZoneVillageView;
use ommu\core\models\query\CoreZoneVillageQuery;

class CoreZoneVillage extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['checked','creation_date','creation_search','modified_date','modified_search','updated_date','slug'];

	// Search Variable
	public $district_search;
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
		return 'ommu_core_zone_village';
	}

	/**
	 * behaviors model class.
	 */
	public function behaviors() {
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'village_name',
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
			[['district_id', 'village_name', 'zipcode', 'mfdonline'], 'required'],
			[['publish', 'district_id', 'creation_id', 'modified_id'], 'integer'],
			[['creation_date', 'modified_date', 'updated_date'], 'safe'],
			[['village_name', 'slug'], 'string', 'max' => 64],
			[['zipcode'], 'string', 'max' => 5],
			[['mfdonline'], 'string', 'max' => 10],
			[['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreZoneDistrict::className(), 'targetAttribute' => ['district_id' => 'district_id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'village_id' => Yii::t('app', 'Village'),
			'publish' => Yii::t('app', 'Publish'),
			'district_id' => Yii::t('app', 'District'),
			'village_name' => Yii::t('app', 'Village'),
			'zipcode' => Yii::t('app', 'Zipcode'),
			'mfdonline' => Yii::t('app', 'Mfdonline'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'slug' => Yii::t('app', 'Slug'),
			'district_search' => Yii::t('app', 'District'),
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
	public function getDistrict()
	{
		return $this->hasOne(CoreZoneDistrict::className(), ['district_id' => 'district_id']);
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
		return $this->hasOne(CoreZoneVillageView::className(), ['village_id' => 'village_id']);
	}

	/**
	 * @inheritdoc
	 * @return CoreZoneCityQuery the active query used by this AR class.
	 */
	public static function find()
	{
		return new CoreZoneVillageQuery(get_called_class());
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
		$this->templateColumns['village_name'] = [
			'attribute' => 'village_name',
			'value' => function($model, $key, $index, $column) {
				return $model->village_name;
			},
		];
		if(!Yii::$app->request->get('district')) {
			$this->templateColumns['district_search'] = [
				'attribute' => 'district_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->district) ? $model->district->district_name : '-';
				},
			];
		}
		if(!isset($_GET['city'])) {
			$this->templateColumns['city_search'] = [
				'attribute' => 'city_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->district->city) ? $model->district->city->city_name : '-';
				},
			];
		}
		if(!Yii::$app->request->get('province')) {
			$this->templateColumns['province_search'] = [
				'attribute' => 'province_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->district->city->province) ? $model->district->city->province->province_name : '-';
				},
			];
		}
		if(!Yii::$app->request->get('country')) {
			$this->templateColumns['country_search'] = [
				'attribute' => 'country_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->district->city->province->country) ? $model->district->city->province->country->country_name : '-';
				},
			];
		}
		$this->templateColumns['zipcode'] = [
			'attribute' => 'zipcode',
			'value' => function($model, $key, $index, $column) {
				return $model->zipcode;
			},
			'contentOptions' => ['class'=>'center'],
		];
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
				->where(['village_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * function getVillage
	 */
	public static function getVillage($publish=null, $array=true) 
	{
		$model = self::find()->alias('t');
		if($publish != null)
			$model = $model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('t.village_name ASC')->all();

		if($array == true) {
			$items = [];
			if($model !== null) {
				foreach($model as $val) {
					$items[$val->village_id] = $val->village_name;
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