
# :trident: Codeigniter Routing

Folder ini berisi penerapan autentifikasi pada bahasa pemrograman PHP. Materi yang dibahas meliputi:
* 
* 
* 

## :package: Prasyarat

Sebelum memulai, pastikan telah terinstall:
* MySQL atau MariaDB
* PHP 5 atau PHP 7
* Text editor
* Web browser
* Web server
* Materi P1-Design
* Framework codeigniter

> Note: framework codeigniter dapat didownload [disini](https://api.github.com/repos/bcit-ci/CodeIgniter/zipball/refs/tags/3.1.11).

**Struktur Folder P1-Design**

```text
├── application
│   └── ...
├── system
│   └── ...
├── user_guide
│   └── ...
├── .editorconfig
├── .gitignore
├── composer.json
├── contributing.md
├── index.php
├── license.txt
├── register.html
└── readme.rst
```

> Note: file `sosmed.sql` dapat dihapus.

## :computer: Langkah Kerja

* Import database `sosmed.sql` yang ada di materi P1-Design jika belum ada.
* Ubah semua format file `.html` yang ada di materi P1-Design ke format `.php`.
* Ubah `index.php` pada materi P1-Design yang sudah diubah ke format `.php` ke `home.php` dan salin semua file ke direktori `application/views`
* Salin folder `assets` yang ada di materi P1-Design ke direktori utama codeigniter.
* Buka file `application/config/autoload.php` lalu ubah line ke-92 menjadi `$autoload['helper'] = array('url');`.

* Tambahkan script di file `application/config/routes.php`.

	**routes.php**
	```bash
	// Skip

    // $route['default_controller'] = 'welcome';
    // $route['404_override'] = '';
    // $route['translate_uri_dashes'] = FALSE;

    $route['register']['get'] = 'auth/register';
    $route['register']['post'] = 'auth/post_register';
    $route['login']['get'] = 'auth/login';
    $route['login']['post'] = 'auth/post_login';

    $route['default_controller'] = 'member/index';
    $route['create_post'] = 'member/create_post';
    $route['profile'] = 'member/profile';
    $route['update_profile/(:num)'] = 'member/update_profile/$1';
    $route['delete_post/(:num)'] = 'member/delete_post/$1';

    $route['admin'] = 'admin/admin';
    $route['edit'] = 'admin/edit';

    ```
* Buat 3 file controller baru di direktori `app/controllers` dengan nama:
  * Auth.php
  * Member.php
  * Admin.php

* Tambahkan script di file `application/controllers/Auth.php`.

	**Auth.php**
	```bash
	<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Auth extends CI_Controller {
        public function register()
        {
            $this->load->view('register');
        }
        public function login()
        {
            $this->load->view('login');
        }
    }
    ```

* Tambahkan script di file `application/controllers/Member.php`.

	**Member.php**
	```bash
	<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Member extends CI_Controller {
        public function index()
        {
            $this->load->view('home');
        }
        public function profile()
        {
            $this->load->view('profile');
        }
    }
    ```

* Tambahkan script di file `application/controllers/Admin.php`.

	**Admin.php**
	```bash
	<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Admin extends CI_Controller {
        public function index()
        {
            $this->load->view('admin');
        }
        public function edit()
        {
            $this->load->view('edit');
        }
    }
    ```