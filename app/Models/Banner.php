<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //

    const STATUS_SHOWN = 0;
    const STATUS_HIDEN =1;
    protected $fillable = ['title', "content", 'cover', 'url', 'sort'];

    public function toArray()
    {
        $array['title']      = $this->title;
        $array['content']    = $this->content;
        $array['cover']      = $this->cover;
        $array['sort']       = $this->sort;
        $array['type']       = $this->type;
        $array['url']        = $this->url;
        $array['created_at'] = $this->created_at;
        return $array;
    }

    public function isShow()
    {
        return $this->is_show == self::STATUS_SHOWN;
    }
}
