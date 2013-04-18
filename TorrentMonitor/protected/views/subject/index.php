<?php
$this->breadcrumbs=array(
	'Subjects',
);

$this->menu=array(
	array('label'=>Yii::t('app','Add subject'),'url'=>array('create'))
);
?>

<h1>Subjects</h1>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>Yii::t('app','Add subject'),
    'type'=>'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'normal',
    'url'=> array('/subject/create') // null, 'large', 'small' or 'mini'
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'columns'=>array(
        array('name'=>'title', 'header'=>'Title'),
        array('name'=>'url', 'header'=>'URL'),
        array('name'=>'tracker', 'header'=>'Tracker'),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>

