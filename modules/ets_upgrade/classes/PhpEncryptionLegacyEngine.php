<?php
/**
  * Copyright ETS Software Technology Co., Ltd
 *
 * NOTICE OF LICENSE
 *
 * This file is not open source! Each license that you purchased is only available for 1 website only.
 * If you want to use this file on more websites (or projects), you need to purchase additional licenses.
 * You are not allowed to redistribute, resell, lease, license, sub-license or offer our resources to any third party.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future.
 *
 * @author ETS Software Technology Co., Ltd
 * @copyright  ETS Software Technology Co., Ltd
 * @license    Valid for 1 website (or project) for each purchase of license
 */

/**
 * Class PhpEncryption engine for openSSL < 0.9.8.
 *
 * @doc http://php.net/manual/fr/function.mcrypt-encrypt.php#refsect1-function.mcrypt-encrypt-examples
 *
 * This class will be deprecated when web hosting providers will update their version of OpenSSL.
 */
class PhpEncryptionLegacyEngineCore extends PhpEncryptionEngine
{
    protected $key;
    protected $hmacIv;
    protected $iv;
    protected $ivSize;

    protected $mode = MCRYPT_MODE_CBC;
    protected $cipher = MCRYPT_RIJNDAEL_128;

    /**
     * PhpEncryptionCore constructor.
     *
     * @param string $hexString A string that only contains hexadecimal characters
     *                          Bother upper and lower case are allowed
     */
    public function __construct($hexString)
    {
        $this->key = substr($hexString, 0, 32);
        $this->ivSize = mcrypt_get_iv_size($this->cipher, $this->mode);
        $this->iv = mcrypt_create_iv($this->ivSize, MCRYPT_RAND);
        $this->hmacIv = substr(sha1(_COOKIE_KEY_), 0, $this->ivSize);
    }

    /**
     * Encrypt the plaintext.
     *
     * @param string $plaintext Plaintext
     *
     * @return string Cipher text
     */
    public function encrypt($plaintext)
    {
        $blockSize = mcrypt_get_block_size($this->cipher, $this->mode);
        $pad = $blockSize - (strlen($plaintext) % $blockSize);

        $cipherText = mcrypt_encrypt(
            $this->cipher,
            $this->key,
            $plaintext . str_repeat(chr($pad), $pad),
            $this->mode,
            $this->iv
        );
        $cipherText = $this->iv . $cipherText;

        return $this->generateHmac($cipherText) . ':' . base64_encode($cipherText);
    }

    /**
     * Decrypt the cipher text.
     *
     * @param string $cipherText Cipher text
     *
     * @return bool|string Plaintext
     *                     `false` if unable to decrypt
     *
     * @throws Exception
     */
    public function decrypt($cipherText)
    {
        $data = explode(':', $cipherText);
        if (count($data) != 2) {
            return false;
        }

        list($hmac, $encrypted) = $data;
        $encrypted = base64_decode($encrypted);
        $newHmac = $this->generateHmac($encrypted);
        if ($hmac !== $newHmac) {
            return false;
        }

        $ivDec = substr($encrypted, 0, $this->ivSize);
        $cipherText = substr($encrypted, $this->ivSize);

        $data = mcrypt_decrypt(
            $this->cipher,
            $this->key,
            $cipherText,
            $this->mode,
            $ivDec
        );

        $pad = ord($data[strlen($data) - 1]);

        return substr($data, 0, -$pad);
    }

    /**
     * Generate Hmac.
     *
     * @param string $encrypted
     *
     * @return string
     */
    protected function generateHmac($encrypted)
    {
        $macKey = $this->generateKeygenS2k('sha256', $this->key, $this->hmacIv, 32);

        return call_user_func('hash_hmac',
            'sha256',
            $this->hmacIv . $this->cipher . $encrypted,
            $macKey
        );
    }

    /**
     * Alternative to mhash_keygen_s2k for security reason
     * and php compatibilities.
     *
     * @param string $hash
     * @param string $password
     * @param string $salt
     * @param int $bytes
     *
     * @return string
     */
    protected function generateKeygenS2k($hash, $password, $salt, $bytes)
    {
        $result = '';
        foreach (range(0, ceil($bytes / strlen(hash($hash, null, true))) - 1) as $i) {
            $result .= hash(
                $hash,
                str_repeat("\0", $i) . str_pad(substr($salt, 0, 8), 8, "\0", STR_PAD_RIGHT) . $password,
                true
            );
        }

        return substr(
            $result,
            0,
            (int) $bytes
        );
    }
}
