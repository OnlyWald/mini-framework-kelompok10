<?php 

class Route{

    //inisialisasi variabel untuk nama controller utama
    protected $controller   = "home";
    //inisialisasi variabel untuk nama method atau fungsi
    protected $method       = "index";
    //inisialisasi variable untuk menyimpan data parameter
    protected $params        = [];

    public function __construct(){

        //memeriksa isi data url
        if(isset($_GET['url'])){
            //inisialisasi variabel untuk menyimpan nama url
            $url = explode('/',filter_var(trim($_GET['url']), FILTER_SANITIZE_URL));
        }else{
            $url[0] = "home";
        }

        //menambahkan string controller pada url
        $url[0] = $url[0].'Controller';

        //memeriksa file pada controller
        if(file_exists('../app/controllers/'.$url[0].'.php')){
            $this->controller = $url[0];
        }else{
            return require_once '../app/views/Error/404.php';
        }
        
        //menghubungkan route ke file controller
        require_once "../app/controllers/".$this->controller.".php";

        //merubah data menjadi berbentuk
        $this->controller = new $this->controller;

        //memeriksa method pada controller
        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
            }
        }

        //menghapus 2 data url pertama
        unset($url[0]);
        unset($url[1]);

        //mendapatkan data url terakhir
        $this->params = $url;

        //mengambil nilai url
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}