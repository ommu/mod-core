<?php
/**
 * Core Settings (core-settings)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\SettingController
 * @var $model ommu\core\models\CoreSettings
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 01:10 WIB
 * @modified date 23 April 2018, 18:49 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting/update']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="core-settings-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php if(Yii::$app->isSocialMedia()) {
	$signupUsername = [
		1 => Yii::t('app', 'Yes, allow members to choose a profile address.'),
		0 => Yii::t('app', 'No, do not allow profile addresses.'),
	];
	echo $form->field($model, 'signup_username', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($signupUsername)
		->label($model->getAttributeLabel('signup_username'))
		->hint(Yii::t('app', '
		If you have selected YES, members will be given the option of choosing a unique profile address. If you select NO, their user id will be used in the URL instead.'));

	$signupPhoto = [
		1 => Yii::t('app', 'Yes, give users the option to upload a photo upon signup.'),
		0 => Yii::t('app', 'No, do not allow users to upload a photo upon signup.'),
	];
	echo $form->field($model, 'signup_photo', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($signupPhoto)
		->label($model->getAttributeLabel('signup_photo'))
		->hint(Yii::t('app', 'Do you want your users to be able to upload a photo of themselves upon signup?'));

	$signupApprove = [
		1 => Yii::t('app', 'Yes, enable users upon signup.'),
		0 => Yii::t('app', 'No, do not enable users upon signup.'),
	];
	echo $form->field($model, 'signup_approve', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($signupApprove)
		->label($model->getAttributeLabel('signup_approve'))
		->hint(Yii::t('app', 'If you have selected YES, users will automatically be enabled when they signup. If you select NO, you will need to manually enable users through the View Users page. Users that are not enabled cannot login.'));

	$signupWelcome = [
		1 => Yii::t('app', 'Yes, send users a welcome email.'),
		0 => Yii::t('app', 'No, do not send users a welcome email.'),
	];
	echo $form->field($model, 'signup_welcome', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($signupWelcome)
		->label($model->getAttributeLabel('signup_welcome'))
		->hint(Yii::t('app', 'Send users a welcome email upon signup? If you have email verification activated, this email will be sent upon verification. You can modify this email on the System Emails page.'));
} ?>

<?php $signupInviteonly = [
	2 => Yii::t('app', 'Yes, admins and users must invite new users before they can signup.'),
	1 => Yii::t('app', 'Yes, admins must invite new users before they can signup.'),
	0 => Yii::t('app', 'No, disable the invite only feature.'),
];
echo $form->field($model, 'signup_inviteonly', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($signupInviteonly)
	->label($model->getAttributeLabel('signup_inviteonly'))
	->hint(Yii::t('app', 'Do you want to turn off public signups and only allow invited users to signup? If yes, you can choose to have either admins and users invite new users, or just admins. If set to yes, an invite code will be required on the signup page.')); ?>

<?php $signupCheckemail = [
	1 => Yii::t('app', 'Yes, check that a user\'s email address was invited before accepting their invite code.'),
	0 => Yii::t('app', 'No, anyone with an invite code can signup, regardless of their email address.'),
];
echo $form->field($model, 'signup_checkemail', ['template' => '{beginWrapper}{hint}{input}{error}{endWrapper}', 'horizontalCssClasses' => ['wrapper'=>'col-md-6 col-sm-9 col-xs-12 col-sm-offset-3']])
	->radioList($signupCheckemail)
	->label($model->getAttributeLabel('signup_checkemail'))
	->hint(Yii::t('app', 'Should each invite code be bound to each invited email address? If set to NO, anyone with a valid invite code can signup regardless of their email address. If set to YES, anyone with a valid invite code that matches an email address that was invited can signup.')); ?>

<?php echo $form->field($model, 'signup_numgiven', ['template' => '{beginWrapper}{hint}{input}{error}<div>'.Yii::t('app', 'invites are given to each user when they signup.').'</div>{endWrapper}', 'horizontalCssClasses' => ['wrapper'=>'col-md-6 col-sm-9 col-xs-12 col-sm-offset-3']])
	->textInput()
	->label($model->getAttributeLabel('signup_numgiven'))
	->hint(Yii::t('app', 'How many invites do users get when they signup? (If you want to give a particular user extra invites, you can do so via the View Users page. Please enter a number between 0 and 999 below.')); ?>

<?php if(Yii::$app->isSocialMedia()) {
	$signupInvitepage = [
		1 => Yii::t('app', 'Yes, show invite friends page.'),
		0 => Yii::t('app', 'No, do not show invite friends page.'),
	];
	echo $form->field($model, 'signup_invitepage', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($signupInvitepage)
		->label($model->getAttributeLabel('signup_invitepage'))
		->hint(Yii::t('app', 'If you have selected YES, your users will be shown a page asking them to optionally invite one or more friends to signup. The "invite friends" feature is different from the "invite only" feature because "invite friends" simply sends an email to the invitee instead of sending them an actual invitation code. Because of this, you probably do not want to enable both "invite friends" and "invite only" features simultaneously.'));
} ?>

<?php $signupVerifyemail = [
	1 => Yii::t('app', 'Yes, verify email addresses.'),
	0 => Yii::t('app', 'No, do not verify email addresses.'),
];
echo $form->field($model, 'signup_verifyemail', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($signupVerifyemail)
	->label($model->getAttributeLabel('signup_verifyemail'))
	->hint(Yii::t('app', 'Force users to verify their email address before they can login? If set to YES, users will be sent an email with a verification link which they must click to activate their account.')); ?>
	
<?php if(Yii::$app->isSocialMedia()) {
	$spamSignup = [
		1 => Yii::t('app', 'Yes, show verification code image.'),
		0 => Yii::t('app', 'No, do not show verification code image.'),
	];
	echo $form->field($model, 'spam_signup', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($spamSignup)
		->label($model->getAttributeLabel('spam_signup'))
		->hint(Yii::t('app', 'If you have selected YES, an image containing a random sequence of 6 numbers will be shown to users on the signup page. Users will be required to enter these numbers into the Verification Code field before they can continue. This feature helps prevent users from trying to automatically create accounts on your system. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors or users cannot signup, try turning this off.'));
} ?>

<?php $signupRandom = [
	1 => Yii::t('app', 'Yes, generate random passwords and email to new users.'),
	0 => Yii::t('app', 'No, let users choose their own passwords.'),
];
echo $form->field($model, 'signup_random', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($signupRandom)
	->label($model->getAttributeLabel('signup_random'))
	->hint(Yii::t('app', 'If you have selected YES, a random password will be created for users when they signup. The password will be emailed to them upon the completion of the signup process. This is another method of verifying users\' email addresses.')); ?>

<?php if(Yii::$app->isSocialMedia()) {
	$signupTerms = [
		1 => Yii::t('app', 'No, users will not be shown a terms of service checkbox on signup.'),
		0 => Yii::t('app', 'Yes, make users agree to your terms of service on signup.'),
	];
	echo $form->field($model, 'signup_terms', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
		->radioList($signupTerms)
		->label($model->getAttributeLabel('signup_terms'))
		->hint(Yii::t('app', 'Note: If you have selected YES, users will be forced to click a during the signup process which signifies that they have read, understand, and agree to your terms of service. Enter your terms of service text in the field below. HTML is OK.'));
} ?>

<?php $signupAdminemail = [
	1 => Yii::t('app', 'Yes, notify admin by email.'),
	0 => Yii::t('app', 'No, do not notify admin by email.'),
];
echo $form->field($model, 'signup_adminemail', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($signupAdminemail)
	->label($model->getAttributeLabel('signup_adminemail'))
	->hint(Yii::t('app', 'Send Admin and email when a new user signs up? If set to YES, admin will be recieve an email with information about new user.')); ?>

<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>