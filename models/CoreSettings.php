<?php
/**
 * CoreSettings
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 01:10 WIB
 * @modified date 22 April 2018, 18:36 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_settings".
 *
 * The followings are the available columns in table "ommu_core_settings":
 * @property integer $id
 * @property integer $online
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
 * @property integer $migrate
 * @property string $modified_date
 * @property integer $modified_id
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use ommu\users\models\Users;
use ommu\core\models\view\CoreSettings as CoreSettingsView;

class CoreSettings extends \app\components\ActiveRecord
{
    use \ommu\traits\UtilityTrait;
    use \ommu\traits\GridViewTrait;

    public $gridForbiddenColumn = [];
    public $event_i;

    // Search Variable
    public $modifiedDisplayname;

    const SCENARIO_GENERAL = 'general';
    const SCENARIO_BANNED = 'banned';
    const SCENARIO_SIGNUP = 'signup';
    const SCENARIO_LANGUAGE = 'language';
    const SCENARIO_ANALYTIC = 'analytic';

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
            [['online', 'site_title', 'site_keywords', 'site_description', 'signup_username', 'signup_approve', 'signup_verifyemail', 'signup_photo', 'signup_welcome', 'signup_random', 'signup_terms', 'signup_invitepage', 'signup_inviteonly', 'signup_checkemail', 'signup_numgiven', 'signup_adminemail', 'general_profile', 'general_invite', 'general_search', 'general_portal', 'general_commenthtml', 'lang_allow', 'lang_autodetect', 'lang_anonymous', 'spam_comment', 'spam_contact', 'spam_invite', 'spam_login', 'spam_failedcount', 'spam_signup', 'analytic', 'analytic_id', 'analytic_profile_id', 'license_email', 'license_key'], 'required'],
            [['online', 'signup_username', 'signup_approve', 'signup_verifyemail', 'signup_photo', 'signup_welcome', 'signup_random', 'signup_terms', 'signup_invitepage', 'signup_inviteonly', 'signup_checkemail', 'signup_numgiven', 'signup_adminemail', 'general_profile', 'general_invite', 'general_search', 'general_portal', 'lang_allow', 'lang_autodetect', 'lang_anonymous', 'spam_comment', 'spam_contact', 'spam_invite', 'spam_login', 'spam_failedcount', 'spam_signup', 'analytic', 'modified_id'], 'integer'],
            [['event_tag', 'general_include', 'banned_ips', 'banned_emails', 'banned_usernames', 'banned_words'], 'string'],
            [['site_creation', 'site_dateformat', 'site_timeformat', 
                'construction_date', 'construction_text', 'event_startdate', 'event_finishdate', 'event_tag', 'general_include', 'event_i',
                'banned_ips', 'banned_emails', 'banned_usernames', 'banned_words', 
                'analytic_id', 'analytic_profile_id', 'ommu_version', 'migrate', 'modified_date'], 'safe'],
            [['analytic_id', 'analytic_profile_id', 'license_email', 'license_key'], 'string', 'max' => 32],
            [['site_title', 'site_keywords', 'site_description', 'general_commenthtml'], 'string', 'max' => 256],
            [['site_dateformat', 'site_timeformat', 'ommu_version'], 'string', 'max' => 8],
        ];
    }

    // get scenarios
    public function scenarios()
    {
        return [
            self::SCENARIO_GENERAL => ['online', 'site_title', 'site_keywords', 'site_description', 'construction_date', 'construction_text', 'event_startdate', 'event_finishdate', 'event_tag', 'signup_username', 'general_profile', 'general_invite', 'general_search', 'general_portal', 'general_include',
                'event_i'],
            self::SCENARIO_BANNED => ['general_commenthtml', 'banned_ips', 'banned_emails', 'banned_usernames', 'banned_words', 'spam_comment', 'spam_contact', 'spam_invite', 'spam_login', 'spam_failedcount', 'spam_signup'],
            self::SCENARIO_SIGNUP => ['signup_username', 'signup_approve', 'signup_verifyemail', 'signup_photo', 'signup_welcome', 'signup_random', 'signup_terms', 'signup_invitepage', 'signup_inviteonly', 'signup_checkemail', 'signup_numgiven', 'signup_adminemail', 'spam_signup'],
            self::SCENARIO_LANGUAGE => ['lang_allow', 'lang_autodetect', 'lang_anonymous'],
            self::SCENARIO_ANALYTIC => ['analytic', 'analytic_id', 'analytic_profile_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'online' => Yii::t('app', 'Maintenance Mode'),
            'site_title' => Yii::t('app', 'Site Title'),
            'site_keywords' => Yii::t('app', 'Site Keyword'),
            'site_description' => Yii::t('app', 'Site Description'),
            'site_creation' => Yii::t('app', 'Site Creation'),
            'site_dateformat' => Yii::t('app', 'Site Dateformat'),
            'site_timeformat' => Yii::t('app', 'Site Timeformat'),
            'construction_date' => Yii::t('app', 'Offline Date'),
            'construction_text' => Yii::t('app', 'Maintenance Text'),
            'construction_text[comingsoon]' => Yii::t('app', 'Coming Soon Text'),
            'construction_text[maintenance]' => Yii::t('app', 'Maintenance Text'),
            'event_startdate' => Yii::t('app', 'Event Startdate'),
            'event_finishdate' => Yii::t('app', 'Event Finishdate'),
            'event_tag' => Yii::t('app', 'Event Tag'),
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
            'general_include' => Yii::t('app', 'Head Scripts/Styles'),
            'general_commenthtml' => Yii::t('app', 'HTML in Comments'),
            'lang_allow' => Yii::t('app', 'Lang Allow'),
            'lang_autodetect' => Yii::t('app', 'Lang Autodetect'),
            'lang_anonymous' => Yii::t('app', 'Lang Anonymous'),
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
            'analytic' => Yii::t('app', 'Analytic'),
            'analytic_id' => Yii::t('app', 'Analytic ID'),
            'analytic_profile_id' => Yii::t('app', 'Analytic Profile ID'),
            'license_email' => Yii::t('app', 'License Email'),
            'license_key' => Yii::t('app', 'License Key'),
            'ommu_version' => Yii::t('app', 'Ommu Version'),
            'migrate' => Yii::t('app', 'Migrate'),
            'modified_date' => Yii::t('app', 'Modified Date'),
            'modified_id' => Yii::t('app', 'Modified'),
            'event_i' => Yii::t('app', 'Event'),
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
    public function getView()
    {
        return $this->hasOne(CoreSettingsView::className(), ['id' => 'id']);
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
        $this->templateColumns['site_title'] = [
            'attribute' => 'site_title',
            'value' => function($model, $key, $index, $column) {
                return $model->site_title;
            },
        ];
        $this->templateColumns['site_keywords'] = [
            'attribute' => 'site_keywords',
            'value' => function($model, $key, $index, $column) {
                return $model->site_keywords;
            },
        ];
        $this->templateColumns['site_description'] = [
            'attribute' => 'site_description',
            'value' => function($model, $key, $index, $column) {
                return $model->site_description;
            },
        ];
        $this->templateColumns['site_creation'] = [
            'attribute' => 'site_creation',
            'filter' => Html::input('date', 'site_creation', Yii::$app->request->get('site_creation'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->site_creation, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->site_creation, 'datetime') : '-';
            },
            'format' => 'html',
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
        $this->templateColumns['construction_date'] = [
            'attribute' => 'construction_date',
            'filter' => Html::input('date', 'construction_date', Yii::$app->request->get('construction_date'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->construction_date, ['0000-00-00','1970-01-01','0002-12-02','-0001-11-30']) ? Yii::$app->formatter->format($model->construction_date, 'date') : '-';
            },
            'format' => 'html',
        ];
        $this->templateColumns['construction_text'] = [
            'attribute' => 'construction_text',
            'value' => function($model, $key, $index, $column) {
                return $model->construction_text;
            },
        ];
        $this->templateColumns['event_startdate'] = [
            'attribute' => 'event_startdate',
            'filter' => Html::input('date', 'event_startdate', Yii::$app->request->get('event_startdate'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->event_startdate, ['0000-00-00','1970-01-01','0002-12-02','-0001-11-30']) ? Yii::$app->formatter->format($model->event_startdate, 'date') : '-';
            },
            'format' => 'html',
        ];
        $this->templateColumns['event_finishdate'] = [
            'attribute' => 'event_finishdate',
            'filter' => Html::input('date', 'event_finishdate', Yii::$app->request->get('event_finishdate'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->event_finishdate, ['0000-00-00','1970-01-01','0002-12-02','-0001-11-30']) ? Yii::$app->formatter->format($model->event_finishdate, 'date') : '-';
            },
            'format' => 'html',
        ];
        $this->templateColumns['event_tag'] = [
            'attribute' => 'event_tag',
            'value' => function($model, $key, $index, $column) {
                return $model->event_tag;
            },
        ];
        $this->templateColumns['signup_numgiven'] = [
            'attribute' => 'signup_numgiven',
            'value' => function($model, $key, $index, $column) {
                return $model->signup_numgiven;
            },
        ];
        $this->templateColumns['general_include'] = [
            'attribute' => 'general_include',
            'value' => function($model, $key, $index, $column) {
                return $model->general_include;
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
        $this->templateColumns['analytic_id'] = [
            'attribute' => 'analytic_id',
            'value' => function($model, $key, $index, $column) {
                return $model->analytic_id;
            },
        ];
        $this->templateColumns['analytic_profile_id'] = [
            'attribute' => 'analytic_profile_id',
            'value' => function($model, $key, $index, $column) {
                return $model->analytic_profile_id;
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
            'filter' => Html::input('date', 'modified_date', Yii::$app->request->get('modified_date'), ['class'=>'form-control']),
            'value' => function($model, $key, $index, $column) {
                return !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'datetime') : '-';
            },
            'format' => 'html',
        ];
        if(!Yii::$app->request->get('modified')) {
            $this->templateColumns['modifiedDisplayname'] = [
                'attribute' => 'modifiedDisplayname',
                'value' => function($model, $key, $index, $column) {
                    return isset($model->modified) ? $model->modified->displayname : '-';
                },
            ];
        }
        $this->templateColumns['signup_username'] = [
            'attribute' => 'signup_username',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_username ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_approve'] = [
            'attribute' => 'signup_approve',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_approve ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_verifyemail'] = [
            'attribute' => 'signup_verifyemail',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_verifyemail ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_photo'] = [
            'attribute' => 'signup_photo',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_photo ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_welcome'] = [
            'attribute' => 'signup_welcome',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_welcome ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_random'] = [
            'attribute' => 'signup_random',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_random ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_terms'] = [
            'attribute' => 'signup_terms',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_terms ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_invitepage'] = [
            'attribute' => 'signup_invitepage',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_invitepage ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_inviteonly'] = [
            'attribute' => 'signup_inviteonly',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_inviteonly ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_checkemail'] = [
            'attribute' => 'signup_checkemail',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_checkemail ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['signup_adminemail'] = [
            'attribute' => 'signup_adminemail',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->signup_adminemail ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['general_profile'] = [
            'attribute' => 'general_profile',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->general_profile ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['general_invite'] = [
            'attribute' => 'general_invite',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->general_invite ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['general_search'] = [
            'attribute' => 'general_search',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->general_search ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['general_portal'] = [
            'attribute' => 'general_portal',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->general_portal ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['lang_allow'] = [
            'attribute' => 'lang_allow',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->lang_allow ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['lang_autodetect'] = [
            'attribute' => 'lang_autodetect',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->lang_autodetect ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['lang_anonymous'] = [
            'attribute' => 'lang_anonymous',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->lang_anonymous ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['spam_comment'] = [
            'attribute' => 'spam_comment',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->spam_comment ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['spam_contact'] = [
            'attribute' => 'spam_contact',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->spam_contact ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['spam_invite'] = [
            'attribute' => 'spam_invite',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->spam_invite ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['spam_login'] = [
            'attribute' => 'spam_login',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->spam_login ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['spam_signup'] = [
            'attribute' => 'spam_signup',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->spam_signup ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['analytic'] = [
            'attribute' => 'analytic',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->analytic ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['online'] = [
            'attribute' => 'online',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $model->analytic ? Yii::t('app', 'Yes') : Yii::t('app', 'No');
            },
            'contentOptions' => ['class'=>'center'],
        ];
        $this->templateColumns['migrate'] = [
            'attribute' => 'migrate',
            'filter' => $this->filterYesNo(),
            'value' => function($model, $key, $index, $column) {
                return $this->filterYesNo($model->migrate);
            },
            'contentOptions' => ['class'=>'center'],
        ];
    }

    /**
     * User get information
     */
    public static function getInfo($id, $column=null)
    {
        if($column != null) {
            $model = self::find()
                ->select([$column])
                ->where(['id' => $id])
                ->one();
            return $model->$column;
            
        } else {
            $model = self::findOne($id);
            return $model;
        }
    }

    /**
     * get Module License
     */
    public static function getLicense($source='1234567890', $length=16, $char=4)
    {
        $mod = $length%$char;
        if($mod == 0)
            $sep = ($length/$char);
        else
            $sep = (int)($length/$char)+1;
        
        $sourceLength = strlen($source);
        $random = '';
        for ($i = 0; $i < $length; $i++)
            $random .= $source[rand(0, $sourceLength - 1)];
        
        $license = '';
        for ($i = 0; $i < $sep; $i++) {
            if($i != $sep-1)
                $license .= substr($random,($i*$char),$char).'-';
            else
                $license .= substr($random,($i*$char),$char);
        }

        return $license;
    }

    /**
     * before validate attributes
     */
    public function beforeValidate() 
    {
        if(parent::beforeValidate()) {
            if($this->isNewRecord) {
                $this->license_email = 'putra@sudaryanto.id';
                $this->license_key = self::getLicense();

            } else
                $this->modified_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
            
            if($this->scenario == 'general') {
                if($this->online != 1) {
                    if($this->construction_date == '')
                        $this->addError('construction_date', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('construction_date')]));
                    if($this->online == 0 && $this->construction_text['maintenance'] == '')
                        $this->addError('construction_text[maintenance]', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('construction_text[maintenance]')]));
                    if($this->online == 2 && $this->construction_text['comingsoon'] == '')
                        $this->addError('construction_text[comingsoon]', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('construction_text[comingsoon]')]));
                }
                
                if($this->event_i == 0) {
                    $this->event_startdate = '00-00-0000';
                    $this->event_finishdate = '00-00-0000';
                    
                } else {
                    $condition = 0;
                    if($this->event_startdate != '' && in_array(Yii::$app->formatter->asDate($this->event_startdate, 'php:Y-m-d'), array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30'))) {
                        $condition = 0;
                        $this->addError('event_startdate', Yii::t('app', '{attribute} cannot be blank or default date.', ['attribute'=>$this->getAttributeLabel('event_startdate')]));
                    } else
                        $condition = 1;
                    if($this->event_finishdate != '' && in_array(Yii::$app->formatter->asDate($this->event_finishdate, 'php:Y-m-d'), array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30'))) {
                        $condition = 0;
                        $this->addError('event_finishdate', Yii::t('app', '{attribute} cannot be blank or default date.', ['attribute'=>$this->getAttributeLabel('event_finishdate')]));
                    } else
                        $condition = 1;
                        
                    if($condition == 1 && (Yii::$app->formatter->asDate($this->event_startdate, 'php:Y-m-d') >= Yii::$app->formatter->asDate($this->event_finishdate, 'php:Y-m-d')))
                        $this->addError('event_finishdate', Yii::t('app', '{attribute} tidak boleh lebih kecil', ['attribute'=>$this->getAttributeLabel('event_finishdate')]));
                        
                    if(trim($this->event_tag) == '')
                        $this->addError('event_tag', Yii::t('app', '{attribute} cannot be blank.', ['attribute'=>$this->getAttributeLabel('event_tag')]));
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
            $this->construction_date = Yii::$app->formatter->asDate($this->construction_date, 'php:Y-m-d');
            if($this->scenario == 'general')
                $this->construction_text = serialize($this->construction_text);
            $this->event_startdate = Yii::$app->formatter->asDate($this->event_startdate, 'php:Y-m-d');
            $this->event_finishdate = Yii::$app->formatter->asDate($this->event_finishdate, 'php:Y-m-d');
        }
        return true;
    }
}
