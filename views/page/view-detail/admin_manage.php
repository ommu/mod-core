<?php
/**
 * Core Page View Histories (core-page-view-history)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\ViewDetailController
 * @var $model ommu\core\models\CorePageViewHistory
 * @var $searchModel ommu\core\models\search\CorePageViewHistory
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.id)
 * @created date 2 October 2017, 23:05 WIB
 * @modified date 31 January 2019, 16:39 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\DetailView;
use ommu\core\models\CorePageViews;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publication'), 'url' => ['page/admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['page/admin/index']];
if($view != null) {
	$this->params['breadcrumbs'][] = ['label' => $view->page->title->message, 'url' => ['page/admin/view', 'id'=>$view->page_id]];
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Views'), 'url' => ['page/view/manage', 'page'=>$view->page_id]];
	$this->params['breadcrumbs'][] = ['label' => isset($view->user) ? $view->user->displayname : 'Anonymous', 'url' => ['page/view-detail/manage', 'view'=>$view->view_id]];
}
$this->params['breadcrumbs'][] = Yii::t('app', 'Histories');

$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
];
?>

<div class="core-page-view-history-manage">
<?php Pjax::begin(); ?>

<?php if($view != null) {
$model = $view;
echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'pageName',
			'value' => function ($model) {
				$pageName = isset($model->page) ? $model->page->title->message : '-';
				if($pageName != '-')
					return Html::a($pageName, ['page/admin/view', 'id'=>$model->page_id], ['title'=>$pageName, 'class'=>'modal-btn']);
				return $pageName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'userDisplayname',
			'value' => isset($model->user) ? $model->user->displayname : '-',
		],
		[
			'attribute' => 'view_date',
			'value' => Yii::$app->formatter->asDatetime($model->view_date, 'medium'),
		],
		'view_ip',
	],
]);
}?>

<?php //echo $this->render('_search', ['model'=>$searchModel]); ?>

<?php echo $this->render('_option_form', ['model'=>$searchModel, 'gridColumns'=>$searchModel->activeDefaultColumns($columns), 'route'=>$this->context->route]); ?>

<?php
$columnData = $columns;
array_push($columnData, [
	'class' => 'app\components\grid\ActionColumn',
	'header' => Yii::t('app', 'Option'),
	'urlCreator' => function($action, $model, $key, $index) {
		if($action == 'view')
			return Url::to(['view', 'id'=>$key]);
		if($action == 'update')
			return Url::to(['update', 'id'=>$key]);
		if($action == 'delete')
			return Url::to(['delete', 'id'=>$key]);
	},
	'buttons' => [
		'view' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title'=>Yii::t('app', 'Detail'), 'class'=>'modal-btn']);
		},
		'update' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title'=>Yii::t('app', 'Update'), 'class'=>'modal-btn']);
		},
		'delete' => function ($url, $model, $key) {
			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'title' => Yii::t('app', 'Delete'),
				'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
				'data-method'  => 'post',
			]);
		},
	],
	'template' => '{view} {delete}',
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'columns' => $columnData,
]); ?>

<?php Pjax::end(); ?>
</div>