<?php
/**
 * Core Tags (core-tags)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\TagController
 * @var $model ommu\core\models\CoreTags
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 00:14 WIB
 * @modified date 31 January 2019, 16:40 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->body, 'url' => ['view', 'id'=>$model->tag_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id'=>$model->tag_id]), 'icon' => 'eye', 'htmlOptions' => ['class'=>'btn btn-info btn-sm']],
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->tag_id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary btn-sm']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->tag_id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger btn-sm'], 'icon' => 'trash'],
];
?>

<div class="core-tags-update">

<?php echo $this->render('_form', [
	'model' => $model,
]); ?>

</div>