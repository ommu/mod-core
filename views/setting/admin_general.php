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

$js = <<<JS
	$('.field-online input[name="online"]').on('change', function() {
		var id = $(this).val();
		if(id == '1') {
			$('div#construction').slideUp();
		} else {
			$('div#construction').slideDown();
			if(id == '0') {
				$('div#comingsoon').slideUp();
				$('div#maintenance').slideDown();
			} else {
				$('div#maintenance').slideUp();
				$('div#comingsoon').slideDown();
			}
		}
	});
	$('.field-event_i input[name="event_i"]').on('change', function() {
		var id = $(this).val();
		if(id == '0') {
			$('div#events').slideUp();
		} else {
			$('div#events').slideDown();
		}
	});
JS;
	$this->registerJs($js, \app\components\View::POS_READY);
?>

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php echo $form->errorSummary($model);?>

<?php 
$online = [
	1 => Yii::t('app', 'Online'),
	2 => Yii::t('app', 'Offline (Coming Soon)'),
	0 => Yii::t('app', 'Offline (Maintenance Mode)'),
];
echo $form->field($model, 'online', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($online)
	->label($model->getAttributeLabel('online'))
	->hint(Yii::t('app', 'Maintenance Mode will prevent site visitors from accessing your website. You can customize the maintenance mode page by manually editing the file "/application/maintenance.html".')); ?>

<div id="construction" <?php echo $model->online == '1' ? 'style="display: none;"' : ''; ?>>
	<?php 
	$model->construction_date = !$model->isNewRecord ? (!in_array($model->construction_date, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? $model->construction_date : '') : '';
	echo $form->field($model, 'construction_date')
		->textInput(['type' => 'date'])
		->label($model->getAttributeLabel('construction_date')); ?>

	<div id="comingsoon" class="form-group field-construction_text-comingsoon" <?php echo $model->online != '2' ? 'style="display: none;"' : ''; ?>>
		<?php echo $form->field($model, 'construction_text[comingsoon]', ['template' => '{label}', 'options' => ['tag' => null]])
			->label($model->getAttributeLabel('construction_text[comingsoon]'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12 col-12']); ?>
		<div class="col-md-6 col-sm-9 col-xs-12 col-12">
			<?php 
			if(!$model->isNewRecord && !$model->getErrors())
				$model->construction_text = unserialize($model->construction_text);
			echo $form->field($model, 'construction_text[comingsoon]', ['template' => '{input}{error}'])
				->textarea(['rows'=>2,'rows'=>6])
				->label($model->getAttributeLabel('construction_text[comingsoon]')); ?>
		</div>
	</div>

	<div id="maintenance" class="form-group field-construction_text-maintenance" <?php echo $model->online != '0' ? 'style="display: none;"' : ''; ?>>
		<?php echo $form->field($model, 'construction_text[maintenance]', ['template' => '{label}', 'options' => ['tag' => null]])
			->label($model->getAttributeLabel('construction_text[maintenance]'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12 col-12']); ?>
		<div class="col-md-6 col-sm-9 col-xs-12 col-12">
			<?php echo $form->field($model, 'construction_text[maintenance]', ['template' => '{input}{error}'])
				->textarea(['rows'=>2,'rows'=>6])
				->label($model->getAttributeLabel('construction_text[maintenance]')); ?>
		</div>
	</div>
</div>

<?php 
if(!$model->getErrors()) {
	$model->event_i = 0;
	if($model->isNewRecord || (!$model->isNewRecord && !in_array($model->event_startdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) && !in_array($model->event_finishdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30'))))
		$model->event_i = 1;
}
$event_i = [
	1 => Yii::t('app', 'Enable'),
	0 => Yii::t('app', 'Disable'),
];
echo $form->field($model, 'event_i')
	->radioList($event_i)
	->label($model->getAttributeLabel('event_i')); ?>

<div id="events" <?php echo $model->event_i == '0' ? 'style="display: none;"' : ''; ?>>
	<?php 
	$model->event_startdate = !$model->isNewRecord ? (!in_array($model->event_startdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? $model->event_startdate : '') : '';
	echo $form->field($model, 'event_startdate')
		->textInput(['type' => 'date'])
		->label($model->getAttributeLabel('event_startdate')); ?>

	<?php 
	$model->event_finishdate = !$model->isNewRecord ? (!in_array($model->event_finishdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? $model->event_finishdate : '') : '';
	echo $form->field($model, 'event_finishdate')
	->textInput(['type' => 'date'])
		->label($model->getAttributeLabel('event_finishdate')); ?>

	<?php echo $form->field($model, 'event_tag')
		->textarea(['rows'=>2,'rows'=>6])
		->label($model->getAttributeLabel('event_tag'))
		->hint(Yii::t('app', 'tambahkan tanda koma (,) jika ingin menambahkan event tag lebih dari satu.')); ?>
</div>

<?php echo $form->field($model, 'site_title')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('site_title'))
	->hint(Yii::t('app', 'Give your community a unique name. This will appear in the &lt;title&gt; tag throughout most of your site.')); ?>

<?php echo $form->field($model, 'site_description')
	->textarea(['rows'=>2,'rows'=>6,'maxlength' => true])
	->label($model->getAttributeLabel('site_description'))
	->hint(Yii::t('app', 'Enter a brief, concise description of your community. Include any key words or phrases that you want to appear in search engine listings.')); ?>

<?php echo $form->field($model, 'site_keywords')
	->textarea(['rows'=>2,'rows'=>6,'maxlength' => true])
	->label($model->getAttributeLabel('site_keywords'))
	->hint(Yii::t('app', 'Provide some keywords (separated by commas) that describe your community. These will be the default keywords that appear in the tag in your page header. Enter the most relevant keywords you can think of to help your community\'s search engine rankings.')); ?>

<?php if(Yii::$app->isSocialMedia()) {?>
<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12 col-12"><?php echo Yii::t('app', 'Public Permission Defaults');?></label>
	<div class="col-md-6 col-sm-9 col-xs-12 col-12">
		<span class="small-px mb-10"><?php echo Yii::t('app', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here.');?></span>
		<?php 
		$general_profile = [
			1 => Yii::t('app', 'Yes, the public can view profiles unless they are made private.'),
			0 => Yii::t('app', 'No, the public cannot view profiles.'),
		];
		echo $form->field($model, 'general_profile', ['template' => '<div class="h5">'.$model->getAttributeLabel('general_profile').'</div>{input}{error}'])
			->radioList($general_profile)
			->label($model->getAttributeLabel('general_profile')); ?>

		<?php 
		$general_invite = [
			1 => Yii::t('app', 'Yes, the public can use the invite page.'),
			0 => Yii::t('app', 'No, the public cannot use the invite page.'),
		];
		echo $form->field($model, 'general_invite', ['template' => '<div class="h5">'.$model->getAttributeLabel('general_profile').'</div>{input}{error}'])
			->radioList($general_invite)
			->label($model->getAttributeLabel('general_invite')); ?>

		<?php 
		$general_search = [
			1 => Yii::t('app', 'Yes, the public can use the search page.'),
			0 => Yii::t('app', 'No, the public cannot use the search page.'),
		];
		echo $form->field($model, 'general_search', ['template' => '<div class="h5">'.$model->getAttributeLabel('general_profile').'</div>{input}{error}'])
			->radioList($general_search)
			->label($model->getAttributeLabel('general_search')); ?>

		<?php 
		$general_portal = [
			1 => Yii::t('app', 'Yes, the public view use the portal page.'),
			0 => Yii::t('app', 'No, the public cannot view the portal page.'),
		];
		echo $form->field($model, 'general_portal', ['template' => '<div class="h5">'.$model->getAttributeLabel('general_profile').'</div>{input}{error}'])
			->radioList($general_portal)
			->label($model->getAttributeLabel('general_portal')); ?>
	</div>
</div>

<?php 
$signup_username = [
	1 => Yii::t('app', 'Yes, users are uniquely identified by their username.'),
	0 => Yii::t('app', 'No, usernames will not be used in this network.'),
];
echo $form->field($model, 'signup_username', ['template' => '{label}{beginWrapper}{hint}{input}{error}{endWrapper}'])
	->radioList($signup_username)
	->label($model->getAttributeLabel('signup_username'))
	->hint(Yii::t('app', 'By default, usernames are used to uniquely identify your users. If you choose to disable this feature, your users will not be given the option to enter a username. Instead, their user ID will be used. Note that if you do decide to enable this feature, you should make sure to create special REQUIRED display name profile fields - otherwise the users\' IDs will be displayed. Also note that if you disable usernames after users have already signed up, their usernames will be deleted and any previous links to their content will not work, as the links will no longer use their username! Finally, all recent activity and all notifications will be deleted if you choose to disable usernames after previously having them enabled.'));
}?>

<?php echo $form->field($model, 'general_include')
	->textarea(['rows'=>2,'rows'=>6])
	->label($model->getAttributeLabel('general_include'))
	->hint(Yii::t('app', 'Anything entered into the box below will be included at the bottom of the <head> tag. If you want to include a script or stylesheet, be sure to use the &lt;script&gt; or &lt;link&gt; tag.')); ?>

<div class="ln_solid"></div>
<div class="form-group row">
	<div class="col-md-6 col-sm-9 col-xs-12 col-12 col-sm-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>