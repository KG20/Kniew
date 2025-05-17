<?php


/**
 * Encrypt and decrypt data for safer transfer of database
 * Not to be used for  password
  someArray ( [0] => AES-128-CBC [1] => AES-128-CBC-HMAC-SHA1 [2] => AES-128-CBC-HMAC-SHA256 [3] => AES-128-CFB [4] => AES-128-CFB1 [5] => AES-128-CFB8 [6] => AES-128-CTR [7] => AES-128-ECB [8] => AES-128-OFB [9] => AES-128-XTS [10] => AES-192-CBC [11] => AES-192-CFB [12] => AES-192-CFB1 [13] => AES-192-CFB8 [14] => AES-192-CTR [15] => AES-192-ECB [16] => AES-192-OFB [17] => AES-256-CBC [18] => AES-256-CBC-HMAC-SHA1 [19] => AES-256-CBC-HMAC-SHA256 [20] => AES-256-CFB [21] => AES-256-CFB1 [22] => AES-256-CFB8 [23] => AES-256-CTR [24] => AES-256-ECB [25] => AES-256-OFB [26] => AES-256-XTS [27] => AES128 [28] => AES192 [29] => AES256 [30] => BF [31] => BF-CBC [32] => BF-CFB [33] => BF-ECB [34] => BF-OFB [35] => CAMELLIA-128-CBC [36] => CAMELLIA-128-CFB [37] => CAMELLIA-128-CFB1 [38] => CAMELLIA-128-CFB8 [39] => CAMELLIA-128-ECB [40] => CAMELLIA-128-OFB [41] => CAMELLIA-192-CBC [42] => CAMELLIA-192-CFB [43] => CAMELLIA-192-CFB1 [44] => CAMELLIA-192-CFB8 [45] => CAMELLIA-192-ECB [46] => CAMELLIA-192-OFB [47] => CAMELLIA-256-CBC [48] => CAMELLIA-256-CFB [49] => CAMELLIA-256-CFB1 [50] => CAMELLIA-256-CFB8 [51] => CAMELLIA-256-ECB [52] => CAMELLIA-256-OFB [53] => CAMELLIA128 [54] => CAMELLIA192 [55] => CAMELLIA256 [56] => CAST [57] => CAST-cbc [58] => CAST5-CBC [59] => CAST5-CFB [60] => CAST5-ECB [61] => CAST5-OFB [62] => DES [63] => DES-CBC [64] => DES-CFB [65] => DES-CFB1 [66] => DES-CFB8 [67] => DES-ECB [68] => DES-EDE [69] => DES-EDE-CBC [70] => DES-EDE-CFB [71] => DES-EDE-OFB [72] => DES-EDE3 [73] => DES-EDE3-CBC [74] => DES-EDE3-CFB [75] => DES-EDE3-CFB1 [76] => DES-EDE3-CFB8 [77] => DES-EDE3-OFB [78] => DES-OFB [79] => DES3 [80] => DESX [81] => DESX-CBC [82] => IDEA [83] => IDEA-CBC [84] => IDEA-CFB [85] => IDEA-ECB [86] => IDEA-OFB [87] => RC2 [88] => RC2-40-CBC [89] => RC2-64-CBC [90] => RC2-CBC [91] => RC2-CFB [92] => RC2-ECB [93] => RC2-OFB [94] => RC4 [95] => RC4-40 [96] => RC4-HMAC-MD5 [97] => RC5 [98] => RC5-CBC [99] => RC5-CFB [100] => RC5-ECB [101] => RC5-OFB [102] => SEED [103] => SEED-CBC [104] => SEED-CFB [105] => SEED-ECB [106] => SEED-OFB [107] => aes-128-cbc [108] => aes-128-cbc-hmac-sha1 [109] => aes-128-cbc-hmac-sha256 [110] => aes-128-ccm [111] => aes-128-cfb [112] => aes-128-cfb1 [113] => aes-128-cfb8 [114] => aes-128-ctr [115] => aes-128-ecb [116] => aes-128-gcm [117] => aes-128-ofb [118] => aes-128-xts [119] => aes-192-cbc [120] => aes-192-ccm [121] => aes-192-cfb [122] => aes-192-cfb1 [123] => aes-192-cfb8 [124] => aes-192-ctr [125] => aes-192-ecb [126] => aes-192-gcm [127] => aes-192-ofb [128] => aes-256-cbc [129] => aes-256-cbc-hmac-sha1 [130] => aes-256-cbc-hmac-sha256 [131] => aes-256-ccm [132] => aes-256-cfb [133] => aes-256-cfb1 [134] => aes-256-cfb8 [135] => aes-256-ctr [136] => aes-256-ecb [137] => aes-256-gcm [138] => aes-256-ofb [139] => aes-256-xts [140] => aes128 [141] => aes192 [142] => aes256 [143] => bf [144] => bf-cbc [145] => bf-cfb [146] => bf-ecb [147] => bf-ofb [148] => blowfish [149] => camellia-128-cbc [150] => camellia-128-cfb [151] => camellia-128-cfb1 [152] => camellia-128-cfb8 [153] => camellia-128-ecb [154] => camellia-128-ofb [155] => camellia-192-cbc [156] => camellia-192-cfb [157] => camellia-192-cfb1 [158] => camellia-192-cfb8 [159] => camellia-192-ecb [160] => camellia-192-ofb [161] => camellia-256-cbc [162] => camellia-256-cfb [163] => camellia-256-cfb1 [164] => camellia-256-cfb8 [165] => camellia-256-ecb [166] => camellia-256-ofb [167] => camellia128 [168] => camellia192 [169] => camellia256 [170] => cast [171] => cast-cbc [172] => cast5-cbc [173] => cast5-cfb [174] => cast5-ecb [175] => cast5-ofb [176] => des [177] => des-cbc [178] => des-cfb [179] => des-cfb1 [180] => des-cfb8 [181] => des-ecb [182] => des-ede [183] => des-ede-cbc [184] => des-ede-cfb [185] => des-ede-ofb [186] => des-ede3 [187] => des-ede3-cbc [188] => des-ede3-cfb [189] => des-ede3-cfb1 [190] => des-ede3-cfb8 [191] => des-ede3-ofb [192] => des-ofb [193] => des3 [194] => desx [195] => desx-cbc [196] => id-aes128-CCM [197] => id-aes128-GCM [198] => id-aes128-wrap [199] => id-aes128-wrap-pad [200] => id-aes192-CCM [201] => id-aes192-GCM [202] => id-aes192-wrap [203] => id-aes192-wrap-pad [204] => id-aes256-CCM [205] => id-aes256-GCM [206] => id-aes256-wrap [207] => id-aes256-wrap-pad [208] => id-smime-alg-CMS3DESwrap [209] => idea [210] => idea-cbc [211] => idea-cfb [212] => idea-ecb [213] => idea-ofb [214] => rc2 [215] => rc2-40-cbc [216] => rc2-64-cbc [217] => rc2-cbc [218] => rc2-cfb [219] => rc2-ecb [220] => rc2-ofb [221] => rc4 [222] => rc4-40 [223] => rc4-hmac-md5 [224] => rc5 [225] => rc5-cbc [226] => rc5-cfb [227] => rc5-ecb [228] => rc5-ofb [229] => seed [230] => seed-cbc [231] => seed-cfb [232] => seed-ecb [233] => seed-ofb )
 */
