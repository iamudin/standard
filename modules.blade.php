<?php

use_module([
    'banner' => [
        'active' => true,
    ],
    'berita' => [
        'active' => true,
        'title' => 'Berita',
        'icon' => 'fa-newspaper',
        'web' => [
            'detail' => true,
            'index' => true,
            'auto_query' => true,
        ],
    ],

    'galeri' => [
        'active' => true,
        'title' => 'Galeri Foto',
        'icon' => 'fa-camera',
        'web' => [
            'detail' => true,
            'index' => true,
            'auto_query' => true,
        ],
    ],
    'sambutan' => [
        'active' => true,
        'title' => 'Sambutan Pimpinan',
        'icon' => 'fa-quote-left',
        'web' => [
            'detail' => true,
            'index' => false,
            'auto_query' => true,
        ],
    ],
    'pengumuman' => [
        'active' => true,
        'title' => 'Pengumuman',
        'icon' => 'fa-bullhorn',
        'form'=>[
            'category'=>true
        ],
        'web' => [
            'detail' => true,
            'index' => true,
            'auto_query' => true,
        ],
    ],
    'document' => [
        'active' => true,
        'title' => 'Dokumen',
        'icon' => 'fa-download',
        'web' => [
            'detail' => true,
            'index' => true,
            'auto_query' => true,
        ],
    ],
]);

add_option('Option Template', [
    ['Hero Subtitle / Tagline', 'text', 'Portal Resmi Informasi Publik dan Pelayanan Terpadu'],
    ['Hero Deskripsi', 'textarea', 'Memberikan pelayanan prima, transparan, dan terpercaya untuk seluruh elemen masyarakat dengan kemudahan akses informasi digital yang cepat dan akurat.'],
    ['Hero Background Image', 'file'],
    ['Site Logo', 'file'],
    ['Nomor WhatsApp', 'text', '081234567890'],
    ['Email Resmi', 'text', 'kontak@instansi.id'],
    ['Alamat Kantor / Instansi', 'text', 'Jl. Merdeka No. 45, Kompleks Perkantoran Terpadu, Indonesia'],
    ['Jam Pelayanan', 'text', 'Senin - Jumat: 08.00 - 16.00 WIB'],
    ['Link Facebook', 'text', 'https://facebook.com'],
    ['Link Instagram', 'text', 'https://instagram.com'],
    ['Link YouTube', 'text', 'https://youtube.com'],
    ['Google Maps Embed URL', 'textarea', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126915.21852926176!2d106.7891558!3d-6.229728!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e49fe3ddb3%3A0x73d44976ea5d725f!2sJakarta!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid'],
]);
