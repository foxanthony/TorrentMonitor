<?php /* `Topic updated` e-mail template */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo CHtml::encode($title); ?></title>
</head>
<body>
<p><?php echo CHtml::encode(Yii::t('mail','Topic `{topic}` has been updated at {timestamp}.',array('{topic}' => $model->title,'{timestamp}' => $model->formatLastUpdated()))); ?></p>
</body>
</html>