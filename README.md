# API-ADV

## Prerequisites

Before you begin, ensure you have Docker and Docker Compose installed on your system.

## Usage Instructions

### Clone the Repository

```bash
git clone https://github.com/assuncaofranco/api-adv.git
cd api-adv
```

# Start the Services with Docker Compose

```bash
docker-compose up
```

This command will build the images (if necessary) and start the containers defined in the docker-compose.yml file.

Access the Application
Once Docker Compose has started the services, you can access the application in your browser using the following URL:

http://localhost

Stopping the Services
To stop and remove the containers, networks, and volumes created by docker-compose up, run:

```bash
docker-compose down
```

## Additional Information
Logs
To view the logs of the services, use:

```bash
docker-compose logs
```

## Execute Commands in a Container

To run commands inside a running container, use:
```bash
docker-compose exec <service-name> <command>
```

## For example, to access a bash terminal:
*To access a bash terminal in the app service:

```bash
docker-compose exec app bash
```
To access a bash terminal in the db service:

```bash
docker-compose exec db bash
```

To list files in the app service:

```bash
docker-compose exec app ls
```
# Contributing
If you would like to contribute to this project, please fork the repository and submit a pull request with your improvements.

## License
This project is licensed under the MIT License.
