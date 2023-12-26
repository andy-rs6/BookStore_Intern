# Book Management API

This project is a simple Symfony application that provides API endpoints for managing books. It utilizes Symfony, Doctrine ORM, FOSRestBundle, and several other Symfony components. The API supports basic CRUD operations for books, including listing, viewing by ID, creating, updating, and deleting.

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/andy-rs6/BookStore_Intern
.git
    ```

2. Install dependencies using [Composer](https://getcomposer.org/):

    ```bash
    composer install
    ```

3. Set up your database configuration in the `.env` file.

## Dependencies

This project relies on the following third-party packages, which can be installed via Composer:

- `jms/serializer-bundle`: Serializer bundle for handling serialization/deserialization.
- `lexik/jwt-authentication-bundle`: JWT authentication bundle for securing endpoints.
- `nelmio/api-doc-bundle`: API documentation bundle for generating API documentation.

To install these dependencies, run:

composer require jms/serializer-bundle lexik/jwt-authentication-bundle nelmio/api-doc-bundle


## Usage

- API Endpoints

1. List Books

1.Get Book by ID

2.GET /book/{id}

3.POST /book/create
Body:

```json
{
    "title": "Sample Book",
    "author": "John Doe",
    "description": "A sample book description",
    "price": 19.99
}
```

4.PUT /book/edit/{id}
Body:

```json
{
    "title": "Updated Book Title",
    "author": "Jane Doe",
    "description": "An updated description",
    "price": 29.99
}
```

5.DELETE /book/{id}

##Pagination and Filtering
- You can include optional parameters page and pageSize to control pagination.
- Filtering by author is supported by providing the filter parameter.
  
## JWT Authentication
- JWT (JSON Web Token) authentication is implemented for securing the API. To authenticate, obtain a JWT token by making a request to the /api/login_check endpoint with valid credentials.
