# Laravel Filament Project

This is a Laravel project using **PHP 8+**. The project includes the following key libraries:

-   [Filament Shield](https://github.com/bezhanSalleh/filament-shield) for Role-Based Access Control (RBAC).
-   [Rupadana API Service](https://github.com/rupadana/api-service) for creating and managing API services.

## Installation

Follow these steps to install and set up the project:

### Prerequisites

-   PHP 8.0 or higher
-   Composer
-   MySQL or another supported database
-   Node.js and npm (optional, if you need to compile assets)

### Steps

1. **Clone the repository:**

    ```bash
    git clone https://github.com/mohammadisa2/blog.git
    cd blog
    ```

2. **Install dependencies:**

    ```bash
    composer install
    npm install && npm run dev  # If you need to compile assets
    ```

3. **Environment setup:**
   Copy the `.env.example` to `.env` and adjust your environment variables, including `APP_URL`, `DB_*`, and other necessary configurations.

    ```bash
    cp .env.example .env
    ```

4. **Generate application key:**

    ```bash
    php artisan key:generate
    ```

5. **Run migrations:**

    ```bash
    php artisan migrate
    ```

6. **Run seeder (if applicable):**

    ```bash
    php artisan db:seed
    ```

7. **Serve the application:**

    ```bash
    php artisan serve
    ```

8. **Install Filament Shield (for RBAC):**
   You can follow the Filament Shield documentation [here](https://github.com/bezhanSalleh/filament-shield) to set up roles and permissions.

9. **Set up Rupadana API Service (for API):**
   The Rupadana API Service documentation can be found [here](https://github.com/rupadana/filament-api-service).

## API Documentation

### 1. Get Blogs with Category Filter

This endpoint retrieves blogs, including their category relation, and allows filtering based on the `category.slug`.

**Endpoint:**

```http
GET {{APP_URL}}/api/admin/blogs?include=category&filter[category.slug]=computer
```

-   **Parameters:**
    -   `include=category` – Includes the category relation.
    -   `filter[category.slug]=<slug>` – Filters the blogs by the slug of the category.

### 2. Sorting Blogs by ID in Descending Order

To sort blogs by `id` in descending order:

**Endpoint:**

```http
GET {{APP_URL}}/api/admin/blogs?sort=-id
```

-   **Parameters:**
    -   `sort=-id` – Sorts the blogs by ID in descending order.

### 3. Get Blog Details by Slug (with Category Relation)

This endpoint fetches a specific blog by its slug, including its category relation.

**Endpoint:**

```http
GET {{APP_URL}}/api/admin/blogs/ex-qui-soluta-archit?include=category
```

-   **Parameters:**
    -   `include=category` – Includes the category relation in the response.

### 4. Get All Categories

This endpoint retrieves all available categories. No additional parameters are required since no relations are involved.

**Endpoint:**

```http
GET {{APP_URL}}/api/admin/categories
```

---

This documentation provides basic API interaction for the blog and category entities. Ensure you set the correct `APP_URL` in your `.env` file to correspond to your environment.
