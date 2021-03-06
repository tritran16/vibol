<?php

namespace App\Repositories;

use App\Models\Store;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\Storage;

class StoreRepository extends AbstractRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Store::class;
    }

    public function bulkInsert(array $data)
    {
        $img = $data['logo'];

        $extension =    substr($img->getClientOriginalName(), strrpos($img->getClientOriginalName(), '.') + 1);
        $filename = time() . '_' . rand(100, 999) . '.' . $extension;

        //Storage::disk('images/stores') -> put($filename, file_get_contents($img -> getRealPath()));
        $folder = storage_path('app/public/images/store/') ;
        $img->move($folder, $filename);
        $data['logo'] = $filename;
        return parent::bulkInsert($data); // TODO: Change the autogenerated stub
    }

    public function updateStore($data)
    {

        if (isset($data['logo_file'])) {
            $img = $data['logo_file'];
            $extension = substr($img->getClientOriginalName(), strrpos($img->getClientOriginalName(), '.') + 1);
            $filename = time() . '_' . rand(100, 999) . '.' . $extension;

            $folder = storage_path('app/public/images/store/');
            $img->move($folder, $filename);
            $data['logo'] = $filename;
        }
        return $this->update($data, $data['id']);

    }

}
