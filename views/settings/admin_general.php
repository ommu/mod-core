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
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('#OmmuSettings_online input[name="OmmuSettings[online]"]').on('change', function() {
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
	$('#OmmuSettings_event_i input[name="OmmuSettings[event_i]"]').on('change', function() {
		var id = $(this).val();
		if(id == '0') {
			$('div#events').slideUp();
		} else {
			$('div#events').slideDown();
		}
	});
EOP;
	$cs->registerScript('setting', $js, CClientScript::POS_END);
?>

<div class="form" name="post-on">

	<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
		'id'=>'ommu-settings-form',
		'enableAjaxValidation'=>true,
		'htmlOptions' => array(
			//'enctype' => 'multipart/form-data',
		),
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('site_type');?> <span class="required">*</span></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php 
				if($model->isNewRecord && !$model->getErrors())
					$model->site_type = 0;
				echo $form->dropDownLIst($model,'site_type', array(
					'1' => Yii::t('phrase', 'Social Media / Community Website'),
					'0' => Yii::t('phrase', 'Company Profile'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'site_type'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('site_oauth');?> <span class="required">*</span></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php 
				if($model->isNewRecord && !$model->getErrors())
					$model->site_oauth = 0;
				echo $form->dropDownLIst($model,'site_oauth', array(
					'1' => Yii::t('phrase', 'Enable'),
					'0' => Yii::t('phrase', 'Disable'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'site_oauth'); ?>
			</div>
		</div>
		
		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('online');?> <span class="required">*</span></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<span class="small-px"><?php echo Yii::t('phrase', 'Maintenance Mode will prevent site visitors from accessing your website. You can customize the maintenance mode page by manually editing the file "/application/maintenance.html".');?></span>
				<?php echo $form->radioButtonList($model, 'online', array(
					1 => Yii::t('phrase', 'Online'),
					2 => Yii::t('phrase', 'Offline (Coming Soon)'),
					0 => Yii::t('phrase', 'Offline (Maintenance Mode)'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'online'); ?>
			</div>
		</div>

		<div id="construction" <?php echo $model->online == '1' ? 'class="hide"' : ''; ?>>
			<div class="form-group row">
				<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('construction_date');?> <span class="required">*</span></label>
				<div class="col-lg-8 col-md-9 col-sm-12">
					<?php 
					$model->construction_date = date('d-m-Y', strtotime($model->construction_date));
					//echo $form->textField($model,'construction_date', array('maxlength'=>10, 'class'=>'span-3'));
					$this->widget('application.libraries.core.components.system.CJuiDatePicker', array(
						'model'=>$model, 
						'attribute'=>'construction_date',
						'options'=>array(
							'dateFormat' => 'yy-mm-dd',
						),
						'htmlOptions'=>array(
							'class'=>'form-control'
						 ),
					));	?>
					<?php echo $form->error($model,'construction_date'); ?>
				</div>
			</div>

			<div id="comingsoon" class="form-group row <?php echo $model->online != '2' ? 'hide' : ''; ?>">
				<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('construction_text[comingsoon]')?> <span class="required">*</span></label>
				<div class="col-lg-8 col-md-9 col-sm-12">
					<?php 
					if(!$model->getErrors())
						$model->construction_text = unserialize($model->construction_text);
					echo $form->textArea($model,'construction_text[comingsoon]', array('rows'=>6, 'cols'=>50, 'class'=>'form-control small')); ?>
					<?php echo $form->error($model,'construction_text[comingsoon]'); ?>
				</div>
			</div>

			<div id="maintenance" class="form-group row <?php echo $model->online != '0' ? 'hide' : ''; ?>">
				<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('construction_text[maintenance]')?> <span class="required">*</span></label>
				<div class="col-lg-8 col-md-9 col-sm-12">
					<?php echo $form->textArea($model,'construction_text[maintenance]', array('rows'=>6, 'cols'=>50, 'class'=>'form-control small')); ?>
					<?php echo $form->error($model,'construction_text[maintenance]'); ?>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('event_i')?> <span class="required">*</span></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php 
				if(!$model->getErrors()) {
					$model->event_i = 0;
					if($model->isNewRecord || (!$model->isNewRecord && !in_array($model->event_startdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) && !in_array($model->event_finishdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30'))))
						$model->event_i = 1;
				}
				echo $form->radioButtonList($model,'event_i', array(
					1 => 'Enable',
					0 => 'Disable',
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'event_i'); ?>
			</div>
		</div>
		
		<div id="events" <?php echo $model->event_i == '0' ? 'class="hide"' : ''; ?>>
			<div class="form-group row">
				<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('event_startdate');?> <span class="required">*</span></label>
				<div class="col-lg-8 col-md-9 col-sm-12">
					<?php 
					if(!$model->getErrors())
						$model->event_startdate = !$model->isNewRecord ? (!in_array($model->event_startdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? date('d-m-Y', strtotime($model->event_startdate)) : '00-00-0000') : '';
					//$model->event_startdate = date('d-m-Y', strtotime($model->event_startdate));
					//echo $form->textField($model,'event_startdate', array('maxlength'=>10, 'class'=>'span-3'));
					$this->widget('application.libraries.core.components.system.CJuiDatePicker', array(
						'model'=>$model, 
						'attribute'=>'event_startdate',
						'options'=>array(
							'dateFormat' => 'yy-mm-dd',
						),
						'htmlOptions'=>array(
							'class'=>'form-control'
						 ),
					));	?>
					<?php echo $form->error($model,'event_startdate'); ?>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('event_finishdate');?> <span class="required">*</span></label>
				<div class="col-lg-8 col-md-9 col-sm-12">
					<?php 
					if(!$model->getErrors())
						$model->event_finishdate = !$model->isNewRecord ? (!in_array($model->event_finishdate, array('0000-00-00','1970-01-01','0002-12-02','-0001-11-30')) ? date('d-m-Y', strtotime($model->event_finishdate)) : '00-00-0000') : '';
					//$model->event_finishdate = date('d-m-Y', strtotime($model->event_finishdate));
					//echo $form->textField($model,'event_finishdate', array('maxlength'=>10, 'class'=>'span-3'));
					$this->widget('application.libraries.core.components.system.CJuiDatePicker', array(
						'model'=>$model, 
						'attribute'=>'event_finishdate',
						'options'=>array(
							'dateFormat' => 'yy-mm-dd',
						),
						'htmlOptions'=>array(
							'class'=>'form-control'
						 ),
					));	?>
					<?php echo $form->error($model,'event_finishdate'); ?>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('event_tag')?> <span class="required">*</span></label>
				<div class="col-lg-8 col-md-9 col-sm-12">
					<?php echo $form->textArea($model,'event_tag', array('rows'=>6, 'cols'=>50, 'class'=>'form-control smaller')); ?>
					<?php echo $form->error($model,'event_tag'); ?>
					<span class="small-px"><?php echo Yii::t('phrase', 'tambahkan tanda koma (,) jika ingin menambahkan event tag lebih dari satu');?></span>
				</div>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('site_title');?> <span class="required">*</span></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'site_title', array('maxlength'=>256, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'site_title'); ?>
				<span class="small-px"><?php echo Yii::t('phrase', 'Give your community a unique name. This will appear in the &lt;title&gt; tag throughout most of your site.');?></span>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('site_url')?> <span class="required">*</span></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'site_url', array('maxlength'=>32, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'site_url'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('site_description');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Enter a brief, concise description of your community. Include any key words or phrases that you want to appear in search engine listings.');?></span>
			</label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'site_description', array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'maxlength'=>256)); ?>
				<?php echo $form->error($model,'site_description'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('site_keywords');?> <span class="required">*</span><br/>
				<span><?php echo Yii::t('phrase', 'Provide some keywords (separated by commas) that describe your community. These will be the default keywords that appear in the <meta> tag in your page header. Enter the most relevant keywords you can think of to help your community\'s search engine rankings.');?></span>
			</label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'site_keywords', array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'maxlength'=>256)); ?>
				<?php echo $form->error($model,'site_keywords'); ?>
				<span class="small-px"><?php echo Yii::t('phrase', 'tambahkan tanda koma (,) jika ingin menambahkan keyword lebih dari satu');?></span>
			</div>
		</div>

		<?php if(OmmuSettings::getInfo('site_type') == 1) {?>
		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12">
				<?php echo Yii::t('phrase', 'Public Permission Defaults');?>
				<span><?php echo Yii::t('phrase', 'Select whether or not you want to let the public (visitors that are not logged-in) to view the following sections of your social network. In some cases (such as Profiles), if you have given them the option, your users will be able to make their pages private even though you have made them publically viewable here.');?></span>
			</label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<p><?php echo $model->getAttributeLabel('general_profile');?></p>
				<?php echo $form->radioButtonList($model, 'general_profile', array(
					1 => Yii::t('phrase', 'Yes, the public can view profiles unless they are made private.'),
					0 => Yii::t('phrase', 'No, the public cannot view profiles.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'general_profile'); ?>

				<p><?php echo $model->getAttributeLabel('general_invite');?></p>
				<?php echo $form->radioButtonList($model, 'general_invite', array(
					1 => Yii::t('phrase', 'Yes, the public can use the invite page.'),
					0 => Yii::t('phrase', 'No, the public cannot use the invite page.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'general_invite'); ?>

				<p><?php echo $model->getAttributeLabel('general_search');?></p>
				<?php echo $form->radioButtonList($model, 'general_search', array(
					1 => Yii::t('phrase', 'Yes, the public can use the search page.'),
					0 => Yii::t('phrase', 'No, the public cannot use the search page.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'general_search'); ?>

				<p><?php echo $model->getAttributeLabel('general_portal');?></p>
				<?php echo $form->radioButtonList($model, 'general_portal', array(
					1 => Yii::t('phrase', 'Yes, the public view use the portal page.'),
					0 => Yii::t('phrase', 'No, the public cannot view the portal page.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'general_portal'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12"><?php echo Yii::t('phrase', 'Enable Username?');?></label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<span class="small-px"><?php echo Yii::t('phrase', 'By default, usernames are used to uniquely identify your users. If you choose to disable this feature, your users will not be given the option to enter a username. Instead, their user ID will be used. Note that if you do decide to enable this feature, you should make sure to create special REQUIRED display name profile fields - otherwise the users\' IDs will be displayed. Also note that if you disable usernames after users have already signed up, their usernames will be deleted and any previous links to their content will not work, as the links will no longer use their username! Finally, all recent activity and all notifications will be deleted if you choose to disable usernames after previously having them enabled.');?></span>
				<?php echo $form->radioButtonList($model, 'signup_username', array(
					1 => Yii::t('phrase', 'Yes, users are uniquely identified by their username.'),
					0 => Yii::t('phrase', 'No, usernames will not be used in this network.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_username'); ?>
				<?php /*<div class="small-px"></div>*/?>
			</div>
		</div>
		<?php }?>

		<div class="form-group row">
			<label class="col-form-label col-lg-4 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('general_include');?>
				<span><?php echo Yii::t('phrase', 'Anything entered into the box below will be included at the bottom of the &lt;head&gt; tag. If you want to include a script or stylesheet, be sure to use the &lt;script&gt; or &lt;link&gt; tag.');?></span>
			</label>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'general_include', array('rows'=>6, 'cols'=>50, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'general_include'); ?>
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
	<?php $this->endWidget(); ?>
</div>