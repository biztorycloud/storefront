<?php

namespace Biztory\Storefront\Enums;

enum DocumentType: string
{
    case Cash = '/cashsale';
    case Extra1 = 'extra_1';
    case Extra2 = 'extra_2';
    case Normal = 'normal';
}
