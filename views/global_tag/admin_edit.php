<?php
/**
 * Ommu Tags (ommu-tags)
 * @var $this GlobaltagController
 * @var $model OmmuTags
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Tags'=>array('manage'),
		$model->tag_id=>array('view','id'=>$model->tag_id),
		'Update',
	);
?>

<?php echo $this->renderPartial('/global_tag/_form', array(
	'model'=>$model,
)); ?>
	