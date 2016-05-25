<?php
/*
	Plugin Name: Gallery
	Description: Plagin for create new gallery, edit or delete exists gallery and then: => EXIT() -> FRONT
	Version: 1.0
	Author: Alexandr Chepelenko
	Author URI: https://www.linkedin.com/in/alexander-chepelenko-860280b9?trk=hp-identity-photo
*/
/*  Copyright 2016  alexchep  (email: alexchep92@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

#Активация плагина(Создание таблицы в базе)
function gallery_install()
{
	global $wpdb;
	$gallery = $wpdb->prefix . 'gallery';
	if($wpdb->get_var("SHOW TABLES LIKE $gallery") != $gallery){
		$cr_gallery = "CREATE TABLE IF NOT EXISTS $gallery (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(100)  NOT NULL,
					`desc` varchar(200) NOT NULL,
					`img1` varchar(255) NOT NULL,
					`img2` varchar(255) NOT NULL,
					`img3` varchar(255) NOT NULL,
					`shortcode` varchar(255) NOT NULL,
					PRIMARY KEY(`id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

		$wpdb->query($cr_gallery);
	}
	add_option('gallery_on_page');
}
register_activation_hook(__FILE__, 'gallery_install');

#Деактивация плагина(Удаление таблицы из базы)
function gallery_uninstall()
{
	global $wpdb;
	$gallery = $wpdb->prefix . 'gallery';
	$dr_gallery = "DROP TABLE IF EXISTS $gallery;";
	$wpdb->query($dr_gallery);
	delete_option('gallery_on_page');
}
register_deactivation_hook(__FILE__, 'gallery_uninstall');

#Определение нужного 'action'
function gallery_editor()
{
	switch ($_GET['c']) {
		case 'add':
			$action = 'add';
			break;
		case 'edit':
			$action = 'edit';
			break;
		default:
			$action = 'all';
			break;
	}
	include_once "includes/$action.php";
}

#Создание шорткода
function gallery_short($atts, $content = null){
	extract(shortcode_atts(array(
	'id' => ''
	), $atts));
	ob_start();
	include_once 'includes/front.php';
	return ob_get_clean();
}
add_filter('widget_text', 'do_shortcode');
add_shortcode('ac_gallery', 'gallery_short');

#Генерация пункта меню 'Галерея'
function gallery_admin_menu()
{
	$page_suffix = add_menu_page('Галерея', 'Галерея', 8, 'gallery', 'gallery_editor', 'http://findicons.com/files/icons/2360/spirit20/20/table_edit.png');
	add_action( 'admin_print_styles-' . $page_suffix, 'admin_styles' );
}

#Подключение стилей в админке
add_action( 'admin_init', 'reg_admin_style' );
add_action( 'admin_menu', 'gallery_admin_menu' );
 
function reg_admin_style() {
	wp_register_style( 'bootstrap', plugins_url('/css/bootstrap.min.css', __FILE__) );
	wp_register_style( 'lightbox', plugins_url('/css/lightbox.css', __FILE__) );
	wp_register_style( 'style', plugins_url('/css/style.css', __FILE__) );
}
 
function admin_styles() {
	wp_enqueue_style( 'style' );
	wp_enqueue_style( 'bootstrap' );
}

#Подключение стилей и скриптов на клиентской стороне
add_action( 'admin_init', 'reg_wp_style' );

function reg_wp_style() {
	wp_register_script('lightbox-js', plugins_url('/js/lightbox.js', __FILE__), array('jquery'), '1.0', true );
	wp_register_style( 'lightbox', plugins_url('/css/lightbox.css', __FILE__) );
	wp_register_style( 'style', plugins_url('/css/style.css', __FILE__) );
	
	wp_enqueue_script('lightbox-js');
	wp_enqueue_style( 'lightbox' );
	wp_enqueue_style( 'style' );
}
add_action('wp_enqueue_scripts', 'reg_wp_style');