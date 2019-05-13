<?php
/**
 * CorePageViews
 * 
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 22:41 WIB
 * @modified date 31 January 2019, 16:07 WIB
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
use yii\helpers\Html;
use yii\helpers\Url;
use ommu\users\models\Users;

class CorePageViews extends \app\components\ActiveRecord
{
	use \ommu\traits\UtilityTrait;

	public $gridForbiddenColumn = ['view_ip', 'deleted_date'];

	public $pageName;
	public $userDisplayname;

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
			'histories' => Yii::t('app', 'Histories'),
			'pageName' => Yii::t('app', 'Page'),
			'userDisplayname' => Yii::t('app', 'User'),
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getHistories($count=false)
	{
		if($count == false)
			return $this->hasMany(CorePageViewHistory::className(), ['view_id' => 'view_id']);

		$model = CorePageViewHistory::find()
			->where(['view_id' => $this->view_id]);
		$histories = $model->count();

		return $histories ? $histories : 0;
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
	 * {@inheritdoc}
	 * @return \ommu\core\models\query\CorePageViews the active query used by this AR class.
	 */
	public static function find()
	{
		return new \ommu\core\models\query\CorePageViews(get_called_class());
	}

	/**
	 * Set default columns to display
	 */
	public function init()
	{
		parent::init();

		$this->templateColumns['_no'] = [
			'header' => Yii::t('app', 'No'),
			'class' => 'yii\grid\SerialColumn',
			'contentOptions' => ['class'=>'center'],
		];
		if(!Yii::$app->request->get('page')) {
			$this->templateColumns['pageName'] = [
				'attribute' => 'pageName',
				'value' => function($model, $key, $index, $column) {
					return isset($model->page) ? $model->page->title->message : '-';
					// return $model->pageName;
				},
			];
		}
		if(!Yii::$app->request->get('user')) {
			$this->templateColumns['userDisplayname'] = [
				'attribute' => 'userDisplayname',
				'value' => function($model, $key, $index, $column) {
					return isset($model->user) ? $model->user->displayname : '-';
					// return $model->userDisplayname;
				},
			];
		}
		$this->templateColumns['view_date'] = [
			'attribute' => 'view_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->view_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'view_date'),
		];
		$this->templateColumns['view_ip'] = [
			'attribute' => 'view_ip',
			'value' => function($model, $key, $index, $column) {
				return $model->view_ip;
			},
		];
		$this->templateColumns['deleted_date'] = [
			'attribute' => 'deleted_date',
			'value' => function($model, $key, $index, $column) {
				return Yii::$app->formatter->asDatetime($model->deleted_date, 'medium');
			},
			'filter' => $this->filterDatepicker($this, 'deleted_date'),
		];
		$this->templateColumns['views'] = [
			'attribute' => 'views',
			'value' => function($model, $key, $index, $column) {
				$views = $model->views;
				return Html::a($views, ['page/view-detail/manage', 'view'=>$model->primaryKey], ['title'=>Yii::t('app', '{count} views', ['count'=>$views])]);
			},
			'filter' => false,
			'contentOptions' => ['class'=>'center'],
			'format' => 'html',
		];
		if(!Yii::$app->request->get('trash')) {
			$this->templateColumns['publish'] = [
				'attribute' => 'publish',
				'value' => function($model, $key, $index, $column) {
					$url = Url::to(['publish', 'id'=>$model->primaryKey]);
					return $this->quickAction($url, $model->publish);
				},
				'filter' => $this->filterYesNo(),
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
	 * {@inheritdoc}
	 */
	public static function insertView($page_id)
	{
		$user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
		
		$findView = self::find()
			->select(['view_id','views'])
			->where(['publish' => 1])
			->andWhere(['page_id' => $page_id]);
		if($user_id !== null)
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
	 * after find attributes
	 */
	public function afterFind()
	{
		parent::afterFind();

		// $this->pageName = isset($this->page) ? $this->page->title->message : '-';
		// $this->userDisplayname = isset($this->user) ? $this->user->displayname : '-';
	}

	/**
	 * before validate attributes
	 */
	public function beforeValidate()
	{
		if(parent::beforeValidate()) {
			if($this->isNewRecord) {
				if($this->user_id == null)
					$this->user_id = !Yii::$app->user->isGuest ? Yii::$app->user->id : null;
			}
			$this->view_ip = $_SERVER['REMOTE_ADDR'];
		}
		return true;
	}
}
