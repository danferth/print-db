Simple App to track print files in  your organization
===============================================
*This is the **localhost** branch set up for working with XAMPP*
Needed a way to track the revision process and order request for print files at work. so created this to put on back end of site and hide via `robots.txt`.  Pretty simple and straight forward to install and use.

Created in `php` and uses `PDO` for db connection and queries. little `jQuery` as well (links to `google CDN`

1. download and eddit a the `assets/connection.php` file with your dbname, user, pass...
2. edit the same variables in `assets/proccess/install.php`, also add the first user and pass.
3. may have to edit the `redirect functions` in assets/functions.php
4. on your server create a db with name 'print' don't worry about creating tables
5. upload and in your borwser go to `yourdomain.com/destination-folder/assets/proccess/install.php`
6. follow the link at the end if all is well and start adding pring files.
7. you can add new user and passwords throught `mysql` on your server.  I plan on creating an admin section to add new users later (see things to do at the bottom)

Feel free to edit and such as you please.

-------------------------
###Things to do
- ~~redo the login backend for better security, as of now not hashing the passwords (big no no)~~
- ~~create admin column in db~~
- ~~create admin page for adding new users~~
- ~~make `head` an `include` and not static for easy maintenance of multiple pages do same with `js` and put at bottom~~
- ~~add favicon support~~
- make responsive
- refine `install.php` with beter error reporting