<?php
    function test($meta_title, $meta_description, $content, $thumbnail_image)
        {
        $content1 = "<html>
    <head>
        <title>$meta_title</title>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='description' content='$meta_description'>
    </head>
    <body>
        <div><img alt='' src='images/$thumbnail_image' /></div>
        <h1>$meta_title</h1>
        <p>$content</p>
    </body>
</html>";
return $content1;
    }
?>