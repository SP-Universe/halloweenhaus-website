<?php

namespace App\Press;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Team\TeamMember
 *
 * @property string $Title
 * @property string $Description
 * @property string $Copyright
 * @property int $Importance
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class PressImage extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Description" => "Text",
        "Copyright" => "Varchar(255)",
        "Importance" => "Int",
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image"
    ];

    private static $indexes = [
        'Importance' => true,
    ];

    private static $default_sort = "Importance DESC";

    private static $field_labels = [
    ];

    private static $summary_fields = [
        "Thumbnail" => "Bild",
        "Title" => "Titel",
        "Importance" => "Wichtigkeit",
    ];

    private static $searchable_fields = [
    ];

    private static $table_name = "PressImage";

    private static $singular_name = "Presse-Bild";
    private static $plural_name = "Presse-Bilder";

    private static $url_segment = "pressimage";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = PressAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function getFileExtension()
    {
        $file = $this->Image();
        if ($file) {
            return $file->getExtension();
        }
        return null;
    }

    public function getThumbnail()
    {
        $file = $this->Image();
        if ($file) {
            return $file->Fit(100, 100);
        }
        return null;
    }

    public function getFileSize()
    {
        $file = $this->Image();
        if ($file) {
            $fileSize = $file->getAbsoluteSize();
            $fileSize = $fileSize / 1024;
            $fileSize = round($fileSize, 2);
            if ($fileSize >= 1024) {
                $fileSize = $fileSize / 1024;
                $fileSize = round($fileSize, 2);
                return $fileSize . " MB";
            } else {
                return $fileSize . " KB";
            }
        }
        return null;
    }

    public function getAspectRatio()
    {
        $file = $this->Image();
        if ($file) {
            $width = $file->getWidth();
            $height = $file->getHeight();
            $ratio = $width / $height;
            return $ratio;
        }
        return null;
    }
}
