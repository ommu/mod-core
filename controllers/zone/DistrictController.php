<?php
/**
 * DistrictController
 * @var $this yii\web\View
 * @var $model ommu\core\models\CoreZoneDistrict
 *
 * DistrictController implements the CRUD actions for CoreZoneDistrict model.
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
 * @created date 15 September 2017, 10:26 WIB
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
use ommu\core\models\CoreZoneDistrict;
use ommu\core\models\search\CoreZoneDistrict as CoreZoneDistrictSearch;
use ommu\core\models\view\CoreZoneDistrict as CoreZoneDistrictView;

class DistrictController extends Controller
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
	 * Lists all CoreZoneDistrict models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new CoreZoneDistrictSearch();
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

		$this->view->title = Yii::t('app', 'Districts');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_index', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
		]);
	}

	/**
	 * Creates a new CoreZoneDistrict model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CoreZoneDistrict();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'District success created.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->district_id]);
			} 
		}

		$this->view->title = Yii::t('app', 'Create District');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing CoreZoneDistrict model.
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
				Yii::$app->session->setFlash('success', Yii::t('app', 'District success updated.'));
				return $this->redirect(['index']);
				//return $this->redirect(['view', 'id' => $model->district_id]);
			}
		}

		$this->view->title = Yii::t('app', 'Update {model-class}: {district-name}', ['model-class' => 'District', 'district-name' => $model->district_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single CoreZoneDistrict model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail {model-class}: {district-name}', ['model-class' => 'District', 'district-name' => $model->district_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CoreZoneDistrict model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

		if($model->save(false, ['publish'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'District success deleted.'));
			return $this->redirect(['index']);
			//return $this->redirect(['view', 'id' => $model->district_id]);
		}
	}

	/**
	 * actionPublish an existing CoreZoneDistrict model.
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
			Yii::$app->session->setFlash('success', Yii::t('app', 'District success updated.'));
			return $this->redirect(['index']);
		}
	}

	public function actionSuggest()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$term = Yii::$app->request->get('term');
		$cityId = Yii::$app->request->get('cid', null);
		$extend = Yii::$app->request->get('extend');
		
		$model = CoreZoneDistrict::find()->alias('t')
			->where(['like', 't.district_name', $term]);
		if($cityId != null)
			$model->andWhere(['t.city_id' => $cityId]);
		$model = $model->published()->limit(10)->all();

		$result = [];
		$i = 0;
		foreach($model as $val) {
			if($extend == null) {
				$result[] = [
					'label' => $val->district_name, 
					'value' => $val->district_id,
				];
			} else {
				$i++;
				$extendArray = array_map("trim", explode(',', $extend));
				$result[$i] = [
					'label' => join(', ', [$val->district_name, $val->city->city_name, $val->city->province->province_name, $val->city->province->country->country_name]), 
					'value' => $val->district_id,
				];
				if(!empty($extendArray)) {
					if(in_array('district_name', $extendArray))
						$result[$i]['district_name'] = $val->district_name;
					if(in_array('city_id', $extendArray))
						$result[$i]['city_id'] = $val->city_id;
					if(in_array('city_name', $extendArray))
						$result[$i]['city_name'] = $val->city->city_name;
					if(in_array('province_id', $extendArray))
						$result[$i]['province_id'] = $val->city->province_id;
					if(in_array('province_name', $extendArray))
						$result[$i]['province_name'] = $val->city->province->province_name;
					if(in_array('country_id', $extendArray))
						$result[$i]['country_id'] = $val->city->province->country_id;
					if(in_array('country_name', $extendArray))
						$result[$i]['country_name'] = $val->city->province->country->country_name;
				} else
					$result[$i]['district_name'] =  $val->district_name;
			}
		}
		return $result;
	}

	/**
	 * Finds the CoreZoneDistrict model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreZoneDistrict the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CoreZoneDistrict::findOne($id)) !== null) 
			return $model;
		else
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
