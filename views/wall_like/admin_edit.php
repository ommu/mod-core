<?php
/**
 * Ommu Wall Likes (ommu-wall-likes)
 * @var $this WalllikeController
 * @var $model OmmuWallLikes
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Wall Likes'=>array('manage'),
		$model->like_id=>array('view','id'=>$model->like_id),
		'Update',
	);
?>

<div class="form">
	<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>
