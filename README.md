<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

## Example Blog

This is a very simple example for Blog applicaton RestAPI

### Activities:
 - User Create Account.
 - User Login to Account.
 - User Filter Blog posts.
- User Create Blog post.
- User Update Blog post.
- User Delete Blog post.
- User Create Comment.
- User Update Comment.
- User Delete Comment.
- User List Post comments.

### Installation
After downloading the project code go to the project directory and run:  

```
docker-compose up -d
```
after successfully running the docker containers we need to perform database migrations by running the command:
```
docker-compose exec app php artisan migrate
```
now the application ready, you can find the documentation [http://localhost:8084/api/documentation](http://localhost:8084/api/documentation)

### Tests
Running test can be performed using the command: 
```
docker-compose exec app php artisan test
```
