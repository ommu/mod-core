<?php
/**
 * OmmuSettings
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @modified date 20 January 2018, 06:30 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_settings".
 *
 * The followings are the available columns in table 'ommu_core_settings':
 * @property integer $id
 * @property integer $online
 * @property integer $site_oauth
 * @property integer $site_type
 * @property string $site_url
 * @property string $site_title
 * @property string $site_keywords
 * @property string $site_description
 * @property string $site_creation
 * @property string $site_dateformat
 * @property string $site_timeformat
 * @property string $construction_date
 * @property string $construction_text
 * @property string $event_startdate
 * @property string $event_finishdate
 * @property string $event_tag
 * @property integer $signup_username
 * @property integer $signup_approve
 * @property integer $signup_verifyemail
 * @property integer $signup_photo
 * @property integer $signup_welcome
 * @property integer $signup_random
 * @property integer $signup_terms
 * @property integer $signup_invitepage
 * @property integer $signup_inviteonly
 * @property integer $signup_checkemail
 * @property integer $signup_numgiven
 * @property integer $signup_adminemail
 * @property integer $general_profile
 * @property integer $general_invite
 * @property integer $general_search
 * @property integer $general_portal
 * @property string $general_include
 * @property string $general_commenthtml
 * @property integer $lang_allow
 * @property integer $lang_autodetect
 * @property integer $lang_anonymous
 * @property string $banned_ips
 * @property string $banned_emails
 * @property string $banned_usernames
 * @property string $banned_words
 * @property integer $spam_comment
 * @property integer $spam_contact
 * @property integer $spam_invite
 * @property integer $spam_login
 * @property integer $spam_failedcount
 * @property integer $spam_signup
 * @property integer $analytic
 * @property string $analytic_id
 * @property string $analytic_profile_id
 * @property string $license_email
 * @property string $license_key
 * @property string $ommu_version
 * @property string $modified_date
 * @property string $modified_id
 */

class OmmuSettings extends OActiveRecord
{
	use GridViewTrait;

	public $gridForbiddenColumn = array();
	public $event_i;

