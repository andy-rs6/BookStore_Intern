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

```bash
composer require jms/serializer-bundle lexik/jwt-authentication-bundle nelmio/api-doc-bundle
