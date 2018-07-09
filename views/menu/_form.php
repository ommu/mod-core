<?php
/**
 * Ommu Menus (ommu-menu)
 * @var $this MenuController
 * @var $model OmmuMenus
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 24 March 2016, 10:20 WIB
 * @link https://github.com/ommu/mod-core
 *
 */
?>

<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
	'id'=>'ommu-menu-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">
	<fieldset>

		<?php //begin.Messages ?>
		<div id="ajax-message">
			<?php echo $form->errorSummary($model); ?>
		</div>
		<?php //begin.Messages ?>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'cat_id', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php 
				$category = OmmuMenuCategory::getCategory();
				if($category != null)
					echo $form->dropDownList($model,'cat_id', $category, array('prompt'=>Yii::t('phrase', 'Select One'), 'class'=>'form-control'));
				else
					echo $form->dropDownList($model,'cat_id', array('prompt'=>Yii::t('phrase', 'Select One')), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'cat_id'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<?php
		$parent = null;
		$menu = OmmuMenus::getParentMenu(null, $parent);
		if($menu != null) {?>
		<div class="form-group row">
			<?php echo $form->labelEx($model,'parent_id', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->dropDownList($model,'parent_id', $menu, array('prompt'=>Yii::t('phrase', 'No Parent'), 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'parent_id'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>
		<?php }?>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'name_i', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'name_i', array('maxlength'=>32,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'name_i'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'url', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'url', array('class'=>'form-control smaller')); ?>
				<?php echo $form->error($model,'url'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'attr', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'attr', array('class'=>'form-control smaller')); ?>
				<?php echo $form->error($model,'attr'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>
		
		<div class="form-group row">
			<?php echo $form->labelEx($model,'sitetype_access', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php 
				$siteType = array(
					'0' => Yii::t('phrase', 'Company Profile'),
					'1' => Yii::t('phrase', 'Social Media / Community Website'),
				);
				if(!$model->getErrors())
					$model->sitetype_access = unserialize($model->sitetype_access);
				echo $form->checkBoxList($model,'sitetype_access', $siteType, array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'sitetype_access'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'userlevel_access', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php 
				if(!$model->getErrors())
					$model->userlevel_access = unserialize($model->userlevel_access);
				$userlevel = UserLevel::getUserLevel();
				$userlevel[0] = Yii::t('phrase', 'Public');
				echo $form->checkBoxList($model,'userlevel_access', $userlevel, array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'userlevel_access'); ?>
			</div>
		</div>

		<div class="form-group row publish">
			<?php echo $form->labelEx($model,'publish', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->checkBox($model,'publish', array('class'=>'form-control')); ?>
				<?php echo $form->labelEx($model, 'publish'); ?>
				<?php echo $form->error($model,'publish'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save') , array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Cancel'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>


