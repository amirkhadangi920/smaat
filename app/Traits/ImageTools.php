<?php

namespace App\Traits;

use Carbon\Carbon;
use Image;


Trait ImageTools
{
    /**
     * Upload an image to public path
     *
     * @param File $image
     * @return String file_name
     */
    public function upload_image ($image)
    {
        $file_name = $this->makeFileName( $image );
        
        $this->createDirectory( $file_name['path'] );

        $image = Image::make( $image );

        return [
            'big'       => $this->resizeAndSave($image, 1000, $file_name),
            'medium'    => $this->resizeAndSave($image, 700, $file_name),
            'small'     => $this->resizeAndSave($image, 400, $file_name),
            'tiny'      => $this->resizeAndSave($image, 100, $file_name),
        ];
    }

    /**
     * Create an array of file name with the image
     *
     * @param file $image
     * @return void
     */
    public function makeFileName ( $image )
    {
        $result = [];
        $time = Carbon::now();
        
        $result['path'] = "images/{$time->year}/{$time->month}/{$time->day}";
        $result['ext'] = $image->getClientOriginalExtension();
        $result['name'] = rtrim($image->getClientOriginalName(), ".{$result['ext']}");
        $result['name'] = time() . '_' . substr($result['name'], 0, 50);

        return $result;
    }

    /**
     * Create a directory if doesn't exists
     *
     * @param string $path
     * @return void
     */
    public function createDirectory ( $path )
    {
        if (!file_exists( public_path( $path ) ))
            mkdir(public_path( $path ), 0777, true);
    }


    public function resizeAndSave ( $image, $width, $file_name )
    {
        $this->resize( $image, $width );

        $file_name = "/{$file_name['path']}/{$width}-{$file_name['name']}.{$file_name['ext']}";
        
        $image->save( public_path( $file_name ) );

        return $file_name;
    }

    /**
     * Resize the image with given dimentions
     *
     * @param File $image
     * @param array $dimentions
     * @param boolean $fixed
     * @return void
     */
    public function resize ( $image, $width )
    {
        $image->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });
    }

    // /**
    //  * Add the watermark to the given image
    //  *
    //  * @param Image $image
    //  * @param File $watermark
    //  * @return void
    //  */
    // public function watermark ($image, $watermark = null)
    // {
    //     if ( $watermark && file_exists( $watermark ) )
    //     {
    //         $watermark = Image::make( $watermark );
    //         $ratio = $watermark->width() / $watermark->height();
    //         $watermark->resize(50 * $ratio, 50);
    //         $image->insert($watermark, 'bottom-right', 10, 10);
    //     }
    // }
}