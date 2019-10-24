<?php
/**
 * CoreSettings
 * 
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 01:10 WIB
 * @modified date 25 March 2019, 09:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_settings".
 *
 * The followings are the available columns in table "ommu_core_settings":
 * @property integer $id
 * @property string $site_creation
 * @property string $site_dateformat
 * @property string $site_timeformat
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
 * @property string $license_email
 * @property string $license_key
 * @property string $ommu_version
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
use ommu\users\models\Users;

class CoreSettings extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = [];

	public $modifiedDisplayname;

	const SCENARIO_GENERAL = 'general';
	const SCENARIO_BANNED = 'banned';
	const SCENARIO_SIGNUP = 'signup';
	const SCENARIO_LANGUAGE = 'language';

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_core_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['signup_username', 'general_profile', 'general_invite', 'general_search', 'general_portal'], 'required', 'on' => self::SCENARIO_GENERAL],
			[['general_commenthtml', 'spam_comment', 'spam_contact', 'spam_invite', 'spam_login', 'spam_failedcount', 'spam_signup'], 'required', 'on' => self::SCENARIO_BANNED],
			[['signup_username', 'signup_approve', 'signup_verifyemail', 'signup_photo', 'signup_welcome', 'signup_random', 'signup_terms', 'signup_invitepage', 'signup_inviteonly', 'signup_checkemail', 'signup_numgiven', 'signup_adminemail', 'spam_signup'], 'required', 'on' => self::SCENARIO_SIGNUP],
			[['lang_allow', 'lang_autodetect', 'lang_anonymous'], 'required', 'on' => self::SCENARIO_LANGUAGE],
			[['signup_username', 'signup_approve', 'signup_verifyemail', 'signup_photo', 'signup_welcome', 'signup_random', 'signup_terms', 'signup_invitepage', 'signup_inviteonly', 'signup_checkemail', 'signup_numgiven', 'signup_adminemail', 'general_profile', 'general_invite', 'general_search', 'general_portal', 'lang_allow', 'lang_autodetect', 'lang_anonymous', 'spam_comment', 'spam_contact', 'spam_invite', 'spam_login', 'spam_failedcount', 'spam_signup', 'modified_id'], 'integer'],
			[['banned_ips', 'banned_emails', 'banned_usernames', 'banned_words'], 'string'],
			[['site_creation', 'site_dateformat', 'site_timeformat', 
				'banned_ips', 'banned_emails', 'banned_usernames', 'banned_words', 
				'ommu_version'], 'safe'],
			[['license_key'], 'string', 'max' => 32],
			[['license_email'], 'string', 'max' => 64],
			[['general_commenthtml'], 'string', 'max' => 256],
			[['site_dateformat', 'site_timeformat', 'ommu_version'], 'string', 'max' => 8],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_GENERAL] = ['signup_username', 'general_profile', 'general_invite', 'general_search', 'general_portal'];
		$scenarios[self::SCENARIO_BANNED] = ['general_commenthtml', 'banned_ips', 'banned_emails', 'banned_usernames', 'banned_words', 'spam_comment', 'spam_contact', 'spam_invite', 'spam_login', 'spam_failedcount', 'spam_signup'];
		$scenarios[self::SCENARIO_SIGNUP] = ['signup_username', 'signup_approve', 'signup_verifyemail', 'signup_photo', 'signup_welcome', 'signup_random', 'signup_terms', 'signup_invitepage', 'signup_inviteonly', 'signup_checkemail', 'signup_numgiven', 'signup_adminemail', 'spam_signup'];
		$scenarios[self::SCENARIO_LANGUAGE] = ['lang_allow', 'lang_autodetect', 'lang_anonymous'];
		return $scenarios;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('app', 'ID'),
			'site_creation' => Yii::t('app', 'Site Creation'),
			'site_dateformat' => Yii::t('app', 'Site Dateformat'),
			'site_timeformat' => Yii::t('app', 'Site Timeformat'),
			'signup_username' => Yii::t('app', 'Enable Profile Address?'),
			'signup_approve' => Yii::t('app', 'Enable Users?'),
			'signup_verifyemail' => Yii::t('app', 'Verify Email Address?'),
			'signup_photo' => Yii::t('app', 'User Photo Upload'),
			'signup_welcome' => Yii::t('app', 'Send Welcome Email?'),
			'signup_random' => Yii::t('app', 'Generate Random Passwords?'),
			'signup_terms' => Yii::t('app', 'Require users to agree to your terms of service?'),
			'signup_invitepage' => Yii::t('app', 'Show "Invite Friends" Page?'),
			'signup_inviteonly' => Yii::t('app', 'Invite Only?'),
			'signup_checkemail' => Yii::t('app', 'Signup Checkemail'),
			'signup_numgiven' => Yii::t('app', 'Signup Numgiven'),
			'signup_adminemail' => Yii::t('app', 'Notify Admin by email when user signs up?'),
			'general_profile' => Yii::t('app', 'Member Profiles'),
			'general_invite' => Yii::t('app', 'Invite Page'),
			'general_search' => Yii::t('app', 'Search Page'),
			'general_portal' => Yii::t('app', 'Portal Page'),
			'general_commenthtml' => Yii::t('app', 'HTML in Comments'),
			'lang_allow' => Yii::t('app', 'Language Allow'),
			'lang_autodetect' => Yii::t('app', 'Language Autodetect'),
			'lang_anonymous' => Yii::t('app', 'Language Anonymous'),
			'banned_ips' => Yii::t('app', 'Ban Users by IP Address'),
			'banned_emails' => Yii::t('app', 'Ban Users by Email Address'),
			'banned_usernames' => Yii::t('app', 'Ban Users by Username'),
			'banned_words' => Yii::t('app', 'Censored Words on Profiles and Plugins'),
			'spam_comment' => Yii::t('app', 'Require users to enter validation code when commenting?'),
			'spam_contact' => Yii::t('app', 'Require users to enter validation code when using the contact form?'),
			'spam_invite' => Yii::t('app', 'Require users to enter validation code when inviting others?'),
			'spam_login' => Yii::t('app', 'Require users to enter validation code when logging in?'),
			'spam_failedcount' => Yii::t('app', 'Spam Failedcount'),
			'spam_signup' => Yii::t('app', 'Require Users to Enter a Verification Code?'),
			'license_email' => Yii::t('app', 'License Email'),
			'license_key' => Yii::t('app', 'License Key'),
			'ommu_version' => Yii::t('app', 'Ommu Version'),
			'modified_date' => Yii::t('app', 'Modified Date'),
			'modified_id' => Yii::t('app', 'Modified'),
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
	 * {@inheritdoc}
	 * @return \ommu\core\models\query\CoreSettings the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\CoreSettings(get_called_class());
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
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['site_creation'] = [
			'attribute' => 'site_creation',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->site_creation, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'site_creation'),
		];
		$this->templateColumns['site_dateformat'] = [
			'attribute' => 'site_dateformat',
			'value' => function($model, $key, $index, $column) {
				return $model->site_dateformat;
			},
		];
		$this->templateColumns['site_timeformat'] = [
			'attribute' => 'site_timeformat',
			'value' => function($model, $key, $index, $column) {
				return $model->site_timeformat;
			},
		];
		$this->templateColumns['signup_numgiven'] = [
			'attribute' => 'signup_numgiven',
			'value' => function($model, $key, $index, $column) {
				return $model->signup_numgiven;
			},
		];
		$this->templateColumns['general_commenthtml'] = [
			'attribute' => 'general_commenthtml',
			'value' => function($model, $key, $index, $column) {
				return $model->general_commenthtml;
			},
		];
		$this->templateColumns['banned_ips'] = [
			'attribute' => 'banned_ips',
			'value' => function($model, $key, $index, $column) {
				return $model->banned_ips;
			},
		];
		$this->templateColumns['banned_emails'] = [
			'attribute' => 'banned_emails',
			'value' => function($model, $key, $index, $column) {
				return $model->banned_emails;
			},
		];
		$this->templateColumns['banned_usernames'] = [
			'attribute' => 'banned_usernames',
			'value' => function($model, $key, $index, $column) {
				return $model->banned_usernames;
			},
		];
		$this->templateColumns['banned_words'] = [
			'attribute' => 'banned_words',
			'value' => function($model, $key, $index, $column) {
				return $model->banned_words;
			},
		];
		$this->templateColumns['spam_failedcount'] = [
			'attribute' => 'spam_failedcount',
			'value' => function($model, $key, $index, $column) {
				return $model->spam_failedcount;
			},
		];
		$this->templateColumns['license_email'] = [
			'attribute' => 'license_email',
			'value' => function($model, $key, $index, $column) {
				return $model->license_email;
			},
		];
		$this->templateColumns['license_key'] = [
			'attribute' => 'license_key',
			'value' => function($model, $key, $index, $column) {
				return $model->license_key;
			},
		];
		$this->templateColumns['ommu_version'] = [
			'attribute' => 'ommu_version',
			'value' => function($model, $key, $index, $column) {
				return $model->ommu_version;
			},
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
		$this->templateColumns['signup_username'] = [
			'attribute' => 'signup_username',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_username);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_approve'] = [
			'attribute' => 'signup_approve',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_approve);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_verifyemail'] = [
			'attribute' => 'signup_verifyemail',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_verifyemail);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_photo'] = [
			'attribute' => 'signup_photo',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_photo);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_welcome'] = [
			'attribute' => 'signup_welcome',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_welcome);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_random'] = [
			'attribute' => 'signup_random',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_random);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_terms'] = [
			'attribute' => 'signup_terms',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_terms);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_invitepage'] = [
			'attribute' => 'signup_invitepage',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_invitepage);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_inviteonly'] = [
			'attribute' => 'signup_inviteonly',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_inviteonly);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_checkemail'] = [
			'attribute' => 'signup_checkemail',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_checkemail);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['signup_adminemail'] = [
			'attribute' => 'signup_adminemail',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->signup_adminemail);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['general_profile'] = [
			'attribute' => 'general_profile',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->general_profile);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['general_invite'] = [
			'attribute' => 'general_invite',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->general_invite);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['general_search'] = [
			'attribute' => 'general_search',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->general_search);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['general_portal'] = [
			'attribute' => 'general_portal',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->general_portal);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['lang_allow'] = [
			'attribute' => 'lang_allow',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->lang_allow);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['lang_autodetect'] = [
			'attribute' => 'lang_autodetect',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->lang_autodetect);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['lang_anonymous'] = [
			'attribute' => 'lang_anonymous',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->lang_anonymous);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['spam_comment'] = [
			'attribute' => 'spam_comment',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->spam_comment);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['spam_contact'] = [
			'attribute' => 'spam_contact',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->spam_contact);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['spam_invite'] = [
			'attribute' => 'spam_invite',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->spam_invite);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['spam_login'] = [
			'attribute' => 'spam_login',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->spam_login);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
		];
		$this->templateColumns['spam_signup'] = [
			'attribute' => 'spam_signup',
			'value' => function($model, $key, $index, $column) {
				return $this->filterYesNo($model->spam_signup);
			},
			'filter' => $this->filterYesNo(),
			'contentOptions' => ['class'=>'center'],
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
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->modifiedDisplayname = isset($this->modified) ? $this->modified->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				$this->license_email = 'putra@ommu.co';
				$this->license_key = $this->licenseCode();

			} else {
				if($this->modified_id == null)
					$this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
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
			// $this->site_creation = Yii::$app->formatter->asDate($this->site_creation, 'php:Y-m-d');
		}
		return true;
	}
}
