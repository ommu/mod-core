<?php
/**
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2013 Ommu Platform (opensource.ommu.co)
 * @link https://github.com/ommu/ommu-core
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
?>