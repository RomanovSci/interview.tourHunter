
## How to run
1) Install application dependencies: `composer install`
2) Configure DB:
* Create db and configure connection in `config/db.php` file
* Apply migration with `php yii migrate` console command for general db
* Apply migration with `php yii migrate-test` console command for test db
3) Build frontend: `npm run build`
4) Run server: `php yii serve`
5) Open `http://localhost:8080` in your browser
