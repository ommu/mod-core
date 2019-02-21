<?php
/**
 * Core Page Views (core-page-views)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\ViewController
 * @var $model ommu\core\models\CorePageViews
 * @var $searchModel ommu\core\models\search\CorePageViews
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 22:42 WIB
 * @modified date 31 January 2019, 16:39 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\widgets\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use ommu\core\models\CorePages;
use ommu\users\models\Users;

$this->params['breadcrumbs'][] = $this->title;

if($page != null) {
	$this->params['menu']['content'] = [
		['label' => Yii::t('app', 'Back To Pages'), 'url' => Url::to(['page/admin/index']), 'icon' => 'table'],
	];
}
$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
];
?>

<div class="core-page-views-manage">
<?php Pjax::begin(); ?>

<?php if($page != null) {
$model = $pages;
echo DetailView::widget([
	'model' => $pages,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'name_i',
			'value' => function ($model) {
				if($model->name_i != '')
					return Html::a($model->name_i, ['page/admin/view', 'id'=>$model->page_id], ['title'=>$model->name_i]);
				return $model->name_i;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'creation_date',
			'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
		],
		[
			'attribute' => 'creationDisplayname',
			'value' => isset($model->creation) ? $model->creation->displayname : '-',
		],
	],
]);
}?>

<?php if($user != null) {
$model = $users;
echo DetailView::widget([
	'model' => $users,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'enabled',
			'value' => Users::getEnabled($model->enabled),
		],
		[
			'attribute' => 'verified',
			'value' => $model->verified == 1 ? Yii::t('app', 'Verified') : Yii::t('app', 'Unverified'),
		],
		[
			'attribute' => 'levelName',
			'value' => isset($model->level) ? $model->level->title->message : '-',
		],
		'email:email',
		[
			'attribute' => 'lastlogin_date',
			'value' => Yii::$app->formatter->asDatetime($model->lastlogin_date, 'medium'),
		],
	],
]);
}?>

<?php //echo $this->render('_search', ['model'=>$searchModel]); ?>

<?php echo $this->render('_option_form', ['model'=>$searchModel, 'gridColumns'=>$this->activeDefaultColumns($columns), 'route'=>$this->context->route]); ?>

<?php 
$columnData = $columns;
array_push($columnData, [
	'class' => 'yii\grid\ActionColumn',
	'header' => Yii::t('app', 'Option'),
	'contentOptions' => [
		'class'=>'action-column',
	],
	'buttons' => [
		'view' => function ($url, $model, $key) {
			$url = Url::to(ArrayHelper::merge(['view', 'id'=>$model->primaryKey], Yii::$app->request->get()));
			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'Detail View')]);
		},
		'update' => function ($url, $model, $key) {
			$url = Url::to(ArrayHelper::merge(['update', 'id'=>$model->primaryKey], Yii::$app->request->get()));
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update View')]);
		},
		'delete' => function ($url, $model, $key) {
			$url = Url::to(['delete', 'id'=>$model->primaryKey]);
			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'title' => Yii::t('app', 'Delete View'),
				'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
				'data-method'  => 'post',
			]);
		},
	],
	'template' => '{view}{delete}',
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'layout' => '<div class="row"><div class="col-sm-12">{items}</div></div><div class="row sum-page"><div class="col-sm-5">{summary}</div><div class="col-sm-7">{pager}</div></div>',
	'columns' => $columnData,
]); ?>

<?php Pjax::end(); ?>
</div>