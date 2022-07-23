<?php
  declare(strict_types=1);

  namespace CLI\Test\handlers;

  use GSP\CLI\interfaces\Handler;

  class ShowArgs implements Handler
  {

    /**
     * Handler logic execution method
     *
     * @param string $name
     * @param array $args
     * @param array $params
     * @return void
     */
    public function execute(string $name, array $args, array $params): void
    {
      $this->printCommandName($name);
      $this->printArgs($args);
      $this->printParams($params);
    }

    /**
     * Method to print command name in console
     *
     * @param string $name
     * @return void
     */
    private function printCommandName(string $name): void
    {
      echo PHP_EOL . 'Called command : ' . $name . PHP_EOL . PHP_EOL;
    }

    /**
     * Method to print arguments in console
     *
     * @param array $args
     * @return void
     */
    private function printArgs(array $args): void
    {
      echo 'Arguments : ' . PHP_EOL;
      array_map([$this, 'printElem'], $args);
      echo PHP_EOL;
    }

    /**
     * Method to print params in console
     *
     * @param array $params
     * @return void
     */
    private function printParams(array $params): void
    {
      echo 'Options : ' . PHP_EOL;
      foreach ($params as $name => $value) {
        $this->printElem($name);
        foreach ($value as $el) {
          echo '    ';
          $this->printElem($el);
        }
      }
    }

    /**
     * Method to print element in console
     *
     * @param string $arg
     * @return void
     */
    private function printElem(string $arg): void
    {
      echo '  - ' . $arg . PHP_EOL;
    }
  }