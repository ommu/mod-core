<?php
/**
 * Ommu Settings (ommu-settings)
 * @var $this SettingsController
 * @var $model OmmuSettings
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@sudaryanto.id>
 * @contact (+62)856-299-4114
 * @copyright Copyright (c) 2012 Ommu Platform (www.ommu.co)
 * @link https://github.com/ommu/mod-core
 *
 */

	$this->breadcrumbs=array(
		'Ommu Settings'=>array('manage'),
		Yii::t('phrase', 'Manage'),
	);
?>

<div class="form" name="post-on">

	<?php $form=$this->beginWidget('application.libraries.yii-traits.system.OActiveForm', array(
		'id'=>'ommu-settings-form',
		'enableAjaxValidation'=>true,
	)); ?>

	<?php //begin.Messages ?>
	<div id="ajax-message">
		<?php echo $form->errorSummary($model); ?>
	</div>
	<?php //begin.Messages ?>

	<fieldset>
		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('banned_ips');?>
				<span><?php echo Yii::t('phrase', 'To ban users by their IP address, enter their address into the field below. Addresses should be separated by commas, like 123.456.789.123, 23.45.67.89');?></span>
			</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'banned_ips', array('rows'=>6, 'cols'=>50, 'class'=>'span-10', 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'banned_ips'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('banned_emails');?>
				<span><?php echo Yii::t('phrase', 'To ban users by their email address, enter their email into the field below. Emails should be separated by commas, like user1@domain1.com, user2@domain2.com. Note that you can ban all email addresses with a specific domain as follows: *@domain.com');?></span>
			</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'banned_emails', array('rows'=>6, 'cols'=>50, 'class'=>'span-10', 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'banned_emails'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('banned_usernames');?>
				<span><?php echo Yii::t('phrase', 'Enter the usernames that are not permitted on your social network. Usernames should be separated by commas, like username1, username2');?></span>
			</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'banned_usernames', array('rows'=>6, 'cols'=>50, 'class'=>'span-10', 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'banned_usernames'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">
				<?php echo $model->getAttributeLabel('banned_words');?>
				<span><?php echo Yii::t('phrase', 'Enter any words that you you want to censor on your users\' profiles as well as any plugins you have installed. These will be replaced with asterisks (*). Separate words by commas like word1, word2 ');?></span>
			</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textArea($model,'banned_words', array('rows'=>6, 'cols'=>50, 'class'=>'span-10', 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'banned_words'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'spam_signup', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected YES, an image containing a random sequence of 6 numbers will be shown to users on the signup page. Users will be required to enter these numbers into the Verification Code field before they can continue. This feature helps prevent users from trying to automatically create accounts on your system. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors or users cannot signup, try turning this off.');?></div>
				<?php echo $form->radioButtonList($model, 'spam_signup', array(
					1 => Yii::t('phrase', 'Yes, show verification code image.'),
					0 => Yii::t('phrase', 'No, do not show verification code image.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'spam_signup'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'spam_invite', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "invite" page. Users will be required to enter these numbers into the Verification Code field in order to send their invitation. This feature helps prevent users from trying to create comment spam. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.');?></div>
				<?php echo $form->radioButtonList($model, 'spam_invite', array(
					1 => Yii::t('phrase', 'Yes, enable validation code for inviting.'),
					0 => Yii::t('phrase', 'No, disable validation code for inviting.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'spam_invite'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('spam_login');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "login" page. Users will be required to enter these numbers into the Verification Code field in order to login. This feature helps prevent users from trying to spam the login form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.');?></div>
				<?php echo $form->radioButtonList($model, 'spam_login', array(
					1 => Yii::t('phrase', 'Yes, enable validation code for logging in.'),
					0 => Yii::t('phrase', 'No, disable validation code for logging in.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'spam_login'); ?>

				<div class="small-px"><?php echo Yii::t('phrase', 'If "no" is selected in the setting directly above, a Verification Code will be displayed to the user only after a certain number of failed logins. You can set this to 0 to never display a code.');?></div>
				<?php echo $form->textField($model,'spam_failedcount', array('class'=>'form-control')); ?>
				<?php echo Yii::t('phrase', 'failed logins');?>
				<?php echo $form->error($model,'spam_failedcount'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'spam_contact', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "contact" page. Users will be required to enter these numbers into the Verification Code field in order to contact you. This feature helps prevent users from trying to spam the contact form. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.');?></div>
				<?php echo $form->radioButtonList($model, 'spam_contact', array(
					1 => Yii::t('phrase', 'Yes, enable validation code for the contact form.'),
					0 => Yii::t('phrase', 'No, disable validation code for the contact form.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'spam_contact'); ?>
			</div>
		</div>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'spam_comment', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected Yes, an image containing a random sequence of 6 numbers will be shown to users on the "write a comment" page. Users will be required to enter these numbers into the Verification Code field in order to post their comment. This feature helps prevent users from trying to create comment spam. For this feature to work properly, your server must have the GD Libraries (2.0 or higher) installed and configured to work with PHP. If you are seeing errors, try turning this off.');?></div>
				<?php echo $form->radioButtonList($model, 'spam_comment', array(
					1 => Yii::t('phrase', 'Yes, enable validation code for commenting.'),
					0 => Yii::t('phrase', 'No, disable validation code for commenting.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'spam_comment'); ?>
			</div>
		</div>

		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('general_commenthtml');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo $form->textField($model,'general_commenthtml', array('maxlength'=>256, 'class'=>'form-control')); ?>
				<?php echo $form->error($model,'general_commenthtml'); ?>
				<div class="small-px"><?php echo Yii::t('phrase', 'By default, the user may not enter any HTML tags into comments. If you want to allow specific tags, you can enter them below (separated by commas). Example: b, img, a, embed, font');?></div>
			</div>
		</div>

		<div class="form-group row submit">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12">&nbsp;</label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('phrase', 'Create') : Yii::t('phrase', 'Save'), array('onclick' => 'setEnableSave()')); ?>
			</div>
		</div>

	</fieldset>
	<?php $this->endWidget(); ?>

</div>