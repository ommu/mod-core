<?php
/**
 * Core Zone Districts (core-zone-district)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\zone\DistrictController
 * @var $model ommu\core\models\CoreZoneDistrict
 * @var $searchModel ommu\core\models\search\CoreZoneDistrict
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 15 September 2017, 10:26 WIB
 * @modified date 30 January 2019, 17:14 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;
use ommu\core\models\CoreZoneCountry;
use ommu\core\models\CoreZoneProvince;
use ommu\core\models\CoreZoneCity;

$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Add District'), 'url' => Url::to(['create']), 'icon' => 'plus-square'],
	['label' => Yii::t('app', 'Countries'), 'url' => Url::to(['zone/country/index']), 'icon' => 'table'],
	['label' => Yii::t('app', 'Provinces'), 'url' => Url::to(['zone/province/index']), 'icon' => 'table'],
	['label' => Yii::t('app', 'Cities'), 'url' => Url::to(['zone/city/index']), 'icon' => 'table'],
	['label' => Yii::t('app', 'Districts'), 'url' => Url::to(['zone/district/index']), 'icon' => 'table'],
	['label' => Yii::t('app', 'Villages'), 'url' => Url::to(['zone/village/index']), 'icon' => 'table'],
];
$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
];
?>

<div class="core-zone-district-manage">
<?php Pjax::begin(); ?>

<?php if($country != null) {
$model = $countries;
echo DetailView::widget([
	'model' => $countries,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'country_name',
			'value' => function ($model) {
				return Html::a($model->country_name, ['zone/country/view', 'id'=>$model->country_id], ['title'=>$model->country_name]);
			},
			'format' => 'html',
		],
		'code',
	],
]);
}?>

<?php if($province != null) {
$model = $provinces;
echo DetailView::widget([
	'model' => $provinces,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'province_name',
			'value' => function ($model) {
				return Html::a($model->province_name, ['zone/province/view', 'id'=>$model->province_id], ['title'=>$model->province_name]);
			},
			'format' => 'html',
		],
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
	],
]);
}?>

<?php if($city != null) {
$model = $cities;
echo DetailView::widget([
	'model' => $cities,
	'options' => [
		'class'=>'table table-striped detail-view',
	],
	'attributes' => [
		[
			'attribute' => 'city_name',
			'value' => function ($model) {
				return Html::a($model->city_name, ['zone/city/view', 'id'=>$model->city_id], ['title'=>$model->city_name]);
			},
			'format' => 'html',
		],
		[
			'attribute' => 'provinceName',
			'value' => function ($model) {
				$provinceName = isset($model->province) ? $model->province->province_name : '-';
				if($provinceName != '-')
					return Html::a($provinceName, ['zone/province/view', 'id'=>$model->province_id], ['title'=>$provinceName]);
				return $provinceName;
			},
			'format' => 'html',
		],
		[
			'attribute' => 'countryName',
			'value' => function ($model) {
				$countryName = isset($model->province->country) ? $model->province->country->country_name : '-';
				if($countryName != '-')
					return Html::a($countryName, ['zone/country/view', 'id'=>$model->province->country_id], ['title'=>$countryName]);
				return $countryName;
			},
			'format' => 'html',
		],
		'mfdonline',
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
			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'Detail District')]);
		},
		'update' => function ($url, $model, $key) {
			$url = Url::to(ArrayHelper::merge(['update', 'id'=>$model->primaryKey], Yii::$app->request->get()));
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update District')]);
		},
		'delete' => function ($url, $model, $key) {
			$url = Url::to(['delete', 'id'=>$model->primaryKey]);
			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'title' => Yii::t('app', 'Delete District'),
				'data-confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
				'data-method'  => 'post',
			]);
		},
	],
	'template' => '{view}{update}{delete}',
]);

echo GridView::widget([
	'dataProvider' => $dataProvider,
	'filterModel' => $searchModel,
	'layout' => '<div class="row"><div class="col-sm-12">{items}</div></div><div class="row sum-page"><div class="col-sm-5">{summary}</div><div class="col-sm-7">{pager}</div></div>',
	'columns' => $columnData,
]); ?>

<?php Pjax::end(); ?>
</div>