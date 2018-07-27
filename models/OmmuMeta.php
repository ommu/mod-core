<?php
/**
 * OmmuMeta
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @modified date 20 January 2018, 06:29 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_meta".
 *
 * The followings are the available columns in table 'ommu_core_meta':
 * @property integer $id
 * @property string $meta_image
 * @property string $meta_image_alt
 * @property integer $office_on
 * @property string $office_name
 * @property string $office_location
 * @property string $office_place
 * @property integer $office_country_id
 * @property integer $office_province_id
 * @property string $office_city_id
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
 * @property string $modified_id
 */

class OmmuMeta extends OActiveRecord
{
	use GridViewTrait;

	public $gridForbiddenColumn = array();
	public $old_meta_image;

	// Variable Search
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuMeta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		preg_match("/dbname=([^;]+)/i", $this->dbConnection->connectionString, $matches);
		return $matches[1].'.ommu_core_meta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('office_place, office_city_id, office_email, office_website', 'required', 'on'=>'contact, google'),
			array('office_on', 'required', 'on'=>'setting, google'),
			array('office_province_id, office_hour, office_hotline', 'required', 'on'=>'contact'),
			array('google_on', 'required', 'on'=>'setting'),
			array('facebook_on', 'required', 'on'=>'setting, facebook, facebook_profile'),
			array('facebook_type', 'required', 'on'=>'facebook, facebook_profile'),
			array('facebook_profile_firstname, facebook_profile_lastname, facebook_profile_username', 'required', 'on'=>'facebook_profile'),
			array('twitter_on', 'required', 'on'=>'setting, twitter'),
			array('twitter_card, twitter_site, twitter_creator', 'required', 'on'=>'twitter'),
			array('office_on, office_country_id, office_province_id, office_city_id, google_on, twitter_on, twitter_card, facebook_on, facebook_type', 'numerical', 'integerOnly'=>true),
			array('meta_image, office_name, office_district, office_village, facebook_sitename', 'length', 'max'=>64),
			array('office_location, office_phone, office_fax, office_email, office_hotline, office_website, map_icons, twitter_site, twitter_creator, twitter_country, facebook_profile_firstname, facebook_profile_lastname, facebook_profile_username, facebook_admins', 'length', 'max'=>32),
			array('office_city_id, modified_id', 'length', 'max'=>11),
			array('office_zipcode', 'length', 'max'=>5),
			array('facebook_see_also', 'length', 'max'=>256),
			array('office_email', 'email'),
			array('meta_image, meta_image_alt, office_name, office_location, office_province_id, office_district, office_village, office_zipcode, office_phone, office_fax, map_icons, twitter_photo_size, twitter_country, twitter_iphone, twitter_ipad, twitter_googleplay, facebook_sitename, facebook_see_also, facebook_admins,
				old_meta_image', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, meta_image, meta_image_alt, office_on, office_name, office_location, office_place, office_country_id, office_province_id, office_city_id, office_district, office_village, office_zipcode, office_hour, office_phone, office_fax, office_email, office_hotline, office_website, map_icons, map_icon_size, google_on, twitter_on, twitter_card, twitter_site, twitter_creator, twitter_photo_size, twitter_country, twitter_iphone, twitter_ipad, twitter_googleplay, facebook_on, facebook_type, facebook_profile_firstname, facebook_profile_lastname, facebook_profile_username, facebook_sitename, facebook_see_also, facebook_admins, modified_date, modified_id,
				modified_search', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'view' => array(self::BELONGS_TO, 'ViewMeta', 'id'),
			'country' => array(self::BELONGS_TO, 'OmmuZoneCountry', 'office_country_id'),
			'province' => array(self::BELONGS_TO, 'OmmuZoneProvince', 'office_province_id'),
			'city' => array(self::BELONGS_TO, 'OmmuZoneCity', 'office_city_id'),
			'modified' => array(self::BELONGS_TO, 'Users', 'modified_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('attribute', 'ID'),
			'meta_image' => Yii::t('attribute', 'Meta Image'),
			'meta_image_alt' => Yii::t('attribute', 'Meta Image Alt'),
			'office_on' => Yii::t('attribute', 'Google Owner Meta'),
			'office_name' => Yii::t('attribute', 'Office Name'),
			'office_location' => Yii::t('attribute', 'Office Maps Location'),
			'office_place' => Yii::t('attribute', 'Office Address'),
			'office_country_id' => Yii::t('attribute', 'Office Country'),
			'office_province_id' => Yii::t('attribute', 'Office Province'),
			'office_city_id' => Yii::t('attribute', 'Office City'),
			'office_district' => Yii::t('attribute', 'Office District'),
			'office_village' => Yii::t('attribute', 'Office Village'),
			'office_zipcode' => Yii::t('attribute', 'Office Zipcode'),
			'office_hour' => Yii::t('attribute', 'Office Hour'),
			'office_phone' => Yii::t('attribute', 'Office Phone'),
			'office_fax' => Yii::t('attribute', 'Office Fax'),
			'office_email' => Yii::t('attribute', 'Office Email'),
			'office_hotline' => Yii::t('attribute', 'Office Hotline'),
			'office_website' => Yii::t('attribute', 'Office Website'),
			'map_icons' => Yii::t('attribute', 'Map Icons'),
			'map_icon_size' => Yii::t('attribute', 'Map Icon Size'),
			'google_on' => Yii::t('attribute', 'Google Plus Meta'),
			'twitter_on' => Yii::t('attribute', 'Twitter Meta'),
			'twitter_card' => Yii::t('attribute', 'Twitter Card'),
			'twitter_site' => Yii::t('attribute', 'Site'),
			'twitter_creator' => Yii::t('attribute', 'Creator'),
			'twitter_photo_size' => Yii::t('attribute', 'Photo Size'),
			'twitter_country' => Yii::t('attribute', 'Country'),
			'twitter_iphone' => Yii::t('attribute', 'Iphone'),
			'twitter_ipad' => Yii::t('attribute', 'Ipad'),
			'twitter_googleplay' => Yii::t('attribute', 'Googleplay'),
			'facebook_on' => Yii::t('attribute', 'Facebook Meta'),
			'facebook_type' => Yii::t('attribute', 'Facebook Type'),
			'facebook_profile_firstname' => Yii::t('attribute', 'Profile Firstname'),
			'facebook_profile_lastname' => Yii::t('attribute', 'Profile Lastname'),
			'facebook_profile_username' => Yii::t('attribute', 'Profile Username'),
			'facebook_sitename' => Yii::t('attribute', 'Sitename'),
			'facebook_see_also' => Yii::t('attribute', 'See Also'),
			'facebook_admins' => Yii::t('attribute', 'Admins'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'old_meta_image' => Yii::t('attribute', 'Old Meta Image'),
			'modified_search' => Yii::t('attribute', 'Modified'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		// Custom Search
		$criteria->with = array(
			'modified' => array(
				'alias' => 'modified',
				'select' => 'displayname',
			),
		);

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.meta_image', $this->meta_image, true);
		$criteria->compare('t.meta_image_alt', $this->meta_image_alt, true);
		$criteria->compare('t.office_on', $this->office_on);
		$criteria->compare('t.office_name', $this->office_name, true);
		$criteria->compare('t.office_location', $this->office_location, true);
		$criteria->compare('t.office_place', $this->office_place, true);
		$criteria->compare('t.office_country_id', $this->office_country_id);
		$criteria->compare('t.office_province_id', $this->office_province_id);
		$criteria->compare('t.office_city_id', $this->office_city_id);
		$criteria->compare('t.office_district', $this->office_district);
		$criteria->compare('t.office_village', $this->office_village);
		$criteria->compare('t.office_zipcode', $this->office_zipcode, true);
		$criteria->compare('t.office_hour', $this->office_hour, true);
		$criteria->compare('t.office_phone', $this->office_phone, true);
		$criteria->compare('t.office_fax', $this->office_fax, true);
		$criteria->compare('t.office_email', $this->office_email, true);
		$criteria->compare('t.office_hotline', $this->office_hotline, true);
		$criteria->compare('t.office_website', $this->office_website, true);
		$criteria->compare('t.map_icons', $this->map_icons, true);
		$criteria->compare('t.map_icon_size', $this->map_icon_size, true);
		$criteria->compare('t.google_on', $this->google_on);
		$criteria->compare('t.twitter_on', $this->twitter_on);
		$criteria->compare('t.twitter_card', $this->twitter_card);
		$criteria->compare('t.twitter_site', $this->twitter_site, true);
		$criteria->compare('t.twitter_creator', $this->twitter_creator, true);
		$criteria->compare('t.twitter_photo_size', $this->twitter_photo_size, true);
		$criteria->compare('t.twitter_country', $this->twitter_country, true);
		$criteria->compare('t.twitter_iphone', $this->twitter_iphone, true);
		$criteria->compare('t.twitter_ipad', $this->twitter_ipad, true);
		$criteria->compare('t.twitter_googleplay', $this->twitter_googleplay, true);
		$criteria->compare('t.facebook_on', $this->facebook_on);
		$criteria->compare('t.facebook_type', $this->facebook_type);
		$criteria->compare('t.facebook_profile_firstname', $this->facebook_profile_firstname, true);
		$criteria->compare('t.facebook_profile_lastname', $this->facebook_profile_lastname, true);
		$criteria->compare('t.facebook_profile_username', $this->facebook_profile_username, true);
		$criteria->compare('t.facebook_sitename', $this->facebook_sitename, true);
		$criteria->compare('t.facebook_see_also', $this->facebook_see_also, true);
		$criteria->compare('t.facebook_admins', $this->facebook_admins, true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified') ? Yii::app()->getRequest()->getParam('modified') : $this->modified_id);

		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('OmmuMeta_sort'))
			$criteria->order = 't.id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['grid-view'] ? Yii::app()->params['grid-view']['pageSize'] : 20,
			),
		));
	}

