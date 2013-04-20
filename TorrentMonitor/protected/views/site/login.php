<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('views_site_login','Login');
$this->breadcrumbs=array(
	Yii::t('views_site_login','Login'),
);
?>

<h1><?php echo Yii::t('views_site_login','Login'); ?></h1>

<p><?php echo Yii::t('views_site_login','Please fill out the following form with your login credentials:'); ?></p>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="help-block"><?php echo Yii::t('views_site_login','Fields with {asterisk} are required.', array('{asterisk}' => '<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'username',array('class'=>'span5','maxlength'=>255)); ?>
	<?php echo $form->passwordFieldRow($model,'password',array('class'=>'span5','maxlength'=>255)); ?>
	<?php echo $form->checkboxRow($model,'rememberMe'); ?>

	<div class="form-actions">
	    <?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>Yii::t('views_site_login_label','Login'),
	    )); ?>
	</div>

<?php $this->endWidget(); ?>
