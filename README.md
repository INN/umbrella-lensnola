## Setup instructions

This repository is designed to be set up in accordance with the VVV install instructions in INN/docs, that were introduced with https://github.com/INN/docs/pull/148

To get started, open a new terminal window.

Navigate to the vagrant-local/www directory.

And then run:

```
vv create
```
You'll then see a series of prompts. Respond thusly:

Prompt | Text to enter 
------------ | -------------
Name of new site directory: | lensnola
Blueprint to use (leave blank for none or use largo): | largo
Domain to use (leave blank for largo-umbrella.dev): | lensnola.dev
WordPress version to install (leave blank for latest version or trunk for trunk/nightly version): | *hit [Enter]*
Install as multisite? (y/N): | n
Install as subdomain or subdirectory? : | subdomain
Git repo to clone as wp-content (leave blank to skip): | *hit [Enter]*
Local SQL file to import for database (leave blank to skip): | *This filename must be an absolute path, so the easiest thing to do on a Mac is to drag your mysql file into your terminal window here: the absolute filepath with fill itself in. Absolute filepaths begin from `/` and go all the way to the file.*
Remove default themes and plugins? (y/N): | y
Add sample content to site (y/N): | N
Enable WP_DEBUG and WP_DEBUG_LOG (y/N): | N

After reviewing the options and creating the new install (you'll be prompted part way through the install process to provide your admin password), proceed with the following steps:

1. `cd` to the directory `lensnola/` in your VVV setup
2. `git clone git@github.com:INN/umbrella-lensnola.git`
3. `cd umbrella-lensnola`
4. `git submodule update --init` to pull down all of the submodules you need (including, crucially, the tools repo)
5. `cd ..`
6. Copy the contents of the new directory `umbrella-lensnola/` into `htdocs/`, including all hidden files whose names start with `.` periods.
	- the easy way to do this is: `rsync -rv umbrella-lensnola/ htdocs`
	- afterwards, you may want to `rm -rf umbrella-lensnola` to save disk space
7. `cd htdocs` to move to the folder where the umbrella now lives
8. `workon fabric`
9. `fab production wp.fetch_sql_dump` (or download via FTP if this doesn't work)
10. `fab vagrant.reload_db:mysql.sql`
11. Search and replace 'lensnola.wpengine.com' --> 'lensnola.dev' in the db (options for doing this are covered in the [largo umbrella setup instructions](https://github.com/INN/docs/blob/master/projects/largo/umbrella-setup.md)
12. Optionally, you may want to pull down recent uploads so you have images, etc. to work with locally.
13. Visit lensnola.dev in your browser and you should see the site!
