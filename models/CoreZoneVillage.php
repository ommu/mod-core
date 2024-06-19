<?php
/**
 * CoreZoneVillage
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)811-2540-432
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 16:09 WIB
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
use yii\helpers\Html;
use yii\helpers\Url;
use yii\behaviors\SluggableBehavior;
use app\models\Users;

class CoreZoneVillage extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['checked', 'creation_date', 'creationDisplayname', 'modified_date', 'modifiedDisplayname', 'updated_date', 'slug'];

	public $districtName;
	public $creationDisplayname;
	public $modifiedDisplayname;
	public $cityName;
	public $provinceName;
	public $countryName;

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
			'districtName' => Yii::t('app', 'District'),
			'creationDisplayname' => Yii::t('app', 'Creation'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
			'cityName' => Yii::t('app', 'City'),
			'provinceName' => Yii::t('app', 'Province'),
			'countryName' => Yii::t('app', 'Country'),
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
	public function getCity()
	{
		return $this->hasOne(CoreZoneCity::className(), ['city_id' => 'city_id'])
			->via('district');
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProvince()
	{
		return $this->hasOne(CoreZoneProvince::className(), ['province_id' => 'province_id'])
			->via('city');
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
	 * @return \ommu\core\models\query\CoreZoneVillage the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\CoreZoneVillage(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
        parent::init();

        if (!(Yii::$app instanceof \app\components\Application)) {
            return;
        }

        if (!$this->hasMethod('search')) {
            return;
        }

		$this->templateColumns['_no'] = [
			'header' => '#',
			'class' => 'app\components\grid\SerialColumn',
			'contentOptions' => ['class' => 'text-center'],
		];
		$this->templateColumns['mfdonline'] = [
			'attribute' => 'mfdonline',
			'value' => function($model, $key, $index, $column) {
				return $model->mfdonline;
			},
			'contentOptions' => ['class' => 'text-center'],
		];
		$this->templateColumns['village_name'] = [
			'attribute' => 'village_name',
			'value' => function($model, $key, $index, $column) {
				return $model->village_name;
			},
		];
		$this->templateColumns['districtName'] = [
			'attribute' => 'districtName',
			'value' => function($model, $key, $index, $column) {
				return isset($model->district) ? $model->district->district_name : '-';
				// return $model->districtName;
			},
			'visible' => !Yii::$app->request->get('district') ? true : false,
		];
        $this->templateColumns['cityName'] = [
            'attribute' => 'cityName',
            'value' => function($model, $key, $index, $column) {
                return isset($model->district->city) ? $model->district->city->city_name : '-';
                // return $model->cityName;
            },
            'visible' => !isset($_GET['city']) && !Yii::$app->request->get('district') ? true : false,
        ];
        $this->templateColumns['provinceName'] = [
            'attribute' => 'provinceName',
            'value' => function($model, $key, $index, $column) {
                return isset($model->district->city->province) ? $model->district->city->province->province_name : '-';
                // return $model->provinceName;
            },
            'visible' => !Yii::$app->request->get('province') && !isset($_GET['city']) && !Yii::$app->request->get('district') ? true : false,
        ];
        $this->templateColumns['countryName'] = [
            'attribute' => 'countryName',
            'value' => function($model, $key, $index, $column) {
                return isset($model->district->city->province->country) ? $model->district->city->province->country->country_name : '-';
                // return $model->countryName;
            },
            'visible' => !Yii::$app->request->get('country') && !Yii::$app->request->get('province') && !isset($_GET['city']) && !Yii::$app->request->get('district') ? true : false,
        ];
		$this->templateColumns['zipcode'] = [
			'attribute' => 'zipcode',
			'value' => function($model, $key, $index, $column) {
				return $model->zipcode;
			},
			'contentOptions' => ['class' => 'text-center'],
		];
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
		$this->templateColumns['publish'] = [
			'attribute' => 'publish',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['publish', 'id' => $model->primaryKey]);
				return $this->quickAction($url, $model->publish);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class' => 'text-center'],
			'format' => 'raw',
			'visible' => !Yii::$app->request->get('trash') ? true : false,
		];
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
        if ($column != null) {
            $model = self::find();
            if (is_array($column)) {
                $model->select($column);
            } else {
                $model->select([$column]);
            }
            $model = $model->where(['village_id' => $id])->one();
            return is_array($column) ? $model : $model->$column;

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
		$model = self::find()
            ->alias('t')
			->suggest();
        if ($publish != null) {
            $model = $model->andWhere(['t.publish' => $publish]);
        }

		$model = $model->orderBy('t.village_name ASC')->all();

        if ($array == true) {
            return \yii\helpers\ArrayHelper::map($model, 'village_id', 'village_name');
        }

		return $model;
	}

	/**
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->districtName = isset($this->district) ? $this->district->district_name : '-';
		// $this->creationDisplayname = isset($this->creation) ? $this->creation->displayname : '-';
		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
		// $this->cityName = isset($this->district) ? $this->district->city->city_name : '-';
		// $this->provinceName = isset($this->district) ? $this->district->city->province->province_name : '-';
		// $this->countryName = isset($this->district) ? $this->district->city->province->country->country_name : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
        if (parent::beforeValidate()) {
            if ($this->isNewRecord) {
                if ($this->creation_id == null) {
                    $this->creation_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                }
            } else {
                if ($this->modified_id == null) {
                    $this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
                }
            }
        }
        return true;
	}
}
