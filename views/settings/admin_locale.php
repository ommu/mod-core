<?php
/**
 * Ommu Settings (ommu-settings)
 * @var $this SettingsController
 * @var $model OmmuSettings
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 Ommu Platform (www.ommu.co)
 * @created date 3 Augustus 2017, 06:42 WIB
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
		'id'=>'ommu-locale-form',
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
			<?php echo $form->labelEx($model,'site_dateformat', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php 
				$dateformat = "1986-08-11 16:25:50";
				echo $form->dropDownList($model,'site_dateformat', array(
					'n/j/Y' => date('n/j/Y', strtotime($dateformat)),
					'n-j-Y' => date('n-j-Y', strtotime($dateformat)),
					'm/j/Y' => date('m/j/Y', strtotime($dateformat)),
					'm-j-Y' => date('m-j-Y', strtotime($dateformat)),		
					'Y/n/j' => date('Y/n/j', strtotime($dateformat)),
					'Y-n-j' => date('Y-n-j', strtotime($dateformat)),
					'Y/m/j' => date('Y/m/j', strtotime($dateformat)),
					'Y-m-d' => date('Y-m-d', strtotime($dateformat)),
					'j/n/Y' => date('j/n/Y', strtotime($dateformat)),
					'j-n-Y' => date('j-n-Y', strtotime($dateformat)),
					'j/m/Y' => date('j/m/Y', strtotime($dateformat)),
					'j-m-Y' => date('j-m-Y', strtotime($dateformat)),
					'Y-F-j' => date('Y-F-j', strtotime($dateformat)),
					'j-F-Y' => date('j-F-Y', strtotime($dateformat)),
					'Y-M-j' => date('Y-M-j', strtotime($dateformat)),
					'j-M-Y' => date('j-M-Y', strtotime($dateformat)),
					'F j, Y' => date('F j, Y', strtotime($dateformat)),
					'j F Y' => date('j F Y', strtotime($dateformat)),
					'M. j, Y' => date('M. j, Y', strtotime($dateformat)),
					'j M Y' => date('j M Y', strtotime($dateformat)),
					'l, F j, Y' => date('l, F j, Y', strtotime($dateformat)),
					'l j F Y' => date('l j F Y', strtotime($dateformat)),
					'D j F Y' => date('D j F Y', strtotime($dateformat)),
					'D j M Y' => date('D j M Y', strtotime($dateformat)),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'site_dateformat'); ?>
			</div>
		</div>
		
		<div class="form-group row">
			<?php echo $form->labelEx($model,'site_timeformat', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php 
				echo $form->dropDownList($model,'site_timeformat', array(
					'g:i A' => date('g:i A', strtotime($dateformat)),
					'h:i A' => date('h:i A', strtotime($dateformat)),
					'g:i' => date('g:i', strtotime($dateformat)),
					'h:i' => date('h:i', strtotime($dateformat)),
					'H:i' => date('H:i', strtotime($dateformat)),
					'H\hi' => date('H\hi', strtotime($dateformat)),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'site_timeformat'); ?>
			</div>
		</div>

		<div class="form-group row submit">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">&nbsp;</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo CHtml::submitButton(Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>
</div>
