<?php
/**
 * Ommu Languages (ommu-languages)
 * @var $this LanguageController
 * @var $model OmmuLanguages
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Languages'=>array('manage'),
		Yii::t('phrase', 'Manage'),
	);
?>

<?php //begin.Search ?>
<div class="search-form">
<?php $this->renderPartial('_search', array(
	'model'=>$model,
)); ?>
</div>
<?php //end.Search ?>

<?php //begin.Grid Option ?>
<div class="grid-form">
<?php $this->renderPartial('_option_form', array(
	'model'=>$model,
	'gridColumns'=>$this->activeDefaultColumns($columns),
)); ?>
</div>
<?php //end.Grid Option ?>

<div id="partial-language">
	<?php //begin.Messages ?>
	<div id="ajax-message">
	<?php
		if(Yii::app()->user->hasFlash('error'))
			echo $this->flashMessage(Yii::app()->user->getFlash('error'), 'error');
		if(Yii::app()->user->hasFlash('success'))
			echo $this->flashMessage(Yii::app()->user->getFlash('success'), 'success');
	?>
	</div>
	<?php //begin.Messages ?>

	<div class="boxed">
		<?php //begin.Grid Item ?>
		<?php 
			$columnData   = $columns;
			array_push($columnData, array(
				'header' => Yii::t('phrase', 'Options'),
				'class' => 'CButtonColumn',
				'buttons' => array(
					'view' => array(
						'label' => 'view',
						'imageUrl' => Yii::app()->params['grid-view']['buttonImageUrl'],
						'options' => array(
							'class' => 'view'
						),
						'url' => 'Yii::app()->controller->createUrl(\'view\', array(\'id\'=>$data->primaryKey))'),
					'update' => array(
						'label' => 'update',
						'imageUrl' => Yii::app()->params['grid-view']['buttonImageUrl'],
						'options' => array(
							'class' => 'update',
						),
						'url' => 'Yii::app()->controller->createUrl(\'edit\', array(\'id\'=>$data->primaryKey))'),
					'delete' => array(
						'label' => 'delete',
						'imageUrl' => Yii::app()->params['grid-view']['buttonImageUrl'],
						'options' => array(
							'class' => 'delete',
						),
						'url' => 'Yii::app()->controller->createUrl(\'delete\', array(\'id\'=>$data->primaryKey))')
				),
				'template' => '{view}|{update}|{delete}',
			));

			$this->widget('application.libraries.yii-traits.system.OGridView', array(
				'id'=>'ommu-languages-grid',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'columns'=>$columnData,
				'template'=>Yii::app()->params['grid-view']['gridTemplate'],
				'pager'=>array('header'=>''),
				'afterAjaxUpdate'=>'reinstallDatePicker',
			));
		?>
		<?php //end.Grid Item ?>
	</div>
</div>

<?php if($setting->site_type == 1) {?>
<div class="form mt-15" name="post-on">

	<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
		'action' => Yii::app()->controller->createUrl('settings'),
		'id'=>'ommu-settings-form',
		'enableAjaxValidation'=>true,
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($setting); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
		<h3><?php echo Yii::t('phrase', 'Language Selection Settings');?></h3>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><span><?php echo Yii::t('phrase', 'If you have more than one language pack, do you want to allow your registered users to select which one will be used while they are logged in? If you select "Yes", users will be able to choose their language on the signup page and the account settings page. Note that this will only apply if you have more than one language pack.');?></span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($setting, 'lang_allow', array(
					1 => Yii::t('phrase', 'Yes, allow registered users to choose their own language.'),
					0 => Yii::t('phrase', 'No, do not allow registered users to save their language preference.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($setting,'lang_allow'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><span><?php echo Yii::t('phrase', 'If you have more than one language pack, do you want to display a select box on your homepage so that unregistered users can change the language in which they view the social network? Note that this will only apply if you have more than one language pack.');?></span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($setting, 'lang_anonymous', array(
					1 => Yii::t('phrase', 'Yes, display a select box that will allow unregistered users to change their language.'),
					0 => Yii::t('phrase', 'No, do not allow unregistered users to change the site language.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($setting,'lang_anonymous'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><span><?php echo Yii::t('phrase', 'If you have more than one language pack, do you want the system to autodetect the language settings from your visitors\' browsers? If you select "Yes", the system will attempt to detect what language the user has set in their browser settings. If you have a matching language, your site will display in that language, otherwise it will display in the default language.');?></span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->radioButtonList($setting, 'lang_autodetect', array(
					1 => Yii::t('phrase', 'Yes, attempt to detect the visitor\'s language based on their browser settings.'),
					0 => Yii::t('phrase', 'No, do not autodetect the visitor\'s language.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($setting,'lang_autodetect'); ?>
			</div>
		</div>

		<div class="form-group row submit">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">&nbsp;</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo CHtml::submitButton($setting->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>

</div>
<?php }?>




