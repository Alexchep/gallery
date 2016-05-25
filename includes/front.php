<?php
include_once '/model/functions.php';
$gallery = getGalleryById($id);
$path_array  = wp_upload_dir();
$path = str_replace('\\', '/', $path_array['url']);
?>

<div class="gallery">
	<h2><?= $gallery['name'] ?></h2>
	<p><?= $gallery['desc'] ?></p>
	<a href="<?= $path . '/' . $gallery['img1'] ?>" data-lightbox="roadtrip"><img class="image" src="<?= $path . '/' . $gallery['img1'] ?>" alt="img1"/></a>
	<a href="<?= $path . '/' . $gallery['img2'] ?>" data-lightbox="roadtrip"><img class="image" src="<?= $path . '/' . $gallery['img2'] ?>" alt="img2"/></a>
	<a href="<?= $path . '/' . $gallery['img3'] ?>" data-lightbox="roadtrip"><img class="image" src="<?= $path . '/' . $gallery['img3'] ?>" alt="img3"/></a>
</div>