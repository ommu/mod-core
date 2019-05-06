<?php
/**
 * ProvinceController
 * @var $this app\components\View
 * @var $model ommu\core\models\CoreZoneProvince
 *
 * ProvinceController implements the CRUD actions for CoreZoneProvince model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
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
 * @created date 8 September 2017, 15:02 WIB
 * @modified date 30 January 2019, 17:13 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\controllers\zone;

use Yii;
use app\components\Controller;
use yii\filters\VerbFilter;
use mdm\admin\components\AccessControl;
use ommu\core\models\CoreZoneProvince;
use ommu\core\models\search\CoreZoneProvince as CoreZoneProvinceSearch;
use ommu\core\models\view\CoreZoneProvince as CoreZoneProvinceView;

class ProvinceController extends Controller
{
	/**
	 * {@inheritdoc}
	 */
	public function init()
	{
		parent::init();
		$this->subMenu = $this->module->params['zone_submenu'];
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
	 * Lists all CoreZoneProvince models.
	 * @return mixed
	 */
	public function actionManage()
	{
		$searchModel = new CoreZoneProvinceSearch();
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

		if(($country = Yii::$app->request->get('country')) != null)
			$country = \ommu\core\models\CoreZoneCountry::findOne($country);

		$this->view->title = Yii::t('app', 'Provinces');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'country' => $country,
		]);
	}

	/**
	 * Creates a new CoreZoneProvince model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new CoreZoneProvince();

		if(Yii::$app->request->isPost) {
			$model->load(Yii::$app->request->post());
			// $postData = Yii::$app->request->post();
			// $model->load($postData);

			if($model->save()) {
				Yii::$app->session->setFlash('success', Yii::t('app', 'Province success created.'));
				return $this->redirect(['manage']);
				//return $this->redirect(['view', 'id'=>$model->province_id]);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Create Province');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_create', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing CoreZoneProvince model.
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
				Yii::$app->session->setFlash('success', Yii::t('app', 'Province success updated.'));
				return $this->redirect(['manage']);

			} else {
				if(Yii::$app->request->isAjax)
					return \yii\helpers\Json::encode(\app\components\widgets\ActiveForm::validate($model));
			}
		}

		$this->view->title = Yii::t('app', 'Update Province: {province-name}', ['province-name' => $model->province_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_update', [
			'model' => $model,
		]);
	}

	/**
	 * Displays a single CoreZoneProvince model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail Province: {province-name}', ['province-name' => $model->province_name]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CoreZoneProvince model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

		if($model->save(false, ['publish','modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Province success deleted.'));
			return $this->redirect(['manage']);
		}
	}

	/**
	 * actionPublish an existing CoreZoneProvince model.
	 * If publish is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionPublish($id)
	{
		$model = $this->findModel($id);
		$replace = $model->publish == 1 ? 0 : 1;
		$model->publish = $replace;

		if($model->save(false, ['publish','modified_id'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Province success updated.'));
			return $this->redirect(['manage']);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function actionSuggest()
	{
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

		$term = Yii::$app->request->get('query');
		$countryId = Yii::$app->request->get('cid', null);
		$extend = Yii::$app->request->get('extend', null);
		
		$model = CoreZoneProvince::find()
			->alias('t')
			->where(['like', 't.province_name', $term]);
		if($countryId != null)
			$model->andWhere(['t.country_id' => $countryId]);
		$model = $model->published()->limit(15)->all();
		
		$result = [];
		$i = 0;
		foreach($model as $val) {
			if($extend == null) {
				$result[] = [
					'id' => $val->province_id,
					'label' => $val->province_name, 
				];
			} else {
				$i++;
				$extendArray = array_map("trim", explode(',', $extend));
				$result[$i] = [
					'id' => $val->province_id,
					'label' => $join(', ', [$val->province_name, $val->country->country_name]), 
				];
				if(!empty($extendArray)) {
					if(in_array('province_name', $extendArray))
						$result[$i]['province_name'] = $val->province_name;
					if(in_array('country_id', $extendArray))
						$result[$i]['country_id'] = $val->country_id;
					if(in_array('country_name', $extendArray))
						$result[$i]['country_name'] = $val->country->country_name;
				} else
					$result[$i]['province_name'] =  $val->province_name;
			}
		}
		return $result;
	}

	/**
	 * Finds the CoreZoneProvince model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CoreZoneProvince the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CoreZoneProvince::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
