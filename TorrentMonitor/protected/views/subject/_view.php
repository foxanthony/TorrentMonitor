<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
	<?php echo CHtml::encode($data->url); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('title')); ?>:</b>
	<?php echo CHtml::encode($data->title); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_updated')); ?>:</b>
	<?php echo CHtml::encode($data->last_updated); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tracker')); ?>:</b>
	<?php echo CHtml::encode($data->tracker); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('torrent_id')); ?>:</b>
	<?php echo CHtml::encode($data->torrent_id); ?>
	<br />


</div>