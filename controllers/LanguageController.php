<?php
/**
 * LanguageController
 * @var $this yii\web\View
 * @var $model ommu\core\models\CoreLanguages
 *
 * LanguageController implements the CRUD actions for CoreLanguages model.
 * Reference start
 * TOC :
 *	Index
 *	Create
 *	Update
 *	View
 *	Delete
 *	Actived
 *	Default
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 08:40 WIB
 * @modified date 23 April 2018, 14:05 WIB
 * @link https://github.com/ommu/mod-core
 *
 */
 
namespace ommu\core\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\core\models\CoreLanguages;
use ommu\core\models\search\CoreLanguages as CoreLanguagesSearch;

class LanguageController extends Controller
{
	/**
	 * @inheritdoc
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
					'actived' => ['POST'],
					'default' => ['POST'],
				],
			],
		];
	}

	/**
	 * Lists all CoreLanguages models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new CoreLanguagesSearch();
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

		$this->view->title = Yii::t('app', 'Languages');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
		]);
	}

	/**
	 * Creates a new CoreLanguages model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CoreLanguages();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Language success created.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->language_id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Create Language');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing CoreLanguages model.
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
				Yii::$app->session->setFlash('success', Yii::t('app', 'Language success updated.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->language_id]);
			}
		}

		$this->view->title = Yii::t('app', 'Update {model-class}: {name}', ['model-class' => 'Language', 'name' => $model->name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single CoreLanguages model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail {model-class}: {name}', ['model-class' => 'Language', 'name' => $model->name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CoreLanguages model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		
		Yii::$app->session->setFlash('success', Yii::t('app', 'Language success deleted.'));
		return $this->redirect(['index']);
	}

	/**
	 * actionActived an existing CoreLanguages model.
	 * If actived is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionActived($id)
	{
		$model = $this->findModel($id);
		$replace = $model->actived == 1 ? 0 : 1;
		$model->actived = $replace;
		
		if($model->save(false, ['actived'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Language success updated.'));
			return $this->redirect(['index']);
		}
	}

	/**
	 * actionDefault an existing CoreLanguages model.
	 * If default is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDefault($id)
	{
		$model = $this->findModel($id);
		$model->default = 1;
		$model->actived = 1;
		
		if($model->save(false, ['default','actived'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Language success updated.'));
			return $this->redirect(['index']);
		}
	}

	/**
	 * Finds the CoreLanguages model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreLanguages the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CoreLanguages::findOne($id)) !== null) 
			return $model;
		else
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
