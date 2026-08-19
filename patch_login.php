<?php
$content = file_get_contents("resources/views/auth/login.blade.php");
$content = str_replace("<label for=\"email\" class=\"form-label\">Email</label>", "<label for=\"email\" class=\"form-label\">Username / Email</label>", $content);
$content = str_replace("type=\"email\"", "type=\"text\"", $content);
file_put_contents("resources/views/auth/login.blade.php", $content);

