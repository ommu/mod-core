<?php
/**
 * CoreZoneProvince
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 8 September 2017, 13:40 WIB
 * @modified date 30 January 2019, 16:08 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_zone_province".
 *
 * The followings are the available columns in table "ommu_core_zone_province":
 * @property integer $province_id
 * @property integer $publish
 * @property integer $country_id
 * @property string $province_name
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
 * @property CoreZoneCity[] $cities
 * @property CoreZoneCountry $country
 * @property Users $creation
 * @property Users $modified
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\behaviors\SluggableBehavior;
use ommu\users\models\Users;
use ommu\core\models\view\CoreZoneProvince as CoreZoneProvinceView;

class CoreZoneProvince extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['checked', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date', 'slug'];

	public $countryName;
	public $creationDisplayname;
	public $modifiedDisplayname;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_core_zone_province';
	}

	/**
	 * behaviors model class.
	 */
	public function behaviors() {
		return [
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'province_name',
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
			[['province_name', 'mfdonline'], 'required'],
			[['publish', 'country_id', 'checked', 'creation_id', 'modified_id'], 'integer'],
			[['province_name', 'slug'], 'string', 'max' => 64],
			[['mfdonline'], 'string', 'max' => 2],
			[['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => CoreZoneCountry::className(), 'targetAttribute' => ['country_id' => 'country_id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'province_id' => Yii::t('app', 'Province'),
			'publish' => Yii::t('app', 'Publish'),
			'country_id' => Yii::t('app', 'Country'),
			'province_name' => Yii::t('app', 'Province'),
			'mfdonline' => Yii::t('app', 'Mfdonline'),
			'checked' => Yii::t('app', 'Checked'),
			'creation_date' => Yii::t('app', 'Creation Date'),
			'creation_id' => Yii::t('app', 'Creation'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'updated_date' => Yii::t('app', 'Updated Date'),
			'slug' => Yii::t('app', 'Slug'),
			'cities' => Yii::t('app', 'Cities'),
			'countryName' => Yii::t('app', 'Country'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCities($count=false, $publish=1)
	{
		if($count == false) {
			return $this->hasMany(CoreZoneCity::className(), ['province_id' => 'province_id'])
				->andOnCondition([sprintf('%s.publish', CoreZoneCity::tableName()) => $publish]);
		}

		$model = CoreZoneCity::find()
			->where(['province_id' => $this->province_id]);
		if($publish == 0)
			$model->unpublish();
		elseif($publish == 1)
			$model->published();
		elseif($publish == 2)
			$model->deleted();
		$cities = $model->count();

		return $cities ? $cities : 0;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getCountry()
	{
		return $this->hasOne(CoreZoneCountry::className(), ['country_id' => 'country_id']);
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
		return $this->hasOne(CoreZoneProvinceView::className(), ['province_id' => 'province_id']);
	}

	/**
	 * {@inheritdoc}
	 * @return \ommu\core\models\query\CoreZoneProvince the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\CoreZoneProvince(get_called_class());
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
		$this->templateColumns['mfdonline'] = [
			'attribute' => 'mfdonline',
			'value' => function($model, $key, $index, $column) {
				return $model->mfdonline;
			},
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['province_name'] = [
			'attribute' => 'province_name',
			'value' => function($model, $key, $index, $column) {
				return $model->province_name;
			},
		];
		if(!Yii::$app->request->get('country')) {
			$this->templateColumns['countryName'] = [
				'attribute' => 'countryName',
				'value' => function($model, $key, $index, $column) {
					return isset($model->country) ? $model->country->country_name : '-';
					// return $model->countryName;
				},
				// 'filter' => CoreZoneCountry::getCountry(),
			];
		}
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		if(!Yii::$app->request->get('creation')) {
			$this->templateColumns['creationDisplayname'] = [
				'attribute' => 'creationDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->creation) ? $model->creation->displayname : '-';
					// return $model->creationDisplayname;
				},
			];
		}
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		if(!Yii::$app->request->get('modified')) {
			$this->templateColumns['modifiedDisplayname'] = [
				'attribute' => 'modifiedDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->modified) ? $model->modified->displayname : '-';
					// return $model->modifiedDisplayname;
				},
			];
		}
		$this->templateColumns['updated_date'] = [
			'attribute' => 'updated_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->updated_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'updated_date'),
		];
		$this->templateColumns['slug'] = [
			'attribute' => 'slug',
			'value' => function($model, $key, $index, $column) {
				return $model->slug;
			},
		];
		$this->templateColumns['cities'] = [
			'attribute' => 'cities',
			'value' => function($model, $key, $index, $column) {
				$cities = $model->getCities(true);
				return Html::a($cities, ['zone/city/manage', 'province'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} cities', ['count'=>$cities])]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		$this->templateColumns['checked'] = [
			'attribute' => 'checked',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->checked);
			},
			'filter' => $this->filterYesNo(),
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
				->where(['province_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * function getProvince
	 */
	public static function getProvince($publish=null, $array=true) 
	{
		$model = self::find()->alias('t');
		if($publish != null)
			$model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('t.province_name ASC')->all();

		if($array == true)
			return \yii\helpers\ArrayHelper::map($model, 'province_id', 'province_name');

		return $model;
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->countryName = isset($this->country) ? $this->country->country_name : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->creation_id == null)
					$this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			} else {
				if($this->modified_id == null)
					$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			}
		}
		return true;
	}
}
