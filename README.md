# backend-test

### Requirements

PHP > 7.2 ( it can probablty run in lower versions )
Mysql > 5.6

### Install project:

Just run ./install.sh after configuring your database parameters on .env.local

This command, will run composer install, create the database, ask for details for creation of the user of backoffice
and also load some data by default.


### Test

### Base instructions

Fork this repository to your own github account. 

### Test starts here

#### 1. Blog post Comments

On the detail page of the blog post, there is a section for comments.

Create the form and the entity that submits the comments, the form must have 3 fields:
- name
- email
- comment

The form must be submited by **ajax** using jquery, and the comment that was inserted must be added
to the list of comments of the blogpost without refreshing the entire page.

Every time a comment is created, send an HTML email to an address of your choice with
the details of the comment.

*No login is necessary to create a comment on a post.*

The template for the listing of the comments is already done ( line 23 to line 36 of templates/app/detail.html.twig )

Theme the form in a way that we only need to do:
```
{{ form(form) }}}
```

And the form layout is the first one show on this page: https://getbootstrap.com/docs/5.0/forms/overview/

### 2. Homepage

Show only the posts that are published, and order them by published date DESC

### 3. Performance

Looking at the symfony debug toolbar, I can see that the homepage is making too many queries,
solve that, without introducing a pager.


### 4. Backoffice

For security reasons we need to store the last login date of the user.
Create a way to save the last login date when a user logins to the backoffice.


Good luck!