<?php
include_once '/model/functions.php';
$allGallery = getAllGalleries();
if(isset($_POST['delete'])){
	$id = $_POST['hidden'];
	if(deleteGallery($id)){
		echo '<h3><a href="' . $_SERVER['PHP_SELF'] . '?page=gallery&c=all' . '">Вернуться к списку галерей</a></h3>';
		echo '<h3>Галерея удалена!</h3>';
		exit();
	}
}
?>

<div class="col-md-12">
	<?php if(count($allGallery) == 0): ?>
		<div class="col-md-12 title">
			<h1>Список галерей пуст. Создайте галерею!</h1>
		</div>
		<div class="col-md-12 cr">
			<a class="btn btn-info link" href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=add">Создать новую галерею</a>
		</div>
	<?php else: ?>
		<div class="col-md-12 title">
			<h1>Список галерей</h1>
		</div>
		<div class="col-md-12 cr">
			<a class="btn btn-info link" href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=add">Создать новую галерею</a>
		</div>
		<div class="col-md-12">
			<table class="table table-hover table-bordered" id="table">
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Название</th>
						<th>Шорткод</th>
						<th>Операции</th>
					</tr>
				</thead>
				<tbody>
				<?php $count = 1; ?>
				<?php foreach($allGallery as $gallery): ?>
				<tr>
					<td><?= $count; ?></td>
					<td><?= $gallery['id'] ?></td>
					<td><?= $gallery['name'] ?></td>
					<td><?= $gallery['shortcode'] ?></td>
					<td>
						<a class="btn btn-primary link" href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=edit&id=<?= $gallery['id'] ?>">Редактировать</a><br/><br/>
						<form method="post">
							<input type="hidden" name="hidden" value="<?= $gallery['id'] ?>"/>
							<button name="delete" class="btn btn-inverse">Удалить</button>
						</form>
					</td>
				</tr>
				<?php $count++; ?>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>	
	<?php endif; ?>
</div>