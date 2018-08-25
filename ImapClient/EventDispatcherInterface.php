<?php
# this is draft
namespace sergey144010\ImapClient;

interface EventDispatcherInterface
{
    # https://docs.zendframework.com/zend-eventmanager/quick-start/
    public function attach(string $object, string $event, callable $handler);
    public function trigger(string $name, object $object, $params);
}
