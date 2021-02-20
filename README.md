# simple Blog platform applicatoin in laravel (simple_blog_platform)
Build a simple blog platform, that allow registered users could CRUD their posts and find me job view others. Admin is required to publish users’ posts.
------------
what is application?
# Core features
* People could register for new account and login/logout to the system
* Registered users could CRUD their posts.
* Posts’ body understand markdown syntax and could render properly
* Admin could see a list of created posts
* Admin could publish or unpublish created posts
# Optional features
* Only published posts would be display in public listing page
* Admin could see highlighting unpublished posts in list of all posts
* Admin could filter/order posts by date or status
* Admin could schedule post publishing. E.g найти работу I want publish this post automatically in tomorrow 9AM

Install
------------
1. Softwares: Installed PHP, Mysql, Laravel
2. Download source code and add .env file to blog directory. Config .env file follow as : 
    2.1 Connect with MySQL database
  
        * DB_HOST=localhost
        * DB_DATABASE=your_database_name
        * DB_USERNAME=database_username
        * DB_PASSWORD=database_password

    2.2 Add admin (default):

        * INITIAL_USER_NAME=Admin
        * INITIAL_USER_EMAIL=admin@admin.com
        * INITIAL_USER_PASSWORD=Admin@123
        * INITIAL_USER_ROLE=admin

Database tables
------------
* users (default + role)
* posts (id, author_id, title, body, slug, active, published_at)

Quick install
------------
If you want to get this up and running quickly, follow these instructions:

1.  Clone the repository

  git clone https://github.com/thanhth85/simple_blog_platform 

2.  Follow the Setup database which includes:

  * Edit the .env.example file to match your database and rename to .env
  * Run the migrations : php artisan migrate:refresh --seed  
3. run `composer install` and `npm install`
4. Ensure that the permissions on the storage folder are set correctly. You will get a 500 error otherwise.

5. Ensure that you have set the correct image path for justboil.me to the appropriate folder or just use the default /images and make sure that folder has the correct permissions to upload images (usually owned by the webserver user).
6. php artisan serve ( run server )
