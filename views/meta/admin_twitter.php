<?php
/**
 * OmmuMeta (ommu-meta)
 * @var $this MetaController
 * @var $model OmmuMeta
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Metas'=>array('manage'),
		$model->id=>array('view','id'=>$model->id),
		Yii::t('phrase', 'Update'),
	);

	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('select#OmmuMeta_twitter_card').on('change', function() {
		var id = $(this).val();
		$('div.filter').slideUp();
		if(id == '3') {
			$('div.filter#photo').slideDown();
		} else if(id == '4') {
			$('div.filter#application').slideDown();
		}
	});
EOP;
	$cs->registerScript('type', $js, CClientScript::POS_END);
?>

<div class="form" name="post-on">

	<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
		'id'=>'ommu-meta-form',
		'enableAjaxValidation'=>true,
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
	
		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('twitter_on');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($model,'twitter_on', array(
					1 => Yii::t('phrase', 'Enabled'),
					0 => Yii::t('phrase', 'Disabled'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'twitter_on'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('twitter_card');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->dropDownList($model,'twitter_card', array(
					1 => Yii::t('phrase', 'Summary Card'),
					2 => Yii::t('phrase', 'Summary Card with Large Image'),
					3 => Yii::t('phrase', 'Photo Card'),
					4 => Yii::t('phrase', 'App Card'),
					//5 => Yii::t('phrase', 'Gallery Card'),
					//6 => Yii::t('phrase', 'Player Card'),
					//7 => Yii::t('phrase', 'Player Card: Approval Guide'),
					//8 => Yii::t('phrase', 'Product Card'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'twitter_card'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('twitter_site');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'twitter_site', array('maxlength'=>32, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'twitter_site'); ?>
				<div class="small-px"><?php echo Yii::t('phrase', 'Your official site in twitter (.i.e. "@CareerCenterCodes, @OmmuPlatform")');?></div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('twitter_creator');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'twitter_creator', array('maxlength'=>32, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'twitter_creator'); ?>
				<div class="small-px"><?php echo Yii::t('phrase', 'Creator your site in twitter (.i.e. "@PutraSudaryanto, @Mba_Em")');?></div>
			</div>
		</div>

		<div id="photo" class="filter <?php echo $model->twitter_card != 3 ? 'hide' : '';?>">
			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('twitter_photo_width_i');?> <span class="required">*</span></label>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php 
					if(!$model->getErrors())
						$model->twitter_photo_size = unserialize($model->twitter_photo_size);
					echo $form->textField($model,'twitter_photo_size[width]', array('maxlength'=>3, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_photo_size[width]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Providing width in px helps us more accurately preserve the aspect ratio of the image when resizing');?></div>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('twitter_photo_height_i');?> <span class="required">*</span></label>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_photo_size[height]', array('maxlength'=>3, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_photo_size[height]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Providing height in px helps us more accurately preserve the aspect ratio of the image when resizing');?></div>
				</div>
			</div>
		</div>

		<div id="application" class="filter <?php echo $model->twitter_card != 4 ? 'hide' : '';?>">
			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_country', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_country', array('maxlength'=>32, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_country'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'If your application is not available in the US App Store, you must set this value to the two-letter country code for the App Store that contains your application.');?></div>
				</div>
			</div>
			
			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_iphone_name_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php
					if(!$model->getErrors())
						$model->twitter_iphone = unserialize($model->twitter_iphone);
					echo $form->textField($model,'twitter_iphone[name]', array('maxlength'=>32, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_iphone[name]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Name of your iPhone app');?></div>
				</div>
			</div>
			
			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_iphone_id_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_iphone[id]', array('maxlength'=>32, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_iphone[id]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'String value, and should be the numeric representation of your app ID in the App Store (.i.e. "307234931")');?></div>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_iphone_url_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_iphone[url]', array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_iphone[url]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Your app\'s custom URL scheme (you must include "://" after your scheme name)');?></div>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_ipad_name_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php 
					if(!$model->getErrors())
						$model->twitter_ipad = unserialize($model->twitter_ipad);
					echo $form->textField($model,'twitter_ipad[name]', array('maxlength'=>32, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_ipad[name]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Name of your iPad optimized app');?></div>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_ipad_id_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_ipad[id]', array('maxlength'=>32, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_ipad[id]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'String value, should be the numeric representation of your app ID in the App Store (.i.e. “307234931”)');?></span>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_ipad_url_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_ipad[url]', array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_ipad[url]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Your app\'s custom URL scheme (you must include "://" after your scheme name)');?></div>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_googleplay_name_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php 
					if(!$model->getErrors())
						$model->twitter_googleplay = unserialize($model->twitter_googleplay);
					echo $form->textField($model,'twitter_googleplay[name]', array('maxlength'=>32, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_googleplay[name]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Name of your Android app');?></div>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_googleplay_id_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_googleplay[id]', array('maxlength'=>32, 'class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_googleplay[id]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'String value, and should be the numeric representation of your app ID in Google Play (.i.e. "co.ommu.nirwasita")');?></div>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'twitter_googleplay_url_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
				<div class="col-lg-6 col-md-9 col-sm-12">
					<?php echo $form->textField($model,'twitter_googleplay[url]', array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'twitter_googleplay[url]'); ?>
					<div class="small-px"><?php echo Yii::t('phrase', 'Your app\'s custom URL scheme (.i.e. "http://play.google.com/store/apps/details?id=co.ommu.nirwasita")');?></div>
				</div>
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
