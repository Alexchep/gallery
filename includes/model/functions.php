<?php

#Получение списка всех галерей
function getAllGalleries() {
	global $wpdb;
	$gallery = $wpdb->prefix . 'gallery';
	$query = "SELECT * FROM $gallery";
	return $wpdb->get_results($query, ARRAY_A);
}

#Получение галереи по её 'id'
function getGalleryById($id) {
	global $wpdb;
	$gallery = $wpdb->prefix . 'gallery';
	$gal_id = "SELECT * FROM $gallery WHERE id='%d'";
	$query = $wpdb->prepare($gal_id, $id);
	return $wpdb->get_row($query, ARRAY_A);
}

#Получение галереи по её 'name'
function getGalleryByName($name) {
	global $wpdb;
	$gallery = $wpdb->prefix . 'gallery';
	$gal_name = "SELECT * FROM $gallery WHERE name='%s'";
	$query = $wpdb->prepare($gal_name, $name);
	return $wpdb->get_row($query, ARRAY_A);
}

#Добавление новой галереи
function addGallery($name, $desc, $img1, $img2, $img3) {
	global $wpdb;
	$name = trim($name);
	$desc = trim($desc);
	for($i=1; $i<=3; $i++){
		if(is_uploaded_file($_FILES['img' . $i]['tmp_name'])){
			$path_array  = wp_upload_dir();
			$path = str_replace('\\', '/', $path_array['path']);
			$img_name = $_FILES['img' . $i]['name'];
			$uploads = move_uploaded_file($_FILES['img' . $i]["tmp_name"], $path. "/" . $img_name);
			echo "Изображение " .$i. " сохранено в: " . $path . "/"  . $img_name . '<br/>';
			if(!$uploads){
				echo 'Error!';
				return false;
			}
		}
	}
	$img1 = $_FILES['img1']['name'];
	$img2 = $_FILES['img2']['name'];
	$img3 = $_FILES['img3']['name'];
	$gallery = $wpdb->prefix . 'gallery';
	$gal = "INSERT INTO $gallery (`name`, `desc`, `img1`, `img2`, `img3`) VALUES ('%s', '%s', '%s', '%s', '%s')";
	$query = $wpdb->prepare($gal, $name, $desc, $img1, $img2, $img3);
	$result = $wpdb->query($query);
	if ($result === false) {
		exit('Error!');
	}
	return true;
}

#Добавление шорткода
function addShortcode($id, $shortcode) {
	global $wpdb;
	$shortcode = trim($shortcode);
	$gallery = $wpdb->prefix . 'gallery';
	$sc = "UPDATE $gallery SET `shortcode`='%s' WHERE id='%d'";
	$query = $wpdb->prepare($sc, $shortcode, $id);
	$result = $wpdb->query($query);
	if ($result === false) {
		exit('Error!');
	}
	return true;
}

#Редактирование галереи
function editGallery($id, $name, $desc, $img1, $img2, $img3) {
	global $wpdb;
	$name = trim($name);
	$desc = trim($desc);
	$img1 = $_FILES['img1']['name'];
	$img2 = $_FILES['img2']['name'];
	$img3 = $_FILES['img3']['name'];
	for($i=1; $i<=3; $i++){
		if(is_uploaded_file($_FILES['img' . $i]['tmp_name'])){
			$path_array  = wp_upload_dir();
			$path = str_replace('\\', '/', $path_array['path']);
			$img_name = $_FILES['img' . $i]['name'];
			$uploads = move_uploaded_file($_FILES['img' . $i]["tmp_name"], $path. "/" . $img_name);
			echo "Изображение " .$i. " сохранено в: " . $path . "/"  . $img_name . '<br/>';
			if(!$uploads){
				echo 'error!';
				return false;
			}
		}
	}
	$gallery = $wpdb->prefix . 'gallery';
	$gal = "UPDATE $gallery SET `name`='%s', `desc`='%s', `img1`='%s', `img2`='%s', `img3`='%s' WHERE id='%d'";
	$query = $wpdb->prepare($gal, $name, $desc, $img1, $img2, $img3, $id);
	$result = $wpdb->query($query);
	if ($result === false) {
		exit('Error!');
	}
	return true;
}

#Удаление галереи
function deleteGallery($id) {
	global $wpdb;
	$gallery = $wpdb->prefix . 'gallery';
	$del = "DELETE FROM $gallery WHERE id='%d'";
	$query = $wpdb->prepare($del, $id);
	return $wpdb->query($query);
}