<?php
/**
 * Core Zone Provinces (core-zone-province)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\ProvinceController
 * @var $model ommu\core\models\CoreZoneProvince
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 8 September 2017, 15:02 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

if(!$small) {
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['/setting/update']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Zone'), 'url' => ['zone/country/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Provinces'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->province_name;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Update'), 'url' => Url::to(['update', 'id'=>$model->province_id]), 'icon' => 'pencil', 'htmlOptions' => ['class'=>'btn btn-primary']],
	['label' => Yii::t('app', 'Delete'), 'url' => Url::to(['delete', 'id'=>$model->province_id]), 'htmlOptions' => ['data-confirm'=>Yii::t('app', 'Are you sure you want to delete this item?'), 'data-method'=>'post', 'class'=>'btn btn-danger'], 'icon' => 'trash'],
];
} ?>

<div class="core-zone-province-view">

<?php echo DetailView::widget([
	'model' => $model,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		'province_id',
		[
			'attribute' => 'publish',
			'value' => $model->quickAction(Url::to(['publish', 'id'=>$model->primaryKey]), $model->publish),
			'format' => 'raw',
		],
		'province_name',
		[
			'attribute' => 'countryName',
			'value' => function ($model) {
				$countryName = isset($model->country) ? $model->country->country_name : '-';
				if($countryName != '-')
					return Html::a($countryName, ['zone/country/view', 'id'=>$model->country_id], ['title'=>$countryName]);
				return $countryName;
			},
			'format' => 'html',
		],
		'mfdonline',
		[
			'attribute' => 'checked',
			'value' => $model->filterYesNo($model->checked),
		],
		[
			'attribute' => 'cities',
			'value' => function ($model) {
				$cities = $model->getCities(true);
				return Html::a($cities, ['zone/city/manage', 'province'=>$model->primaryKey, 'publish'=>1], ['title'=>Yii::t('app', '{count} cities', ['count'=>$cities])]);
			},
			'format' => 'html',
			'visible' => !$small,
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
		[
			'attribute' => 'updated_date',
			'value' => Yii::$app->formatter->asDatetime($model->updated_date, 'medium'),
			'visible' => !$small,
		],
		[
			'attribute' => 'slug',
			'value' => $model->slug ? $model->slug : '-',
			'visible' => !$small,
		],
		[
			'attribute' => '',
			'value' => Html::a(Yii::t('app', 'Update'), ['update', 'id'=>$model->primaryKey], ['title'=>Yii::t('app', 'Update'), 'class'=>'btn modal-btn btn-primary']),
			'format' => 'html',
			'visible' => !$small && Yii::$app->request->isAjax ? true : false,
		],
	],
]); ?>

</div>