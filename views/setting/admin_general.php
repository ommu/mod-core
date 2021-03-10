<?php
/**
 * Core Settings (core-settings)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\SettingController
 * @var $model ommu\core\models\CoreSettings
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
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
	'options' => ['class' => 'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
	'fieldConfig' => [
		'errorOptions' => [
			'encode' => false,
		],
	],
]); ?>

<?php echo $form->errorSummary($model);?>

<?php $generalProfile = [
	1 => Yii::t('app', 'Yes, the public can view profiles unless they are made private.'),
	0 => Yii::t('app', 'No, the public cannot view profiles.'),
];
echo $form->field($model, 'general_profile', ['template' => '{label}{beginWrapper}{hint}<div class="h6 mt-4 mb-4">'.$model->getAttributeLabel('general_profile').'</div>{input}{error}{endWrapper}'])
	->radioList($generalProfile)
	->label(Yii::t('app', 'Public Permission Defaults'))
	->hint(Yii::t('app', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here.')); ?>

<?php $generalInvite = [
	1 => Yii::t('app', 'Yes, the public can use the invite page.'),
	0 => Yii::t('app', 'No, the public cannot use the invite page.'),
];
echo $form->field($model, 'general_invite', ['template' => '{beginWrapper}{hint}<div class="h6 mt-4 mb-4">'.$model->getAttributeLabel('general_invite').'</div>{input}{error}{endWrapper}', 'horizontalCssClasses' => ['wrapper' => 'col-md-6 col-sm-9 col-xs-12 col-sm-offset-3']])
	->radioList($generalInvite)
	->label($model->getAttributeLabel('general_invite')); ?>

<?php $generalSearch = [
	1 => Yii::t('app', 'Yes, the public can use the search page.'),
	0 => Yii::t('app', 'No, the public cannot use the search page.'),
];
echo $form->field($model, 'general_search', ['template' => '{beginWrapper}{hint}<div class="h6 mt-4 mb-4">'.$model->getAttributeLabel('general_search').'</div>{input}{error}{endWrapper}', 'horizontalCssClasses' => ['wrapper' => 'col-md-6 col-sm-9 col-xs-12 col-sm-offset-3']])
	->radioList($generalSearch)
	->label($model->getAttributeLabel('general_search')); ?>
		
<?php $generalPortal = [
	1 => Yii::t('app', 'Yes, the public view use the portal page.'),
	0 => Yii::t('app', 'No, the public cannot view the portal page.'),
];
echo $form->field($model, 'general_portal', ['template' => '{beginWrapper}{hint}<div class="h6 mt-4 mb-4">'.$model->getAttributeLabel('general_portal').'</div>{input}{error}{endWrapper}', 'horizontalCssClasses' => ['wrapper' => 'col-md-6 col-sm-9 col-xs-12 col-sm-offset-3']])
	->radioList($generalPortal)
	->label($model->getAttributeLabel('general_portal')); ?>
	
<?php $signupUsername = [
	1 => Yii::t('app', 'Yes, users are uniquely identified by their username.'),
	0 => Yii::t('app', 'No, usernames will not be used in this network.'),
];
echo $form->field($model, 'signup_username', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($signupUsername)
	->label($model->getAttributeLabel('signup_username'))
	->hint(Yii::t('app', 'By default, usernames are used to uniquely identify your users. If you choose to disable this feature, your users will not be given the option to enter a username. Instead, their user ID will be used. Note that if you do decide to enable this feature, you should make sure to create special REQUIRED display name profile fields - otherwise the users\' IDs will be displayed. Also note that if you disable usernames after users have already signed up, their usernames will be deleted and any previous links to their content will not work, as the links will no longer use their username! Finally, all recent activity and all notifications will be deleted if you choose to disable usernames after previously having them enabled.')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>