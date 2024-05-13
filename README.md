# Electricity Price Comparison API

Tariff Comparison

## Overview

The Electricity Price Comparison API is a RESTful service designed to facilitate the comparison of electricity tariffs based on provided consumption data. By leveraging this API, users can obtain insights into various electricity tariffs, aiding in making informed decisions regarding energy consumption and cost management.

## Getting Started

### Prerequisites

- Docker installed
- Docker Compose installed

### Installation

1. Clone the repository:

   ```bash
   git clone git@github.com:Maysarah/Electricity-price-comparison.git

### Run The project
1. Reach to the project folder:
   ```bash
   cd electricity-price-comparison

2. Copy the .env.example file to create a new .env file:
    ```bash
   cp .env.example .env

3. Update the .env file with your database configuration and other settings.

4. Install the composer to generate the vendor directory:
    ```bash
    composer install
5. If you face issues related to your platform requirements use:
    ```bash
    composer install --ignore-platform-reqs
6. Make sure the vendor directory is generated.
7. Build and start the Docker containers using Laravel Sail:
    ```bash
   ./vendor/bin/sail up -d

8. Generate an application key:
    ```bash
   ./vendor/bin/sail artisan key:generate

9. Run database migrations:
     ```bash
   ./vendor/bin/sail artisan migrate
10. The application should now be accessible at http://localhost.

### API Documentation
1. Visit http://localhost/api/documentation for API documentation Using Swagger.
2. However, You can find a postman collection "electricity-price-comparison.postman_collection" inside the project, So you can use it for API test

### Run Tests
1. To run the Unit test tests
    ```bash
   ./vendor/bin/sail artisan test
