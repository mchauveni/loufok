<?php

$loufokerie = Loufokerie::getInstance()->getCurrent();
if ($loufokerie) {
    $now = new DateTime('now');
    $now = $now->modify("-1 second");
    $now = $now->format('Y-m-d H:i:s');
    Loufokerie::getInstance()->update($loufokerie['id_loufokerie'], ['date_fin_loufokerie' => $now]);
}

HTTP::redirect("/admin");
