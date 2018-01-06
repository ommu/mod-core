<?php
/**
 * Ommu System Phrase (ommu-system-phrase)
 * @var $this TranslateController
 * @var $model OmmuSystemPhrase
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
 *
 */
?>

<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
	'id'=>'ommu-system-phrase-form',
	'enableAjaxValidation'=>true,
	//'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>
<div class="dialog-content">

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>

		<?php foreach($language as $key => $val) {?>
		<div class="form-group row">
			<?php echo CHtml::label($val->name, 'OmmuSystemPhrase_'.$val->code, array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php 
				//echo $form->textArea($model,$val->code,array('rows'=>6, 'cols'=>50, 'class'=>'span-8 medium'));
				$this->widget('yiiext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
					'model'=>$model,
					'attribute'=>$val->code,
					// Redactor options
					'options'=>array(
						//'lang'=>'fi',
						'buttons'=>array(
							'html', 'formatting', '|', 
							'bold', 'italic', 'deleted', '|',
							'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
							'link', '|',
						),
					),
					'plugins' => array(
						'fontcolor' => array('js' => array('fontcolor.js')),
						'table' => array('js' => array('table.js')),
						'fullscreen' => array('js' => array('fullscreen.js')),
					),
					'htmlOptions'=>array(
						'class'=>'form-control'
					 ),
				)); ?>
				<?php echo $form->error($model, $val->code); ?>
			</div>
		</div>
		<?php }?>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'location', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
			<div class="col-lg-8 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'location',array('class'=>'form-control smaller')); ?>
				<?php echo $form->error($model,'location'); ?>
				<span class="small-px"><?php echo Yii::t('phrase', 'We recommend you to use location field. It helps you to know where this phrase is used. Example: you can use "event.create" location for "Create" button\'s label on create a new event page');?></span>
			</div>
		</div>

	</fieldset>
</div>
<div class="dialog-submit">
	<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>
<?php $this->endWidget(); ?>
