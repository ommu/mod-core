<?php
/**
 * Core Languages (core-languages)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\LanguageController
 * @var $model ommu\core\models\CoreLanguages
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 08:40 WIB
 * @modified date 22 March 2019, 17:18 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Languages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Detail'), 'url' => Url::to(['view', 'id'=>$model->language_id]), 'icon' => 'eye'],
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->language_id]), 'icon' => 'pencil'],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->language_id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post'], 'icon' => 'trash'],
];
?>

<div class="core-languages-view">

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		'language_id',
		[
			'attribute' => 'actived',
			'value' => $this->quickAction(Url::to(['actived', 'id'=>$model->primaryKey]), $model->actived, 'Enable,Disable'),
			'format' => 'raw',
		],
		[
			'attribute' => 'default',
			'value' => $this->quickAction(Url::to(['default', 'id'=>$model->primaryKey]), $model->default, 'Yes,No', true),
			'format' => 'raw',
		],
		'code',
		'name',
		[
			'attribute' => 'creation_date',
			'value' => Yii::$app->formatter->asDatetime($model->creation_date, 'medium'),
		],
		[
			'attribute' => 'creationDisplayname',
			'value' => isset($model->creation) ? $model->creation->displayname : '-',
		],
		[
			'attribute' => 'modified_date',
			'value' => Yii::$app->formatter->asDatetime($model->modified_date, 'medium'),
		],
		[
			'attribute' => 'modifiedDisplayname',
			'value' => isset($model->modified) ? $model->modified->displayname : '-',
		],
		[
			'attribute' => 'updated_date',
			'value' => Yii::$app->formatter->asDatetime($model->updated_date, 'medium'),
		],
		[
			'attribute' => 'users',
			'value' => function ($model) {
				$users = $model->getUsers(true);
				return Html::a($users, ['/users/member/index', 'language'=>$model->primaryKey], ['title'=>Yii::t('app', '{count} users', ['count'=>$users])]);
			},
			'format' => 'html',
		],
	],
]); ?>

</div>