<?php
// Оптимизируем код:
add_action('wp_enqueue_scripts', function () {
	/* wp_enqueue_style('style-name', get_stylesheet_uri()); */ // подключится файл style.css, который уже был из коробки,
	// но нам нужно подключить наш файл css из папки assets:

	// укажем функции подключающие стили:
	// в параметры функции wp_enqueue_style передадим название нашего файла и функцию, которая возвращает адрес к нашей теме get_template_directory_uri() и конкатенируем (соединяем с о второй частью пути к файлу стилей), аналогично подключаются другие ссылки:
	wp_enqueue_style('fonts-gstatic', 'https://fonts.gstatic.com');
	wp_enqueue_style('fonts', 'https://fonts.googleapis.com/css2?family=Oswald:wght@300;400&display=swap');
	wp_enqueue_style('reset', get_template_directory_uri() . '/assets/css/reset.css');
	wp_enqueue_style('slick', get_template_directory_uri() . '/assets/css/slick.css');
	wp_enqueue_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css');


	// укажем функции подключающие стили:
	wp_deregister_script('jquery'); // отключаем jquery, которое было установлено по умолчанию
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js'); // регистрируем нашу версию jquery
	wp_enqueue_script('jquery'); // подключаем jquery
	wp_enqueue_script('slick', get_template_directory_uri() . '/assets/js/slick.min.js', array('jquery'), 'null', true);
	wp_enqueue_script('wow', get_template_directory_uri() . '/assets/js/wow.min.js', array('jquery'), 'null', true);
	wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), 'null', true); //где array()-показывает зависит ли этот скрипт от другого скрипта (т.е. этот скрипт загрузится только после того как загрузится jquery), далее вместо версии укажем null, true-мы хотим что бы скрипты подключились внизу (в footer) 
});

// Прописываем все необходимые нам возможности:
// поддержка постами картинок (добавление миниатюр)
add_theme_support('post-thumbnails');
// заголовок управления wordpress (вверху)
add_theme_support('title-tag');
// замена логотипа
add_theme_support('custom-logo');


add_filter('upload_mimes', 'svg_upload_allow');
# Добавляет SVG в список разрешенных для загрузки файлов.
function svg_upload_allow($mimes)
{
	$mimes['svg']  = 'image/svg+xml';
	return $mimes;
}


add_filter('wp_check_filetype_and_ext', 'fix_svg_mime_type', 10, 5);
# Исправление MIME типа для SVG файлов.
function fix_svg_mime_type($data, $file, $filename, $mimes, $real_mime = '')
{
	// WP 5.1 +
	if (version_compare($GLOBALS['wp_version'], '5.1.0', '>='))
		$dosvg = in_array($real_mime, ['image/svg', 'image/svg+xml']);
	else
		$dosvg = ('.svg' === strtolower(substr($filename, -4)));

	// mime тип был обнулен, поправим его
	// а также проверим право пользователя
	if ($dosvg) {

		// разрешим
		if (current_user_can('manage_options')) {

			$data['ext']  = 'svg';
			$data['type'] = 'image/svg+xml';
		}
		// запретим
		else {
			$data['ext'] = $type_and_ext['type'] = false;
		}
	}
	return $data;
}
