# Readme

![Film follower screenshot](/docs/main-screenshot.png "Film follower screenshot")

## Introduction

[Film follower](https://filmfollower.philvigus.com) is a website designed and built to solve a problem my wife and I were having. We watch a lot of films through a service called [Cinema Paradiso](https://www.cinemaparadiso.co.uk/). We maintain a list of films we want to see, and they send us a random film from the list a couple of times a month.

The way we keep up-to-date with films is to watch trailers from [Trailer Adddict](https://www.traileraddict.com/) using their RSS feed. Before film follower, we were subscribed to the feed through my email, and would manually track films we wanted to watch using a spreadsheet. This was fiddly, time-consuming and generally awkward.

Film follower is the second version of the site. The original version of film follower was the first full-stack site I built, before I had a job in software development. You can find it's repository [here](https://github.com/PhilipVigus/trailers-express).

The new version has enhanced features including authentication, a full suite of unit and feature tests, client-side infinite scrolling, and the ability to leave reviews and ignore films you aren't interested in.

## Core technologies

| Area | Technologies |
|---|---|
| Language | [PHP](https://www.php.net/) |
| Stack | [Tailwind](https://tailwindcss.com/), [Alpine](https://alpinejs.dev/), [Livewire](https://laravel-livewire.com/), [Laravel (Jetstream)](https://jetstream.laravel.com/2.x/introduction.html) |
| Database | [PostgreSQL](https://phpunit.de/) |
| Testing | [PHPUnit](https://phpunit.de/) |

## Using the site

The core functionality of the site allows you to watch film trailers, shortlisting films you are interested in. After watching a film, you can also leave a review.

Trailers are automatically added to the site on a daily basis, and appended to all users' lists to watch.

Users can ignore types of film they aren't interested in using tags that every film is assigned by Trailer Addict, and you can see all films linked to a specific tag.

There is also a general search function on each of the lists you maintain, which utilises [fuse](https://fusejs.io/) to implement fuzzy results.

Lastly, there is a guest user account is provided, with restricted ability to edit account details.

## Running the code locally

1. Clone this repository

2. Ensure you have PostgreSQL running, and create a database called film_follower

3. Create a .env file, using .env.example as a template, paying particular attention to the database values.

4. Run the following commands

```bash
npm install

npm run dev

composer install

php artisan migrate:fresh

php artisan serve
```

You should then be able to access to the site on `http://localhost:8000/`

There are two options for seeding the database. The following will fill the database with completely faked data.

```bash
php artisan db:seed
```
Alternatively, you can run the following command, which clears the database before pulling real data from the rss feed.

```bash
php artisan film-follower:clear-and-seed-real-data
```

## Tests
There are 127 unit and feature tests. These include a mix of tests provided with Jetstream, and those written as part of development of the site itself. They can be run with the command `php artisan test`

## User stories

- As a user, so that my lists can only be accessed by me, I want to be able to register an account on the site. 
- As a user, so that only I can access my account, I want to be able to login to the site.
- As a user, so that my account is only accessible by me, I want to be able to log out of the site.
- As a user, so that I can update access to the site, I want to be able to change my password.
- As a user, so that I can leave no personal details if I decide I don't like the site, I want to be able to delete my account.
- As a user, so that I can work my way through films I might be interested in, I want to have a list of films/trailers whose trailers I have not seen yet.
- As a user, so that I can keep track of films I want to see, I want to be able to add films to a shortlist.
- As a user, so that I can remember films I have seen, I want to be able to review films I have seen.
- As a user, so that I can hide films I'm not interested in, I want to be able to add films to an ignored list.
- As a user, so that I have access to the most recent trailers, I want new trailers to be automatically added to my trailers to watch.
- As a user, so that I can easily view trailers, I want to be able to click links that take me directly to trailers on Trailer Addict.
- As a user, to keep my lists organised, I want trailers to be grouped by the films they are advertising.
- As a user, so that I can ignore general types of film, I want to be able to ignore all films with a given tag.
- As a user, so that I can ignore general types of trailer, I want to be able to ignore trailers with specified text in their titles.
- As a user, so that I can prioritize files to watch, I want to be able to add a rating to films in my shortlist.
- As a user, so that I can remember films on my shortlist, I want to be able to add a comment to each film.
- As a user, so that I can change my mind or undo a mistake, I want to be able to remove a film from my reviews, shortlist or ignored films lists.
- As a user, so that it is easier for me to find films I am interested in, I want to be able to search each of my lists.
- As a user, so that it is easier for me to find films I am interested in, I want to be able to see all films with a specific tag.
- As a user, so that I can easily navigate the tags on the site, I want to be able to search through all of the tags on the site.
- As a guest, so that I don't have to register to see what the site can do, I want to be able to login with a guest account that is already set up.

## Development

Development was dividing into rough 'sprints'. These were used more loosely than sprints in a full agile development team, just dividing up the user stories and development into logical chunks of roughly the same length.

Being one of the main user of the site, my wife was able to help clarify questions I had, filling in gaps in user stories and general functionality.

My choice of technologies was motivated by wanting to practice and demonstrate skills and knowledge used in my role as developer at Mumsnet. I chose to use Jetstream because it provided a starter application with all of the key, TALL stack technologies set up.

Regularly pulling trailers from the RSS feed is implemented as a job, set to run every 24 hours. This is checked for using a cron-job on the server.

Infinite scrolling prevents the site attempting to load too many images at once on initial load.

## Database

![ERD Diagram](/docs/erd-diagram.png "ERD Diagram")

## Deployment

The site is deployed to AWS using an EC2 instance. The instance includes both the Laravel application and PostgreSQL database. I am aware that using an RDS managed database would provide a more resilient setup, but was keen to explore setting up the application, Apache server and database together.

## Challenges

### The MVP

I started development with an MVP consisting of the following functionality:
-   Get the latest films and trailers
-   Display all films and trailers
-   Allow you to watch the trailers on the list

This seemed relatively straightforward. However, partway through implementation I found that my database design had a number of issues with it.
- I had not accounted for the fact that when a film was moved back, for example from reviews to the shortlist, my wife wanted to keep any data related to the film at that stage in case the move was by accident. For example, a reviewed film has a rating and optional comment. When moving the film from the reviews to shortlist, she wanted to have the option to keep those in the database.

  This led to a redesign of the database, separating out data relating to the different lists into its own tables.

- I generally found that my database design was not quite fully formed enough, which led to a number of smaller issues that I had to resolve as I worked through the implementation.

### Laravel Jetstream

I chose to start with Jetstream as it had all of the necessary elements of the TALL stack set up. However, as I progressed through the project I realised that it contained a lot of functionality I just didn't need. It also made it more difficult to implement certain features such as additional middleware.

If I were to work on a similar project in the future, I would probably start with a more stripped-down setup, adding and implementing features and technologies myself. This would result in a much cleaner codebase containing only what was absolutely necessary.

### RSS feed encoding

I had a lot of problems with the way that the RSS feed was encoded. Based on the information provided in the feed itself I initially assumed it was utf-8. However, there were still issues with saving certain characters to the database.

After a lot of experimentation and debugging, I eventually resorted to a backup function that manually converted any remaining 'difficult' characters.

### Film tags and trailer tags

My initial implementation included tags for both films and trailers, set up as a polymorphic relationship in the database. However, partway through the project I realised there were only an extremely small number of cases where the tags associated with a film's trailers differed from those on the film itself. On this basis I decided to simplify my implementation considerably by only having tags associated with films.

### Livewire hydration

Livewire provides a link between the PHP backend and JS frontend. On the frontend, whenever changes are made to livewire component properties, the JS representation is rehydrated, recreating the object. During implementation of the tags view I discovered an issue where the tags were not hydrating correctly, and were missing the number of films that each tag was associated with.

Fixing this proved to be quite difficult. After raising the issue on the Livewire Github page, it was suggested that I change from using a Laravel collection to an array, which fixed the problem. I have since seen similar issues on other projects, both personal and professional and my understanding helped a lot with resolving them.

### Importing data from the first version of the site

We had a lot of shortlisted films stored on the site's first version in a MongoDB database, and this information had to be imported into PosgreSQL. The main issue I had with this was needing to clean up the imported data before storing it in the new database. In particular, there was a section of corrupted data that I could not import at all, as it was missing key fields.

### Deployment

The main issue I had during deployment was associating the `https://filmfollower.philvigus.com/` subdomain with the EC2 instance. Due to the way I had setup my portfolio site on Netlify, I effectively had to delete my entire DNS setup and start again, which took a bit of research and experimentation.
