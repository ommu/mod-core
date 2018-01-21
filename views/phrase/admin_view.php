<?php
/**
 * Source Messages (source-message)
 * @var $this PhraseController
 * @var $model SourceMessage
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (opensource.ommu.co)
 * @created date 21 January 2018, 07:20 WIB
 * @link http://opensource.ommu.co
 *
 */

	$this->breadcrumbs=array(
		'Source Messages'=>array('manage'),
		$model->id,
	);
?>

<div class="dialog-content">
<?php $this->widget('application.libraries.core.components.system.FDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'name'=>'id',
			'value'=>$model->id,
		),
		array(
			'name'=>'category',
			'value'=>$model->category ? $model->category : '-',
		),
		array(
			'name'=>'message',
			'value'=>$model->message ? $model->message : '-',
			'type'=>'raw',
		),
		array(
			'name'=>'location',
			'value'=>$model->location ? $model->location : '-',
		),
		array(
			'name'=>'creation_date',
			'value'=>!in_array($model->creation_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->creation_date, true) : '-',
		),
		array(
			'name'=>'creation_id',
			'value'=>$model->creation_id ? $model->creation->displayname : '-',
		),
		array(
			'name'=>'modified_date',
			'value'=>!in_array($model->modified_date, array('0000-00-00 00:00:00','1970-01-01 00:00:00')) ? Utility::dateFormat($model->modified_date, true) : '-',
		),
		array(
			'name'=>'modified_id',
			'value'=>$model->modified_id ? $model->modified->displayname : '-',
		),
	),
)); ?>
</div>
<div class="dialog-submit">
	<?php echo CHtml::button(Yii::t('phrase', 'Close'), array('id'=>'closed')); ?>
</div>