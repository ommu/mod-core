<?php
/**
 * Ommu Settings (ommu-settings)
 * @var $this SettingsController
 * @var $model OmmuSettings
 * @var $form CActiveForm
 *
 * @author Putra Sudaryanto <putra@ommu.co>
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
		<?php if($model->site_type == 1) {?>
		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_username', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected YES, members will be given the option of choosing a unique profile address. If you select NO, their user id will be used in the URL instead.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_username', array(
					1 => Yii::t('phrase', 'Yes, allow members to choose a profile address.'),
					0 => Yii::t('phrase', 'No, do not allow profile addresses.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_username'); ?>
			</div>
		</div>
		<?php }?>

		<?php if($model->site_type == 1) {?>
		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_photo', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'Do you want your users to be able to upload a photo of themselves upon signup?');?></div>
				<?php echo $form->radioButtonList($model, 'signup_photo', array(
					1 => Yii::t('phrase', 'Yes, give users the option to upload a photo upon signup.'),
					0 => Yii::t('phrase', 'No, do not allow users to upload a photo upon signup.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_photo'); ?>
			</div>
		</div>
		<?php }?>

		<?php if($model->site_type == 1) {?>
		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_approve', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected YES, users will automatically be enabled when they signup. If you select NO, you will need to manually enable users through the View Users page. Users that are not enabled cannot login.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_approve', array(
					1 => Yii::t('phrase', 'Yes, enable users upon signup.'),
					0 => Yii::t('phrase', 'No, do not enable users upon signup.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_approve'); ?>
			</div>
		</div>
		<?php }?>

		<?php if($model->site_type == 1) {?>
		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_welcome', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'Send users a welcome email upon signup? If you have email verification activated, this email will be sent upon verification. You can modify this email on the System Emails page.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_welcome', array(
					1 => Yii::t('phrase', 'Yes, send users a welcome email.'),
					0 => Yii::t('phrase', 'No, do not send users a welcome email.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_welcome'); ?>
			</div>
		</div>
		<?php }?>

		<?php if($model->site_type == 1) {?>
		<div class="form-group row">
			<label class="col-form-label col-lg-3 col-md-3 col-sm-12"><?php echo $model->getAttributeLabel('signup_inviteonly');?> <span class="required">*</span></label>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'Do you want to turn off public signups and only allow invited users to signup? If yes, you can choose to have either admins and users invite new users, or just admins. If set to yes, an invite code will be required on the signup page.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_inviteonly', array(
					2 => Yii::t('phrase', 'Yes, admins and users must invite new users before they can signup.'),
					1 => Yii::t('phrase', 'Yes, admins must invite new users before they can signup.'),
					0 => Yii::t('phrase', 'No, disable the invite only feature.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_inviteonly'); ?>
				
				<div class="small-px"><?php echo Yii::t('phrase', 'Should each invite code be bound to each invited email address? If set to NO, anyone with a valid invite code can signup regardless of their email address. If set to YES, anyone with a valid invite code that matches an email address that was invited can signup.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_checkemail', array(
					1 => Yii::t('phrase', 'Yes, check that a user\'s email address was invited before accepting their invite code.'),
					0 => Yii::t('phrase', 'No, anyone with an invite code can signup, regardless of their email address.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_checkemail'); ?>
				
				<div class="small-px"><?php echo Yii::t('phrase', 'How many invites do users get when they signup? (If you want to give a particular user extra invites, you can do so via the View Users page. Please enter a number between 0 and 999 below.');?></div>
				<?php echo $form->textField($model,'signup_numgiven', array('class'=>'form-control')); ?>
				<?php echo Yii::t('phrase', 'invites are given to each user when they signup.');?>
				<?php echo $form->error($model,'signup_numgiven'); ?>
			</div>
		</div>
		<?php }?>

		<?php if($model->site_type == 1) {?>
		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_invitepage', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected YES, your users will be shown a page asking them to optionally invite one or more friends to signup. The "invite friends" feature is different from the "invite only" feature because "invite friends" simply sends an email to the invitee instead of sending them an actual invitation code. Because of this, you probably do not want to enable both "invite friends" and "invite only" features simultaneously.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_invitepage', array(
					1 => Yii::t('phrase', 'Yes, show invite friends page.'),
					0 => Yii::t('phrase', 'No, do not show invite friends page.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_invitepage'); ?>
			</div>
		</div>
		<?php }?>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_verifyemail', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'Force users to verify their email address before they can login? If set to YES, users will be sent an email with a verification link which they must click to activate their account.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_verifyemail', array(
					1 => Yii::t('phrase', 'Yes, verify email addresses.'),
					0 => Yii::t('phrase', 'No, do not verify email addresses.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_verifyemail'); ?>
			</div>
		</div>

		<?php if($model->site_type == 1) {?>
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
		<?php }?>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_random', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'If you have selected YES, a random password will be created for users when they signup. The password will be emailed to them upon the completion of the signup process. This is another method of verifying users\' email addresses.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_random', array(
					1 => Yii::t('phrase', 'Yes, generate random passwords and email to new users.'),
					0 => Yii::t('phrase', 'No, let users choose their own passwords.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_random'); ?>
			</div>
		</div>

		<?php if($model->site_type == 1) {?>
		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_terms', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'Note: If you have selected YES, users will be forced to click a checkbox during the signup process which signifies that they have read, understand, and agree to your terms of service. Enter your terms of service text in the field below. HTML is OK.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_terms', array(
					1 => Yii::t('phrase', 'No, users will not be shown a terms of service checkbox on signup.'),
					0 => Yii::t('phrase', 'Yes, make users agree to your terms of service on signup.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_terms'); ?>
			</div>
		</div>
		<?php }?>

		<div class="form-group row">
			<?php echo $form->labelEx($model,'signup_adminemail', array('class'=>'col-form-label col-lg-3 col-md-3 col-sm-12')); ?>
			<div class="col-lg-6 col-md-9 col-sm-12">
				<div class="small-px"><?php echo Yii::t('phrase', 'Send Admin and email when a new user signs up? If set to YES, admin will be recieve an email with information about new user.');?></div>
				<?php echo $form->radioButtonList($model, 'signup_adminemail', array(
					1 => Yii::t('phrase', 'Yes, notify admin by email.'),
					0 => Yii::t('phrase', 'No, do not notify admin by email.'),
				), array('class'=>'form-control')); ?>
				<?php echo $form->error($model,'signup_adminemail'); ?>
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