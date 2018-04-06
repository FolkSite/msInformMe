<?php
include_once 'setting.inc.php';

$_lang['msinformme_button_send'] = 'Send';
$_lang['msinformme_open_send'] = 'Send Email';
$_lang['msinformme_send_question'] = 'A letter will be sent to the address';
$_lang['msinformme_send_success'] = 'Your message has been sent!';
$_lang['msinformme_message_from'] = 'A message from ';

$_lang['msinformme_err_not_class'] = '[msInformMe] Failed to load class';
$_lang['msinformme_err_not_email'] = 'You forgot to enter your email address.';
$_lang['msinformme_err_email_validate'] = '<span style="color: red;">The entered address is not 
    an email address.</span><br />The email address must be in the format: <strong>user@domain.com</strong>';
$_lang['msinformme_err_template_send'] = '<span style="color: red;">You have not specified 
    a template for your email.</span><br /> System setting <strong>msinformme_template_send</strong>';
$_lang['msinformme_err_no_template'] = 'The specified template in the system setup 
    <strong>msinformme_template_send</strong> not found.';