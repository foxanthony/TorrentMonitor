<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'subject-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('views_subject__form','Fields with {asterisk} are required.', array('{asterisk}' => '<span class="required">*</span>'));?></p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? Yii::t('views_subject__form','Add') : Yii::t('views_subject__form','Save'),
		)); ?>
	</div>

<?php $this->endWidget(); ?>
