<?php
/**
 * Ommu Menus (ommu-menu)
 * @var $this MenuController
 * @var $model OmmuMenus
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2016 Ommu Platform (www.ommu.co)
 * @created date 24 March 2016, 10:20 WIB
 * @link https://github.com/ommu/mod-core
 *
 */

    $cs = Yii::app()->getClientScript();
$js=<<<EOP
    $('form[name="gridoption"] :checkbox').click(function(){
        var url = $('form[name="gridoption"]').attr('action');
        $.ajax({
            url: url,
            data: $('form[name="gridoption"] :checked').serialize(),
            success: function(response) {
                $.fn.yiiGridView.update('support-feedback-user-grid', {
                    data: $('form[name="gridoption"]').serialize()
                });
                return false;
            }
        });
    });
EOP;
    $cs->registerScript('grid-option', $js, CClientScript::POS_END);
?>

<?php echo CHtml::beginForm(Yii::app()->createUrl($this->route), 'get', array(
	'name' => 'gridoption',
));
$columns   = array();
$exception = array('id');
foreach($model->metaData->columns as $key => $val) {
	if(!in_array($key, $exception)) {
		$columns[$key] = $key;
	}
}
?>
<ul>
	<?php foreach($columns as $val): ?>
	<li>
		<?php echo CHtml::checkBox('GridColumn['.$val.']'); ?>
		<?php echo CHtml::label($val, 'GridColumn_'.$val); ?>
	</li>
	<?php endforeach; ?>
</ul>
<?php echo CHtml::endForm(); ?>
