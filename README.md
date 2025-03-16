# MarocExplore API - Documentation

## Introduction

**MarocExplore API** is designed to promote tourism in Morocco by allowing users to create, manage, and share personalized travel itineraries. Users can explore destinations, add activities, and save itineraries, making trip planning easier and more interactive.

## Table of Contents

- [Installation](#installation)
- [API Endpoints](#api-endpoints)
    - [Authentication](#authentication)
    - [Itineraries](#itineraries)
    - [Categories](#categories)
    - [Destinations](#destinations)
    - [Activities](#activities)
    - [Dishes](#dishes)
    - [To-Visits](#to-visits)
    - [Search & Filter](#search--filter)
- [Query Builder Examples](#query-builder-examples)
- [Testing](#testing)
- [Documentation](#documentation)

---

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/your-repo/marocexplore-api.git
   cd marocexplore-api
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Configure the environment:
   ```sh
   cp .env.example .env
   php artisan key:generate
   ```
4. Set up the database:
   ```sh
   php artisan migrate --seed
   ```
5. Run the server:
   ```sh
   php artisan serve
   ```

---

## API Endpoints

### Authentication

| Method | Endpoint  | Description     |
| ------ | --------- | --------------- |
| POST   | /register | Register a user |
| POST   | /login    | Login a user    |

### Itineraries

| Method | Endpoint                 | Description                      |
| ------ | ------------------------ | -------------------------------- |
| GET    | /itineraries             | List all itineraries             |
| POST   | /itineraries             | Create a new itinerary           |
| GET    | /itineraries/{id}        | Get a specific itinerary         |
| PUT    | /itineraries/{id}        | Update an itinerary              |
| DELETE | /itineraries/{id}        | Delete an itinerary              |
| POST   | /itineraries/{id}/save   | Save an itinerary                |
| DELETE | /itineraries/{id}/unsave | Remove itinerary from saved list |
| GET    | /user/itineraries        | Get saved itineraries            |

### Categories

| Method | Endpoint         | Description         |
| ------ | ---------------- | ------------------- |
| GET    | /categories      | List all categories |
| POST   | /categories      | Create a category   |
| PUT    | /categories/{id} | Update a category   |
| DELETE | /categories/{id} | Delete a category   |

### Destinations

| Method | Endpoint                              | Description                       |
| ------ | ------------------------------------- | --------------------------------- |
| POST   | /itineraries/{itinerary}/destinations | Add a destination to an itinerary |
| PUT    | /destinations/{id}                    | Update a destination              |
| DELETE | /destinations/{id}                    | Delete a destination              |

### Activities

| Method | Endpoint                               | Description                      |
| ------ | -------------------------------------- | -------------------------------- |
| POST   | /destinations/{destination}/activities | Add an activity to a destination |
| PUT    | /activities/{id}                       | Update an activity               |
| DELETE | /activities/{id}                       | Delete an activity               |

### Dishes

| Method | Endpoint                           | Description                 |
| ------ | ---------------------------------- | --------------------------- |
| POST   | /destinations/{destination}/dishes | Add a dish to a destination |
| PUT    | /dishes/{id}                       | Update a dish               |
| DELETE | /dishes/{id}                       | Delete a dish               |

### To-Visits

| Method | Endpoint                              | Description                           |
| ------ | ------------------------------------- | ------------------------------------- |
| POST   | /destinations/{destination}/to-visits | Add a place to visit to a destination |
| PUT    | /to-visits/{id}                       | Update a place to visit               |
| DELETE | /to-visits/{id}                       | Delete a place to visit               |

### Search & Filter

| Method | Endpoint            | Description                    |
| ------ | ------------------- | ------------------------------ |
| GET    | /itineraries/search | Search itineraries by keyword  |
| GET    | /itineraries/filter | Filter itineraries by category |

---

## Query Builder Examples

### Retrieve all itineraries with destinations

```php
$itineraries = DB::table('itineraries')
    ->join('destinations', 'itineraries.id', '=', 'destinations.itinerary_id')
    ->select('itineraries.*', 'destinations.name as destination')
    ->get();
```

### Filter itineraries by category and duration

```php
$filtered = DB::table('itineraries')
    ->where('category', 'beach')
    ->where('duration', '<=', 5)
    ->get();
```

### Search itineraries by keyword

```php
$search = DB::table('itineraries')
    ->where('title', 'LIKE', '%adventure%')
    ->get();
```

### Retrieve popular itineraries (most saved)

```php
$popular = DB::table('itineraries')
    ->leftJoin('saves', 'itineraries.id', '=', 'saves.itinerary_id')
    ->select('itineraries.*', DB::raw('COUNT(saves.id) as save_count'))
    ->groupBy('itineraries.id')
    ->orderByDesc('save_count')
    ->get();
```

---

## Testing

Run the following command to execute tests:

```sh
php artisan test
```



---

## License

This project is open-source and available under the MIT License.

