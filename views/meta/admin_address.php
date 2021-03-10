<?php
/**
 * Core Metas (core-meta)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\MetaController
 * @var $model ommu\core\models\CoreMeta
 * @var $form yii\widgets\ActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 24 April 2018, 14:11 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\jui\AutoComplete;
use ommu\core\models\CoreZoneCity;
use ommu\core\models\CoreZoneProvince;
use ommu\core\models\CoreZoneCountry;

if (!$small) {
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Metas'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = $this->title;

    $this->params['menu']['content'] = [
        ['label' => Yii::t('app', 'Global Meta'), 'url' => Url::to(['update']), 'icon' => 'pencil', 'htmlOptions' => ['class' => 'btn btn-primary']],
        ['label' => Yii::t('app', 'Address'), 'url' => Url::to(['address']), 'icon' => 'pencil', 'htmlOptions' => ['class' => 'btn btn-primary']],
        ['label' => Yii::t('app', 'Google Owner Meta'), 'url' => Url::to(['google']), 'icon' => 'pencil', 'htmlOptions' => ['class' => 'btn btn-primary']],
        ['label' => Yii::t('app', 'Twitter Meta'), 'url' => Url::to(['twitter']), 'icon' => 'pencil', 'htmlOptions' => ['class' => 'btn btn-primary']],
        ['label' => Yii::t('app', 'Facebook Meta'), 'url' => Url::to(['facebook']), 'icon' => 'pencil', 'htmlOptions' => ['class' => 'btn btn-primary']],
    ];
} ?>

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

<?php //echo $form->errorSummary($model);?>

<?php echo $form->field($model, 'office_location')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_location'))
	->hint(Yii::t('app', 'A struct containing metadata defining the location of a place')); ?>

<?php echo $form->field($model, 'office_name')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_name')); ?>

<div class="form-group">
	<?php echo $form->field($model, 'office_place', ['template' => '{label}', 'options' => ['tag' => null]])
		->label($model->getAttributeLabel('office_place'), ['class' => 'control-label col-sm-3 col-xs-12']); ?>
	<div class="col-md-6 col-sm-9 col-xs-12">
		<?php echo $form->field($model, 'office_place', ['template' => '{input}{error}'])
			->textarea(['rows' => 6, 'cols' => 50])
			->label($model->getAttributeLabel('office_place')); ?>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php echo $form->field($model, 'office_district', ['template' => '{input}{error}'])
					//->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('office_district')])
					->widget(AutoComplete::className(), [
						'options' => [
							'placeholder' => 'Your district. *auto suggest',
							'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Autosuggest input, ketikan minimal 2 huruf',
							'class' => 'ui-autocomplete-input form-control'
						],
						'clientOptions' => [
							'source' => Url::to(['/district/suggest', 'extend' => 'district_name,city_id,province_id,country_id']),
							'minLength' => 2,
							'select' => new JsExpression("function(event, ui) {
								\$('.field-office_city_id #office_city_id').val(ui.item.city_id);
								\$('.field-office_province_id #office_province_id').val(ui.item.province_id);
								\$('.field-office_country_id #office_country_id').val(ui.item.country_id);
								\$(event.target).val(ui.item.district_name);
								return false;
							}"),
						]
					])
					->label($model->getAttributeLabel('office_district')); ?>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-12">
				<?php echo $form->field($model, 'office_village', ['template' => '{input}{error}'])
					//->textInput(['maxlength' => true, 'placeholder' => $model->getAttributeLabel('office_village')])
					->widget(AutoComplete::className(), [
						'options' => [
							'placeholder' => 'Your village. *auto suggest',
							'data-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => 'Autosuggest input, ketikan minimal 2 huruf',
							'class' => 'ui-autocomplete-input form-control'
						],
						'clientOptions' => [
							'source' => Url::to(['/village/suggest', 'extend' => 'village_name,district_name,city_id,province_id,country_id']),
							'minLength' => 2,
							'select' => new JsExpression("function(event, ui) {
								\$('.field-office_district #office_district').val(ui.item.district_name);
								\$('.field-office_city_id #office_city_id').val(ui.item.city_id);
								\$('.field-office_province_id #office_province_id').val(ui.item.province_id);
								\$('.field-office_country_id #office_country_id').val(ui.item.country_id);
								\$(event.target).val(ui.item.village_name);
								return false;
							}"),
						]
					])
					->label($model->getAttributeLabel('office_village')); ?>
			</div>
		</div>
		<span class="small-px"><?php echo Yii::t('app', 'The number, street, district and village of the postal address for this business');?></span>
	</div>
</div>

<?php
$office_city_id = CoreZoneCity::getCity(1);
echo $form->field($model, 'office_city_id')
	->dropDownList($office_city_id, ['prompt' => ''])
	->label($model->getAttributeLabel('office_city_id'))
	->hint(Yii::t('app', 'The city (or locality) line of the postal address for this business')); ?>

<?php
$office_province_id = CoreZoneProvince::getProvince(1);
echo $form->field($model, 'office_province_id')
	->dropDownList($office_province_id, ['prompt' => ''])
	->label($model->getAttributeLabel('office_province_id')); ?>

<?php
$office_country_id = CoreZoneCountry::getCountry();
echo $form->field($model, 'office_country_id')
	->dropDownList($office_country_id, ['prompt' => ''])
	->label($model->getAttributeLabel('office_country_id')); ?>

<?php echo $form->field($model, 'office_zipcode')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_zipcode'))
	->hint(Yii::t('app', 'The state (or region) line of the postal address for this business')); ?>

<?php echo $form->field($model, 'office_phone')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_phone'))
	->hint(Yii::t('app', 'A telephone number to contact this business')); ?>

<?php echo $form->field($model, 'office_fax')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_fax'))
	->hint(Yii::t('app', 'A fax number to contact this business')); ?>

<?php echo $form->field($model, 'office_email')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_email'))
	->hint(Yii::t('app', 'An email address to contact this business')); ?>

<?php echo $form->field($model, 'office_website')
	->textInput(['maxlength' => true])
	->label($model->getAttributeLabel('office_website'))
	->hint(Yii::t('app', 'A website for this business')); ?>

<hr/>

<?php echo $form->field($model, 'submitButton')
	->submitButton(); ?>

<?php ActiveForm::end(); ?>