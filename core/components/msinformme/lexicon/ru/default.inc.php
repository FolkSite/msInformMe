<?php
include_once 'setting.inc.php';

$_lang['msinformme_button_send'] = 'Отправить';
$_lang['msinformme_open_send'] = 'Отправить Email';
$_lang['msinformme_send_question'] = 'Будет отправлено письмо на адрес';
$_lang['msinformme_send_success'] = 'Ваше сообщение отправлено!';
$_lang['msinformme_message_from'] = 'Сообщение от ';

$_lang['msinformme_err_not_class'] = '[msInformMe] Не удалось загрузить класс';
$_lang['msinformme_err_not_email'] = 'Вы забыли указать адрес электронной почты.';
$_lang['msinformme_err_email_validate'] = '<span style="color: red;">Введённый адрес 
    не является адресом электронной почты.</span><br />Адрес электронной почты должен 
    быть в формате: <strong>user@domain.com</strong>';
$_lang['msinformme_err_template_send'] = '<span style="color: red;">Вы не указали шаблон 
    для электронной почты.</span><br /> Системная настройка <strong>msinformme_template_send</strong>';
$_lang['msinformme_err_no_template'] = 'Указанный шаблон в системной настройке 
    <strong>msinformme_template_send</strong> не найден.';
