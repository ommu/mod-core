<?php
/**
 * Ommu Wall Likes (ommu-wall-likes)
 * @var $this WalllikeController
 * @var $model OmmuWallLikes
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
 *
 */
?>

<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
	'id'=>'ommu-wall-likes-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

<?php //begin.Messages ?>
<div id="ajax-message">
	<?php echo $form->errorSummary($model); ?>
</div>
<?php //begin.Messages ?>

<fieldset>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'wall_id', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
		<div class="col-lg-8 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'wall_id',array('size'=>11,'maxlength'=>11, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'wall_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'user_id', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
		<div class="col-lg-8 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'user_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'likes_date', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
		<div class="col-lg-8 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'likes_date', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'likes_date'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'likes_ip', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
		<div class="col-lg-8 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'likes_ip',array('size'=>20,'maxlength'=>20, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'likes_ip'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row submit">
		<label class="col-form-label col-lg-4 col-md-3 col-sm-12">&nbsp;</label>
		<div class="col-lg-8 col-md-9 col-sm-12">
			<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
		</div>
	</div>

</fieldset>
<?php /*
<div class="dialog-content">
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') ,array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
*/?>
<?php $this->endWidget(); ?>


