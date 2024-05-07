<!-- Improved compatibility of back to top link: See: https://github.com/WebApp24/WebApp24/pull/73 -->
<a name="readme-top"></a>

[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]
[![LinkedIn][linkedin-shield]][linkedin-url]



<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/WebApp24/WebApp24">
    <img src=".assets/logo.svg" alt="Logo" width="150">
    
  </a>

  <h3 align="center" IAAC: Code Architecture Basics & Model Deployment </h3>

  <p align="center">
    City Layers: Citizen Mapping as a Practice of City-Making 
    <br />
    <a href="https://citylayer.urbanitarian.com/">View Demo</a>
    ·
    <a href="https://github.com/WebApp24/WebApp24/issues">Report Bug</a>
    ·
    <a href="https://github.com/WebApp24/WebApp24/issues">Request Feature</a>
  </p>
</div>



<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
      <li><a href="#intro">Intro</a></li>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#usage">Usage</a></li>
      </ul>
    </li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>



<!-- ABOUT THE PROJECT -->
## About The Project


Citizens are invited to contribute to a collective network of data on citizens’ spatial needs by
sharing their thoughts on a range of urban phenomena.
                    

### Intro



<p align="right">(<a href="#readme-top">back to top</a>)</p>



### Built With


* [PHP](https://www.php.net/)
* [JS](https://www.javascript.com/)
* [SCSS](https://sass-lang.com/)
* [MySQL](https://www.mysql.com/)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- GETTING STARTED -->
## Getting Started for developers



### Prerequisites

* [PHP](https://www.php.net/)
* [XAMPP](https://www.apachefriends.org/)
* [Pear](https://pear.php.net/manual/en/installation.php)
* [Herd](https://herd.laravel.com/)

<p align="right">(<a href="#readme-top">back to top</a>)</p>
<!-- USAGE EXAMPLES -->

### Setup of the development environment

* Clone or fork the repo:
    ```sh
    git clone https://github.com/citylayers/WebApp24.git
    ```
* Install all the [prerequisites](#prerequisites)
* Go to the root folder 
    ```sh
    cd WebApp24
    ```
* Install composer dependencies:
  ```sh
  composer install
  ```
* Configure setup file:
  ```sh
  cp .env.example .env
  ```
  for Windows:
  ```sh
  copy .env.example .env
  ```
* Clear the cache 

    ```sh
    php artisan config:clear
    ```
* Generate a new encryption key

    ```sh
    php artisan key:generate
    ```

* Go to XAMPP, start Apache and MySQL Server
* Go to ```http://localhost:8080/phpmyadmin/``` (replace 8080 with your Apache server port from config file)

* Create a dataset ``citylayers_db`` if it does not exist
  ![create dataset](./assets/create_db_php.jpg)

* Select your dataset; go to privileges
  ![db privileges](./assets/db_privileges.jpg)

* Create a new user, add pwd, give all the necessary rights

* Set environmental variables in the config file:
  DB_CONNECTION=mysql\
  DB_HOST=127.0.0.1 \
  DB_PORT=3306 \
  DB_DATABASE=citylayers_db DB_USERNAME=your_database_username DB_PASSWORD=your_database_password

  *your_database_username* and *your_database_password* are the values you created in the previous step, when 
  adding a user account with the rights to access the database

* Run database migrations and seeders:
  ```sh
  php artisan migrate --seed
  ```
* Run the server:
  ```sh
  php artisan serve
  ```
* Install node dependencies
  ```sh
  npm install
  ```
* Run the local version
  ```sh
    npm run dev
    ```
    or
    ```sh
    npm run build
    ```
    or
    ```sh
    npx vite
    ```


<p align="right">(<a href="#readme-top">back to top</a>)</p>

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE.txt` for more information.

<p align="right">(<a href="#readme-top">back to top</a>)</p>



## Contact

Lovro - [@website](https://citylayer.urbanitarian.com/) - [e-mail](mailto:lovro.koncar-gamulin@tuwien.ac.at) - [LinkedIn][linkedin-url]\
Firas Safieddine - [@website](https://www.firassafieddine.com/) - [e-mail](mailto:firas.safieddine@iaac.net) - [LinkedIn][linkedin-url]\
Stasja - [@website](https://stasyafedorova.wixsite.com/designautomation) - [e-mail](mailto:0.0stasya@gmail.com) - [LinkedIn][linkedin-url]

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* [Department of Visual Culture, School of Architecture and Planning, Technische Universitat Wien](https://visualculture.tuwein.ac.at)
* [My favorite README template](https://github.com/othneildrew/Best-README-Template)

<p align="right">(<a href="#readme-top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/WebApp24/WebApp24.svg?style=for-the-badge
[contributors-url]: https://github.com/WebApp24/WebApp24/graphs/contributors
[forks-shield]: https://img.shields.io/github/forks/WebApp24/WebApp24.svg?style=for-the-badge
[forks-url]: https://github.com/WebApp24/WebApp24/network/members
[stars-shield]: https://img.shields.io/github/stars/WebApp24/WebApp24.svg?style=for-the-badge
[stars-url]: https://github.com/WebApp24/WebApp24/stargazers
[issues-shield]: https://img.shields.io/github/issues/WebApp24/WebApp24.svg?style=for-the-badge
[issues-url]: https://github.com/WebApp24/WebApp24/issues
[license-shield]: https://img.shields.io/github/license/WebApp24/WebApp24.svg?style=for-the-badge
[license-url]: https://github.com/WebApp24/WebApp24/blob/master/LICENSE.txt
[linkedin-shield]: https://img.shields.io/badge/-LinkedIn-black.svg?style=for-the-badge&logo=linkedin&colorB=555
[linkedin-url]: https://linkedin.com/in/stanislava-fedorova
[product-screenshot]: assets/screenshot.png



