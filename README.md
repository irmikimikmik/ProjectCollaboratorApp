# Project Description

Frontend and backend developers, designers, project managers, and QAs! Here is an app to get you started on your new project.

By allowing the user select projects from their feed based on the role they are invested in, ProjectCollaboratorApp provides an easy-to-use and multipurpose platform for people who want to create or participate in a project. On ProjectCollaboratorApp, you can view your tasks and projects, search for other users, create posts and find teammates. With the goals of providing effortless project management and discovery of tailored projects, we hope to empower your visions.

In short, our app empowers you to effortlessly engage in meaningful projects and bring your ideas to life. Connect and conquer!

# Disclaimer

This project has been created for UBC's CPSC304: Introduction to Relational Databases Class. The contributors of this are Irmak Bayir, Kutluay Cakadur and Selin Uz. The below project needs to have XAMPP installed and the PHP of XAMPP set up with the correct dependencies in order to access `localhost:8080/phpmyadmin` and `localhost:8080/feed`. Please keep in mind the policies regarding academic dishonesty if you decide to use code from this project!

# Project Setup

This guide will help you set up the necessary tools for your project. Follow the steps below to download and configure XAMPP, Composer, and other essential components.

## Download and Install XAMPP

1. Visit [Apache Friends](https://www.apachefriends.org/)
2. Download XAMPP according to your Operating System.

## Download and Install Composer

1. Visit [Composer's Download Page](https://getcomposer.org/download/)
2. Download Composer by clicking on `Composer.exe`.
3. During installation, on the Settings Check page, set your path to where XAMPP installed PHP. The path should be similar to `C:\\xampp\\php\\php.exe`.

## Setting Up the Project

> **IMPORTANT NOTE:**  The project has different steps for setup in Windows and MacOS systems. Please follow the below steps based on which operating system you are using.

## Configure Environment Variables

### Configure Environment Variables for Windows

1. Set an environment variable for PHP, pointing to the path where the PHP folder is installed by XAMPP. The path should be similar to `C:\\xampp\\php`.

### Configure Environment Variables for MacOS

1. Make sure that you are using XAMPP's PHP rather than the default PHP in the MacOS operating system. To do so, navigate to XAMPP's `bin` directory using `cd Applications/XAMPP/bin` from the root directory.<br>
2. Execute `vim ~/.bash_profile`<br>
3. Type `i`, and then paste `export PATH=/Applications/XAMPP/bin:$PATH` to the top of the file.<br>
4. Hit ESC, Type `:wq`, and hit Enter.<br>
5. Finally, run `source ~/.bash_profile`<br>
6. Confirm that you are using XAMPP's PHP via the `which php` command. It should return the path `/Applications/XAMPP/bin/php` and not `usr/bin/php`.<br><br>
(Instructions taken from https://gist.github.com/djandyr/c04950a1375e96814316 )

## Create Project Directory

### Create Project Directory for Windows

1. Navigate to the XAMPP's `htdocs` directory using `cd ~./xampp/htdocs`.
2. Run the following command to create a new project with CodeIgniter: <br>
   `composer create-project codeigniter4/appstarter project_buddies`
   
### Create Project Directory for MacOS

1. Navigate to the XAMPP's `htdocs` directory using `cd Applications/XAMPP/htdocs` from the root directory.<br>
2. Run the following command to create a new project with CodeIgniter: `composer create-project codeigniter4/appstarter project_buddies`<br>
3. You are likely to receive an error afer running the above command due to the lack of the `intl` extension. If that happens, follow the below steps:<br>
&emsp;&emsp;3.1. First, issue a `php --version` from a terminal to determine the exact PHP version provided by your XAMPP installation.<br>
&emsp;&emsp;3.2 Download the PHP archive matching this version from the following page : https://www.php.net/releases/index.php (that is, for our project, php-8.2.4 which has the link https://www.php.net/distributions/php-8.2.4.tar.gz)<br>
&emsp;&emsp;3.3 Now unzip the php folder and cd to the `php-8.2.4/ext/intl` directory.<br>
&emsp;&emsp;3.4 Run the command `./configure --enable-intl --with-php-config=/Applications/XAMPP/bin/php-config`<br>
&emsp;&emsp;3.5 Run `make`. While running `make`, you might get an error saying `unicode/ubrk.h file not found`. If so:<br>
&emsp;&emsp;&emsp;&emsp;3.5.1 Make sure `icu4c` (a dependency necessary for `intl`) is installed via `brew install icu4c`.<br>
&emsp;&emsp;&emsp;&emsp;3.5.2 Check the `icu4c` path via `brew list icu4c`.<br>
&emsp;&emsp;&emsp;&emsp;3.5.3 Then, run `export CPPFLAGS=-I/usr/local/Cellar/icu4c/XX.X/include/` and `export LDFLAGS=-L/usr/local/Cellar/icu4c/XX.X/lib` where XX.X is the version of icu4c you have installed.<br>
&emsp;&emsp;&emsp;&emsp;3.5.4 Finally, run `make distclean` and `./configure` before running `make` again.<br>
&emsp;&emsp;3.6 After running `make` successfully, run `sudo make install` which should copy the newly built `intl.so` file to your XAMPP PHP extensions folder.<br>
&emsp;&emsp;3.7 At last, edit `/Applications/XAMPP/etc/php.ini` and make sure `intl` is enabled by adding (or removing the comments around) `extension=intl.so`.<br>
&emsp;&emsp;3.8 Restart your Apache. Once you have `intl` installed, you should be able to run the command mentioned in step 2.<br>
4. After running the command mentioned in step 2, confirm that you have a new directory named `project_buddies` in the `htdocs` directory.<br>
5. If you have issues accessing localhost, make sure you have write permissions for necessary users by following this link: https://stackoverflow.com/questions/30139570/phpmyadmin-xampp-wrong-permissions-on-configuration-file-should-not-be-world <br><br>
(Instructions taken from https://stackoverflow.com/questions/74996016/php-intl-h3310-fatal-error-unicode-ubrk-h-file-not-found and https://stackoverflow.com/questions/66844482/unicode-ubrk-h-file-not-found-on-mac-osx-big-sur )
  
## Connect to Git and Add Remote URL
  
1. Navigate to the newly created project folder:
2. Run `git init` <br>
3. Run `git remote add origin git@github.students.cs.ubc.ca:CPSC304-2023S-T2/project_p6n2b_w1q0i_z6s4s.git` <br>
4. Run `git checkout -m main` <br>
5. Run `git pull`

## Initializing DB

1. Create a .env file and copy the code below and paste it in the file. <br>

```
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost/'
database.default.hostname = localhost
database.default.database = project_buddies
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
```

2. Create a database called `project_buddies` after navigating to localhost/phpmyadmin <br>
3. In your terminal, from the project root (`XAMPP/htdocs/project_buddies`), RUN `php spark db:seed PbSeeder`. This is a seeder that helps creating datatables and filling the tables with dummy data. <br>
4. If you want to drop all the tables, then simply run `php spark db:seed DropTablesSeeder`.
