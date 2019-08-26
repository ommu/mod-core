<?php
/**
 * ViewController
 * @var $this ommu\core\controllers\page\ViewController
 * @var $model ommu\core\models\CorePageViews
 *
 * ViewController implements the CRUD actions for CorePageViews model.
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	View
 *	Delete
 *	RunAction
 *	Publish
 *
 *	findModel
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2017 OMMU (www.ommu.co)
 * @created date 2 October 2017, 22:42 WIB
 * @modified date 31 January 2019, 16:39 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

namespace ommu\core\controllers\page;

use Yii;
use yii\filters\VerbFilter;
use app\components\Controller;
use mdm\admin\components\AccessControl;
use ommu\core\models\CorePageViews;
use ommu\core\models\search\CorePageViews as CorePageViewsSearch;

class ViewController extends Controller
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
	public function actionIndex()
	{
		return $this->redirect(['manage']);
	}

	/**
	 * Lists all CorePageViews models.
	 * @return mixed
	 */
	public function actionManage()
	{
		$searchModel = new CorePageViewsSearch();
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

		if(($page = Yii::$app->request->get('page')) != null)
			$page = \ommu\core\models\CorePages::findOne($page);
		if(($user = Yii::$app->request->get('user')) != null)
			$user = \ommu\users\models\Users::findOne($user);

		$this->view->title = Yii::t('app', 'Views');
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->render('admin_manage', [
			'searchModel' => $searchModel,
			'dataProvider' => $dataProvider,
			'columns' => $columns,
			'page' => $page,
			'user' => $user,
		]);
	}

	/**
	 * Displays a single CorePageViews model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		$model = $this->findModel($id);

		$this->view->title = Yii::t('app', 'Detail View: {page-id}', ['page-id' => $model->page->title->message]);
		$this->view->description = '';
		$this->view->keywords = '';
		return $this->oRender('admin_view', [
			'model' => $model,
		]);
	}

	/**
	 * Deletes an existing CorePageViews model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$model = $this->findModel($id);
		$model->publish = 2;

		if($model->save(false, ['publish'])) {
			Yii::$app->session->setFlash('success', Yii::t('app', 'Page view success deleted.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage']);
		}
	}

	/**
	 * actionPublish an existing CorePageViews model.
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
			Yii::$app->session->setFlash('success', Yii::t('app', 'Page view success updated.'));
			return $this->redirect(Yii::$app->request->referrer ?: ['manage']);
		}
	}

	/**
	 * Finds the CorePageViews model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return CorePageViews the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if(($model = CorePageViews::findOne($id)) !== null)
			return $model;

		throw new \yii\web\NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
	}
}
