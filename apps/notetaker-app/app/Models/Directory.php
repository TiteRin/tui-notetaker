<?php

namespace App\Models;

use Database\Factories\DirectoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    /** @use HasFactory<DirectoryFactory> */
    use HasFactory;

    private $icon = "📂";

    protected $fillable = ['name'];

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getIconAndName() {
        return "$this->icon $this->name";
    }
}
