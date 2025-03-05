<?php

namespace App\Api;

use PhalApi\Api;
use App\Domain\Examples\CURD as DomainCURD;
use PhalApi\Response;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


/**
 * 湖人家庭
 */
class Lakers extends Api {

	/**
	 * 湖人队接口
     * @desc这是一个测试湖人数据的接口
	 */
	public function world() {
        $domainCurd = new DomainCURD();
        $listItems = $domainCurd->getList(1,1,10);

        $arr = array("name"=>"desmond","msg"=>"succ");
        \PhalApi\DI()->response->setData($arr);
        //return  $arr;
        return $listItems;
        //设置状态码
        //\PhalApi\DI()->response->setRet(1000);
        //手动设置提示消息
        //\PhalApi\DI()->response->setMsg('手动设置提示消息');
		//return array('content' => '中国','data' => $listItems);
	}


    /**
     * 湖人队队列--生产者
     * @desc这是一个测试湖人队列生产者的接口
     */
    public function rabbitMqProduce() {
        for($i = 0; $i < 1000; $i++) {
            // 创建连接到 RabbitMQ 服务器
            $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
            $channel = $connection->channel();


            // 声明队列
            $channel->queue_declare('task_queue', false, true, false, false);

            // 发送的消息内容
            $data = "Hello!======".$i;
            $msg = new AMQPMessage($data, array('delivery_mode' => 2)); // 设置消息为持久化
            //$msg = new AMQPMessage($data, array('delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));

            // 发布消息到队列
            $channel->basic_publish($msg, '', 'task_queue');

            echo " [x] Sent ".$data."\n";

            // 关闭连接
            $channel->close();

        }


        $domainCurd = new DomainCURD();
        $listItems = $domainCurd->getList(1,1,10);

        return $listItems;
        //设置状态码
        //\PhalApi\DI()->response->setRet(1000);
        //手动设置提示消息
        //\PhalApi\DI()->response->setMsg('手动设置提示消息');
        //return array('content' => '中国','data' => $listItems);
    }

    /**
     * 湖人队队列--消费者
     * @desc这是一个测试湖人队列消费者的接口
     */
    public function rabbitMqConsumer() {
        for($i = 0; $i < 1000; $i++) {


        // 创建连接到 RabbitMQ 服务器
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        // 声明队列
        $channel->queue_declare('task_queue', false, true, false, false);

        echo " [*] Waiting for messages. To exit press CTRL+C\n";

         // 回调函数，用于处理接收到的消息
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
            // 模拟任务处理
            sleep(substr_count($msg->body, '.'));
            echo " [x] Done\n";
            // 手动确认消息已经处理
           //$msg->ack();
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        // 告诉 RabbitMQ 在同一时间不要发送多于一条消息给一个消费者
        $channel->basic_qos(null, 1, null);

        // 告诉 RabbitMQ 使用回调函数来接收消息，并手动确认消息
        $channel->basic_consume('task_queue', '', false, false, false, false, $callback);

        // 等待消息进入队列
       // while ($channel->is_consuming()) {
            $channel->wait();
        //}

        // 关闭连接
        $channel->close();
        $connection->close();

        }
    }



}