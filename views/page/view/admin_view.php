<?php
/**
 * Core Page Views (core-page-views)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\ViewController
 * @var $model ommu\core\models\CorePageViews
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 22:42 WIB
 * @modified date 31 January 2019, 16:39 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publication'), 'url' => ['page/admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['page/admin/index']];
$this->params['breadcrumbs'][] = ['label' => $model->page->title->message, 'url' => ['page/admin/view', 'id'=>$model->page_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Views'), 'url' => ['manage', 'page'=>$model->page_id]];
$this->params['breadcrumbs'][] = isset($model->user) ? $model->user->displayname : 'Anonymous'; ?>

<div class="core-page-views-view">

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		'view_id',
		[
			'attribute' => 'publish',
			'value' => $model->quickAction(Url::to(['publish', 'id'=>$model->primaryKey]), $model->publish),
			'format' => 'raw',
		],
		[
			'attribute' => 'pageName',
			'value' => function ($model) {
				$pageName = isset($model->page) ? $model->page->title->message : '-';
				if($pageName != '-')
					return Html::a($pageName, ['page/admin/view', 'id'=>$model->page_id], ['title'=>$pageName]);
				return $pageName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'userDisplayname',
			'value' => isset($model->user) ? $model->user->displayname : '-',
		],
		[
			'attribute' => 'views',
			'value' => function ($model) {
				$views = $model->views;
				return Html::a($views, ['page/view-detail/manage', 'view'=>$model->primaryKey], ['title'=>Yii::t('app', '{count} views', ['count'=>$views])]);
			},
			'format' => 'html',
			'visible' => !$small,
		],
		[
			'attribute' => 'view_date',
			'value' => Yii::$app->formatter->asDatetime($model->view_date, 'medium'),
		],
		'view_ip',
		[
			'attribute' => 'deleted_date',
			'value' => Yii::$app->formatter->asDatetime($model->deleted_date, 'medium'),
		],
	],
]); ?>

</div>