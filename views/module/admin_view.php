<?php
/**
 * Modules (modules)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\ModuleController
 * @var $model ommu\core\models\Modules
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 26 December 2017, 09:41 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Url;
use yii\widgets\DetailView;

if(!$small) {
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Development Tools'), 'url' => ['module/manage']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Modules'), 'url' => ['manage']];
$this->params['breadcrumbs'][] = $model->module_id;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->module_id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
} ?>

<div class="modules-view">

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		'id',
		'module_id',
		[
			'attribute' => 'installed',
			'value' => $model->filterYesNo($model->installed),
		],
		[
			'attribute' => 'enabled',
			'value' => $model->getEnableCondition($model->enabled, $model->module_id) ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
		],
		[
			'attribute' => 'creation_date',
			'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
			'visible' => !$small,
		],
		[
			'attribute' => 'creationDisplayname',
			'value' => isset($model->creation) ? $model->creation->displayname : '-',
			'visible' => !$small,
		],
		[
			'attribute' => 'modified_date',
			'value' => Yii::$app->formatter->asDatetime($model->modified_date, 'medium'),
			'visible' => !$small,
		],
		[
			'attribute' => 'modifiedDisplayname',
			'value' => isset($model->modified) ? $model->modified->displayname : '-',
			'visible' => !$small,
		],
	],
]); ?>

</div>