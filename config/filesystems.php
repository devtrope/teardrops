<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Upload Path
    |--------------------------------------------------------------------------
    |
    | Directory where uploaded images are stored. This path is relative to
    | the public directory and should be web-accessible for displaying images.
    |
    | Example: An image uploaded here can be accessed at:
    | https://yoursite.com/uploads/images/photo.jpg
    |
    | Note: Ensure this directory exists and is writable by the web server.
    |
    */
    'images' => [
        'root' => '/uploads/images/',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Path
    |--------------------------------------------------------------------------
    |
    | Directory for general file uploads (PDFs, documents, etc.). Like images,
    | this path is relative to the public directory.
    |
    | Example: A file uploaded here can be accessed at:
    | https://yoursite.com/uploads/files/document.pdf
    |
    | Note: Ensure this directory exists and is writable by the web server.
    |
    */
    'files' => [
        'root' => '/uploads/files/',
    ],
    
];