<?php
/**
 * CoreZoneCity
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 14 September 2017, 22:22 WIB
 * @modified date 30 January 2019, 16:09 WIB
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
use yii\helpers\Html;
use yii\helpers\Url;
use yii\behaviors\SluggableBehavior;
use app\models\Users;

class CoreZoneCity extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['checked', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date', 'slug'];

	public $provinceName;
	public $creationDisplayname;
	public $modifiedDisplayname;
	public $countryName;

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
			'districts' => Yii::t('app', 'Districts'),
			'provinceName' => Yii::t('app', 'Province'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'countryName' => Yii::t('app', 'Country'),
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
	public function getCountry()
	{
		return $this->hasOne(CoreZoneCountry::className(), ['country_id' => 'country_id'])
			->via('province');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getDistricts($count=false, $publish=1)
	{
		if($count == false) {
			return $this->hasMany(CoreZoneDistrict::className(), ['city_id' => 'city_id'])
				->alias('districts')
				->andOnCondition([sprintf('%s.publish', 'districts') => $publish]);
		}

		$model = CoreZoneDistrict::find()
			->alias('t')
			->where(['t.city_id' => $this->city_id]);
		if($publish == 0)
			$model->unpublish();
		elseif($publish == 1)
			$model->published();
		elseif($publish == 2)
			$model->deleted();
		$districts = $model->count();

		return $districts ? $districts : 0;
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
	 * {@inheritdoc}
	 * @return \ommu\core\models\query\CoreZoneCity the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\CoreZoneCity(get_called_class());
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
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['mfdonline'] = [
			'attribute' => 'mfdonline',
			'value' => function($model, $key, $index, $column) {
				return $model->mfdonline;
			},
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['city_name'] = [
			'attribute' => 'city_name',
			'value' => function($model, $key, $index, $column) {
				return $model->city_name;
			},
		];
		$this->templateColumns['provinceName'] = [
			'attribute' => 'provinceName',
			'value' => function($model, $key, $index, $column) {
				return isset($model->province) ? $model->province->province_name : '-';
				// return $model->provinceName;
			},
			// 'filter' => CoreZoneProvince::getProvince(),
			'visible' => !Yii::$app->request->get('province') ? true : false,
		];
		if(!Yii::$app->request->get('country') && !Yii::$app->request->get('province')) {
			$this->templateColumns['countryName'] = [
				'attribute' => 'countryName',
				'value' => function($model, $key, $index, $column) {
					return isset($model->province->country) ? $model->province->country->country_name : '-';
					// return $model->countryName;
				},
			];
		}
		$this->templateColumns['creation_date'] = [
			'attribute' => 'creation_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->creation_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'creation_date'),
		];
		$this->templateColumns['creationDisplayname'] = [
			'attribute' => 'creationDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->creation) ? $model->creation->displayname : '-';
				// return $model->creationDisplayname;
			},
			'visible' => !Yii::$app->request->get('creation') ? true : false,
		];
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->modified_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
		];
		$this->templateColumns['modifiedDisplayname'] = [
			'attribute' => 'modifiedDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->modified) ? $model->modified->displayname : '-';
				// return $model->modifiedDisplayname;
			},
			'visible' => !Yii::$app->request->get('modified') ? true : false,
		];
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
		$this->templateColumns['districts'] = [
			'attribute' => 'districts',
			'value' => function($model, $key, $index, $column) {
				$districts = $model->getDistricts(true);
				return Html::a($districts, ['zone/district/manage', 'city'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} districts', ['count'=>$districts]), 'data-pjax'=>0]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
		];
		$this->templateColumns['checked'] = [
			'attribute' => 'checked',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->checked);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
		];
		$this->templateColumns['publish'] = [
			'attribute' => 'publish',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['publish', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->publish);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
			'visible' => !Yii::$app->request->get('trash') ? true : false,
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

	/**
	 * function getCity
	 */
	public static function getCity($publish=null, $array=true) 
	{
		$model = self::find()
			->alias('t')
			->suggest();
		if($publish != null)
			$model = $model->andWhere(['t.publish' => $publish]);

		$model = $model->orderBy('t.city_name ASC')->all();

		if($array == true)
			return \yii\helpers\ArrayHelper::map($model, 'city_id', 'city_name');

		return $model;
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->provinceName = isset($this->province) ? $this->province->province_name : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
		// $this->countryName = isset($this->province) ? $this->province->country->country_name : '-';
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
