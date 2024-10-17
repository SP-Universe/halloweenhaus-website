<?php

namespace App\POS;

use SilverStripe\Assets\Image;
use App\Feedback\FeedbackAdmin;
use SilverStripe\ORM\DataObject;

/**
 * Class \App\Team\TeamSocial
 *
 * @property string $Title
 * @property float $Price
 * @property int $ImageID
 * @method \SilverStripe\Assets\Image Image()
 */
class Product extends DataObject
{
    private static $db = [
        "Title" => "Varchar(255)",
        "Price" => "Double",
    ];

    private static $has_one = [
        "Image" => Image::class,
    ];

    private static $owns = [
        "Image",
    ];

    private static $belongs_many = [
        "ProductSales" => ProductSale::class,
    ];

    private static $default_sort = "ID ASC";

    private static $field_labels = [
        "Title" => "Titel",
        "Price" => "Preis",
    ];

    private static $summary_fields = [
        "ID" => "ID",
        "Title" => "Titel",
        "FormattedPrice" => "Preis",
    ];

    private static $table_name = "Product";

    private static $singular_name = "Produkt";
    private static $plural_name = "Produkte";

    private static $url_segment = "product";

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        return $fields;
    }

    public function CMSEditLink()
    {
        $admin = FeedbackAdmin::singleton();
        $urlClass = str_replace('\\', '-', self::class);
        return $admin->Link("/{$urlClass}/EditForm/field/{$urlClass}/item/{$this->ID}/edit");
    }

    public function getFormattedPrice()
    {
        if ($this->Price > 0) {
            return $this->Price . " €";
        } else {
            return "Spendenbasis";
        }
    }
}
