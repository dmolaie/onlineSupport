<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
</p>

## About Project

This project for test interview with a company of UAE.

Keep in mind that in this test according to the time and the document of project we don't <b> have access controller list</b> and I didn't consider it.

## How To Run

Please Step by Step go on:
- **1- clone project from repository**
- **2- go to directory project and run this command :**
- docker-compose up --build -d
- docker exec -it onineSupport-app bash
- composer install --no-dev
- php artisan migrate
- exit

Note:
- all apis Other than register and login you need send request:
```json
  authorization: Bearer ********token********
```

- all apis you need send request in header:
```json
  Accept: application/json
```

### List of api

- **register**
- http://localhost:8000/api/v1/user/register <br>
method: POST<br>
inputs is:  <br>
email, password, password_confirmation


- **login**
- http://localhost:8000/api/v1/user/register <br>
method: POST<br>
inputs is: <br>
email, password

- **Create question user customer by status noAnswered**
- http://localhost:8000/api/v1/question/create <br>
method: POST<br>
inputs is: <br>
title, description

- **list question by user customer**
- http://localhost:8000/api/v1/question/listCustomerQuestion <br>
method: GET<br>
inputs is: <br>
title, description

- **Change status question**
- http://localhost:8000/api/v1/question/changeStatus <br>
method: POST<br>
inputs are: <br>
question_id, status</br>
[<b>noAnswered ,inProgress ,answered, spam</b>]


- **list question by user support with filter name and status**
- http://localhost:8000/api/v1/question/listQuestionSupport <br>
method: POST<br>
inputs is: <br>
user_name, status

- **create answer by support user with status question inProgress**
- http://localhost:8000/api/v1/answer/support/create <br>
method: POST<br>
inputs is: <br>
description, question_id

- **create answer by customer user with status question noAnswered**
- http://localhost:8000/api/v1/answer/create <br>
method: POST<br>
inputs is: <br>
description, question_id


- **change status question to answered by user support**
- http://localhost:8000/api/v1/answer/support/change-answered <br>
method: POST<br>
inputs is: <br>
description, question_id


- **command run for cron job change status question after 24 hour**
- php artisan: question:answered <br>

### Output
format all response of api like:

```json

{
    "data": {
        "id": 1,
        "name": "dfdfdfd",
        "email": "d2@d.com",
        "token": "1|3VYkOCDH7wHlmVrkrcjqxqKXP90YN7F1khi7ohA5"
    },
    "status_code": 200,
    "message": "register successful"
}
```
### Export file postman

the export file postman are in project root directory with name:<br>
- postman_collection.json
