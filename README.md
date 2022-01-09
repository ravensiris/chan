<div id="top"></div>

[![MIT License][license-shield]][license-url]

<!-- PROJECT LOGO -->
<br />
<div align="center">
  <a href="https://github.com/ravensiris/chan">
    <img src="images/logo.png" alt="Logo" width="80" height="80">
  </a>

<h3 align="center">Chan</h3>

  <p align="center">
    Imageboard API built on top of Laravel Lumen.
    <br />
    <a href="https://github.com/ravensiris/chan"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/ravensiris/chan">View Demo</a>
    ·
    <a href="https://github.com/ravensiris/chan/issues">Report Bug</a>
    ·
    <a href="https://github.com/ravensiris/chan/issues">Request Feature</a>
  </p>
</div>

<!-- TABLE OF CONTENTS -->
<details>
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li>
      <a href="#getting-started">Getting Started</a>
      <ul>
        <li><a href="#prerequisites">Prerequisites</a></li>
        <li><a href="#installation">Installation</a></li>
      </ul>
    </li>
    <li><a href="#usage">Usage</a></li>
    <li><a href="#roadmap">Roadmap</a></li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgments">Acknowledgments</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->
## About The Project

<p align="right">(<a href="#top">back to top</a>)</p>

### Built With

* [Laravel Lumen](https://lumen.laravel.com/)

<p align="right">(<a href="#top">back to top</a>)</p>


<!-- GETTING STARTED -->
## Getting Started

To get a local copy up and running follow these simple steps.

### Prerequisites

Follow [Lumen Guide](https://lumen.laravel.com/docs/8.x) and install whatever appropriate for your system.

### Installation

1. Clone the repo
   ```sh
   git clone https://github.com/ravensiris/chan.git
   ```
2. Setup your environment
Follow guide [HERE](https://lumen.laravel.com/docs/8.x/configuration#environment-configuration).
3. Setup your database
Follow guide [HERE](https://lumen.laravel.com/docs/8.x/database#configuration)

Remember to create a database with the same name as in `DB_DATABASE` variable in your `.env` file.

Example in postgres:
```sh
createdb chan
```
Where `chan` is value of your `DB_DATABASE`.

You can also connect to the database using:
```sh
psql -d chan
```
Might be useful if you need to tweak stuff like encoding or limits.
4. Run migrations
 ```sh
 php artisan migrate:fresh
 ```

<p align="right">(<a href="#top">back to top</a>)</p>

<!-- USAGE EXAMPLES -->
## Usage
### Run
```sh
php -S localhost:8000 -t public
```
### Run tests
You need to have `phpunit` installed on your system.
Follow guide [HERE](https://phpunit.readthedocs.io/en/9.5/installation.html) if you don't have it already.
```sh
phpunit
```

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ROADMAP -->
## Roadmap

- [x] Boards
   - [x] List
   - [x] View
- [ ] Threads
   - [x] List
   - [x] View
   - [ ] Create
- [ ] Replies
    - [ ] Create
    - [ ] List
    - [ ] View
- [ ] Attachments
    - [ ] Attach image to reply
- [ ] Limits
    - [ ] Limit maximum threads
    - [ ] Limit maximum frequency for creating new threads
    - [ ] Limit replies per thread
    - [ ] Limit maximum replies
    - [ ] Limit max image size

See the [open issues](https://github.com/ravensiris/chan/issues) for a full list of proposed features (and known issues).

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

If you have a suggestion that would make this better, please fork the repo and create a pull request. You can also simply open an issue with the tag "enhancement".
Don't forget to give the project a star! Thanks again!

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- LICENSE -->
## License

Distributed under the GPLv3 License. See `LICENSE` for more information.

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- CONTACT -->
## Contact

Project Link: [https://github.com/ravensiris/chan](https://github.com/ravensiris/chan)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- ACKNOWLEDGMENTS -->
## Acknowledgments

* [Best-README-Template](https://github.com/othneildrew/Best-README-Template)
* [Lumen Generator](https://github.com/flipboxstudio/lumen-generator)

<p align="right">(<a href="#top">back to top</a>)</p>



<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[license-shield]: https://img.shields.io/github/license/ravensiris/chan.svg?style=for-the-badge
[license-url]: https://github.com/ravensiris/chan/blob/master/COPYING

