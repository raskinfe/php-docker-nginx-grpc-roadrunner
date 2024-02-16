<?php
use App\Models\User;

session_start();

function dd($args) {
    var_dump($args);
    die();
}

function setFlashMessage($message, $type = "success") {
    $_SESSION['flash_message'] = [
        'type' => $type,
        'message' => $message,
        'expiry_time' => time() + 10 // Set expiry time to 10 seconds from current time
    ];
}

// Function to get flash message
function getFlashMessage() {
    if (isset($_SESSION['flash_message']) && $_SESSION['flash_message']['expiry_time'] > time()) {
        $flashMessage = $_SESSION['flash_message'];
        unset($_SESSION['flash_message']); // Clear the message after displaying
        return $flashMessage;
    }
    return null; // No message or expired
}

function setActiveLink($link) {
    $_SESSION['active'] = $link;
}

function setActiveUser($user) {
    $_SESSION['user'] = [
        'user' => $user,
        'expiry_time' => time() + 1800 
    ];
}

function currentUser(): User | null {
    return isset($_SESSION['user']['user']) ? $_SESSION['user']['user'] : null;
}

function assets(string $path): string {
    return 'src/assets/'.$path;
}

function base(): string { 
    return $_SERVER['DOCUMENT_ROOT'];
}