class Crypto
{
  const METHOD = 'aes-256-ctr';
  const HASH_ALGO = 'sha256';

  // public function __construct($method = FALSE)
  // {
  //
  //   if($method)
  //   {
  //     if(in_array(strtolower($method), openssl_get_cipher_methods())) {
  //       $this->method = $method;
  //     } else {
  //       die(__METHOD__ . ": unrecognised cipher method: {$method}");
  //     }
  //   }
  //
  // }

  //Encrypts (but does not authenticate) a message

  public static function unsafe_encrypt($data, $keyraw, $encode = false)
  {
    $key = self::keytobinary($keyraw);
    $ivSize = openssl_cipher_iv_length(self::METHOD);
    $iv = openssl_random_pseudo_bytes($ivSize);
    $encrypttext = openssl_encrypt($data, self::METHOD, $key, OPENSSL_RAW_DATA, $iv);
    if($encode) return base64_encode($iv.$encrypttext);
    return $iv.$encrypttext;
  }

  //Decrypts (but does not verify) a message

  public static function unsafe_decrypt($data, $keyraw, $encoded = false)
  {
    $key = self::keytobinary($keyraw);
    if($encoded)
    {
      $data = base64_decode($data, true);
      if ($data === false) {
        throw new Exception('Encryption failure');
      }
    }
    $ivSize = openssl_cipher_iv_length(self::METHOD);
    $iv = mb_substr($data, 0, $ivSize, '8bit');
    $encrypttext =  mb_substr($data, $ivSize, null, '8bit');
    $plaintext = openssl_decrypt($encrypttext,self::METHOD,  $key, OPENSSL_RAW_DATA,$iv);
    return $plaintext;
  }

