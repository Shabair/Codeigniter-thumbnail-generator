# Codeigniter Thumbnail Generator
This thumbnail helper file used to create thumbnails of any image.This function create a folder with the name of "thumbnails" and save created thumbnails in sub folder with the name of dimensions of images like 600x450 contain images with 600 height and 450 width.This function will not upload the original file.
<h4>Create thumbnail</h4>
<blockquote>
   thumbnail_generator($_FILES['thumbnail'],600,450);
</blockquote>

<h4>Get Thumbnail</h4>
<blockquote>
   get_thumbnail($image_name,600,450);
</blockquote>
