<?php
/**
 * Core Zone Villages (core-zone-village)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\VillageController
 * @var $model ommu\core\models\CoreZoneVillage
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 16 September 2017, 17:35 WIB
 * @modified date 30 January 2019, 17:15 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ActiveForm;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
?>

<div class="core-zone-village-form">

<?php $form = ActiveForm::begin([
	'options' => ['class'=>'form-horizontal form-label-left'],
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<?php $district_id = $form->field($model, 'district_id', ['template' => '{input}', 'options' => ['tag' => null]])->hiddenInput()->label(false);
echo $form->field($model, 'districtName', ['template' => '{label}<div class="col-md-6 col-sm-9 col-xs-12">{input}'.$district_id.'{error}</div>'])
	// ->textInput(['maxlength'=>true])
	->widget(AutoComplete::className(), [
		'options' => [
			'data-toggle' => 'tooltip', 'data-placement' => 'top',
			'class' => 'ui-autocomplete-input form-control'
		],
		'clientOptions' => [
			'source' => Url::to(['zone/district/suggest', 'extend'=>'district_name']),
			'minLength' => 2,
			'select' => new JsExpression("function(event, ui) {
				\$('.field-districtname #district_id').val(ui.item.id);
				\$('.field-districtname #districtname').val(ui.item.label);
				return false;
			}"),
		]
	])
	->label($model->getAttributeLabel('districtName'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

<?php echo $form->field($model, 'village_name')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('village_name')); ?>

<?php echo $form->field($model, 'zipcode')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('zipcode')); ?>

<?php echo $form->field($model, 'mfdonline')
	->textInput(['maxlength'=>true])
	->label($model->getAttributeLabel('mfdonline')); ?>

<?php echo $form->field($model, 'publish')
	->checkbox(['label'=>''])
	->label($model->getAttributeLabel('publish')); ?>

<div class="ln_solid"></div>
<div class="form-group row">
	<div class="col-md-6 col-sm-9 col-xs-12 offset-sm-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>

</div>