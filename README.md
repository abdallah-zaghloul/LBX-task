<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1>LBX Task Documentation</h1>

<h2>Live Demo</h2>
<strong>Please watch this video 👇</strong>

[![Live Demo](https://img.youtube.com/vi/8rP9GRuBH-w/0.jpg)](https://youtu.be/8rP9GRuBH-w)
<li> Please run "Truncate DB API" Firstly for a clean demo database
<ul>To keep it simple for you the project is : 
<li> Deployed at Heroku Free Serverless Host with Jaws Free 10 MB DB
<br>
  <a target="_blank" href="http://lbx-task-ac05b2f76b97.herokuapp.com/api/documentation#/Demo/truncateDB">Heroku Swagger Open API</a>
<li> Dockerized using laravel sail to run it locally
<br>
  <a target="_blank" href="http://localhost:8000/api/documentation#/Demo/truncateDB">Local Swagger Open API</a>
</ul>

<h2>Project Infra Structure</h2>
<ul>
<li> The Project is a Decoupled Modular Monolithic App :
    HMVC Modules (you can turn on/off each module and republish/reuse it at another project)
<p>
<a target="_blank" href="https://drive.google.com/uc?export=view&id=1DT3YIcfRSaU_SeiSzPht_vljOWu745Sr">
<img src="https://drive.google.com/uc?export=view&id=1DT3YIcfRSaU_SeiSzPht_vljOWu745Sr" width="200" height="200">
</a>

<a target="_blank" href="https://drive.google.com/uc?export=view&id=18jSzl7SrJKevpDNko9kgWgvZLWJwXK_Y">
<img src="https://drive.google.com/uc?export=view&id=18jSzl7SrJKevpDNko9kgWgvZLWJwXK_Y" width="200" height="200">
</a>
</p>

<li> Module Structure (Repository Design Pattern)
<p>
<a target="_blank" href="https://drive.google.com/uc?export=view&id=1_CTRCCiZ0X4nG06_xTv48y6MH5vBb1gx">
<img src="https://drive.google.com/uc?export=view&id=1_CTRCCiZ0X4nG06_xTv48y6MH5vBb1gx" width="400" height="200">
</a>
</p>

<li> Separated/Attached Tests
<p>
<a target="_blank" href="https://drive.google.com/uc?export=view&id=1JzE_2ZtJXvIZjWXmb_tZUAmE3gsHgdD4">
<img src="https://drive.google.com/uc?export=view&id=1JzE_2ZtJXvIZjWXmb_tZUAmE3gsHgdD4" width="200" height="200">
</a>
</p>
</ul>

<h2>Import Solution Implementation</h2>
<pre>
Preparation :
- validate excel-sheet file memType and Extension
- upload it at S3 Bucket with status = "Processing"
----------------
Execution : 2 Background Job Queue Buses (groups)
are chained in chunks (Read 1000 Record/ChunkedJob) :
- Validator : validate records
- Importer : Import records if the all the excel-sheet is Valid with ability 
             to rollback in case of failure
- Updates Url : show the updated status of file validation and importation
  so front end can utilize it with ajax to update the UI continuously
----------------
* Recommendation :
 we can utilize after import and validation event-listener not only to
 update file status but also for send the user updates via email
</pre>

<h3>How To Run The Project Locally</h3>
<pre>
Requirements (all can be installed automatically using docker desktop):
---------------
- PHP 8.2
- Run Docker Desktop
- MYSQL
- SQL lite PHP Extension

<hr>
Run the following at the project root dir Terminal
---------------
<ul>
<li>Download Vendor folder
composer install

<li>Make Sail alias
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

<li>Generate .env file from .env.decrypted:
php artisan env:decrypt --key="base64:IMQS06IFVHHEqYuLNYQRQ1XYEyEXUr57kNXqkpBIPlo="

<li>Laravel Sail install
php artisan sail:install

<li>Make an alias for ./vendor/bin/sail:
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

<li>Make an alias for ./vendor/bin/sail:
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

<li>Run Your local server up:
sail up -d

<li>Run Your local server down:
sail down

<li>To Run Unit/Feature Tests but configure your test with xdebug
php artisan test --testsuite=Employee
</ul>

if you have an issue you can see <a href="https://laravel.com/docs/10.x/sail">Laravel Sail</a>
</pre>

