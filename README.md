# Tournament Management System


Welcome to our Tournament Management System! This application allows users to organize and manage tournaments seamlessly. Whether you're running gaming competitions, or any other kind of tournament, our system provides the tools you need for smooth management.

## Features

- User Authentication: Secure user authentication system to manage access and permissions.
- Tournament Creation: Easily create and manage tournaments with various customizable settings.
- Participant Registration: Participants can register for tournaments online.
- Bracket Generation: Automatic generation of brackets for tournament matches.
- Score Tracking: Record and track scores for matches in real-time.
- Email Notifications: Automated email notifications for important tournament updates.
- Admin Dashboard: Comprehensive dashboard for administrators to oversee tournaments and manage users.


## Tech Stack

**Client:** VueJS 3

**Server:** Symfony 7, Api Platform 3

**Database:** MySQL

**Other Tool:** Vue Router, Symfony Doctrine ORM


## Installation

To install and run the application locally, follow these steps:

1. Clone Repository
```bash
  git clone https://github.com/yourusername/tournament-management-system.git
```
2. Navigate to the backend directory:
```bash
  cd backend/symfony
```
3. Install backend dependencies:
```bash
  composer install
```
4. Configure your database connection in .env file.

5. Create the database schema:

```bash
  php bin/console doctrine:database:create
  php bin/console doctrine:migrations:migrate
```

6. Start the Symfony server:
```bash
  symfony server:start
```
7. Navigate to frontend directory and install dependencies: 
```bash
  cd /front/Tournament
  npm install
```

7. Run server :
```bash
  npm run dev
```

8. Open your browser and visit http://localhost:5173 to access the application.



    
## License

This project is licensed under the [MIT](https://choosealicense.com/licenses/mit/) License.



