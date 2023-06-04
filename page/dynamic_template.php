<?php
    function dynamic_template($meta_title, $meta_description, $content, $thumbnail_image)
        {
        $dynamic_template = "<html>
    <head>
        <title>$meta_title</title>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <meta name='description' content='$meta_description'>
    </head>
    <body>
        <div><img alt='$meta_title' src='images/$thumbnail_image' /></div>
        <h1>$meta_title</h1>
        <p>$content</p>
    </body>
</html>";
return $dynamic_template;
    }
?>