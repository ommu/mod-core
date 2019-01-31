<?php
/**
 * TagController
 * @var $this app\components\View
 * @var $model ommu\core\models\CoreTags
 *
 * TagController implements the CRUD actions for CoreTags model.
 * Reference start
 * TOC :
 *	Index
 *	Create
 *	Update
 *	View
 *	Delete
 *	RunAction
 *	Publish
 *	Suggest
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 00:14 WIB
 * @modified date 24 April 2018, 11:53 WIB
 * @link https://github.com/ommu/mod-core
 *
 */
 
namespace ommu\core\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\core\models\CoreTags;
use ommu\core\models\search\CoreTags as CoreTagsSearch;
use yii\helpers\Inflector;

class TagController extends Controller
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
					'publish' => ['POST'],
				],
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function allowAction(): array {
		return ['suggest'];
	}

	/**
	 * Lists all CoreTags models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new CoreTagsSearch();
		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

		$gridColumn = Yii::$app->request->get('GridColumn', null);
		$cols = [];
		if($gridColumn != null && count($gridColumn) > 0) {
			foreach($gridColumn as $key => $val) {
				if($gridColumn[$key] == 1)
					$cols[] = $key;
			}
		}
		$columns = $searchModel->getGridColumn($cols);

		$this->view->title = Yii::t('app', 'Tags');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
		]);
	}

	/**
	 * Creates a new CoreTags model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CoreTags();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Tag success created.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->tag_id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Create Tag');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing CoreTags model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Tag success updated.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->tag_id]);
			}
		}

		$this->view->title = Yii::t('app', 'Update {model-class}: {body}', ['model-class' => 'Tag', 'body' => $model->body]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single CoreTags model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail {model-class}: {body}', ['model-class' => 'Tag', 'body' => $model->body]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CoreTags model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

		if($model->save(false, ['publish'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Tag success deleted.'));
			return $this->redirect(['index']);
			//return $this->redirect(['view', 'id' => $model->tag_id]);
		}
	}

	/**
	 * actionPublish an existing CoreTags model.
	 * If publish is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionPublish($id)
	{
		$model = $this->findModel($id);
		$replace = $model->publish == 1 ? 0 : 1;
		$model->publish = $replace;

		if($model->save(false, ['publish'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Tag success updated.'));
			return $this->redirect(['index']);
		}
	}

	public function actionSuggest() 
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$term = Yii::$app->request->get('term');
		$layout = Yii::$app->request->get('layout', 0);
		if($term == null) return [];

		$model = CoreTags::find()->where(['like', 'body', $term])
			->published()->limit(15)->all();

		$result = [];
		foreach($model as $val) {
			$labelName = Inflector::id2camel($val->body);
			$labelName = Inflector::camel2words($labelName);
			if($layout == 1) {
				$result[] = ['label' => $labelName, 'value' => $val->tag_id, 'label_tag' => $val->body];
			}else {
				$result[] = ['label' => $val->body, 'value' => $val->tag_id];
			}
		}
		return $result;
	}

	/**
	 * Finds the CoreTags model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreTags the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CoreTags::findOne($id)) !== null) 
			return $model;
		else
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
