# Readme

https://trello.com/b/Xxo9CwvF/movies

## Requirements

-   Register
-   Log in
-   Log out
-   Change password
-   Specify tags to ignore/highlight
-   Delete account

-   Regularly get the latest trailers from the RSS feed

-   Display all trailers that have a specific tag or tags
-   Display all trailers I haven't seen yet
-   Display my shortlist
-   Display films I've seen
-   Display trailers I'm ignoring
-   Search/filter any of the above

-   General search

-   Shortlist a trailer with a priority and optional description
-   Unshortlist a trailer
-   Review a film I've seen from the shortlist with an optional description
-   Unreview a film
-   Put a trailer on my ignore list
-   Take a trailer off my ignore list

-   Seed a 'guest' user for people who want to view the site with it partially populated
-   Regularly reseed the 'guest' user data

## MVP

-   Get the latest films and trailers
-   Display all films and trailers
-   Allow you to watch the trailers on the list

### User stories

-   As a user, so that I can watch the latest trailers, the site must get the latest trailers from the RSS feed
-   As a user, so that I can choose which trailers I want to watch, I must be able to see a list of trailers to watch
-   As a user, so that I can watch a trailer, I must be able to click a link and watch a trailer

## Sprint 1

-   Display my shortlist
-   Display all films I haven't shortlisted yet
-   Shortlist a film with a priority and optional comment
-   Edit a shortlisted film
  - Change its priority and/or comment

## Sprint 2

- Unshortlist a film
  - Decide whether to delete existing priority or not
- Display films I've seen
- Add a review to a film
  - Stars out of 5
  - Optional comment
- Unreview a film
  - Decide whether to delete existing stars and comment or not
- Edit a review
  - Change its existing stars and comment

## Sprint 3

-   Display films I'm ignoring
-   Put a film on my ignore list
-   Take a film off my ignore list
-   Display all films that have a specific tag

## Sprint 4
-   Specify tags to ignore/highlight
-   Specify trailer types to ignore/highlight

- ignore films by tag
  - create an ignored-film-tags table
  - add relationships to the models
  - update the ignored livewire view to include these ignored films

- ignore trailers by tag
  - create an ignored-trailer-tags table
  - add relationships to the models
  - hide films in lists where all trailers are ignored
  - hide trailers which have an ignored tag in the to shortlist view

- ignore trailers my words in trailer title
  - create an ignored_trailer_words table
  - add relationships to the models
  - hide trailers which have ignored words in their titles from the to shortlist view

## Sprint 5
- Draft gui
  - basic colour scheme
  - components
  - layouts

## Sprint 6
- Tags
  - Add/remove ignored tags
  - Individual tag view
- Search
  - Add search/filter to each page

- Add a tags view
- List the most common tags
- Show ignored tags
- Allow users to add/remove ignored tags
- Allow users to filter by trailer text

## Sprint 7
- Add/remove trailer text filter strings
- Delete account
- Pagination
- Add ignore/unignore to the individual tag view
- Add search to each main view

## Sprint 8
- Rework edit buttons for reviews and priorities
- Fix validation text error in details modals
- Reword all uses of 'watch' to 'review'
- Investigate directly rendering Livewire components from routes file
- Do a general gui polish pass
- Protect the 'get-trailers' route

## Sprint 9
- Import legacy data
- Implement simple account types
- Set up seeding
