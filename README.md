Purpose

The purpose of this API is to provide a robust, scalable, and secure backend system for managing the application's functionality. With performance as a priority, all APIs are optimized to respond in under 400 milliseconds, ensuring a seamless user experience.

Key Features

Secure Routes: All routes are protected to ensure only authenticated and authorized users can access the system. Security measures include token-based authentication.

Docker Support: The entire project is containerized using Docker to facilitate easy deployment and environment consistency.

API Documentation: Swagger is integrated for clear and interactive API documentation, making it easier for developers to understand and test endpoints.

Repository Structure: We have implemented the repository pattern with interfaces, ensuring clean and maintainable code.

Prerequisites

Docker and Docker Compose installed

PHP installed (for running artisan commands)

Composer installed

MySQL or your preferred database system configured

Setup and Run

Follow these steps to set up and run the project:

Start the application using Docker Compose:

sudo docker-compose up -d

Run migrations to set up the database schema:

php artisan migrate

Seed the database with initial data:

php artisan db:seed

Optional: Seed specific translations data:

php artisan db:seed --class=TranslationSeeder

Testing

We ensure quality and reliability by testing the repository using the php artisan test command. Make sure to run the tests after setting up the project to confirm everything is working as expected.

Documentation

Access the Swagger documentation to explore and test the API endpoints:

Swagger UI is available at: http://localhost:6162/api/documentation

Additional Notes

Performance: All APIs are designed to execute in under 400 milliseconds, ensuring high performance.

Environment: Use .env to configure environment-specific variables.
