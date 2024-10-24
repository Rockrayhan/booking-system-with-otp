### Booking System with Email OTP verification
* User registration with Email OTP.
* User can Book for products and see booking status.
* Admin can Accept or cancel the booking.



#### How to run: 
* git clone the repository
* go to project root directory, in cmd run `composer i ` 
* then run `copy .env.example .env` and `php artisan key:generate`
* then `php artisan migrate` ,  then ` php artisan db:seed `
* and finally `php artisan serve`


* Admin Email: admin@gmail.com
* Admin Password: 123456789