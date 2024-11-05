<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class PostFilter extends ApiFilter
{
    protected $allowedParms = [
        'userId' => ['eq'],
        'title' => ['eq'],
        'body' => ['eq'],
        'publishedAt' => ['eq', 'gt', 'lt']
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'publishedAt' => 'published_at'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
    ];
}
