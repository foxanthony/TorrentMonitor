<?php
$this->breadcrumbs=array(
	Yii::t('app','Subjects')=>array('index'),
	Yii::t('app','Add subject'),
);
?>

<h1><?php echo Yii::t('app','Add subject'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>