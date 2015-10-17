<?php
/**
 *
 * @file          security.php
 * @author        ricardo
 * @version       2.1.23
 * @copyright     (c) 2015 Ricardo Madriz
 * @licensing     GNU GPL 2.0
 * @link          http://www.TEST.net
 *
 * This software is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * Date: 24/10/15
 * Time: 02:25 PM
 */
define("ENCRYPT_KEY", "fapOnMerkel__!+*");
define("AUTH_KEY", "*+!__lekreMnOpaf");

function secure_data($data) {
    $iv = mcrypt_create_iv(16);
    $ciphertext = mcrypt_encrypt(
        MCRYPT_RIJNDAEL_128,
        ENCRYPT_KEY,
        json_encode($data),
        'ctr',
        $iv
    );
    // Note: We cover the IV in our HMAC
    $hmac = hash_hmac('sha256', $iv . $ciphertext, AUTH_KEY, true);
    return base64_encode($hmac . $iv . $ciphertext);
}

function extract_data($data) {
    $decoded = base64_decode($data);
    $hmac = mb_substr($decoded, 0, 32, '8bit');
    $iv = mb_substr($decoded, 32, 16, '8bit');
    $ciphertext = mb_substr($decoded, 48, null, '8bit');

    $calculated = hash_hmac('sha256', $iv . $ciphertext, AUTH_KEY, true);

    if (hash_equals($hmac, $calculated)) {
        $decrypted = rtrim(
            mcrypt_decrypt(
                MCRYPT_RIJNDAEL_128,
                ENCRYPT_KEY,
                $ciphertext,
                'ctr',
                $iv
            ),
            "\0"
        );
        return json_decode($decrypted, true)['0'];
    } else {
        return false;
    }
}
