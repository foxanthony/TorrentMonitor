<?php /* Topic updation error */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($title); ?>
</title>
</head>
<body>
<p><?php echo CHtml::encode(Yii::t('mail','Error has been occured during topic updation: `{message}`',array('{message}'=>$model->getMessage()))); ?></p>
<p>Stack trace:</p>
<pre><?php echo CHtml::encode($model->getTraceAsString()); ?></pre>
</body>
</html>