<?php
$this->breadcrumbs=array(
	Yii::t('views_topic_index','Topics'),
);
?>

<h1><?php echo Yii::t('views_topic_index','Topics');?></h1>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>Yii::t('views_topic_index','Add topic'),
    'type'=>'primary',
    'size'=>'normal',
    'url'=> array('/topic/create')
)); ?>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'type'=>'striped',
    'dataProvider'=>$dataProvider,
    'template'=>"{items}",
    'columns'=>array(
	array(
	    'name'=>'icon',
	    'header'=>'',
	    'type'=>'raw',
	    'value'=>'Yii::app()->trackerManager->renderTrackerIcon($data->tracker);',
	    'htmlOptions'=>array('style'=>'width: 50px')
	),
        array('name'=>'title'),
        array('name'=>'url'),
        array('name'=>'tracker'),
        array(
	    'name'=>'last_updated',
	    'value'=>'Yii::app()->dateFormatter->formatDateTime($data->last_updated)'
	),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
	    'template'=>'{delete}',
            'htmlOptions'=>array('style'=>'width: 50px'),
        ),
    ),
)); ?>

