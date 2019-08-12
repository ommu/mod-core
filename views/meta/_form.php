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
?>

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
		<?php echo $form->labelEx($model,'id', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'id', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'meta_image', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'meta_image', array('maxlength'=>64, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'meta_image'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_on', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_on', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_on'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_location', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_location', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_location'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_place', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textArea($model,'office_place', array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_place'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_country_id', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_country_id', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_country_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_province_id', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_province_id', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_province_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_city_id', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_city_id', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_city_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_district', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_district', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_district'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_village', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_village', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_village'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_zipcode', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_zipcode', array('maxlength'=>6, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_zipcode'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_hour', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textArea($model,'office_hour', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_hour'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_phone', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_phone', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_phone'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_fax', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_fax', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_fax'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_email', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_email', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_email'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_hotline', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_hotline', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_hotline'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'office_website', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'office_website', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'office_website'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'google_on', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'google_on', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'google_on'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_on', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_on', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_on'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_card', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_card', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_card'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_site', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_site', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_site'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_creator', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_creator', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_creator'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_photo_width_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php 
			if(!$model->getErrors())
				$model->twitter_photo_size = unserialize($model->twitter_photo_size);
			echo $form->textField($model,'twitter_photo_size[width]', array('maxlength'=>3, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_photo_size[width]'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_photo_height_i', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_photo_size[height]', array('maxlength'=>3, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_photo_size[height]'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_iphone_id', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_iphone_id', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_iphone_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_iphone_url', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_iphone_url', array('maxlength'=>256, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_iphone_url'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_ipad_name', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_ipad_name', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_ipad_name'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_ipad_url', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_ipad_url', array('maxlength'=>256, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_ipad_url'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_googleplay_id', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_googleplay_id', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_googleplay_id'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'twitter_googleplay_url', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'twitter_googleplay_url', array('maxlength'=>256, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'twitter_googleplay_url'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_on', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_on', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_on'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_type', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_type', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_type'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_profile_firstname', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_profile_firstname', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_profile_firstname'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_profile_lastname', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_profile_lastname', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_profile_lastname'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_profile_username', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_profile_username', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_profile_username'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_sitename', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_sitename', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_sitename'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_see_also', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_see_also', array('maxlength'=>256, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_see_also'); ?>
			<?php /*<div class="small-px"></div>*/?>
		</div>
	</div>

	<div class="form-group row">
		<?php echo $form->labelEx($model,'facebook_admins', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
		<div class="col-lg-6 col-md-9 col-sm-12">
			<?php echo $form->textField($model,'facebook_admins', array('maxlength'=>32, 'class'=>'form-control')); ?>
			<?php echo $form->error($model,'facebook_admins'); ?>
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