	/**
	 * Set default columns to display
	 */
	protected function afterConstruct() {
		if(count($this->templateColumns) == 0) {
			$this->templateColumns['_option'] = array(
				'class' => 'CCheckBoxColumn',
				'name' => 'id',
				'selectableRows' => 2,
				'checkBoxHtmlOptions' => array('name' => 'trash_id[]')
			);
			$this->templateColumns['_no'] = array(
				'header' => Yii::t('app', 'No'),
				'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
				'htmlOptions' => array(
					'class' => 'center',
				),
			);
			$this->templateColumns['meta_image'] = array(
				'name' => 'meta_image',
				'value' => '$data->meta_image',
			);
			$this->templateColumns['meta_image_alt'] = array(
				'name' => 'meta_image_alt',
				'value' => '$data->meta_image_alt',
			);
			$this->templateColumns['office_name'] = array(
				'name' => 'office_name',
				'value' => '$data->office_name',
			);
			$this->templateColumns['office_location'] = array(
				'name' => 'office_location',
				'value' => '$data->office_location',
			);
			$this->templateColumns['office_place'] = array(
				'name' => 'office_place',
				'value' => '$data->office_place',
			);
			$this->templateColumns['office_country_id'] = array(
				'name' => 'office_country_id',
				'value' => '$data->office_country_id',
			);
			$this->templateColumns['office_province_id'] = array(
				'name' => 'office_province_id',
				'value' => '$data->office_province_id',
			);
			$this->templateColumns['office_city_id'] = array(
				'name' => 'office_city_id',
				'value' => '$data->office_city_id',
			);
			$this->templateColumns['office_district'] = array(
				'name' => 'office_district',
				'value' => '$data->office_district',
			);
			$this->templateColumns['office_village'] = array(
				'name' => 'office_village',
				'value' => '$data->office_village',
			);
			$this->templateColumns['office_zipcode'] = array(
				'name' => 'office_zipcode',
				'value' => '$data->office_zipcode',
			);
			$this->templateColumns['office_hour'] = array(
				'name' => 'office_hour',
				'value' => '$data->office_hour',
			);
			$this->templateColumns['office_phone'] = array(
				'name' => 'office_phone',
				'value' => '$data->office_phone',
			);
			$this->templateColumns['office_fax'] = array(
				'name' => 'office_fax',
				'value' => '$data->office_fax',
			);
			$this->templateColumns['office_email'] = array(
				'name' => 'office_email',
				'value' => '$data->office_email',
			);
			$this->templateColumns['office_hotline'] = array(
				'name' => 'office_hotline',
				'value' => '$data->office_hotline',
			);
			$this->templateColumns['office_website'] = array(
				'name' => 'office_website',
				'value' => '$data->office_website',
			);
			$this->templateColumns['map_icons'] = array(
				'name' => 'map_icons',
				'value' => '$data->map_icons',
			);
			$this->templateColumns['map_icon_size'] = array(
				'name' => 'map_icon_size',
				'value' => '$data->map_icon_size',
			);
			$this->templateColumns['twitter_site'] = array(
				'name' => 'twitter_site',
				'value' => '$data->twitter_site',
			);
			$this->templateColumns['twitter_creator'] = array(
				'name' => 'twitter_creator',
				'value' => '$data->twitter_creator',
			);
			$this->templateColumns['twitter_photo_size'] = array(
				'name' => 'twitter_photo_size',
				'value' => '$data->twitter_photo_size',
			);
			$this->templateColumns['twitter_country'] = array(
				'name' => 'twitter_country',
				'value' => '$data->twitter_country',
			);
			$this->templateColumns['twitter_iphone'] = array(
				'name' => 'twitter_iphone',
				'value' => '$data->twitter_iphone',
			);
			$this->templateColumns['twitter_ipad'] = array(
				'name' => 'twitter_ipad',
				'value' => '$data->twitter_ipad',
			);
			$this->templateColumns['twitter_googleplay'] = array(
				'name' => 'twitter_googleplay',
				'value' => '$data->twitter_googleplay',
			);
			$this->templateColumns['facebook_profile_firstname'] = array(
				'name' => 'facebook_profile_firstname',
				'value' => '$data->facebook_profile_firstname',
			);
			$this->templateColumns['facebook_profile_lastname'] = array(
				'name' => 'facebook_profile_lastname',
				'value' => '$data->facebook_profile_lastname',
			);
			$this->templateColumns['facebook_profile_username'] = array(
				'name' => 'facebook_profile_username',
				'value' => '$data->facebook_profile_username',
			);
			$this->templateColumns['facebook_sitename'] = array(
				'name' => 'facebook_sitename',
				'value' => '$data->facebook_sitename',
			);
			$this->templateColumns['facebook_see_also'] = array(
				'name' => 'facebook_see_also',
				'value' => '$data->facebook_see_also',
			);
			$this->templateColumns['facebook_admins'] = array(
				'name' => 'facebook_admins',
				'value' => '$data->facebook_admins',
			);
			$this->templateColumns['modified_date'] = array(
				'name' => 'modified_date',
				'value' => '!in_array($data->modified_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\', \'0002-12-02 07:07:12\', \'-0001-11-30 00:00:00\')) ? Yii::app()->dateFormatter->formatDateTime($data->modified_date, \'medium\', false) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'modified_date'),
			);
			if(!Yii::app()->getRequest()->getParam('modified')) {
				$this->templateColumns['modified_search'] = array(
					'name' => 'modified_search',
					'value' => '$data->modified->displayname ? $data->modified->displayname : \'-\'',
				);
			}
			$this->templateColumns['office_on'] = array(
				'name' => 'office_on',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'office_on\', array(\'id\'=>$data->id)), $data->office_on)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['google_on'] = array(
				'name' => 'google_on',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'google_on\', array(\'id\'=>$data->id)), $data->google_on)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['twitter_on'] = array(
				'name' => 'twitter_on',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'twitter_on\', array(\'id\'=>$data->id)), $data->twitter_on)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['twitter_card'] = array(
				'name' => 'twitter_card',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'twitter_card\', array(\'id\'=>$data->id)), $data->twitter_card)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['facebook_on'] = array(
				'name' => 'facebook_on',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'facebook_on\', array(\'id\'=>$data->id)), $data->facebook_on)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['facebook_type'] = array(
				'name' => 'facebook_type',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'facebook_type\', array(\'id\'=>$data->id)), $data->facebook_type)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
		}
		parent::afterConstruct();
	}

	/**
	 * User get information
	 */
	public static function getInfo($column=null)
	{
		if($column != null) {
			$model = self::model()->findByPk(1, array(
				'select' => $column,
			));
			if(count(explode(',', $column)) == 1)
				return $model->$column;
			else
				return $model;
			
		} else {
			$model = self::model()->findByPk(1);
			return $model;
		}
	}

	/**
	 * before validate attributes
	 */
	protected function beforeValidate() 
	{
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
		if(parent::beforeValidate()) {
			//if($this->office_place == '' || $this->office_district == '' || $this->office_village == '') {
			if($this->office_place == '') {
				$this->addError('office_place', Yii::t('phrase', 'Office Address cannot be blank.'));
				//$this->addError('office_village', Yii::t('phrase', 'Office Village cannot be blank.'));
				//$this->addError('office_district', Yii::t('phrase', 'Office District cannot be blank.'));
			}
			
			$meta_image = CUploadedFile::getInstance($this, 'meta_image');	
			if($meta_image->name != '') {
				$extension = pathinfo($meta_image->name, PATHINFO_EXTENSION);
				if(!in_array($extension, array('bmp','gif','jpg','png')))
					$this->addError('meta_image', 'The file $image_name cannot be uploaded. Only files with these extensions are allowed: bmp, gif, jpg, png.', array('$image_name'=>$meta_image->name));
			}
			
			if($currentAction == 'meta/twitter') {
				if($this->twitter_card == 3) {
					if($this->twitter_photo_size['width'] == '')
						$this->addError('twitter_photo_size[width]', Yii::t('phrase', 'Photo Width cannot be blank.'));
					if($this->twitter_photo_size['height'] == '')
						$this->addError('twitter_photo_size[height]', Yii::t('phrase', 'Photo Height cannot be blank.'));
				}
			}
			
			$this->modified_id = Yii::app()->user->id;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);
		
		if(parent::beforeSave()) {
			$meta_path = "public";
			$this->meta_image = CUploadedFile::getInstance($this, 'meta_image');
			if($this->meta_image instanceOf CUploadedFile) {
				$fileName = 'meta_'.time().'.'.$this->meta_image->extensionName;
				if($this->meta_image->saveAs($meta_path.'/'.$fileName)) {
					if($this->old_meta_image != '')
						@unlink($meta_path.'/'.$this->old_meta_image);
					$this->meta_image = $fileName;

					//create thumb image
					Yii::import('ext.phpthumb.PhpThumbFactory');
					$pageImg = PhpThumbFactory::create($meta_path.'/'.$fileName, array('jpegQuality' => 90, 'correctPermissions' => true));
					$pageImg->resize(700);
					$pageImg->save($meta_path.'/'.$fileName);
				}
			}
			
			if($currentAction == 'meta/edit')
				$this->map_icon_size = serialize($this->map_icon_size);
			
			if($currentAction == 'meta/twitter') {
				$this->twitter_photo_size = serialize($this->twitter_photo_size);
				$this->twitter_iphone = serialize($this->twitter_iphone);
				$this->twitter_ipad = serialize($this->twitter_ipad);
				$this->twitter_googleplay = serialize($this->twitter_googleplay);
			}
		}
		return true;
	}
	
	/**
	 * After save attributes
	 */
	protected function afterSave() 
	{
		parent::afterSave();
		Utility::generateEmailTemplate();
	}

}