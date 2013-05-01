<?php
$this->breadcrumbs=array(
	Yii::t('view_topic_create','Topics')=>array('index'),
	Yii::t('view_topic_create','Add topic'),
);
?>

<h1><?php echo Yii::t('view_topic_create','Add topic'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>