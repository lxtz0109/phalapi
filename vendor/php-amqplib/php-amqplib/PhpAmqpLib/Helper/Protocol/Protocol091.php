<?php

/* This file was autogenerated by spec/parser.php - Do not modify */

namespace PhpAmqpLib\Helper\Protocol;

use PhpAmqpLib\Wire\AMQPWriter;
use PhpAmqpLib\Wire\AMQPReader;

class Protocol091
{
    /**
     * @param int $version_major
     * @param int $version_minor
     * @param mixed $server_properties
     * @param string $mechanisms
     * @param string $locales
     * @return array
     */
    public function connectionStart($version_major, $version_minor , $server_properties, $mechanisms = 'PLAIN', $locales = 'en_US')
    {
        $writer = new AMQPWriter();
        $writer->write_octet($version_major);
        $writer->write_octet($version_minor);
        $writer->write_table(empty($server_properties) ? array() : $server_properties);
        $writer->write_longstr($mechanisms);
        $writer->write_longstr($locales);
        return array(10, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionStartOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_table();
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_longstr();
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $challenge
     * @return array
     */
    public function connectionSecure($challenge)
    {
        $writer = new AMQPWriter();
        $writer->write_longstr($challenge);
        return array(10, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionSecureOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_longstr();
        return $response;
    }

    /**
     * @param int $channel_max
     * @param int $frame_max
     * @param int $heartbeat
     * @return array
     */
    public function connectionTune($channel_max = 0, $frame_max = 0, $heartbeat = 0)
    {
        $writer = new AMQPWriter();
        $writer->write_short($channel_max);
        $writer->write_long($frame_max);
        $writer->write_short($heartbeat);
        return array(10, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionTuneOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_short();
        $response[] = $reader->read_long();
        $response[] = $reader->read_short();
        return $response;
    }

    /**
     * @param string $virtual_host
     * @param string $capabilities
     * @param bool $insist
     * @return array
     */
    public function connectionOpen($virtual_host = '/', $capabilities = '', $insist = false)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($virtual_host);
        $writer->write_shortstr($capabilities);
        $writer->write_bits(array($insist));
        return array(10, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionOpenOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param int $class_id
     * @param int $method_id
     * @return array
     */
    public function connectionClose($reply_code, $reply_text, $class_id, $method_id)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_short($class_id);
        $writer->write_short($method_id);
        return array(10, 50, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionCloseOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param string $reason
     * @return array
     */
    public function connectionBlocked($reason = '')
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($reason);
        return array(10, 60, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function connectionUnblocked(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param string $out_of_band
     * @return array
     */
    public function channelOpen($out_of_band = '')
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($out_of_band);
        return array(20, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function channelOpenOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_longstr();
        return $response;
    }

    /**
     * @param bool $active
     * @return array
     */
    public function channelFlow($active)
    {
        $writer = new AMQPWriter();
        $writer->write_bits(array($active));
        return array(20, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function channelFlowOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_bit();
        return $response;
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param int $class_id
     * @param int $method_id
     * @return array
     */
    public function channelClose($reply_code, $reply_text , $class_id, $method_id)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_short($class_id);
        $writer->write_short($method_id);
        return array(20, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function channelCloseOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param string $realm
     * @param bool $exclusive
     * @param bool $passive
     * @param bool $active
     * @param bool $write
     * @param bool $read
     * @return array
     */
    public function accessRequest($realm = '/data', $exclusive = false, $passive = true, $active = true, $write = true, $read = true)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($realm);
        $writer->write_bits(array($exclusive, $passive, $active, $write, $read));
        return array(30, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function accessRequestOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_short();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param string $type
     * @param bool $passive
     * @param bool $durable
     * @param bool $auto_delete
     * @param bool $internal
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function exchangeDeclare($ticket , $exchange, $type = 'direct', $passive = false, $durable = false, $auto_delete = false, $internal = false, $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($type);
        $writer->write_bits(array($passive, $durable, $auto_delete, $internal, $nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(40, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function exchangeDeclareOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param bool $if_unused
     * @param bool $nowait
     * @return array
     */
    public function exchangeDelete($ticket , $exchange, $if_unused = false, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_bits(array($if_unused, $nowait));
        return array(40, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function exchangeDeleteOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $destination
     * @param string $source
     * @param string $routing_key
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function exchangeBind($ticket , $destination, $source, $routing_key = '', $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($destination);
        $writer->write_shortstr($source);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(40, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function exchangeBindOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $destination
     * @param string $source
     * @param string $routing_key
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function exchangeUnbind($ticket , $destination, $source, $routing_key = '', $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($destination);
        $writer->write_shortstr($source);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(40, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function exchangeUnbindOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $passive
     * @param bool $durable
     * @param bool $exclusive
     * @param bool $auto_delete
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function queueDeclare($ticket , $queue = '', $passive = false, $durable = false, $exclusive = false, $auto_delete = false, $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($passive, $durable, $exclusive, $auto_delete, $nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueDeclareOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_long();
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $exchange
     * @param string $routing_key
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function queueBind($ticket , $queue  , $exchange, $routing_key , $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueBindOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $nowait
     * @return array
     */
    public function queuePurge($ticket = 0, $queue = '', $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($nowait));
        return array(50, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queuePurgeOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $if_unused
     * @param bool $if_empty
     * @param bool $nowait
     * @return array
     */
    public function queueDelete($ticket = 0, $queue = '', $if_unused = false, $if_empty = false, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($if_unused, $if_empty, $nowait));
        return array(50, 40, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueDeleteOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $exchange
     * @param string $routing_key
     * @param array $arguments
     * @return array
     */
    public function queueUnbind($ticket, $queue , $exchange, $routing_key = '', $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(50, 50, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function queueUnbindOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $prefetch_size
     * @param int $prefetch_count
     * @param bool $global
     * @return array
     */
    public function basicQos($prefetch_size = 0, $prefetch_count = 0, $global = false)
    {
        $writer = new AMQPWriter();
        $writer->write_long($prefetch_size);
        $writer->write_short($prefetch_count);
        $writer->write_bits(array($global));
        return array(60, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicQosOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param string $consumer_tag
     * @param bool $no_local
     * @param bool $no_ack
     * @param bool $exclusive
     * @param bool $nowait
     * @param array $arguments
     * @return array
     */
    public function basicConsume($ticket = 0, $queue = '', $consumer_tag = '', $no_local = false, $no_ack = false, $exclusive = false, $nowait = false, $arguments = array())
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($no_local, $no_ack, $exclusive, $nowait));
        $writer->write_table(empty($arguments) ? array() : $arguments);
        return array(60, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicConsumeOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param string $consumer_tag
     * @param bool $nowait
     * @return array
     */
    public function basicCancel($consumer_tag, $nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_bits(array($nowait));
        return array(60, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicCancelOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param int $ticket
     * @param string $exchange
     * @param string $routing_key
     * @param bool $mandatory
     * @param bool $immediate
     * @return array
     */
    public function basicPublish($ticket = 0, $exchange = '', $routing_key = '', $mandatory = false, $immediate = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        $writer->write_bits(array($mandatory, $immediate));
        return array(60, 40, $writer);
    }

    /**
     * @param int $reply_code
     * @param string $reply_text
     * @param string $exchange
     * @param string $routing_key
     * @return array
     */
    public function basicReturn($reply_code, $reply_text , $exchange, $routing_key)
    {
        $writer = new AMQPWriter();
        $writer->write_short($reply_code);
        $writer->write_shortstr($reply_text);
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        return array(60, 50, $writer);
    }

    /**
     * @param string $consumer_tag
     * @param int $delivery_tag
     * @param bool $redelivered
     * @param string $exchange
     * @param string $routing_key
     * @return array
     */
    public function basicDeliver($consumer_tag, $delivery_tag, $redelivered , $exchange, $routing_key)
    {
        $writer = new AMQPWriter();
        $writer->write_shortstr($consumer_tag);
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($redelivered));
        $writer->write_shortstr($exchange);
        $writer->write_shortstr($routing_key);
        return array(60, 60, $writer);
    }

    /**
     * @param int $ticket
     * @param string $queue
     * @param bool $no_ack
     * @return array
     */
    public function basicGet($ticket = 0, $queue = '', $no_ack = false)
    {
        $writer = new AMQPWriter();
        $writer->write_short($ticket);
        $writer->write_shortstr($queue);
        $writer->write_bits(array($no_ack));
        return array(60, 70, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicGetOk(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_longlong();
        $response[] = $reader->read_bit();
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_shortstr();
        $response[] = $reader->read_long();
        return $response;
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicGetEmpty(AMQPReader $reader)
    {
        $response = array();
        $response[] = $reader->read_shortstr();
        return $response;
    }

    /**
     * @param int $delivery_tag
     * @param bool $multiple
     * @return array
     */
    public function basicAck($delivery_tag = 0, $multiple = false)
    {
        $writer = new AMQPWriter();
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($multiple));
        return array(60, 80, $writer);
    }

    /**
     * @param int $delivery_tag
     * @param bool $requeue
     * @return array
     */
    public function basicReject($delivery_tag, $requeue = true)
    {
        $writer = new AMQPWriter();
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($requeue));
        return array(60, 90, $writer);
    }

    /**
     * @param bool $requeue
     * @return array
     */
    public function basicRecoverAsync($requeue = false)
    {
        $writer = new AMQPWriter();
        $writer->write_bits(array($requeue));
        return array(60, 100, $writer);
    }

    /**
     * @param bool $requeue
     * @return array
     */
    public function basicRecover($requeue = false)
    {
        $writer = new AMQPWriter();
        $writer->write_bits(array($requeue));
        return array(60, 110, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function basicRecoverOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param int $delivery_tag
     * @param bool $multiple
     * @param bool $requeue
     * @return array
     */
    public function basicNack($delivery_tag = 0, $multiple = false, $requeue = true)
    {
        $writer = new AMQPWriter();
        $writer->write_longlong($delivery_tag);
        $writer->write_bits(array($multiple, $requeue));
        return array(60, 120, $writer);
    }

    /**

     * @return array
     */
    public function txSelect()
    {
        $writer = new AMQPWriter();
        return array(90, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function txSelectOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**

     * @return array
     */
    public function txCommit()
    {
        $writer = new AMQPWriter();
        return array(90, 20, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function txCommitOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**

     * @return array
     */
    public function txRollback()
    {
        $writer = new AMQPWriter();
        return array(90, 30, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function txRollbackOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }

    /**
     * @param bool $nowait
     * @return array
     */
    public function confirmSelect($nowait = false)
    {
        $writer = new AMQPWriter();
        $writer->write_bits(array($nowait));
        return array(85, 10, $writer);
    }

    /**
     * @param AMQPReader $reader
     * @return array
     */
    public static function confirmSelectOk(AMQPReader $reader)
    {
        $response = array();
        return $response;
    }
}
