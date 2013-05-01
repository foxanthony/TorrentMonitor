<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<?php Yii::app()->bootstrap->register(); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',array(
    'fixed'=>null,
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'items'=>array(
                array('label'=>Yii::t('view_layouts_main','Topics'), 'url'=>array('/topic/index'), 'visible'=>!Yii::app()->user->isGuest),
                array('label'=>Yii::t('view_layouts_main','Login'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>Yii::t('view_layouts_main','Logout ({alias})', array('{alias}'=>Yii::app()->user->name)), 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        ),
    ),
)); ?>

<div class="container">

<?php if(isset($this->breadcrumbs)):?>
	<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
)); ?>
<?php endif?>

<?php echo $content; ?>

</div>
</body>
</html>
