<?php
/**
 * MetaController
 * @var $this ommu\core\controllers\MetaController
 * @var $model ommu\core\models\CoreMeta
 *
 * MetaController implements the CRUD actions for CoreMeta model.
 * Reference start
 * TOC :
 *	Index
 *	Update
 *	Google
 *	Facebook
 *	Twitter
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 OMMU (www.ommu.id)
 * @created date 24 April 2018, 14:11 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\core\models\CoreMeta;
use ommu\core\models\search\CoreMeta as CoreMetaSearch;

class MetaController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all CoreMeta models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		return $this->redirect(['update']);
	}

	/**
	 * Creates a new CoreMeta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionUpdate()
	{
		$model = CoreMeta::findOne(1);
		if ($model === null) 
			$model = new CoreMeta();
		$model->scenario = CoreMeta::SCENARIO_SETTING;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Meta setting success updated.'));
				return $this->redirect(['update']);
				//return $this->redirect(['view', 'id' => $model->id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Meta Settings');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new CoreMeta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionGoogle()
	{
		$model = CoreMeta::findOne(1);
		if ($model === null) 
			$model = new CoreMeta();
		$model->scenario = CoreMeta::SCENARIO_GOOGLE;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Google owner meta success updated.'));
				return $this->redirect(['google']);
				//return $this->redirect(['view', 'id' => $model->id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Meta Setting: {meta-name}', array('meta-name'=>'Google Owner'));
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_google', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new CoreMeta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionFacebook()
	{
		$model = CoreMeta::findOne(1);
		if ($model === null) 
			$model = new CoreMeta();
		$model->scenario = CoreMeta::SCENARIO_FACEBOOK;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Facebook meta success updated.'));
				return $this->redirect(['facebook']);
				//return $this->redirect(['view', 'id' => $model->id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Meta Setting: {meta-name}', array('meta-name'=>'Facebook'));
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_facebook', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new CoreMeta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionTwitter()
	{
		$model = CoreMeta::findOne(1);
		if ($model === null) 
			$model = new CoreMeta();
		$model->scenario = CoreMeta::SCENARIO_TWITTER;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Twitter meta success updated.'));
				return $this->redirect(['twitter']);
				//return $this->redirect(['view', 'id' => $model->id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Meta Setting: {meta-name}', array('meta-name'=>'Twitter'));
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_twitter', [
			'model' => $model,
		]);
	}

	/**
	 * Creates a new CoreMeta model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionAddress()
	{
		$model = CoreMeta::findOne(1);
		if ($model === null) 
			$model = new CoreMeta();
		$model->scenario = CoreMeta::SCENARIO_ADDRESS;

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);
			// $model->order = $postData['order'] ? $postData['order'] : 0;

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Address success updated.'));
				return $this->redirect(['facebook']);
				//return $this->redirect(['view', 'id' => $model->id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Meta Setting: {meta-name}', array('meta-name'=>'Address'));
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_address', [
			'model' => $model,
		]);
	}

	/**
	 * Finds the CoreMeta model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreMeta the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CoreMeta::findOne($id)) !== null) 
			return $model;
		else
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
