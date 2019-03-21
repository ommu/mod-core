<?php
/**
 * CountryController
 * @var $this app\components\View
 * @var $model ommu\core\models\CoreZoneCountry
 *
 * CountryController implements the CRUD actions for CoreZoneCountry model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Create
 *	Update
 *	View
 *	Delete
 *	Suggest
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 8 September 2017, 11:45 WIB
 * @modified date 30 January 2019, 17:12 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\controllers\zone;

use Yii;
use yii\filters\VerbFilter;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\core\models\CoreZoneCountry;
use ommu\core\models\search\CoreZoneCountry as CoreZoneCountrySearch;

class CountryController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		parent::init();
		$this->subMenu = $this->module->params['config']['zone_submenu'];
	}

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
	 * {@inheritdoc}
	 */
	public function allowAction(): array {
		return ['suggest'];
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
		return $this->redirect(['manage']);
	}

	/**
	 * Lists all CoreZoneCountry models.
	 * @return mixed
	 */
	public function actionManage()
	{
		$searchModel = new CoreZoneCountrySearch();
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

		$this->view->title = Yii::t('app', 'Countries');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
		]);
	}

	/**
	 * Creates a new CoreZoneCountry model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CoreZoneCountry();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Country success created.'));
				return $this->redirect(['manage']);
				//return $this->redirect(['view', 'id'=>$model->country_id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Create Country');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing CoreZoneCountry model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);
		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Country success updated.'));
				return $this->redirect(['manage']);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Update {model-class}: {country-name}', ['model-class' => 'Country', 'country-name' => $model->country_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single CoreZoneCountry model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail {model-class}: {country-name}', ['model-class' => 'Country', 'country-name' => $model->country_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CoreZoneCountry model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		
		Yii::$app->session->setFlash('success', Yii::t('app', 'Country success deleted.'));
		return $this->redirect(['manage']);
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionSuggest()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$term = Yii::$app->request->get('term');
		$model = CoreZoneCountry::find()
			->where(['like', 'country_name', $term])
			->limit(15)
			->all();

		$result = [];
		foreach($model as $val) {
			$result[] = [
				'id' => $val->country_id,
				'label' => trim($val->country_name), 
			];
		}
		return $result;
	}

	/**
	 * Finds the CoreZoneCountry model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreZoneCountry the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CoreZoneCountry::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
