<?php
/**
 * WallController
 * @var $this WallController
 * @var $model OmmuWalls
 * @var $form CActiveForm
 *
 * Reference start
 * TOC :
 *	Index
 *	Manage
 *	Edit
 *	View
 *	Runaction
 *	Delete
 *	Publish
 *	Post
 *	Get
 *
 *	LoadModel
 *	performAjaxValidation
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2015 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 *----------------------------------------------------------------------------------------------------------
 */

class WallController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';
	public $defaultAction = 'index';

	/**
	 * Initialize admin page theme
	 */
	public function init() 
	{
		if(!Yii::app()->user->isGuest) {
			if(in_array(Yii::app()->user->level, array(1,2))) {
				$arrThemes = $this->currentTemplate('admin');
				Yii::app()->theme = $arrThemes['folder'];
				$this->layout = $arrThemes['layout'];
				$this->applyViewPath(__dir__, false);
			}
		} else
			$this->redirect(Yii::app()->createUrl('site/login'));
	}

	/**
	 * @return array action filters
	 */
	public function filters() 
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() 
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('post','get'),
				'users'=>array('@'),
				'expression'=>'in_array(Yii::app()->user->level, array(1,2))',
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','manage','edit','view','runaction','delete','publish'),
				'users'=>array('@'),
				'expression'=>'Yii::app()->user->level == 1',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex() 
	{
		$this->redirect(array('manage'));
	}

	/**
	 * Manages all models.
	 */
	public function actionManage() 
	{
		$model=new OmmuWalls('search');
		$model->unsetAttributes();	// clear any default values
		if(isset($_GET['OmmuWalls'])) {
			$model->attributes=$_GET['OmmuWalls'];
		}

		$columns = $model->getGridColumn($this->gridColumnTemp());

		$this->pageTitle = 'Ommu Walls Manage';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_manage', array(
			'model'=>$model,
			'columns' => $columns,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionEdit($id) 
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['OmmuWalls'])) {
			$model->attributes=$_POST['OmmuWalls'];
			
			$jsonError = CActiveForm::validate($model);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($model->save()) {
						echo CJSON::encode(array(
							'type' => 5,
							'get' => Yii::app()->controller->createUrl('manage'),
							'id' => 'partial-ommu-walls',
							'msg' => '<div class="errorSummary success"><strong>OmmuWalls success updated.</strong></div>',
						));
					} else {
						print_r($model->getErrors());
					}
				}
			}
			Yii::app()->end();
		}
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;
	
		$this->pageTitle = 'Update Ommu Walls';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_edit', array(
			'model'=>$model,
		));
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id) 
	{
		$model=$this->loadModel($id);
		
		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 600;

		$this->pageTitle = 'View Ommu Walls';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_view', array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionRunaction() {
		$id	   = $_POST['trash_id'];
		$criteria = null;
		$actions  = Yii::app()->getRequest()->getParam('action');

		if(count($id) > 0) {
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $id);

			if($actions == 'publish') {
				OmmuWalls::model()->updateAll(array(
					'publish' => 1,
				),$criteria);
			} elseif($actions == 'unpublish') {
				OmmuWalls::model()->updateAll(array(
					'publish' => 0,
				),$criteria);
			} elseif($actions == 'trash') {
				OmmuWalls::model()->updateAll(array(
					'publish' => 2,
				),$criteria);
			} elseif($actions == 'delete') {
				OmmuWalls::model()->deleteAll($criteria);
			}
		}

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!Yii::app()->getRequest()->getParam('ajax')) {
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('manage'));
		}
	}
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id) 
	{
		$model=$this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest) {
			// we only allow deletion via POST request
			$model->publish = 2;
			
			if($model->update()) {
				echo CJSON::encode(array(
					'type' => 5,
					'get' => Yii::app()->controller->createUrl('manage'),
					'id' => 'partial-ommu-walls',
					'msg' => '<div class="errorSummary success"><strong>OmmuWalls success deleted.</strong></div>',
				));
			}
			Yii::app()->end();
		}

		$this->dialogDetail = true;
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage');
		$this->dialogWidth = 350;

		$this->pageTitle = 'OmmuWalls Delete.';
		$this->pageDescription = '';
		$this->pageMeta = '';
		$this->render('admin_delete');
	} 

	/** 
	 * Deletes a particular model. 
	 * If deletion is successful, the browser will be redirected to the 'admin' page. 
	 * @param integer $id the ID of the model to be deleted 
	 */ 
	public function actionPublish($id)  
	{ 
		$model=$this->loadModel($id);
		
		$title = $model->publish == 1 ? Yii::t('phrase', 'Deactived') : Yii::t('phrase', 'Actived');
		$replace = $model->publish == 1 ? 0 : 1;

		if(Yii::app()->request->isPostRequest) { 
			// we only allow deletion via POST request 
			//change value active or publish 
			$model->publish = $replace;

			if($model->update()) {
				echo CJSON::encode(array( 
					'type' => 5, 
					'get' => Yii::app()->controller->createUrl('manage'), 
					'id' => 'partial-ommu-walls', 
					'msg' => '<div class="errorSummary success"><strong>OmmuWalls success published.</strong></div>', 
				)); 
			} 
			Yii::app()->end();
		}

		$this->dialogDetail = true; 
		$this->dialogGroundUrl = Yii::app()->controller->createUrl('manage'); 
		$this->dialogWidth = 350; 

		$this->pageTitle = $title; 
		$this->pageDescription = ''; 
		$this->pageMeta = ''; 
		$this->render('admin_publish', array( 
			'title'=>$title, 
			'model'=>$model, 
		));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPost() 
	{
		$data=new OmmuWalls;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($data);

		if(isset($_POST['OmmuWalls'])) {
			$data->attributes=$_POST['OmmuWalls'];
			
			$jsonError = CActiveForm::validate($data);
			if(strlen($jsonError) > 2) {
				echo $jsonError;

			} else {
				if(Yii::app()->getRequest()->getParam('enablesave') == 1) {
					if($data->save()) {
						echo CJSON::encode(array(
							'type' => 3,
							'idclass' => '#admin .wall .list-view .items.wall',
							'value' => 0,
							'data' => Utility::otherDecode($this->renderPartial('_view', array('data'=>$data), true, false)),
						));
					} else {
						print_r($data->getErrors());
					}
				}
			}
			Yii::app()->end();
			
		} else
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
	}
	
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionGet() 
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria=new CDbCriteria; 
			$criteria->condition = 'publish = :publish'; 
			$criteria->params = array(':publish'=>1); 
			$criteria->order = 'creation_date DESC'; 

			$dataProvider = new CActiveDataProvider('OmmuWalls', array( 
				'criteria'=>$criteria, 
				'pagination'=>array( 
					'pageSize'=>5, 
				), 
			));
			
			$data = '';
			$wall = $dataProvider->getData();
			if(!empty($wall)) {
				foreach($wall as $key => $item) {
					$data .= Utility::otherDecode($this->renderPartial('_view', array('data'=>$item), true, false));
				}
			}
			$pager = OFunction::getDataProviderPager($dataProvider);
			if($pager[nextPage] != '0') {
				$summaryPager = 'Displaying 1-'.($pager[currentPage]*$pager[pageSize]).' of '.$pager[itemCount].' results.';
			} else {
				$summaryPager = 'Displaying 1-'.$pager[itemCount].' of '.$pager[itemCount].' results.';
			}
			$nextPager = $pager['nextPage'] != 0 ? Yii::app()->controller->createUrl('get', array($pager['pageVar']=>$pager['nextPage'])) : 0;
			
			$return = array(
				'type'=>0,
				'data'=>$data,
				'pager'=>$pager,
				'summarypager'=>$summaryPager,
				'nextpage'=>$nextPager,
			);
			echo CJSON::encode($return);
			
		} else
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id) 
	{
		$model = OmmuWalls::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, Yii::t('phrase', 'The requested page does not exist.'));
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model) 
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ommu-walls-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
