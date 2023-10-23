<?php
RandomContribution::getInstance()->assign(Loufokerie::getInstance()->getCurrent()['id_loufokerie'], $_COOKIE['id']);
HTTP::redirect();
