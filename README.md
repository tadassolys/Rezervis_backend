# Rezervis Backend

This is the backend for the Reservation Management System, built using Laravel. It provides APIs for managing room, equipment, and vehicle reservations. The backend handles user authentication, CRUD operations for reservable items, and reservation management.

## Features

- User authentication using Laravel Sanctum
- CRUD operations for rooms, equipment, and vehicles
- Filtering of items based on reservation status
- Reservation management, including creation, updating, and cancellation

## API Endpoints

### Authentication

- `POST /api/register`: Register a new user
- `POST /api/login`: Login an existing user
- `POST /api/logout`: Logout the current user

### Rooms

- `GET /api/rooms`: List all rooms with optional status filtering
- `GET /api/rooms/{id}`: Show details for a single room
- `POST /api/rooms`: Create a new room
- `PUT /api/rooms/{id}`: Update an existing room
- `DELETE /api/rooms/{id}`: Delete a room

### Equipment

- `GET /api/equipment`: List all equipment with optional status filtering
- `GET /api/equipment/{id}`: Show details for a single piece of equipment
- `POST /api/equipment`: Create new equipment
- `PUT /api/equipment/{id}`: Update existing equipment
- `DELETE /api/equipment/{id}`: Delete equipment

### Vehicles

- `GET /api/vehicles`: List all vehicles with optional status filtering
- `GET /api/vehicles/{id}`: Show details for a single vehicle
- `POST /api/vehicles`: Create a new vehicle
- `PUT /api/vehicles/{id}`: Update an existing vehicle
- `DELETE /api/vehicles/{id}`: Delete a vehicle

### Reservations

- `GET /api/reservations`: List all reservations
- `POST /api/reservations`: Create a new reservation
- `GET /api/reservations/{id}`: Show details for a single reservation
- `PUT /api/reservations/{id}`: Update an existing reservation
- `PATCH /api/cancel-reservation/{id}`: Cancel a reservation
- `DELETE /api/reservations/{id}`: Delete a reservation

### Middleware

- `auth:sanctum`: Protects routes to ensure only authenticated users can access them

## Database Setup

1. **Download `rezervis.sql`.**
2. **Create a new database in MySQL named `rezervis`.**
3. **Insert the data from the `rezervis.sql` file into the newly created database.**

## Starting the Application

1. **Run MySQL using XAMPP (or similar tool).**
2. **Create a database named `rezervis` and load the provided SQL data into MySQL.**
3. **Navigate to the cloned `Rezervis_backend` folder, open a terminal in that folder, and run:**

    ```sh
    composer install
    ```

4. **Then run:**

    ```sh
    php artisan serve
    ```