	// Variable Search
	public $modified_search;

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OmmuSettings the static model class
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
		return $matches[1].'.ommu_core_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('site_oauth, site_type, site_url, site_title, site_keywords, site_description,
				event_i', 'required', 'on'=>'general'),
			array('site_dateformat, site_timeformat', 'required', 'on'=>'locale'),
			array('general_commenthtml, spam_failedcount', 'required', 'on'=>'banned'),
			array('signup_numgiven', 'required', 'on'=>'signup'),
			array('analytic_id', 'required', 'on'=>'analytic'),
			array('online, site_oauth, site_type, signup_username, signup_approve, signup_verifyemail, signup_photo, signup_welcome, signup_random, signup_terms, signup_invitepage, signup_inviteonly, signup_checkemail, signup_numgiven, signup_adminemail, general_profile, general_invite, general_search, general_portal, lang_allow, lang_autodetect, lang_anonymous, spam_comment, spam_contact, spam_invite, spam_login, spam_failedcount, spam_signup, analytic', 'numerical', 'integerOnly'=>true),
			array('signup_numgiven', 'length', 'max'=>3),
			array('site_url, analytic_id, analytic_profile_id, license_email, license_key', 'length', 'max'=>32),
			array('site_title, site_keywords, site_description, general_commenthtml', 'length', 'max'=>256),
			array('site_dateformat, site_timeformat, ommu_version', 'length', 'max'=>8),
			array('modified_id', 'length', 'max'=>11),
			array('license_email', 'email'),
			array('site_creation, site_dateformat, site_timeformat, construction_date, construction_text, event_startdate, event_finishdate, event_tag, general_include, banned_ips, banned_emails, banned_usernames, banned_words, analytic_id, analytic_profile_id,
				event_i', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, online, site_oauth, site_type, site_url, site_title, site_keywords, site_description, site_creation, site_dateformat, site_timeformat, construction_date, construction_text, event_startdate, event_finishdate, event_tag, signup_username, signup_approve, signup_verifyemail, signup_photo, signup_welcome, signup_random, signup_terms, signup_invitepage, signup_inviteonly, signup_checkemail, signup_numgiven, signup_adminemail, general_profile, general_invite, general_search, general_portal, general_include, general_commenthtml, lang_allow, lang_autodetect, lang_anonymous, banned_ips, banned_emails, banned_usernames, banned_words, spam_comment, spam_contact, spam_invite, spam_login, spam_failedcount, spam_signup, analytic, analytic_id, analytic_profile_id, license_email, license_key, ommu_version, modified_date, modified_id, 
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
			'view' => array(self::BELONGS_TO, 'ViewSettings', 'id'),
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
			'online' => Yii::t('attribute', 'Maintenance Mode'),
			'site_oauth' => Yii::t('attribute', 'Oauth'),
			'site_type' => Yii::t('attribute', 'Site Type'),
			'site_url' => Yii::t('attribute', 'Site Url'),
			'site_title' => Yii::t('attribute', 'Site Title'),
			'site_keywords' => Yii::t('attribute', 'Site Keywords'),
			'site_description' => Yii::t('attribute', 'Site Description'),
			'site_creation' => Yii::t('attribute', 'Site Creation'),
			'site_dateformat' => Yii::t('attribute', 'Site Dateformat'),
			'site_timeformat' => Yii::t('attribute', 'Site Timeformat'),
			'construction_date' => Yii::t('attribute', 'Offline Date'),
			'construction_text' => Yii::t('attribute', 'Maintenance Text'),
			'construction_text[comingsoon]' => Yii::t('attribute', 'Coming Soon Text'),
			'construction_text[maintenance]' => Yii::t('attribute', 'Maintenance Text'),
			'event_startdate' => Yii::t('attribute', 'Event Startdate'),
			'event_finishdate' => Yii::t('attribute', 'Event Finishdate'),
			'event_tag' => Yii::t('attribute', 'Event Tag'),
			'signup_username' => Yii::t('attribute', 'Enable Profile Address?'),
			'signup_approve' => Yii::t('attribute', 'Enable Users?'),
			'signup_verifyemail' => Yii::t('attribute', 'Verify Email Address?'),
			'signup_photo' => Yii::t('attribute', 'User Photo Upload'),
			'signup_welcome' => Yii::t('attribute', 'Send Welcome Email?'),
			'signup_random' => Yii::t('attribute', 'Generate Random Passwords?'),
			'signup_terms' => Yii::t('attribute', 'Require users to agree to your terms of service?'),
			'signup_invitepage' => Yii::t('attribute', 'Show "Invite Friends" Page?'),
			'signup_inviteonly' => Yii::t('attribute', 'Invite Only?'),
			'signup_checkemail' => Yii::t('attribute', 'Signup Checkemail'),	
			'signup_numgiven' => Yii::t('attribute', 'Signup Numgiven'),
			'signup_adminemail' => Yii::t('attribute', 'Notify Admin by email when user signs up?'),
			'general_profile' => Yii::t('attribute', 'Member Profiles'),
			'general_invite' => Yii::t('attribute', 'Invite Page'),
			'general_search' => Yii::t('attribute', 'Search Page'),
			'general_portal' => Yii::t('attribute', 'Portal Page'),
			'general_include' => Yii::t('attribute', 'Head Scripts/Styles'),
			'general_commenthtml' => Yii::t('attribute', 'HTML in Comments'),
			'lang_allow' => Yii::t('attribute', 'Lang Allow'),
			'lang_autodetect' => Yii::t('attribute', 'Lang Autodetect'),
			'lang_anonymous' => Yii::t('attribute', 'Lang Anonymous'),
			'banned_ips' => Yii::t('attribute', 'Ban Users by IP Address'),
			'banned_emails' => Yii::t('attribute', 'Ban Users by Email Address'),
			'banned_usernames' => Yii::t('attribute', 'Ban Users by Username'),
			'banned_words' => Yii::t('attribute', 'Censored Words on Profiles and Plugins'),
			'spam_comment' => Yii::t('attribute', 'Require users to enter validation code when commenting?'),
			'spam_contact' => Yii::t('attribute', 'Require users to enter validation code when using the contact form?'),
			'spam_invite' => Yii::t('attribute', 'Require users to enter validation code when inviting others?'),
			'spam_login' => Yii::t('attribute', 'Require users to enter validation code when logging in?'),
			'spam_failedcount' => Yii::t('attribute', 'Spam Failedcount'),
			'spam_signup' => Yii::t('attribute', 'Require Users to Enter a Verification Code?'),
			'analytic' => Yii::t('attribute', 'Analytic'),
			'analytic_id' => Yii::t('attribute', 'Analytic'),
			'analytic_profile_id' => Yii::t('attribute', 'Profile ID'),
			'license_email' => Yii::t('attribute', 'License Email'),
			'license_key' => Yii::t('attribute', 'License Key'),
			'ommu_version' => Yii::t('attribute', 'Ommu Version'),
			'modified_date' => Yii::t('attribute', 'Modified Date'),
			'modified_id' => Yii::t('attribute', 'Modified'),
			'event_i' => Yii::t('attribute', 'Event'),
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
				'alias'=>'modified',
				'select'=>'displayname',
			),
		);

		$criteria->compare('t.id', $this->id);
		$criteria->compare('t.online', $this->online);
		$criteria->compare('t.site_oauth', $this->site_oauth);
		$criteria->compare('t.site_type', $this->site_type);
		$criteria->compare('t.site_url', $this->site_url, true);
		$criteria->compare('t.site_title', $this->site_title, true);
		$criteria->compare('t.site_keywords', $this->site_keywords, true);
		$criteria->compare('t.site_description', $this->site_description, true);
		if($this->site_creation != null && !in_array($this->site_creation, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.site_creation)', date('Y-m-d', strtotime($this->site_creation)));
		$criteria->compare('t.site_dateformat', $this->site_dateformat, true);
		$criteria->compare('t.site_timeformat', $this->site_timeformat, true);
		if($this->construction_date != null && !in_array($this->construction_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')))
			$criteria->compare('date(t.construction_date)', date('Y-m-d', strtotime($this->construction_date)));
		$criteria->compare('t.construction_text', $this->construction_text, true);
		if($this->event_startdate != null && !in_array($this->event_startdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')))
			$criteria->compare('date(t.event_startdate)', date('Y-m-d', strtotime($this->event_startdate)));
		if($this->event_finishdate != null && !in_array($this->event_finishdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')))
			$criteria->compare('date(t.event_finishdate)', date('Y-m-d', strtotime($this->event_finishdate)));
		$criteria->compare('t.event_tag', strtolower($this->event_tag), true);
		$criteria->compare('t.signup_username', $this->signup_username);
		$criteria->compare('t.signup_approve', $this->signup_approve);
		$criteria->compare('t.signup_verifyemail', $this->signup_verifyemail);
		$criteria->compare('t.signup_photo', $this->signup_photo);
		$criteria->compare('t.signup_welcome', $this->signup_welcome);
		$criteria->compare('t.signup_random', $this->signup_random);
		$criteria->compare('t.signup_terms', $this->signup_terms);
		$criteria->compare('t.signup_invitepage', $this->signup_invitepage);
		$criteria->compare('t.signup_inviteonly', $this->signup_inviteonly);
		$criteria->compare('t.signup_checkemail', $this->signup_checkemail);
		$criteria->compare('t.signup_numgiven', $this->signup_numgiven);
		$criteria->compare('t.signup_adminemail', $this->signup_adminemail);
		$criteria->compare('t.general_profile', $this->general_profile);
		$criteria->compare('t.general_invite', $this->general_invite);
		$criteria->compare('t.general_search', $this->general_search);
		$criteria->compare('t.general_portal', $this->general_portal);
		$criteria->compare('t.general_include', $this->general_include, true);
		$criteria->compare('t.general_commenthtml', $this->general_commenthtml, true);
		$criteria->compare('t.lang_allow', $this->lang_allow);
		$criteria->compare('t.lang_autodetect', $this->lang_autodetect);
		$criteria->compare('t.lang_anonymous', $this->lang_anonymous);
		$criteria->compare('t.banned_ips', $this->banned_ips, true);
		$criteria->compare('t.banned_emails', $this->banned_emails, true);
		$criteria->compare('t.banned_usernames', $this->banned_usernames, true);
		$criteria->compare('t.banned_words', $this->banned_words, true);
		$criteria->compare('t.spam_comment', $this->spam_comment);
		$criteria->compare('t.spam_contact', $this->spam_contact);
		$criteria->compare('t.spam_invite', $this->spam_invite);
		$criteria->compare('t.spam_login', $this->spam_login);
		$criteria->compare('t.spam_failedcount', $this->spam_failedcount);
		$criteria->compare('t.spam_signup', $this->spam_signup);
		$criteria->compare('t.analytic', $this->analytic);
		$criteria->compare('t.analytic_id', $this->analytic_id, true);
		$criteria->compare('t.analytic_profile_id', $this->analytic_profile_id, true);
		$criteria->compare('t.license_email', $this->license_email, true);
		$criteria->compare('t.license_key', $this->license_key, true);
		$criteria->compare('t.ommu_version', $this->ommu_version, true);
		if($this->modified_date != null && !in_array($this->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00')))
			$criteria->compare('date(t.modified_date)', date('Y-m-d', strtotime($this->modified_date)));
		$criteria->compare('t.modified_id', Yii::app()->getRequest()->getParam('modified') ? Yii::app()->getRequest()->getParam('modified') : $this->modified_id);

		$criteria->compare('modified.displayname', strtolower($this->modified_search), true);

		if(!Yii::app()->getRequest()->getParam('OmmuSettings_sort'))
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
			$this->templateColumns['site_url'] = array(
				'name' => 'site_url',
				'value' => '$data->site_url',
			);
			$this->templateColumns['site_title'] = array(
				'name' => 'site_title',
				'value' => '$data->site_title',
			);
			$this->templateColumns['site_keywords'] = array(
				'name' => 'site_keywords',
				'value' => '$data->site_keywords',
			);
			$this->templateColumns['site_description'] = array(
				'name' => 'site_description',
				'value' => '$data->site_description',
			);
			$this->templateColumns['site_creation'] = array(
				'name' => 'site_creation',
				'value' => '!in_array($data->site_creation, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\', \'0002-12-02 07:07:12\', \'-0001-11-30 00:00:00\')) ? Utility::dateFormat($data->site_creation) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'site_creation'),
			);
			$this->templateColumns['site_dateformat'] = array(
				'name' => 'site_dateformat',
				'value' => '$data->site_dateformat',
			);
			$this->templateColumns['site_timeformat'] = array(
				'name' => 'site_timeformat',
				'value' => '$data->site_timeformat',
			);
			$this->templateColumns['construction_date'] = array(
				'name' => 'construction_date',
				'value' => '!in_array($data->construction_date, array(\'0000-00-00\', \'1970-01-01\')) ? Utility::dateFormat($data->construction_date) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'construction_date'),
			);
			$this->templateColumns['construction_text'] = array(
				'name' => 'construction_text',
				'value' => '$data->construction_text',
			);
			$this->templateColumns['event_startdate'] = array(
				'name' => 'event_startdate',
				'value' => '!in_array($data->event_startdate, array(\'0000-00-00\', \'1970-01-01\')) ? Utility::dateFormat($data->event_startdate) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'event_startdate'),
			);
			$this->templateColumns['event_finishdate'] = array(
				'name' => 'event_finishdate',
				'value' => '!in_array($data->event_finishdate, array(\'0000-00-00\', \'1970-01-01\')) ? Utility::dateFormat($data->event_finishdate) : \'-\'',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterDatepicker($this, 'event_finishdate'),
			);
			$this->templateColumns['event_tag'] = array(
				'name' => 'event_tag',
				'value' => '$data->event_tag',
			);
			$this->templateColumns['signup_numgiven'] = array(
				'name' => 'signup_numgiven',
				'value' => '$data->signup_numgiven',
			);
			$this->templateColumns['general_include'] = array(
				'name' => 'general_include',
				'value' => '$data->general_include',
			);
			$this->templateColumns['general_commenthtml'] = array(
				'name' => 'general_commenthtml',
				'value' => '$data->general_commenthtml',
			);
			$this->templateColumns['banned_ips'] = array(
				'name' => 'banned_ips',
				'value' => '$data->banned_ips',
			);
			$this->templateColumns['banned_emails'] = array(
				'name' => 'banned_emails',
				'value' => '$data->banned_emails',
			);
			$this->templateColumns['banned_usernames'] = array(
				'name' => 'banned_usernames',
				'value' => '$data->banned_usernames',
			);
			$this->templateColumns['banned_words'] = array(
				'name' => 'banned_words',
				'value' => '$data->banned_words',
			);
			$this->templateColumns['spam_failedcount'] = array(
				'name' => 'spam_failedcount',
				'value' => '$data->spam_failedcount',
			);
			$this->templateColumns['analytic_id'] = array(
				'name' => 'analytic_id',
				'value' => '$data->analytic_id',
			);
			$this->templateColumns['analytic_profile_id'] = array(
				'name' => 'analytic_profile_id',
				'value' => '$data->analytic_profile_id',
			);
			$this->templateColumns['license_email'] = array(
				'name' => 'license_email',
				'value' => '$data->license_email',
			);
			$this->templateColumns['license_key'] = array(
				'name' => 'license_key',
				'value' => '$data->license_key',
			);
			$this->templateColumns['ommu_version'] = array(
				'name' => 'ommu_version',
				'value' => '$data->ommu_version',
			);
			$this->templateColumns['modified_date'] = array(
				'name' => 'modified_date',
				'value' => '!in_array($data->modified_date, array(\'0000-00-00 00:00:00\', \'1970-01-01 00:00:00\', \'0002-12-02 07:07:12\', \'-0001-11-30 00:00:00\')) ? Utility::dateFormat($data->modified_date) : \'-\'',
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
			$this->templateColumns['online'] = array(
				'name' => 'online',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'online\', array(\'id\'=>$data->id)), $data->online)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['site_oauth'] = array(
				'name' => 'site_oauth',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'site_oauth\', array(\'id\'=>$data->id)), $data->site_oauth)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['site_type'] = array(
				'name' => 'site_type',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'site_type\', array(\'id\'=>$data->id)), $data->site_type)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_username'] = array(
				'name' => 'signup_username',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_username\', array(\'id\'=>$data->id)), $data->signup_username)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_approve'] = array(
				'name' => 'signup_approve',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_approve\', array(\'id\'=>$data->id)), $data->signup_approve)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_verifyemail'] = array(
				'name' => 'signup_verifyemail',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_verifyemail\', array(\'id\'=>$data->id)), $data->signup_verifyemail)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_photo'] = array(
				'name' => 'signup_photo',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_photo\', array(\'id\'=>$data->id)), $data->signup_photo)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_welcome'] = array(
				'name' => 'signup_welcome',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_welcome\', array(\'id\'=>$data->id)), $data->signup_welcome)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_random'] = array(
				'name' => 'signup_random',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_random\', array(\'id\'=>$data->id)), $data->signup_random)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_terms'] = array(
				'name' => 'signup_terms',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_terms\', array(\'id\'=>$data->id)), $data->signup_terms)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_invitepage'] = array(
				'name' => 'signup_invitepage',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_invitepage\', array(\'id\'=>$data->id)), $data->signup_invitepage)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_inviteonly'] = array(
				'name' => 'signup_inviteonly',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_inviteonly\', array(\'id\'=>$data->id)), $data->signup_inviteonly)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_checkemail'] = array(
				'name' => 'signup_checkemail',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_checkemail\', array(\'id\'=>$data->id)), $data->signup_checkemail)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['signup_adminemail'] = array(
				'name' => 'signup_adminemail',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'signup_adminemail\', array(\'id\'=>$data->id)), $data->signup_adminemail)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['general_profile'] = array(
				'name' => 'general_profile',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'general_profile\', array(\'id\'=>$data->id)), $data->general_profile)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['general_invite'] = array(
				'name' => 'general_invite',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'general_invite\', array(\'id\'=>$data->id)), $data->general_invite)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['general_search'] = array(
				'name' => 'general_search',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'general_search\', array(\'id\'=>$data->id)), $data->general_search)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['general_portal'] = array(
				'name' => 'general_portal',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'general_portal\', array(\'id\'=>$data->id)), $data->general_portal)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['lang_allow'] = array(
				'name' => 'lang_allow',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'lang_allow\', array(\'id\'=>$data->id)), $data->lang_allow)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['lang_autodetect'] = array(
				'name' => 'lang_autodetect',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'lang_autodetect\', array(\'id\'=>$data->id)), $data->lang_autodetect)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['lang_anonymous'] = array(
				'name' => 'lang_anonymous',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'lang_anonymous\', array(\'id\'=>$data->id)), $data->lang_anonymous)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['spam_comment'] = array(
				'name' => 'spam_comment',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'spam_comment\', array(\'id\'=>$data->id)), $data->spam_comment)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['spam_contact'] = array(
				'name' => 'spam_contact',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'spam_contact\', array(\'id\'=>$data->id)), $data->spam_contact)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['spam_invite'] = array(
				'name' => 'spam_invite',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'spam_invite\', array(\'id\'=>$data->id)), $data->spam_invite)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['spam_login'] = array(
				'name' => 'spam_login',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'spam_login\', array(\'id\'=>$data->id)), $data->spam_login)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['spam_signup'] = array(
				'name' => 'spam_signup',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'spam_signup\', array(\'id\'=>$data->id)), $data->spam_signup)',
				'htmlOptions' => array(
					'class' => 'center',
				),
				'filter' => $this->filterYesNo(),
				'type' => 'raw',
			);
			$this->templateColumns['analytic'] = array(
				'name' => 'analytic',
				'value' => 'Utility::getPublish(Yii::app()->controller->createUrl(\'analytic\', array(\'id\'=>$data->id)), $data->analytic)',
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
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);

		if(parent::beforeValidate()) {
			if($currentAction == 'settings/general') {
				if($this->online != 1) {
					if($this->construction_date == '')
						$this->addError('construction_date', Yii::t('phrase', 'Maintenance date cannot be blank.'));
					if($this->online == 0 && $this->construction_text['maintenance'] == '')
						$this->addError('construction_text[maintenance]', Yii::t('phrase', 'Maintenance text cannot be blank.'));
					if($this->online == 2 && $this->construction_text['comingsoon'] == '')
						$this->addError('construction_text[comingsoon]', Yii::t('phrase', 'Coming Soon text cannot be blank.'));
				}

				if($this->event_i == 0) {
					$this->event_startdate = '00-00-0000';
					$this->event_finishdate = '00-00-0000';
					
				} else {
					$condition = 0;
					if($this->event_startdate != '' && in_array(date('Y-m-d', strtotime($this->event_startdate)), array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30'))) {
						$condition = 0;
						$this->addError('event_startdate', Yii::t('phrase', 'Event Startdate cannot be blank or default date.'));
					} else
						$condition = 1;
					if($this->event_finishdate != '' && in_array(date('Y-m-d', strtotime($this->event_finishdate)), array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30'))) {
						$condition = 0;
						$this->addError('event_finishdate', Yii::t('phrase', 'Event Finishdate cannot be blank or default date.'));
					} else
						$condition = 1;
					if($condition == 1 && (date('Y-m-d', strtotime($this->event_startdate)) >= date('Y-m-d', strtotime($this->event_finishdate))))
						$this->addError('event_finishdate', Yii::t('phrase', 'Event Finishdate tidak boleh lebih kecil'));
				}
			}
			
			$this->modified_id = !Yii::app()->user->isGuest ? Yii::app()->user->id : null;
		}
		return true;
	}
	
	/**
	 * before save attributes
	 */
	protected function beforeSave() 
	{
		$controller = strtolower(Yii::app()->controller->id);
		$action = strtolower(Yii::app()->controller->action->id);
		$currentAction = strtolower(Yii::app()->controller->id.'/'.Yii::app()->controller->action->id);

		if(parent::beforeSave()) {
			$this->construction_date = date('Y-m-d', strtotime($this->construction_date));
			if($currentAction == 'settings/general')
				$this->construction_text = serialize($this->construction_text);
			$this->event_startdate = date('Y-m-d', strtotime($this->event_startdate));
			$this->event_finishdate = date('Y-m-d', strtotime($this->event_finishdate));
		}
		return true;
	}

}