<?php
  declare(strict_types=1);

  namespace GSP\CLI\interfaces;

  interface Handler
  {
    /**
     * Each handler must have an executing method
     *
     * @param string $name
     * @param array $args
     * @param array $params
     */
    public function execute(string $name, array $args, array $params);

  }