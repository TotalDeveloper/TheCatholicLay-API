<?php

namespace App\GraphQL\Queries;
use App\Models\Project;

class Projects
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // TODO implement the resolver
        $data = new Project;
        if(isset($args['admin_id'])) {
          $data = $data->where('admin_id',$args['admin_id']);
        }
        // if(isset($args['name'])) {
        //   $data = $data->where('name','like',$args['name']);
        // }
        return $data->get();
    }
}
