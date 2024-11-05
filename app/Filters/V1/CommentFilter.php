<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class CommentFilter extends ApiFilter
{
    protected $allowedParms = [
        'userId' => ['eq'],
        'postId' => ['eq'],
        'comment' => ['eq'],
        'publishedAt' => ['eq', 'gt', 'lt']
    ];

    protected $columnMap = [
        'userId' => 'user_id',
        'postId' => 'post_id',
        'publishedAt' => 'published_at'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
    ];
}
