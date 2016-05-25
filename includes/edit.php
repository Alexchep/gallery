<?php
include_once '/model/functions.php';
?>

<h3><a href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=all">Вернуться к списку галерей</a></h3>

<?php
$id = (int) $_GET['id'];
if ($id == 0) {
	exit('Неверный id!');
}
if (!empty($_POST)) {
	if (isset($_POST['save'])) {
		$gal_name = getGalleryByName($_POST['name']);
		if ($gal_name) {//Проверка на существование галереи с таким именем
			if (($gal_name['name'] == $_POST['name']) && $gal_name['id'] == $id) {//Если имя не изменилось - сохраняем
				if (editGallery($id, $_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
					echo '<h3>Успешно отредактировано!</h3>';
					exit();
				}
			} elseif ($gal_name['name'] == $_POST['name']) {
				echo "<h3>Галерея с таким названием уже существует!</h3><br/></br/><h3><a class='btn btn-warning link' href='?page=gallery&c=edit&id=$id'>Попробовать снова</a></h3>";
				exit();
			}
		} else {//Иначе сохраняем
			if (editGallery($id, $_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
				echo '<h3>Успешно отредактировано!</h3>';
				exit();
			}
			$name = $_POST['name'];
			$desc = $_POST['desc'];
			$img1 = $_POST['img1'];
			$img2 = $_POST['img2'];
			$img3 = $_POST['img3'];
		}
	}
} else {
	$gallery = getGalleryById($id);
	$name = $gallery['name'];
	$desc = $gallery['desc'];
	$img1 = $gallery['img1'];
	$img2 = $gallery['img2'];
	$img3 = $gallery['img3'];
}
?>

<div class="col-md-12">
	<div class="col-md-12 title">
		<h3>Редактирование:</h3>
	</div>
	<div class="col-md-12">
		<form method="post" class="edit_form" enctype="multipart/form-data">
			<label for="name">Название:&nbsp;&nbsp;</label>
			<input type="text" id="name" name="name" placeholder="Название" required value="<?= $name ?>"/><br/><br/>
			<label for="desc">Краткое описание:&nbsp;&nbsp;</label>
			<textarea id="desc" name="desc" placeholder="Краткое описание" rows="2" cols="40" required><?= $desc ?></textarea><br/><br/>
			<label for="img1">Изображение 1 (Старое - <?= '"' . $img1 . '"' ?>):&nbsp;&nbsp;</label>
			<input type="file" id="img1" name="img1" placeholder="Изобр-е 1" size="40" accept="image/jpeg,image/png" required value="<?= $img1 ?>"/><br/><br/>
			<label for="img2">Изображение 2 (Старое - <?= '"' . $img2 . '"' ?>):&nbsp;&nbsp;</label>
			<input type="file" id="img2" name="img2" placeholder="Изобр-е 2" size="40" accept="image/jpeg,image/png" required value="<?= $img2 ?>"/><br/><br/>
			<label for="img3">Изображение 3 (Старое - <?= '"' . $img3 . '"' ?>):&nbsp;&nbsp;</label>
			<input type="file" id="img3" name="img3" placeholder="Изобр-е 3" size="40" accept="image/jpeg,image/png" required value="<?= $img3 ?>"/><br/><br/>
			<button name="save" class="btn btn-success">Сохранить</button>
		</form>
	</div>
</div>