<?php
$this->breadcrumbs=array(
	'Subjects'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List Subject','url'=>array('index')),
	array('label'=>'Create Subject','url'=>array('create')),
	array('label'=>'Update Subject','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Subject','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Subject','url'=>array('admin')),
);
?>

<h1>View Subject #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'url',
		'title',
		'last_updated',
		'tracker',
		'torrent_id',
	),
)); ?>
