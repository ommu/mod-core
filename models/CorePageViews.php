<?php
/**
 * CorePageViews
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 22:41 WIB
 * @modified date 22 April 2018, 18:35 WIB
 * @link https://github.com/ommu/mod-core
 *
 * This is the model class for table "ommu_core_page_views".
 *
 * The followings are the available columns in table "ommu_core_page_views":
 * @property integer $view_id
 * @property integer $publish
 * @property integer $page_id
 * @property integer $user_id
 * @property integer $views
 * @property string $view_date
 * @property string $view_ip
 * @property string $deleted_date
 *
 * The followings are the available model relations:
 * @property CorePageViewHistory[] $histories
 * @property CorePages $page
 * @property Users $user
 *
 */

namespace ommu\core\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use ommu\users\models\Users;
use yii\web\HeadersAlreadySentException;

class CorePageViews extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['view_ip', 'deleted_date'];

	// Search Variable
	public $page_search;
	public $user_search;

	/**
	 * @return string the associated database table name
	 */
	public static function tableName()
	{
		return 'ommu_core_page_views';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return [
			[['page_id'], 'required'],
			[['publish', 'page_id', 'user_id', 'views'], 'integer'],
			[['user_id', 'view_date', 'view_ip', 'deleted_date'], 'safe'],
			[['view_ip'], 'string', 'max' => 20],
			[['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => CorePages::className(), 'targetAttribute' => ['page_id' => 'page_id']],
			[['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'user_id']],
		];
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'view_id' => Yii::t('app', 'View'),
			'publish' => Yii::t('app', 'Publish'),
			'page_id' => Yii::t('app', 'Page'),
			'user_id' => Yii::t('app', 'User'),
			'views' => Yii::t('app', 'Views'),
			'view_date' => Yii::t('app', 'View Date'),
			'view_ip' => Yii::t('app', 'View Ip'),
			'deleted_date' => Yii::t('app', 'Deleted Date'),
			'page_search' => Yii::t('app', 'Page'),
			'user_search' => Yii::t('app', 'User'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getHistories()
	{
		return $this->hasMany(CorePageViewHistory::className(), ['view_id' => 'view_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPage()
	{
		return $this->hasOne(CorePages::className(), ['page_id' => 'page_id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getUser()
	{
		return $this->hasOne(Users::className(), ['user_id' => 'user_id']);
	}

	/**
	 * Set default columns to display
	 */
	public function init() 
	{
		parent::init();

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class'  => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		if(!Yii::$app->request->get('page')) {
			$this->templateColumns['page_search'] = [
				'attribute' => 'page_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->page) ? $model->page->title->message : '-';
				},
			];
		}
		if(!Yii::$app->request->get('user')) {
			$this->templateColumns['user_search'] = [
				'attribute' => 'user_search',
				'value' => function($model, $key, $index, $column) {
					return isset($model->user) ? $model->user->displayname : '-';
				},
			];
		}
		$this->templateColumns['view_date'] = [
			'attribute' => 'view_date',
			'filter' => Html::input('date', 'view_date', Yii::$app->request->get('view_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->view_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->view_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		$this->templateColumns['view_ip'] = [
			'attribute' => 'view_ip',
			'value' => function($model, $key, $index, $column) {
				return $model->view_ip;
			},
		];
		$this->templateColumns['deleted_date'] = [
			'attribute' => 'deleted_date',
			'filter' => Html::input('date', 'deleted_date', Yii::$app->request->get('deleted_date'), ['class'=>'form-control']),
			'value' => function($model, $key, $index, $column) {
				return !in_array($model->deleted_date, ['0000-00-00 00:00:00','1970-01-01 00:00:00','0002-12-02 07:07:12','-0001-11-30 00:00:00']) ? Yii::$app->formatter->format($model->deleted_date, 'datetime') : '-';
			},
			'format' => 'html',
		];
		$this->templateColumns['views'] = [
			'attribute' => 'views',
			'value' => function($model, $key, $index, $column) {
				$url = Url::to(['page-history/index', 'view'=>$model->primaryKey]);
				return Html::a($model->views, $url);
			},
			'contentOptions' => ['class'=>'center'],
			'format'	=> 'html',
		];
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'filter' => $this->filterYesNo(),
				'value' => function($model, $key, $index, $column) {
					$url = Url::to(['publish', 'id'=>$model->primaryKey]);
					return $this->quickAction($url, $model->publish);
				},
				'contentOptions' => ['class'=>'center'],
				'format' => 'raw',
			];
		}
	}

	/**
	 * User get information
	 */
	public static function getInfo($id, $column=null)
	{
		if($column != null) {
			$model = self::find()
				->select([$column])
				->where(['view_id' => $id])
				->one();
			return $model->$column;
			
		} else {
			$model = self::findOne($id);
			return $model;
		}
	}

	/**
	 * User get information
	 */
	public static function insertView($page_id)
	{
		$user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
		
		$findView = self::find()
			->select(['view_id','publish','page_id','user_id','views'])
			->where(['publish' => 1])
			->andWhere(['page_id' => $page_id]);
		if($user_id != null)
			$findView->andWhere(['user_id' => $user_id]);
		else
			$findView->andWhere(['is', 'user_id', null]);
		$findView = $findView->one();
			
		if($findView !== null)
			$findView->updateAttributes(['views'=>$findView->views+1, 'view_ip'=>$_SERVER['REMOTE_ADDR']]);

		else {
			$view = new CorePageViews();
			$view->page_id = $page_id;
			$view->save();
		}
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate() 
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord)
				$this->user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			
			$this->view_ip = $_SERVER['REMOTE_ADDR'];
		}
		return true;
	}
}
