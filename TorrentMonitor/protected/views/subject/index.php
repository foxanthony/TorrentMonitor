<?php
$this->breadcrumbs=array(
	Yii::t('views_subject_index','Subjects'),
);
?>

<h1><?php echo Yii::t('views_subject_index','Subjects');?></h1>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>Yii::t('views_subject_index','Add subject'),
    'type'=>'primary',
    'size'=>'normal',
    'url'=> array('/subject/create')
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'title'),
        array('name'=>'url'),
        array('name'=>'tracker'),
        array('name'=>'last_updated'),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
	    'template'=>'{delete}',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>

