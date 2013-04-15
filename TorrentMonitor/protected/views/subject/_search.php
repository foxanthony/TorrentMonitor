<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'url',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'last_updated',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'tracker',array('class'=>'span5','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'torrent_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
