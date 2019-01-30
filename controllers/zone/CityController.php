<?php
/**
 * CityController
 * @var $this yii\web\View
 * @var $model ommu\core\models\CoreZoneCity
 *
 * CityController implements the CRUD actions for CoreZoneCity model.
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
 * @created date 14 September 2017, 22:22 WIB
 * @modified date 24 April 2018, 23:00 WIB
 * @link https://github.com/ommu/mod-core
 *
 */
 
namespace ommu\core\controllers\zone;

use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\core\models\CoreZoneCity;
use ommu\core\models\search\CoreZoneCity as CoreZoneCitySearch;
use ommu\core\models\view\CoreZoneCity as CoreZoneCityView;

class CityController extends Controller
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
	 * {@inheritdoc}
	 */
	public function actionIndex()
	{
		return $this->redirect(['manage']);
	}

	/**
	 * Lists all CoreZoneCity models.
	 * @return mixed
	 */
	public function actionManage()
	{
		$searchModel = new CoreZoneCitySearch();
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

		$this->view->title = Yii::t('app', 'Cities');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
		]);
	}

	/**
	 * Creates a new CoreZoneCity model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CoreZoneCity();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'City success created.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->city_id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Create City');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing CoreZoneCity model.
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
				Yii::$app->session->setFlash('success', Yii::t('app', 'City success updated.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->city_id]);
			}
		}

		$this->view->title = Yii::t('app', 'Update {model-class}: {city-name}', ['model-class' => 'City', 'city-name' => $model->city_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single CoreZoneCity model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail {model-class}: {city-name}', ['model-class' => 'City', 'city-name' => $model->city_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CoreZoneCity model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

		if($model->save(false, ['publish'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'City success deleted.'));
			return $this->redirect(['index']);
			//return $this->redirect(['view', 'id' => $model->city_id]);
		}
	}

	/**
	 * actionPublish an existing CoreZoneCity model.
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
			Yii::$app->session->setFlash('success', Yii::t('app', 'City success updated.'));
			return $this->redirect(['index']);
		}
	}

	public function actionSuggest()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$term = Yii::$app->request->get('term');
		$provinceId = Yii::$app->request->get('pid', null);
		$extend = Yii::$app->request->get('extend');
		
		$model = CoreZoneCity::find()->alias('t')
			->where(['like', 't.city_name', $term]);
		if($provinceId != null)
			$model->andWhere(['t.province_id' => $provinceId]);
		$model = $model->published()->limit(10)->all();

		$result = [];
		$i = 0;
		foreach($model as $val) {
			if($extend == null) {
				$result[] = [
					'label' => $val->city_name, 
					'value' => $val->city_id,
				];
			} else {
				$i++;
				$extendArray = array_map("trim", explode(',', $extend));
				$result[$i] = [
					'label' => join(', ', [$val->city_name, $val->province->province_name, $val->province->country->country_name]), 
					'value' => $val->city_id,
				];
				if(!empty($extendArray)) {
					if(in_array('city_name', $extendArray))
						$result[$i]['city_name'] = $val->city_name;
					if(in_array('province_id', $extendArray))
						$result[$i]['province_id'] = $val->province_id;
					if(in_array('province_name', $extendArray))
						$result[$i]['province_name'] = $val->province->province_name;
					if(in_array('country_id', $extendArray))
						$result[$i]['country_id'] = $val->province->country_id;
					if(in_array('country_name', $extendArray))
						$result[$i]['country_name'] = $val->province->country->country_name;
				} else
					$result[$i]['city_name'] =  $val->city_name;
			}
		}
		return $result;
	}

	/**
	 * Finds the CoreZoneCity model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreZoneCity the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CoreZoneCity::findOne($id)) !== null) 
			return $model;
		else
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
