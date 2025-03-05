<?php
namespace App\Api\Rabbitmq;

use PhalApi\Api;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * rabbitmq案例
 * @author wzh 20250227
 */

class Testdemo1 extends Api {
    public function getRules() {
        return array(
            // 字符串
            'str' => array(
                'str' => array('name' => 'str', 'desc' => '简单的字符串参数'),
            ),
            // 生产者
            'producer' => array(
                'senddata' => array('name' => 'senddata', 'desc' => '生产者发送内容'),
            ),
            // 消费者
            'comsumer' => array(

            ),
        );
    }
    /** ---------------------- string 字符串参数 ---------------------- **/

    /**
     * 参数示例 - 字符串参数
     * @desc 简单的字符串参数传递案例
     */
    public function str() {
        return $this->str();
    }

    /** ----------------------生产者接口---------------------- **/

    /**
     * rabbitmq生产者接口
     * @desc 这是一个rabbitmq生产者案例
     */
    public function producer() {
        $senddata = $this->senddata;
        $connect = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connect->channel();

        // 第三参数持久化
        $channel->queue_declare('swoft_queue_test', false,true,false,false);
        # 消息
        $msg = new AMQPMessage('swoft_queue_test'.time(),array('content_type' => 'text/plain', 'delivery_mode' => 2));

        $channel->confirm_select(); // 发布确认模式


        //推送成功
         $channel->set_ack_handler(
             function (AMQPMessage $message) {

                 echo "发送成功: " . $message->body . PHP_EOL;
             }
         );

          //推送失败
        /*   $channel->set_nack_handler(
              function (AMQPMessage $message) {
                  echo "发送失败: " . $message->body . PHP_EOL;
              }
          );*/
        # 发送
        $channel->basic_publish($msg,'','swoft_queue_test');
        $channel->wait_for_pending_acks();

        $channel->close();
        $connect->close();
        return $senddata;
    }

    /** ----------------------消费者接口---------------------- **/

    /**
     * rabbitmq消费者接口
     * @desc 这是一个rabbitmq消费者案例
     */
    public function comsumer() {

        $connect = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connect->channel();
        $channel->queue_declare('swoft_queue_test', false,true,false,false,false);

        # 回调
        $callback = function ($msg){
            echo $msg->body.PHP_EOL;
            echo "消费====\n";
            // 手动应答
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        // 公平调度
        $channel->basic_qos(null, 1, null);
        // 第四参数为自动应答, 设置为false
        $channel->basic_consume('swoft_queue_test','',false,false,false,false,$callback);
        //while(count($channel->callbacks)){
            $channel->wait();
        //}


        $channel->close();
        $connect->close();

        return "ok";
    }


}