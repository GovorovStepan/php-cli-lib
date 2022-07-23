# PHP CLI

README for other languages: [Русский](README.ru.md)

This repository is a sample of working with PHP in the console.

Compound:
- Mini library for creating console applications with the ability to call some registered command. It includes two classes and one interface. Located - src/lib/gsp
    - App - the main class for creating an application
    - Command - class for creating an application command
    - Handler - interface of the command logic handler when it is called
- A test application in which one command is registered that allows you to display the entered parameters in the console


## Logic of working with the library

To create an application you need:

 ```php
 // initialize an object of class App
$app = newApp();

// Register command
$app->bindCommand('show','testing description', new ShowArgs());

// Call execute() method and pass the data received from the console to it
$app->execute($argv);
 ```

When registering a command, we pass 3 arguments:
- Command name
- Description of the command to be displayed when help is called
- Command execution logic handler, it must implement the Handler interface


## Run test application
```sh
cd src
php app.php show {verbose,write} [log_file=app.log] [methods={create,update,delete}] [paginate=50] {log}
```


## License

MIT