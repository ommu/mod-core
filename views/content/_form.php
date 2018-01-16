<?php
/**
 * Ommu Pages (ommu-pages)
 * @var $this ContentController
 * @var $model OmmuPages
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
 *
 */
 
	$cs = Yii::app()->getClientScript();
$js=<<<EOP
	$('input#OmmuPages_media_show').change(function(){
		var type = $(this).parents('form').attr('action');
		var id = $(this).prop('checked');
		if(id == true) {
			$('form[action="'+type+'"] div#media').slideDown();
		} else {
			$('form[action="'+type+'"] div#media').slideUp();
		}
	});
EOP;
	$cs->registerScript('mediashow', $js, CClientScript::POS_END);
?>

<?php $form=$this->beginWidget('application.libraries.core.components.system.OActiveForm', array(
	'id'=>'ommu-pages-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array('enctype' => 'multipart/form-data')
)); ?>

	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>

	<fieldset>
		<div class="row">
			<div class="col-lg-8 col-md-12">

				<div class="form-group row">
					<?php echo $form->labelEx($model,'name_i', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
					<div class="col-lg-8 col-md-9 col-sm-12">
						<?php echo $form->textField($model,'name_i',array('maxlength'=>256,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'name_i'); ?>
					</div>
				</div>
				
				<div class="form-group row">
					<?php echo $form->labelEx($model,'quote_i', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
					<div class="col-lg-8 col-md-9 col-sm-12">
						<?php 
						//echo $form->textArea($model,'quote_i',array('rows'=>6, 'cols'=>50, 'class'=>'form-control'));
						$this->widget('yiiext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
							'model'=>$model,
							'attribute'=>'quote_i',
							// Redactor options
							'options'=>array(
								//'lang'=>'fi',
								'buttons'=>array(
									'html', '|', 
									'bold', 'italic', 'deleted', '|',
								),
							),
							'plugins' => array(
								'fontcolor' => array('js' => array('fontcolor.js')),
								'fullscreen' => array('js' => array('fullscreen.js')),
							),
							'htmlOptions'=>array(
								'class'=>'form-control'
							 ),
						)); ?>
						<span class="small-px">Note : add {$quote} in description static pages</span>
						<?php echo $form->error($model,'quote_i'); ?>
					</div>
				</div>

				<div class="form-group row">
					<?php echo $form->labelEx($model,'desc_i', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
					<div class="col-lg-8 col-md-9 col-sm-12">
						<?php
						//echo $form->textArea($model,'desc_i',array('rows'=>6, 'cols'=>50, 'class'=>'form-control'));
						$this->widget('yiiext.imperavi-redactor-widget.ImperaviRedactorWidget', array(
							'model'=>$model,
							'attribute'=>'desc_i',
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
						<?php echo $form->error($model,'desc_i'); ?>
					</div>
				</div>

				<?php /*<div class="form-group row">
					<?php echo $form->labelEx($model,'desc_i', array('class'=>'col-form-label col-lg-4 col-md-3 col-sm-12')); ?>
					<div class="col-lg-8 col-md-9 col-sm-12">
						<?php
						$model->desc_i = $model->description->message;
						//echo $form->textArea($model,'desc_i',array('rows'=>6, 'cols'=>50, 'class'=>'form-control'));
						$options = array(
							'lang' => 'en',
							'buttons' => array('html', '|', 'bold', 'italic', '|',
								'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
								'image', 'video', 'file', 'table', 'link', '|', 'horizontalrule'
							),
						);
						$this->widget('application.extensions.imperavi-redactor.ImperaviRedactorWidget', array(
							'model'=>$model,
							'attribute'=>'desc_i',
							'options'   => $options
						)); ?>
						<?php echo $form->error($model,'desc_i'); ?>
					</div>
				</div> */?>

			</div>
			<div class="col-lg-4 col-md-12">
				<?php if($model->isNewRecord) {?>
					<div class="form-group row">
						<?php echo $form->labelEx($model,'media', array('class'=>'col-form-label col-lg-12 col-md-3 col-sm-12')); ?>
						<div class="col-lg-12 col-md-9 col-sm-12">
							<?php echo $form->fileField($model,'media', array('class'=>'form-control')); ?>
							<?php echo $form->error($model,'media'); ?>
						</div>
					</div>
				<?php } else {?>
					<div class="form-group row publish">
						<?php echo $form->labelEx($model,'media_show', array('class'=>'col-form-label col-lg-12 col-md-3 col-sm-12')); ?>
						<div class="col-lg-12 col-md-9 col-sm-12">
							<?php echo $form->checkBox($model,'media_show', array('class'=>'form-control')); ?>
							<?php echo $form->labelEx($model, 'media_show'); ?>
							<?php echo $form->error($model,'media_show'); ?>
						</div>
					</div>
					
					<div id="media" <?php echo $model->media_show == 0 ? 'class="hide"' : '';?>>
						<div class="form-group row">
							<?php echo $form->labelEx($model,'media', array('class'=>'col-form-label col-lg-12 col-md-3 col-sm-12')); ?>
							<div class="col-lg-12 col-md-9 col-sm-12">
								<?php if($model->media != '') {
									$model->old_media_i = $model->media;
									echo $form->hiddenField($model,'old_media_i');
									$images = Yii::app()->request->baseUrl.'/public/page/'.$model->old_media_i;?>
									<img src="<?php echo Utility::getTimThumb($images, 320, 150, 1);?>" alt="">
								<?php }?>
								<?php echo $form->fileField($model,'media', array('class'=>'form-control')); ?>
								<?php echo $form->error($model,'media'); ?>
							</div>
						</div>

						<div class="form-group row <?php echo $model->media == '' ? 'hide' : '';?>">
							<?php echo $form->labelEx($model,'media_type', array('class'=>'col-form-label col-lg-12 col-md-3 col-sm-12')); ?>
							<div class="col-lg-12 col-md-9 col-sm-12">
								<?php echo $form->dropDownList($model,'media_type', array(
									1 => Yii::t('phrase', 'Large'),
									2 => Yii::t('phrase', 'Medium'),
								), array('prompt'=>Yii::t('phrase', 'Select type'), 'class'=>'form-control')); ?>
								<?php echo $form->error($model,'media_type'); ?>
							</div>
						</div>
					</div>
				<?php }?>

				<div class="form-group row publish">
					<?php echo $form->labelEx($model,'publish', array('class'=>'col-form-label col-lg-12 col-md-3 col-sm-12')); ?>
					<div class="col-lg-12 col-md-9 col-sm-12">
						<?php echo $form->checkBox($model,'publish', array('class'=>'form-control')); ?>
						<?php echo $form->labelEx($model, 'publish'); ?>
						<?php echo $form->error($model,'publish'); ?>
					</div>
				</div>
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

