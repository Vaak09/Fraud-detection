# Fraud Detection Application

The Fraud Detection Application is a Laravel-based web application designed to identify fraudulent activities by analyzing customer data. It leverages Laravel's robust framework to provide a seamless and efficient fraud detection process.


## Prerequisites

Ensure you have the following installed on your system:

- PHP >= 8.0
- Composer
- Node.js and npm
- A database (e.g., MySQL, PostgreSQL)

## Installation

Follow these steps to set up the application:

1. **Clone the repository**:
    ```bash
    git clone https://github.com/Vaak09/Fraud-detection.git
    cd Fraud-detection
    ```

2. **Install dependencies**:
    ```bash
    composer install
    npm install
    npm run dev
    ```

3. **Set up the environment**:
    ```bash
    cp .env.example .env
    ```
    Update the `.env` file with your database and other configuration details.

4. **Generate the application key**:
    ```bash
    php artisan key:generate
    ```

5. **Run migrations to set up the database**:
    ```bash
    php artisan migrate
    ```

6. **Start the development server**:
    ```bash
    php artisan serve
    ```

## Usage

Once the server is running, open your browser and navigate to `http://localhost:8000` to access the application.
## Docker Container

To simplify the setup process, a Docker container is available for this application. You can pull the pre-configured image from Docker Hub:

```bash
docker pull vzdeveloper/customers-api
```

### Running the Docker Container

1. **Pull the Docker image**:
    Ensure you have Docker installed on your system, then pull the image using the command above.

2. **Run the container**:
    ```bash
    docker run -d -p 8000:8000 --name fraud-detection vzdeveloper/customers-api
    ```

    This will start the application and map it to port `8000` on your local machine.

3. **Access the application**:
    Open your browser and navigate to `http://localhost:8000` to use the application.

For more details, visit the [Docker Hub page](https://hub.docker.com/r/vzdeveloper/customers-api).

