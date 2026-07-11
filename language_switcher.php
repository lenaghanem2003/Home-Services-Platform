<?php
$arUrl = htmlspecialchars(current_page_lang_url('ar'), ENT_QUOTES, 'UTF-8');
$enUrl = htmlspecialchars(current_page_lang_url('en'), ENT_QUOTES, 'UTF-8');
$arActive = $_SESSION['lang'] === 'ar' ? ' active' : '';
$enActive = $_SESSION['lang'] === 'en' ? ' active' : '';
?>
<li class="nav-item ms-lg-2 d-flex align-items-center">
    <div class="btn-group btn-group-sm lang-switcher" role="group" aria-label="Language">
        <a class="btn btn-lang<?php echo $arActive; ?>" href="<?php echo $arUrl; ?>">عربي</a>
        <a class="btn btn-lang<?php echo $enActive; ?>" href="<?php echo $enUrl; ?>">English</a>
    </div>
</li>
