<?php 



function thumbnail_generator($imgSrc,$width,$height){
                    
    $CI = &get_instance();

    // get src file's dirname, filename and extension
    $path = pathinfo($imgSrc);

    // Path to image thumbnail
    // if( !$saveDirec )
    //     $saveDirec = $path['dirname'] . DIRECTORY_SEPARATOR . $path['filename'] . "_" . $width . '_' . $height . "." . $path['extension'];

    $saveDirec = 'thumbnails'. DIRECTORY_SEPARATOR .$width.'x'.$height. DIRECTORY_SEPARATOR ;

    $new_thumb = $saveDirec.$path['filename'] . "." . $path['extension'];

    //check if already file exists
    if(!file_exists($new_thumb)){

        // if Directory not exsits then create it.
        if (!is_dir($saveDirec)) {
            mkdir($saveDirec, 0777, TRUE);
        }
        
        //load the image library which will be used by the codeigniter for image processing 
        $config['image_library'] = 'gd2';

        //setting up the source of image
        $config['source_image'] = $imgSrc;

        //get the all attributes of original image
        list($original_width, $original_height, $file_type, $attr) = getimagesize($config['source_image']);

        //this path for the new image otherwise overwrite the original image.
        $config['new_image'] = $saveDirec;

        //division of original image width by required width 
        $widthRatio = ($original_width/$width);

        //division of original image height by required height
        $heightRatio = ($original_height/$height);

        //then compare which one is lesser
        if($widthRatio < $heightRatio){

            $multiplyRatio = $widthRatio;

        }else{

            $multiplyRatio = $heightRatio;

        }

        //multiply the lesser value with the required both width and height
        $widthFinal = $width*$multiplyRatio;

        $heightFinal = $height*$multiplyRatio;


        $config['width']         = floor($widthFinal);

        $config['height']       = floor($heightFinal);

        $config['maintain_ratio'] = false;

        // set our cropping limits according to the center of image.
        $x_axis = ($original_width / 2) - ($widthFinal / 2);

        $y_axis = ($original_height / 2) - ($heightFinal / 2);

        // $x_axis = ($original_width - $width)/2;

        // $y_axis = ($original_height - $height)/2;

        $config['x_axis'] = $x_axis;
        $config['y_axis'] = $y_axis;

        $CI->load->library('image_lib');
        $CI->image_lib->initialize($config); 

        if ( ! $CI->image_lib->crop())
        {
              echo $CI->image_lib->display_errors();die();
        }
        $CI->image_lib->clear();

        //again get the image for the next process of resizing
        $config['source_image'] = $new_thumb;

        $config['new_image'] = $saveDirec;
        $config['width']         = $width;
        $config['height']       = $height;
        $config['maintain_ratio'] = true;

        // $config['y_axis'] = 50;

        $CI->load->library('image_lib');

        $CI->image_lib->initialize($config); 

        if ( ! $CI->image_lib->resize())
        {
              echo $CI->image_lib->display_errors();die();
        }

        $CI->image_lib->clear();
    }
}

function get_thumbnail($imgSrc,$width,$height){
    $thumbDirec = 'thumbnails'. DIRECTORY_SEPARATOR .$width.'x'.$height. DIRECTORY_SEPARATOR ;
    return base_url($thumbDirec.$imgSrc);
}