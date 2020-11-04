<?php
/**
 * Core Page View Histories (core-page-view-history)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\page\ViewDetailController
 * @var $model ommu\core\models\CorePageViewHistory
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
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Publication'), 'url' => ['page/admin/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['page/admin/index']];
$this->params['breadcrumbs'][] = ['label' => $model->view->page->title->message, 'url' => ['page/admin/view', 'id'=>$model->view->page_id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Views'), 'url' => ['page/view/manage', 'page'=>$model->view->page_id]];
$this->params['breadcrumbs'][] = ['label' => isset($model->view->user) ? $model->view->user->displayname : 'Anonymous', 'url' => ['page/view-detail/manage', 'view'=>$model->view_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Histories'); ?>

<div class="core-page-view-history-view">

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		'id',
		[
			'attribute' => 'pageName',
			'value' => function ($model) {
				$pageName = isset($model->view->page) ? $model->view->page->title->message : '-';
                if ($pageName != '-') {
                    return Html::a($pageName, ['page/admin/view', 'id'=>$model->view_id], ['title'=>$pageName]);
                }
				return $pageName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'userDisplayname',
			'value' => isset($model->view->user) ? $model->view->user->displayname : '-',
		],
		[
			'attribute' => 'view_date',
			'value' => Yii::$app->formatter->asDatetime($model->view_date, 'medium'),
		],
		'view_ip',
	],
]); ?>

</div>