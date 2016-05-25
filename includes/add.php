<?php
include_once '/model/functions.php';
?>

<h3><a href="<?= $_SERVER['PHP_SELF'] ?>?page=gallery&c=all">Вернуться к списку галерей</a></h3>

<?php
if (!empty($_POST)) {
	$galleries = getAllGalleries();
	if (count($galleries) != 0) {//Если список галерей не пуст, то идем путем добавления новой
		$gal_name = getGalleryByName($_POST['name']);
		if ($gal_name) {//Проверка на существование галереи с таким именем. Если есть - не создаем
			echo "<h3>Галерея с таким названием уже существует!</h3><br/></br/><h3><a class='btn btn-warning link' href='?page=gallery&c=add'>Попробовать снова</a></h3>";
			exit();
		} else {//Если нет -создаем
			if (addGallery($_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
				$gallery = getGalleryByName($_POST['name']);
				$shortcode = '[ac_gallery id="' . $gallery['id'] . '"]';
				addShortcode($gallery['id'], $shortcode);
				echo '<h3>Шорткод для вставки:&nbsp;&nbsp;&nbsp;<strong>' . $shortcode . '</strong></h3<br/><br/>';
				exit('Галерея успешно создана!');
			}
		}
	} else {//Если пуст, то естественно создаем без проверки имени
		if (addGallery($_POST['name'], $_POST['desc'], $_POST['img1'], $_POST['img2'], $_POST['img3'])) {
			$gallery = getGalleryByName($_POST['name']);
			$shortcode = '[ac_gallery id="' . $gallery['id'] . '"]';
			addShortcode($gallery['id'], $shortcode);
			echo '<h3>Шорткод для вставки:&nbsp;&nbsp;&nbsp;<strong>' . $shortcode . '</strong></h3<br/><br/>';
			exit('Галерея успешно создана!');
		}
	}
}
?>

<div class="col-md-12">
	<div class="col-md-12 title">
		<h3>Новая галерея:</h3>
	</div>
	<div class="col-md-12">
		<form method="post" class="add_form" enctype="multipart/form-data">
			<label for="name">Название:&nbsp;&nbsp;</label>
			<input type="text" id="name" name="name" placeholder="Название" required/><br/><br/>
			<label for="desc">Краткое описание:&nbsp;&nbsp;</label>
			<textarea id="desc" name="desc" placeholder="Краткое описание" rows="2" cols="40" required></textarea><br/><br/>
			<label for="img1">Изображение 1:&nbsp;&nbsp;</label>
			<input type="file" id="img1" name="img1" accept="image/jpeg,image/png" required/><br/><br/>
			<label for="img2">Изображение 2 :&nbsp;&nbsp;</label>
			<input type="file" id="img2" name="img2" accept="image/jpeg,image/png" required/><br/><br/>
			<label for="img3">Изображение 3 :&nbsp;&nbsp;</label>
			<input type="file" id="img3" name="img3" accept="image/jpeg,image/png" required/><br/><br/>
			<input type="hidden" name="hidden" value="<?= $gallery['id'] ?>"/>
			<button name="create" class="btn btn-success">Создать</button>
		</form>
	</div>
</div>