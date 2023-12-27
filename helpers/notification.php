<?php

function notifyAndRedir($type, $msg, $location) {

    $_SESSION['notify_type'] = $type;
    $_SESSION['notify_msg'] = $msg;

    header("Location: " . $location);

}

function notifyReset() {
    if (isset($_SESSION['notify_type']) && isset($_SESSION['notify_msg'])) {
        unset($_SESSION['notify_type']);
        unset($_SESSION['notify_msg']);
    }
}

function notifyExists() {
    return isset($_SESSION['notify_type']) && isset($_SESSION['notify_msg']);
}