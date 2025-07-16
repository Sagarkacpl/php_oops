<?php
function convert_string($action, $string)
{
    $output = '';
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'vaUM777#$vaUM7$@57#$vaUM777#$vaUM7245#7#$';
    $secret_iv = 'test1234567890test1234567890test1234567890';
    $key = hash('sha256', $secret_key);
    $initialization_vector = substr(hash('sha256', $secret_iv), 0, 16);
    if ($string != '') {
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $initialization_vector);
            $output = base64_encode($output);
        }
        if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $initialization_vector);
        }
    }
    return $output;
}

/**
 * Sanitize a string or array for safe output/use.
 * Prevents XSS and HTML injection.
 * @param mixed $data
 * @return mixed
 */
function sanitize_input($data) {
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            $data[$key] = sanitize_input($value);
        }
        return $data;
    }
    // Only encode special characters, do not use strip_tags
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Get sanitized POST value by key.
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function post($key, $default = null) {
    return isset($_POST[$key]) ? strip_tags($_POST[$key]) : $default;
}

/**
 * Get sanitized GET value by key.
 * @param string $key
 * @param mixed $default
 * @return mixed
 */
function get($key, $default = null) {
    return isset($_GET[$key]) ? strip_tags($_GET[$key]) : $default;
}
