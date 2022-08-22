<?php
# @Author : zhoulei1
# @Time   : 2022-08-22
# @File   : WechatController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;
use Zuogechengxu\Wechat\Factory;

class WechatController extends Controller
{
    private $config;

    public function __construct()
    {
        $conf = [
            'corp_id' => env('CORP_ID'),
            'agent_id'=> env('AGENT_ID'),
            'secret'  => env('SECRET')
        ];

        $this->config =$conf;
    }

    public function test()
    {
        $app = Factory::work($this->config);

        $result = $app->message->setTemplateCard(['aa'=>1], 'text_notice')->toUser('xxxx')->send();

        dd($result);
    }
}
