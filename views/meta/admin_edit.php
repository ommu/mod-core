<?php
/**
 * OmmuMeta (ommu-meta)
 * @var $this MetaController
 * @var $model OmmuMeta
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Metas'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		'Update',
	);
?>

<div class="form">

	<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
		'id'=>'ommu-meta-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array('enctype' => 'multipart/form-data')
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
	<?php
		echo $form->errorSummary($model);
		if(Yii::app()->user->hasFlash('error'))
			echo $this->flashMessage(Yii::app()->user->getFlash('error'), 'error');
		if(Yii::app()->user->hasFlash('success'))
			echo $this->flashMessage(Yii::app()->user->getFlash('success'), 'success');
	?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>

		<?php if($model->meta_image != '') {
			$model->old_meta_image = $model->meta_image;
			echo $form->hiddenField($model,'old_meta_image');
			$images = Yii::app()->request->baseUrl.'/public/'.$model->old_meta_image;
			?>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'old_meta_image', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
				<div class="col-lg-8 col-md-9 col-sm-12">
					<img src="<?php echo Utility::getTimThumb($images, 320, 150, 3);?>" alt="">
				</div>
			</div>
		<?php }?>
		
		<div class="form-group row">
			<?php echo $form->labelEx($model,'meta_image', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->fileField($model,'meta_image', array('maxlength'=>64, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'meta_image'); ?>
				<?php echo $form->error($model,'meta_image'); ?>
			</div>
		</div>
		
		<div class="form-group row">
			<?php echo $form->labelEx($model,'meta_image_alt', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'meta_image_alt', array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'meta_image_alt'); ?>
				<span class="small-px"><?php echo Yii::t('phrase', 'A text description of the image conveying the essential nature of an image to users who are visually impaired');?></span>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'office_on', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($model,'office_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'office_on'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'google_on', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($model,'google_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'google_on'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'twitter_on', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($model,'twitter_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'twitter_on'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'facebook_on', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($model,'facebook_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'facebook_on'); ?>
			</div>
		</div>

		<div class="form-group row submit">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12">&nbsp;</label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>


</div>
