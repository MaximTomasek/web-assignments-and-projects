<?php

declare(strict_types=1);

namespace App\AppCore\Utils;

class Upload
{
    public static function image(
        string $storeTo = 'Resources/images',
        string $input = 'image',
    ): string|null
    {
        if (isset($_FILES[$input])) {
            $storeFileName = $storeTo . $_FILES[$input]['name'];

            // Test velikosti souboru
            if ($_FILES[$input]['size'] > 250000) {
                return null;
            }

            if (
                move_uploaded_file(
                    $_FILES[$input]['tmp_name'],
                    __APP_ROOT__ . getenv('(APP_SUB_FOLDERS') . $storeFileName
                )
            ) {
                return $storeFileName;
            }
        }

        return null;
    }
}