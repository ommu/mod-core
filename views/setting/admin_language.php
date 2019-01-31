<?php
/**
 * Core Settings (core-settings)
 * @var $this app\components\View
 * @var $this ommu\core\controllers\SettingController
 * @var $model ommu\core\models\CoreSettings
 * @var $form app\components\ActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 01:10 WIB
 * @modified date 23 April 2018, 18:49 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\ActiveForm;
use app\components\menu\MenuContent;
use app\components\menu\MenuOption;
use app\components\grid\GridView;
use app\components\Utility;
use yii\widgets\Pjax;

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Settings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->params['menu']['content'] = [
	['label' => Yii::t('app', 'Add Language'), 'url' => Url::to(['language/create']), 'icon' => 'plus-square'],
];
$this->params['menu']['option'] = [
	//['label' => Yii::t('app', 'Search'), 'url' => 'javascript:void(0);'],
	['label' => Yii::t('app', 'Grid Option'), 'url' => 'javascript:void(0);'],
];
?>

<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<?php if($this->params['menu']['content']):
			echo MenuContent::widget(['items' => $this->params['menu']['content']]);
			endif;?>
			<ul class="nav navbar-right panel_toolbox">
				<li><a href="#" title="<?php echo Yii::t('app', 'Toggle');?>" class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
				<?php if($this->params['menu']['option']):?>
				<li class="dropdown">
					<a href="#" title="<?php echo Yii::t('app', 'Options');?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
					<?php echo MenuOption::widget(['items' => $this->params['menu']['option']]);?>
				</li>
				<?php endif;?>
				<li><a href="#" title="<?php echo Yii::t('app', 'Close');?>" class="close-link"><i class="fa fa-close"></i></a></li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
<?php Pjax::begin(); ?>

<?php //echo $this->render('/language/_search', ['model'=>$searchModel]); ?>

<?php echo $this->render('/language/_option_form', ['model'=>$searchModel, 'gridColumns'=>$this->activeDefaultColumns($columns), 'route'=>$this->context->route]); ?>

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
			$url = Url::to(['language/view', 'id'=>$model->primaryKey]);
			return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, ['title' => Yii::t('app', 'Detail Language')]);
		},
		'update' => function ($url, $model, $key) {
			$url = Url::to(['language/update', 'id'=>$model->primaryKey]);
			return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['title' => Yii::t('app', 'Update Language')]);
		},
		'delete' => function ($url, $model, $key) {
			$url = Url::to(['language/delete', 'id'=>$model->primaryKey]);
			return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
				'title' => Yii::t('app', 'Delete Language'),
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
	</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12">
	<?php if(Yii::$app->session->hasFlash('success'))
		echo $this->flashMessage(Yii::$app->session->getFlash('success'));
	else if(Yii::$app->session->hasFlash('error'))
		echo $this->flashMessage(Yii::$app->session->getFlash('error'), 'danger');?>

	<div class="x_panel">
		<div class="x_content">
<?php $form = ActiveForm::begin([
	'enableClientValidation' => true,
	'enableAjaxValidation' => false,
	//'enableClientScript' => true,
]); ?>

<?php //echo $form->errorSummary($model);?>

<div class="form-group">
	<label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo Yii::t('app', 'Language Selection Settings');?></label>
	<div class="col-md-9 col-sm-9 col-xs-12">
		<?php  
		$lang_allow = [
			1 => Yii::t('app', 'Yes, allow registered users to choose their own language.'),
			0 => Yii::t('app', 'No, do not allow registered users to save their language preference.'),
		];
		echo $form->field($model, 'lang_allow', ['template' => '<span class="small-px mb-10">'.Yii::t('app', 'If you have more than one language pack, do you want to allow your registered users to select which one will be used while they are logged in? If you select "Yes", users will be able to choose their language on the signup page and the account settings page. Note that this will only apply if you have more than one language pack.').'</span>{input}{error}'])
			->radioList($lang_allow, ['class'=>'desc', 'separator' => '<br />'])
			->label($model->getAttributeLabel('lang_allow'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

		<?php 
		$lang_anonymous = [
			1 => Yii::t('app', 'Yes, display a select box that will allow unregistered users to change their language.'),
			0 => Yii::t('app', 'No, do not allow unregistered users to change the site language.'),
		];
		echo $form->field($model, 'lang_anonymous', ['template' => '<span class="small-px mb-10">'.Yii::t('app', 'If you have more than one language pack, do you want the system to autodetect the language settings from your visitors\' browsers? If you select "Yes", the system will attempt to detect what language the user has set in their browser settings. If you have a matching language, your site will display in that language, otherwise it will display in the default language.').'</span>{input}{error}'])
			->radioList($lang_anonymous, ['class'=>'desc', 'separator' => '<br />'])
			->label($model->getAttributeLabel('lang_anonymous'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

		<?php 
		$lang_autodetect = [
			1 => Yii::t('app', 'Yes, attempt to detect the visitor\'s language based on their browser settings.'),
			0 => Yii::t('app', 'No, do not autodetect the visitor\'s language.'),
		];
		echo $form->field($model, 'lang_autodetect', ['template' => '<span class="small-px mb-10">'.Yii::t('app', 'If you have more than one language pack, do you want to display a select box on your homepage so that unregistered users can change the language in which they view the social network? Note that this will only apply if you have more than one language pack.').'</span>{input}{error}'])
			->radioList($lang_autodetect, ['class'=>'desc', 'separator' => '<br />'])
			->label($model->getAttributeLabel('lang_autodetect'), ['class'=>'control-label col-md-3 col-sm-3 col-xs-12']); ?>

	</div>
</div>

<div class="ln_solid"></div>
<div class="form-group">
	<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
		<?php echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>
	</div>
</div>

<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>