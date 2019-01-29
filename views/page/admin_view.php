<?php
/**
 * Core Pages (core-pages)
 * @var $this yii\web\View
 * @var $this ommu\core\controllers\PageController
 * @var $model ommu\core\models\CorePages
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 16:31 WIB
 * @modified date 23 April 2018, 10:07 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Back To Manage'), 'url' => Url::to(['index']), 'icon' => 'table'],
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id' => $model->page_id]), 'icon' => 'pencil'],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id' => $model->page_id]), 'confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'method'=>'post', 'icon' => 'trash'],
];
?>

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'publish',
			'value' => $model->publish == 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
		],
		[
			'attribute' => 'name_i',
			'value' => isset($model->title) ? $model->title->message : '-',
		],
		[
			'attribute' => 'desc_i',
			'value' => isset($model->description) ? $model->description->message : '-',
			'format' => 'html',
		],
		[
			'attribute' => 'quote_i',
			'value' => isset($model->quoteRltn) ? $model->quoteRltn->message : '-',
		],
		[
			'attribute' => 'media',
			'value' => $model->media ? $model->media : '-',
			'format' => 'html',
		],
		[
			'attribute' => 'media_show',
			'value' => $model->media_show == 1 ? Yii::t('app', 'Yes') : Yii::t('app', 'No'),
		],
		[
			'attribute' => 'media_type',
			'value' => $model->media_type == 0 ? Yii::t('app', 'Small') : ($model->media_type == 1 ? Yii::t('app', 'Medium') : Yii::t('app', 'Large')),
		],
		[
			'attribute' => 'creation_date',
			'value' => !in_array($model->creation_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->creation_date, 'datetime') : '-',
		],
		[
			'attribute' => 'creation_search',
			'value' => isset($model->creation) ? $model->creation->displayname : '-',
		],
		[
			'attribute' => 'modified_date',
			'value' => !in_array($model->modified_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->modified_date, 'datetime') : '-',
		],
		[
			'attribute' => 'modified_search',
			'value' => isset($model->modified) ? $model->modified->displayname : '-',
		],
		[
			'attribute' => 'updated_date',
			'value' => !in_array($model->updated_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->updated_date, 'datetime') : '-',
		],
		[
			'attribute' => 'slug',
			'value' => $model->slug ? $model->slug : '-',
		],
	],
]) ?>