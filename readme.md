# Simple REST example based on Laravel framework.


To start:
1. Checkout
2. Set DB info into .env file
3. Run DB migration:
```php
php artisan migrate
```
4. make sure that route looks like this:

```php
php artisan route:list
```

### Output

| GET|HEAD | /                     |
|----------|-----------------------|
| POST     | api/v1/customers      |
| GET|HEAD | api/v1/customers      |
| DELETE   | api/v1/customers/{id} |
| PATCH    | api/v1/customers/{id} |
| GET|HEAD | api/v1/customers/{id} |
| PUT      | api/v1/customers/{id} |


## Supported actions:

### GET all
```
curl -H "Content-Type: application/json" -X GET <Your URL>api/v1/customers
```

### POST
```
curl -H "Content-Type: application/json" -X POST -d '{"name":"user 7","email":"seven@mail.com", "address":"seven address"}' <Your URL>api/v1/customers
```

### GET by id
```
curl -H "Content-Type: application/json" -X GET <Your URL>api/v1/customers/1
```

### PUT
```
curl -H "Content-Type: application/json" -X PUT -d '{"name":"Modified seven","email":"third@mail.com", "address":"thirdaddress new"}' <Your URL>api/v1/customers/7
```

### PATCH
```
curl -H "Content-Type: application/json" -X PATCH -d '{"address":"seven new address"}' <Your URL>api/v1/customers/7
```

### DELETE
```
curl -H "Content-Type: application/json" -X DELETE <Your URL>api/v1/customers/7
```


