# bollo_web
A compact web API written in PHP aimed to work aside with the main project Bollo

For a live preview visit bollo [website](http://bollo-server.bitnamiapp.com/bollo_web/)

# API Documentation

## Section: Bakeries
###'bakery.php' module - Located at [api/v1/bakeries]

#### Valid Parameters:
- **id**: A valid bakery id.
- **all**: If you want to fetch all the bakeries at the same time.
- **stock**: if you want to modify the bakery stock.
	- **[keep]**: If you want to keep the current stock and just add the new one. It is, of course, optional and no requires value.

#### Valid parameter combinations:
- **id**:
	- Alone
	- stock
	- stock and keep
- **stock**
	- keep
- **all**:
	- Alone

Any other combination will throw an message error with code 15.
#### Usage examples:

To fetch the information of the bakery with id 1

> host/api/v1/bakeries/bakery.php?id=1


And the response is:
```json
{
    "code": 0,
    "message": "Ok!",
    "bakery": {
        "id": "1",
        "name": "Delipan",
        "province": "3",
        "city": "Paraíso",
        "stock": "0",
        "progress": 250,
        "status": "Dividiendo la masa"
    }
}
```

To fetch the information of all the bakeries in the database, use:

> host/api/v1/bakeries/bakery.php?all

And the response is:
```json
{
    "code": 0,
    "message": "Ok!",
    "bakeries": [
        {
            "id": "1",
            "name": "Delipan",
            "province": "3",
            "city": "Paraiso",
            "stock": "0",
            "progress": 250,
            "status": "Dividiendo la masa"
        },
        {
            "id": "2",
            "name": "Cali",
            "province": "3",
            "city": "Turrialba",
            "stock": "0",
            "progress": 520,
            "status": "Horneando el pan"
        },
        {
            "id": "3",
            "name": "San Antonio",
            "province": "3",
            "city": "Tucurrique",
            "stock": "0",
            "progress": 900,
            "status": "Inactiva"
        }
    ]
}
```

Note that array attribute named 'bakeries' containing the information of an individual bakery as an object.

#### Response codes:

Code | Message
--------|-----------
0 | Ok
1 | Bakery not found
15 | Missing or invalidad combination of params.


## 'create.php' module - Located at [api/v1/bakeries]

#### Valid parameters;
* **name**: The name of the new bakery to insert. Cannot exists in the Database.
* **state**: The state or province where the bakery is located. Must be an integer between 1 and 7
* **city**: The city where the bakery is located

#### Valid parameter combinations:
**ALL the parameters must be present in the call at the same time**, if at least one is omitted an error code 15 will be thrown.


#### Usage examples:

The use is pretty straight-foward:

>host/api/v1/bakeries/create.php?name=Delipal&state=3&city=Paraíso.

And, if all the information is correct (actually, if does not exist a previous bakery with the provide name) the response will look like this:

```json
{
	"code": 0,
	"message": "Ok"
}
```

#### Response codes:

Code | Message
--------|-------------
0 | Ok
1 | Error inserting the bakery
15 | Missing parameters

Error code 1 is thrown when the bakery already exists.

## 'modify.php' module - Located at [api/v1/bakeries]

### Valid parameters:
- **id**: The bakery's id which is being edited.
- **name**: The new name of the bakery.
- **state**: The new state/province of the bakery (remember, an integer between 1 and 7)
- **city**: The new city of the bakery.

### Valid parameter combinations:
**All the parameters must be present at the same time**

### Usage example

To edit the information of bakery with id 13

> host/bollo_web/api/v1/bakeries/modify.php?id=13&name=Jari&state=1&city=Paraiso

And the corresponding response (in success) would look like this:

```json
{
	"code": 0,
	"message": "Ok!"
}
```

### Server code responses

Code | Message
-------|------------
0 | Ok
1 | Name already used
15 | Missing parameters

## 'status.php' module - Located at [api/v1/bakeries]

### Valid parameters:

- **id**: The id number of the bakery whose status is being fetched.
- **progress**: The integer corresponding to the current progress of the bakery.
- **description**: A brief description about the current operation being perfoermed in the bakery.

### Valid parameter combinations:
- **id**:
	- Alone: to fetch the status of the bakery with such id.
	- progress & description: To update the current progress of the bakery with such id.

### Usage examples:

To fetch the current status of the bakery with the id 1

> host/bollo_web/api/v1/bakeries/status.php?id=1

The corresponding response (if and only if the bakery exists) would look like this:

```json
{
	"code": 0,
	"message": "Ok!",
	"progress": 10,
	"status": "Mezclando Ingredientes"
}
```

To set the current progress of the bakery with id 2 use:

> host/bollo_web/api/v1/bakeries/status.php?id=2&progress=90&description=Mezclando Ingredientes

The response:

```json
{
    "code": 0,
    "message": "Ok"
}
```

### Server code responses

Code | Message
-------|------------
0 | Ok
1 | Bakery not found
15 | Missing parameters

## 'production.php' module - Located at [api/v1/bakeries]

### Valid parameters:

- **id**: The id number of the bakery whose status is being fetched.
- **quantity**: The number of bread pieces produced.
- **all**: Used to fetch the production of all the bakeries.

### Valid parameter combinations:
- **id**:
	- Alone: To fetch the production of a specific bakery.
	- quantity: To add a new quantity of produced bread to a bakery.
- **all**:
    - Alone: to fetch the production of all the bakeries.

### Usage examples:

To fetch the production the bakery with the id 1

> host/bollo_web/api/v1/bakeries/production.php?id=1

The corresponding response (if and only if the bakery exists) would look like this:

```json
{
    "code": 0,
    "message": "Ok",
    "data": [
        {
            "bakery": 1,
            "date": "12-11-2015",
            "quantity": 220
        },
        {
            "bakery": 1,
            "date": "16-11-2015",
            "quantity": 105
        }
    ]
}
```

To update the production of the bakery with id 22 use:

> host/bollo_web/api/v1/bakeries/production.php?id=22&quantity=90

The response:

```json
{
    "code": 0,
    "message": "Ok"
}
```

### Server code responses

Code | Message
-------|------------
0 | Ok
1 | Bakery not found
15 | Missing parameters


## 'notifier.php' module - Located at [api/v1/bakeries]

### Valid parameters:

- **token**: The telegram's bot token.
- **chatid**: The telegram bot's chat id.
- **msg**: The text of the message to be sent with the bot.

### Valid parameter combinations:
- All parameters must be present.

### Usage examples:

To notify about a bakery being closed down:

> host/bollo_web/api/v1/bakeries/notifier.php?token=some_valid_token&chatid=45635&msg=Bollo #1 ha sido clausarada

The corresponding response would look like this:

```json
{
    "code": 0,
    "message": "Ok"
}
```

### Server code responses

Code | Message
-------|------------
0 | Ok
15 | Missing parameters

## Section: Reports

### 'logbook.php' module - Located at [api/v1/bakeries]

#### Valid parameters:

* **bakery**: The bakery ID which the information will be retrieved.
* **event**: Set this parameter (with no value) to retrieve the all the events.
* **problem**: Set this parameter (with no value) to retrieve the problems.

#### Valid parameter combination:

* **bakery** with:
	* *Alone*
	* problem: To get only the problems of the specified bakery.
	* event: To get only the events of the specified bakery.
* **problem** with:
	* *Alone*
* **event** with:
	* *Alone*

Any attempt to make a different combination than the shown above will throw an error code 15.

#### Usage examples:
To retrieve the general entries in the logbook of the bakery with ID # 1

> host/api/v1/reports/logbook.php?bakery=1

The response should looks like this (if the bakery exists):
```json
{
    "code": 0,
    "message": "Ok!",
    "events": [
        {
            "id": 1,
            "bakery": {
                "id": 1,
                "name": "Delipan Centro",
                "province": 3,
                "city": "Paraiso",
                "stock": 0
            },
            "description": "Mezclando la masa",
            "date": "26-10-2015",
            "hour": "04:45:03"
        }
    ]
}
```

The returning JSON document contains the whole information about the bakery being consulted.

Note that the returning "events" member is a JSON Array that contains LogBook objects.

------

To retrieve the problems entries of an specific bakery:

> host/api/v1/reports/logbook.php?bakery=1&problem

The response (in case of success) will look like this

```json
{
    "code": 0,
    "message": "Ok!",
    "events": [
        {
            "id": 2,
            "bakery": {
                "id": 1,
                "name": "Delipan Centro",
                "province": 3,
                "city": "Paraiso",
                "stock": 0
            },
            "description": "Residuos fecales",
            "date": "26-10-2015",
            "hour": "04:45:09",
            "dough": 15
        }
    ]
}
```

Again, note that the returning "events" member is a JSON Array that contains LogBook objects.

------

### 'Forgot' module - Located at [api/v1/users/forgot.php]

#### Brief introduction:
This interface provides the user a way to reestablish its password just by providing a couple of valid parameters

#### Valid parameters:
- **api_token**: refers to the application programming interface security token. It is unique and it should be kept secret.
- **user_email**: refers to the email of the user whom forgot its password.

#### Procedure:
First, the api_token is checked, if the same is encountered valid the process is started, and it works as follows:
A random token is generated for the user with the email provided, this token is stored into the database bollo_db at the table bollo_user in the column user_forgot_token and will be emailed to the user_email as an URL with the following format:
> HOST/bollo_web/public/forgot.php?token=$TOKEN

where a simple form will be filled with the new password details.

#### Usage example:
> HOST/bollo_web/api/v1/users/forgot.php?api_token=XX&email=YY

Where XX must be a valid token generated by this API and YY is valid previous-registered email address.

#### Server response:
The server response will be a JSON file containing a code response and a message. The code response is a number and it is decoded according to the next table:

Code | Meaning
-----|--------
0 | Success!
1 | Could not send email
2 | The email does not exists
15 | Missing parameters

It is important to mention the message is written in English so It should not be used in the ui of the program. Instead, decode the code response.

Response example:
```json
{
    "code": 0,
    "message": "Ok"
}
```

### 'Sign up' module – Located at [api/v1/users/signup.php]

#### Brief introduction:
This interface provides the user a way to register a new user into the bollo database.

#### Valid parameters:
- **api_token**: refers to the application programming interface security token. It is unique and it should be kept secret.
- **firstname**: this parameter represents the first name of the user being registered. Max length is 60 characters.
- **lastname**: this parameter represents the last name of the user being registered. Max length 60 characters.
- **username**: this parameter represents the chosen username, it must have a max length of 20 characters and it cannot previously exists in the database.
- **password**: this parameter represents the sha1 hash of the user's password.
- **email**: this parameter represents the email of the user. It must be a real and valid email address in order to activate the account and recover the password in the future.
- [**telegram**]: this parameter represents the telegram's phone number of the username. This is important for further implementation of Telegram API into Bollo. This is optional

#### Procedure:
As usual, the first step is to check whether the api_token parameter is a valid API token. After this check, all the inputs are sanitized and the user is inserted into the database. If it fails to insert, then another user have provided the same username/email; else an activation token is generated and saved into the database at the table bollo_inactive_account along with username. Also, the basic information is emailed to user's email address.

#### Usage example:
> $HOST/bollo_web/api/v1/users/signup.php?api_token=XX&firstname=Name&lastname=Lastname&username=nick&password=sha1-hash&email=abc@abc.xyz&telegram=richin13

#### Server response:
The server response will be a JSON file containing a code response and a message. The code response is a number and it is decoded according to the next table:

Code | Meaning
-----|--------
0 | Success
1 | Connection error
2 | User already exists
15 | Missing required parameters

Response example:
```json
{
    "code": 0,
    "message": "Ok"
}
```
