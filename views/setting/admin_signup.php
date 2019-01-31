<?php
/**
 * Core Settings (core-settings)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\SettingController
 * @var $model ommu\core\models\CoreSettings
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 01:10 WIB
 * @modified date 23 April 2018, 18:49 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php 
if($model->site_type == 1) {
$signup_username = [
	1 => Yii::t('app', 'Yes, allow members to choose a profile address.'),
	0 => Yii::t('app', 'No, do not allow profile addresses.'),
];
echo $form->field($model, 'signup_username', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', '
If you have selected YES, members will be given the option of choosing a unique profile address. If you select NO, their user id will be used in the URL instead.').'</span>{input}{error}</div>'])
	->radioList($signup_username, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_username'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']);
} ?>

<?php 
if($model->site_type == 1) {
$signup_photo = [
	1 => Yii::t('app', 'Yes, give users the option to upload a photo upon signup.'),
	0 => Yii::t('app', 'No, do not allow users to upload a photo upon signup.'),
];
echo $form->field($model, 'signup_photo', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Do you want your users to be able to upload a photo of themselves upon signup?').'</span>{input}{error}</div>'])
	->radioList($signup_photo, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_photo'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']);
} ?>

<?php 
if($model->site_type == 1) {
$signup_approve = [
	1 => Yii::t('app', 'Yes, enable users upon signup.'),
	0 => Yii::t('app', 'No, do not enable users upon signup.'),
];
echo $form->field($model, 'signup_approve', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'If you have selected YES, users will automatically be enabled when they signup. If you select NO, you will need to manually enable users through the View Users page. Users that are not enabled cannot login.').'</span>{input}{error}</div>'])
	->radioList($signup_approve, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_approve'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']);
} ?>

<?php 
if($model->site_type == 1) {
$signup_welcome = [
	1 => Yii::t('app', 'Yes, send users a welcome email.'),
	0 => Yii::t('app', 'No, do not send users a welcome email.'),
];
echo $form->field($model, 'signup_welcome', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Send users a welcome email upon signup? If you have email verification activated, this email will be sent upon verification. You can modify this email on the System Emails page.').'</span>{input}{error}</div>'])
	->radioList($signup_welcome, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_welcome'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']);
} ?>

<div class="form-group">
	<?php echo $form->field($model, 'signup_inviteonly', ['template' => '{label}', 'options' => ['tag' => null]])
		->label($model->getAttributeLabel('signup_inviteonly'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
	<div class="col-md-6 col-sm-9 col-xs-12">
		<?php 
		$signup_inviteonly = [
			2 => Yii::t('app', 'Yes, admins and users must invite new users before they can signup.'),
			1 => Yii::t('app', 'Yes, admins must invite new users before they can signup.'),
			0 => Yii::t('app', 'No, disable the invite only feature.'),
		];
		echo $form->field($model, 'signup_inviteonly', ['template' => '<span class="small-px">'.Yii::t('app', 'Do you want to turn off public signups and only allow invited users to signup? If yes, you can choose to have either admins and users invite new users, or just admins. If set to yes, an invite code will be required on the signup page.').'</span>{input}{error}'])
			->radioList($signup_inviteonly, ['class'=>'desc pt-10', 'separator' => '<br />'])
			->label($model->getAttributeLabel('signup_inviteonly'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

		<?php 
		$signup_checkemail = [
			1 => Yii::t('app', 'Yes, check that a user\'s email address was invited before accepting their invite code.'),
			0 => Yii::t('app', 'No, anyone with an invite code can signup, regardless of their email address.'),
		];
		echo $form->field($model, 'signup_checkemail', ['template' => '<span class="small-px">'.Yii::t('app', 'Should each invite code be bound to each invited email address? If set to NO, anyone with a valid invite code can signup regardless of their email address. If set to YES, anyone with a valid invite code that matches an email address that was invited can signup.').'</span>{input}{error}'])
			->radioList($signup_checkemail, ['class'=>'desc pt-10', 'separator' => '<br />'])
			->label($model->getAttributeLabel('signup_checkemail'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

		<?php echo $form->field($model, 'signup_numgiven', ['template' => '<span class="small-px mb-10">'.Yii::t('app', 'How many invites do users get when they signup? (If you want to give a particular user extra invites, you can do so via the View Users page. Please enter a number between 0 and 999 below.').'</span>{input}{error}<div>'.Yii::t('app', 'invites are given to each user when they signup.').'</div>'])
			->textInput()
			->label($model->getAttributeLabel('signup_numgiven'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
	</div>
</div>

<?php 
if($model->site_type == 1) {
$signup_invitepage = [
	1 => Yii::t('app', 'Yes, show invite friends page.'),
	0 => Yii::t('app', 'No, do not show invite friends page.'),
];
echo $form->field($model, 'signup_invitepage', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'If you have selected YES, your users will be shown a page asking them to optionally invite one or more friends to signup. The "invite friends" feature is different from the "invite only" feature because "invite friends" simply sends an email to the invitee instead of sending them an actual invitation code. Because of this, you probably do not want to enable both "invite friends" and "invite only" features simultaneously.').'</span>{input}{error}</div>'])
	->radioList($signup_invitepage, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_invitepage'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']);
} ?>

<?php 
$signup_verifyemail = [
	1 => Yii::t('app', 'Yes, verify email addresses.'),
	0 => Yii::t('app', 'No, do not verify email addresses.'),
];
echo $form->field($model, 'signup_verifyemail', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Force users to verify their email address before they can login? If set to YES, users will be sent an email with a verification link which they must click to activate their account.').'</span>{input}{error}</div>'])
	->radioList($signup_verifyemail, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_verifyemail'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>
	
<?php 
if($model->site_type == 1) {
$spam_signup = [
	1 => Yii::t('app', 'Yes, show verification code image.'),
	0 => Yii::t('app', 'No, do not show verification code image.'),
];
echo $form->field($model, 'spam_signup', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'If you have selected YES, an image containing a random sequence of 6 numbers will be shown to users on the signup page. Users will be required to enter these numbers into the Verification Code field before they can continue. This feature helps prevent users from trying to automatically create accounts on your system. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors or users cannot signup, try turning this off.').'</span>{input}{error}</div>'])
	->radioList($spam_signup, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('spam_signup'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']);
} ?>

<?php 
$signup_random = [
	1 => Yii::t('app', 'Yes, generate random passwords and email to new users.'),
	0 => Yii::t('app', 'No, let users choose their own passwords.'),
];
echo $form->field($model, 'signup_random', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'If you have selected YES, a random password will be created for users when they signup. The password will be emailed to them upon the completion of the signup process. This is another method of verifying users\' email addresses.').'</span>{input}{error}</div>'])
	->radioList($signup_random, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_random'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php 
if($model->site_type == 1) {
$signup_terms = [
	1 => Yii::t('app', 'No, users will not be shown a terms of service checkbox on signup.'),
	0 => Yii::t('app', 'Yes, make users agree to your terms of service on signup.'),
];
echo $form->field($model, 'signup_terms', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Note: If you have selected YES, users will be forced to click a during the signup process which signifies that they have read, understand, and agree to your terms of service. Enter your terms of service text in the field below. HTML is OK.').'</span>{input}{error}</div>'])
	->radioList($signup_terms, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_terms'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']);
} ?>

<?php 
$signup_adminemail = [
	1 => Yii::t('app', 'Yes, notify admin by email.'),
	0 => Yii::t('app', 'No, do not notify admin by email.'),
];
echo $form->field($model, 'signup_adminemail', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12"><span class="small-px">'.Yii::t('app', 'Send Admin and email when a new user signs up? If set to YES, admin will be recieve an email with information about new user.').'</span>{input}{error}</div>'])
	->radioList($signup_adminemail, ['class'=>'desc pt-10', 'separator' => '<br />'])
	->label($model->getAttributeLabel('signup_adminemail'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-6 col-sm-9 col-xs-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>