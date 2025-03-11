# Create a Symfony Application

Install Symfony CLI:

```shell
brew install symfony-cli/tap/symfony-cli
```

Create new Symfony API application:

```shell
composer require api
```

## Create a complex Symfony application

To create a new Symfony application inside the `app` directory for a headless application with a RESTful and socket-based API backend, follow these steps:

1. **Create the Symfony Application:**
   Use Composer to create a new Symfony project in the `app` directory.

   ```shell
   composer create-project symfony/skeleton app
   ```

2. **Install Required Packages:**
   Install the necessary packages for a RESTful API and WebSocket support.

   ```shell
   cd app
   composer require symfony/orm-pack
   composer require symfony/maker-bundle
   composer require symfony/serializer-pack
   composer require symfony/validator
   composer require symfony/websockets
   ```

3. **Configure the Database:**
   Update the `.env` file with your database configuration.

   ```dotenv
   DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
   ```

4. **Create API Endpoints:**
   Use the MakerBundle to generate a controller for your RESTful API.

   ```shell
   php bin/console make:controller ApiController
   ```

   Example `ApiController`:

   ```php
   // src/Controller/ApiController.php
   namespace App\Controller;

   use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
   use Symfony\Component\HttpFoundation\JsonResponse;
   use Symfony\Component\Routing\Annotation\Route;

   class ApiController extends AbstractController
   {
       /**
        * @Route("/api/data", name="api_data", methods={"GET"})
        */
       {
           $data = [
               'message' => 'Hello, this is your API data!',
           ];

           return new JsonResponse($data);
       }
   }
   ```

5. **Set Up WebSocket Server:**
   Create a WebSocket server using Ratchet or another WebSocket library.

   Example WebSocket server:

   ```php
   // src/WebSocket/Server.php
   namespace App\WebSocket;

   use Ratchet\MessageComponentInterface;
   use Ratchet\ConnectionInterface;

   class Server implements MessageComponentInterface
   {
       public function onOpen(ConnectionInterface $conn)
       {
           // Store the new connection
       }

       public function onMessage(ConnectionInterface $from, $msg)
       {
           // Handle incoming messages
       }

       public function onClose(ConnectionInterface $conn)
       {
           // Handle connection close
       }

       public function onError(ConnectionInterface $conn, \Exception $e)
       {
           // Handle errors
       }
   }
   ```

6. **Run the WebSocket Server:**
   Create a command to run the WebSocket server.

   ```php
   // src/Command/WebSocketServerCommand.php
   namespace App\Command;

   use App\WebSocket\Server;
   use Ratchet\Http\HttpServer;
   use Ratchet\Server\IoServer;
   use Ratchet\WebSocket\WsServer;
   use Symfony\Component\Console\Command\Command;
   use Symfony\Component\Console\Input\InputInterface;
   use Symfony\Component\Console\Output\OutputInterface;

   {
       protected static $defaultName = 'app:websocket-server';

       protected function execute(InputInterface $input, OutputInterface $output)
       {
           $server = IoServer::factory(
               new HttpServer(
                   new WsServer(
                       new Server()
                   )
               ),
               8080
           );

           $output->writeln('WebSocket server started on port 8080');
           $server->run();

           return Command::SUCCESS;
       }
   }
   ```

7. **Register the Command:**
   Register the WebSocket server command in `services.yaml`.

   ```yaml
   # config/services.yaml
   services:
       App\Command\WebSocketServerCommand:
           tags: ['console.command']
   ```

8. **Run the Application:**
   Start the Symfony server and the WebSocket server.

   ```shell
   symfony server:start
   php bin/console app:websocket-server
   ```

This setup provides a basic structure for a headless Symfony application with RESTful and WebSocket API support.
