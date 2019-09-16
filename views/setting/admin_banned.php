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

<?php echo $form->field($model, 'banned_ips', ['template' => '{beginLabel}{labelTitle}{hint}{endLabel}{beginWrapper}{input}{error}{endWrapper}'])
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('banned_ips'))
	->hint(Yii::t('app', 'To ban users by their IP address, enter their address into the field below. Addresses should be separated by commas, like 123.456.789.123, 23.45.67.89')); ?>

<?php echo $form->field($model, 'banned_emails', ['template' => '{beginLabel}{labelTitle}{hint}{endLabel}{beginWrapper}{input}{error}{endWrapper}'])
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('banned_emails'))
	->hint(Yii::t('app', 'To ban users by their email address, enter their email into the field below. Emails should be separated by commas, like user1@domain1.com, user2@domain2.com. Note that you can ban all email addresses with a specific domain as follows: *@domain.com')); ?>

<?php echo $form->field($model, 'banned_usernames', ['template' => '{beginLabel}{labelTitle}{hint}{endLabel}{beginWrapper}{input}{error}{endWrapper}'])
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('banned_usernames'))
	->hint(Yii::t('app', 'Enter the usernames that are not permitted on your social network. Usernames should be separated by commas, like username1, username2')); ?>

<?php echo $form->field($model, 'banned_words', ['template' => '{beginLabel}{labelTitle}{hint}{endLabel}{beginWrapper}{input}{error}{endWrapper}'])
	->textarea(['rows'=>6, 'cols'=>50])
	->label($model->getAttributeLabel('banned_words'))
	->hint(Yii::t('app', 'Enter any words that you you want to censor on your users\' profiles as well as any plugins you have installed. These will be replaced with asterisks (*). Separate words by commas like word1, word2')); ?>
	
<?php $spamSignup = [
	1 => Yii::t('app', 'Yes, show verification code image.'),
	0 => Yii::t('app', 'No, do not show verification code image.'),
];
echo $form->field($model, 'spam_signup', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($spamSignup)
	->label($model->getAttributeLabel('spam_signup'))
	->hint(Yii::t('app', 'If you have selected YES, an image containing a random sequence of 6 numbers will be shown to users on the signup page. Users will be required to enter these numbers into the Verification Code field before they can continue. This feature helps prevent users from trying to automatically create accounts on your system. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors or users cannot signup, try turning this off.')); ?>

<?php $spamInvite = [
	1 => Yii::t('app', 'Yes, enable validation code for inviting.'),
	0 => Yii::t('app', 'No, disable validation code for inviting.'),
];
echo $form->field($model, 'spam_invite', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($spamInvite)
	->label($model->getAttributeLabel('spam_invite'))
	->hint(Yii::t('app', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "invite" page. Users will be required to enter these numbers into the Verification Code field in order to send their invitation. This feature helps prevent users from trying to create comment spam. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.')); ?>

<?php $spamLogin = [
	1 => Yii::t('app', 'Yes, enable validation code for logging in.'),
	0 => Yii::t('app', 'No, disable validation code for logging in.'),
];
echo $form->field($model, 'spam_login', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($spamLogin)
	->label(Yii::t('app', 'Require users to enter validation code when logging in?'))
	->hint(Yii::t('app', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "login" page. Users will be required to enter these numbers into the Verification Code field in order to login. This feature helps prevent users from trying to spam the login form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.')); ?>

<?php echo $form->field($model, 'spam_failedcount', ['template' => '{beginWrapper}{hint}{input}{error}{endWrapper}', 'horizontalCssClasses' => ['wrapper'=>'col-md-6 col-sm-9 col-xs-12 col-sm-offset-3']])
	->textInput()
	->label($model->getAttributeLabel('spam_failedcount'))
	->hint(Yii::t('app', 'If "no" is selected in the setting directly above, a Verification Code will be displayed to the user only after a certain number of failed logins. You can set this to 0 to never display a code.')); ?>
	
<?php $spamContact = [
	1 => Yii::t('app', 'Yes, enable validation code for the contact form.'),
	0 => Yii::t('app', 'No, disable validation code for the contact form.'),
];
echo $form->field($model, 'spam_contact', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($spamContact)
	->label($model->getAttributeLabel('spam_contact'))
	->hint(Yii::t('app', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "contact" page. Users will be required to enter these numbers into the Verification Code field in order to contact you. This feature helps prevent users from trying to spam the contact form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.')); ?>

<?php $spamComment = [
	1 => Yii::t('app', 'Yes, enable validation code for the contact form.'),
	0 => Yii::t('app', 'No, disable validation code for the contact form.'),
];
echo $form->field($model, 'spam_comment', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($spamComment)
	->label($model->getAttributeLabel('spam_comment'))
	->hint(Yii::t('app', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "write a comment" page. Users will be required to enter these numbers into the Verification Code field in order to post their comment. This feature helps prevent users from trying to create comment spam. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.')); ?>

<?php echo $form->field($model, 'general_commenthtml')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('general_commenthtml'))
	->hint(Yii::t('app', 'By default, the user may not enter any HTML tags into comments. If you want to allow specific tags, you can enter them below (separated by commas). Example: b, img, a, embed, font')); ?>
	
<div class="ln_solid"></div>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>
