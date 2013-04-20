<?php
$this->breadcrumbs=array(
	Yii::t('view_subject_create','Subjects')=>array('index'),
	Yii::t('view_subject_create','Add subject'),
);
?>

<h1><?php echo Yii::t('view_subject_create','Add subject'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>