<?php

namespace App\Traits;

Trait ImageTools
{
    /**
     * Upload an image to public path
     *
     * @param File $image
     * @return String file_name
     */
    public function upload_image ($image, $resize = [], $watermark = null)
    {
        // Create file name & file path with /year/month/day/filename formats
        $time = Carbon::now();   
        $file_path = "uploads/{$time->year}/{$time->month}/{$time->day}";
        $file_ext = $image->getClientOriginalExtension();
        $file_name = rtrim($image->getClientOriginalName(), ".$file_ext");
        $file_name = time() . '_' . substr($file_name, 0, 50);
        
        // Create directories if doesn't exists
        if (!file_exists( public_path($file_path) )) {
            mkdir(public_path($file_path), 0777, true);
        }
        
        // Reszie , Add watermark and upload the image to storge
        $image = Image::make( $image );
        $this->resize($image, $resize);
        $this->watermark($image, $watermark);
        

        $image->save( public_path("$file_path/$file_name.$file_ext") );
        return "/$file_path/$file_name.$file_ext";
    }

    /**
     * Resize the image with given dimentions
     *
     * @param File $image
     * @param array $dimentions
     * @param boolean $fixed
     * @return void
     */
    public function resize ( $image, $dimentions = [], $fixed = false )
    {
        // Get width & height value from array to vars
        $width = isset($dimentions['width']) ? $dimentions['width'] : null; 
        $height = isset($dimentions['height']) ? $dimentions['height'] : null; 

        // Return the image if doens't define any dimentions
        if ( !( $width && $height ) ) return $image;

        // Fixed resize if $fixed == true 
        if ( $fixed || ( $width && $height ) )
        {
            $img->resize($width, $height);
        }
        // Resize with asspect ratio if $fixed == false
        else
        {
            $image->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }
    }

    /**
     * Add the watermark to the given image
     *
     * @param Image $image
     * @param File $watermark
     * @return void
     */
    public function watermark ($image, $watermark = null)
    {
        if ( $watermark && file_exists( $watermark ) )
        {
            $watermark = Image::make( $watermark );
            $ratio = $watermark->width() / $watermark->height();
            $watermark->resize(50 * $ratio, 50);
            $image->insert($watermark, 'bottom-right', 10, 10);
        }
    }
}