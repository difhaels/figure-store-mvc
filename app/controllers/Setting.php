<?php

class Setting extends Controller
{
    public function index()
    {
        // cek dulu admin sudah login atau belum
        if (isset($_SESSION['login-admin'])) {
            $data['nav'] = "";
            $data['nav-short'] = "no";
            $this->view('templates/header', $data);
            $this->view('setting/index');
            $this->view('templates/footer');
        } else {
            // pindah ke halaman login
            header("Location: " . BASEURL . "/setting/loginadmin");
        }
    }

    // method untuk tampilan login admin
    public function loginAdmin()
    {
        $data['nav'] = "";
        $data['nav-short'] = "yes";
        $this->view('templates/header', $data);
        $this->view('setting/login', $data);
    }

    // method untuk handle login admin
    public function login()
    {
        if ($this->model('Admin_model')->login()) {
            $_SESSION['login-admin'] = true;

            // pindah ke dashboard admin
            header("Location: " . BASEURL . "/setting");
            die;
        }
        echo "password atau username salah";
    }


    // method untuk item
    public function item()
    {
        $data['nav'] = "back-button";
        $data['back'] = "admin";
        $data['nav-short'] = "no";

        $data['items'] = $this->model('Item_model')->getAllItem(); // untuk default

        if (isset($_POST['search'])) { // menggunakan isset karena post seacrh belum terbaca diawal
            $data['search'] = $this->model('Item_model')->searchItem($_POST['key']); // untuk fitur seacrh
        }
        if (isset($_POST['sort'])) { // menggunakan isset karena post sort belum terbaca diawal
            $data['sort'] = $this->model('Item_model')->sortItem($_POST['sort']); // untuk fitur sort
        }
        $this->view('templates/header', $data);
        $this->view('admin/item', $data);
    }

    public function itemUpdate()
    {
        $data['nav'] = "";
        $data['nav-short'] = "no";

        $get = $_GET;
        $string = http_build_query($get);
        $url = explode('%2F', $string);
        $lastUrl = end($url);

        if ($lastUrl) {
            $id = $lastUrl; // jika last url ada maka id akan menggunakan last url
        }

        $data['update'] = $this->model('Item_model')->getItem($id);
        $this->view('templates/header', $data);
        $this->view('admin/item/update', $data);
        $this->view('templates/footer');
    }

    public function itemDelete()
    {
        $coba = $_GET;
        var_dump($coba);
    }

    // method untuk transaction
    public function transaction()
    {
        echo "transaction";
    }
}
