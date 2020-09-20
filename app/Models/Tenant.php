<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tenancy\Identification\Contracts\Tenant as TenantContract;
use Tenancy\Identification\Concerns\AllowsTenantIdentification;
use Tenancy\Identification\Drivers\Queue\Contracts\IdentifiesByQueue;
use Tenancy\Identification\Drivers\Queue\Events\Processing;
use Tenancy\Tenant\Events as TenantEvent;

class Tenant extends Model implements TenantContract, IdentifiesByQueue
{
    use AllowsTenantIdentification;
    
    protected $dispatchesEvents = [
        'created' => TenantEvent\Created::class,
        'updated' => TenantEvent\Updated::class,
        'deleted' => TenantEvent\Deleted::class,
    ];

    public function tenantIdentificationByQueue(Processing $event): ?TenantContract
    {
        if($event->tenant_identifier != $this->getTenantIdentifier()){
            return null;
        }
        return $this->newQuery()->where($this->getTenantKeyName(), $event->tenant_key)->first();
    }
}