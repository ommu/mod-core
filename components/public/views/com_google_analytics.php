<?php
/**
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2013 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */
?>
<?php
	$cs = Yii::app()->getClientScript();
	$cs->registerScriptFile('https://www.googletagmanager.com/gtag/js?id='.$model->analytic_id, CClientScript::POS_END);
$js=<<<EOP
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());

	gtag('config', '$model->analytic_id');
EOP;
	$model->analytic == '1' ? $cs->registerScript('analytics', $js, CClientScript::POS_END) : '';

	if(Yii::app()->getRequest()->getParam('debug')) {
		echo '<pre>';
		print_r(Yii::$app)."\n\n";
		print_r(Yii::app());
	}
?>