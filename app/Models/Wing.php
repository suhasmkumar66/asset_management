<?php

namespace App\Models;

use App\Http\Traits\UniqueUndeletedTrait;
use App\Models\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Log;
use Watson\Validating\ValidatingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\AssetModel;
use App\Models\User;

class Wing extends AssetModel
{
    /**
     * Whether the model should inject it's identifier to the unique
     * validation rules before attempting validation. If this property
     * is not set in the model it will default to true.
     *
     * @var boolean
     */
    protected $injectUniqueIdentifier = true;
    
    use ValidatingTrait, UniqueUndeletedTrait;
    
    protected $table = 'wings';
    
    protected $rules = [
        'wing'          => 'required|max:255',
        
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wing',
        'department_id'
    ];
    
    use Searchable;
    
    /**
     * The attributes that should be included when searching the model.
     *
     * @var array
     */
   
    
    /**
     * The relations and their attributes that should be included when searching the model.
     *
     * @var array
     */
    
    
    
   
    
    /**
     * Even though we allow allow for checkout to things beyond users
     * this method is an easy way of seeing if we are checked out to a user.
     * @return mixed
     */
   
    
    
    /**
     * Return the manager in charge of the dept
     * @return mixed
     */
   
    
    
   
    
    /**
     * Query builder scope to order on location name
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
   
    
    /**
     * Query builder scope to order on manager name
     *
     * @param  \Illuminate\Database\Query\Builder  $query  Query builder instance
     * @param  text                              $order       Order
     *
     * @return \Illuminate\Database\Query\Builder          Modified query builder
     */
    
    
    
}
