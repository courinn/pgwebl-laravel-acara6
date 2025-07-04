<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PointsModel extends Model
{
    protected $table = 'points';

    protected $guarded = ['id'];

    public function geojson_points()

{
    $points = $this
->select(DB::raw('points.id,
            ST_AsGeoJSON(points.geom) as geom,
            points.name,
            points.birth_date,
            points.description,
            points.image,
            points.created_at,
            points.updated_at,
            points.user_id,
            users.name as user_created'))
            ->leftJoin('users', 'points.user_id', '=', 'users.id')
            ->get();

    $geojson = [
        'type' => 'FeatureCollection',
        'features' =>[],
    ];

    foreach ($points as $p) {
        $feature = [
            'type' => 'Feature',
            'geometry' => json_decode($p->geom),
            'properties' => [
                'id' => $p->id,
                'name' => $p->name,
                'birth_date' => $p->birth_date,
                'description' => $p->description,
                'created_at' => $p->created_at,
                'updated_at' => $p->updated_at,
                'image' => $p->image,
                'user_created' => $p->user_created,
                'user_id' => $p->user_id,
            ],
        ];

        array_push($geojson['features'],$feature);
    }
        return $geojson;
    }



public function geojson_point($id)
{
    $points = $this
        ->select(DB::raw('points.id,
            ST_AsGeoJSON(points.geom) as geom,
            points.name,
            points.birth_date,
            points.description,
            points.image,
            points.created_at,
            points.updated_at,
            points.user_id,
            users.name as user_created'))
        ->leftJoin('users', 'points.user_id', '=', 'users.id')
        ->where('points.id', $id)
        ->get();

    $geojson = [
        'type' => 'FeatureCollection',
        'features' => [],
    ];

    foreach ($points as $p) {
        $feature = [
            'type' => 'Feature',
            'geometry' => json_decode($p->geom),
            'properties' => [
                'id' => $p->id,
                'name' => $p->name,
                'birth_date' => $p->birth_date,
                'description' => $p->description,
                'created_at' => $p->created_at,
                'updated_at' => $p->updated_at,
                'image' => $p->image,
                'user_created' => $p->user_created,
                'user_id' => $p->user_id,
            ],
        ];

        array_push($geojson['features'], $feature);
    }

    return $geojson;
}

public static function withUser()
{
    return DB::table('points')
        ->select('points.*', 'users.name as user_created')
        ->leftJoin('users', 'points.user_id', '=', 'users.id')
        ->get();
}

}
