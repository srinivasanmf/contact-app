<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'Contacts App';
?>
<div class="site-index">
    <div class="body-content">
       <?php echo Html::a('Add Contact', array('/site/addcontact'), array('class' => 'btn btn-primary pull-right')); ?>
		<div class="clearfix"></div>
		<hr />
		<?php if($models != NULL): ?>
		<table class="table table-striped table-hover">
			<tr>
				<td>Name</td>
				<td>Email</td>
				<td>Subject</td>
				<td>Country</td>
				<td>State/Province</td>
				<td>Body</td>
				<td>Actions</td>
			</tr>
			<?php foreach ($models as $contact): ?>
				<tr>
					<td><?php echo $contact->name; ?></td>
					<td><?php echo $contact->email; ?></td>
					<td><?php echo $contact->subject; ?></td>
					<td><?php echo $contact->country; ?></td>
					<td><?php echo $contact->province; ?></td>
					<td><?php echo $contact->body; ?></td>
					<td>
						<?php echo Html::a('<i class="glyphicon glyphicon-edit"></i>', array('/site/addcontact', 'id'=>$contact->id)); ?>
						<?php echo Html::a('<i class="glyphicon glyphicon-trash"></i>', array('site/delete', 'id'=>$contact->id)); ?>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php endif; ?>
	</div>
</div>
