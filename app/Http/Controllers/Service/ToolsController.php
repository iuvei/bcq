<?php
namespace App\Http\Controllers\Service;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;

class ToolsController extends Controller
{
    protected $method;
    protected $key;

    public function __construct($method ,$key)
    {
        $this->method = $method;
        $this->key = $key;
    }

    public function decrypt($payload, $unserialize = true)
    {
        $payload = $this->getJsonPayload($payload); //把加密后的字符串转换出成数组。

        $iv = base64_decode($payload['iv']); //把随机字符串进行base64解密出来

        $decrypted = \openssl_decrypt( //解密数据
            $payload['value'], $this->method, $this->key, 0, $iv
        );

        if ($decrypted === false) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return $unserialize ? unserialize($decrypted) : $decrypted; //把数据转换为原始数据
    }

    public function encrypt($value, $serialize = true)
    {
        $iv = random_bytes(16); //生成一个16位的随机字符串


        // 使用openssl_encrypt把数据生成一个加密的数据
        // 1、判断需要不需要生成一个可存储表示的值，这样做是为了不管你的数据是数组还是字符串都能给你转成一个字符串，不至于在判断你传过来的数据是数组还是字符串了。
        // 2、使用openssl_encrypt。第一个参数是传入数据，第二个参数是传入加密方式，目前使用AES-256-CBC的加密方式，第三个参数是，返回加密后的原始数据，还是把加密的数据在经过一次base64的编码，0的话表示base64位数据。第四个参数是项量，这个参数传入随机数，是为了在加密数据的时候每次的加密数据都不一样。
        $value = \openssl_encrypt(
            $serialize ? serialize($value) : $value,
            $this->method, $this->key, 0, $iv
        ); //使用AES256加密内容

        if ($value === false) {
            throw new EncryptException('Could not encrypt the data.');
        }

        $mac = $this->hash($iv = base64_encode($iv), $value); //生成一个签名，用来保证内容参数没有被更改

        $json = json_encode(compact('iv', 'value', 'mac')); //把随机码，加密内容，已经签名，组成数组，并转成json格式

        if (! is_string($json)) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return base64_encode($json); //把json格式转换为base64位，用于传输
    }

    protected function getJsonPayload($payload)
    {
        $payload = json_decode(base64_decode($payload), true); //把数据转换为原来的数组形式

        if (! $this->validPayload($payload)) { //验证是不是数组以及数组里有没有随机字符串，加密后的内容，签名
            throw new DecryptException('The payload is invalid.');
        }

        if (! $this->validMac($payload)) { //验证数据是否被篡改
            throw new DecryptException('The MAC is invalid.');
        }

        return $payload;
    }

    protected function validPayload($payload)
    {
        return is_array($payload) && isset($payload['iv'], $payload['value'], $payload['mac']) &&
            strlen(base64_decode($payload['iv'], true)) === openssl_cipher_iv_length($this->method);
    }

    protected function validMac(array $payload)
    {
        $calculated = $this->calculateMac($payload, $bytes = random_bytes(16)); //拿数据和随机值生成一个签名

        return hash_equals( //比对上一步生成的签名和下面生成的签名的hash是否一样。
            hash_hmac('sha256', $payload['mac'], $bytes, true), $calculated //根据原始数据里的签名在新生成一个签名
        );
    }

    protected function calculateMac($payload, $bytes)
    {
        return hash_hmac(
            'sha256', $this->hash($payload['iv'], $payload['value']), $bytes, true
        );
    }

    protected function hash($iv, $value)
    {
        return hash_hmac('sha256', $iv.$value, $this->key);
    }

}