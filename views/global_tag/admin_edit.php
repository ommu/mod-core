<?php
/**
 * Ommu Tags (ommu-tags)
 * @var $this GlobaltagController
 * @var $model OmmuTags
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Tags'=>array('manage'),
		$model->tag_id=>array('view','id'=>$model->tag_id),
		Yii::t('phrase', 'Update'),
	);
?>

<?php echo $this->renderPartial('/global_tag/_form', array(
	'model'=>$model,
)); ?>
	