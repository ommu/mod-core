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

<?php $langAllow = [
	1 => Yii::t('app', 'Yes, allow registered users to choose their own language.'),
	0 => Yii::t('app', 'No, do not allow registered users to save their language preference.'),
];
echo $form->field($model, 'lang_allow', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($langAllow)
	->label($model->getAttributeLabel('lang_allow'))
	->hint(Yii::t('app', 'If you have more than one language pack, do you want to allow your registered users to select which one will be used while they are logged in? If you select "Yes", users will be able to choose their language on the signup page and the account settings page. Note that this will only apply if you have more than one language pack.')); ?>

<?php $langAnonymous = [
	1 => Yii::t('app', 'Yes, display a select box that will allow unregistered users to change their language.'),
	0 => Yii::t('app', 'No, do not allow unregistered users to change the site language.'),
];
echo $form->field($model, 'lang_anonymous', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($langAnonymous)
	->label($model->getAttributeLabel('lang_anonymous'))
	->hint(Yii::t('app', 'If you have more than one language pack, do you want the system to autodetect the language settings from your visitors\' browsers? If you select "Yes", the system will attempt to detect what language the user has set in their browser settings. If you have a matching language, your site will display in that language, otherwise it will display in the default language.')); ?>

<?php $langAutodetect = [
	1 => Yii::t('app', 'Yes, attempt to detect the visitor\'s language based on their browser settings.'),
	0 => Yii::t('app', 'No, do not autodetect the visitor\'s language.'),
];
echo $form->field($model, 'lang_autodetect', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($langAutodetect)
	->label($model->getAttributeLabel('lang_autodetect'))
	->hint(Yii::t('app', 'If you have more than one language pack, do you want to display a select box on your homepage so that unregistered users can change the language in which they view the social network? Note that this will only apply if you have more than one language pack.')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>

</div>