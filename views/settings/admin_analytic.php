<?php
/**
 * Ommu Settings (ommu-settings)
 * @var $this SettingsController
 * @var $model OmmuSettings
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Settings'=>array('manage'),
		'Manage',
	);
?>

<div class="form" name="post-on">

	<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
		'id'=>'ommu-settings-form',
		'enableAjaxValidation'=>true,
		//'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
		<div class="form-group row publish">
			<?php echo $form->labelEx($model,'analytic', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->checkBox($model,'analytic', array('class'=>'form-control')); ?>
				<?php echo $form->labelEx($model, 'analytic'); ?>
				<?php echo $form->error($model,'analytic'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('analytic_id');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'analytic_id', array('maxlength'=>32, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'analytic_id'); ?>
				<div class="small-px"><?php echo Yii::t('phrase', 'Enter the Website Profile ID to use Google Analytics.');?></div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('analytic_profile_id');?>
			</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'analytic_profile_id', array('maxlength'=>32, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'analytic_profile_id'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row submit">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">&nbsp;</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>

</div>