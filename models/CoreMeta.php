<?php
/**
 * CoreMeta
 * 
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 22 April 2018, 18:33 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_meta".
 *
 * The followings are the available columns in table "ommu_core_meta":
 * @property integer $id
 * @property string $meta_image
 * @property string $meta_image_alt
 * @property integer $office_on
 * @property string $office_name
 * @property string $office_location
 * @property string $office_place
 * @property integer $office_country_id
 * @property integer $office_province_id
 * @property integer $office_city_id
 * @property string $office_district
 * @property string $office_village
 * @property string $office_zipcode
 * @property string $office_hour
 * @property string $office_phone
 * @property string $office_fax
 * @property string $office_email
 * @property string $office_hotline
 * @property string $office_website
 * @property string $map_icons
 * @property string $map_icon_size
 * @property integer $google_on
 * @property integer $twitter_on
 * @property integer $twitter_card
 * @property string $twitter_site
 * @property string $twitter_creator
 * @property string $twitter_photo_size
 * @property string $twitter_country
 * @property string $twitter_iphone
 * @property string $twitter_ipad
 * @property string $twitter_googleplay
 * @property integer $facebook_on
 * @property integer $facebook_type
 * @property string $facebook_profile_firstname
 * @property string $facebook_profile_lastname
 * @property string $facebook_profile_username
 * @property string $facebook_sitename
 * @property string $facebook_see_also
 * @property string $facebook_admins
 * @property string $modified_date
 * @property integer $modified_id
 *
 * The followings are the available model relations:
 * @property Users $modified
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Url;
use app\models\Users;
use ommu\core\models\CoreZoneCountry;
use ommu\core\models\CoreZoneProvince;
use ommu\core\models\CoreZoneCity;
use yii\helpers\Html;
use yii\web\UploadedFile;

class CoreMeta extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;
	use \ommu\traits\FileTrait;

	public $gridForbiddenColumn = [];

	public $old_meta_image_i;
	public $modifiedDisplayname;

	const SCENARIO_SETTING = 'setting';
	const SCENARIO_GOOGLE = 'google';
	const SCENARIO_TWITTER = 'twitter';
	const SCENARIO_FACEBOOK = 'facebook';
	const SCENARIO_ADDRESS = 'address';

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_core_meta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['meta_image', 'meta_image_alt', 'office_on', 'google_on', 'twitter_on', 'facebook_on'], 'required', 'on' => self::SCENARIO_SETTING],
			[['office_on', 'google_on', 'office_name', 'office_location', 'office_place', 'office_country_id', 'office_province_id', 'office_city_id', 'office_district', 'office_district', 'office_village'], 'required', 'on' => self::SCENARIO_GOOGLE],
			[['twitter_on', 'twitter_card', 'twitter_site', 'twitter_creator', 'twitter_country'], 'required', 'on' => self::SCENARIO_TWITTER],
			[['facebook_on', 'facebook_type', 'facebook_sitename', 'facebook_see_also', 'facebook_admins'], 'required', 'on' => self::SCENARIO_FACEBOOK],
			[['office_name', 'office_location', 'office_place', 'office_country_id', 'office_province_id', 'office_city_id', 'office_district', 'office_district', 'office_village'], 'required', 'on' => self::SCENARIO_ADDRESS],
			//[['office_on','office_name', 'office_place', 'office_country_id', 'office_province_id', 'office_city_id', 'office_district', 'office_village', 'office_zipcode', 'office_phone', 'office_email', 'office_website','google_on','twitter_on', 'twitter_card', 'twitter_site','facebook_on', 'facebook_sitename'], 'required'],
			[['office_on', 'office_country_id', 'office_province_id', 'office_city_id', 'google_on', 'twitter_on', 'twitter_card', 'facebook_on', 'facebook_type', 'modified_id'], 'integer'],
			[['meta_image', 'meta_image_alt', 'office_place', 'office_hour'], 'string'],
			[['meta_image', 'meta_image_alt', 'office_location', 'office_hour', 'office_fax', 'office_hotline', 'map_icons', 'map_icon_size', 'twitter_creator', 'twitter_photo_size', 'twitter_country', 'twitter_iphone', 'twitter_ipad', 'twitter_googleplay', 'facebook_profile_firstname', 'facebook_profile_lastname', 'facebook_profile_username', 'facebook_see_also', 'facebook_admins', 'modified_date'], 'safe'],
			[['office_name', 'office_district', 'office_village', 'facebook_sitename'], 'string', 'max' => 64],
			[['office_location', 'office_phone', 'office_fax', 'office_email', 'office_hotline', 'office_website', 'map_icons', 'twitter_site', 'twitter_creator', 'twitter_country', 'facebook_profile_firstname', 'facebook_profile_lastname', 'facebook_profile_username', 'facebook_admins'], 'string', 'max' => 32],
			[['office_zipcode'], 'string', 'max' => 5],
			[['facebook_see_also'], 'string', 'max' => 256],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		return [
			self::SCENARIO_SETTING => ['meta_image', 'meta_image_alt', 'office_on', 'google_on', 'twitter_on', 'facebook_on'],
			self::SCENARIO_GOOGLE => ['office_on', 'google_on', 'office_name', 'office_location', 'office_place', 'office_country_id', 'office_province_id', 'office_city_id', 'office_district', 'office_district', 'office_village', 'office_zipcode', 'office_phone', 'office_fax', 'office_email', 'office_website'],
			self::SCENARIO_TWITTER => ['twitter_on', 'twitter_card', 'twitter_site', 'twitter_creator', 'twitter_photo_size', 'twitter_country', 'twitter_iphone', 'twitter_ipad', 'twitter_googleplay'],
			self::SCENARIO_FACEBOOK => ['facebook_on', 'facebook_type', 'facebook_profile_firstname', 'facebook_profile_lastname', 'facebook_profile_username', 'facebook_sitename', 'facebook_see_also', 'facebook_admins'],
			self::SCENARIO_ADDRESS => ['office_name', 'office_location', 'office_place', 'office_country_id', 'office_province_id', 'office_city_id', 'office_district', 'office_district', 'office_village', 'office_zipcode', 'office_phone', 'office_fax', 'office_email', 'office_website'],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'meta_image' => Yii::t('app', 'Meta Image'),
			'meta_image_alt' => Yii::t('app', 'Meta Image Alt'),
			'office_on' => Yii::t('app', 'Google Owner Meta'),
			'office_name' => Yii::t('app', 'Office Name'),
			'office_location' => Yii::t('app', 'Office Location'),
			'office_place' => Yii::t('app', 'Office Place'),
			'office_country_id' => Yii::t('app', 'Office Country'),
			'office_province_id' => Yii::t('app', 'Office Province'),
			'office_city_id' => Yii::t('app', 'Office City'),
			'office_district' => Yii::t('app', 'Office District'),
			'office_village' => Yii::t('app', 'Office Village'),
			'office_zipcode' => Yii::t('app', 'Office Zipcode'),
			'office_hour' => Yii::t('app', 'Office Hour'),
			'office_phone' => Yii::t('app', 'Office Phone'),
			'office_fax' => Yii::t('app', 'Office Fax'),
			'office_email' => Yii::t('app', 'Office Email'),
			'office_hotline' => Yii::t('app', 'Office Hotline'),
			'office_website' => Yii::t('app', 'Office Website'),
			'map_icons' => Yii::t('app', 'Map Icon'),
			'map_icon_size' => Yii::t('app', 'Map Icon Size'),
			'google_on' => Yii::t('app', 'Google Plus Meta'),
			'twitter_on' => Yii::t('app', 'Twitter Meta'),
			'twitter_card' => Yii::t('app', 'Twitter Card'),
			'twitter_site' => Yii::t('app', 'Twitter Site'),
			'twitter_creator' => Yii::t('app', 'Twitter Creator'),
			'twitter_photo_size' => Yii::t('app', 'Twitter Photo Size'),
			'twitter_photo_size[i]' => Yii::t('app', 'Twitter Photo Size'),
			'twitter_photo_size[width]' => Yii::t('app', 'Photo Width'),
			'twitter_photo_size[height]' => Yii::t('app', 'Photo Height'),
			'twitter_country' => Yii::t('app', 'Twitter Country'),
			'twitter_iphone' => Yii::t('app', 'Twitter Iphone'),
			'twitter_iphone[i]' => Yii::t('app', 'Twitter Iphone'),
			'twitter_iphone[name]' => Yii::t('app', 'Application Name'),
			'twitter_iphone[id]' => Yii::t('app', 'Application ID'),
			'twitter_iphone[url]' => Yii::t('app', 'Application URL'),
			'twitter_ipad' => Yii::t('app', 'Twitter Ipad'),
			'twitter_ipad[i]' => Yii::t('app', 'Twitter Ipad'),
			'twitter_ipad[name]' => Yii::t('app', 'Application Name'),
			'twitter_ipad[id]' => Yii::t('app', 'Application ID'),
			'twitter_ipad[url]' => Yii::t('app', 'Application URL'),
			'twitter_googleplay' => Yii::t('app', 'Twitter Googleplay'),
			'twitter_googleplay[i]' => Yii::t('app', 'Twitter Googleplay'),
			'twitter_googleplay[name]' => Yii::t('app', 'Application Name'),
			'twitter_googleplay[id]' => Yii::t('app', 'Application ID'),
			'twitter_googleplay[url]' => Yii::t('app', 'Application URL'),
			'facebook_on' => Yii::t('app', 'Facebook Meta'),
			'facebook_type' => Yii::t('app', 'Facebook Type'),
			'facebook_profile_firstname' => Yii::t('app', 'Facebook Profile Firstname'),
			'facebook_profile_lastname' => Yii::t('app', 'Facebook Profile Lastname'),
			'facebook_profile_username' => Yii::t('app', 'Facebook Profile Username'),
			'facebook_sitename' => Yii::t('app', 'Facebook Sitename'),
			'facebook_see_also' => Yii::t('app', 'Facebook See Also'),
			'facebook_admins' => Yii::t('app', 'Facebook Admin'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
			'old_meta_image_i' => Yii::t('app', 'Old Meta Image'),
			'modifiedDisplayname' => Yii::t('app', 'Modified'),
		];
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
	public function getCountry()
	{
		return $this->hasOne(CoreZoneCountry::className(), ['country_id' => 'office_country_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getProvince()
	{
		return $this->hasOne(CoreZoneProvince::className(), ['province_id' => 'office_province_id']);
	}

	public function getCity()
	{
		return $this->hasOne(CoreZoneCity::className(), ['city_id' => 'office_city_id']);
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
		$this->templateColumns['meta_image'] = [
			'attribute' => 'meta_image',
			'value' => function($model, $key, $index, $column) {
				return $model->meta_image;
			},
		];
		$this->templateColumns['meta_image_alt'] = [
			'attribute' => 'meta_image_alt',
			'value' => function($model, $key, $index, $column) {
				return $model->meta_image_alt;
			},
		];
		$this->templateColumns['office_name'] = [
			'attribute' => 'office_name',
			'value' => function($model, $key, $index, $column) {
				return $model->office_name;
			},
		];
		$this->templateColumns['office_location'] = [
			'attribute' => 'office_location',
			'value' => function($model, $key, $index, $column) {
				return $model->office_location;
			},
		];
		$this->templateColumns['office_place'] = [
			'attribute' => 'office_place',
			'value' => function($model, $key, $index, $column) {
				return $model->office_place;
			},
		];
		$this->templateColumns['office_country_id'] = [
			'attribute' => 'office_country_id',
			'value' => function($model, $key, $index, $column) {
				return $model->office_country_id;
			},
		];
		$this->templateColumns['office_province_id'] = [
			'attribute' => 'office_province_id',
			'value' => function($model, $key, $index, $column) {
				return $model->office_province_id;
			},
		];
		$this->templateColumns['office_city_id'] = [
			'attribute' => 'office_city_id',
			'value' => function($model, $key, $index, $column) {
				return $model->office_city_id;
			},
		];
		$this->templateColumns['office_district'] = [
			'attribute' => 'office_district',
			'value' => function($model, $key, $index, $column) {
				return $model->office_district;
			},
		];
		$this->templateColumns['office_village'] = [
			'attribute' => 'office_village',
			'value' => function($model, $key, $index, $column) {
				return $model->office_village;
			},
		];
		$this->templateColumns['office_zipcode'] = [
			'attribute' => 'office_zipcode',
			'value' => function($model, $key, $index, $column) {
				return $model->office_zipcode;
			},
		];
		$this->templateColumns['office_hour'] = [
			'attribute' => 'office_hour',
			'value' => function($model, $key, $index, $column) {
				return $model->office_hour;
			},
		];
		$this->templateColumns['office_phone'] = [
			'attribute' => 'office_phone',
			'value' => function($model, $key, $index, $column) {
				return $model->office_phone;
			},
		];
		$this->templateColumns['office_fax'] = [
			'attribute' => 'office_fax',
			'value' => function($model, $key, $index, $column) {
				return $model->office_fax;
			},
		];
		$this->templateColumns['office_email'] = [
			'attribute' => 'office_email',
			'value' => function($model, $key, $index, $column) {
				return $model->office_email;
			},
		];
		$this->templateColumns['office_hotline'] = [
			'attribute' => 'office_hotline',
			'value' => function($model, $key, $index, $column) {
				return $model->office_hotline;
			},
		];
		$this->templateColumns['office_website'] = [
			'attribute' => 'office_website',
			'value' => function($model, $key, $index, $column) {
				return $model->office_website;
			},
		];
		$this->templateColumns['map_icons'] = [
			'attribute' => 'map_icons',
			'value' => function($model, $key, $index, $column) {
				return $model->map_icons;
			},
		];
		$this->templateColumns['map_icon_size'] = [
			'attribute' => 'map_icon_size',
			'value' => function($model, $key, $index, $column) {
				return $model->map_icon_size;
			},
		];
		$this->templateColumns['twitter_site'] = [
			'attribute' => 'twitter_site',
			'value' => function($model, $key, $index, $column) {
				return $model->twitter_site;
			},
		];
		$this->templateColumns['twitter_creator'] = [
			'attribute' => 'twitter_creator',
			'value' => function($model, $key, $index, $column) {
				return $model->twitter_creator;
			},
		];
		$this->templateColumns['twitter_photo_size'] = [
			'attribute' => 'twitter_photo_size',
			'value' => function($model, $key, $index, $column) {
				return $model->twitter_photo_size;
			},
		];
		$this->templateColumns['twitter_country'] = [
			'attribute' => 'twitter_country',
			'value' => function($model, $key, $index, $column) {
				return $model->twitter_country;
			},
		];
		$this->templateColumns['twitter_iphone'] = [
			'attribute' => 'twitter_iphone',
			'value' => function($model, $key, $index, $column) {
				return $model->twitter_iphone;
			},
		];
		$this->templateColumns['twitter_ipad'] = [
			'attribute' => 'twitter_ipad',
			'value' => function($model, $key, $index, $column) {
				return $model->twitter_ipad;
			},
		];
		$this->templateColumns['twitter_googleplay'] = [
			'attribute' => 'twitter_googleplay',
			'value' => function($model, $key, $index, $column) {
				return $model->twitter_googleplay;
			},
		];
		$this->templateColumns['facebook_profile_firstname'] = [
			'attribute' => 'facebook_profile_firstname',
			'value' => function($model, $key, $index, $column) {
				return $model->facebook_profile_firstname;
			},
		];
		$this->templateColumns['facebook_profile_lastname'] = [
			'attribute' => 'facebook_profile_lastname',
			'value' => function($model, $key, $index, $column) {
				return $model->facebook_profile_lastname;
			},
		];
		$this->templateColumns['facebook_profile_username'] = [
			'attribute' => 'facebook_profile_username',
			'value' => function($model, $key, $index, $column) {
				return $model->facebook_profile_username;
			},
		];
		$this->templateColumns['facebook_sitename'] = [
			'attribute' => 'facebook_sitename',
			'value' => function($model, $key, $index, $column) {
				return $model->facebook_sitename;
			},
		];
		$this->templateColumns['facebook_see_also'] = [
			'attribute' => 'facebook_see_also',
			'value' => function($model, $key, $index, $column) {
				return $model->facebook_see_also;
			},
		];
		$this->templateColumns['facebook_admins'] = [
			'attribute' => 'facebook_admins',
			'value' => function($model, $key, $index, $column) {
				return $model->facebook_admins;
			},
		];
		$this->templateColumns['modified_date'] = [
			'attribute' => 'modified_date',
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'datetime') : '-';
			},
			'filter' => $this->filterDatepicker($this, 'modified_date'),
			'format' => 'html',
		];
		$this->templateColumns['modifiedDisplayname'] = [
			'attribute' => 'modifiedDisplayname',
			'value' => function($model, $key, $index, $column) {
				return isset($model->modified) ? $model->modified->displayname : '-';
				// return $model->modifiedDisplayname;
			},
			'visible' => !Yii::$app->request->get('modified') ? true : false,
		];
		$this->templateColumns['twitter_card'] = [
			'attribute' => 'twitter_card',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['twitter-card', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->twitter_card, '1=summary, 2=summary_large_image, 3=photo,4=app');
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
		];
		$this->templateColumns['facebook_type'] = [
			'attribute' => 'facebook_type',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['facebook-type', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->facebook_type, '1=profile, 2=website');
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
		];
		$this->templateColumns['office_on'] = [
			'attribute' => 'office_on',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['office-on', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->office_on, '0=disable, 1=enable');
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
		];
		$this->templateColumns['google_on'] = [
			'attribute' => 'google_on',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['google-on', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->google_on, '0=disable, 1=enable');
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
		];
		$this->templateColumns['twitter_on'] = [
			'attribute' => 'twitter_on',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['twitter-on', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->twitter_on, '0=disable, 1=enable');
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
		];
		$this->templateColumns['facebook_on'] = [
			'attribute' => 'facebook_on',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['facebook-on', 'id'=>$model->primaryKey]);
				return $this->quickAction($url, $model->facebook_on, '0=disable, 1=enable');
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'text-center'],
			'format' => 'raw',
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

	/**
	 * @param returnAlias set true jika ingin kembaliannya path alias atau false jika ingin string
	 * relative path. default true.
	 */
	public static function getUploadPath($returnAlias=true) 
	{
		return ($returnAlias ? Yii::getAlias('@public') : 'public');
	}

	/**
	 * after find attributes
	 */
	public function afterFind() 
	{
		$this->old_meta_image_i = $this->meta_image;
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;

			$meta_imageFileType = ['bmp','gif','jpg','png'];
			$meta_image = UploadedFile::getInstance($this, 'meta_image');

			if($meta_image instanceof UploadedFile && !$meta_image->getHasError()) {
				if(!in_array(strtolower($meta_image->getExtension()), $meta_imageFileType)) {
					$this->addError('meta_image', Yii::t('app', 'The file {name} cannot be uploaded. Only files with these extensions are allowed: {extensions}', array(
						'{name}'=>$meta_image->name,
						'{extensions}'=>$this->formatFileType($meta_imageFileType, false),
					)));
				}
			} /* else {
				//if($this->isNewRecord)
					$this->addError('meta_image', Yii::t('app', '{attribute} cannot be blank.', array('{attribute}'=>$this->getAttributeLabel('meta_image'))));
			} */
			
			if($this->scenario == self::SCENARIO_TWITTER) {
				if($this->twitter_card == 3) {
					if($this->twitter_photo_size['width'] == '')
						$this->addError('twitter_photo_size[width]', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('twitter_photo_size[width]')]));
					if($this->twitter_photo_size['height'] == '')
						$this->addError('twitter_photo_size[height]', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('twitter_photo_size[height]')]));
				}
			}
			
			if($this->scenario == self::SCENARIO_FACEBOOK) {
				if($this->facebook_type == 1) {
					if($this->facebook_profile_firstname == '')
						$this->addError('facebook_profile_firstname', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('facebook_profile_firstname')]));
					if($this->facebook_profile_lastname == '')
						$this->addError('facebook_profile_lastname', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('facebook_profile_lastname')]));
					//if($this->facebook_profile_username == '')
					//	$this->addError('facebook_profile_username', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('facebook_profile_username')]));
				}
			}
		}
		return true;
	}

	/**
	 * before save attributes
	 */
	public function beforeSave($insert)
	{
		if(parent::beforeSave($insert)) {
			$uploadPath = self::getUploadPath();
			$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);
			$this->createUploadDirectory(self::getUploadPath());

			$this->meta_image = UploadedFile::getInstance($this, 'meta_image');
			if($this->meta_image instanceof UploadedFile && !$this->meta_image->getHasError()) {
				$fileName = 'meta_'.time().'.'.strtolower($this->meta_image->getExtension()); 
				if($this->meta_image->saveAs(join('/', [$uploadPath, $fileName]))) {
					if($this->old_meta_image_i != '' && file_exists(join('/', [$uploadPath, $this->old_meta_image_i])))
						rename(join('/', [$uploadPath, $this->old_meta_image_i]), join('/', [$verwijderenPath, time().'_change_'.$this->old_meta_image_i]));
					$this->meta_image = $fileName;
				}
			} else {
				if($this->meta_image == '')
					$this->meta_image = $this->old_meta_image_i;
			}
			
			if($this->scenario == self::SCENARIO_SETTING)
				$this->map_icon_size = serialize($this->map_icon_size);
			
			if($this->scenario == self::SCENARIO_TWITTER) {
				$this->twitter_photo_size = serialize($this->twitter_photo_size);
				$this->twitter_iphone = serialize($this->twitter_iphone);
				$this->twitter_ipad = serialize($this->twitter_ipad);
				$this->twitter_googleplay = serialize($this->twitter_googleplay);
			}
		}
		return true;
	}

	/**
	 * After delete attributes
	 */
	public function afterDelete() 
	{
		parent::afterDelete();

		$uploadPath = self::getUploadPath();
		$verwijderenPath = join('/', [self::getUploadPath(), 'verwijderen']);

		if($this->meta_image != '' && file_exists(join('/', [$uploadPath, $this->meta_image])))
			rename(join('/', [$uploadPath, $this->meta_image]), join('/', [$verwijderenPath, time().'_deleted_'.$this->meta_image]));
	}
}
