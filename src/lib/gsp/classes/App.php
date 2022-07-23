<?php
  declare(strict_types=1);

  namespace GSP\CLI\classes;

  use GSP\CLI\interfaces\Handler;
  use TypeError;

  class App
  {
    protected array $commandList;
    protected string $commandName;
    protected array $params = [];
    protected array $args = [];

    /**
     * App execution method. Receives data from the command line as input, after which it analyzes and in case
     * the presence of a command in the list of registered calls the method of executing the command with passing
     * parameters to it
     *
     * @param $data
     * @return void
     */
    public function execute($data): void
    {
      try {
        $this->analyze($data)->callCommand();
      } catch (TypeError $e) {
        $this->printCommandList();
      }
    }

    /**
     * Command execution call method
     *
     * @return void
     */
    protected function callCommand(): void
    {
      if ($this->checkCommandBind()) {
        in_array('help', $this->args) ?
          $this->showCommandDescription($this->commandList[$this->commandName]->getDescription()) :
          $this->commandList[$this->commandName]->execute($this->args, $this->params);
      } else {
        echo PHP_EOL . 'Undefined command. Try something from list.' . PHP_EOL;
        $this->printCommandList();
      }

    }

    /**
     *  Method for checking if the called command is in the list of registered ones
     *
     * @return bool
     */
    protected function checkCommandBind(): bool
    {
      return boolval(array_filter($this->commandList, fn($el) => $el->getName() === $this->commandName));
    }

    /**
     * Called command description display method
     *
     * @param $description
     * @return void
     */
    protected function showCommandDescription($description): void
    {
      echo $description . PHP_EOL . PHP_EOL;
    }

    /**
     * Method for displaying the list of commands registered in the application
     *
     * @return void
     */
    protected function printCommandList(): void
    {
      echo PHP_EOL . 'Available methods: ' . PHP_EOL;
      foreach ($this->commandList as $command) {
        echo '  - ' . $command->getName() . '  ';
        $this->showCommandDescription($command->getDescription());
      }
    }

    /**
     * @param $data
     * @return $this
     */
    protected function analyze($data): App
    {
      unset($data[0]);
      $this->commandName = array_shift($data);
      array_map([$this, 'analyzeData'], $data);
      return $this;
    }

    /**
     * The method is used to registration a new command.
     *
     * @param string $name Command name
     * @param string $description Command description
     * @param Handler $handler Command handler
     * @return $this
     */
    public function bindCommand(string $name, string $description, Handler $handler): App
    {
      $this->commandList[$name] = new Command($name, $description, $handler);
      return $this;
    }

    /**
     * @param $el
     * @return void
     */
    protected function analyzeData($el): void
    {
      preg_match('/\[(.*?)\]/', $el, $matches);

      if (empty($matches)) {
        $this->args[] = $this->removeBrackets($el);
      } else {
        $paramArray = explode("=", $matches[1]);
        $this->params[$paramArray[0]][] = $paramArray[1];
      }
    }

    /**
     * The method removes curly braces from a string
     *
     * @param $param
     * @return string
     */
    protected function removeBrackets($param): string
    {
      preg_match('/\{(.*?)\}/', $param, $matches);

      return empty($matches) ? $param : $matches[1];

    }
  }