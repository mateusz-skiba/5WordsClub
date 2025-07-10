# 5WordsClub 

5WordsClub is a PHP + jQuery app that helps users learn English vocabulary daily.  
Users sign up by selecting their English level and verifying their email.  
The system automatically generates and sends daily emails with 5 new words via cron jobs, each word containing definitions, examples, synonyms, grammatical forms, image, and audio.  
Subscription payments are handled through Stripe integration, and users can update their subscription and english level in a personalized dashboard.

Live: [5words.club](https://5words.club)

## Technologies

* PHP 8.2+  
* jQuery 3.7  
* MySQL 8+  
* SMTP for email delivery  
* Cron jobs for automation  
* Stripe API for payments  

## Structure

- `/public` — frontend assets, landing page, and dashboard  
- `/src` — backend PHP scripts including database interactions, email generation and sending and Stripe payment processing
- `/admin` — scripts triggered by cron jobs for automated email sending, and admin panel for manual email generation and sending
- `/config` — configuration files
- `/vendor` — third-party PHP libraries managed via Composer

## Features

* Landing page with a registration form
* User registration and login system via email confirmation
* Personalized dashboard for managing subscription and English level
* Stripe integration for payments
* Vocabulary generation embedded in email content
* Automated daily emails with 5 tailored words, including definitions, examples, synonyms, forms, images, and audio
* Admin panel with manual and automated email sending via cron jobs

## Architecture

* Frontend: Landing page and dashboard
* Backend: PHP handles user management, payment processing (Stripe), and email content generation
* Database: MySQL stores users, leads, subscription info, and vocabulary sets
* Cron jobs trigger daily email generation and delivery via SMTP
* Admin panel allows manual email generation and sending

## Contact

Author: [Mateusz Skiba](https://mateusz-skiba.pl/)  
Email: mateusz.skiba14@gmail.com