<?php
/**
 * Ommu Themes (ommu-themes)
 * @var $this ThemeController
 * @var $model OmmuThemes
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2018 Ommu Platform (www.ommu.co)
 * @created date 29 July 2018, 16:54 WIB
 * @link https://github.com/ommu/mod-core
 *
 */
?>

<?php
if($parent == false) {
	$globalConfig = array(
		'ga'=>array(
			'label'=>Yii::t('phrase', 'Google Analytic Rules'),
			'rules'=>'',
		),
		'site-controller'=>array(
			'label'=>Yii::t('phrase', 'Site Controller "site/index"'),
			'view-render'=>array(
				'label'=>Yii::t('phrase', 'View Render From'),
				'option'=>array(
					'app'=>Yii::t('phrase', 'Application'),
					'theme'=>Yii::t('phrase', 'Theme'),
				),
			),
			'redirect'=>array(
				'label'=>Yii::t('phrase', 'Redirect'),
				'rules'=>'',
			),
		),
	);
	$config = array_merge($globalConfig, $config);
	$config['script'] = array(
		'label'=>Yii::t('phrase', 'Head Scripts/Styles'),
		'desc'=>Yii::t('phrase', 'Anything entered into the box below will be included at the bottom of the &lt;head&gt; tag. If you want to include a script or stylesheet, be sure to use the &lt;script&gt; or &lt;link&gt; tag.'),
	);
}
if(!empty($config)) {
	foreach($config as $key => $val) {
		if($parent == false) {?>
<div class="form-group row">
	<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo Yii::t('phrase', $val['label']);?></label>
	<div class="col-lg-9 col-md-9 col-sm-12">
<?php }
	if(is_array($val)) {
		if($parent == true) {
			$inputField = $inputField."[$key]";
			echo $form->dropDownList($model, $inputField, $val, array('prompt'=>'', 'class'=>'form-control'));
			
		} else {
			foreach($val as $a => $b) {
				if($a == 'label')
					continue;

				$inputField = "config[{$key}][{$a}]";
				if(is_array($val[$a])) {
					if($val[$a]['label'] == null)
						echo $form->dropDownList($model, $inputField, $val[$a], array('prompt'=>'', 'class'=>'form-control'));
					else {
						echo $this->renderPartial('_config_field', array(
							'form'=>$form,
							'model'=>$model,
							'config'=>$b,
							'inputField'=>$inputField,
							'parent'=>true,
						));
					}
				} else {
					if($a == 'publish') {
						$publish = array(
							'1'=>Yii::t('phrase', 'Publish'),
							'0'=>Yii::t('phrase', 'Unpublish'),
						);
						echo $form->dropDownList($model, $inputField, $publish, array('prompt'=>'', 'class'=>'form-control'));
					} else {
						if($a == 'desc')
							echo $form->textArea($model, $inputField, array('rows'=>6, 'cols'=>50, 'class'=>'form-control smaller', 'placeholder'=>$val[$a]));
						else
							echo $form->textField($model, $inputField, array('class'=>'form-control', 'placeholder'=>$val[$a]));
					}
				}
				echo $form->error($model, $inputField);
			}
		}
	} else {
		if($key == 'label') {?>
			<div class="mb-10"><?php echo Yii::t('phrase', $val);?></div>
		<?php } else {
			$inputField = $inputField."[$key]";
			if($key == 'publish') {
				$publish = array(
					'1'=>Yii::t('phrase', 'Publish'),
					'0'=>Yii::t('phrase', 'Unpublish'),
				);
				echo $form->dropDownList($model, $inputField, $publish, array('prompt'=>'', 'class'=>'form-control'));
			} else {
				if($key == 'desc')
					echo $form->textArea($model, $inputField, array('rows'=>6, 'cols'=>50, 'class'=>'form-control smaller', 'placeholder'=>$val));
				else
					echo $form->textField($model, $inputField, array('class'=>'form-control', 'placeholder'=>$val));
			}
		}
	}
if($parent == false) {?>
	</div>
</div>
<?php 	}
	}
}?>