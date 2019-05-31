# Tweety

This is a basic Twitter bot

## Installation

To install, clone the repository to your preferred location on your machine:

```
$ git clone git@github.com:Jolaolu/Tweety.git tweety
```

Next, `cd` to the directory of the project.

```
$ cd tweety
```


Make a copy of the `.env.example` file and name it `.env`

```
$ cp .env.example .env
```

Generate a new application key using `artisan`

```
$ php artisan key:generate
```

Add your twitter tokens and consumer keys generated from your developer account app in the .env file

```
TWITTER_CONSUMER_KEY = xxxxxx
TWITTER_CONSUMER_SECRET = xxxxx
TWITTER_ACCESS_TOKEN = xxxx
TWITTER_ACCESS_TOKEN_SECRET = xxxx
```

Next, install the dependencies for the project using the following command:

```
$ composer install

```

Serve the project using `artisan`

```
$ php artisan serve
```

Then check it on http://localhost:8000

