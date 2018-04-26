<?php
namespace App\Http\Controllers\Service;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Service\ToolsController;

class TestController extends Controller
{
    protected $method = 'AES-256-CBC';
    protected $key = 'dHIVxVHDrASGcpwDNC0KNgHFPneqRUjK';

    public function test()
    {
        $str = '{"customer_id":21,"set_url":"https:\/\/bcquan.com\/api\/set_lottery","event":100000,"priority":1,"serial":"$2y$10$mUwjWs4ZClih9dcK5GTyfOnt0QjFxkVTeLfM7d14xWoj..Ay8sr2a","handler":"SQS","time":"2018-04-18 06:36:54","level":"DEBUG","type":"JSON","data":{"lottery_id":"49","lottery":"TXFFC","issue":"201804180872","code":"14413"}}';
        $tools = new ToolsController($this->method, $this->key);
        $res = $tools->encrypt($str);

        dd($res);
    }
}