  //Encrypts then MACs a message

  public static function encrypt($data, $keyraw, $encode = false)
  {
    $key = self::keytobinary($keyraw);
    list($encKey, $authKey) = self::splitKeys($key);
    $encrypttext = self::unsafe_encrypt($data, $encKey); // Pass to UnsafeCrypto::encrypt
    $mac = hash_hmac(self::HASH_ALGO, $encrypttext, $authKey, true); // Calculate a MAC of the IV and ciphertext
    if ($encode) {
        return base64_encode($mac.$encrypttext);
    }
    return $mac.$encrypttext; // Prepend MAC to the ciphertext and return to caller
  }

  //Decrypts a message (after verifying integrity)

  public static function decrypt($data, $keyraw, $encoded = false)
  {
    $key = self::keytobinary($keyraw);
    list($encKey, $authKey) = self::splitKeys($key);
    if ($encoded) {
      $data = base64_decode($data, true);
      if ($data === false) {
        throw new Exception('Encryption failure');
      }
    }

    // Hash Size -- in case HASH_ALGO is changed
    $hs = mb_strlen(hash(self::HASH_ALGO, '', true), '8bit');
    $mac = mb_substr($data, 0, $hs, '8bit');
    $encrypttext = mb_substr($data, $hs, null, '8bit');

    $calculated = hash_hmac( self::HASH_ALGO, $encrypttext, $authKey, true);

    if (!self::hashEquals($mac, $calculated)) {
      throw new Exception('Encryption failure');
    }
    // Pass to UnsafeCrypto::decrypt
    $plaintext = self::unsafe_decrypt($encrypttext, $encKey);

    return $plaintext;
  }

  // Splits a key into two separate keys; one for encryption and the other for authenticaiton

  protected static function splitKeys($masterKey)
  {
    // You really want to implement HKDF here instead!
    return [
      hash_hmac(self::HASH_ALGO, 'ENCRYPTION', $masterKey, true),
      hash_hmac(self::HASH_ALGO, 'AUTHENTICATION', $masterKey, true)
    ];
  }

  // Compare two strings without leaking timing information
  protected static function hashEquals($a, $b)
  {
    if (function_exists('hash_equals')) {
      return hash_equals($a, $b);
    }
    $iv = openssl_random_pseudo_bytes(32);
    return hash_hmac(self::HASH_ALGO, $a, $iv) === hash_hmac(self::HASH_ALGO, $b, $iv);
  }

 protected static function keytobinary($keyraw)
 {
   $key;
   if(ctype_print($keyraw))
   {
     // convert ASCII keys to binary format
     $key = openssl_digest($keyraw, 'SHA256', TRUE);
   } else {
     $key = $keyraw;
   }
   return $key;
 }




}
