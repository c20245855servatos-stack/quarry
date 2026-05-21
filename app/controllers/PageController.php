<?php

class PageController
{
    public function home(): void
    {
        require __DIR__ . '/../views/pages/home.php';
    }

    public function about(): void
    {
        require __DIR__ . '/../views/pages/about.php';
    }

    public function contact(): void
    {
        require __DIR__ . '/../views/pages/contact.php';
    }
}