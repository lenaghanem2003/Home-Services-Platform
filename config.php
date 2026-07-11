<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
$db=new mysqli('127.0.0.1','root','L@cs765ena432','homeservice');

//التحقق من انه اذا تم الاتصال بقاعدة البيانات بنجاح ام لا

if($db->connect_errno){
    die('Sorry,we are having some prblems'.$db->connect_errno);
}

if(isset($_GET['lang']) && in_array($_GET['lang'], ['ar', 'en'], true)){
    $_SESSION['lang'] = $_GET['lang'];
} elseif(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = 'en';
}

if(!in_array($_SESSION['lang'], ['ar', 'en'], true)){
    $_SESSION['lang'] = 'en';
}

$lang_file = __DIR__ . '/languages/' . $_SESSION['lang'] . '.php';
if(!is_readable($lang_file)){
    $_SESSION['lang'] = 'en';
    $lang_file = __DIR__ . '/languages/en.php';
}

$lang = include $lang_file;
if($lang === false || $lang === 1){
    $_SESSION['lang'] = 'en';
    $lang = include __DIR__ . '/languages/en.php';
}

$html_lang = htmlspecialchars($_SESSION['lang'], ENT_QUOTES, 'UTF-8');
$html_dir = $_SESSION['lang'] === 'ar' ? 'rtl' : 'ltr';

/**
 * Same page URL with lang=… (keeps existing query string).
 * Guarded because config.php may be loaded more than once per request.
 */
if(!function_exists('current_page_lang_url')){
    function current_page_lang_url(string $langCode): string {
        if(!in_array($langCode, ['ar', 'en'], true)){
            $langCode = 'en';
        }
        $params = $_GET;
        $params['lang'] = $langCode;
        $query = http_build_query($params);
        $script = basename($_SERVER['PHP_SELF'] ?? 'index.php');
        return $query === '' ? $script : ($script . '?' . $query);
    }
}

?>