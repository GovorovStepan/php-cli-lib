<?php
declare(strict_types=1);
namespace GSP\CLI\classes;

class Command
{

    protected string $name;
    protected string $description;
    protected object $handler;

    public function __construct(string $name, string $description, $handler)
    {
        $this->name = $name;
        $this->description = $description;
        $this->handler = $handler;
    }

  /**
   * Command execution method.
   * Calls the handler method and passes parameters there
   *
   * @param $args
   * @param $params
   * @return mixed
   */
    public function execute($args, $params): mixed
    {
      return $this->handler->execute($this->name, $args, $params);
    }

  /**
   * Command name getter
   *
   * @return string
   */
    public function getName():string
    {
        return $this->name;
    }

  /**
   * Command description getter
   *
   * @return string
   */
    public function getDescription():string
    {
      return $this->description;
    }
}