# LaravelPing

**Interview task.** Small Laravel app that accepts device “ping” data (UUID + battery %) via a web form and stores it via the API.

## Run

```bash
cp .env.example .env
docker compose up -d
```

Then open the app in your browser at  `http://localhost:8000`.


## Architecture & Technology Stack

- **Backend:** [Laravel](https://laravel.com/) (PHP 8.4)
- **Frontend:** Laravel Blade + Vue 3 via CDN
- **Database:** MySQL 8 (Dockerized)
- **Containerization:** Docker Compose for easy local development
- **Composer:** Dependency management for PHP
- **Environment Variables:** Managed via `.env` file

### Architecture Overview

The app is a minimal Laravel project exposing an HTTP API and a simple web interface for submitting device data. Data is persisted in a MySQL database. Application and database services are run in Docker containers for a fully reproducible environment.

**Component Diagram:**

```
[Browser] 
    | 
    v 
[Laravel App (php:8.4-cli)] <-----> [MySQL (db)]
         |  
     [Composer]          
```

- The app service exposes port `8000` for HTTP.
- The MySQL service is set up with credentials from the Docker Compose file.
- All dependencies (PHP extensions, Composer, Laravel) are installed within the app container.


