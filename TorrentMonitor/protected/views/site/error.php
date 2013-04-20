<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - ' . Yii::t('views_site_error','Error');
$this->breadcrumbs=array(
	Yii::t('views_site_error','Error'),
);
?>

<h2>Error <?php echo $code; ?></h2>

<div class="error">
<?php echo CHtml::encode($message); ?>
</div>