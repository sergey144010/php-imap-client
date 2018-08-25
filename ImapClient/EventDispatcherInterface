<?php
# this is draft
namespace sergey144010\ImapClient;

interface EventDispatcherInterface
{
    # https://framework.zend.com/manual/2.4/en/modules/zend.event-manager.event-manager.html
    public function attach(string $object, string $event, callable $handler);
    public function trigger(string $name, object $object, $params);
}
