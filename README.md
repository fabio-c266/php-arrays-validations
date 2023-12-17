# Arrays Validations

![PHP](https://img.shields.io/badge/PHP-777BB4.svg?style=for-the-badge&logo=PHP&logoColor=white)
![Composer](https://img.shields.io/badge/Composer-885630.svg?style=for-the-badge&logo=Composer&logoColor=white)

> A simple code to validate data from an array, if a key needs to be of a certain type, minimum or maximum number of characters, etc...

## 💻 Require:

- PHP >= 8.0
- Composer

## 🚀 Running the project

## 1.
```
composer install
```

## 2.
```
php src/index.php
```

## ☕ Usage Example

```php
$dataSchema = [
    "id" => ["string", "required"],
    "username" => ["string", "required", "minLen: 3", "maxLen: 16"],
    "avatar_url" => ["string", "optional"],
];

$data = [
    "id" => "dawdadawd",
    "username" => "dwadawdaw"
];

try {
    $schema = new Schema();
    $dataValidated = $schema->validate(schema: $dataSchema, data: $data);
    var_dump($dataValidated);
} catch (Exception $except) {
    //$execept->getMessage() return the first error from validate errors
}
```
