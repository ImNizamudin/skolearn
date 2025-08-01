<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'admin';
}

function isMahasiswa() {
    return isLoggedIn() && $_SESSION['user']['role'] === 'mahasiswa';
}
