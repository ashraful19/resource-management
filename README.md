# Resource Management Application!
<p align="center"><a href="https://laravel.com" target="_blank">
<img src="https://laravel.com/img/logomark.min.svg" width="80"></a>&nbsp;&nbsp;&nbsp;&nbsp;
<a href="https://vuejs.org" target="_blank" rel="noopener noreferrer"><img width="85" src="https://vuejs.org/images/logo.png" alt="Vue logo"></a>
<a href="https://tailwindcss.com/" target="_blank">
      <img alt="Tailwind CSS" width="120" src="https://tailwindcss.com/_next/static/media/tailwindcss-mark.cb8046c163f77190406dfbf4dec89848.svg">
    </a>
</p>

## Functionalities

 - [x] 3 types of Resources. PDF, HTML, LINK
 - [x] Management Panel for Admins to Create, Edit, Delete and View resources
 - [x] Browsing site for visitors to View all resources
 - [x] Download PDF (PDF Resource) by Admin and Visitor 
 - [x] Click to Open Link (LINK Resource) by Admin and Visitor
 - [x] View Description and View snippet and Copy snippet to clipboard (HTML Resource)

### Folder Structure
 - Root Folder
	 - **api** ---> this has the Laravel part, acting as api, and also includes the visitor part
	 - **management** ---> this has the Vue Cli setup for the admin management part

## Local Installation
Clone the repository in your local machine using `git clone https://ashraful-islam19@bitbucket.org/ashraful-islam19/resource-management.git`
### *Requirements* for Local Environment

 - [x] PHP Version 7.4
 - [x] NodeJs Version 14 (Have tested on v14, but should be okay with v12 also)
 - [x] MySql version 5.7

### *api* - Running the Laravel Api and Visitor Site 
 1. Open terminal/command promt from inside the `api` folder
 2. run command `cp .env.local .env`
 3. update `.env` file database informations according to your local machine.
 4. run command `composer install`
 5. run command `php artisan migrate`
 6. run command `npm install`
 7. run command `npm run dev` or `npm run prod`
 8. run command `php artisan serve`
> At this point you have the Laravel API ready to serve and Visitor Site
> ready to browse. Just open your browser and navigate to
> `http://localhost:8000`  and you should see the visitor site home page
> showing a blank list page of resources.
#### Running Unit Testing
 9. update `.env.testing` file database informations according to your local machine. 
> If you keep the database info same as `.env` file, after running each
> test, the database will reset. So i recommend to use a seperate
> database,
 11. run command `php artisan test` to execute unit testing cases

### *management* - Running the Admin Management (Vue Cli)
 1. Open terminal/command promt from inside the `management` folder
 2. run command `npm install`
 3. run command `npm run serve`

> Admin Management site is ready to browse. Just open your browser and
> navigate to`http://localhost:8000`  and you should see the management site home page showing a blank list page of resources.
> You can see a **Create New** button to create new resources. 

## Features
 - Laravel part (**Api**)
	 - Developed following **SOLID** *Principles*
	 - Followed **Service** *Pattern* where application
	 - Followed **Repository** *Pattern* where applicable
	 - **Dependency Injection** was used where applicable
	 - Seperate **Form Request** classes for each type of resources
 - VueJs part (**Management and Browsing**)
	 - **Reusable Component** based structure
	 - **Loader** on Router change and Axios call
	 - **Scroll to top** on page change, and **Scroll to first error** on validation error
	 - **Validation** errors shown with fields
	 - Specialized **HTML snippet** insertion field with **autocomplete** and **suggestion**
	 - **Text Editor** for HTML Description insertion
	 - **PDF File** uploads along with form data. **No preupload to temporary** folders

## Scope of Improvements

 1. **Laravel Test Cases** can be *improved*, currently are *messy*. 
 2. **HTML Snippet view** popup can be improved. while viewing the snippet, **indentions are not right**.
 3. Laravel and Vuejs part can be combined into a **single Docker environment**, so can be Run/Deploy with single docker command. ***Currently In Progress**. If i am able to finish on time, will publish in the repo*
 4. VueJs part can be updated to **Vue3**. Currently has plans to update.
 5. VueJs part can be implemented with SSR.
 6. Laravel part **test cases** can be ran with **sqlite in-memory** db, so we may not need to create separate db for test. Currently i was not inrested into installing sqlite driver.


&copy; Ashraful Islam ( ai.tushar19@gmail.com )

